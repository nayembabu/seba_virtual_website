<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SimConversion extends Model
{
    protected $table = 'sim_conversions';

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
        'note',
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