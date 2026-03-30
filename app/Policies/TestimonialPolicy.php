<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class TestimonialPolicy
{
    use HandlesAuthorization;


    public function view(User $user, $testimonial)
    {
        if (is_null($user->admin_id)) {
            return $user->id == $testimonial->user_id;
        } else {
            return $user->admin_id == $testimonial->user_id;
        }
    }

   
}
