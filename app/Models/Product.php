<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // fillable columns for product
    protected $fillable = [
        'name',
        'image',
        'detail',
        'price',
        'discount',
        'rating',
        'amount',
        'views',
        'expiration',
        'date_1',
        'discount_1',
        'date_2',
        'discount_2',
        'date_3',
        'discount_3',
    ];

    // ****************** has many ****************** //
    // product has many reviews
    public function reviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Review::class);
    }

    // product has many discounts
    public function discounts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Discount::class)->orderBy('date');
    }

    // ****************** belongs to ****************** //
    // product belongs to one category
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // product belongs to one seller
    public function seller(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    // one product can belong to many users __cart functionality
    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_products');
    }
}
