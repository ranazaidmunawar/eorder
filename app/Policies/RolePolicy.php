<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User\Role;
use App\Models\User;

class RolePolicy
{
    use HandlesAuthorization;

   
    public function view(User $user, $role)
    {
        if (is_null($user->admin_id)) {
            return $user->id == $role->user_id;
        } else {
            return $user->admin_id == $role->user_id;
        }
    }

}
