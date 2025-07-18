<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstituteSubject extends Model
{
    use HasFactory;
    protected $table = 'institute_subjects';
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'institute_id',
        'subject_id',
    ];

    public function samplings()
    {
        return $this->hasMany(Sampling::class, 'institute_subject_id');
    }
    public function institute()
    {
        return $this->belongsTo(Institute::class, 'institute_id');
    }
    public function Subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id','id', 'name');
    }
    public function instituteRegulations()
    {
        return $this->hasMany(InstituteRegulation::class, 'institute_subject_id');
    }
    public function regulations()
    {
        return $this->belongsToMany(Regulation::class, 'institute_regulations', 'institute_subject_id', 'regulation_id');
    }
}
