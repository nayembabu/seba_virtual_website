<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCharge extends Model
{
    protected $table = 'service_charges';

    protected $fillable = [
        'service_name',
        'amount',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'status' => 'boolean',
    ];

    // ── Scopes ──────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    // ── Helper ──────────────────────────────────────────

    /**
     * Get the charge amount for a given service_name.
     * Returns 0 if the service doesn't exist or is inactive.
     */
    public static function getCharge(string $serviceName): float
    {
        $charge = static::where('service_name', $serviceName)
            ->where('status', 1)
            ->first();

        return $charge ? (float) $charge->amount : 0.0;
    }
}