<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PassportSearchHistory extends Model
{
    protected $table = 'passport_search_histories';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'passport_no',
        'applicant_name',
        'passport_type',
        'thana',
        'charged_amount',
        'api_response',
        'created_at',
    ];

    protected $casts = [
        'charged_amount' => 'decimal:2',
        'api_response' => 'array',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
