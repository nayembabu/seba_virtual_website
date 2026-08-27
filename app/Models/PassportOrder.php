<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PassportOrder extends Model
{
    // Status constants
    const STATUS_PENDING = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_CANCELLED = 3;
    
    protected $table = 'passport_orders';
    
    protected $casts = [
        'form_data' => 'array',
        'cost' => 'decimal:2',
        'is_money_back' => 'boolean',
    ];

    protected $fillable = [
        'user_id',
        'form_type',
        'form_type_name',
        'form_data',
        'status',
        'admin_note',
        'text',
        'reject_note',
        'cost',
        'is_money_back'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get status as string
     */
    public function getStatusStringAttribute()
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELLED => 'Cancelled',
            default => 'Unknown'
        };
    }
}