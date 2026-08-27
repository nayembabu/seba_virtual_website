<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $fillable = [
        'code',
        'usage_limit',
        'times_used',
        'promo_amount',
        'promo_type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        // Add other field casts here
    ];

    // Example method: check if the promo code is still active
    public function isActive(): bool
    {
        return $this->is_active;
    }

    // Example method: increase the times the promo code has been used
    public function incrementTimesUsed(): void
    {
        $this->times_used++;
        $this->save();
    }

    // Add other custom methods as needed
}
