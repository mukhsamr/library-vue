<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casts
    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => bcrypt($value)
        );
    }
}
