<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class MemberPolicy
{
    use HandlesAuthorization;

    
    public function view(User $user, $member)
    {
        if (is_null($user->admin_id)) {
            return $user->id == $member->user_id;
        } else {
            return $user->admin_id == $member->user_id;
        }
    }

}
