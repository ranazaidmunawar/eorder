<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Traits\UserCurrentLanguageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;


class LoginController extends Controller
{
    use UserCurrentLanguageTrait;

    public function __construct(){
        $user = getUser();
        $currentLang = $this->getUserCurrentLanguage($user);
        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;

        Config::set('captcha.sitekey', $bs->google_recaptcha_site_key);
        Config::set('captcha.secret', $bs->google_recaptcha_secret_key);

        Config::set('services.facebook.client_id', $be->facebook_app_id);
        Config::set('services.facebook.client_secret', $be->facebook_app_secret);
        Config::set('services.facebook.redirect', route('user.client.facebook.callback',getParam()));

        Config::set('services.google.client_id', $be->google_client_id);
        Config::set('services.google.client_secret', $be->google_client_secret);
        Config::set('services.google.redirect', route('user.client.google.callback',getParam()));
    }

    public function showLoginForm()
    {
        if (str_contains(session()->get('link'), 'qr-menu')) {
            session()->forget('link');
        }
        return view('user-front.client.login');
    }

    public function login(Request $request)
    {
        //--- Validation Section
        $user = getUser();
        $currentLang = $this->getUserCurrentLanguage($user);

        $bs = $currentLang->basic_setting;

        $rules = [
            'email'   => 'required|email',
            'password' => 'required'
        ];

        if ($bs->is_recaptcha == 1) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }
        $messages = [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
        ];
        $request->validate($rules, $messages);
        //--- Validation Section Ends
        if (Session::has('link')) {
            $redirectUrl = Session::get('link');
            Session::forget('link');
        } else {
            $redirectUrl = route('user.client.dashboard',getParam());
        }

        // Attempt to log the user in
        if (Auth::guard('client')->attempt(['email' => $request->email, 'password' => $request->password,'user_id' => $user->id])) {

            // Check If Email is verified or not
            if (Auth::guard('client')->user()->email_verified == 'no' || Auth::guard('client')->user()->email_verified == 'No') {
                Auth::guard('client')->logout();

                return back()->with('err', __('Your Email is not Verified!'));
            }
            if (Auth::guard('client')->user()->status == '0') {
                Auth::guard('client')->logout();

                return back()->with('err', __('Your account has been banned'));
            }
            return redirect($redirectUrl);
        }
        // if unsuccessful, then redirect back to the login with the form data
        return back()->with('err', __("Credentials Does Not Match !"));
    }

    public function logout()
    {
        Auth::guard('client')->logout();
        return redirect()->route('user.front.index',getParam());
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        return $this->authUserViaProvider('facebook');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        return $this->authUserViaProvider('google');
    }

    public function authUserViaProvider($provider) {
        $rootUser = getUser();
        if (Session::has('link')) {
            $redirectUrl = Session::get('link');
            Session::forget('link');
        } else {
            $redirectUrl = route('user.client.dashboard',getParam());
        }

        $user = Socialite::driver($provider)->user();
        if ($provider == 'facebook') {
            $user = json_decode(json_encode($user), true);
        } elseif ($provider == 'google') {
            $user = json_decode(json_encode($user), true)['user'];
        }
        if ($provider == 'facebook') {
            $fname = $user['name'];
            $photo = $user['avatar'];
        } elseif ($provider == 'google') {
            $fname = $user['given_name'];
            $photo = $user['picture'];
        }
        $email = $user['email'];
        $provider_id = $user['id'];


        // retrieve user via the email
        $user = Client::query()
            ->where('email', $email)
            ->where('user_id', $rootUser->id)
            ->first();

        // if it doesn't exist, store the new user's info (email, name, avatar, provider_name, provider_id)
        if (empty($user)) {
            $user = new Client;
            $user->email = $email;
            $user->fname = $fname;
            $user->photo = $photo;
            $user->provider_id = $provider_id;
            $user->provider = $provider;
            $user->status = 1;
            $user->email_verified = 'Yes';
            $user->user_id = $rootUser->id;
            $user->save();
        }


        // authenticate the user
        Auth::guard('client')->login($user);

        // if user is banned
        if ($user->status == 0) {
            Auth::guard('client')->logout();
            if (str_contains($redirectUrl, 'qr-menu')) {
                return redirect(route('user.front.qrmenu.login',getParam()))->with('err', __('Your account has been banned'));
            } else {
                return redirect(route('user.client.login',getParam()))->with('err', __('Your account has been banned'));
            }
        }
        // if logged in successfully
        return redirect($redirectUrl);

    }

    public function secretLogin(Request $request)
    {
        $client = Client::where('id', $request->user_id)->first();

        if ($client) {
            Auth::guard('client')->login($client);
            return redirect()->route('user.client.dashboard', getParam())
                ->withSuccess('You have Successfully loggedin');
        } else {

            return redirect()->route('user.client.login', getParam())->withSuccess('Oppes! You have entered invalid credentials');
        }
    }
}
