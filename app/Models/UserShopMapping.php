<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserShopMapping extends Model
{
    use HasFactory;
    public $table = '010_shop_user_mapping';
    protected $fillable = [
        'shop_id',
        'user_id',
        'u_type_id',
        'revenue_source_id',
        'created_by',
        'updated_by',
    ];
}
