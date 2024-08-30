<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_ar',
        'style_number',
        'price',
        'sale_price',
        'discount_percentage',
        'discount_status',
        'colors',
        'tags',
        'description',
        'description_ar',
        'designer_id',
        'subcategory_id',
    ];

    protected $casts = [
        'sizes' => 'array',
        'colors' => 'array',
        'tags' => 'array',
    ];

    public function designer()
    {
        return $this->belongsTo(Designer::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function subcategories()
    {
        return $this->belongsToMany(Subcategory::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'price')->withTimestamps();
    }


    public function getDiscountedPriceAttribute()
    {
        if ($this->discount_status && $this->discount_percentage) {
            return $this->price - ($this->price * ($this->discount_percentage / 100));
        }

        return $this->price;
    }
}
