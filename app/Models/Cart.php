<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'designer_id',

    ];
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity','color','size')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function designer(){
        return $this->belongsTo(Designer::class,'designer_id');
    }
}
