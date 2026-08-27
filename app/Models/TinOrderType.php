<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TinOrderType extends Model
{
    protected $table = 'tin_orders_type';
    
    protected $fillable = [
        'name_bn',
        'code',
        'cost',
        'is_active'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'cost' => 'decimal:2',
    ];
}
