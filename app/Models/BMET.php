<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BMET extends Model
{
    use HasFactory;

    protected $table = 'bmet'; // Specify the manually created table

    protected $fillable = [
        'photo',
        'name',
        'clearance_id',
        'clearance_date',
        'father_name',
        'mother_name',
        'bra_id',
        'employer',
        'country',
        'bmet_no',
        'passport_no',
        'p_issue_date',
        'p_expiry_date',
        'dob',
        'visa_no',
        'pdf_path',
        'qr_path',
        'token',
        'user_id',
        'job'
    ];

    public $timestamps = true; // Enable created_at & updated_at
}
