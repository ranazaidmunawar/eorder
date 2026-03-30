<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Admin;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class ForgetController extends Controller
{
    public function mailForm() {
        return view('admin.forget');
    }

    public function sendmail(Request $request) {
        // check whether the mail exists in database
        $request->validate([
            'email' => [
                'required',
                function ($attribute, $value, $fail) {
                    $count = Admin::where('email', $value)->count();
                    if ($count == 0) {
                        $fail("The email address doesn't exist");
                    }
                }
            ]
        ]);

        // change the password with newly created random password
        $pass = uniqid();
        $admin = Admin::where('email', $request->email)->first();
        $admin->password = bcrypt($pass);
        $admin->save();

        // send the random (newly created) & username to the mail
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $be = $currentLang->basic_extended;
        $from = $be->from_mail;
        $to = $request->email;
        $subject = "Restore Password & Username";
        $username = $admin->username;


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
                
                $body    = "<h4>Hello $username,</h4><div><p><strong>Your current username:</strong> $username</p><p><strong>Your new password:</strong>$pass</p></div>";

                Mail::send([], [], function (Message $message) use ($from, $be, $to, $subject,$body) {
                    $fromMail = $from;
                    $fromName = $be->from_name;
                    $message->to($to)
                        ->subject($subject)
                        ->from($fromMail, $fromName)
                        ->html($body, 'text/html');
                });

            } catch (\Exception $e) {
                dd($e);
            }
        } else {
            try {

                $body    = "<h4>Hello $username,</h4><div><p><strong>Your current username:</strong> $username</p><p><strong>Your new password:</strong>$pass</p></div>";

                Mail::send([], [], function (Message $message) use ($from, $be, $to, $subject, $body) {
                    $fromMail = $from;
                    $fromName = $be->from_name;
                    $message->to($to)
                        ->subject($subject)
                        ->from($fromMail, $fromName)
                        ->html($body, 'text/html');
                });
               
            } catch (\Exception $e) {
                dd($e);
            }
        }

        Session::flash('success', 'New password & current username sent successfully via mail');
        return back();
    }
}
