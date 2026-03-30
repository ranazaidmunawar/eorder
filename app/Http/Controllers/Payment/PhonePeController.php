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
use Illuminate\Support\Facades\Auth;
use Ixudra\Curl\Facades\Curl;

class PhonePeController extends Controller
{
    private $information;

    public function __construct()
    {
        $data = PaymentGateway::whereKeyword('phonepe')->first();
        $this->information = $data->convertAutoData();
    }

    public function paymentProcess(Request $request, $_amount, $_success_url, $cancel_url)
    {
        if (is_null($this->information)) {
            session()->flash('error', 'Credentials are not set yet');
            return redirect()->back();
        }

        $price = $_amount;
        $price = round($price, 2);
        $success_url = $_success_url;

        $paymentFor = Session::get('paymentFor');
        if ($paymentFor == 'membership') {
            $phone = $request['phone'];
        } else {
            $phone = Auth::guard('web')->user()->phone;
        }


        ################################
        // Payment Gateway Info 
        ################################ 

        $random_id = rand(111, 999);
        $data = array(
            'merchantId' => $this->information['merchant_id'], // sandbox merchant id
            'merchantTransactionId' => uniqid(),
            'merchantUserId' => 'MUID' . $random_id, // it will be the ID of tenants / vendors from database
            'amount' => intval($_amount * 100),
            'redirectUrl' => $success_url,
            'redirectMode' => 'POST',
            'callbackUrl' => $success_url,
            'mobileNumber' => $phone,
            'paymentInstrument' =>
            array(
                'type' => 'PAY_PAGE',
            ),
        );

        $encode = base64_encode(json_encode($data));
        $saltKey = $this->information['salt_key'];
        $saltIndex = $this->information['salt_index'];

        $string = $encode . '/pg/v1/pay' . $saltKey;
        $sha256 = hash('sha256', $string);

        $finalXHeader = $sha256 . '###' . $saltIndex;

        if ($this->information['sandbox_check'] == 1) {
            $url = "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay"; // sandbox payment URL
        } else {
            $url = "https://api.phonepe.com/apis/hermes/pg/v1/pay"; // prod payment URL
        }

        $response = Curl::to($url)
            ->withHeader('Content-Type:application/json')
            ->withHeader('X-VERIFY:' . $finalXHeader)
            ->withData(json_encode(['request' => $encode]))
            ->post();
        Session::put('request', $request->all());
        $rData = json_decode($response);
        if (empty($rData->data->instrumentResponse->redirectInfo->url)) {
            return redirect($cancel_url);
        }
        return redirect()->to($rData->data->instrumentResponse->redirectInfo->url);
    }

    public function successPayment(Request $request)
    {
        $requestData = Session::get('request');
        $currentLang = session()->has('lang') ?
            (Language::where('code', session()->get('lang'))->first())
            : (Language::where('is_default', 1)->first());
        $be = $currentLang->basic_extended;
        $bs = $currentLang->basic_setting;
        /** clear the session payment ID **/
        $cancel_url = route('membership.cancel');

        if ($request->code == 'PAYMENT_SUCCESS') {
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
