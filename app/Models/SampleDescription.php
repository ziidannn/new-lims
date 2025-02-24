<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleDescription extends Model
{
    use HasFactory;

    protected $table = 'sample_descriptions';
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = ['name'];

    public function institute()
    {
        return $this->belongsToMany(Institute::class, 'institute_sample_descriptions', 'sample_description_id', 'institute_id');
    }
    public function resume()
    {
        return $this->hasMany(Resume::class, 'sample_description_id', 'id');
    }
}
