<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class JobPolicy
{
    use HandlesAuthorization;

   
    public function view(User $user, $job)
    {
        if (is_null($user->admin_id)) {
            return $user->id == $job->user_id;
        } else {
            return $user->admin_id == $job->user_id;
        }
    }
}
