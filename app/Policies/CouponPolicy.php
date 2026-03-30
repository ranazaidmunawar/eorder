<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class CouponPolicy
{
    use HandlesAuthorization;

    public function view(User $user, $coupon)
    {
        if (is_null($user->admin_id)) {
            return $user->id == $coupon->user_id;
        } else {
            return $user->admin_id == $coupon->user_id;
        }
    }

   
}
