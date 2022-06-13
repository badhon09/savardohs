<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Revenue extends Model
{
    use HasFactory;
    public $table = '002_revenue_source';

    protected $fillable = [
        'institute_id',
        'revenue_head_name',
        'revenue_head_name_bn',
        'institute_info_id',
        'created_by',
        'updated_by',
    ];

    // public function UserInfo()
    // {
    //     return $this->hasOne(UserInfo::class,'revenue_source_id','id');
    // }

}
