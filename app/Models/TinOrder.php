<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TinOrder extends Model
{
    protected $table = 'tin_orders';

    protected $casts = [
        'form_data' => 'object',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'cost' => 'decimal:2',
        'is_money_back' => 'boolean'
    ];

    protected $fillable = [
        'user_id',
        'form_data',
        'form_type_name',
        'type',
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
}
