<?php

namespace App\Http\Controllers\Client;

use App\Http\Helpers\MegaMailer;
use App\Models\Client;
use App\Traits\UserCurrentLanguageTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    use UserCurrentLanguageTrait;

    public function __construct(){}

    public function registerPage()
    {
        
        return view('user-front.client.register');
    }

    public function register(Request $request)
    {
        
        $user = getUser();
        $currentLang = $this->getUserCurrentLanguage($user);

        $bs = $currentLang->basic_setting;

        $messages = [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
        ];

        $rules = [
            'username' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) use ($user) {
                    if (Client::query()
                            ->where('username', $value)
                            ->where('user_id', $user->id)
                            ->count() > 0
                    ) {
                        $fail('Username has already been taken');
                    }
                }
            ],
            'email' => ['required', 'email', 'max:255', function ($attribute, $value, $fail) use ($user) {
                if (Client::query()
                        ->where('email', $value)
                        ->where('user_id', $user->id)
                        ->count() > 0
                ) {
                    $fail('Email has already been taken');
                }
            }],
            'password' => 'required|confirmed'
        ];

        if ($bs->is_recaptcha == 1) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        $request->validate($rules, $messages);

        $client = new Client;
        $input = $request->all();
        $input['status'] = 1;
        $input['password'] = bcrypt($request['password']);
        $token = md5(time() . $request->name . $request->email);
        $input['verification_link'] = $token;
        $input['user_id'] = $user->id;
        $client->fill($input)->save();

        $link = '<a href=' . route('user.client.register.token', [getParam(),'token' => $token]) . '>Click Here</a>';
        $mailer = new MegaMailer();
        $data = [
            'toMail' => $client->email,
            'toName' => $client->username,
            'username' => $client->username,
            'verification_link' => $link,
            'website_title' => $bs->website_title,
            'templateType' => 'verify_email',
            'type' => 'emailVerification'
        ];
        $mailer->mailFromUser($data,$user->id,$user);

        return back()->with('sendmail', 'We need to verify your email address. We have sent an email to  ' . $request->email . ' to verify your email address. Please click link in that email to continue.');
    }


    public function token(Request $request, $domain, $token)
    {
        $user = Client::where('verification_link', $token)->first();
        if ($user->email_verified == 'Yes') {
            return view('errors.user-404');
        }
        if (isset($user)) {
            $user->email_verified = 'Yes';
            $user->update();
            Auth::guard('client')->login($user);
            Session::flash('success', 'Email Verified Successfully');
            return redirect()->route('user.client.dashboard',getParam());
        }
    }
}
