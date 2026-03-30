<?php

namespace App\Http\Middleware;

use App\Http\Helpers\UserPermissionHelper;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPackage
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
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            $package = UserPermissionHelper::currentPackage($user->id);
            if (empty($package)) {
                return redirect()->route('user.dashboard');
            }
        }
        return $next($request);
    }
}
