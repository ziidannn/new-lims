<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstituteSamplingLocation extends Model
{
    use HasFactory;
    protected $table = 'institute_sampling_locations';
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'institute_subject_id',
        'sampling_location'
    ];
}
