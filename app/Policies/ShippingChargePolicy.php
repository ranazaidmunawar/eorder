<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User\ShippingCharge;
use App\Models\User;

class ShippingChargePolicy
{
    use HandlesAuthorization;

   
    public function view(User $user,  $shippingCharge)
    {
        if (is_null($user->admin_id)) {
            return $user->id == $shippingCharge->user_id;
        } else {
            return $user->admin_id == $shippingCharge->user_id;
        }
    }
}
