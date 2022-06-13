<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopRateInfo extends Model
{
    use HasFactory;
    public $table = '009_shop_rate_info';

    protected $fillable = [
        'shop_id',
        'revenue_head_id',
        'amount',
        'currency',
        'created_by',
        'updated_by',
    ];
}
