<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    public $table = '008_shop_info';

    public $filterable = [
        'id',
        'institute_master_id',
        'shop_name',
        'shop_name_bn',
        'shop_type_id',
        'shop_new_num',
        'shop_old_num',
        'pay_master_id',
    ];
    protected $fillable = [
        'institute_master_id',
        'shop_name',
        'shop_name_bn',
        'shop_type_id',
        'shop_new_num',
        'shop_old_num',
        'pay_master_id',
    ];

}
