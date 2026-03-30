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
use Omnipay\Omnipay;

class AuthorizenetController extends PaymentController
{
    use UserCurrentLanguageTrait;

    public $gateway;
    private $information;

    public function __construct()
    {
        
        $user = getUser();
        $data = PaymentGateway::query()
            ->where('keyword', 'authorize.net')
            ->where('user_id', $user->id)
            ->first();
        $this->information = $data->information;
        $anetData = json_decode($data->information, true);
        if (!is_null($data->information)) {
            $this->gateway = Omnipay::create('AuthorizeNetApi_Api');
            $this->gateway->setAuthName($anetData['login_id']);
            $this->gateway->setTransactionKey($anetData['transaction_key']);
            if ($anetData['sandbox_check'] == 1) {
                $this->gateway->setTestMode(true);
            }
        }else{
            session()->flash('error', 'Credentials are not set yet');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        if (is_null($this->information)) {

            session()->flash('error', 'Credentials are not set yet');
            return redirect()->back();
        }
        $user = getUser();
        $available_currency = array('BIF', 'CAD', 'CDF', 'CVE', 'EUR', 'GBP', 'GHS', 'GMD', 'GNF', 'KES', 'LRD', 'MWK', 'MZN', 'NGN', 'RWF', 'SLL', 'STD', 'TZS', 'UGX', 'USD', 'XAF', 'XOF', 'ZMK', 'ZMW', 'ZWD');
        $currentLang = $this->getUserCurrentLanguage($user);
        $be = $currentLang->basic_extended;
        if (!in_array($be->base_currency_text, $available_currency)) {
            return redirect()->back()->with('error', __('Invalid Currency For Authorize.net.'));
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
            if (
                !empty($shipping) && !empty($shipping->free_delivery_amount)
                && cartTotal() >= $shipping->free_delivery_amount
            ) {
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
        return $this->apiRequest($request, $order_id);
    }

    // send API request & redirect
    public function apiRequest($request, $orderId)
    {
        $user = getUser();
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
        if ($order->type == 'qr') {
            $success_url = route('user.qr.payment.return', [getParam(), $order->order_number]);
            $cancel_url = route('user.qr.payment.cancel', getParam());
        } else {
            $success_url = route('product.payment.return', [getParam(), $order->order_number]);
            $cancel_url = route('product.payment.cancel', getParam());
        }
        if ($request->input('opaqueDataDescriptor') && $request->input('opaqueDataValue')) {
            try {
                // Generate a unique merchant site transaction ID.
                $transactionId = rand(100000000, 999999999);
                $response = $this->gateway->authorize([
                    'amount' => $usdTotal,
                    'currency' => $be->base_currency_text,
                    'transactionId' => $transactionId,
                    'opaqueDataDescriptor' => $request->input('opaqueDataDescriptor'),
                    'opaqueDataValue' => $request->input('opaqueDataValue'),
                ])->send();

                if ($response->isSuccessful()) {
                    // Captured from the authorization response.
                    $transactionReference = $response->getTransactionReference();
                    $response = $this->gateway->capture([
                        'amount' => $usdTotal,
                        'currency' => $be->base_currency_text,
                        'transactionReference' => $transactionReference,
                    ])->send();
                    $order->payment_status = 'Completed';
                    $order->save();
                    $this->sendNotifications($order, $user->email, $user);
                    Session::forget($user->username.'_cart');
                    return redirect($success_url);
                } else {
                    // not successful
                    return redirect($cancel_url);
                }
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }
        }
    }
}
