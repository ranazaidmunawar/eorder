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

class MercadopagoController extends PaymentController
{
    use UserCurrentLanguageTrait;
    private $access_token;
    private $sandbox;
    private $information;

    public function __construct()
    {
        $user = getUser();
        $data = PaymentGateway::query()
            ->where('keyword', 'mercadopago')
            ->where('user_id', $user->id)
            ->first();
        $this->information = $data->information;
        if (!is_null($data->information)) {
            $mercadopagoData = json_decode($data->information, true);

            $this->access_token = $mercadopagoData['token'];
            $this->sandbox = $mercadopagoData['sandbox_check'];
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


        $available_currency = array('ARS', 'BOB', 'BRL', 'CLF', 'CLP', 'COP', 'CRC', 'CUC', 'CUP', 'DOP', 'EUR', 'GTQ', 'HNL', 'MXN', 'NIO', 'PAB', 'PEN', 'PYG', 'UYU', 'VEF', 'VES');
        if (!in_array($be->base_currency_text, $available_currency)) {
            return redirect()->back()->with('error', 'Invalid Currency For Mercado Pago.');
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
        if ($order->type == 'website') {
            $return_url = route('product.payment.return', [getParam(), $order->order_number]);
        } elseif ($order->type == 'qr') {
            $return_url = route('user.qr.payment.return', [getParam(), $order->order_number]);
        }
        $notify_url = route('product.mercadopago.notify', getParam());

        $item_name = $bs->website_title . " Order";
        $item_number = Str::random(4) . time();
        $item_amount = (float)$order->total;


        $curl = curl_init();


        $preferenceData = [
            'items' => [
                [
                    'id' => $item_number,
                    'title' => $item_name,
                    'description' => $item_name,
                    'quantity' => 1,
                    'currency_id' => $order->currency_code,
                    'unit_price' => $item_amount
                ]
            ],
            'payer' => [
                'email' => $order->billing_email,
            ],
            'back_urls' => [
                'success' => $return_url,
                'pending' => '',
                'failure' => $cancel_url,
            ],
            'notification_url' =>  $notify_url,
            'auto_return' =>  'approved',

        ];

        $httpHeader = [
            "Content-Type: application/json",
        ];
        $url = "https://api.mercadopago.com/checkout/preferences?access_token=" . $this->access_token;
        $opts = [
            CURLOPT_URL             => $url,
            CURLOPT_CUSTOMREQUEST   => "POST",
            CURLOPT_POSTFIELDS      => json_encode($preferenceData, true),
            CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_TIMEOUT         => 30,
            CURLOPT_HTTPHEADER      => $httpHeader
        ];

        curl_setopt_array($curl, $opts);

        $response = curl_exec($curl);
        $payment = json_decode($response, true);

        $err = curl_error($curl);

        curl_close($curl);

        $orderData['order_id'] = $orderId;

        Session::put('order_data', $orderData);

        if ($this->sandbox == 1) {
            return redirect($payment['sandbox_init_point']);
        } else {
            return redirect($payment['init_point']);
        }
    }


    public function curlCalls($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $paymentData = curl_exec($ch);
        curl_close($ch);
        return $paymentData;
    }

    public function notify(Request $request)
    {
        $user = getUser();
        $order_data = Session::get('order_data');
        $po = ProductOrder::query()
            ->where('user_id', $user->id)
            ->findOrFail($order_data["order_id"]);

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



        if ($request['status'] == 'approved') {
            $po->payment_status = "Completed";
            $po->save();

            $this->sendNotifications($po, $user->email, $user);

            Session::forget('order_data');
            Session::forget('coupon');
            Session::forget($user->username . '_cart');

            return redirect($success_url);
        }

        return redirect($cancel_url);
    }
}
