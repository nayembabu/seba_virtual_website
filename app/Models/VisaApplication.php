<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisaApplication extends Model
{
    protected $table = 'visa_applications';
    
    // Disable timestamps since the table doesn't have updated_at column
    public $timestamps = false;
    
    protected $fillable = [
        'user_id',
        'visa_number',
        'full_name',
        'date_of_birth',
        'citizenship',
        'passport_number',
        'travel_document_type',
        'passport_issue_date',
        'passport_expiry_date',
        'visa_type',
        'visa_validity',
        'number_of_entries',
        'period_of_stay',
        'invitation',
        'visa_issue_date',
        'profile_photo'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}