<?php

namespace App\Traits;

use App\Models\User\Language;

trait UserCurrentLanguageTrait
{
    public function getUserCurrentLanguage($user)
    {
     
        if (session()->has('user_lang')) {
            $lang = Language::query()
                ->where('code', session()->get('user_lang'))
                ->where('user_id', $user->id)
                ->first();
            if($lang){
                return  $lang;
            } else{
                return Language::query()
                ->where('user_id', $user->id)
                ->where('is_default', 1)
                ->first();
            }   
        } else {
            return Language::query()
                ->where('user_id', $user->id)
                ->where('is_default', 1)
                ->first();
        }
    }
}
