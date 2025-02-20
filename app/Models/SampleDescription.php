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

    public function resumes()
    {
        return $this->belongsToMany(Resume::class, 'resume_sample_description', 'sample_description_id', 'resume_id');
    }
    public function resume()
    {
        return $this->hasMany(Resume::class, 'sample_description_id', 'id');
    }

    public function ambient()
    {
        return $this->hasMany(AmbientAir::class, 'sample_description_id', 'id');
    }
}
