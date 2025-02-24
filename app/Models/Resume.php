<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Resume extends Model
{
    use HasFactory;

    protected $table = 'resumes';
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'name_parameter',
        'sample_description_id',
        'sampling_time',
        'testing_result',
        'regulation',
        'unit',
        'method',
    ];

    public function sampleDescriptions()
    {
        return $this->belongsToMany(SampleDescription::class, 'institute_sample_descriptions', 'institute_id', 'sample_description_id');
    }
    public function description()
    {
        return $this->belongsTo(SampleDescription::class, 'sample_description_id', 'id');
    }
}

