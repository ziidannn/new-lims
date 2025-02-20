<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmbientAir extends Model
{
    use HasFactory;
    protected $table = 'ambient_airs';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
            'name_parameter',
            'sample_description_id',
            'sampling_time',
            'testing_result',
            'regulation',
            'unit',
            'method',
    ];

    public function description()
    {
        return $this->belongsTo(SampleDescription::class, 'sample_description_id', 'id');
    }
}
