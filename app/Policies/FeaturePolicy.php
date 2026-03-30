<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Models\User;

class FeaturePolicy
{
    use HandlesAuthorization;

    
    public function view(User $user, $feature)
    {
        if (is_null($user->admin_id)) {
            return $user->id == $feature->user_id;
        } else {
            return $user->admin_id == $feature->user_id;
        }
    }

}
