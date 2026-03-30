<?php

namespace App\Http\Controllers\Payment\product;

use App\Models\User\BasicSetting;
use App\Models\User\PaymentGateway;
use App\Models\User\PostalCode;
use App\Models\User\ProductOrder;
use App\Models\User\ShippingCharge;
use App\Traits\UserCurrentLanguageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use PDF;

class FlutterWaveController extends PaymentController
{
    use UserCurrentLanguageTrait;
    public $public_key;
    private $secret_key;
    private $information;

    public function __construct()
    {
        $user = getUser();
        $data = PaymentGateway::query()
            ->where('keyword', 'flutterwave')
            ->where('user_id', $user->id)
            ->first();
        $this->information = $data->information;
        if (!is_null($data->information)) {
            $flutterwaveData = json_decode($data->information, true);

            $this->public_key = $flutterwaveData['public_key'];
            $this->secret_key = $flutterwaveData['secret_key'];

            config([
                // in case you would like to overwrite values inside config/services.php
                'flutterwave.publicKey' => $this->public_key,
                'flutterwave.secretKey' => $this->secret_key,
                'flutterwave.secretHash' => '',
            ]);
        }
    }

    public function store(Request $request)
    {
        if (is_null($this->information)) {

            session()->flash('error', 'Credentials are not set yet');
            return redirect()->back();
        }
        
        $user = getUser();
        $available_currency = array('BIF', 'CAD', 'CDF', 'CVE', 'EUR', 'GBP', 'GHS', 'GMD', 'GNF', 'KES', 'LRD', 'MWK', 'NGN', 'RWF', 'SLL', 'STD', 'TZS', 'UGX', 'USD', 'XAF', 'XOF', 'ZMK', 'ZMW', 'ZWD');
        $currentLang = $this->getUserCurrentLanguage($user);
        $be = $currentLang->basic_extended;

        if (!in_array($be->base_currency_text, $available_currency)) {
            return redirect()->back()->with('error', __('Invalid Currency For Flutterwave.'));
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
        $bs = BasicSetting::first();

        $orderData['item_name'] = $bs->website_title . " Order";
        $orderData['item_number'] = Str::random(4) . time();
        $orderData['item_amount'] = $order->total;
        $orderData['order_id'] = $orderId;
        if ($order->type == 'website') {
            $cancel_url = route('product.payment.cancel', getParam());
        } elseif ($order->type == 'qr') {
            $cancel_url = route('user.qr.payment.cancel', getParam());
        }
        $notify_url = route('product.flutterwave.notify', getParam());

        Session::put('order_data', $orderData);
        Session::put('order_payment_id', $orderData['item_number']);

        // SET CURL

        $curl = curl_init();
        $customer_email = $order->billing_email;


        $amount = $order->total;
        $currency = $order->currency_code;
        $txref = $orderData['item_number']; // ensure you generate unique references per transaction.
        $PBFPubKey = $this->public_key; // get your public key from the dashboard.
        $redirect_url = $notify_url;
        $payment_plan = ""; // this is only required for recurring payments.


        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/hosted/pay",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'amount' => $amount,
                'customer_email' => $customer_email,
                'currency' => $currency,
                'txref' => $txref,
                'PBFPubKey' => $PBFPubKey,
                'redirect_url' => $redirect_url,
                'payment_plan' => $payment_plan
            ]),
            CURLOPT_HTTPHEADER => [
                "content-type: application/json",
                "cache-control: no-cache"
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            // there was an error contacting the rave API
            return redirect($cancel_url)->with('error', 'Curl returned error: ' . $err);
        }

        $transaction = json_decode($response);

        if (!$transaction->data && !$transaction->data->link) {
            // there was an error from the API
            return redirect($cancel_url)->with('error', 'API returned error: ' . $transaction->message);
        }

        return redirect($transaction->data->link);
    }


    public function notify(Request $request)
    {
        $user = getUser();
        $order_data = Session::get('order_data');
        $po = ProductOrder::query()->where('user_id', $user->id)->findOrFail($order_data["order_id"]);

        if ($po->type == 'website') {
            $cancel_url = route('product.payment.cancel', getParam());
        } elseif ($po->type == 'qr') {
            $cancel_url = route('user.qr.payment.cancel', getParam());
        }
        $input_data = $request->all();

        /** Get the payment ID before session clear **/
        $payment_id = Session::get('order_payment_id');

        if (isset($input_data['txref'])) {
            $ref = $payment_id;
            $query = array(
                "SECKEY" => $this->secret_key,
                "txref" => $ref
            );

            $data_string = json_encode($query);

            $ch = curl_init('https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

            $response = curl_exec($ch);

            curl_close($ch);

            $resp = json_decode($response, true);

            if ($resp['status'] == 'error') {
                return redirect($cancel_url);
            }

            if ($resp['status'] = "success") {
                $paymentStatus = $resp['data']['status'];
                $chargeResponsecode = $resp['data']['chargecode'];

                if (($chargeResponsecode == "00" || $chargeResponsecode == "0") && ($paymentStatus == "successful")) {
                    $po->payment_status = "Completed";
                    $po->save();

                    $this->sendNotifications($po, $user->email, $user);
                    Session::forget('order_payment_id');
                    Session::forget('order_data');
                    Session::forget('coupon');
                    Session::forget($user->username . '_cart');

                    if ($po->type == 'website') {
                        $success_url = route('product.payment.return', [getParam(), $po->order_number]);
                    } elseif ($po->type == 'qr') {
                        $success_url = route('user.qr.payment.return', [getParam(), $po->order_number]);
                    }
                    return redirect($success_url);
                }
            }
            return redirect($cancel_url);
        }
        return redirect($cancel_url);
    }
}
