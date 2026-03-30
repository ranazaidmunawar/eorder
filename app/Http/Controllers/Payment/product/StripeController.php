<?php

namespace App\Http\Controllers\Payment\product;

use App\Models\User\BasicSetting;
use App\Models\User\BasicExtended;
use App\Models\User\PaymentGateway;
use App\Models\User\PostalCode;
use App\Models\User\ProductOrder;
use App\Models\User\ShippingCharge;
use App\Traits\UserCurrentLanguageTrait;
use Cartalyst\Stripe\Exception\CardErrorException;
use Cartalyst\Stripe\Exception\MissingParameterException;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class StripeController extends PaymentController
{
    use UserCurrentLanguageTrait;
    private $stripe_token;
    private $information;
    private $customer_email;
    private $customer_name;
    
    public function __construct()
    {

        $user = getUser();
        //Set Stripe Keys
        $data = PaymentGateway::query()
            ->where('keyword', 'stripe')
            ->where('user_id', $user->id)
            ->first();
        $this->information =$data->information;
        if (!is_null($data->information)) {
            $stripeData = json_decode($data->information, true);

            $secret = $stripeData['secret'];
            $key = $stripeData['key'];
            config([
                // in case you would like to overwrite values inside config/services.php
                'services.stripe.secret' => $secret,
                'services.stripe.key' => $key,
            ]);
        }
    }


    public function store(Request $request)
    {

        if($request->serving_method == 'on_table' || $request->serving_method == 'pick_up'){
            $this->customer_email = $request->billing_email;
            $this->customer_name = $request->billing_fname;
        }
        elseif($request->serving_method == 'home_delivery' && $request->same_as_shipping == 1){
            $this->customer_email = $request->shipping_email;
            $this->customer_name = $request->shipping_fname;

        } elseif ($request->serving_method == 'home_delivery' && !$request->has('same_as_shipping')) {
            $this->customer_email = $request->billing_email;
            $this->customer_name = $request->billing_fname;
        }
       
        if (is_null($this->information)) {

            session()->flash('error', 'Credentials are not set yet');
            return redirect()->back();
        }

        $this->stripe_token = $request->stripeToken;
        $user = getUser();
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

        // save order
        $txnId = 'txn_' . Str::random(8) . time();
        $chargeId = 'ch_' . Str::random(9) . time();
        $order = $this->saveOrder($request, $shipping, $total, $txnId, $chargeId);
        $order_id = $order->id;

        // save ordered items
        $this->saveOrderItem($order_id);

        session()->put('request', $request->only('cardNumber', 'month', 'year', 'cardCVC'));

        return $this->apiRequest($order_id);
    }


    // send API request & redirect
    public function apiRequest($orderId)
    {
      
        $user = getUser();
        $request = session()->get('request');
        $currentLang = $this->getUserCurrentLanguage($user);
        $order = ProductOrder::query()
            ->where('user_id', $user->id)
            ->find($orderId);
        $be = BasicExtended::query()
            ->where('user_id', $user->id)
            ->where('language_id', $currentLang->id)
            ->first();
        $usdTotal = round(($order->total / $be->base_currency_rate), 2);
        $title = 'Product Checkout';
        if ($order->type == 'website') {
            $success_url = route('product.payment.return', [getParam(), $order->order_number]);
        } elseif ($order->type == 'qr') {
            $success_url = route('user.qr.payment.return', [getParam(), $order->order_number]);
        }
        $stripe = Stripe::make(Config::get('services.stripe.secret'));
        try {
           
            if (!isset($this->stripe_token)) {
                return back()->with('error', 'Token Problem With Your Token.');
            }

            $charge = $stripe->charges()->create([
                'receipt_email' => $this->customer_email,
                'card' => $this->stripe_token,
                'currency' =>  'USD',
                'amount' => $usdTotal,
                'description' => $title,
                'metadata' => [
                    'customer_name' => $this->customer_name,
                ]
            ]);


            if ($charge['status'] == 'succeeded') {
                $order->payment_status = 'Completed';
                $order->save();

                $this->sendNotifications($order, $user->email, $user);

                Session::forget('coupon');
                Session::forget($user->username . '_cart');
                Session::forget('request');

                return redirect($success_url);
            }
        } catch (\Exception | CardErrorException | MissingParameterException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
