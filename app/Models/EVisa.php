<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EVisa extends Model
{
    use HasFactory;

    protected $table = 'e_visas';

    protected $fillable = [
        'visa_id',
        'evisa_number',
        'ref_number',
        'issue_date',
        'expire_date',
        'place_of_issue',
        'remarks',
        'visa_fee',
        'gender',
        'full_name',
        'date_of_birth',
        'nationality',
        'travel_document',
        'travel_doc_no',
        'travel_doc_issue',
        'travel_doc_expiry',
        'image'
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expire_date' => 'date',
        'date_of_birth' => 'date',
        'travel_doc_issue' => 'date',
        'travel_doc_expiry' => 'date',
        'visa_fee' => 'decimal:2'
    ];
}
