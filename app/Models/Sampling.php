<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sampling extends Model
{
    use HasFactory;
    protected $table = 'samplings';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'institute_id',
        'no_sample',
        'sampling_location',
        'institute_subject_id',
        'sampling_date',
        'sampling_time',
        'sampling_method',
        'date_received',
        'itd_start',
        'itd_end',
    ];

    public function description()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function instituteSubject()
    {
        return $this->belongsTo(InstituteSubject::class, 'sampling_id', 'id');
    }
    public function parameter()
    {
        return $this->belongsTo(Parameter::class, 'parameter_id', 'id');
    }

    // Relasi ke Regulations
    public function regulation()
    {
        return $this->belongsTo(Regulation::class, 'regulation_id', 'id');
    }
}

