<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $table = 'user_roles';

    protected $fillable = [
        'user_id',
        'name',
        'permissions',
    ];

    public function admins(): HasMany
    {
        return $this->hasMany(User::class,'role_id');
    }
}
