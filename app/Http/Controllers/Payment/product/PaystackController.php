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


class PaystackController extends PaymentController
{
    use UserCurrentLanguageTrait;

    public $secret_key;
    private $information;

    public function __construct()
    {
        $user = getUser();
        $data = PaymentGateway::query()
            ->where('keyword', 'paystack')
            ->where('user_id', $user->id)
            ->first();
        $this->information = $data->information;
        if (!is_null($data->information)) {
            $paystackData = json_decode($data->information, true);
            $this->secret_key = $paystackData['key'];
        }
    }

    /**
     * Redirect the User to Paystack Payment Page
     * @return
     */
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
        if ($be->base_currency_text != "NGN") {
            return back()->with('error', 'Currency must be NGN for Paystack');
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

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'amount' => $order->total * 100,
                'email' => $order->billing_email,
                'callback_url' => route('product.paystack.notify', getParam())
            ]),
            CURLOPT_HTTPHEADER => [
                "authorization: Bearer " . $this->secret_key, //replace this with your own test key
                "content-type: application/json",
                "cache-control: no-cache"
            ],
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);
        if ($err) {
            return back()->with('error', $err);
        }

        $tranx = json_decode($response, true);

        if ($tranx['status'] == true) {
            return redirect($tranx['data']['authorization_url']);
        } else {
           
            return back()->with('error', $tranx['message']);
        }
    }


    public function notify(Request $request)
    {
        $user = getUser();
        $po = ProductOrder::query()
            ->where('user_id', $user->id)
            ->findOrFail($request["order_id"]);

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

        if ($request['trxref'] === $request['reference']) {
            $po->payment_status = "Completed";
            $po->save();

            $this->sendNotifications($po, $user->email, $user);

            Session::forget('coupon');
            Session::forget($user->username . '_cart');

            return redirect($success_url);
        } else {
            return redirect($cancel_url);
        }
    }
}
