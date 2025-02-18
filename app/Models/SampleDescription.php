<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleDescription extends Model
{
    use HasFactory;
    protected $table = 'sample_descriptions';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'id',
        'name',
    ];
}
