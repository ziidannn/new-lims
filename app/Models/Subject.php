<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'name',
        'subject_code'
    ];

    public function institute()
    {
        return $this->belongsToMany(Institute::class, 'institute_subjects', 'subject_id', 'institute_id');
    }
    public function result()
    {
        return $this->hasMany(Result::class, 'subject_id', 'id');
    }
    public function instituteSampleDescriptions()
    {
        return $this->hasMany(InstituteSubject::class, 'subject_id');
    }
}
