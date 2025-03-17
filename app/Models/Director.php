<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    use HasFactory;
    protected $table = 'directors';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'name',
        'ttd',
    ];
}
