<?php

namespace App\Http\Controllers\Front\renter;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Helpers\MegaMailer;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ForgetController extends Controller
{
    public function mailForm(): View
    {
        return view('user-front.forget');
    }

    public function sendMail(Request $request): RedirectResponse
    {
        // check whether the mail exists in database
        $user = getUser();
        $request->validate([
            'email' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    $count = User::query()
                        ->where('email', $value)
                        ->where('admin_id',$user->id)
                        ->count();
                    if ($count == 0) {
                        $fail("The email address doesn't exist");
                    }
                }
            ]
        ]);
         $bs = User\BasicSetting::query()
             ->where('user_id',$user->id)
             ->select('website_title')
             ->first();

        $pass_token = Str::random(30);

        $renter = User::query()
            ->where('email', $request->email)
            ->where('admin_id',$user->id)
            ->first();
        $renter->pass_token = $pass_token;
        $renter->save();

        $forgetLinkRoute = route('renter.create.password.form', ['pass_token' => $renter->pass_token,getParam()]);
        $btn = "<a href='$forgetLinkRoute'>Please click this link to create a new password.</a>";

        $mailer = new MegaMailer();
        $data = [
            'toMail' => $request->email,
            'toName' => $renter->first_name.' '.$renter->last_name,
            'customer_name' => $renter->first_name.' '.$renter->last_name,
            'password_reset_link' => $btn,
            'website_title' => $bs->website_title ?? '',
            'templateType' => 'reset_password',
            'type' => 'reset_password'
        ];
        $mailer->mailFromUser($data, $user->id, $user);

        Session::flash('success', 'New password create link sent successfully via mail');
        return back();
    }

    public function passwordCreateForm()
    {

        return view('user.renter_create_password_form');
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
