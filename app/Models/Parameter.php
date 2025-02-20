<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    protected $table = 'parameters';
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'name',
        'sampling_time',
        'unit',
        'method',
    ];
}
