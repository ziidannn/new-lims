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

    public function description()
    {
        return $this->belongsTo(SampleDescription::class, 'sample_description_id', 'id');
    }
}
