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
        'unit',
        'method',
        'regulation_id'
    ];
    public function regulation()
    {
        return $this->belongsTo(Regulation::class, 'regulation_id', 'id');
    }

    public function samplingTimeRegulations()
    {
        return $this->hasMany(SamplingTimeRegulation::class, 'parameter_id', 'id');
    }
}
