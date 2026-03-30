<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User\Journal\BlogCategory;
use App\Models\User;

class BlogCategoryPolicy
{
    use HandlesAuthorization;

    
    public function view(User $user,$blogCategory)
    {
        if (is_null($user->admin_id)) {
            return $user->id == $blogCategory->user_id;
        } else {
            return $user->admin_id == $blogCategory->user_id;
        }
    }

   
}
