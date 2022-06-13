<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;
    public $table = '005_user_info';

    protected $fillable = [
        'user_name',
        'user_name_bn',
        'user_id',
        'user_type_id',
        'pin',
        'mobile_no',
        'email',
        'address',
        'city',
        'state',
        'postcode',
        'country',
        'created_by',
        'updated_by',
    ];
}
