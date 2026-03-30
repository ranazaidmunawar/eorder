<?php

namespace App\Http\Controllers\Payment\product;

use App\Models\User\BasicExtended;
use App\Models\User\BasicSetting;
use App\Models\User\PaymentGateway;
use App\Models\User\PostalCode;
use App\Models\User\ProductOrder;
use App\Models\User\ShippingCharge;
use App\Traits\UserCurrentLanguageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Basel\MyFatoorah\MyFatoorah;

class MyFatoorahController extends PaymentController
{
    use UserCurrentLanguageTrait;
    private $information;
    public $myfatoorah;

    public function __construct()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
        } else {
            $user = getUser();
        }
        $data = PaymentGateway::query()
            ->where('keyword', 'myfatoorah')
            ->where('user_id', $user->id)
            ->first();
        $this->information = json_decode($data->information, true);

        $paydata = json_decode($data->information, true);
        $currentLang = $this->getUserCurrentLanguage($user);

        $be = BasicExtended::query()
            ->where('user_id', $user->id)
            ->where('language_id', $currentLang->id)
            ->first();

        Config::set('myfatorah.token', $paydata['token']);
        Config::set('myfatorah.DisplayCurrencyIso', $be->base_currency_text);
        Config::set('myfatorah.CallBackUrl', route('myfatoorah.success'));
        Config::set('myfatorah.ErrorUrl', route('myfatoorah.cancel'));
        if ($paydata['sandbox_status'] == 1) {
            $this->myfatoorah = MyFatoorah::getInstance(true);
        } else {
            $this->myfatoorah = MyFatoorah::getInstance(false);
        }
    }

    public function store(Request $request)
    {
        if (is_null($this->information)) {
            session()->flash('error', 'Credentials are not set yet');
            return redirect()->back();
        }

        $user = getUser();
        $currentLang = $this->getUserCurrentLanguage($user);

        $be = BasicExtended::query()
            ->where('user_id', $user->id)
            ->where('language_id', $currentLang->id)
            ->first();


        $available_currency = array('KWD', 'SAR', 'BHD', 'AED', 'QAR', 'OMR', 'JOD');
        if (!in_array($be->base_currency_text, $available_currency)) {
            return redirect()->back()->with('error', 'Invalid Currency For MyFatoorah.');
        }

        if ($this->orderValidation($request)) {
            return $this->orderValidation($request);
        }

        $bs = BasicSetting::query()
            ->where('user_id', $user->id)
            ->select('postal_code')
            ->first();

        if ($request->serving_method == 'home_delivery') {
            if ($bs->postal_code == 0) {
                if ($request->has('shipping_charge')) {
                    $shipping = ShippingCharge::query()
                        ->where('user_id', $user->id)
                        ->findOrFail($request->shipping_charge);
                    $shipping_charge = $shipping->charge;
                } else {
                    $shipping = NULL;
                    $shipping_charge = 0;
                }
            } else {
                $shipping = PostalCode::query()
                    ->where('user_id', $user->id)
                    ->findOrFail($request->postal_code);
                $shipping_charge = $shipping->charge;
            }
            if (!empty($shipping) && !empty($shipping->free_delivery_amount) && cartTotal() >= $shipping->free_delivery_amount) {
                $shipping_charge = 0;
            }
        } else {
            $shipping = NULL;
            $shipping_charge = 0;
        }
        $total = $this->orderTotal($shipping_charge);


        // saving data in database
        $txnId = 'txn_' . Str::random(8) . time();
        $chargeId = 'ch_' . Str::random(9) . time();
        $order = $this->saveOrder($request, $shipping, $total, $txnId, $chargeId);
        $order_id = $order->id;

        // save ordered items
        $this->saveOrderItem($order_id);

        return $this->apiRequest($order_id);
    }


    public function apiRequest($orderId)
    {
        $user = getUser();
        $order = ProductOrder::query()
            ->where('user_id', $user->id)
            ->find($orderId);
        $bs = BasicSetting::query()
            ->where('user_id', $user->id)
            ->select('postal_code')
            ->first();
        if ($order->type == 'website') {
            $cancel_url = route('product.payment.cancel', getParam());
        } elseif ($order->type == 'qr') {
            $cancel_url = route('user.qr.payment.cancel', getParam());
        }

        $item_amount = (float)$order->total;

        #######################################
        //payment gateway info start
        ####################################### 
        $random_1 = rand(999, 9999);
        $random_2 = rand(9999, 99999);
        Session::put('order_data', $order);
        $result = $this->myfatoorah->sendPayment(
            $order->billing_fname,
            $item_amount,
            [
                'CustomerMobile' => $this->information['sandbox_status'] == 1 ? '56562123544' : $order->billing_number,
                'CustomerReference' => "$random_1",  //orderID
                'UserDefinedField' => "$random_2", //clientID
                "InvoiceItems" => [
                    [
                        "ItemName" => "Order Item",
                        "Quantity" => 1,
                        "UnitPrice" => $item_amount
                    ]
                ]
            ]
        );
        Session::put('cancel_url', $cancel_url);
        if ($result && $result['IsSuccess'] == true) {
            // put data into session for future use
            Session::put('myfatoorah_payment_type', 'product');
            Session::put('user', getUser());
            Session::put('get_param', getParam());
            //return to payment url
            return redirect($result['Data']['InvoiceURL']);
        } else {
            // if fail then return to cancel url
            return redirect($cancel_url);
        }
    }

    public function notify(Request $request)
    {
        $user = Session::get('user');
        $get_param = Session::get('get_param');
        $order_data = Session::get('order_data');
        $order = ProductOrder::query()
            ->where('user_id', $user->id)
            ->find($order_data['id']);
        if ($order?->type == 'website') {
            $cancel_url = route('product.payment.cancel', $get_param);
        } elseif ($order?->type == 'qr') {
            $cancel_url = route('user.qr.payment.cancel', $get_param);
        }

        if (!empty($request->paymentId)) {
            $result = $this->myfatoorah->getPaymentStatus('paymentId', $request->paymentId);
            if ($result && $result['IsSuccess'] == true && $result['Data']['InvoiceStatus'] == "Paid") {
                $resp = null;
                $txnId = uniqid();
                $chargeId = $request->paymentId;
                $order->txnid = $txnId;
                $order->charge_id = $chargeId;
                $order->payment_status = 'Completed';
                $order->save();
                $this->sendNotifications($order, $user->email, $user);
                Session::forget('coupon');
                Session::forget($user->username . '_cart');
                Session::forget('order_data');

                if ($order->type == 'website') {
                    $success_url = route('product.payment.return', [$get_param, $order->order_number]);
                } elseif ($order->type == 'qr') {
                    $success_url = route('user.qr.payment.return', [$get_param, $order->order_number]);
                }
                return $success_url;
            } else {
                return $cancel_url;
            }
        } else {
            return $cancel_url;
        }
    }
}
