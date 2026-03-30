<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class PagePolicy
{
    use HandlesAuthorization;

    public function view(User $user, $page)
    {
        if (is_null($user->admin_id)) {
            return $user->id == $page->user_id;
        } else {
            return $user->admin_id == $page->user_id;
        }
    }

}
