<?php

namespace App\Http\Helpers;

use App\Models\Language;
use App\Constants\Constant;
use Illuminate\Mail\Message;
use App\Models\BasicExtended;
use App\Models\EmailTemplate;
use App\Models\User\MailTemplate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Traits\UserCurrentLanguageTrait;

class MegaMailer
{

    use UserCurrentLanguageTrait;

    public function mailFromAdmin($data)
    {
       
        $temp = EmailTemplate::query()
            ->where('email_type', '=', $data['templateType'])
            ->first();

        $body = $temp->email_body;
        if (array_key_exists('username', $data)) {
            $body = preg_replace("/{username}/", $data['username'], $body);
        }
        if (array_key_exists('replaced_package', $data)) {
            $body = preg_replace("/{replaced_package}/", $data['replaced_package'], $body);
        }
        if (array_key_exists('removed_package_title', $data)) {
            $body = preg_replace("/{removed_package_title}/", $data['removed_package_title'], $body);
        }
        if (array_key_exists('package_title', $data)) {
            $body = preg_replace("/{package_title}/", $data['package_title'], $body);
        }
        if (array_key_exists('package_price', $data)) {
            $body = preg_replace("/{package_price}/", $data['package_price'], $body);
        }
        if (array_key_exists('discount', $data)) {
            $body = preg_replace("/{discount}/", $data['discount'], $body);
        }
        if (array_key_exists('total', $data)) {
            $body = preg_replace("/{total}/", $data['total'], $body);
        }
        if (array_key_exists('activation_date', $data)) {
            $body = preg_replace("/{activation_date}/", $data['activation_date'], $body);
        }
        if (array_key_exists('expire_date', $data)) {
            $body = preg_replace("/{expire_date}/", $data['expire_date'], $body);
        }
        if (array_key_exists('requested_domain', $data)) {
            $body = preg_replace("/{requested_domain}/", "<a href='http://" . $data['requested_domain'] . "'>" . $data['requested_domain'] . "</a>", $body);
        }
        if (array_key_exists('previous_domain', $data)) {
            $body = preg_replace("/{previous_domain}/", "<a href='http://" . $data['previous_domain'] . "'>" . $data['previous_domain'] . "</a>", $body);
        }
        if (array_key_exists('current_domain', $data)) {
            $body = preg_replace("/{current_domain}/", "<a href='http://" . $data['current_domain'] . "'>" . $data['current_domain'] . "</a>", $body);
        }
        if (array_key_exists('subdomain', $data)) {
            $body = preg_replace("/{subdomain}/", "<a href='http://" . $data['subdomain'] . "'>" . $data['subdomain'] . "</a>", $body);
        }
        if (array_key_exists('last_day_of_membership', $data)) {
            $body = preg_replace("/{last_day_of_membership}/", $data['last_day_of_membership'], $body);
        }
        if (array_key_exists('login_link', $data)) {
            $body = preg_replace("/{login_link}/", $data['login_link'], $body);
        }
        if (array_key_exists('customer_name', $data)) {
            $body = preg_replace("/{customer_name}/", $data['customer_name'], $body);
        }
        if (array_key_exists('verification_link', $data)) {
            $body = preg_replace("/{verification_link}/", $data['verification_link'], $body);
        }
        if (array_key_exists('website_title', $data)) {
            $body = preg_replace("/{website_title}/", $data['website_title'], $body);
        }

        if (session()->has('lang')) {
            $currentLang = Language::query()->where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::query()->where('is_default', 1)->first();
        }

        $be = $currentLang->basic_extended;


        if (empty($be->smtp_host) || empty($be->smtp_port) || empty($be->encryption) || empty($be->smtp_username) || empty($be->smtp_password)) {
            return back();
        }

        if ($be->is_smtp == 1) {
            try {
                $smtp = [
                    'transport' => 'smtp',
                    'host' => $be->smtp_host,
                    'port' => $be->smtp_port,
                    'encryption' => $be->encryption,
                    'username' => $be->smtp_username,
                    'password' => $be->smtp_password,
                    'timeout' => null,
                    'auth_mode' => null,
                ];
                Config::set('mail.mailers.smtp', $smtp);
            } catch (\Exception $e) {
                Session::flash('error', $e->getMessage());
                return back();
            }
        }

        try {

            Mail::send([], [], function (Message $message) use ($data, $be, $body, $temp) {
                $fromMail = $be->from_mail;
                $fromName = $be->from_name;
                $message->to($data['toMail'])
                    ->subject($temp->email_subject)
                    ->from($fromMail, $fromName)
                    ->html($body, 'text/html');
                if (array_key_exists('membership_invoice', $data)) {
                    $message->attach(public_path('assets/front/invoices/') . $data['membership_invoice']);
                }
            });

            // Attachments
            if (array_key_exists('membership_invoice', $data)) {
                @unlink(public_path('assets/front/invoices/') . $data['membership_invoice']);
            }
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return back();
        }
    }

