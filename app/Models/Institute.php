<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    use HasFactory;
    public $timestamps = true;
    public $incrementing = true;
    protected $table = 'institutes';
    protected $fillable = [
        'no_coa',
        'direktur_id',
        'customer_id',
        'sample_receive_date',
        'sample_analysis_date',
        'report_date',
    ];

    public function Subjects()
    {
        return $this->belongsToMany(Subject::class, 'institute_subjects', 'institute_id', 'subject_id');
    }
    public function Regulations()
    {
        return $this->belongsToMany(Regulation::class, 'institute_regulations', 'institute_id', 'regulation_id');
    }
    public function instituteSubjects()
    {
        return $this->hasMany(InstituteSubject::class, 'institute_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
