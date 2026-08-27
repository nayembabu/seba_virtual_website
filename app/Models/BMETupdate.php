<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BMETupdate extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bmet_update';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'token',
        'photo',
        'name',
        'clearance_id',
        'clearance_date',
        'father_name',
        'mother_name',
        'bra_id',
        'employer',
        'job',
        'country',
        'bmet_no',
        'passport_no',
        'p_issue_date',
        'p_expiry_date',
        'dob',
        'visa_no',
        'pdf_path',
        'qr_path'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'clearance_date' => 'date',
        'p_issue_date' => 'date',
        'p_expiry_date' => 'date',
        'dob' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the BMET update.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}