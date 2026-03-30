<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Language;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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

        
        $admin = Admin::where('email', $request->email)->first();
        $pass_token = Str::random(30). $admin->username;
        $admin->token = $pass_token;
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

        $forgetLinkRoute = route('admin.create.pasword.form',['pass_token'=> $admin->token]);
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

                $body    = "<h4>Hello $username,</h4><div><p><strong>Your current username:</strong> $username</p><p><strong><a href='$forgetLinkRoute'>Please click this link to create a new password.</a></strong></p></div>";

                Mail::send([], [], function (Message $message) use ($be, $subject, $username,$to, $body) {
                    $fromMail = $be->from_mail;
                    $fromName = $username;
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

                //Recipients
                $body    = "<h4>Hello $username,</h4><div><p><strong>Your current username:</strong> $username</p><p><a href='$forgetLinkRoute'>Please click this link to create a new password.</a></p></div>";

                Mail::send([], [], function (Message $message) use ($be, $subject, $username, $to, $body) {
                    $fromMail = $be->from_mail;
                    $fromName = $username;
                    $message->to($to)
                        ->subject($subject)
                        ->from($fromMail, $fromName)
                        ->html($body, 'text/html');
                });
            } catch (\Exception $e) {
                dd($e);
            }
        }

        Session::flash('success', 'New password create link sent successfully via mail');
        return back();
    }

    public function passwordCreateForm()
    {
      
        return view('admin.create_password_form');
    }
    public function createNewPassword(Request $request)
    {


        $rules = [
            'password' => 'required|min:5',
            'password_confirmation' => 'required|same:password',
        ];

        $messages = [
            'password_confirmation.same' => 'The password confirmation does not match.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $admin = Admin::where('token', $request->pass_token)->first();
        if($admin){

            $admin->password = bcrypt($request->password);
            $admin->token = null;
            $admin->save();
            return back()->with('success','New password created successfully');
        }
        session()->flash('link_error', 'This link has expired. Please request it again.');
        return back();

    }
}
