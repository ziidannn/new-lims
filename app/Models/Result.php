<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $table = 'results';
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'sampling_id',
        'parameter_id',
        'sampling_time_id',
        'regulation_standard_id',
        'testing_result',
        'unit',
        'method',
        'time',
        'regulatory_standard',
        'noise',
        'leq',
        'ls',
        'lm',
        'lsm'
    ];

    public function parameter()
    {
        return $this->belongsTo(Parameter::class, 'parameter_id');
    }
    public function sampling()
    {
        return $this->belongsTo(Sampling::class, 'sampling_id');
    }
    public function result()
    {
        return $this->hasOne(Result::class, 'parameter_id', 'parameter_id');
    }
}
