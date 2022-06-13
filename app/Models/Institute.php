<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    use HasFactory;
    public $table = '001_institute_info';

    protected $fillable = [
        'institute_name',
        'institute_name_bn',
        'logo',
        'address',
        'created_by',
        'updated_by',
    ];

}
