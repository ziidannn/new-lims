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
    protected $fillable = [
        'customer',
        'address',
        'contact_name',
        'email',
        'phone',
        'sample_taken_by',
        'sample_receive_date',
        'sample_analysis_date',
        'report_date'
    ];

    public function Subjects()
    {
        return $this->belongsToMany(Subject::class, 'institute_subjects', 'institute_id', 'subject_id');
    }
    public function institute_subjects()
    {
        return $this->hasMany(InstituteSubject::class, 'institute_id');
    }
}