    public function mailToAdmin($data)
    {
        $be = BasicExtended::query()->first();

        if (empty($be->smtp_host) || empty($be->smtp_port) || empty($be->encryption) || empty($be->smtp_username) || empty($be->smtp_password)) {
            return back();
        }

        if ($be->is_smtp == 1) {
            try {
                $smtp = [
                    'transport' => 'smtp',
                    'host' => $be->smtp_host,
                    'port' => $be->smtp_port,
                    'encryption' => $be->encryption,
                    'username' => $be->smtp_username,
                    'password' => $be->smtp_password,
                    'timeout' => null,
                    'auth_mode' => null,
                ];
                Config::set('mail.mailers.smtp', $smtp);
            } catch (\Exception $e) {
                Session::flash('error', $e->getMessage());
                return back();
            }
        }
        try {

            Mail::send([], [], function (Message $message) use ($data, $be) {
                $fromMail = $be->from_mail;
                $fromName = $be->from_name;
                $message->to($be->to_mail)
                    ->subject($data['subject'])
                    ->from($fromMail, $fromName)
                    ->html($data['body'], 'text/html');
                if (array_key_exists('attachments', $data)) {
                    $message->addAttachment(public_path('assets/front/invoices/') . $data['attachments']); // Add 
                }
            });
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return back();
        }
    }

