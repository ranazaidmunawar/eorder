<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class ReservationInputPolicy
{
    use HandlesAuthorization;

    
    public function view(User $user,$reservationInput)
    {
        if (is_null($user->admin_id)) {
            return $user->id == $reservationInput->user_id;
        } else {
            return $user->admin_id == $reservationInput->user_id;
        }
    }

   
}
