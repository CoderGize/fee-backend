<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'tracking_number',
        'carrier',
        'name',
        'street_address',
        'street_address_line_2',
        'city',
        'state_or_province',
        'paid_status',
        'delivery_status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
