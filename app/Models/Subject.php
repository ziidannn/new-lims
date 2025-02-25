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

    protected $fillable = ['name'];

    public function institute()
    {
        return $this->belongsToMany(Institute::class, 'institute_subjects', 'subject_id', 'institute_id');
    }
    public function resume()
    {
        return $this->hasMany(Resume::class, 'subject_id', 'id');
    }
    public function instituteSampleDescriptions()
    {
        return $this->hasMany(InstituteSubject::class, 'subject_id');
    }
}
