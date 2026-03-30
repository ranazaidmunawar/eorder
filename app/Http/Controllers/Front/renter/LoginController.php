<?php

namespace App\Http\Controllers\Front\renter;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login(){
      return view('user-front.login');
    }

    public function authenticate(Request $request)
    {

     
      $user = getUser();
      $request->validate([
        'username'   => 'required',
        'password' => 'required'
      ]);
      
      $vendor = User::query()->where([
          ['username', $request->username],
          ['admin_id',$user->id]
      ])->first();

      if($vendor){

        if($vendor->status == 0){
            return redirect()->back()->with('alert','Your account is deactive. Please contact with owner');
        }

      if ($vendor->status == 1) {
        if(Hash::check($request->password, $vendor->password)){
           Auth::guard('web')->login($vendor);
          Session::put('login_url', route('renter.login', getParam()));
           return redirect()->route('user.dashboard');
        }else{
          return redirect()->back()->with('alert', 'Username and Password Not Matched');
        }
      }
      
      }else{
        return redirect()->back()->with('alert','Username and Password Not Matched');
      }
    }

    public function logout() {
      Auth::guard('web')->logout();
      return redirect()->route('renter.login');
    }
}
