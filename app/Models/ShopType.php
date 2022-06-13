<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopType extends Model
{
    use HasFactory;
    public $table = '003_shop_type_info';

    protected $fillable = [
        'revenue_source_id',
        'shop_type_name',
        'shop_type_name_bn',
        'created_by',
        'updated_by',
    ];
}
