<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    
    public function view(User $user, User $model)
    {
       return $user->id == $model->id;
    }

    public function editview(User $user, User $model)
    {
        return $user->id == $model->admin_id;
    }

}
