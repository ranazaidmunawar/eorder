<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\User\UserCheckoutController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Helpers\UserPermissionHelper;
use App\Models\Package;
use App\Http\Helpers\MegaMailer;
use App\Models\Language;
use Carbon\Carbon;
use Illuminate\Support\Str;

class XenditController extends Controller
{
    private $information;

    public function __construct()
    {
        $data = PaymentGateway::whereKeyword('xendit')->first();
        $this->information = $data->convertAutoData();
    }

    public function paymentProcess(Request $request, $_amount, $_success_url, $be)
    {
        if (is_null($this->information)) {
            session()->flash('error', 'Credentials are not set yet');
            return redirect()->back();
        }

        $price = $_amount;
        $success_url = $_success_url;

        /*******************************************************
         *************** Payment Gateway Info **************
         *******************************************************/
        $external_id = Str::random(10);
        $secret_key = 'Basic ' . base64_encode($this->information['secret_key'] . ':');
        $data_request = Http::withHeaders([
            'Authorization' => $secret_key
        ])->post('https://api.xendit.co/v2/invoices', [
            'external_id' => $external_id,
            'amount' => $price,
            'currency' => $be->base_currency_text,
            'success_redirect_url' => $success_url
        ]);
        $response = $data_request->object();
        $response = json_decode(json_encode($response), true);
        if (!empty($response['success_redirect_url'])) {
            $request->session()->put('xendit_id', $response['id']);
            $request->session()->put('secret_key', $secret_key);
            Session::put('request', $request->all());
            Session::put('amount', $_amount);
            return redirect($response['invoice_url']);
        } else {
            return redirect()->back()->with('error', 'Unknown error occurred');
        }
    }

    public function successPayment(Request $request)
    {
        $xendit_id = Session::get('xendit_id');
        $secret_key = Session::get('secret_key');

        $requestData = Session::get('request');
        $currentLang = session()->has('lang') ?
            (Language::where('code', session()->get('lang'))->first())
            : (Language::where('is_default', 1)->first());
        $be = $currentLang->basic_extended;
        $bs = $currentLang->basic_setting;
        /** clear the session payment ID **/
        $cancel_url = route('membership.cancel');

        $p_secret_key = 'Basic ' . base64_encode($this->information['secret_key'] . ':');
        if (!is_null($xendit_id) && $secret_key == $p_secret_key) {
            $paymentFor = Session::get('paymentFor');
            $package = Package::find($requestData['package_id']);
            $transaction_id = UserPermissionHelper::uniqueId(8);
            $transaction_details = json_encode($request->all());
            if ($paymentFor == "membership") {
                $amount = $requestData['price'];
                $password = $requestData['password'];
                $checkout = new CheckoutController();
                $user = $checkout->store($requestData, $transaction_id, $transaction_details, $amount, $be, $password);

                $lastMemb = $user->memberships()->orderBy('id', 'DESC')->first();
                $activation = Carbon::parse($lastMemb->start_date);
                $expire = Carbon::parse($lastMemb->expire_date);
                $file_name = $this->makeInvoice($requestData, "membership", $user, $password, $amount, "Yoco", $requestData['phone'], $be->base_currency_symbol_position, $be->base_currency_symbol, $be->base_currency_text, $transaction_id, $package->title, $lastMemb);

                $mailer = new MegaMailer();
                $data = [
                    'toMail' => $user->email,
                    'toName' => $user->first_name . ' ' . $user->last_name,
                    'username' => $user->username,
                    'package_title' => $package->title,
                    'package_price' => ($be->base_currency_text_position == 'left' ? $be->base_currency_text . ' ' : '') . $package->price . ($be->base_currency_text_position == 'right' ? ' ' . $be->base_currency_text : ''),
                    'discount' => ($be->base_currency_text_position == 'left' ? $be->base_currency_text . ' ' : '') . $lastMemb->discount . ($be->base_currency_text_position == 'right' ? ' ' . $be->base_currency_text : ''),
                    'total' => ($be->base_currency_text_position == 'left' ? $be->base_currency_text . ' ' : '') . $lastMemb->price . ($be->base_currency_text_position == 'right' ? ' ' . $be->base_currency_text : ''),
                    'activation_date' => $activation->toFormattedDateString(),
                    'expire_date' => Carbon::parse($expire->toFormattedDateString())->format('Y') == '9999' ? 'Lifetime' : $expire->toFormattedDateString(),
                    'membership_invoice' => $file_name,
                    'website_title' => $bs->website_title,
                    'templateType' => 'registration_with_premium_package',
                    'type' => 'registrationWithPremiumPackage'
                ];
                $mailer->mailFromAdmin($data);

                session()->flash('success', __('successful_payment'));
                return redirect()->route('success.page');
            } elseif ($paymentFor == "extend") {
                $amount = $requestData['price'];
                $password = uniqid('qrcode');
                $checkout = new UserCheckoutController();
                $user = $checkout->store($requestData, $transaction_id, $transaction_details, $amount, $be, $password);


                $lastMemb = $user->memberships()->orderBy('id', 'DESC')->first();
                $activation = Carbon::parse($lastMemb->start_date);
                $expire = Carbon::parse($lastMemb->expire_date);
                $file_name = $this->makeInvoice($requestData, "extend", $user, $password, $amount, $requestData["payment_method"], $user->phone, $be->base_currency_symbol_position, $be->base_currency_symbol, $be->base_currency_text, $transaction_id, $package->title, $lastMemb);

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
                    'templateType' => 'membership_extend',
                    'type' => 'membershipExtend'
                ];
                $mailer->mailFromAdmin($data);
                return redirect()->route('success.page');
            }
        }
        return redirect($cancel_url);
    }
}
