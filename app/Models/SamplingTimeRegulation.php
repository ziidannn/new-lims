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

    public function regulationStandards()
    {
        return $this->belongsTo(RegulationStandard::class, 'regulation_standard_id', 'id');
    }
    public function result()
    {
        return $this->hasOne(Result::class, 'sampling_time_id', 'sampling_time_id')
                    ->whereColumn('parameter_id', 'parameter_id')
                    ->whereColumn('regulation_standard_id', 'regulation_standard_id');
    }
}
