<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillMonth extends Model
{
    use HasFactory;
    public $table = '007_bill_cycle_info';

    protected $fillable = [
        'billing_dept_id',
        'bill_cycle_name',
        'bill_cycle_name_bn',
        'seq',
        'processed',
        'active_status',
        'created_by',
        'updated_by',
    ];
}
