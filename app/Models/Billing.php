<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;
    public $table = '002A_billing_dept';

    protected $fillable = [
        'revenue_source_id',
        'billing_dept_name',
        'billing_dept_name_bn',
        'created_by',
        'updated_by',
    ];
}
