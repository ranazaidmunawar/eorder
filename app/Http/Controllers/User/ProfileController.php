<?php

namespace App\Http\Controllers\User;

use App\Constants\Constant;
use App\Models\User;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function changePass() {
      return view('user.profile.changepass');
    }

    public function editProfile() {
      $user = User::query()->findOrFail(Auth::guard('web')->user()->id);
      return view('user.profile.editprofile', ['user' => $user]);
    }

    public function updateProfile(Request $request)
    {
      $request->validate([
        'username' => [
            'required',
            'max:255',
            Rule::unique('users')->ignore(Auth::guard('web')->user()->id)
        ],
        'email' => 'required|email|max:255',
        'restaurant_name' => 'required|max:255',
        'address' => 'required|max:255',
        'profile_image' => new ImageMimeTypeRule()
      ]);

      $user = User::query()->findOrFail(Auth::guard('web')->user()->id);
      $user->username = $request->username;
      $user->email = $request->email;
      $user->restaurant_name = $request->restaurant_name;
      $user->address = $request->address;

      if ($request->hasFile('profile_image'))
      {
          $user->image = update_picture(Constant::WEBSITE_TENANT_USER_IMAGE,$request->file('profile_image'),$user->image);
      }
      $user->save();
      Session::flash('success', 'Profile updated successfully!');
      return redirect()->back();
    }

    public function updatePassword(Request $request) {
      $messages = [
          'password.required' => 'The new password field is required',
          'password.confirmed' => "Password does'nt match"
      ];
      $validator = Validator::make($request->all(), [
          'old_password' => 'required',
          'password' => 'required|confirmed'
      ], $messages);
      // if given old password matches with the password of this authenticated user...
      if(Hash::check($request->old_password, Auth::guard('web')->user()->password)) {
          $oldPassMatch = 'matched';
      } else {
          $oldPassMatch = 'not_matched';
      }
      if ($validator->fails() || $oldPassMatch=='not_matched') {
          if($oldPassMatch == 'not_matched') {
            $validator->errors()->add('oldPassMatch', true);
          }
          return redirect()->route('user.change.password')
                      ->withErrors($validator);
      }

      // updating password in database...
      $user = User::query()->findOrFail(Auth::guard('web')->user()->id);
      $user->password = bcrypt($request->password);
      $user->save();

      Session::flash('success', 'Password changed successfully!');

      return redirect()->back();
    }
}
