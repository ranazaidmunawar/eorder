<?php

namespace App\Http\Controllers\Payment\product;

use App\Http\Helpers\Instamojo;
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

class InstamojoController extends PaymentController
{
    use UserCurrentLanguageTrait;

    public function store(Request $request)
    {
        $user = getUser();
        $currentLang = $this->getUserCurrentLanguage($user);
        $be = BasicExtended::query()
            ->where('user_id', $user->id)
            ->where('language_id', $currentLang->id)
            ->first();

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

        if ($be->base_currency_text != "INR") {
            return redirect()->back()->with('error', __('Please Select INR Currency For This Payment.'));
        } elseif ($total < 9) {
            return redirect()->back()->with('error', __('Amount cannot be less than INR 9.00'));
        }

        if ($this->orderValidation($request)) {
            return $this->orderValidation($request);
        }


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

        $orderData['item_name'] = $bs->website_title . " Order";
        $orderData['item_number'] = Str::random(4) . time();
        $orderData['item_amount'] = $order->total;
        $orderData['order_id'] = $orderId;

        if ($order->type == 'website') {
            $cancel_url = route('product.payment.cancel', getParam());
        } elseif ($order->type == 'qr') {
            $cancel_url = route('user.qr.payment.cancel', getParam());
        }
        $notify_url = route('product.instamojo.notify', getParam());


        $user = getUser();
        $data = PaymentGateway::query()
            ->where('keyword', 'instamojo')
            ->where('user_id', $user->id)
            ->first();
        if (!is_null($data->information)) {
            $instamojoData = json_decode($data->information, true);
            if ($instamojoData['sandbox_check'] == 1) {
                $api = new Instamojo($instamojoData['key'], $instamojoData['token'], 'https://test.instamojo.com/api/1.1/');
            } else {
                $api = new Instamojo($instamojoData['key'], $instamojoData['token']);
            }
        } else {
            session()->flash('error', 'Credentials are not set yet');
            return back();
        }

        try {
            $response = $api->paymentRequestCreate(array(
                "purpose" => $orderData['item_name'],
                "amount" => $orderData['item_amount'],
                "send_email" => false,
                "email" =>  null,
                "redirect_url" => $notify_url
            ));
            $redirect_url = $response['longurl'];

            Session::put('order_payment_id', $response['id']);
            Session::put('order_data', $orderData);

            return redirect($redirect_url);
        } catch (\Exception $e) {
            return redirect($cancel_url)->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function notify(Request $request)
    {
        $user = getUser();
        $order_data = Session::get('order_data');
        $orderid = $order_data["order_id"];
        $po = ProductOrder::query()->where('user_id', $user->id)->findOrFail($orderid);

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

        if ($input_data['payment_request_id'] == $payment_id) {
            $po->payment_status = "Completed";
            $po->save();

            $this->sendNotifications($po, $user->email, $user);

            Session::forget('order_payment_id');
            Session::forget('order_data');
            Session::forget('coupon');
            Session::forget($user->username . '_cart');

            return redirect($success_url);
        }
        return redirect($cancel_url);
    }
}
