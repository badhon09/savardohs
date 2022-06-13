<?php

namespace App\Http\Controllers\Shop\BillGenerate;

use App\Http\Controllers\Controller;
use App\Models\RevenueHead;
use App\Models\ShopRateInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class MonthWiseBillController extends Controller
{
    public function index(){
        $breadcrumbs = [
            ['link' => "bill-generate/month-wise-bill-list", 'name' => "Month Wise Bill"], ['name' => "List"]
        ];
        return view('content.shop.bill-generate.month-wise-bill',['action'=>'list','breadcrumbs' => $breadcrumbs]);
    }
    public function create(Request $r){
        if($r->submit != 'Generate'){
            $qty = 10;
            if($r->qty){
                $qty = $r->qty;
            }
            $userData = Auth::user();
            $data['BillMonthList'] = DB::table('007_bill_cycle_info')->where('billing_dept_id',$userData->billing_dept_id)->where('processed',0)->where('active_status',1)->get();
            if($r->cycle_id != ''){
                $billList = DB::table('shop_wise_gen-bill_rate')->paginate($qty);
                $DataList = collect($billList);
                $data['totalAmount'] = DB::table('shop_wise_gen-bill_rate')->sum('rate');
                $data['ProcessDataList'] =  $DataList['data'];
                $data['links'] = $DataList['links'];
            }else{
                $data['ProcessDataList'] = [];
                $data['links'] = [];
            }
            return view('content.shop.bill-generate.month-wise-bill-genarate',$data);

        }else{

            return $this->GenerateBill($r);
        }

    }

    public function GenerateBill($r){
//        return $r;
        $userData = Auth::user();
        $cycleID = $r->cycle_id;
        $curency = 'BDT';
        //AND `bd`.`id` = 1
        $dataList = DB::table('shop_wise_gen-bill_rate')->where('billing_dept_id',$userData->billing_dept_id)->get();
        $shopWiseData = collect($dataList)->groupBy('shop_id');

        $PenaltyRate =  DB::table('009a_various_rate_info')->where('id',7)->first();
           if(!$PenaltyRate){
               session()->flash('server_error', 'Penalty Rate Not Found');
               return redirect()->to('bill-generate/month-wise-bill-create');
           }

        DB::beginTransaction();
        try{
            $headers = [
                'Content-Type' => 'application/json',
                'User-Agent' => 'PostmanRuntime/7.28.4',
                'Accept' => '*/*',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Connection' => 'keep-alive',
            ];

                $id = DB::table('101a_month_wise_bill_master')->insertGetId([
                    'billing_dept_id'=>$userData->billing_dept_id,
                    'bill_cycle_id'=>$cycleID,
                    'issue_date'=>Date('Y-m-d',strtotime($r->issue_date)),
                    'due_date'=>Date('Y-m-d',strtotime($r->due_date)),
                    'currency'=>$curency,
                    'created_by'=>$userData->id,
                ]);
                foreach($shopWiseData as $i=>$row){
                    $totalSum = collect($row)->sum('rate');

                    if($PenaltyRate->is_percent == 0){
                        $billAfterPenalty = $totalSum*$PenaltyRate->rate;
                        $panaltyAmount = 0;
                    }
                    elseif($PenaltyRate->is_percent == 1){
                        $panaltyAmount = $totalSum*$PenaltyRate->rate/100;
                        $billAfterPenalty = $panaltyAmount+$totalSum;
                    }
                    else{
                        $billAfterPenalty = $totalSum+$PenaltyRate->rate;
                        $panaltyAmount = $PenaltyRate->rate;
                    }
                    if($totalSum == 0){
                        $panaltyAmount = 0;
                    }
                    $childId = DB::table('101b_month_wise_bill_child')->insertGetId([
                        'bill_master_id'=>$id,
                        'shop_id'=>$i,
                        'total_amount'=>$totalSum,
                        'billing_name'=>$r->bill_name,
                        'penalty'=>$panaltyAmount,
                        'total_bill_after_penalty'=>$billAfterPenalty,
                        'payment_status'=>0,
                        'created_by'=>$userData->id,
                    ]);
                    foreach($row as $head){
                        $rate = $head->rate;
                        if(!$rate){
                            $rate = 0;
                        }
                        DB::table('101b1_month_wise_bill_child_revenue')->insert([
                            'bill_child_id'=>$childId,
                            'revenue_head_id'=>$head->rev_head_id,
                            'amount'=>$rate,
                            'payment_status'=>0,
                            'created_by'=>$userData->id,
                        ]);
                    }
                }
            $CycleStatus = DB::table('007_bill_cycle_info')->where('id',$cycleID)->update(['processed'=>1]);
            DB::commit();
//
//            foreach($this->TotalShopList as $item){
//                if($item[0]['mobile_no'] != ''){
//                    $msg = 'Your have a new bill for '.$item[0]['shop_new_num'].'. Bill Cycle Name '.$item[0]['revenue_head_name'].' '.$item[0]['bill_cycle_name'];
//                    Http::withHeaders($headers)->get('https://api.sms.net.bd/sendsms',
//                        [
//                            "api_key"=>'F4AmXa3ihYwlZb2yH7uF7u8cA25FbHjCY4z1Jv7v',
//                            'msg'=> "$msg",
//                            'to'=>$item[0]['mobile_no'],
//                        ]);
//                }
//            }
//            $this->isSubmit['status'] = true;
//            $this->isSubmit['message'] = 'Data Inserted Successfully';
//            $this->isSubmit['viewmode'] = true;

            session()->flash('server_message', 'Bill Generated successfully.');
            return redirect('bill-generate/month-wise-bill-create');
        }
        catch(\Exception $e){
//            $this->isSubmit['status'] = false;
//            $this->isSubmit['message'] = $e->getMessage();
//            $this->isSubmit['viewmode'] = false;
//            $this->ProccessDataAction();
            DB::rollback();
            return $e->getMessage();
            session()->flash('server_error', $e->getMessage());
            return redirect()->to('bill-generate/month-wise-bill-create');
        }
    }


    public function OpeningBalanceByDepartment(Request $request){
        $userData = Auth::user();
        $ShopTypeData = DB::table('101a_month_wise_bill_master as bm')
            ->leftJoin('101b_month_wise_bill_child as bc','bm.id','=','bc.bill_master_id')
            ->leftJoin('008_shop_info as shop','bc.shop_id','=','shop.id')
            ->leftJoin('101b1_month_wise_bill_child_revenue as bcr','bc.id','=','bcr.bill_child_id')
            ->leftJoin('006_revenue_head as rh','bcr.revenue_head_id','=','rh.id')
            ->where('bill_cycle_id',3)
            ->select('bc.id as bc_id','bcr.id as bcr_id','bc.shop_id','bcr.revenue_head_id','shop.shop_new_num','rh.revenue_head_name','bc.total_amount','bc.penalty','bc.total_bill_after_penalty','bcr.revenue_head_id','bcr.amount')
            ->get();
        
        $billChildList1  = collect($ShopTypeData)->groupBy('bc_id');    
        $dataCount  = count($billChildList1);
        $data['dataCount'] = $dataCount;        
        if (isset($request->page)) {  
            $page=$request->page;
            $take=10;          
            $skip=($page-1)*$take;                       
            $billChildList  = $billChildList1->slice($skip)->take($take);           
            $data['billChildList'] = $billChildList;                        
            return view('content.shop.bill-generate.opening_balance_by_department',$data);
        }        
        $billChildList  = $billChildList1->slice(0)->take(10);       
        $data['billChildList'] = $billChildList;       
        return view('content.shop.bill-generate.opening_balance_by_department',$data);
    }
    
    public function OpeningBalanceByDepartmentUpdate(Request $r){
        $bcId = $r->bc_id;
        $bcrId = $r->bcr_id;
        $amount = $r->amount;
        $total_amount = $r->total_amount;
        $penalty = $r->penalty;
        $total_bill_after_penalty = $r->total_bill_after_penalty;
        $bcIdCount = count($r->bc_id);

        for($i= 0;$i<$bcIdCount;$i++){
            DB::table('101b_month_wise_bill_child')->where('id',$bcId[$i])->update([
                'total_amount'=>$total_amount[$i],
                'penalty'=>$penalty[$i],
                'total_bill_after_penalty'=>$total_bill_after_penalty[$i],
            ]);
            DB::table('101b1_month_wise_bill_child_revenue')->where('id',$bcrId[$i])->update([
                'amount'=>$amount[$i],
            ]);
        }
        return redirect('opening-balance-by-department')->with('server_message','Data Updated Successfully');

    }
}
