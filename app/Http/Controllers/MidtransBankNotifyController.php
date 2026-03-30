<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Helpers\UserPermissionHelper;
use App\Models\Language;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Payment\product\MidtransController;
use App\Http\Controllers\User\UserCheckoutController;
use Carbon\Carbon;
use App\Http\Helpers\MegaMailer;
use App\Models\User\ProductOrder;

class MidtransBankNotifyController extends Controller
{
    public function bank_notify(Request $request)
    {
        $midtrans_payment_type = Session::get('midtrans_payment_type');
        if ($midtrans_payment_type == 'membership') {
            $requestData = Session::get('request');
            $currentLang = session()->has('lang') ?
                (Language::where('code', session()->get('lang'))->first())
                : (Language::where('is_default', 1)->first());
            $be = $currentLang->basic_extended;
            $bs = $currentLang->basic_setting;
            /** clear the session payment ID **/
            $cancel_url = route('membership.cancel');

            $token = Session::get('token');
            if ($request->status_code == 200 && $token == $request->order_id) {
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
            } else {
                return redirect($cancel_url);
            }
        } elseif ($midtrans_payment_type == 'product') {
            Session::put('bank_notify', 'yes');
            try {
                $data = new MidtransController();
                $result = $data->bankNotify($request);
                return redirect($result);
            } catch (\Exception $th) {
                dd($th);
            }
        }
    }

    public function cancel()
    {
        $midtrans_payment_type = Session::get('midtrans_payment_type');
        if ($midtrans_payment_type == 'membership') {
            return redirect()->route('membership.cancel');
        } elseif ($midtrans_payment_type == 'shop_room') {
            $cancel_url = Session::get('midtrans_cancel_url');
            return redirect($cancel_url);
        } elseif ($midtrans_payment_type == 'course') {
            $cancel_url = Session::get('midtrans_cancel_url');
            // remove all session data
            Session::forget('userId');
            Session::forget('courseId');
            Session::forget('arrData');
            Session::forget('midtrans_payment_type');
            Session::forget('order_details_url');
            Session::forget('midtrans_cancel_url');
            Session::forget('midtrans_success_url');

            return redirect($cancel_url);
        } elseif ($midtrans_payment_type == 'causes') {
            $cancel_url = Session::get('midtrans_cancel_url');
            // remove all session data
            Session::forget('causeId');
            Session::forget('userId');
            Session::forget('arrData');

            Session::forget('midtrans_payment_type');
            Session::forget('order_details_url');
            Session::forget('midtrans_cancel_url');
            Session::forget('midtrans_success_url');
            return redirect($cancel_url);
        }
    }
}
