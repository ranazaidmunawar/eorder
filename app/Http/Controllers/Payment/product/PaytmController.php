<?php

namespace App\Http\Controllers\Payment\product;

use Anand\LaravelPaytmWallet\Facades\PaytmWallet;
use App\Models\User\BasicExtended;
use App\Models\User\BasicSetting;
use App\Models\User\PaymentGateway;
use App\Models\User\PostalCode;
use App\Models\User\ProductOrder;
use App\Models\User\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PaytmController extends PaymentController
{
    private $information;
    public function __construct()
    {
        $user = getUser();
        $data = PaymentGateway::query()
            ->where('keyword', 'paytm')
            ->where('user_id', $user->id)
            ->first();
        $this->information = $data->information;
        if (!is_null($data->information)) {

            $paytmData = json_decode($data->information, true);

            Config::set('services.paytm-wallet.env', $paytmData['environment']);
            Config::set('services.paytm-wallet.merchant_id', $paytmData['merchant']);
            Config::set('services.paytm-wallet.merchant_key', $paytmData['secret']);
            Config::set('services.paytm-wallet.merchant_website', $paytmData['website']);
            Config::set('services.paytm-wallet.industry_type', $paytmData['industry']);
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

        if ($be->base_currency_text != "INR") {
            return redirect()->back()->with('error', 'Please Select INR Currency For Paytm.');
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

        $notifyURL = route('product.paypal.notify', getParam());

        $payment = PaytmWallet::with('receive');

        $payment->prepare([
            'order' => time(),
            'user' => uniqid(),
            'mobile_number' => $request->billing_number ?? $user->phone,
            'email' => $request->billing_email  ?? $user->email,
            'amount' => $total,
            'callback_url' => $notifyURL
        ]);

        Session::put('order_id', $order_id);
        return $payment->receive();
    }

    public function notify(Request $request)
    {
        $user = getUser();
        $orderId = Session::get('order_id');
        $po = ProductOrder::query()
            ->where('user_id', $user->id)
            ->findOrFail($orderId);

        if ($po->type == 'qr') {
            $success_url = route('user.qr.payment.return', [getParam(), $po->order_number]);
            $cancel_url = route('user.qr.payment.cancel', getParam());
        } else {
            $success_url = route('product.payment.return', [getParam(), $po->order_number]);
            $cancel_url = route('product.payment.cancel', getParam());
        }
        $transaction = PaytmWallet::with('receive');
        // this response is needed to check the transaction status
        $response = $transaction->response();

        if ($transaction->isSuccessful()) {
            $po->payment_status = "Completed";
            $po->save();
            $this->sendNotifications($po, $user->email, $user);
            Session::forget('order_id');
            Session::forget($user->username . '_cart');
            session()->flash('success', 'Payment completed!');
            return redirect($success_url);
        } else {
            $po->delete();
            Session::forget('order_id');
            session()->flash('error', 'Something is wrong!');
            return redirect($cancel_url);
        }
    }
}
