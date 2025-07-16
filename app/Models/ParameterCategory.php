<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterCategory extends Model
{
    use HasFactory;
    protected $table = 'parameter_categories';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'name',
    ];
    public function parameters()
    {
        return $this->hasMany(Parameter::class, 'parameter_category_id', 'id');
    }
}
