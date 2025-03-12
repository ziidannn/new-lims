<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldCondition extends Model
{
    use HasFactory;
    protected $table = 'field_conditions';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'result_id',
        'coordinate',
        'temperature',
        'pressure',
        'humidity',
        'wind_speed',
        'wind_direction',
        'weather',
    ];
    public function result()
    {
        return $this->belongsTo(Result::class, 'result_id');
    }
}
