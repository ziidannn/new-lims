<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    use HasFactory;
    protected $table = 'institutes';
    public $timestamps = true;
    public $incrementing = true;
    

        public function Subjects()
    {
        return $this->belongsToMany(Subject::class, 'institute_subjects', 'institute_id', 'subject_id');
    }
    public function Regulations()
    {
        return $this->belongsToMany(Regulation::class, 'institute_regulations', 'institute_id', 'regulation_id');
    }
    public function institute_subjects()
    {
        return $this->hasMany(InstituteSubject::class, 'institute_id');
    }

}
