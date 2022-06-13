<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use DB;

class BillPaymentMaster extends Controller
{



    public function makePayment(Request $r){
	//return $r;
        $ID  = $r->id;
        $billChildId  = $r->billChildId;
        $billMonthId  = $r->billMonthId;
        $shopId  = $r->shopId;
        $revenueHeadId  = $r->revenueHeadId;
        $Amount  = $r->Amount;
        $currency  = $r->currency;

        if($Amount == '' || $Amount <= 0 || $ID == ''){
            return response()->json(['status'=>false,'token'=>'valid amount','pay_url'=>'']);
        }
        $headers = [
            'Content-Type' => 'application/json',
            'User-Agent' => 'PostmanRuntime/7.28.4',
            'Accept' => '*/*',
            'Accept-Encoding' => 'gzip, deflate, br',
            'Connection' => 'keep-alive',

        ];
       $getToken = Http::withHeaders($headers)->POST('https://engine.shurjopayment.com/api/get_token',['username'=>'ainigmatech','password'=>'ainidtjmtnxzyabv'])->json();
        //$getToken = Http::withHeaders($headers)->POST('https://sandbox.shurjopayment.com/api/get_token',['username'=>'sp_sandbox','password'=>'pyyk97hu&6u6'])->json();

	if(isset($getToken)){
            $invoice = 'INV-'.time();
            $getPayInit = Http::withHeaders($headers)->POST('https://engine.shurjopayment.com/api/secret-pay',
               [
                    'token'=>$getToken['token'],
                    'store_id'=>floatVal($getToken['store_id']),
		     //'store_id'=>1,
                    'prefix'=>'ATL',
                    'currency'=> $currency,
                    'return_url'=>"https://zit-solution.com/get-r-11722-status/",
                    'cancel_url'=>'https://zit-solution.com/get-r-11722-status-failed/',
                    'amount'=>floatVal($Amount),
                    'order_id'=>$invoice,
                    'discsount_amount'=>0,
                    'disc_percent'=>'',
                    'client_ip'=>'192.168.10.104',
                    'customer_name'=>'Syed Mostafa Jamal',
                    'customer_phone'=>'01713041428',
                    'customer_email'=>'',
                    'customer_address'=>'Uttora',
                    'customer_city'=>'Dhaka',
                    'customer_postcode'=>'',
                    'customer_country'=>'',
                    'value1'=>$billChildId,
                    'value2'=>$billMonthId,
                    'value3'=>'3',
                    'value4'=>'4',
                ]
            )->json();
            if(isset($getPayInit)){
                DB::beginTransaction();
                try {
                        $insertID = DB::table('102a_month_wise_payment_master')->insertGetId([
                            'bill_month_id'=>$billMonthId,
                            'bill_master_id'=>$ID,
                            'shop_id'=>$shopId,
                        ]);
                        DB::table('102b_month_wise_payment_child')->insert([
                            'payment_master_id'=>$insertID,
                            'service_head_id'=>$revenueHeadId,
                            'order_id'=>$getPayInit['sp_order_id'],
                            'bill_child_id'=>$billChildId,
                            'amount'=>floatVal($Amount),
                            'currency'=>$currency,
                            'invoice_no'=>$invoice,
                        ]);
                    DB::commit();
                    return response()->json(['status'=>true,'token'=>'valid token','pay_url'=>$getPayInit['checkout_url']]);
                }catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['status'=>false,'token'=>'valid token','pay_url'=>'','msg'=>$e->getMessage()]);
                }
            }else{
                return response()->json(['status'=>false,'token'=>'valid token','pay_url'=>'']);
            }
        }else{
            return response()->json(['status'=>false,'token'=>'valid token','pay_url'=>'']);
        }

    }



    public function PayableBillList(){
        return DB::table('101a_month_wise_bill_master')
            ->leftJoin('101b_month_wise_bill_child','101a_month_wise_bill_master.id','=','101b_month_wise_bill_child.bill_master_id')
            ->leftJoin('007_bill_month_info','101a_month_wise_bill_master.bill_month_id','=','007_bill_month_info.id')
            ->leftJoin('008_shop_info','101a_month_wise_bill_master.shop_id','=','008_shop_info.id')
            ->leftJoin('006_revenue_head','101b_month_wise_bill_child.revenue_head_id','=','006_revenue_head.id')
            ->leftJoin('002_revenue_source','008_shop_info.revenue_source_id','=','002_revenue_source.id')
            ->where('002_revenue_source.id','=',2)
            ->where('101b_month_wise_bill_child.payment_status','!=',1)
            ->select('101a_month_wise_bill_master.*','007_bill_month_info.bill_month','008_shop_info.shop_name','008_shop_info.shop_new_num','006_revenue_head.revenue_head_name','101b_month_wise_bill_child.id as bill_child_id','101b_month_wise_bill_child.revenue_head_id','101b_month_wise_bill_child.amount','101b_month_wise_bill_child.currency')
            ->get();
    }


	public function GetReturnStatusBack(Request $r){

		if($r->order_id != ''){
			$headers = [
            			'Content-Type' => 'application/json',
            			'User-Agent' => 'PostmanRuntime/7.28.4',
            			'Accept' => '*/*',
            			'Accept-Encoding' => 'gzip, deflate, br',
            			'Connection' => 'keep-alive',
        		];
			$getToken = Http::withHeaders($headers)->POST('https://engine.shurjopayment.com/api/get_token',['username'=>'ainigmatech','password'=>'ainidtjmtnxzyabv'])->json();
			$GetVerifyData = Http::withHeaders($headers)->POST('https://engine.shurjopayment.com/api/verification',['token'=>$getToken['token'],'order_id'=>$r->order_id])->json();
			$status = false;
            if(count($GetVerifyData) > 0){
		$data['sp_code'] = $GetVerifyData[0]['sp_code'];
		$data['order_id'] = $GetVerifyData[0]['order_id'];
		$data['currency'] = $GetVerifyData[0]['currency'];
		$data['amount'] = $GetVerifyData[0]['amount'];
		$data['phone_no'] = $GetVerifyData[0]['phone_no'];
		$data['invoice_no'] = $GetVerifyData[0]['invoice_no'];
		$data['sp_massage'] = $GetVerifyData[0]['sp_massage'];
		$data['method'] = $GetVerifyData[0]['method'];
		$data['date_time'] = $GetVerifyData[0]['date_time'];
		$data['bill_child_id'] = $GetVerifyData[0]['value1'];
		$data['bill_month_id'] = $GetVerifyData[0]['value2'];


                //return $data;                   
		$PayData = DB::table('102b_month_wise_payment_child')->where('order_id','=',$data['order_id'])->count();
		if($PayData > 0){
			DB::beginTransaction();
        try {
              DB::table('102b_month_wise_payment_child')->where('order_id','=',$data['order_id'])->update([
                'status_code'=>$data['sp_code'],
                'response_msg'=>$data['sp_massage'],
                'method'=>$data['method'],
              ]);
              DB::table('101b_month_wise_bill_child')->where('id','=',$data['bill_child_id'])->update([
                'payment_status'=>1
              ]);

 				      DB::commit();
              $data['status'] = true; 
              $data['status_msg'] = 'updated successfully'; 
              return $data;
        }catch(\Exception $e)
        {
              DB::rollback();
              $data['status'] = false; 
              $data['status_msg'] = $e->getMessage(); 
              return $data;
        }
}else{
        $data['status'] = false; 
        $data['status_msg'] = 'data not found'; 
        return $data;
}

            }

	}else{
		return ['status'=>false,'message'=>'valid'];
	}

	}




}
