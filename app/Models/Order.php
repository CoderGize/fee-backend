<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'designer_id',
        'total_price',
        'discount',
        'status',
        'quantity',
        'payment_method',
        'on_cash',
        'is_guest',
        'guest_name',
        'guest_email',
        'guest_phone',
        'guest_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function designer(){
        return $this->belongsTo(Designer::class,'designer_id');
    }

     public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity','color','size', 'price');
    }

    public function shipment()
    {
        return $this->hasOne(Shipment::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
