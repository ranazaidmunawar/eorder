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
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PPConnectionException;
use PayPal\Rest\ApiContext;


class PaypalController extends PaymentController
{
    use UserCurrentLanguageTrait;
    private $_api_context;
    private $information;

    public function __construct()
    {
        $user = getUser();
        $data = PaymentGateway::query()
            ->where('keyword', 'paypal')
            ->where('user_id', $user->id)
            ->first();
        $this->information = $data->information;    
        if (!is_null($data->information)) {
            
            $paypalData = json_decode($data->information, true);

            $paypal_conf = Config::get('paypal');
            $paypal_conf['client_id'] = $paypalData['client_id'];
            $paypal_conf['secret'] = $paypalData['client_secret'];
            $paypal_conf['settings']['mode'] = $paypalData['sandbox_check'] == 1 ? 'sandbox' : 'live';

            $this->_api_context = new ApiContext(
                new OAuthTokenCredential(
                    $paypal_conf['client_id'],
                    $paypal_conf['secret']
                )
            );
            $this->_api_context->setConfig($paypal_conf['settings']);
        }
    }

    public function store(Request $request)
    {
        if(is_null($this->information)){
            session()->flash('error', 'Credentials are not set yet');
            return redirect()->back();
        }
       
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
        $order = $this->saveOrder($request, $shipping, $total);
        $order_id = $order->id;

        // save ordered items
        $this->saveOrderItem($order_id);
        return $this->apiRequest($order_id);
    }


    // send API request & redirect
    public function apiRequest($orderId)
    {
        $user = getUser();
        $order = ProductOrder::query()
            ->where('user_id', $user->id)
            ->find($orderId);
        $currentLang = $this->getUserCurrentLanguage($user);

        $be = BasicExtended::query()
            ->where('user_id', $user->id)
            ->where('language_id', $currentLang->id)
            ->first();

        // convert the total in USD
        $total = round(($order->total / $be->base_currency_rate), 2);
        $title = 'Product Checkout';
        $notify_url = route('product.paypal.notify', getParam());
        if ($order->type == 'website') {
            $cancel_url = route('product.payment.cancel', getParam());
        } elseif ($order->type == 'qr') {
            $cancel_url = route('user.qr.payment.cancel', getParam());
        }

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName($title)
            /** item name **/
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice(round($total, 2));
        /** unit price **/
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal(round($total, 2));
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription($title . ' Via Paypal');
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl($notify_url)
            /** Specify return URL **/
            ->setCancelUrl($cancel_url);
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->_api_context);
        } catch (PPConnectionException $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session **/
        Session::put('order_data', $order);
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            /** redirect to PayPal **/
            return Redirect::away($redirect_url);
        }
        return redirect()->back()->with('error', 'Unknown error occurred');
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
        $input = $request->all();
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        if (empty($input['PayerID']) || empty($input['token'])) {
            return redirect($cancel_url);
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($input['PayerID']);
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {
            $resp = json_decode($payment, true);
            $txnId = $resp['transactions'][0]['related_resources'][0]['sale']['id'];
            $chargeId = $request->paymentId;
            $order->txnid = $txnId;
            $order->charge_id = $chargeId;
            $order->payment_status = 'Completed';
            $order->save();
            $this->sendNotifications($order, $user->email, $user);
            Session::forget('coupon');
            Session::forget($user->username . '_cart');
            Session::forget('order_data');
            Session::forget('paypal_payment_id');

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
