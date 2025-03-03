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
        'subject_id'
    ];
    public function subjects()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
}
