<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'style_number',
        'price',
        'sale_price',
        'sizes',
        'colors',
        'description',
        'designer_id',
    ];

    public function designer()
    {
        return $this->belongsTo(Designer::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'price')->withTimestamps();
    }
}
