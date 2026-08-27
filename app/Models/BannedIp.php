<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannedIp extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'reason',
    ];

    protected $table = 'ip_bans'; // Specify the table name if it's not pluralized
}
