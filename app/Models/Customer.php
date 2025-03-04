<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'name',
        'contact_name',
        'email',
        'phone',
        'address'
    ];
}
