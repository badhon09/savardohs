<?php

namespace App\Models;

use App\Models\MonthWiseBillPaymentChild;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthWiseBillPaymentMaster extends Model
{
    use HasFactory;
    public $table = '102a_month_wise_payment_master';
    public function GetPaymentChild()
    {
        return $this->hasOne(MonthWiseBillPaymentChild::class,'payment_master_id','id')->where('status_code',1000)->where('realization_status',0);
    }
    protected $fillable = [
        'bill_cycle_id',
        'bill_master_id',
        'payment_type',
        'payment_date',
        'shop_id',
        'created_by',
        'updated_by',
    ];

}
