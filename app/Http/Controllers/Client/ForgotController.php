<?php

namespace App\Http\Controllers\Client;


use App\Models\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Helpers\MegaMailer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Traits\UserCurrentLanguageTrait;
use Illuminate\Support\Facades\Validator;


class ForgotController extends Controller
{
    use UserCurrentLanguageTrait;

    public function __construct(){}

    public function showForgotForm()
    {
        return view('user-front.client.forgot');
    }

    public function forgot(Request $request)
    {
        $user = getUser();
        $request->validate([
            'email' => 'required'
        ]);
        // Validation Starts
        $currentLang = $this->getUserCurrentLanguage($user);
      
        $bs = $currentLang->basic_setting;

        if (Client::query()
                ->where('email', '=', $request->email)
                ->where('user_id', $user->id)
                ->count() > 0) {
            // user found
            $client = Client::query()
                ->where('email', '=', $request->email)
                ->where('user_id', $user->id)
                ->first();

            $pass_token = Str::random(30);

            $client->pass_token = $pass_token;
            $client->save();

            $forgetLinkRoute = route('client.create.password.form', ['pass_token' => $client->pass_token, getParam()]);
            $btn = "<a href='$forgetLinkRoute'>Please click this link to create a new password.</a>";

            $mailer = new MegaMailer();
            $data = [
                'toMail' => $request->email,
                'toName' => $client->fname . ' ' . $client->lname,
                'customer_name' => $client->fname . ' ' . $client->lname,
                'password_reset_link' => $btn,
                'website_title' => $bs->website_title ?? '',
                'templateType' => 'reset_password',
                'type' => 'reset_password'
            ];
            $mailer->mailFromUser($data, $user->id, $user);

            Session::flash('success', 'New password create link sent successfully via mail');
            return back();
        } else {
            // user not found
            Session::flash('err', 'No Account Found With This Email.');
            return back();
        }
    }
    public function passwordCreateForm()
    {

        return view('user-front.client.create_password_form');
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

        $Client = Client::where('pass_token', $request->pass_token)->first();

        if ($Client) {

            $Client->password = bcrypt($request->password);
            $Client->pass_token = null;
            $Client->save();
            return back()->with('success', 'New password created successfully');
        }
        session()->flash('link_error', 'This link has expired. Please request it again.');
        return back();
    }
}
