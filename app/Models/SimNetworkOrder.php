<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimNetworkOrder extends Model
{
    use HasFactory;

    protected $table = 'sim_network_orders';

    protected $fillable = [
        'user_id',
        'form_data',
        'form_type_name',
        'type',
        'status',
        'reject_note',
        'admin_note',
        'text',
        'cost',
        'is_money_back',
    ];

    protected $casts = [
        'form_data' => 'array',
        'cost' => 'decimal:2',
        'is_money_back' => 'boolean',
    ];

    /**
     * Get the user that owns the order
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the service name based on type
     */
    public function getServiceNameAttribute()
    {
        $services = [
            1 => 'কল লিস্ট ৩ মাস',
            2 => 'রবি/এয়ারটেল SMS লিস্ট',
            3 => 'বাংলালিংক/গ্রামীন SMS লিস্ট',
            4 => 'নাম্বার টু লোকেশন',
            5 => 'NID টু সকল নাম্বার',
            6 => 'IMEI টু লোকেশন',
            7 => 'IMEI টু এক্টিভ নাম্বার',
            8 => 'নাম্বার টু IMEI',
            9 => 'বিকাশ ইনফরমেশন',
            10 => 'নগদ ইনফরমেশন',
            11 => 'রকেট ইনফরমেশন',
        ];

        return $services[$this->type] ?? 'N/A';
    }

    /**
     * Get the status name
     */
    public function getStatusNameAttribute()
    {
        $statuses = [
            0 => 'অপেক্ষমান',
            1 => 'প্রক্রিয়াধীন',
            2 => 'সম্পন্ন',
            3 => 'বাতিল',
        ];

        return $statuses[$this->status] ?? 'N/A';
    }

    /**
     * Get the service cost based on type
     */
    public function getServiceCostAttribute()
    {
        $costs = [
            1 => 100,
            2 => 80,
            3 => 80,
            4 => 50,
            5 => 150,
            6 => 120,
            7 => 120,
            8 => 100,
            9 => 200,
            10 => 200,
            11 => 200,
        ];

        return $costs[$this->type] ?? 0;
    }
}
