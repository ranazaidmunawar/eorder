<?php

namespace App\Policies;

use App\Models\User;
use App\Models\User\Language;
use Illuminate\Auth\Access\HandlesAuthorization;

class PcategoryPolicy
{
    use HandlesAuthorization;

    public function view(User $user, $pCategory)
    {
        if(is_null($user->admin_id)){
            return $user->id == $pCategory->user_id;
        }else{
            return $user->admin_id == $pCategory->user_id;
        }
    }

    public function canview(User $user, $languageCode, $userId)
    {
        if (is_null($user->admin_id)) {
            return Language::where([
                ['code', $languageCode],
                ['user_id', $userId]
            ])->exists();
        } else {
            return Language::where([
                ['code', $languageCode],
                ['user_id', $user->admin_id]
            ])->exists();
        }
    }

}
