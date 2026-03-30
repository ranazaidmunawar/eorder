<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Models\User;

class MailTemplatePolicy
{
    use HandlesAuthorization;

    public function view(User $user, $mailTemplate)
    {
        if (is_null($user->admin_id)) {
            return $user->id == $mailTemplate->user_id;
        } else {
            return $user->admin_id == $mailTemplate->user_id;
        }
    }

   
}
