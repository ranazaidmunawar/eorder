<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Package;
use App\Models\Language;
use App\Models\User\Menu;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\OfflineGateway;
use App\Http\Helpers\MegaMailer;
use App\Models\User\PageHeading;
use App\Models\User\MailTemplate;
use App\Models\User\PaymentGateway;
use App\Models\User\UserPermission;
use App\Constants\UserEmailTemplate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use App\Http\Helpers\UserPermissionHelper;
use App\Http\Requests\Checkout\CheckoutRequest;
use App\Http\Controllers\Payment\PaytmController;
use App\Http\Controllers\Payment\MollieController;
use App\Http\Controllers\Payment\PaypalController;
use App\Http\Controllers\Payment\StripeController;
use App\Http\Controllers\Payment\PaystackController;
use App\Http\Controllers\Payment\RazorpayController;
use App\Http\Controllers\Payment\InstamojoController;
use App\Http\Controllers\Payment\FlutterWaveController;
use App\Http\Controllers\Payment\MercadopagoController;
use App\Http\Controllers\Payment\AuthorizenetController;
use App\Http\Controllers\Payment\IyzicoController;
use App\Http\Controllers\Payment\MidtransController;
use App\Http\Controllers\Payment\MyFatoorahController;
use App\Http\Controllers\Payment\PaytabsController;
use App\Http\Controllers\Payment\PerfectMoneyController;
use App\Http\Controllers\Payment\PhonePeController;
use App\Http\Controllers\Payment\ToyyibpayController;
use App\Http\Controllers\Payment\XenditController;
use App\Http\Controllers\Payment\YocoController;

