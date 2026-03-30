<?php

namespace App\Http\Middleware;

use App\Http\Helpers\UserPermissionHelper;
use Closure;
use Illuminate\Support\Facades\Session;

class PackageHasPermission
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
      
        $user = getUser();
        $permissions = UserPermissionHelper::packagePermission($user->id);
        if (!empty($user)) {
            $permissions = json_decode($permissions, true);
            if (!in_array($permission, $permissions)) {
                session()->flash('error', 'Currently Not Available');
                return redirect()->route('user.front.index',getParam());
            }
        }
        return $next($request);
    }
}