    public function mailFromUser($data, $order, $user)
    {

        $temp = MailTemplate::query()
            ->where([
                ['mail_type', '=', $data['templateType']],
                ['user_id', '=', $user->id],
            ])
            ->first();

        $body = $temp->mail_body;


        if (array_key_exists('username', $data)) {
            $body = preg_replace("/{username}/", $data['username'], $body);
        }
        if (array_key_exists('password', $data)) {
            $body = preg_replace("/{password}/", $data['password'], $body);
        }
        if (array_key_exists('order_number', $data)) {
            $body = preg_replace("/{order_number}/", $data['order_number'], $body);
        }
        if (array_key_exists('order_link', $data) && $order->customer_id) {

            $body = preg_replace("/{order_link}/", $data['order_link'], $body);
            $body = preg_replace("/{text}/", "Please click on the below link to see your order details.", $body);
        } else {

            $body = preg_replace("/{order_link}/", '', $body);
            $body = preg_replace("/{text}/", '', $body);
        }
        if (array_key_exists('customer_name', $data)) {
            $body = preg_replace("/{customer_name}/", $data['customer_name'], $body);
        }
        if (array_key_exists('verification_link', $data)) {
            $body = preg_replace("/{verification_link}/", $data['verification_link'], $body);
        }
        if (array_key_exists('password_reset_link', $data)) {
            $body = preg_replace("/{password_reset_link}/", $data['password_reset_link'], $body);
        }
        if (array_key_exists('website_title', $data)) {
            $body = preg_replace("/{website_title}/", $data['website_title'], $body);
        }

        if (session()->has('lang')) {
            $currentLang = Language::query()->where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::query()->where('is_default', 1)->first();
        }

        $be = $currentLang->basic_extended;


        if (empty($be->smtp_host) || empty($be->smtp_port) || empty($be->encryption) || empty($be->smtp_username) || empty($be->smtp_password)) {
            return back();
        }

        $userClang = $this->getUserCurrentLanguage($user);
        $package = LimitCheckerHelper::currentMembershipPackage($user->id);
        $packageArray = $package->toArray();
        $userBs = $userClang->basic_setting;
        $userBe = $userClang->basic_extended;

        if ($be->is_smtp == 1) {
            try {
                $smtp = [
                    'transport' => 'smtp',
                    'host' => $be->smtp_host,
                    'port' => $be->smtp_port,
                    'encryption' => $be->encryption,
                    'username' => $be->smtp_username,
                    'password' => $be->smtp_password,
                    'timeout' => null,
                    'auth_mode' => null,
                ];
                Config::set('mail.mailers.smtp', $smtp);
            } catch (\Exception $e) {
                dd($e);
            }
        }

        try {

            Mail::send([], [], function (Message $message) use ($data, $body, $temp, $be, $userBs, $userBe, $packageArray) {
                $fromMail = $be->from_mail;
                $fromName = $userBe->from_name;
                $message->to($data['toMail'])
                    ->subject($temp->mail_subject)
                    ->from($fromMail, $fromName)
                    ->replyTo($userBe->from_mail, $userBe->from_name)
                    ->html($body, 'text/html');

                if (array_key_exists('attachment', $data)) {
                    $directory = public_path(Constant::WEBSITE_PRODUCT_INVOICE) . '/';
                    $path = $directory . $data['attachment'];
                    // Attachments (Invoice)
                    if (in_array('Amazon AWS s3', $packageArray) && !is_null($userBs->aws_access_key_id) && !is_null($userBs->aws_secret_access_key) && !is_null($userBs->aws_default_region) && !is_null($userBs->aws_bucket)) {
                        setAwsCredentials($userBs->aws_access_key_id, $userBs->aws_secret_access_key, $userBs->aws_default_region, $userBs->aws_bucket);
                        $s3 = Storage::disk('s3');
                        if ($s3->exists($path)) {
                            if (!file_exists($directory)) {
                                if (!mkdir($directory, 0755, true)) {
                                    die('Failed to create folders...');
                                }
                            }
                            touch($path);
                            copy($s3->url($path), $path);
                        }
                    }

                    $message->attach($path);
                  
                }

                // Attachments
                if (array_key_exists('attachment', $data)) {
                    $directory = public_path(Constant::WEBSITE_PRODUCT_INVOICE) . '/';
                    $path = $directory . $data['attachment'];
                    //remove copied aws file from local storage
                    if (in_array('Amazon AWS s3', $packageArray) && !is_null($userBs->aws_access_key_id) && !is_null($userBs->aws_secret_access_key) && !is_null($userBs->aws_default_region) && !is_null($userBs->aws_bucket)) {
                        setAwsCredentials($userBs->aws_access_key_id, $userBs->aws_secret_access_key, $userBs->aws_default_region, $userBs->aws_bucket);
                        $s3 = Storage::disk('s3');
                        if ($s3->exists($path)) {
                            @unlink($path);
                        }
                    }
                    Session::flash("success", "The order information was sent to your email.");
                    return;
                }
            });
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return;
        }
    }
    public function mailToOwner($data, $email)
    {
        $be = BasicExtended::query()->first();

        if (empty($be->smtp_host) || empty($be->smtp_port) || empty($be->encryption) || empty($be->smtp_username) || empty($be->smtp_password)) {
            return back();
        }

        $userClang = $this->getUserCurrentLanguage(getUser());
        $userBs = $userClang->basic_setting;
        $userBe = $userClang->basic_extended;

        if ($be->is_smtp == 1) {
            try {
                $smtp = [
                    'transport' => 'smtp',
                    'host' => $be->smtp_host,
                    'port' => $be->smtp_port,
                    'encryption' => $be->encryption,
                    'username' => $be->smtp_username,
                    'password' => $be->smtp_password,
                    'timeout' => null,
                    'auth_mode' => null,
                ];
                Config::set('mail.mailers.smtp', $smtp);
            } catch (\Exception $e) {
                Session::flash('error', $e->getMessage());
                return back();
            }
        }
        try {

            Mail::send([], [], function (Message $message) use ($data, $be, $email, $userBs) {
                $fromMail = $be->from_mail;
                $fromName = $userBs->from_name;
                $message->to($email)
                    ->subject($data['subject'])
                    ->from($fromMail, $fromName)
                    ->html($data['body'], 'text/html');
                if (array_key_exists('attachments', $data)) {
                    $message->attach(public_path('assets/front/invoices/') . $data['attachments']); // Add attachments
                }
            });

            Mail::send([], [], function (Message $message) use ($data, $be, $userBe, $userBs) {
                $fromMail = $be->from_mail;
                $fromName = $userBs->from_name;
                $toMail = $userBe->from_mail;
                $message->to($toMail)
                    ->subject($data['subject'])
                    ->from($fromMail, $fromName)
                    ->html($data['body'], 'text/html');
                if (array_key_exists('attachments', $data)) {
                    $message->attach(public_path('assets/front/invoices/') . $data['attachments']); // Add attachments
                }
            });
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return back();
        }
    }
    public function mailContactMessage($data)
    {
        if (session()->has('lang')) {
            $currentLang = Language::query()->where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::query()->where('is_default', 1)->first();
        }
        $be = $currentLang->basic_extended;

        $userClang = $this->getUserCurrentLanguage(getUser());
        $userBs = $userClang->basic_setting;
        $userBe = $userClang->basic_extended;

        if (empty($be->smtp_host) || empty($be->smtp_port) || empty($be->encryption) || empty($be->smtp_username) || empty($be->smtp_password)) {
            return back();
        }

        if ($be->is_smtp == 1) {
            try {

                $smtp = [
                    'transport' => 'smtp',
                    'host' => $be->smtp_host,
                    'port' => $be->smtp_port,
                    'encryption' => $be->encryption,
                    'username' => $be->smtp_username,
                    'password' => $be->smtp_password,
                    'timeout' => null,
                    'auth_mode' => null,
                ];
                Config::set('mail.mailers.smtp', $smtp);
            } catch (\Exception $e) {
                Session::flash('error', $e->getMessage());
                return back();
            }
        }

        try {

            Mail::send([], [], function (Message $message) use ($data, $be, $userBe, $userBs) {
                $fromMail = $be->from_mail;
                $fromName = $data['fullname'] ?? $userBs->from_name;
                $message->to($userBe->from_mail)
                    ->subject($data['subject'])
                    ->replyTo($data['email'])
                    ->from($fromMail, $fromName)
                    ->html($data['body'], 'text/html');
            });
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return back();
        }
    }
}