class CheckoutController extends Controller
{
    public function checkout(CheckoutRequest $request)
    {
        $coupon = Coupon::where('code', Session::get('coupon'))->first();
        if (!empty($coupon)) {
            $coupon_count = $coupon->total_uses;
            if ($coupon->maximum_uses_limit != 999999) {
                if ($coupon_count == $coupon->maximum_uses_limit) {
                    Session::forget('coupon');
                    session()->flash('warning', __('This coupon reached maximum limit'));
                    return redirect()->back();
                }
            }
        }

        $offline_payment_gateways = OfflineGateway::all()->pluck('name')->toArray();
        $currentLang = session()->has('lang') ?
            (Language::where('code', session()->get('lang'))->first())
            : (Language::where('is_default', 1)->first());
        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;
        $request['status'] = 1;
        $request['mode'] = 'online';
        $request['receipt_name'] = null;
        Session::put('paymentFor', 'membership');
        $title = "You are purchasing a membership";
        $description = "Congratulation you are going to join our membership.Please make a payment for confirming your membership now!";
        if ($request->package_type == "trial") {
            $package = Package::find($request['package_id']);
            $request['price'] = 0.00;
            $request['payment_method'] = "-";
            $transaction_id = UserPermissionHelper::uniqueId(8);
            $transaction_details = "Trial";
            $user = $this->store(
                $request->all(),
                $transaction_id,
                $transaction_details,
                $request->price,
                $be,
                $request->password
            );

            $lastMemb = $user->memberships()->orderBy('id', 'DESC')->first();
            $activation = Carbon::parse($lastMemb->start_date);
            $expire = Carbon::parse($lastMemb->expire_date);
            $file_name = $this->makeInvoice(
                $request->all(),
                "membership",
                $user,
                $request->password,
                $request['price'],
                "Trial",
                $request['phone'],
                $be->base_currency_symbol_position,
                $be->base_currency_symbol,
                $be->base_currency_text,
                $transaction_id,
                $package->title,
                $lastMemb
            );

            $mailer = new MegaMailer();
            $data = [
                'toMail' => $user->email,
                'toName' => $user->first_name . ' ' . $user->last_name,
                'username' => $user->username,
                'package_title' => $package->title,
                'package_price' => ($be->base_currency_text_position == 'left' ? $be->base_currency_text . ' ' : '') . $package->price . ($be->base_currency_text_position == 'right' ? ' ' . $be->base_currency_text : ''),
                'activation_date' => $activation->toFormattedDateString(),
                'expire_date' => Carbon::parse($expire->toFormattedDateString())->format('Y') == '9999' ? 'Lifetime' : $expire->toFormattedDateString(),
                'membership_invoice' => $file_name,
                'website_title' => $bs->website_title,
                'templateType' => 'registration_with_trial_package',
                'type' => 'registrationWithTrialPackage'
            ];
            $mailer->mailFromAdmin($data);
            session()->flash('success', __('successful_payment'));
            return redirect()->route('membership.trial.success');
        } elseif ($request->price == 0) {
            $package = Package::find($request['package_id']);
            $request['price'] = 0.00;
            $request['payment_method'] = "-";
            $transaction_id = UserPermissionHelper::uniqueId(8);
            $transaction_details = "Free";
            $user = $this->store($request->all(), $transaction_id, $transaction_details, $request->price, $be, $request->password);

            $lastMemb = $user->memberships()->orderBy('id', 'DESC')->first();
            $activation = Carbon::parse($lastMemb->start_date);
            $expire = Carbon::parse($lastMemb->expire_date);
            $file_name = $this->makeInvoice($request->all(), "membership", $user, $request->password, $request['price'], "Free", $request['phone'], $be->base_currency_symbol_position, $be->base_currency_symbol, $be->base_currency_text, $transaction_id, $package->title, $lastMemb);

            if (Session::has('coupon_amount')) {
                $mailTemp = 'registration_with_premium_package';
                $mailType = 'registrationWithPremiumPackage';
            } else {
                $mailTemp = 'registration_with_free_package';
                $mailType = 'registrationWithFreePackage';
            }

            $mailer = new MegaMailer();
            $data = [
                'toMail' => $user->email,
                'toName' => $user->first_name . ' ' . $user->last_name,
                'username' => $user->username,
                'package_title' => $package->title,
                'package_price' => ($be->base_currency_text_position == 'left' ? $be->base_currency_text . ' ' : '') . $package->price . ($be->base_currency_text_position == 'right' ? ' ' . $be->base_currency_text : ''),
                'activation_date' => $activation->toFormattedDateString(),
                'expire_date' => Carbon::parse($expire->toFormattedDateString())->format('Y') == '9999' ? 'Lifetime' : $expire->toFormattedDateString(),
                'membership_invoice' => $file_name,
                'website_title' => $bs->website_title,
                'templateType' => $mailTemp,
                'type' => $mailType
            ];

            if (Session::has('coupon_amount')) {
                $data['discount'] = ($be->base_currency_text_position == 'left' ? $be->base_currency_text . ' ' : '') . $lastMemb->discount . ($be->base_currency_text_position == 'right' ? ' ' . $be->base_currency_text : '');
                $data['total'] = ($be->base_currency_text_position == 'left' ? $be->base_currency_text . ' ' : '') . $lastMemb->price . ($be->base_currency_text_position == 'right' ? ' ' . $be->base_currency_text : '');
            }

            $mailer->mailFromAdmin($data);
            session()->flash('success', __('successful_payment'));
            return redirect()->route('success.page');
        } elseif ($request->payment_method == "Paypal") {
            $amount = round(($request->price / $be->base_currency_rate), 2);
            $paypal = new PaypalController();
            $cancel_url = route('membership.paypal.cancel');
            $success_url = route('membership.paypal.success');
            return $paypal->paymentProcess($request, $amount, $title, $success_url, $cancel_url);
        } elseif ($request->payment_method == "Stripe") {
            $amount = round(($request->price / $be->base_currency_rate), 2);
            $stripe = new StripeController();
            $cancel_url = route('membership.stripe.cancel');
            return $stripe->paymentProcess($request, $amount, $title, NULL, $cancel_url);
        } elseif ($request->payment_method == "Paytm") {
            if ($be->base_currency_text != "INR") {
                return redirect()->back()->with('error', __('only paytm INR'))->withInput($request->all());
            }
            $amount = $request->price;
            $item_number = uniqid('paytm-') . time();
            $callback_url = route('membership.paytm.status');
            $paytm = new PaytmController();
            return $paytm->paymentProcess($request, $amount, $item_number, $callback_url);
        } elseif ($request->payment_method == "Paystack") {
            if ($be->base_currency_text != "NGN") {
                return redirect()->back()->with('error', __('only paystack NGN'))->withInput($request->all());
            }
            $amount = $request->price * 100;
            $email = $request->email;
            $success_url = route('membership.paystack.success');
            $payStack = new PaystackController();
            return $payStack->paymentProcess($request, $amount, $email, $success_url, $be);
        } elseif ($request->payment_method == "Razorpay") {
            if ($be->base_currency_text != "INR") {
                return redirect()->back()->with('error', __('only razorpay INR'))->withInput($request->all());
            }
            $amount = $request->price;
            $item_number = uniqid('razorpay-') . time();
            $cancel_url = route('membership.razorpay.cancel');
            $success_url = route('membership.razorpay.success');
            $razorpay = new RazorpayController();
            return $razorpay->paymentProcess($request, $amount, $item_number, $cancel_url, $success_url, $title, $description, $bs, $be);
        } elseif ($request->payment_method == "Instamojo") {
            if ($be->base_currency_text != "INR") {
                return redirect()->back()->with('error', __('only instamojo INR'))->withInput($request->all());
            }
            if ($request->price < 9) {
                session()->flash('warning', 'Minimum 10 INR required for this payment gateway');
                return back()->withInput($request->all());
            }
            $amount = $request->price;
            $success_url = route('membership.instamojo.success');
            $cancel_url = route('membership.instamojo.cancel');
            $instaMojo = new InstamojoController();
            return $instaMojo->paymentProcess($request, $amount, $success_url, $cancel_url, $title, $be);
        } elseif ($request->payment_method == "Mercado Pago") {
            if ($be->base_currency_text != "BRL") {
                return redirect()->back()->with('error', __('only mercadopago BRL'))->withInput($request->all());
            }
            $amount = $request->price;
            $email = $request->email;
            $success_url = route('membership.mercadopago.success');
            $cancel_url = route('membership.mercadopago.cancel');
            $mercadopagoPayment = new MercadopagoController();
            return $mercadopagoPayment->paymentProcess($request, $amount, $success_url, $cancel_url, $email, $title, $description, $be);
        } elseif ($request->payment_method == "Flutterwave") {
            $available_currency = array(
                'BIF', 'CAD', 'CDF', 'CVE', 'EUR', 'GBP', 'GHS', 'GMD', 'GNF', 'KES', 'LRD', 'MWK', 'NGN', 'RWF', 'SLL', 'STD', 'TZS', 'UGX', 'USD', 'XAF', 'XOF', 'ZMK', 'ZMW', 'ZWD'
            );
            if (!in_array($be->base_currency_text, $available_currency)) {
                return redirect()->back()->with('error', __('invalid currency'))->withInput($request->all());
            }
            $amount = round(($request->price / $be->base_currency_rate), 2);
            $email = $request->email;
            $item_number = uniqid('flutterwave-') . time();
            $cancel_url = route('membership.flutterwave.cancel');
            $success_url = route('membership.flutterwave.success');
            $flutterWave = new FlutterWaveController();
            return $flutterWave->paymentProcess($request, $amount, $email, $item_number, $success_url, $cancel_url, $be);
        } elseif ($request->payment_method == "Authorize.net") {
            $available_currency = array('USD', 'CAD', 'CHF', 'DKK', 'EUR', 'GBP', 'NOK', 'PLN', 'SEK', 'AUD', 'NZD');
            if (!in_array($be->base_currency_text, $available_currency)) {
                return redirect()->back()->with('error', __('invalid currency'))->withInput($request->all());
            }
            $amount = $request->price;
            $cancel_url = route('membership.anet.cancel');
            $anetPayment = new AuthorizenetController();
            return $anetPayment->paymentProcess($request, $amount, $cancel_url, $title, $be);
        } elseif ($request->payment_method == "Mollie Payment") {
            $available_currency = array('AED', 'AUD', 'BGN', 'BRL', 'CAD', 'CHF', 'CZK', 'DKK', 'EUR', 'GBP', 'HKD', 'HRK', 'HUF', 'ILS', 'ISK', 'JPY', 'MXN', 'MYR', 'NOK', 'NZD', 'PHP', 'PLN', 'RON', 'RUB', 'SEK', 'SGD', 'THB', 'TWD', 'USD', 'ZAR');
            if (!in_array($be->base_currency_text, $available_currency)) {
                return redirect()->back()->with('error', __('invalid currency'))->withInput($request->all());
            }
            $amount = round(($request->price / $be->base_currency_rate), 2);
            $success_url = route('membership.mollie.success');
            $cancel_url = route('membership.mollie.cancel');
            $molliePayment = new MollieController();
            return $molliePayment->paymentProcess($request, $amount, $success_url, $cancel_url, $title, $be);
        } elseif ($request->payment_method == "Yoco") {
            $available_currency = array('ZAR');
            if (!in_array($be->base_currency_text, $available_currency)) {
                return redirect()->back()->with('error', __('invalid currency'))->withInput($request->all());
            }
            $amount = round(($request->price / $be->base_currency_rate), 2);
            $success_url = route('membership.yoco.success');
            $cancel_url = route('membership.cancel');
            $payment = new YocoController();
            return $payment->paymentProcess($request, $amount, $success_url);
        } elseif ($request->payment_method == "Xendit") {
            $available_currency = array('IDR', 'PHP', 'USD', 'SGD', 'MYR');
            if (!in_array($be->base_currency_text, $available_currency)) {
                return redirect()->back()->with('error', __('invalid currency'))->withInput($request->all());
            }
            $amount = round(($request->price / $be->base_currency_rate), 2);
            $success_url = route('membership.xendit.success');
            $cancel_url = route('membership.cancel');
            $payment = new XenditController();
            return $payment->paymentProcess($request, $amount, $success_url, $be);
        } elseif ($request->payment_method == "Perfect Money") {
            $available_currency = array('USD');
            if (!in_array($be->base_currency_text, $available_currency)) {
                return redirect()->back()->with('error', __('invalid currency'))->withInput($request->all());
            }
            $amount = round(($request->price / $be->base_currency_rate), 2);
            $success_url = route('membership.perfect_money.success');
            $cancel_url = route('membership.cancel');
            $payment = new PerfectMoneyController();
            return $payment->paymentProcess($request, $amount, $success_url, $cancel_url, $be, $bs);
        } elseif ($request->payment_method == "Midtrans") {
            $available_currency = array('IDR');
            if (!in_array($be->base_currency_text, $available_currency)) {
                return redirect()->back()->with('error', __('invalid currency'))->withInput($request->all());
            }
            $amount = round(($request->price / $be->base_currency_rate), 2);
            $success_url = route('membership.midtrans.success');
            $cancel_url = route('membership.cancel');
            $payment = new MidtransController();
            return $payment->paymentProcess($request, $amount, $success_url, $cancel_url, $be, $bs);
        } elseif ($request->payment_method == "Myfatoorah") {
            $available_currency = array('KWD', 'SAR', 'BHD', 'AED', 'QAR', 'OMR', 'JOD');
            if (!in_array($be->base_currency_text, $available_currency)) {
                return redirect()->back()->with('error', __('invalid currency'))->withInput($request->all());
            }
            $amount = round(($request->price / $be->base_currency_rate), 2);
            $success_url = route('membership.myfatoorah.success');
            $cancel_url = route('membership.cancel');
            $payment = new MyFatoorahController();
            return $payment->paymentProcess($request, $amount, $success_url, $cancel_url, $be, $bs);
        } elseif ($request->payment_method == "Iyzico") {
            $available_currency = array('TRY');
            if (!in_array($be->base_currency_text, $available_currency)) {
                return redirect()->back()->with('error', __('invalid currency'))->withInput($request->all());
            }
            $amount = round(($request->price / $be->base_currency_rate), 2);
            $success_url = route('membership.iyzico.success');
            $cancel_url = route('membership.cancel');
            $payment = new IyzicoController();
            return $payment->paymentProcess($request, $amount, $success_url, $cancel_url, $be, $bs);
        } elseif ($request->payment_method == "Toyyibpay") {
            $available_currency = array('RM');
            if (!in_array($be->base_currency_text, $available_currency)) {
                return redirect()->back()->with('error', __('invalid currency'))->withInput($request->all());
            }
            $amount = round(($request->price / $be->base_currency_rate), 2);
            $success_url = route('membership.toyyibpay.success');
            $cancel_url = route('membership.cancel');
            $payment = new ToyyibpayController();
            return $payment->paymentProcess($request, $amount, $success_url, $cancel_url, $be, $bs);
        } elseif ($request->payment_method == "Paytabs") {
            $paytabInfo = paytabInfo('admin', null);
            if ($be->base_currency_text != $paytabInfo['currency']) {
                return redirect()->back()->with('error', __('invalid currency'))->withInput($request->all());
            }
            $amount = round(($request->price / $be->base_currency_rate), 2);
            $success_url = route('membership.paytabs.success');
            $cancel_url = route('membership.cancel');
            $payment = new PaytabsController();
            return $payment->paymentProcess($request, $amount, $success_url, $cancel_url, $be, $bs);
        } elseif ($request->payment_method == "PhonePe") {
            $available_currency = array('INR');
            if (!in_array($be->base_currency_text, $available_currency)) {
                return redirect()->back()->with('error', __('invalid currency'))->withInput($request->all());
            }
            $amount = round(($request->price / $be->base_currency_rate), 2);
            $success_url = route('membership.phonepe.success');
            $cancel_url = route('membership.cancel');
            $payment = new PhonePeController();
            return $payment->paymentProcess($request, $amount, $success_url, $cancel_url, $be, $bs);
        } elseif (in_array($request->payment_method, $offline_payment_gateways)) {
            $request['mode'] = 'offline';
            $request['status'] = 0;
            $request['receipt_name'] = null;
            if ($request->has('receipt')) {
                $filename = time() . '.' . $request->file('receipt')->getClientOriginalExtension();
                $directory = "./assets/front/img/membership/receipt";
                if (!file_exists($directory)) mkdir($directory, 0775, true);
                $request->file('receipt')->move($directory, $filename);
                $request['receipt_name'] = $filename;
            }
            $amount = round(($request->price / $be->base_currency_rate), 2);
            $transaction_id = UserPermissionHelper::uniqueId(8);
            $transaction_details = "offline";
            $password = $request->password;
            
            $this->store($request->all(), $transaction_id, json_encode($transaction_details), $amount, $be, $password);
            session()->flash('success', __('successful_payment'));
            return redirect()->route('membership.offline.success');
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(
        $request,
        $transaction_id,
        $transaction_details,
        $amount,
        $be,
        $password
    ) {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $bs = $currentLang->basic_setting;
        $token = md5(time() . $request['username'] . $request['email']);
        $verification_link = "<a href='" . url('user/register/mode/' . $request['mode'] . '/verify/' . $token) . "'>" . "<button type=\"button\" class=\"btn btn-primary\">Click Here</button>" . "</a>";

        $userData = User::query()->where('username', $request['username']);
        if ($userData->count() == 0) {
            $user = User::create([
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
                'phone' => $request['phone'],
                'username' => $request['username'],
                'password' => bcrypt($password),
                'status' => $request["status"],
                'address' => $request["address"] ? $request["address"] : null,
                'city' => $request["city"] ? $request["city"] : null,
                'state' => $request["district"] ? $request["district"] : null,
                'country' => $request["country"] ? $request["country"] : null,
                'verification_link' => $token,
            ]);

            if ($user) {
                $this->insertMailTemplate($user);
            }

            $deLang = User\Language::first();
            $langCount = User\Language::query()->where('user_id', $user->id)->where('is_default', 1)->count();
            if ($langCount == 0) {

                $in['datepicker_name'] = uniqid();

                $filename = $in['datepicker_name'] . '-' . 'en';

                // Path to the public folder where the JavaScript file will be stored
                $publicPath = public_path('assets/tenant/js/i18n');

                // Create the directory if it doesn't exist
                File::makeDirectory($publicPath, 0755, true, true);

                // Full path to the JavaScript file
                $filePath = $publicPath . '/' . $filename . '.js';


                $jsContent = <<<JS
            (function(factory) {
                "use strict";

                if (typeof define === "function" && define.amd) {
                    define(["../widgets/datepicker"], factory);
                } else {
                    factory(jQuery.datepicker);
                }
            })(function(datepicker) {
                "use strict";

                datepicker.regional.en = {
                    closeText: "Done",
                    prevText: "Prev",
                    nextText: "Next",
                    currentText: "Today",
                    monthNames: [ "January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December" ],
                    monthNamesShort: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                    "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ],
                    dayNames: [ "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday" ],
                    dayNamesShort: [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
                    dayNamesMin: [ "Su", "Mo", "Tu", "We", "Th", "Fr", "Sa" ],
                    weekHeader: "Wk",
                    dateFormat: "dd/mm/yy",
                    firstDay: 1,
                    isRTL: false,
                    showMonthAfterYear: false,
                    yearSuffix: "" 
                };
                
                datepicker.setDefaults(datepicker.regional.en);

            });
            JS;
                file_put_contents($filePath, $jsContent);

                $lang = new User\Language;
                $lang->name = 'English';
                $lang->code = 'en';
                $lang->is_default = 1;
                $lang->rtl = 0;
                $lang->user_id = $user->id;
                $lang->keywords = $deLang->keywords;
                $lang->datepicker_name = $in['datepicker_name'];
                $lang->save();


                $umenu = new Menu();
                $umenu->language_id = $lang->id;
                $umenu->user_id = $user->id;
                $umenu->menus = '[{"text":"Home","href":"","icon":"empty","target":"_self","title":"","type":"home"},{"text":"Menu","href":"","icon":"empty","target":"_self","title":"","type":"menu"},{"text":"Items","href":"","icon":"empty","target":"_self","title":"","type":"items"},{"text":"Cart","href":"","icon":"empty","target":"_self","title":"","type":"cart"},{"text":"Checkout","href":"","icon":"empty","target":"_self","title":"","type":"checkout"},{"text":"Pages","href":"","icon":"empty","target":"_self","title":"","type":"custom","children":[{"text":"Career","href":"","icon":"empty","target":"_self","title":"","type":"career"},{"text":"Team Members","href":"","icon":"empty","target":"_self","title":"","type":"team"},{"text":"Gallery","href":"","icon":"empty","target":"_self","title":"","type":"gallery"},{"text":"FAQ","href":"","icon":"empty","target":"_self","title":"","type":"faq"},{"type":"about-us","text":"About Us","href":"","target":"_self"}]},{"text":"Blog","href":"","icon":"empty","target":"_self","title":"","type":"blog"},{"text":"Contact","href":"","icon":"empty","target":"_self","title":"","type":"contact"}]';
                $umenu->save();
            }

            // create payment gateways
            $payment_keywords = ['flutterwave', 'razorpay', 'paytm', 'paystack', 'instamojo', 'stripe', 'paypal', 'mollie', 'mercadopago', 'authorize.net'];
            foreach ($payment_keywords as $key => $value) {
                PaymentGateway::create([
                    'title' => null,
                    'user_id' => $user->id,
                    'details' => null,
                    'keyword' => $value,
                    'subtitle' => null,
                    'name' => ucfirst($value),
                    'type' => 'automatic',
                    'information' => null
                ]);
            }

            $package = Package::query()->findOrFail($request['package_id']);

            Membership::create([
                'package_price' => $package->price,
                'discount' => session()->has('coupon_amount') ? session()->get('coupon_amount') : 0,
                'coupon_code' => session()->has('coupon') ? session()->get('coupon') : NULL,
                'price' => $amount,
                'currency' => $be->base_currency_text ?? "USD",
                'currency_symbol' => $be->base_currency_symbol ?? $be->base_currency_text,
                'payment_method' => $request["payment_method"],
                'transaction_id' => $transaction_id ?? 0,
                'status' => $request["status"] ? $request["status"] : 0,
                'is_trial' => $request["package_type"] == "regular" ? 0 : 1,
                'trial_days' => $request["package_type"] == "regular" ? 0 : $request["trial_days"],
                'receipt' => $request["receipt_name"] ? $request["receipt_name"] : null,
                'transaction_details' => $transaction_details ?? null,
                'settings' => json_encode($be),
                'package_id' => $request['package_id'],
                'user_id' => $user->id,
                'start_date' => Carbon::parse($request['start_date']),
                'expire_date' => Carbon::parse($request['expire_date']),
                'conversation_id' => array_key_exists('conversation_id', $request) ? $request["conversation_id"] : null
            ]);
            $features = json_decode($package->features, true);
            $features[] = "Contact";
            UserPermission::create([
                'package_id' => $request['package_id'],
                'user_id' => $user->id,
                'permissions' => json_encode($features)
            ]);

            User\BasicSetting::create([
                'base_color' => 'D3A971',
                'language_id' => $lang->id,
                'user_id' => $user->id,
                'home_version' => 'slider',
                'support_email' => $user->email,
                'support_phone' => $user->phone,
                'website_title' => $user->username,
            ]);
            PageHeading::create([
                'language_id' => $lang->id,
                'user_id' => $user->id,
            ]);
            User\BasicExtended::create([
                'base_currency_symbol' => '$',
                'base_currency_text' => 'USD',
                'base_currency_rate' => 1.00,
                'language_id' => $lang->id,
                'user_id' => $user->id,
                'from_mail' => $user->email,
                'from_name' => $user->username,
            ]);
            User\BasicExtra::create([
                'user_id' => $user->id,
            ]);

            User\ServingMethod::query()->insert(['user_id' => $user->id, 'name' => 'On Table', 'value' => 'on_table', 'serial_number' => 1]);
            User\ServingMethod::query()->insert(['user_id' => $user->id, 'name' => 'Pick Up', 'value' => 'pick_up', 'serial_number' => 2]);
            User\ServingMethod::query()->insert(['user_id' => $user->id, 'name' => 'Home Delivery', 'value' => 'home_delivery', 'serial_number' => 3]);

            $orderTimeData = [
                ['user_id' => $user->id, 'day' => 'monday'],
                ['user_id' => $user->id, 'day' => 'tuesday'],
                ['user_id' => $user->id, 'day' => 'wednesday'],
                ['user_id' => $user->id, 'day' => 'thursday'],
                ['user_id' => $user->id, 'day' => 'friday'],
                ['user_id' => $user->id, 'day' => 'saturday'],
                ['user_id' => $user->id, 'day' => 'sunday'],
            ];
            User\OrderTime::query()->insert($orderTimeData);
            // user seo insert
            User\SEO::query()->create([
                'user_id' => $user->id,
                'language_id' => $lang->id,
                'home_meta_keywords' => 'home_meta_keywords',
                'home_meta_description' => 'home_meta_description',
                'career_meta_keywords' => 'career_meta_keywords',
                'career_meta_description' => 'career_meta_description',
                'blogs_meta_keywords' => 'blogs_meta_keywords',
                'blogs_meta_description' => 'blogs_meta_description',
                'gallery_meta_keywords' => 'gallery_meta_keywords',
                'gallery_meta_description' => 'gallery_meta_description',
                'faqs_meta_keywords' => 'faqs_meta_keywords',
                'faqs_meta_description' => 'faqs_meta_description',
                'contact_meta_keywords' => 'contact_meta_keywords',
                'contact_meta_description' => 'contact_meta_description',
                'reservation_meta_keywords' => 'reservation_meta_keywords',
                'reservation_meta_description' => 'reservation_meta_description',
                'team_meta_keywords' => 'team_meta_keywords',
                'team_meta_description' => 'team_meta_description',
                'product_meta_keywords' => 'product_meta_keywords',
                'product_meta_description' => 'product_meta_description',
                'checkout_meta_keywords' => 'checkout_meta_keywords',
                'checkout_meta_description' => 'checkout_meta_description',
                'login_meta_keywords' => 'login_meta_keywords',
                'login_meta_description' => 'login_meta_description',
                'sign_up_meta_keywords' => 'sign_up_meta_keywords',
                'sign_up_meta_description' => 'sign_up_meta_description',
                'forget_password_meta_keywords' => 'forget_password_meta_keywords',
                'forget_password_meta_description' => 'forget_password_meta_description',
                'cart_meta_keywords' => 'cart_meta_keywords',
                'cart_meta_description' => 'cart_meta_description'
            ]);
            $mailer = new MegaMailer();
            $data = [
                'toMail' => $user->email,
                'toName' => $user->first_name . ' ' . $user->last_name,
                'customer_name' => $user->username,
                'verification_link' => $verification_link,
                'website_title' => $bs->website_title,
                'templateType' => 'email_verification',
                'type' => 'emailVerification'
            ];
            $mailer->mailFromAdmin($data);
        }
        // coupon update
        if (Session::has('coupon')) {
            $coupon = Coupon::query()->where('code', Session::get('coupon'))->first();
            $coupon->total_uses = $coupon->total_uses + 1;
            $coupon->save();
        }
        return $user;
    }

    public function insertMailTemplate($user)
    {
        $template = new UserEmailTemplate($user);
        $data = $template->getUserMailTemplate();
        foreach ($data as $value) {
            $mailTemp = new MailTemplate();
            $mailTemp->user_id = $value['user_id'];
            $mailTemp->mail_type = $value['mail_type'];
            $mailTemp->mail_subject = $value['mail_subject'];
            $mailTemp->mail_body = $value['mail_body'];
            $mailTemp->save();
        }
    }

    public function onlineSuccess()
    {
        Session::forget('coupon');
        Session::forget('coupon_amount');
        return view('front.success');
    }

    public function offlineSuccess()
    {
        Session::forget('coupon');
        Session::forget('coupon_amount');
        return view('front.offline-success');
    }

    public function trialSuccess()
    {
        Session::forget('coupon');
        Session::forget('coupon_amount');
        return view('front.trial-success');
    }

    public function coupon(Request $request)
    {
        if (session()->has('coupon')) {
            return 'Coupon already applied';
        }
        $coupon = Coupon::where('code', $request->coupon)->first();
        if (empty($coupon)) {
            return 'This coupon does not exist';
        }

        $coupon_count = $coupon->total_uses;
        if ($coupon->maximum_uses_limit != 999999) {
            if ($coupon_count >= $coupon->maximum_uses_limit) {
                return 'This coupon reached maximum limit';
            }
        }
        $start = Carbon::parse($coupon->start_date);
        $end = Carbon::parse($coupon->end_date);
        $today = Carbon::parse(Carbon::now()->format('m/d/Y'));
        $packages = $coupon->packages;
        $packages = json_decode($packages, true);
        $packages = !empty($packages) ? $packages : [];
        if (!in_array($request->package_id, $packages)) {
            return 'This coupon is not valid for this package';
        }

        if ($today->greaterThanOrEqualTo($start) && $today->lessThanOrEqualTo($end)) {
            $package = Package::find($request->package_id);
            $price = $package->price;
            if ($coupon->type == 'percentage') {
                $cAmount = ($price * $coupon->value) / 100;
            } else {
                $cAmount = $coupon->value;
            }
            Session::put('coupon', $request->coupon);
            Session::put('coupon_amount', round($cAmount, 2));
            return "success";
        } else {
            return 'This coupon does not exist';
        }
    }

    public function cancel()
    {
        $request = Session::get('request');
        $paymentFor = Session::get('paymentFor');
        if ($paymentFor == "membership") {
            return redirect()->route('front.register.view', ['status' => $request['package_type'], 'id' => $request['package_id']])->withInput($request);
        } else {
            return redirect()->route('user.plan.extend.checkout', ['package_id' => $request['package_id']])->withInput($request);
        }
    }
}
