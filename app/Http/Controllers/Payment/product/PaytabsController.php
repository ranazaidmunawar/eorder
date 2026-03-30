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

class PaytabsController extends PaymentController
{
    use UserCurrentLanguageTrait;
    private $information;

    public function __construct()
    {
        $user = getUser();
        $data = PaymentGateway::query()
            ->where('keyword', 'paytabs')
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

        $paytabInfo = paytabInfo('user', $user->id);
        if ($be->base_currency_text != $paytabInfo['currency']) {
            return redirect()->back()->with('error', 'Invalid Currency For Paytabs.');
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
        $notify_url = route('product.paytabs.notify', getParam());

        $item_amount = (float)$order->total;
        Session::put('order_data', $order);
        ###################################
        //payment gateway info start
        ###################################
        $paytabInfo = paytabInfo('user', $user->id);
        $description = 'order item via paytabs';
        try {
            $response = Http::withHeaders([
                'Authorization' => $paytabInfo['server_key'], // Server Key
                'Content-Type' => 'application/json',
            ])->post(
                $paytabInfo['url'],
                [
                    'profile_id' => $paytabInfo['profile_id'], // Profile ID
                    'tran_type' => 'sale',
                    'tran_class' => 'ecom',
                    'cart_id' => uniqid(),
                    'cart_description' => $description,
                    'cart_currency' => $paytabInfo['currency'], // set currency by region
                    'cart_amount' => round($item_amount, 2),
                    'return' => $notify_url,
                ]
            );

            $responseData = $response->json();
            return redirect()->to($responseData['redirect_url']);
        } catch (\Exception $e) {
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

        $resp = $request->all();
        if ($resp['respStatus'] == "A" && $resp['respMessage'] == 'Authorised') {
            $resp = json_encode($resp, true);
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
}
