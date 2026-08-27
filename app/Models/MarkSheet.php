<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarkSheet extends Model
{
    protected $fillable = [
        "user_id", "student_name", "father_name", "mother_name",
        "roll_no", "registration_no", "exam_name", "board",
        "year", "group_name", "institute_name", "gpa", "grade",
        "result", "subjects", "details",
    ];

    protected $casts = [
        "subjects" => "array",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}