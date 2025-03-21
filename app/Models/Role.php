<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $guarded = ['id'];

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
