<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SamplingTime extends Model
{
    use HasFactory;
    protected $table = 'sampling_times';
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'time',
    ];

}
