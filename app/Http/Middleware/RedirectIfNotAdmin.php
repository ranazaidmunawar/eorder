<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAdmin
{
    public string $ADMIN_LOGIN_ROUTE = 'admin.login';
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, ?string $guard = 'admin')
    {
        if (!Auth::guard($guard)->check()) {
            return redirect($this->ADMIN_LOGIN_ROUTE);
        }
        return $next($request);
    }
}
