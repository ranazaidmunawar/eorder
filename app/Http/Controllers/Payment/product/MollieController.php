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
use Mollie\Api\MollieApiClient;

class MollieController extends PaymentController
{
    use UserCurrentLanguageTrait;

    protected $mollie, $key;
    private $information;

    public function __construct()
    {
        $user = getUser();
        $data = PaymentGateway::query()
            ->where('keyword', 'mollie')
            ->where('user_id', $user->id)
            ->first();
        $this->information = $data->information;
         if (!empty($data->information)) {
           
            $mollieData = json_decode($data->information, true);
            $this->key = $mollieData['key'];

            $this->mollie = new MollieApiClient();
            $this->mollie->setApiKey($this->key);
        }
    }
    public function store(Request $request)
    {
        if (empty($this->information)) {

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

        $available_currency = array('AED', 'AUD', 'BGN', 'BRL', 'CAD', 'CHF', 'CZK', 'DKK', 'EUR', 'GBP', 'HKD', 'HRK', 'HUF', 'ILS', 'ISK', 'JPY', 'MXN', 'MYR', 'NOK', 'NZD', 'PHP', 'PLN', 'RON', 'RUB', 'SEK', 'SGD', 'THB', 'TWD', 'USD', 'ZAR');


        if (!in_array($be->base_currency_text, $available_currency)) {
            return redirect()->back()->with('error', __('Invalid Currency For Mollie Payment.'));
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
            ->select('postal_code')
            ->first();
        $be = BasicExtended::query()
            ->where('user_id', $user->id)
            ->where('language_id', $currentLang->id)
            ->first();

        $orderData['item_name'] = $bs->website_title . " Order";
        $orderData['item_number'] = Str::random(4) . time();
        $orderData['item_amount'] = $order->total;
        $orderData['order_id'] = $orderId;
        $notify_url = route('product.mollie.notify', getParam());

        $payment = $this->mollie->payments->create([
            'amount' => [
                'currency' => $be->base_currency_text,
                'value' => '' . sprintf('%0.2f', $orderData['item_amount']) . '', // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            'description' => $orderData['item_name'],
            'redirectUrl' => $notify_url,
        ]);

        Session::put('order_data', $orderData);
        Session::put('order_payment_id', $payment->id);

        $payment = $this->mollie->payments->get($payment->id);

        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function notify(Request $request)
    {
        $user = getUser();
        $order_data = Session::get('order_data');
        $po = ProductOrder::query()
            ->where('user_id', $user->id)
            ->findOrFail($order_data["order_id"]);
        if ($po->type == 'website') {
            $cancel_url = route('product.payment.cancel', getParam());
        } elseif ($po->type == 'qr') {
            $cancel_url = route('user.qr.payment.cancel', getParam());
        }
        /** Get the payment ID before session clear **/

        $payment = $this->mollie->payments->get(Session::get('order_payment_id'));
        if ($payment->status == 'paid') {
            $po->payment_status = "Completed";
            $po->save();

            $this->sendNotifications($po, $user->email, $user);

            Session::forget('coupon');
            Session::forget($user->username . '_cart');
            Session::forget('order_data');
            Session::forget('order_payment_id');

            if ($po->type == 'website') {
                $success_url = route('product.payment.return', [getParam(), $po->order_number]);
            } elseif ($po->type == 'qr') {
                $success_url = route('user.qr.payment.return', [getParam(), $po->order_number]);
            }
            return redirect($success_url);
        }
        return redirect($cancel_url);
    }
}
