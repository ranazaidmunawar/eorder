<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class SocialPolicy
{
    use HandlesAuthorization;

   
    public function view(User $user, $social)
    {
        if (is_null($user->admin_id)) {
            return $user->id == $social->user_id;
        } else {
            return $user->admin_id == $social->user_id;
        }
    }

   
}
