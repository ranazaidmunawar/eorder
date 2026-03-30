<?php

namespace App\Http\Controllers\Payment\product;

use App\Models\User\BasicSetting;
use App\Models\User\PostalCode;
use App\Models\User\ProductOrder;
use App\Models\User\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


class OfflineController extends PaymentController
{

    public function store(Request $request,$domain,$gatewayid)
    {
        $user = getUser();
        if($this->orderValidation($request)) {
            return $this->orderValidation($request);
        }

        $bs = BasicSetting::query()
            ->where('user_id',$user->id)
            ->select('postal_code')
            ->first();

        if ($request->serving_method == 'home_delivery') {
            if ($bs->postal_code == 0) {
                if ($request->has('shipping_charge')) {
                    $shipping = ShippingCharge::query()
                        ->where('user_id',$user->id)
                        ->findOrFail($request->shipping_charge);
                    $shipping_charge = $shipping->charge;
                } else {
                    $shipping = NULL;
                    $shipping_charge = 0;
                }
            } else {
                $shipping = PostalCode::query()
                    ->where('user_id',$user->id)
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
        $order = $this->saveOrder($request, $shipping, $total, $txnId, $chargeId, 'offline');
        $order_id = $order->id;


        // save ordered items
        $this->saveOrderItem($order_id);

        $norder = ProductOrder::find($order->id);

        $this->sendNotifications($norder,$user->email,$user);

        Session::forget('coupon');
        Session::forget($user->username . '_cart');

        if ($order->type == 'website') {
            $success_url = route('product.payment.return', [getParam(),$order->order_number]);
        } elseif ($order->type == 'qr') {
            $success_url = route('user.qr.payment.return', [getParam(),$order->order_number]);
        }
        return redirect($success_url);

    }
}
