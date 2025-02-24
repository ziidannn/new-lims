<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstituteSampleDescription extends Model
{
    use HasFactory;
    protected $table = 'institute_sample_descriptions';
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'institute_id',
        'sample_description_id',
    ];

    public function institute()
    {
        return $this->belongsTo(Institute::class, 'institute_id');
    }
    public function sampleDescription()
    {
        return $this->belongsTo(SampleDescription::class, 'sample_description_id','id');
    }
}
