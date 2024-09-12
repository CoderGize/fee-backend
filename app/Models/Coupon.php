<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'promo_code',
        'discount_type',
        'discount_value',
        'min_order_amount',
        'count',
        'usage_limit',
        'active_status',
        'expires_at',
    ];

    /**
     * Check if the coupon is still valid.
     *
     * @return bool
     */
    public function isValid()
    {
        return $this->active_status && (!$this->expires_at || $this->expires_at->isFuture());
    }

    /**
     * Get the discount in a formatted way.
     *
     * @return string
     */
    public function getFormattedDiscountAttribute()
    {
        if ($this->discount_type === 'percentage') {
            return $this->discount_value . '%';
        }
        return '$' . number_format($this->discount_value, 2);
    }

    /**
     * Scope a query to only include active coupons.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active_status', 1)
                     ->where(function ($q) {
                         $q->whereNull('expires_at')
                           ->orWhere('expires_at', '>', Carbon::now());
                     });
    }

    /**
     * Get the formatted expiration date.
     *
     * @return string|null
     */
    public function getFormattedExpiresAtAttribute()
    {
        return $this->expires_at ? $this->expires_at->format('Y-m-d H:i:s') : null;
    }

    /**
     * Cast attributes to the correct types.
     *
     * @var array
     */
    protected $casts = [
        'expires_at' => 'datetime',
        'active_status' => 'boolean',
        'discount_value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
    ];
}
