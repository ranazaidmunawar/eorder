<?php

namespace App\Http\Controllers\User\Auth;

use App\Models\Seo;
use App\Models\User;
use App\Models\Language;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Helpers\MegaMailer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Traits\UserCurrentLanguageTrait;
use Illuminate\Support\Facades\Password;
use App\Models\User\Language as UserLang;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    use UserCurrentLanguageTrait;
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return
     */
    public function showLinkRequestForm()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['seo'] = Seo::where('language_id', $currentLang->id)->first();
        return view('front.auth.passwords.email', $data);
    }

    public function sendResetLinkEmail(Request $request)
    {
       
        if (
            User::query()
            ->where('email', '=', $request->email)
            ->count() > 0
        ) {
            // user found
            $user = User::query()
                ->where('email', '=', $request->email)
                ->first();
            $currentLang = $this->getUserCurrentLanguage($user);
            $bs = $currentLang->basic_setting;

            $pass_token = Str::random(30);
            $input['pass_token'] = $pass_token;
            $user->update($input);
            $forgetLinkRoute = route('user.reset.password.form', ['pass_token' => $user->pass_token]);
            $btn = "<a href='$forgetLinkRoute'>Please click this link to create a new password.</a>";
      
            $mailer = new MegaMailer();
            $data = [
                'toMail' => $user->email,
                'toName' => $user->username,
                'customer_name' => $user->username,
                'password_reset_link' => $btn,
                'templateType' => 'reset_password',
                'website_title'=> $bs->website_title,
                'type' => 'reset_password'
            ];
            $mailer->mailFromUser($data, $user, $user);
            Session::flash('success', 'New password create link sent successfully via mail');
        } else {
            // user not found
            Session::flash('error', 'No Account Found With This Email.');
        }
        return back();
    }

    public function passwordCreateForm()
    {

        return view('front.auth.passwords.reset');
    }
    public function createNewPassword(Request $request)
    {

        $rules = [
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ];

        $messages = [
            'password_confirmation.same' => 'The password confirmation does not match.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $renter = User::where('pass_token', $request->pass_token)->first();

        if ($renter) {

            $renter->password = bcrypt($request->password);
            $renter->pass_token = null;
            $renter->save();
            return back()->with('success', 'New password created successfully');
        }
        
        session()->flash('link_error', 'This link has expired. Please request it again.');
        return back();
    }
}
