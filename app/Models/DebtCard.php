<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebtCard extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'account_name',
        'bank',
        'account_number',
        'expiry_date'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
