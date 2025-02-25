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
        'name_parameter',
        'sampling_id',
        'sampling_time',
        'testing_result',
        'regulation',
        'unit',
        'method',
        'regulation_id',
        'noise',
        'leq',
        'ls',
        'lm',
        'lsm'
    ];

    public function regulation()
    {
        return $this->belongsTo(Regulation::class, 'regulation_id');
    }
    public function sampling()
    {
        return $this->belongsTo(Sampling::class, 'sampling_id');
    }
}
