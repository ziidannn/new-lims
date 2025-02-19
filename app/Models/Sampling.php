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
        'no_sample',
        'sampling_location',
        'sample_description_id',
        'date',
        'time',
        'method',
        'date_received',
        'itd_start',
        'itd_end'
    ];

    public function description()
    {
        return $this->belongsTo(SampleDescription::class, 'sample_description_id', 'id');
    }
}

