<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NidType extends Model
{
    protected $table = 'nid_types';
    
    protected $fillable = [
        'name_bn',
        'code',
        'cost',
        'is_active'
    ];

    protected $casts = [
        'cost'      => 'decimal:2',
        'is_active' => 'boolean',
    ];
}