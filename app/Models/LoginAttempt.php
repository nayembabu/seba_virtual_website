<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip_address',
        'login_time',
        'status',
    ];

    public $timestamps = false; // Disable automatic timestamps if you don't need created_at and updated_at columns
}

