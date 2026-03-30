<?php

namespace App\Http\Middleware;

use App\Http\Helpers\UserPermissionHelper;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckAdminHasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        // if the admin is logged in & he has a role defined then this check will be applied
        if (Auth::guard('web')->check()) {
            if (!is_null(Auth::guard('web')->user()->admin_id)){
            
                $roleBasedPermission = Auth::guard('web')->user()->role->permissions;
                $permissions = json_decode($roleBasedPermission, true);
                if (is_array($permissions) && !in_array($permission, $permissions)) {
                    session()->flash('warning', 'You do not have permission to perform this action');
                    return redirect()->route('user.dashboard');
                }elseif(is_null($permissions)){
                    session()->flash('warning', 'You do not have permission to perform this action');
                    return redirect()->route('user.dashboard');
                }
            }
        }
        return $next($request);
    }
}
