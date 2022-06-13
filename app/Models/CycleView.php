<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CycleView extends Model
{
    use HasFactory;
     public $table = 'view_cycle_list';
        protected $fillable = [
        'cycle_id',
        'bill_cycle_name',
    ];
}
