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

class PerfectMoneyController extends PaymentController
{
    use UserCurrentLanguageTrait;
    private $information;

    public function __construct()
    {
        $user = getUser();
        $data = PaymentGateway::query()
            ->where('keyword', 'perfect_money')
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


        $available_currency = array('USD');
        if (!in_array($be->base_currency_text, $available_currency)) {
            return redirect()->back()->with('error', 'Invalid Currency For Perfect Money.');
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
            ->select('postal_code', 'website_title')
            ->first();
        $currentLang = $this->getUserCurrentLanguage($user);
        $be = BasicExtended::query()
            ->where('user_id', $user->id)
            ->where('language_id', $currentLang->id)
            ->first();

        if ($order->type == 'website') {
            $cancel_url = route('product.payment.cancel', getParam());
        } elseif ($order->type == 'qr') {
            $cancel_url = route('user.qr.payment.cancel', getParam());
        }
        $notify_url = route('product.perfect_money.notify', getParam());

        $item_amount = (float)$order->total;//live amount
        // $item_amount = 0.01; //test amount

        Session::put('order_data', $order);
        $randomNo = substr(uniqid(), 0, 8);

        /*******************************************************
         ****************** Payment Gateway Info ******************
         ********************************************************/
        $val['PAYEE_ACCOUNT'] = $this->information['perfect_money_wallet_id'];;
        $val['PAYEE_NAME'] = $bs->website_title;
        $val['PAYMENT_ID'] = "$randomNo"; //random id
        $val['PAYMENT_AMOUNT'] = $item_amount;
        $val['PAYMENT_UNITS'] = "$be->base_currency_text";

        $val['STATUS_URL'] = $notify_url;
        $val['PAYMENT_URL'] = $notify_url;
        $val['PAYMENT_URL_METHOD'] = 'GET';
        $val['NOPAYMENT_URL'] = $cancel_url;
        $val['NOPAYMENT_URL_METHOD'] = 'GET';
        $val['SUGGESTED_MEMO'] = $order->billing_email;
        $val['BAGGAGE_FIELDS'] = 'IDENT';

        $data['val'] = $val;
        $data['method'] = 'post';
        $data['url'] = 'https://perfectmoney.com/api/step1.asp';

        Session::put('payment_id', $randomNo);
        Session::put('cancel_url', $cancel_url);
        Session::put('amount', $item_amount);
        return view('payments.perfect-money', compact('data'));
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

        $amo = $request['PAYMENT_AMOUNT'];
        $track = $request['PAYMENT_ID'];
        $id = Session::get('payment_id');
        $final_amount = Session::get('amount');

        if ($request->PAYEE_ACCOUNT == $this->information['perfect_money_wallet_id']  && $track == $id && $amo == round($final_amount, 2)) {
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
