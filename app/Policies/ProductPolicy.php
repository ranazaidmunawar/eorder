<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User\Product;
use App\Models\User;

class ProductPolicy
{
    use HandlesAuthorization;

   
    public function view(User $user, $product)
    {
        if (is_null($user->admin_id)) {
            return $user->id == $product->user_id;
        } else {
            return $user->admin_id == $product->user_id;
        }
    }

}
