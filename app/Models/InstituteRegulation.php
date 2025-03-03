<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstituteRegulation extends Model
{
    use HasFactory;
    protected $table = 'institute_regulations';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'institute_id',
        'regulation_id',
    ];

    public function institute()
    {
        return $this->belongsTo(Institute::class, 'institute_id');
    }
    public function regulation()
    {
        return $this->belongsTo(Regulation::class, 'regulation_id','id');
    }
}
