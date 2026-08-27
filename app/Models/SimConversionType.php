<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SimConversionType extends Model
{
    protected $table = 'sim_conversions_type';
    
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
