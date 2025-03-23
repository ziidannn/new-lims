<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    protected $table = 'parameters';
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'name',
        'unit',
        'method',
        'subject_id'
    ];
    public function subjects()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
    public function samplingTimeRegulations()
    {
        return $this->hasMany(SamplingTimeRegulation::class, 'parameter_id', 'id');
    }
    public function samplingTime()
    {
        return $this->belongsToMany(SamplingTime::class, 'sampling_time_id');
    }
    public function regulationStandards()
    {
        return $this->belongsToMany(RegulationStandard::class, 'regulation_standard_id');
    }
}
