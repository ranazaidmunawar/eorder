<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Models\User;

class LanguagePolicy
{
    use HandlesAuthorization;

   
    public function view(User $user,$language)
    {
        if (is_null($user->admin_id)) {
            return $user->id == $language->user_id;
        } else {
            return $user->admin_id == $language->user_id;
        }
    }

    
}
