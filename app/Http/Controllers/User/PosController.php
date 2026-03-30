<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\User;
use App\Models\User\Table;
use App\Constants\Constant;
use App\Events\OrderPlaced;
use Illuminate\Support\Str;
use App\Models\User\Product;
use Illuminate\Http\Request;
use App\Models\User\Customer;
use App\Models\User\Language;
use App\Models\User\OrderItem;
use App\Models\User\TimeFrame;
use App\Models\User\BasicExtra;
use App\Models\User\PostalCode;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Helpers\MegaMailer;
use App\Models\User\BasicSetting;
use App\Models\User\ProductOrder;
use App\Models\User\BasicExtended;
use App\Models\User\ServingMethod;
use App\Models\User\ShippingCharge;
use App\Http\Controllers\Controller;
use App\Models\User\PosPaymentMethod;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Http\Helpers\LimitCheckerHelper;
use App\Traits\UserCurrentLanguageTrait;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\UserPermissionHelper;
use App\Notifications\WhatsappNotification;

class PosController extends Controller
{
   use UserCurrentLanguageTrait;

    public function index()
     {
       
        $userId = getRootUser()->id;

        $lang = Language::query()->where([
            ['user_id', $userId],
            ['is_default', 1]
        ])->first();

        $data['pcats'] = $lang->pcategories()->where('status', 1)->get();

        $data['smethods'] = ServingMethod::query()->where([
            ['pos', 1],
            ['user_id', $userId]
        ])->get();
        $data['pmethods'] = PosPaymentMethod::query()->where([
            ['status', 1],
            ['user_id', $userId]
        ])->get();
        $data['tables'] = Table::query()->where([
            ['status', 1],
            ['user_id', $userId]
        ])->get();
        $data['scharges'] = $lang->shipping_charges;

        $data['postcodes'] = PostalCode::query()->where([
            ['language_id', $lang->id],
            ['user_id', $userId]
        ])
        ->orderBy('serial_number', 'ASC')
        ->get();
        $data['lang'] = $lang;
        $data['cart'] = Session::get(getRootUser()->username.'_pos_cart');

        // disabled days
        $days = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];
        $disDays = [];
        foreach ($days as $day) {
            $count = TimeFrame::where([
                ['day', $day],
                ['user_id', $userId]
            ])->count();
            if ($count == 0) {
                if ($day == 'sunday') {
                    $disDays[] = 0;
                } elseif ($day == 'monday') {
                    $disDays[] = 1;
                } elseif ($day == 'tuesday') {
                    $disDays[] = 2;
                } elseif ($day == 'wednesday') {
                    $disDays[] = 3;
                } elseif ($day == 'thursday') {
                    $disDays[] = 4;
                } elseif ($day == 'friday') {
                    $disDays[] = 5;
                } elseif ($day == 'saturday') {
                    $disDays[] = 6;
                }
            }
        }
        $data['disDays'] = $disDays;
        $data['onTable'] = ServingMethod::where([
            ['value', 'on_table'],
            ['user_id', $userId]
        ])->first();

