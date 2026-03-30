<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $rootUser = getRootUser();
        if($rootUser->status != 1){
            Auth::guard('web')->logout();
            if(is_null(Auth::guard('web')->user()->admin_id)){
                Session::flash('error','Your account has been banned!');
                return redirect(route('front.index'));
            }else{
                Session::flash('error','Your owner account has been banned!');
                return redirect(route('renter.login',getParam()));
            }
        }
        return $next($request);
    }
}
