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

class ToyyibpayController extends PaymentController
{
    use UserCurrentLanguageTrait;
    private $information;

    public function __construct()
    {
        $user = getUser();
        $data = PaymentGateway::query()
            ->where('keyword', 'toyyibpay')
            ->where('user_id', $user->id)
            ->first();
        $this->information = json_decode($data->information, true);
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


        $available_currency = array('RM');
        if (!in_array($be->base_currency_text, $available_currency)) {
            return redirect()->back()->with('error', 'Invalid Currency For Toyyibpay.');
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
        $notify_url = route('product.toyyibpay.notify', getParam());

        $item_amount = (float)$order->total;
        ####################################
        //payment gateway info start
        ####################################

        $ref = uniqid();
        session()->put('toyyibpay_ref_id', $ref);


        $some_data = array(
            'userSecretKey' => $this->information['secret_key'],
            'categoryCode' => $this->information['category_code'],
            'billName' => 'Order Item',
            'billDescription' => 'Pay via Toyyibpay',
            'billPriceSetting' => 1,
            'billPayorInfo' => 1,
            'billAmount' => $item_amount * 100,
            'billReturnUrl' => $notify_url,
            'billExternalReferenceNo' => $ref,
            'billTo' => $order->billing_fname . ' ' . $order->billing_lname,
            'billEmail' => $order->billing_email,
            'billPhone' => $order->billing_number,
        );

        if ($this->information['sandbox_status'] == 1) {
            $host = 'https://dev.toyyibpay.com/'; // for development environment
        } else {
            $host = 'https://toyyibpay.com/'; // for production environment
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_URL, $host . 'index.php/api/createBill');  // sandbox will be dev.
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);

        $result = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);
        $response = json_decode($result, true);

        // put order info into session
        Session::put('order_data', $order);
        if (!empty($response[0])) {
            return redirect($host . $response[0]["BillCode"]);
        } else {
            return redirect($cancel_url);
        }
    }



    public function notify(Request $request)
    {
        $user = getUser();
        $order_data = Session::get('order_data');
        $order = ProductOrder::query()
            ->where('user_id', $user->id)
            ->find($order_data['id']);
        if ($order?->type == 'website') {
            $cancel_url = route('product.payment.cancel', getParam());
        } elseif ($order?->type == 'qr') {
            $cancel_url = route('user.qr.payment.cancel', getParam());
        }

        $ref = session()->get('toyyibpay_ref_id');
        if ($request['status_id'] == 1 && $request['order_id'] == $ref) {
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
            Session::forget('paypal_payment_id');

            if ($order->type == 'website') {
                $success_url = route('product.payment.return', [getParam(), $order->order_number]);
            } elseif ($order->type == 'qr') {
                $success_url = route('user.qr.payment.return', [getParam(), $order->order_number]);
            }
            return redirect($success_url);
        }
        return redirect($cancel_url);
    }
}
