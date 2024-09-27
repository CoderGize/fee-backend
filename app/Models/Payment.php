<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'designer_id',
        'order_id',
        'amount',
        'status',
        'payment_method',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function designer(){
        return $this->belongsTo(Designer::class,'designer_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
