<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SamplingTimeRegulation extends Model
{
    use HasFactory;
    protected $table = 'sampling_time_regulations';
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'parameter_id',
        'sampling_time_id',
        'regulation_standard_id'
    ];
    public function parameter()
    {
        return $this->belongsTo(Parameter::class, 'parameter_id', 'id');
    }

    public function samplingTime()
    {
        return $this->belongsTo(SamplingTime::class, 'sampling_time_id', 'id');
    }

    public function regulationStandard()
    {
        return $this->belongsTo(RegulationStandard::class, 'regulation_standard_id', 'id');
    }
}
