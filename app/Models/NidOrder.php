<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NidOrder extends Model
{
    protected $table = 'nid_orders';
    
    protected $fillable = [
        'form_type',
        'form_type_name',
        'name',
        'nid',
        'dob',
        'user_id',
        'email',
        'password',
        'status',
        'cost',
        'is_money_back',
        'rejection_reason',
        'rejection_notes'
    ];

    protected $casts = [
        'cost' => 'decimal:2',
        'is_money_back' => 'boolean',
    ];

    protected $dates = [
        'dob',
        'created_at',
        'updated_at'
    ];

    // Status constants
    const STATUS_PENDING = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_REJECTED = 3;

    // Form type constants
    const TYPE_NID_10_12_17 = 1;
    const TYPE_NID_FORM_REG = 2;
    const TYPE_USER_ID_PASS = 3;
    const TYPE_LOST_FORM = 4;

    public function getStatusTextAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_REJECTED => 'Rejected',
            default => 'Unknown'
        };
    }

    public function getFormTypeTextAttribute()
    {
        return match($this->form_type) {
            self::TYPE_NID_10_12_17 => '১০/১২/১৭ দিয়ে এনআইডি',
            self::TYPE_NID_FORM_REG => 'ফরম/নিবন্ধন নং/১৩ডিজিট দিয়ে এনআইডি',
            self::TYPE_USER_ID_PASS => 'ইউজার আইডি পাস সেট',
            self::TYPE_LOST_FORM => 'হারানো ফরম উত্তোলন',
            default => 'Unknown'
        };
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}