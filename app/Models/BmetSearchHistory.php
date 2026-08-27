<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BmetSearchHistory extends Model
{
    protected $table = 'bmet_search_histories';
    
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'passport_no',
        'bmet_no',
        'applicant_name',
        'country',
        'charged_amount',
        'api_response',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'charged_amount' => 'decimal:2',
    ];
}
