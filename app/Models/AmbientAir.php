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
        'testing_result',
        'parameter_id',
        'note_id',
    ];
}
