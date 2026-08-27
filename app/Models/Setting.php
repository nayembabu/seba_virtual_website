<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    // Define the table associated with the model
    protected $table = 'settings';

    // Define the primary key of the table
    protected $primaryKey = 'id';

    // Define the fillable columns
    protected $fillable = [
        'name',
        'value',
    ];

    // Optionally, define any relationships or additional methods here
}
