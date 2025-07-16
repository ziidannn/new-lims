<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegulationStandardCategory extends Model
{
    use HasFactory;
    protected $table = 'regulation_standard_categories';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'parameter_id',
        'code',
        'value',
    ];
}
