<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\DateToWordsHelper;

class SscCertificate extends Model
{
    protected $casts = [
        'publication_date' => 'integer',
        'publication_year' => 'integer',
        'registration_year' => 'integer',
        'gpa' => 'float',
        'dob' => 'date',
    ];

    protected $fillable = [
        'user_id',
        'serial_no_dbs',
        'registration_no',
        'registration_year',
        'dbcsc_no',
        'student_name',
        'father_name',
        'mother_name',
        'school_name',
        'school_address',
        'roll_no',
        'student_group',
        'gpa',
        'dob',
        'dob_day_month_words',
        'dob_year_words',
        'publication_date',
        'publication_year',
    ];

    // Define relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setDobAttribute($value)
    {
        $this->attributes['dob'] = $value;

        if ($value) {
            $dateWords = DateToWordsHelper::convertDate($value);
            $this->attributes['dob_day_month_words'] = $dateWords['day_month'];
            $this->attributes['dob_year_words'] = $dateWords['year'];
        }
    }
}