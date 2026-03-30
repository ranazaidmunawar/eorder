<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login(){
      return view('user.login');
    }

    public function authenticate(Request $request){
      $this->validate($request, [
        'username'   => 'required',
        'password' => 'required'
      ]);
      if (Auth::guard('user')->attempt(['username' => $request->username,'password' => $request->password]))
      {
          return redirect()->route('user.dashboard');
      }
      return redirect()->back()->with('alert','Username and Password Not Matched');
    }

    public function logout() {
        if(is_null(Auth::guard('web')->user()->admin_id)){
            Auth::guard('web')->logout();
            return redirect()->route('user.login');
        }
        else{
            $redirect_url = Session::get('login_url');
            Auth::guard('web')->logout();
            return  redirect()->to($redirect_url);
        }
    }
}
