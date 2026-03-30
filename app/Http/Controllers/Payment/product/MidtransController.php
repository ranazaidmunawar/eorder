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
use Midtrans\Snap;
use Midtrans\Config as MidtransConfig;

class MidtransController extends PaymentController
{
    use UserCurrentLanguageTrait;
    private $information;

    public function __construct()
    {

        if (Session::has('user') && Session::get('bank_notify') == 'yes') {
            $user = Session::get('user');
        } else {
            $user = getUser();
        }
        $data = PaymentGateway::query()
            ->where('keyword', 'midtrans')
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


        $available_currency = array('IDR');
        if (!in_array($be->base_currency_text, $available_currency)) {
            return redirect()->back()->with('error', 'Invalid Currency For Midtrans.');
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
        $notify_url = route('product.midtrans.notify', getParam());

        $item_amount = (float)$order->total;

        MidtransConfig::$serverKey = $this->information['server_key'];
        MidtransConfig::$isProduction = $this->information['is_production'] == 0 ? true : false;
        MidtransConfig::$isSanitized = true;
        MidtransConfig::$is3ds = true;
        $token = uniqid();
        Session::put('token', $token);
        $params = [
            'transaction_details' => [
                'order_id' => $token,
                'gross_amount' => $item_amount * 1000, // will be multiplied by 1000
            ],
            'customer_details' => [
                'first_name' => $order->billing_fname,
                'email' => $order->billing_email,
                'phone' => $order->billing_number,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        // put some data in session before redirect to midtrans url
        if ($this->information['is_production'] == 1) {
            $is_production = $this->information['is_production'];
        }
        $data['snapToken'] = $snapToken;
        $data['is_production'] = $is_production;
        $data['success_url'] = $notify_url;
        $data['_cancel_url'] = $cancel_url;
        $data['client_key'] = $this->information['server_key'];
        Session::put('order_data', $order);
        Session::put('amount', $item_amount);
        Session::put('midtrans_payment_type', 'product');
        Session::put('user', getUser());
        Session::put('get_param', getParam());
        return view('payments.product-midtrans', $data);
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

        $token = Session::get('token');
        if ($request->status_code == 200 && $token == $request->order_id) {
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
                $success_url = route('product.payment.return', [getParam(), $order->order_number]);
            } elseif ($order->type == 'qr') {
                $success_url = route('user.qr.payment.return', [getParam(), $order->order_number]);
            }
            return redirect($success_url);
        }
        return redirect($cancel_url);
    }

    public function bankNotify(Request $request)
    {
        $user = Session::get('user');
        $order_data = Session::get('order_data');
        $get_param = Session::get('get_param');
        $order = ProductOrder::query()
            ->where('user_id', $user->id)
            ->find($order_data['id']);
        if ($order?->type == 'website') {
            $cancel_url = route('product.payment.cancel', $get_param);
        } elseif ($order?->type == 'qr') {
            $cancel_url = route('user.qr.payment.cancel', $get_param);
        }

        $token = Session::get('token');
        if ($request->status_code == 200 && $token == $request->order_id) {
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
            $user = Session::get('user');
            $get_param = Session::get('get_param');

            if ($order->type == 'website') {
                $success_url = route('product.payment.return', [$get_param, $order->order_number]);
            } elseif ($order->type == 'qr') {
                $success_url = route('user.qr.payment.return', [$get_param, $order->order_number]);
            }
            return $success_url;
        }
        return $cancel_url;
    }
}
