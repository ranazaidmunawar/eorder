<?php

namespace App\Http\Controllers\Admin;

use App\Rules\ImageMimeTypeRule;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Admin;

class ProfileController extends Controller
{
    protected string $path = 'assets/admin/img/propics';

    public function changePass(): View
    {
        return view('admin.profile.changepassword');
    }

    public function editProfile(): View
    {
        $admin = Admin::query()->findOrFail(Auth::guard('admin')->user()->id);
        return view('admin.profile.editprofile', ['admin' => $admin]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $admin = Admin::query()->findOrFail(Auth::guard('admin')->user()->id);
       $request->validate([
        'username' => [
            'required',
            'max:255',
            Rule::unique('admins')->ignore($admin->id)
        ],
        'email' => 'required|email|max:255',
        'first_name' => 'required|max:255',
        'last_name' => 'required|max:255',
        'profile_image' => new ImageMimeTypeRule(),
        ]);
        $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->first_name = $request->first_name;
        $admin->last_name = $request->last_name;
        if ($request->hasFile('profile_image')) {
            $admin->image = update_picture($this->path,$request->file('profile_image'),$admin->image);
        }
        $admin->save();
        Session::flash('success', 'Profile updated successfully!');
        return redirect()->back();
    }

    public function updatePassword(Request $request) {
        $messages = [
            'password.required' => 'The new password field is required',
            'password.confirmed' => "Password doesn't match"
        ];
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ], $messages);
        // if given old password matches with the password of this authenticated user...
        if(Hash::check($request->old_password, Auth::guard('admin')->user()->password)) {
            $oldPassMatch = 'matched';
        } else {
            $oldPassMatch = 'not_matched';
        }
        if ($validator->fails() || $oldPassMatch == 'not_matched') {
            if($oldPassMatch == 'not_matched') {
                $validator->errors()->add('oldPassMatch', true);
            }
            return redirect()->route('admin.change.password')
                ->withErrors($validator);
        }

        // updating password in database...
        $user = Admin::query()->findOrFail(Auth::guard('admin')->user()->id);
        $user->password = bcrypt($request->password);
        $user->save();
        Session::flash('success', 'Password changed successfully!');
        return redirect()->back();
    }
}
