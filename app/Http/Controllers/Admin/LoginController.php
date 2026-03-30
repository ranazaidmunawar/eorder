<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(): View
    {
        return view('admin.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $request->validate([
            'username'   => 'required',
            'password' => 'required'
        ]);
        
        if (Auth::guard('admin')->attempt(['username' => $request->username,'password' => $request->password]))
        {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->with('alert','Username and Password Not Matched');
    }

    public function logout(): RedirectResponse
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
