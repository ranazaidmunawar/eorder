<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffBanMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('POST') || $request->isMethod('PUT')) {
            if (Auth::guard('web')->check() && !is_null(Auth::guard('web')->user()->admin_id)) {
                $staff = User::where('id', Auth::guard('web')->user()->id)->first();
                if($staff->status == 0){
                    return response()->json('banStaff');
                }
            }
        }
        
        return $next($request);
    }
}
