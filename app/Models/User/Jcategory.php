<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jcategory extends Model
{
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }
}
