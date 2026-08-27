<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnMake extends Model
{
    protected $table = 'return_makes';

    protected $fillable = [
        'tin',
        'name',
        'father_name',
        'mother_name',
        'circle',
        'zone',
        'current_address',
        'permanent_address',
        'assessment_year',
        'nid',
        'total_income',
        'paid_tax',
        'return_serial_no',
        'submission_date',
        'user_id',
        'service_fee',
        'status',
    ];

    protected $casts = [
        'submission_date' => 'date',
        'total_income' => 'decimal:2',
        'paid_tax' => 'decimal:2',
        'service_fee' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
