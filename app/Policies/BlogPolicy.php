<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPolicy
{
    use HandlesAuthorization;

  

    public function view(User $user, $blog)
    {
        if (is_null($user->admin_id)) {
            return $user->id == $blog->user_id;
        } else {
            return $user->admin_id == $blog->user_id;
        }
    }


}
