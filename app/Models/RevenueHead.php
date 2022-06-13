<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevenueHead extends Model
{
    use HasFactory;
    public $table = '006_revenue_head';

    protected $fillable = [
        'revenue_source_id',
        'revenue_head_name',
        'revenue_head_name_bn',
        'calculated',
        'revenue_source_id1',
        'created_by',
        'updated_by',
    ];

}
