<?php

namespace App\Http\Controllers;

use App\Models\BillCycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShopOpeningBalance extends Controller
{
    public function opening_balance_by_Shop(Request $request){
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"], ['name' => "Opening-balance-by-Flat"]
        ];
        $revenue_source_id = Auth::user()->revenue_source_id; 
        $billing_dept_id = Auth::user()->billing_dept_id;        
        $isBillGenerated = DB::table('007_bill_cycle_info')->where('billing_dept_id',$billing_dept_id)->where('active_status',1)->get();
        if(count($isBillGenerated)>0){       
            return view('content.opening_balance_by_shop')->with(compact('isBillGenerated'));
        }else{
            $shoplist = DB::table('008_shop_info')
                        ->leftJoin('002A_billing_dept','008_shop_info.revenue_source_id','=','002A_billing_dept.revenue_source_id')
                        ->select(
                            '008_shop_info.*',
                            '002A_billing_dept.id as billing_dept_id'
                        )
                        ->where('008_shop_info.revenue_source_id',$revenue_source_id)
                        ->where('002A_billing_dept.id',$billing_dept_id)
                        ->where('008_shop_info.shutter_type',0)
                        ->whereNotNull('pay_master_id')
                        ->get();

            $shopDetails=[];
            $shopOwnerDetails=[];
            $rate=[];
            $billcycleExist=[];
            $billCyclelist=[];
            $billcycleNotExist=[];

            if(isset($request->shop_id)){            
                $shop_id = $request->shop_id;
                $shopDetails = DB::table('008_shop_info')
                                    ->leftJoin('003_shop_type_info','008_shop_info.shop_type_id','=','003_shop_type_info.id')
                                    ->select(
                                        '008_shop_info.*',
                                        '003_shop_type_info.shop_type_name',
                                    )
                                    ->where('008_shop_info.id',$shop_id)
                                    ->first();
                $shopOwnerDetails = DB::select("SELECT shopowner.user_name AS ownerName, tenant.user_name AS tenantName, paymaster.user_name AS paymasterName, shopowner.mobile_no AS ownerMobile,
                tenant.mobile_no AS tenantMobile, paymaster.mobile_no AS paymasterMobile FROM ( SELECT ui.user_name, ui.mobile_no, sum.shop_id AS shopowner_shopID
                FROM `005_user_info` AS `ui` LEFT JOIN `010_shop_user_mapping` AS `sum` ON `ui`.`id` = `sum`.`user_id` WHERE shop_id = ".$shop_id." AND u_type_id = 14 ) AS `shopowner` LEFT JOIN(
                SELECT ui.user_name, ui.mobile_no, sum.shop_id AS tenant_shopID
                FROM `005_user_info` AS `ui` LEFT JOIN `010_shop_user_mapping` AS `sum`  ON `ui`.`id` = `sum`.`user_id`
                WHERE shop_id = ".$shop_id." AND u_type_id = 15 ) AS `tenant` ON shopowner.shopowner_shopID = tenant.tenant_shopID
                LEFT JOIN( SELECT ui.user_name, ui.mobile_no, si.id AS paymaster_shopID
                FROM `005_user_info` AS `ui` LEFT JOIN `008_shop_info` AS `si` ON `ui`.`id` = `si`.`pay_master_id`
                WHERE `si`.id = ".$shop_id." ) AS `paymaster` ON shopowner.shopowner_shopID = paymaster.paymaster_shopID;"); 
                
                $revenue_head_list = DB::table('006_revenue_head')->where('billing_dept_id',$billing_dept_id)->get();            
                foreach($revenue_head_list as $item){
                    $headDt = DB::table('009_shop_rate_info')->where('shop_id',$shop_id)->where('revenue_head_id',$item->id)->first();
                    if($headDt){$shop_rate = $headDt->amount;}else{$shop_rate = 0;}
                    $vatDt = DB::table('009c_vat_rate_info')->where('revenue_head_id',$item->id)->first();
                    if($vatDt){$vat_rate = $vatDt->rate;}else{$vat_rate = 0;}
                    $penaltyDt = DB::table('009a_various_rate_info')->find(42);
                    if($penaltyDt){$penalty_rate = $penaltyDt->rate;}else{$penalty_rate = 0;}
                    $rate[]=[
                        'revenue_head_id'=>$item->id,
                        'revenue_head_name'=>$item->revenue_head_name,
                        'shop_rate_amount'=>$shop_rate,
                        'vat_amount'=>$vat_rate,
                        'penalty_amount'=>$penalty_rate
                    ];
                }
                        
                $billCyclelist = DB::table('007_bill_cycle_info')
                                    ->where('processed',1)
                                    ->where('active_status',0)
                                    ->where('billing_dept_id',Auth::user()->billing_dept_id)
                                    ->get();
                foreach($billCyclelist as $billCyclelistItem){
                    
                    foreach($revenue_head_list as $revenue_head_list_item){
                        $billcycleNotExist[]=[
                            'bill_cycle_id'=>$billCyclelistItem->id,
                            'bill_cycle_name'=>$billCyclelistItem->bill_cycle_name,
                            'revenue_head_id'=>$revenue_head_list_item->id,
                            'revenue_head_name'=>$revenue_head_list_item->revenue_head_name,
                        ];
                    }
                }
                foreach($billCyclelist as $row){

                    foreach($revenue_head_list as $revenue_head_list_item){
                    
                        $data = DB::table('101a_month_wise_bill_master as mwbm')
                            ->leftJoin('101b_month_wise_bill_child as mwbc','mwbm.id','=','mwbc.bill_master_id')
                            ->leftJoin('101b1_month_wise_bill_child_revenue as mwbcr','mwbc.id','=','mwbcr.bill_child_id')
                            ->leftJoin('007_bill_cycle_info as bci','mwbm.bill_cycle_id','=','bci.id')
                            ->leftJoin('006_revenue_head as rh','mwbcr.revenue_head_id','=','rh.id')
                            ->where('mwbc.shop_id',$request->shop_id)
                            ->where('mwbm.bill_cycle_id',$row->id)
                            ->where('mwbcr.revenue_head_id',$revenue_head_list_item->id)
                            ->select(
                                'mwbm.id as master_id',
                                'mwbm.bill_cycle_id',
                                'bci.bill_cycle_name',
                                'mwbm.due_date',
                                'mwbm.discount_date',
                                'mwbc.shop_id',
                                'mwbcr.revenue_head_id',
                                'rh.revenue_head_name',
                                'mwbcr.amount_before_vat as bill_rate',
                                'mwbcr.vat_amount',
                                'mwbcr.amount as total_amount_after_vat',
                                'mwbcr.penalty_amount',
                                'mwbcr.total_bill_after_penalty',
                                'mwbcr.weaved_amount',
                                'mwbcr.total_payable',
                            )->first();
                            if(!empty($data)){                                
                                $billcycleExist[] = [
                                    'master_id'=>$data->master_id,
                                    'bill_cycle_id'=>$data->bill_cycle_id,
                                    'bill_cycle_name'=>$data->bill_cycle_name,
                                    'due_date'=>$data->due_date,
                                    'discount_date'=>$data->discount_date,
                                    'shop_id'=>$data->shop_id,
                                    'revenue_head_id'=>$data->revenue_head_id,
                                    'revenue_head_name'=>$data->revenue_head_name,
                                    'bill_rate'=>$data->bill_rate,
                                    'vat_amount'=>$data->vat_amount,
                                    'total_amount_after_vat'=>$data->total_amount_after_vat,
                                    'penalty_amount'=>$data->penalty_amount,
                                    'total_bill_after_penalty'=>$data->total_bill_after_penalty,
                                    'weaved_amount'=>$data->weaved_amount,
                                    'total_payable'=>$data->total_payable,
                                ];
                            }else{
                                $billcycleExist=[];
                            }
                    }
                }    

            }
            // dd($billcycleExist);
            return view('content.opening_balance_by_shop')->with(compact('breadcrumbs','shoplist','shopDetails','shopOwnerDetails','rate','billcycleExist','billCyclelist','billcycleNotExist'));
        }
        
    }
    public function opening_balance_bill_generate(Request $request){
        $curency = 'BDT';
        $headCount = $request->revenue_head_count;
        $totalCount = count($request->bill_cycle_id);
        $cycleCount = $request->revenue_head_count;
        $childId = '';
        $isMaster = true;
        for($item = 0; $item < $totalCount; $item++){
            if($request->grand_total_amount[$item] > 0){
                
                if($cycleCount == $headCount){
                    $id = DB::table('101a_month_wise_bill_master')->insertGetId([
                        'billing_dept_id'=>Auth::user()->billing_dept_id,
                        'bill_cycle_id'=>$request->bill_cycle_id[$item],
                        'issue_date'=>Date('Y-m-d',strtotime($request->due_date[$item])),
                        'due_date'=>Date('Y-m-d',strtotime($request->due_date[$item])),
                        'discount_date'=>Date('Y-m-d',strtotime($request->discounted_date[$item])),
                        'currency'=>$curency,
                        'created_by'=>auth()->user()->id,
                    ]);
                    // echo $request->grand_total_amount[$item];
                    $childId = DB::table('101b_month_wise_bill_child')->insertGetId([
                        'bill_master_id'=>$id,
                        'shop_id'=>$request->shop_id_val[$item],
                        'total_amount'=>$request->grand_total_amount[$item],
                        'billing_name'=>$request->bill_cycle_id[$item],
                        'penalty'=>$request->grand_total_penalty_amount[$item],
                        'total_bill_after_penalty'=>$request->grand_total_after_penalty_amount[$item],
                        'payment_status'=>0,
                        'created_by'=>auth()->user()->id,
                    ]);
                    $updateBillCycle = DB::table('007_bill_cycle_info')
                                            ->where('id',$request->bill_cycle_id[$item])
                                            ->update(['active_status'=>1]);
                    $cycleCount = 0;
                }
                $cycleCount++;

                DB::table('101b1_month_wise_bill_child_revenue')->insert([
                    'bill_child_id'=>$childId,
                    'revenue_head_id'=>$request->revenue_head_id[$item],
                    'amount_before_vat'=>$request->bill_rate[$item],
                    'vat_amount'=>$request->vat_rate[$item],
                    'amount'=>$request->total_amount[$item],
                    'penalty_amount'=>$request->penalty_amount[$item],
                    'total_bill_after_penalty'=>$request->after_penalty[$item],
                    'weaved_amount'=>$request->waived_amount[$item],
                    'total_payable'=>$request->payable_amount[$item],
                    'payment_status'=>0,
                    'created_by'=>auth()->user()->id,
                ]);
            }
        }
        session()->flash('server_message','Data insert success!');
        return redirect()->to('opening-balance-by-shop');
    }
    public function current_month_bill_generate(Request $request){
        
        $curency = 'BDT';
        $headCount = $request->revenue_head_count;
        $totalCount = count($request->bill_cycle_id);
        $cycleCount = $request->revenue_head_count;
        $childId = '';
        $isMaster = true;
        for($item = 0; $item < $totalCount; $item++){
            if($request->grand_total_amount[$item] > 0){
                
                if($cycleCount == $headCount){
                    $id = DB::table('101a_month_wise_bill_master')->insertGetId([
                        'billing_dept_id'=>Auth::user()->billing_dept_id,
                        'bill_cycle_id'=>$request->bill_cycle_id[$item],
                        'issue_date'=>Date('Y-m-d',strtotime($request->due_date[$item])),
                        'due_date'=>Date('Y-m-d',strtotime($request->due_date[$item])),
                        'discount_date'=>Date('Y-m-d',strtotime($request->discounted_date[$item])),
                        'currency'=>$curency,
                        'created_by'=>auth()->user()->id,
                    ]);
                    // echo $request->grand_total_amount[$item];
                    $childId = DB::table('101b_month_wise_bill_child')->insertGetId([
                        'bill_master_id'=>$id,
                        'shop_id'=>$request->shop_id_val[$item],
                        'total_amount'=>$request->grand_total_amount[$item],
                        'billing_name'=>$request->bill_cycle_id[$item],
                        'penalty'=>$request->grand_total_penalty_amount[$item],
                        'total_bill_after_penalty'=>$request->grand_total_after_penalty_amount[$item],
                        'payment_status'=>0,
                        'created_by'=>auth()->user()->id,
                    ]);
                    $updateBillCycle = DB::table('007_bill_cycle_info')
                                            ->where('id',$request->bill_cycle_id[$item])
                                            ->update(['active_status'=>1]);
                    $cycleCount = 0;
                }
                $cycleCount++;

                DB::table('101b1_month_wise_bill_child_revenue')->insert([
                    'bill_child_id'=>$childId,
                    'revenue_head_id'=>$request->revenue_head_id[$item],
                    'amount_before_vat'=>$request->bill_rate[$item],
                    'vat_amount'=>$request->vat_rate[$item],
                    'amount'=>$request->total_amount[$item],
                    'penalty_amount'=>$request->penalty_amount[$item],
                    'total_bill_after_penalty'=>$request->after_penalty[$item],
                    'weaved_amount'=>$request->waived_amount[$item],
                    'total_payable'=>$request->payable_amount[$item],
                    'payment_status'=>0,
                    'created_by'=>auth()->user()->id,
                ]);
            }
        }
        session()->flash('server_message', 'Data insert success!');
        return redirect()->to('current-month-bill-by-shop');
    }
    public function opening_balance_by_single_Shop(Request $request){
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"], ['name' => "Current Month Bill by-Flat"]
        ];
        $revenue_source_id = Auth::user()->revenue_source_id; 
        $billing_dept_id = Auth::user()->billing_dept_id;        

        $billGeneratedShoplist = DB::table('101b_month_wise_bill_child')->get();
        $shop_id_list = [];
        foreach($billGeneratedShoplist as $row){
            $shop_id_list[]=$row->shop_id;
        }
        $shoplist = DB::table('008_shop_info')
                    ->leftJoin('002A_billing_dept','008_shop_info.revenue_source_id','=','002A_billing_dept.revenue_source_id')
                    ->select(
                        '008_shop_info.*',
                        '002A_billing_dept.id as billing_dept_id'
                    )
                    ->where('008_shop_info.revenue_source_id',$revenue_source_id)
                    ->where('002A_billing_dept.id',$billing_dept_id)
                    ->whereNotNull('008_shop_info.pay_master_id')
                    ->whereNotIn('008_shop_info.id', array_unique($shop_id_list))
		            ->where('008_shop_info.shutter_type',0)
                    ->get();
        $shopDetails=[];
        $shopOwnerDetails=[];
        $rate=[];
        $billcycleNotExist=[];
        $billCyclelist=[];

        if(isset($request->shop_id)){            
            $shop_id = $request->shop_id;
            $shopDetails = DB::table('008_shop_info')
                                ->leftJoin('003_shop_type_info','008_shop_info.shop_type_id','=','003_shop_type_info.id')
                                ->select(
                                    '008_shop_info.*',
                                    '003_shop_type_info.shop_type_name',
                                )
                                ->where('008_shop_info.id',$shop_id)
                                ->first();
            $shopOwnerDetails = DB::select("SELECT shopowner.user_name AS ownerName, tenant.user_name AS tenantName, paymaster.user_name AS paymasterName, shopowner.mobile_no AS ownerMobile,
            tenant.mobile_no AS tenantMobile, paymaster.mobile_no AS paymasterMobile FROM ( SELECT ui.user_name, ui.mobile_no, sum.shop_id AS shopowner_shopID
            FROM `005_user_info` AS `ui` LEFT JOIN `010_shop_user_mapping` AS `sum` ON `ui`.`id` = `sum`.`user_id` WHERE shop_id = ".$shop_id." AND u_type_id = 14 ) AS `shopowner` LEFT JOIN(
            SELECT ui.user_name, ui.mobile_no, sum.shop_id AS tenant_shopID
            FROM `005_user_info` AS `ui` LEFT JOIN `010_shop_user_mapping` AS `sum`  ON `ui`.`id` = `sum`.`user_id`
            WHERE shop_id = ".$shop_id." AND u_type_id = 15 ) AS `tenant` ON shopowner.shopowner_shopID = tenant.tenant_shopID
            LEFT JOIN( SELECT ui.user_name, ui.mobile_no, si.id AS paymaster_shopID
            FROM `005_user_info` AS `ui` LEFT JOIN `008_shop_info` AS `si` ON `ui`.`id` = `si`.`pay_master_id`
            WHERE `si`.id = ".$shop_id." ) AS `paymaster` ON shopowner.shopowner_shopID = paymaster.paymaster_shopID;"); 
            
            $revenue_head_list = DB::table('006_revenue_head')->where('billing_dept_id',$billing_dept_id)->get();            
            foreach($revenue_head_list as $item){
                $headDt = DB::table('009_shop_rate_info')->where('shop_id',$shop_id)->where('revenue_head_id',$item->id)->first();
                if($headDt){$shop_rate = $headDt->amount;}else{$shop_rate = 0;}
                $vatDt = DB::table('009c_vat_rate_info')->where('revenue_head_id',$item->id)->first();
                if($vatDt){$vat_rate = $vatDt->rate;}else{$vat_rate = 0;}
                $penaltyDt = DB::table('009a_various_rate_info')->find(42);
                if($penaltyDt){$penalty_rate = $penaltyDt->rate;}else{$penalty_rate = 0;}
                $rate[]=[
                    'revenue_head_id'=>$item->id,
                    'revenue_head_name'=>$item->revenue_head_name,
                    'shop_rate_amount'=>$shop_rate,
                    'vat_amount'=>$vat_rate,
                    'penalty_amount'=>$penalty_rate
                ];
            }
                    
            $billCycleseq = DB::table('007_bill_cycle_info')
                                ->where('billing_dept_id',Auth::user()->billing_dept_id)
                                ->max('seq');
            $billCyclelist = DB::table('007_bill_cycle_info')
                                ->where('billing_dept_id',Auth::user()->billing_dept_id)                                
                                ->where('seq',$billCycleseq)                                
                                ->get();
            foreach($billCyclelist as $billCyclelistItem){
                foreach($revenue_head_list as $revenue_head_list_item){
                    $billcycleNotExist[]=[
                        'bill_cycle_id'=>$billCyclelistItem->id,
                        'bill_cycle_name'=>$billCyclelistItem->bill_cycle_name,
                        'revenue_head_id'=>$revenue_head_list_item->id,
                        'revenue_head_name'=>$revenue_head_list_item->revenue_head_name,
                    ];
                }
            }

        }
     
        return view('content.opening_balance_by_single_shop')->with(compact('breadcrumbs','shoplist','shopDetails','shopOwnerDetails','rate','billcycleNotExist','billCyclelist'));
    }
    public function single_shop_data(Request $request){
        $rate = DB::table('009_shop_rate_info as sri')
            ->leftJoin('006_revenue_head','sri.revenue_head_id','=','006_revenue_head.id')
            ->leftJoin('009c_vat_rate_info','sri.revenue_head_id','=','009c_vat_rate_info.revenue_head_id')
            ->where('sri.shop_id',$request->shop_id)
            // ->where('006_revenue_head.billing_dept_id',Auth::user()->billing_dept_id)
            ->select(
                'sri.shop_id',
                'sri.revenue_head_id',
                'sri.amount as bill_rate_amount',
                '009c_vat_rate_info.rate as vat_rate',
            )
            ->get();
        return response()->json(['result'=>$rate]);
    }
    public function settlement_by_Shop(){
        
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"], ['name' => "Settlement-by-Shop"]
        ];
        return view('content.settlement_by_shop',['breadcrumbs' => $breadcrumbs]);
    }
    public function single_shop_data_store(Request $request){
        
        if($request->shop_id !== null){
            
            $shop_id = $request->shop_id;
            foreach($request->shop_rate_amount as $rev_id => $inp_amount){
                $existDt = DB::table('009_shop_rate_info')->where('shop_id',$shop_id)->where('revenue_head_id',$rev_id)->get();                
                if(count($existDt)>0){
                    DB::table('009_shop_rate_info')->where('shop_id',$shop_id)->where('revenue_head_id',$rev_id)->update([
                        'amount' => $inp_amount,
                    ]);
                }else{                
                    DB::table('009_shop_rate_info')->insert([
                        'shop_id' => $shop_id,
                        'amount' => $inp_amount,
                        'revenue_head_id' => $rev_id,
                        'currency' => 'BDT',
                        'created_by' => auth()->user()->id,
                    ]);
                }
            }          
                                
            session()->flash('server_message', 'Data successfully updated');
            return back();              
        }else{
            
            session()->flash('server_message', 'Data Not inserted');
            return back();
        }
    }
}

