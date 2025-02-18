<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COA extends Model
{
    use HasFactory;
    protected $table = 'ambient_airs';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'auditee_id',
        'date_start',
        'date_end',
        'audit_status_id',
        'location_id',
        'department_id',
        'auditor_id',
        'periode',
        'type_audit',
        'remark_standard_lpm',
        'head_major',
        'upm_major',
    ];
}
