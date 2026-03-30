<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class SliderPolicy
{
    use HandlesAuthorization;

    
    public function view(User $user, $slider)
    {
        if (is_null($user->admin_id)) {
            return $user->id == $slider->user_id;
        } else {
            return $user->admin_id == $slider->user_id;
        }
    }

}
