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
        'id',
        'no_sample',
        'date',
        'time',
        'method',
        'date_received',
        'interval_testing_date',
        'sample_description_id'
    ];
}