        return view('user.pos.index', $data);
    }

    public function addToCart($id)
    {
        $userId = getRootUser()->id;
        $lang = Language::query()->where([
            ['user_id', $userId],
            ['is_default', 1]
        ])->first();
        $cart = Session::get(getRootUser()->username.'_pos_cart');

        $data = explode(',,,', $id);
        $id = (int)$data[0];
        $qty = (int)$data[1];
        $total = (float)$data[2];
        $variant = json_decode($data[3], true);
        $addons = json_decode($data[4], true);

        $product = Product::query()
            ->join('product_informations', 'products.id','product_informations.product_id')
            ->where('products.user_id',$userId)
            ->where('product_informations.language_id', $lang->id)
            ->findOrFail($id);

        // validations
        if ($qty < 1) {
            return response()->json(['error' => 'Quantity must be 1 or more than 1.']);
        }
        $pvariant = json_decode($product->variations, true);
        if (!empty($pvariant) && empty($variant)) {
            return response()->json(['error' => 'You must select a variant.']);
        }


        if (!$product) {
            abort(404);
        }
        $cart = Session::get(getRootUser()->username.'_pos_cart');
        $ckey = time();

        // if cart is empty then this the first product
        if (!$cart) {

            $cart = [
                $ckey => [
                    "id" => $id,
                    "name" => $product->title,
                    "qty" => (int)$qty,
                    "variations" => $variant,
                    "addons" => $addons,
                    "product_price" => (float)$product->current_price,
                    "total" => $total,
                    "photo" => $product->feature_image
                ]
            ];

            session()->put(getRootUser()->username.'_pos_cart', $cart);
            return response()->json(['message' => 'Product added to cart successfully!']);
        }

        // if cart not empty then check if this product (with same variation) exist then increment quantity
        foreach ($cart as $key => $cartItem) {
            if ($cartItem["id"] == $id && $variant == $cartItem["variations"] && $addons == $cartItem["addons"]) {
                $cart[$key]['qty'] = (int)$cart[$key]['qty'] + $qty;
                $cart[$key]['total'] = (float)$cart[$key]['total'] + $total;
                session()->put(getRootUser()->username.'_pos_cart', $cart);
                return response()->json(['message' => 'Product added to cart successfully!']);
            }
        }

        // if item not exist in cart then add to cart with quantity = 1
        $cart[$ckey] = [
            "id" => $id,
            "name" => $product->title,
            "qty" => (int)$qty,
            "variations" => $variant,
            "addons" => $addons,
            "product_price" => (float)$product->current_price,
            "total" => $total,
            "photo" => $product->feature_image
        ];


        session()->put(getRootUser()->username.'_pos_cart', $cart);


        return response()->json(['message' => 'Product added to cart successfully!']);
    }

    public function updateQty($key, $qty) {
        $cart = Session::get(getRootUser()->username.'_pos_cart');

        $total = 0;
        $cart["$key"]["qty"] = (int)$qty;

        // calculate total
        $addons = $cart["$key"]["addons"];
        if (is_array($addons)) {
            foreach ($addons as $addon) {
                $total += (float)$addon["price"];
            }
        }

        $variations = $cart["$key"]["variations"];
        if (is_array($variations)) {
            foreach ($variations as $variation) {
                $total += (float)$variation["price"];
            }
        }

        $total += (float)$cart["$key"]["product_price"];
        $total = $total * $qty;

        // save total in the cart item
        $cart["$key"]["total"] = $total;

        session()->put(getRootUser()->username.'_pos_cart', $cart);

        return 'success';
    }

    public function cartItemRemove($id)
    {
        if ($id) {
            $cart = Session::get(getRootUser()->username.'_pos_cart');
            unset($cart[$id]);
            session()->put(getRootUser()->username.'_pos_cart', $cart);
            return response()->json(['message' => 'Item removed successfully']);
        }
    }

    public function cartClear()
    {
        
        Session::forget(getRootUser()->username.'_pos_cart');
        Session::flash('success', 'Cart has been cleared!');
        return "success";
    }

    public function customerCopy() {
        $data['cart'] = Session::get(getRootUser()->username.'_pos_cart');
        return view('user.pos.partials.customer-copy', $data);
    }

    public function kitchenCopy() {
        $data['cart'] = Session::get(getRootUser()->username.'_pos_cart');
        return view('user.pos.partials.kitchen-copy', $data);
    }

    public function tokenNo() {
        return view('user.pos.partials.token-no');
    }

    public function paymentMethods() {
        $userId = getRootUser()->id;
        $data['pmethods'] = PosPaymentMethod::query()
            ->where('user_id', $userId)
            ->get();
        return view('user.pos.payment-methods', $data);
    }

    public function paymentMethodStore(Request $request) {
        $rules = [
            'status' => 'required',
            'name' => 'required|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;
        $pm = new PosPaymentMethod;
        $pm->user_id = $userId;
        $pm->status = $request->status;
        $pm->name = $request->name;
        $pm->save();

        Session::flash('success', 'Payment Method added successfully!');
        return "success";
    }

    public function paymentMethodUpdate(Request $request)
    {
        $rules = [
            'status' => 'required',
            'name' => 'required|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $userId = getRootUser()->id;
        $pm = PosPaymentMethod::query()
            ->where('user_id', $userId)
            ->findOrFail($request->pm_id);
        $pm->status = $request->status;
        $pm->name = $request->name;
        $pm->save();

        Session::flash('success', 'Payment Method updated successfully!');
        return "success";
    }

    public function paymentMethodDelete(Request $request)
    {
        $userId = getRootUser()->id;
        $pm = PosPaymentMethod::query()
            ->where('user_id', $userId)
            ->findOrFail($request->pm_id);
        $pm->delete();

        Session::flash('success', 'Payment Method deleted successfully!');
        return back();
    }

    public function customerName($phone) {
        $userId = getRootUser()->id;
        $customer = Customer::where([
            ['phone', $phone],
            ['user_id', $userId]
        ])->first();
        return response()->json($customer);
    }

    public function placeOrder(Request $request) 
    {
        $userId = getRootUser()->id;
        $count = LimitCheckerHelper::orderCount(getRootUser()->id);
        $package = LimitCheckerHelper::currentMembershipPackage(getRootUser()->id);
        $membership = LimitCheckerHelper::currentMembership($userId);

        if (is_null($package) || $count >= $package->order_limit) {

            Session::flash('warning', "we are currently unable to receive any order");
            return 'success';
        }

        $packagePermissions = UserPermissionHelper::packagePermission($userId);
        $packagePermissions = json_decode($packagePermissions, true);

        $currentLang = Language::query()->where([
            ['user_id', $userId],
            ['is_default', 1]
        ])->first();

        $be = BasicExtended::query()
            ->where('user_id', $userId)
            ->where('language_id', $currentLang->id)
            ->first();

        $user = User::where('id',$userId)->first();

      

        if (empty(Session::get(getRootUser()->username.'_pos_cart'))) {

            Session::flash('warning', 'No item added to cart!');
            return 'success';
        }

        if ($request->has('delivery_time') && $request->filled('delivery_time')) {
            $tf = TimeFrame::query()
                ->where('user_id', $userId)
                ->find((int)$request->delivery_time);
            // if maximum orders limit is not unlimited
            if (!empty($tf) && $tf->max_orders != 0) {
                $orderCount = ProductOrder::query()
                    ->where('order_status', '<>', 'cancelled')
                    ->where('delivery_time_start', $tf->start)
                    ->where('delivery_time_end', $tf->end)
                    ->where('user_id', $userId)
                    ->count();
                if ($orderCount >= $tf->max_orders) {
                    
                    Session::flash('warning', 'Number of orders in this time frame has reached to its limit!');
                    return 'success';
                }
            }
        }
       
        $bs = BasicSetting::query()
            ->where('user_id', $userId)
            ->first();
        // store in `product_orders`
        $po = new ProductOrder;
        $po->order_number = Str::random(4) . '-' . time();
        $po->billing_fname = $request->customer_name;
        $po->billing_number = $request->customer_phone;
        $po->billing_email = $request->customer_email;
        $po->serving_method = $request->serving_method;
        $po->method = $request->payment_method;
        $po->payment_status = $request->payment_status;
        $po->user_id = $userId;
        $po->membership_id = $membership->id;

        if ($request->serving_method == 'on_table') {
            $po->token_no = $bs->token_no + 1;
            $bs->token_no = $po->token_no;
            $bs->save();
            session()->put('pos_token_no', $po->token_no);
            $po->table_number = $request->table_no;
        } elseif ($request->serving_method == 'pick_up') {
            $po->pick_up_date = $request->pick_up_date;
            $po->pick_up_time = $request->pick_up_time;
        } elseif ($request->serving_method == 'home_delivery') {
            $po->delivery_date = $request->delivery_date;
            if ($be->delivery_date_time_status == 1) {
                if ($request->has('delivery_time') && $request->filled('delivery_time')) {
                    $po->delivery_time_start = $tf->start;
                    $po->delivery_time_end = $tf->end;
                }
            }

            if ($bs->postal_code == 0 || (is_array($packagePermissions) && !in_array('Postal Code Based Delivery Charge', $packagePermissions))) {
                if ($request->has('shipping_charge')) {
                    $shipping = ShippingCharge::query()
                        ->where('user_id', $userId)
                        ->findOrFail($request->shipping_charge);
                    $po->shipping_method = $shipping->title;
                    $po->shipping_charge = posShipping();
                }
            } else {
                $postalCode = PostalCode::query()
                    ->where('user_id', $userId)
                    ->findOrFail($request->postal_code);
                $po->shipping_charge = posShipping();

                $title = '';
                if (!empty($postalCode->title)) {
                    $title = $postalCode->title . ' - ';
                }
                $po->postal_code = $title . $postalCode->postcode;
                $po->postal_code_status = 1;
            }
        }

        $po->currency_code = $be->base_currency_text;
        $po->currency_code_position = $be->base_currency_text_position;
        $po->currency_symbol = $be->base_currency_symbol;
        $po->currency_symbol_position = $be->base_currency_symbol_position;
        $po->tax = posTax();
        $po->total = posCartSubTotal() + posTax() + posShipping();
        $po->type = 'pos';

        $po->save();
        $orderId = $po->id;

        // store in `customers`
        $customer = Customer::query()
            ->where([
            ['phone', $request->customer_phone],
            ['user_id', $userId]
        ]);

        if ($customer->count() == 0) {
            $customer = new Customer;
        } else {
            $customer = $customer->first();
        }
        $customer->name = $request->customer_name;
        $customer->phone = $request->customer_phone;
        $customer->email = $request->customer_email;
        $customer->user_id = $userId;
        $customer->save();

        // store in `order_items`
        $cart = Session::get(getRootUser()->username.'_pos_cart');

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
                foreach ($cartItem["variations"] as $key => $variation) {
                    $varTotal += (float)$variation["price"];
                }
                $varTotal = $varTotal * (int)$cartItem["qty"];
            }
            $pprice = (float)$cartItem["product_price"] * (int)$cartItem["qty"];

            OrderItem::insert([
                'user_id' => $userId,
                'product_order_id' => $orderId,
                'product_id' => $cartItem["id"],
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

        if (!empty($be['pusher_app_id']) && !empty($be['pusher_app_key']) && !empty($be['pusher_app_secret']) && !empty($be['pusher_app_cluster']) && (is_array($packagePermissions) && in_array('Live Orders', $packagePermissions))) {

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

            event(new OrderPlaced());
        }
        // clear cart
        Session::forget(getRootUser()->username.'_pos_cart');
        Session::forget(getRootUser()->username.'_pos_shipping_charge');
        Session::forget(getRootUser()->username.'_pos_serving_method');

        $bex = BasicExtra::query()->where('user_id', $userId)->first();

        if (!empty($packagePermissions) && in_array('Whatsapp Order & Notification', $packagePermissions)) {

            if ($bex->whatsapp_order_status_notification == 1) {

                if (($po->serving_method == 'home_delivery' && $bex->whatsapp_home_delivery == 1)
                    || ($po->serving_method == 'pick_up' && $bex->whatsapp_pickup == 1)
                    || ($po->serving_method == 'on_table' && $bex->whatsapp_on_table == 1)
                ) {
                    try {
                        // whatsapp notification
                        Config::set('services.twilio.sid', $bex->twilio_sid);
                        Config::set('services.twilio.token', $bex->twilio_token);
                        Config::set('services.twilio.whatsapp_from', $bex->twilio_phone_number);
                        $po->notify(new WhatsappNotification($po));
                    } catch (\Exception $e) {
                      
                    }
                }
            }
        }

        
        $this->mailFromOwner($po, $user);
     
        Session::flash('previous_serving_method', $request->serving_method);
        Session::flash('success', 'Order placed successfully');
        return 'success';
    }

    public function shippingCharge(Request $request)
     {

        $userId = getRootUser()->id;
        $sm = ServingMethod::query()
            ->where('value', $request->serving_method)
            ->where('user_id', $userId)
            ->first();

        if(!is_null($sm)){
            session()->put(getRootUser()->username.'_pos_serving_method', $sm->name);
            session()->put(getRootUser()->username.'_pos_shipping_charge', $request->shipping_charge);
        }
       
        return $sm;
    }

    public function mailFromOwner($order, $user)
    {
        $currentLang = $this->getUserCurrentLanguage($user);
        $bs = BasicSetting::query()
        ->where('user_id', $user->id)
        ->where('language_id', $currentLang->id)
        ->first();

        $fileName = Str::random(4) . time() . '.pdf';
        $path = public_path(Constant::WEBSITE_PRODUCT_INVOICE) . '/' . $fileName;
        $data['order']  = $order;
        PDF::loadView('user.pdf.product', $data)->save($path);

        ProductOrder::query()
            ->where('id', $order->id)
            ->update([
                'invoice_number' => $fileName
            ]);
        if (!is_null($order->billing_email)) {
            // Send Mail to Buyer
            $mailer = new MegaMailer;
            $data = [
                'toMail' => $order->billing_email,
                'toName' => $order->billing_fname,
                'attachment' => $fileName,
                'customer_name' => $order->billing_fname,
                'order_number' => $order->order_number,
                'order_link' => "<a href='" . route('user.client.orders.details', [$user->username, $order->id]) . "'>" . route('user.client.orders.details', [$user->username, $order->id]) . "</a>",
                'website_title' => $bs->website_title,
                'templateType' => 'food_checkout',
                'type' => 'foodCheckout'
            ];

            $mailer->mailFromUser($data, $order, $user);
        } 
    }
}
