<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin  extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    // fillable columns for admin
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'number'
    ];

    // admin __seller__ has many products
    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class); //Product Model Name
    }


    // *********** override methods for jwt interface *********** //
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
