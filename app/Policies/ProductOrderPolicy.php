<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User\ProductOrder as FrontProductOrder;
use App\Models\User;
use App\Models\Client;

class ProductOrderPolicy
{
    use HandlesAuthorization;

  
    public function view(User $user,  $productOrder)
    {
        if (is_null($user->admin_id)) {
            return $user->id == $productOrder->user_id;
        } else {
            return $user->admin_id == $productOrder->user_id;
        }
    }

    public function viewFront(Client $client, FrontProductOrder $FrontProductOrder)
    {
        return $client->id == $FrontProductOrder->customer_id;
    }

  
}
