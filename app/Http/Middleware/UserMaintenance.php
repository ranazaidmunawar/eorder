<?php

namespace App\Http\Middleware;

use App\Models\User\BasicSetting;
use Closure;


class UserMaintenance
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
        $user = getUser();
        $bs = BasicSetting::query()->where('user_id',$user->id)->first();
        $maintenanceStatus = $bs->maintenance_mode;
        $token = $bs->bypass_token;

        if ($maintenanceStatus == 1) {
            if (session()->has('user-bypass-token') && session()->get('user-bypass-token') == $token) {
                return $next($request);
            }
            $data['userBs'] = $bs;
            return response()->view('errors.user-503', $data);
        }
        return $next($request);
    }
}
