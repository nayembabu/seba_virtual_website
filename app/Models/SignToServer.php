<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class SignToServer extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('user', function (Builder $builder) {
            $builder->where('user_id', auth()->id());
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'user_id',
        'photo',
        'signature',
        'id_number',
        'pin_number',
        'name_bangla',
        'name_english',
        'date_of_birth',
        'place_of_birth',
        'father_name',
        'mother_name',
        'spouse_name',
        'education',
        'form_no',
        'voter_no',
        'serial_no',
        'voter_area',
        'father_id',
        'mother_id',
        'phone',
        'gender',
        'occupation',
        'blood_group',
        'religion',
        'present_address',
        'permanent_address',
        'address',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];
}
