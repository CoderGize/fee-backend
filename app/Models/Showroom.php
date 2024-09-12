<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'title_en',
        'title_ar',
        'img',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
