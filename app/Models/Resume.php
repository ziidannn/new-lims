<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Resume extends Model
{
    use HasFactory;
    protected $table = 'resume_limses';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'id',
        'customer',
        'contact_name',
        'email',
        'phone',
        'sample_description_id',
        'sample_taken_by',
        'sample_receive_date',
        'sample_analysis_date',
        'report_date'
    ];
}
