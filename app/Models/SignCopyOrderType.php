<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SignCopyOrderType extends Model
{
    protected $table = 'sign_copy_orders_type';
    
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
