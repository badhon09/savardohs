<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;
    public $table = '004_user_type_info';

    protected $fillable = [
        'u_type_name',
        'u_type_name_bn',
        'created_by',
        'updated_by',
    ];
}
