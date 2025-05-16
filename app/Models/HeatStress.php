<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeatStress extends Model
{
    use HasFactory;
    protected $table = 'heat_stresses';
    public $timestamps = true;
    protected $fillable = [
        'sampling_id',
        'sampling_location',
        'time',
        'humidity',
        'wet',
        'dew',
        'globe',
        'wbgt_index',
        'methods'
    ];

}
