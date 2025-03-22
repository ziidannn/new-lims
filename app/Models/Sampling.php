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
        'institute_subject_id',
        'no_sample',
        'sampling_location',
        'sampling_date',
        'sampling_time',
        'sampling_method',
        'date_received',
        'itd_start',
        'itd_end',
    ];

    public function institute()
    {
        return $this->belongsTo(Institute::class, 'institute_id');
    }
    public function description()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
    public function instituteSubject()
    {
        return $this->belongsTo(InstituteSubject::class, 'institute_subject_id');
    }
}

