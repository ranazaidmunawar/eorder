<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User\Gallery;
use App\Models\User;

class GalleryPolicy
{
    use HandlesAuthorization;

    public function view(User $user, $gallery)
    {
        if (is_null($user->admin_id)) {
            return $user->id == $gallery->user_id;
        } else {
            return $user->admin_id == $gallery->user_id;
        }
    }

}
