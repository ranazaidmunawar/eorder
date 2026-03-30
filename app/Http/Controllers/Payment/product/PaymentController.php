<?php

namespace App\Http\Controllers\Payment\product;

use App\Constants\Constant;
use App\Events\OrderPlaced;
use App\Http\Controllers\Controller;
use App\Http\Helpers\LimitCheckerHelper;
use App\Http\Helpers\MegaMailer;
use App\Http\Helpers\Uploader;
use App\Http\Helpers\UserPermissionHelper;
use App\Models\User\BasicExtended;
use App\Models\User\BasicExtra;
use App\Models\User\BasicSetting;
use App\Models\User\Customer;
use App\Models\User\Language;
use App\Models\User\OfflineGateway;
use App\Models\User\OrderItem;
use App\Models\User\OrderTime;
use App\Models\User\PaymentGateway;
use App\Models\User\ProductOrder;
use App\Models\User\TimeFrame;
use App\Notifications\WhatsappNotification;
use App\Traits\UserCurrentLanguageTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Cartalyst\Stripe\Api\Orders;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PaymentController extends Controller
{

    use UserCurrentLanguageTrait;

    public function payCancel()
    {
        return redirect()->route('user.product.front.checkout', getParam())->with('error', 'Payment Cancelled.');
    }

    public function qrPayCancel()
    {
        return redirect()->route('user.front.qrmenu.checkout', getParam())->with('error', 'Payment Cancelled.');
    }

    public function payReturn($domain, $orderNum)
    {
        $user = getUser();
        $data['orderNum'] = $orderNum;
        $order = ProductOrder::query()
            ->where('user_id', $user->id)
            ->where('order_number', $orderNum)
            ->first();

        $data['order'] = $order;
        return view('user-front.product.success', $data);
    }

    public function qrPayReturn($orderNum)
    {
        $user = getUser();
        $defaultLang = Language::query()
            ->where('user_id', $user->id)
            ->where('is_default', 1)
            ->first();
        $data['defaultLang'] = $defaultLang;
        $itemsCount = 0;
        $cartTotal = 0;
        $cart = session()->get($user->username . '_cart');
        if (!empty($cart)) {
            foreach ($cart as $p) {
                $itemsCount += $p['qty'];
                $cartTotal += (float)$p['total'];
            }
        }

        $data['cart'] = $cart;
        $data['itemsCount'] = $itemsCount;
        $data['cartTotal'] = $cartTotal;
        $data['orderNum'] = $orderNum;
        $data['order'] = ProductOrder::query()
            ->where('user_id', $user->id)
            ->where('order_number', $orderNum)
            ->first();

        Session::forget('table');

        return view('user-front.qrmenu.success', $data);
    }

    public function orderTotal($scharge)
    {
        $user = getUser();
        $dataTax = tax();
        $dataTax = json_decode($dataTax, true);
        $cart = Session::get($user->username . '_cart');
        $total = 0.00;

        foreach ($cart as $cartItem) {
            $total += $cartItem["total"];
        }

        $discount = session()->has('coupon') && !empty(session()->get('coupon')) ? session()->get('coupon') : 0;
        $total = ($total + $scharge + $dataTax['tax']) - $discount;
        $total = round($total, 2);

        return $total;
    }

    public function orderValidation($request)
    {
        $user = getUser();

        $count = LimitCheckerHelper::orderCount($user->id);
        $package = LimitCheckerHelper::currentMembershipPackage($user->id);

        if (is_null($package) || $count >= $package->order_limit) {

            return back()->with('error', "we are currently unable to receive any order")->withInput($request->all());
        }
        $be = BasicExtended::query()
            ->where('user_id', $user->id)
            ->first();
        $bs = BasicSetting::query()
            ->where('user_id', $user->id)
            ->first();

        if ($be->order_close == 1) {
            return back()->with('error', $be->order_close_message);
        }

        if (!Session::has($user->username . '_cart')) {
            return back()->with('error', 'No item added to cart!')->withInput($request->all());
        }

        $timezone = $be->timezone ?? config('app.timezone');
        $now = Carbon::now($timezone);
        $todaysDay = strtolower($now->format('l'));
        $currentTime = $now->timestamp; // Use timestamp directly

        // Set  time zone 
        // $timezone = $be->timezone;
        $now->setTimezone($timezone);

        // search in the database by today's day & retrieve start & end time
        $orderTime = OrderTime::query()
            ->where('user_id', $user->id)
            ->where('day', $todaysDay)
            ->first();
            
        if (!$orderTime || empty($orderTime->start_time) || empty($orderTime->end_time)) {
            return back()->with('error', "We are closed on " . $todaysDay)->withInput($request->all());
        }

        $start = Carbon::parse($orderTime->start_time, $timezone)->timestamp;
        $end = Carbon::parse($orderTime->end_time, $timezone)->timestamp;

        // check if current time is not between retrieved start & end time,
        // then show the message 'shop is closed now'
        if ($currentTime < $start || $currentTime > $end) {
            return back()
                ->with('error', "We take orders from " . $orderTime->start_time . " to " . $orderTime->end_time . " on " . $todaysDay)
                ->withInput($request->all());
        }

        $messages = [
            'billing_fname.required' => 'The billing first name field is required',
            'billing_lname.required' => 'The billing last name field is required',
            'shipping_fname.required' => 'The shipping first name field is required',
            'shipping_lname.required' => 'The shipping last name field is required',
            'shipping_address.required' => 'The shipping address field is required',
            'shipping_city.required' => 'The shipping city field is required',
            'shipping_country.required' => 'The shipping country field is required',
            'shipping_country_code.required' => 'The shipping country code field is required',
            'shipping_number.required' => 'The shipping phone number field is required',
            'shipping_email.required' => 'The shipping email field is required',
        ];

        $rules = [
            'gateway' => 'required',
            'serving_method' => 'required|sometimes',
            'shipping_fname' => 'required|sometimes',
            'shipping_lname' => 'required|sometimes',
            'shipping_address' => 'required|sometimes',
            'shipping_city' => 'required|sometimes',
            'shipping_country' => 'required|sometimes',
            'shipping_country_code' => 'required|sometimes',
            'shipping_number' => 'required|sometimes',
            'shipping_email' => 'required|sometimes',
            'pick_up_date' => 'required|sometimes',
            'pick_up_time' => 'required|sometimes',
            'table_number' => 'required|sometimes',
            'shipping_charge' => 'required|sometimes',
            'cardNumber' => 'required|sometimes',
            'cardCVC' => 'required|sometimes',
            'month' => 'required|sometimes',
            'year' => 'required|sometimes',
            'address' => $request->gateway == 'iyzico' ? 'required' : '',
            'city' => $request->gateway == 'iyzico' ? 'required' : '',
            'country' => $request->gateway == 'iyzico' ? 'required' : '',
            'zip_code' => $request->gateway == 'iyzico' ? 'required' : '',
            'identity_number' => $request->gateway == 'iyzico' ? 'required' : '',
        ];

        if (!$request->has('same_as_shipping') || $request->same_as_shipping != 1) {
            $rules['billing_fname'] = 'required';
            $rules['billing_lname'] = 'required|sometimes';
            $rules['billing_address'] = 'required|sometimes';
            $rules['billing_city'] = 'required|sometimes';
            $rules['billing_country'] = 'required|sometimes';
            $rules['billing_number'] = 'required|sometimes';
            $rules['billing_email'] = 'required';
            $rules['billing_country_code'] = 'required';
        }


        if ($request->serving_method == 'home_delivery' && $bs->postal_code == 1) {
            $rules['postal_code'] = 'required';
        }

        // return $request;
        // delivery date & time validation
        if ($request->serving_method == 'home_delivery' && $be->delivery_date_time_status == 1) {
            $rules['delivery_date'] = [
                function ($attribute, $value, $fail) use ($request, $be) {
                    if ($be->delivery_date_time_required == 1) {
                        if (!$request->has('delivery_date') || !$request->filled('delivery_date')) {
                            $fail("The delivery date field is required.");
                        }
                    }
                }
            ];

            $dtRequired = 0;
            if ($be->delivery_date_time_required == 1) {
                if (!$request->has('delivery_time') || !$request->filled('delivery_time')) {
                    $rules['delivery_time'] = 'required';
                    $dtRequired = 1;
                }
            }
            if ($dtRequired == 0) {
                $rules['delivery_time'] = [
                    function ($attribute, $value, $fail) use ($request, $user) {
                        if ($request->has('delivery_time') && $request->filled('delivery_time')) {
                            $tf = TimeFrame::query()->where('user_id', $user->id)->find($request->delivery_time);
                            // if maximum orders limit is not unlimited
                            if (!empty($tf) && $tf->max_orders != 0) {
                                $orderCount = ProductOrder::query()
                                    ->where('user_id', $user->id)
                                    ->where('order_status', '<>', 'cancelled')
                                    ->where('delivery_time_start', $tf->start)
                                    ->where('delivery_time_end', $tf->end)
                                    ->count();
                                if ($orderCount >= $tf->max_orders) {
                                    $fail("Number of orders in this time frame has reached to its limit");
                                }
                            }
                        }
                    }
                ];
            }
        }


        $onCount = PaymentGateway::query()->where('user_id', $user->id)->where('keyword', $request->gateway)->count();
        // if this is an offline gateway
        if ($onCount == 0) {
            $isReceipt = OfflineGateway::query()->where('user_id', $user->id)->findOrFail($request->gateway)->is_receipt;
            // if the receipt is required
            if ($isReceipt == 1) {
                $rules['receipt'] = [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        $ext = $request->file('receipt')->getClientOriginalExtension();
                        if (!in_array($ext, array('jpg', 'png', 'jpeg'))) {
                            return $fail("Only png, jpg, jpeg image is allowed");
                        }
                    },
                ];
            }
        }

        $request->validate($rules, $messages);
    }

    public function saveOrder($request, $shipping, $total, $txnId = NULL, $chargeId = NULL, $gtype = 'online')
    {

        $dataTax = tax();
        $dataTax = json_decode($dataTax, true);
        $user = getUser();
        $currentLang = $this->getUserCurrentLanguage($user);
        $be = BasicExtended::query()
            ->where('user_id', $user->id)
            ->where('language_id', $currentLang->id)
            ->first();
        $bs = BasicSetting::query()
            ->where('user_id', $user->id)
            ->where('language_id', $currentLang->id)
            ->first();

        $order = new ProductOrder;

        if (
            $request['serving_method'] == 'home_delivery' &&
            $request->has('same_as_shipping') &&
            $request['same_as_shipping'] == 1
        ) {
            $order->billing_fname = $request['shipping_fname'];
            $order->billing_lname = $request['shipping_lname'];
            $order->billing_email = $request['shipping_email'];
            $order->billing_address = $request['shipping_address'];
            $order->billing_city = $request['shipping_city'];
            $order->billing_country = $request['shipping_country'];
            $order->billing_number = $request['shipping_number'];
            $order->billing_country_code = $request['shipping_country_code'];
        } else {
            $order->billing_fname = $request['billing_fname'];
            $order->billing_email = $request['billing_email'];
            $order->billing_number = $request['billing_number'];
            $order->billing_country_code = $request['billing_country_code'];

            // if the 'serving method' is 'home delivery', but 'same as shipping address' is not selected
            if ($request['serving_method'] == 'home_delivery') {
                $order->billing_lname = $request['billing_lname'];
                $order->billing_address = $request['billing_address'];
                $order->billing_city = $request['billing_city'];
                $order->billing_country = $request['billing_country'];
            }
        }

        if ($request['serving_method'] == 'home_delivery') {
            $order->shipping_fname = $request['shipping_fname'];
            $order->shipping_lname = $request['shipping_lname'];
            $order->shipping_email = $request['shipping_email'];
            $order->shipping_address = $request['shipping_address'];
            $order->shipping_city = $request['shipping_city'];
            $order->shipping_country = $request['shipping_country'];
            $order->shipping_number = $request['shipping_number'];
            $order->shipping_country_code = $request['shipping_country_code'];
            $order->delivery_date = $request['delivery_date'];
            if ($be->delivery_date_time_status == 1) {
                if ($request->has('delivery_time') && $request->filled('delivery_time')) {
                    $tf = TimeFrame::query()
                        ->where('user_id', $user->id)
                        ->find((int)$request->delivery_time);
                    $order->delivery_time_start = $tf->start;
                    $order->delivery_time_end = $tf->end;
                }
            }
            if ($bs->postal_code == 0 && $request->has('shipping_charge')) {
                $order->shipping_method = $shipping->title;
                if (!empty($shipping->free_delivery_amount) && cartTotal() >= $shipping->free_delivery_amount) {
                    $order->shipping_charge = 0;
                } else {
                    $order->shipping_charge = $shipping->charge;
                }
            } elseif ($bs->postal_code == 1) {
                if (!empty($shipping->free_delivery_amount) && cartTotal() >= $shipping->free_delivery_amount) {
                    $order->shipping_charge = 0;
                } else {
                    $order->shipping_charge = $shipping->charge;
                }

                $title = '';
                if (!empty($shipping->title)) {
                    $title = $shipping->title . ' - ';
                }
                $order->postal_code = $title . $shipping->postcode;
                $order->postal_code_status = 1;
            }
        }
        if ($request['serving_method'] == 'pick_up') {
            $order->pick_up_date = $request['pick_up_date'];
            $order->pick_up_time = $request['pick_up_time'];
        }
        if ($request['serving_method'] == 'on_table') {
            $order->token_no = $bs->token_no + 1;
            $bs->token_no = $order->token_no;
            $bs->save();
            $order->table_number = $request['table_number'];
            $order->waiter_name = $request['waiter_name'];
        }
        $order->order_notes = $request['order_notes'];
        $order->serving_method = $request['serving_method'];
        if ($request->ordered_from == 'website') {
            $order->type = 'website';
        } elseif ($request->ordered_from == 'qr') {
            $order->type = 'qr';
        }

        $order->total = round($total, 2);
        if ($gtype == 'offline') {
            $gt = OfflineGateway::query()
                ->where('user_id', $user->id)
                ->findOrFail($request['gateway']);
            $gname = $gt->name;
        } else {
            $gname = $request['gateway'];
        }
        $order->method = $gname;
        $order->gateway_type = $gtype;
        $order->currency_code = $be->base_currency_text;
        $order->currency_code_position = $be->base_currency_text_position;
        $order->currency_symbol = $be->base_currency_symbol;
        $order->currency_symbol_position = $be->base_currency_symbol_position;
        $order->tax = $dataTax['tax'];
        $discount = session()->has('coupon') && !empty(session()->get('coupon')) ? session()->get('coupon') : 0.00;
        $order->coupon = $discount;

        $order['order_number'] = Str::random(4) . '-' . time();
        $order['payment_status'] = "Pending";
        $order['txnid'] = $txnId;
        $order['charge_id'] = $chargeId;
        $order['user_id'] = $user->id;
        $order['customer_id'] = Auth::guard('client')->check() ? Auth::guard('client')->user()->id : NULL;

        if ($request->hasFile('receipt')) {
            $receipt = uniqid() . '.' . $request->file('receipt')->getClientOriginalExtension();
            $receipt = Uploader::upload_picture(Constant::WEBSITE_PRODUCT_RECEIPT, $request->file('receipt'), $user->id);
            $order['receipt'] = $receipt;
        }
        $membership = LimitCheckerHelper::currentMembership($user->id);
        $order['membership_id'] = $membership->id;
        $order->save();

        // store customer in `customers` table
        $cust = Customer::query()
            ->where('user_id', $user->id)
            ->where('phone', $request->billing_number);
        if ($cust->count() == 0) {
            $customer = new Customer;
        } else {
            $customer = $cust->first();
        }
        $customer->name = $request->billing_fname;
        $customer->email = $request->billing_email;
        $customer->phone = $request->billing_number;
        if ($request['serving_method'] == 'home_delivery') {
            $customer->address = $request->billing_address;
        }
        $customer->user_id = $user->id;
        $customer->save();

        return $order;
    }

    public function saveOrderItem($orderId)
    {
        $user = getUser();

        $cart = Session::get($user->username . '_cart');

        foreach ($cart as $cartItem) {
            $addonTotal = 0.00;
            if (!empty($cartItem["addons"])) {
                foreach ($cartItem["addons"] as $addon) {
                    $addonTotal += (float)$addon["price"];
                }
                $addonTotal = $addonTotal * (int)$cartItem["qty"];
            }
            $varTotal = 0.00;
            if (!empty($cartItem["variations"])) {
                foreach ($cartItem["variations"] as $variation) {
                    $varTotal += (float)$variation["price"];
                }
                $varTotal = $varTotal * (int)$cartItem["qty"];
            }
            $pprice = (float)$cartItem["product_price"] * (int)$cartItem["qty"];

            OrderItem::insert([
                'product_order_id' => $orderId,
                'product_id' => $cartItem["id"],
                'user_id' => $user->id,
                'customer_id' => Auth::guard('client')->check() ? Auth::guard('client')->user()->id : NULL,
                'title' => $cartItem["name"],
                'variations' => json_encode($cartItem["variations"]),
                'addons' => json_encode($cartItem["addons"]),
                'variations_price' => $varTotal,
                'addons_price' => $addonTotal,
                'product_price' => $pprice,
                'total' => $pprice + $varTotal + $addonTotal,
                'qty' => $cartItem["qty"],
                'image' => $cartItem["photo"],
                'created_at' => Carbon::now()
            ]);
        }
    }

    public function sendNotifications($order, $email, $user)
    {

        $currentLang = Language::query()->where([
            ['user_id', $user->id],
            ['is_default', 1]
        ])->first();

        $be = BasicExtended::query()
            ->where('user_id', $user->id)
            ->where('language_id', $currentLang->id)
            ->first();


        if (!empty($be['pusher_app_id']) && !empty($be['pusher_app_key']) && !empty($be['pusher_app_secret']) && !empty($be['pusher_app_cluster'])) {
            $pusherCredentials = [
                'driver' => 'pusher',
                'app_id' => $be['pusher_app_id'],
                'key' => $be['pusher_app_key'],
                'secret' => $be['pusher_app_secret'],
                'options' => [
                    'cluster' => $be['pusher_app_cluster'],
                ],
            ];

            Config::set('broadcasting.connections.pusher', $pusherCredentials);
        }

        if ($order->method != 'flutterwave') {
            // send mail to buyer

            $this->mailFromOwner($order, $user);
        }
        // send mail to owner

        $packagePermissions = UserPermissionHelper::packagePermission($user->id);
        $packagePermissions = json_decode($packagePermissions, true);
        if (!is_null($packagePermissions) && in_array('Live Orders', $packagePermissions)) {
            // real time notification to Owner
            if (!empty($be['pusher_app_id']) && !empty($be['pusher_app_key']) && !empty($be['pusher_app_secret']) && !empty($be['pusher_app_cluster'])) {
                event(new OrderPlaced());
            }
        }
        $bex = BasicExtra::query()->where('user_id', $user->id)->first();


        if (!empty($packagePermissions) && in_array('Whatsapp Order & Notification', $packagePermissions)) {

            if ($bex->twilio_sid && $bex->twilio_token && $bex->twilio_phone_number) {

                if (($order->serving_method == 'home_delivery' && $bex->whatsapp_home_delivery == 1)
                    || ($order->serving_method == 'pick_up' && $bex->whatsapp_pickup == 1)
                    || ($order->serving_method == 'on_table' && $bex->whatsapp_on_table == 1)
                ) {

                    try {
                        // whatsapp notification
                        Config::set('services.twilio.sid', $bex->twilio_sid);
                        Config::set('services.twilio.token', $bex->twilio_token);
                        Config::set('services.twilio.whatsapp_from', $bex->twilio_phone_number);
                        $order->notify(new WhatsappNotification($order));
                    } catch (\Exception $e) {
                    }
                }
            }
        }
    }


    public function mailFromOwner($order, $user)
    {
        $currentLang = $this->getUserCurrentLanguage($user);
        $bs = BasicSetting::query()
            ->where('user_id', $user->id)
            ->where('language_id', $currentLang->id)
            ->first();

        $fileName = Str::random(4) . time() . '.pdf';
        $path = public_path(Constant::WEBSITE_PRODUCT_INVOICE) . '/';
        $data['order']  = $order;

        @mkdir($path, 0775, true);

        if (!file_exists($path)) {
            @mkdir($path, 0775, true);
        }

        $fileLocated = $path . $fileName;

        Pdf::loadView('user-front.pdf.product', compact('order'))->save($fileLocated);

        ProductOrder::query()
            ->where('id', $order->id)
            ->update([
                'invoice_number' => $fileName
            ]);
        if (!is_null($order->customer_id)) {
            // Send Mail to Buyer
            $mailer = new MegaMailer;
            $data = [
                'toMail' => $order->billing_email,
                'toName' => $order->billing_fname,
                'attachment' => $fileName,
                'customer_name' => $order->billing_fname,
                'order_number' => $order->order_number,
                'order_link' => "<a href='" . route('user.client.orders.details', [getParam(), $order->id]) . "'>" . route('user.client.orders.details', [getParam(), $order->id]) . "</a>",
                'website_title' => $bs->website_title,
                'templateType' => 'food_checkout',
                'type' => 'foodCheckout'
            ];

            $mailer->mailFromUser($data, $order, $user);
        } else {
            $mailer = new MegaMailer;
            $data = [
                'toMail' => $order->billing_email,
                'toName' => $order->billing_fname,
                'attachment' => $fileName,
                'customer_name' => $order->billing_fname,
                'order_number' => $order->order_number,
                'website_title' => $bs->website_title,
                'templateType' => 'food_checkout',
                'type' => 'foodCheckout'
            ];

            $mailer->mailFromUser($data, $order, $user);
        }
    }

    public function mailToOwner($order, $email)
    {
        $subject = 'New Order Placed';
        $body = "A new order has been placed.<br>
        <strong>Order Number: </strong> " . $order->order_number . "<br>
        <a href='" . route('user.product.orders.details', $order->id) . "'>
            Click here to view order details
        </a>";
        $data = [
            'fromMail' => $order->billing_email,
            'fromName' => $order->billing_fname,
            'subject' => $subject,
            'body' => $body
        ];
        $mailer = new MegaMailer;
        $mailer->mailToOwner($data, $email);
    }
}
