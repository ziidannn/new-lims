<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegulationStandard extends Model
{
    use HasFactory;
    protected $table = 'regulation_standards';
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'title',
    ];

}
