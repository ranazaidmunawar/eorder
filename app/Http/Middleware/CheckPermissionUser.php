<?php

namespace App\Http\Middleware;

use App\Http\Helpers\UserPermissionHelper;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckPermissionUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // CheckPermissionUser.php

    public function handle($request, Closure $next, ...$permissions)
    {
        // if the admin is logged in & he has a role defined then this check will be applied
        if (Auth::guard('web')->check()) {
            $user = getRootUser();
            $userPermissions = UserPermissionHelper::packagePermission($user->id);

            if (!empty($user)) {
                $userPermissions = json_decode($userPermissions, true);

                $hasPermission = false;
                foreach ($permissions as $permission) {
                    if (in_array($permission, $userPermissions)) {
                        $hasPermission = true;
                        break;
                    }
                }

                if (!$hasPermission) {
                    session()->flash('warning', 'Your package does not have permission to access this resource');
                    return redirect()->route('user.dashboard');
                }
            }
        }

        return $next($request);
    }


    
}
