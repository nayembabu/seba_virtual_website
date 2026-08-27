<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoudiSonod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'nationality', 'passport_no', 'certificate_no', 
        'worker_no', 'type', 'issue_date', 'expiry_date'
    ];

    protected $dates = ['issue_date', 'expiry_date'];
}