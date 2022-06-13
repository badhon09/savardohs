<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthWiseBillPaymentChild extends Model
{
    use HasFactory;
    public $table = '102b_month_wise_payment_child';

//    protected $fillable = [
//        'payment_master_id',
//        'revenue_head_id',
//        'bill_child_id',
//        'order_id',
//        'card_holder_name',
//        'card_number',
//        'amount',
//    ];
}
