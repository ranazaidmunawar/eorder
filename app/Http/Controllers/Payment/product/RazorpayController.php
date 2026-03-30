<?php

namespace App\Http\Controllers\Payment\product;

use App\Models\User\BasicSetting;
use App\Models\User\BasicExtended;
use App\Models\User\PaymentGateway;
use App\Models\User\PostalCode;
use App\Models\User\ProductOrder;
use App\Models\User\ShippingCharge;
use App\Traits\UserCurrentLanguageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Razorpay\Api\Api;


class RazorpayController extends PaymentController
{
    private $key, $secret, $api;
    private $information;
    use UserCurrentLanguageTrait;

    public function __construct()
    {
        $user = getUser();
        $data = PaymentGateway::query()
            ->where('keyword', 'razorpay')
            ->where('user_id', $user->id)
            ->first();
        $this->information = $data->information;
        if (!is_null($data->information)) {
            $razorpayData = json_decode($data->information, true);

            $this->key = $razorpayData['key'];
            $this->secret = $razorpayData['secret'];

            $this->api = new Api($this->key, $this->secret);
        }
    }


    public function store(Request $request)
    {
        if (is_null($this->information)) {

            session()->flash('error', 'Credentials are not set yet');
            return redirect()->back();
        }
        
        $user = getUser();
        // Validation Starts
        $currentLang = $this->getUserCurrentLanguage($user);

        $be = BasicExtended::query()
            ->where('user_id', $user->id)
            ->where('language_id', $currentLang->id)
            ->first();

        if ($be->base_currency_text != "INR") {
            return redirect()->back()->with('error', __('Please Select INR Currency For This Payment.'));
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
        $currentLang = $this->getUserCurrentLanguage($user);
        $order = ProductOrder::query()
            ->where('user_id', $user->id)
            ->find($orderId);
        $bs = BasicSetting::query()
            ->where('user_id', $user->id)
            ->where('language_id', $currentLang->id)
            ->first();

        $orderInfo['title'] = $bs->website_title . " Order";
        $orderInfo['item_number'] = Str::random(4) . time();
        $orderInfo['item_amount'] = $order->total;
        $orderInfo['order_id'] = $orderId;
        if ($order->type == 'website') {
            $cancel_url = route('product.payment.cancel', getParam());
        } elseif ($order->type == 'qr') {
            $cancel_url = route('user.qr.payment.cancel', getParam());
        }
        $notify_url = route('product.razorpay.notify', getParam());


        $orderData = [
            'receipt'         => $orderInfo['title'],
            'amount'          => $orderInfo['item_amount'] * 100,
            'currency'        => 'INR',
            'payment_capture' => 1 // auto capture
        ];

        $razorpayOrder = $this->api->order->create($orderData);

        Session::put('order_data', $orderInfo);
        Session::put('order_payment_id', $razorpayOrder['id']);

        $displayAmount = $amount = $orderData['amount'];


        $checkout = 'automatic';

        if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true)) {
            $checkout = $_GET['checkout'];
        }

        $data = [
            "key"               => $this->key,
            "amount"            => $amount,
            "name"              => $orderInfo['title'],
            "description"       => $orderInfo['title'],
            "prefill"           => [
                "name"              => $order->billing_fname,
                "email"             => $order->billing_email,
                "contact"           => $order->billing_number,
            ],
            "notes"             => [
                "address"           => $order->billing_address,
                "merchant_order_id" => $orderInfo['item_number'],
            ],
            "theme"             => [
                "color"             => "{{$bs->base_color}}"
            ],
            "order_id"          => $razorpayOrder['id'],
        ];

        $json = json_encode($data);
        $displayCurrency = $order->currency_code;

        return view('user-front.razorpay', compact('data', 'displayCurrency', 'json', 'notify_url'));
    }


    public function notify(Request $request)
    {
        $user = getUser();
        $order_data = Session::get('order_data');
        $po = ProductOrder::query()->where('user_id', $user->id)->findOrFail($order_data["order_id"]);

        if ($po->type == 'website') {
            $success_url = route('product.payment.return', [getParam(), $po->order_number]);
        } elseif ($po->type == 'qr') {
            $success_url = route('user.qr.payment.return', [getParam(), $po->order_number]);
        }
        if ($po->type == 'website') {
            $cancel_url = route('product.payment.cancel', getParam());
        } elseif ($po->type == 'qr') {
            $cancel_url = route('user.qr.payment.cancel', getParam());
        }
        $input_data = $request->all();
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('order_payment_id');

        $success = true;

        if (empty($input_data['razorpay_payment_id']) === false) {

            try {
                $attributes = array(
                    'razorpay_order_id' => $payment_id,
                    'razorpay_payment_id' => $input_data['razorpay_payment_id'],
                    'razorpay_signature' => $input_data['razorpay_signature']
                );

                $this->api->utility->verifyPaymentSignature($attributes);
            } catch (SignatureVerificationError $e) {
                $success = false;
            }
        }

        if ($success === true) {
            $po->payment_status = "Completed";
            $po->save();
            $this->sendNotifications($po, $user->email, $user);
            Session::forget('order_data');
            Session::forget('order_payment_id');
            Session::forget('coupon');
            Session::forget($user->username . '_cart');

            return redirect($success_url);
        }
        return redirect($cancel_url);
    }
}
