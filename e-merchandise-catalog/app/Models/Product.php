<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'image', 'price', 'promo_price',
        'type', 'sizes', 'stock', 'category_id', 'tags', 'is_active', 'is_promo'
    ];

    protected $casts = [
        'sizes' => 'array',
        'tags' => 'array',
        'price' => 'decimal:2',
        'promo_price' => 'decimal:2',
        'stock' => 'integer',
        'is_active' => 'boolean',
        'is_promo' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function getFinalPriceAttribute()
    {
        return $this->is_promo && $this->promo_price ? $this->promo_price : $this->price;
    }

    public function getIsKaosAttribute()
    {
        return $this->type === 'kaos';
    }
}
