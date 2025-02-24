<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regulation extends Model
{
    use HasFactory;

    protected $table = 'regulations';
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'title',
        'sample_description_id'
    ];
    public function description()
    {
        return $this->belongsTo(SampleDescription::class, 'sample_description_id', 'id');
    }
}
