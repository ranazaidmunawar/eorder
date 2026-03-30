<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class PsubCategoryPolicy
{
    use HandlesAuthorization;

    public function view(User $user,$psubCategory)
    {
        if (is_null($user->admin_id)) {
            return $user->id == $psubCategory->user_id;
        } else {
            return $user->admin_id == $psubCategory->user_id;
        }
    }

}
