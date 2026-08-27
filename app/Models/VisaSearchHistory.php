<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisaSearchHistory extends Model
{
    protected $table = 'visa_search_histories';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'passport_no', 'visa_no', 'applicant_name',
        'country', 'charged_amount', 'api_response', 'created_at',
    ];

    protected $casts = [
        'charged_amount' => 'decimal:2',
        'api_response' => 'json',
        'created_at' => 'datetime',
    ];

    public function user() { return $this->belongsTo(User::class); }
}