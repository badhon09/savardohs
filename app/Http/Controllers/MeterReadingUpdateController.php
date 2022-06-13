<?php

namespace App\Http\Controllers;

use App\Models\CycleView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MeterReadingUpdateController extends Controller
{
    public function index(Request $r){
        $qty = 10;
        if($r->qty){
            $qty = $r->qty;
        }
//        return $r;
        $userData = Auth::user();
        $data['cycleList'] = CycleView::where('revenue_source_id',$userData->revenue_source_id)->where('processed',1)->groupBy('cycle_id')->orderby('bill_cycle_name')->get();
        if($r->cycle_id != ''){
            $prevCycleID = '';
            $prevCycleData = DB::select('select id from 007_bill_cycle_info where seq < (select seq from 007_bill_cycle_info where id = '.$r->cycle_id.') and billing_dept_id = '.Auth::user()->billing_dept_id.' order by seq desc limit 1');
            if(count($prevCycleData) > 0){
                $prevCycleID = $prevCycleData[0]->id;
            }

            $shopListData = CycleView::where('revenue_source_id',$userData->revenue_source_id)
                ->where('cycle_id',$r->cycle_id)
                ->paginate($qty);
            $shopListData = collect($shopListData);
//            return $shopListData['current_page'];
            $shopList = $shopListData['data'];
            $data['links'] = $shopListData['links'];
            $prevShopBillListData = CycleView::where('revenue_source_id',$userData->revenue_source_id)
                ->where('cycle_id',$prevCycleID)
                ->paginate($qty);
            $prevShopBillListData = collect($prevShopBillListData);
            $prevShopBillList = $prevShopBillListData['data'];

            $this->meterReading = [];
            foreach($shopList as $i=>$itm){
                $prevReding = collect($prevShopBillList)->where('shop_id',$itm['shop_id'])->where('revenue_head_id',$itm['revenue_head_id'])->take(1)->values();
                if(count($prevReding) > 0 && $prevReding) {
                    $shopList[$i]['prev_meter_reading'] = $prevReding[0]['meter_reading'];
                    $shopList[$i]['prev_meter_reading_date'] = $prevReding[0]['previous_meter_reading_date'];
                }else{
                    $shopList[$i]['prev_meter_reading'] = 0;
                    $shopList[$i]['prev_meter_reading_date'] = '';
                }
            }
        }else{
            $data['links'] = [];
            $shopList  = [];
            $meterReading = [];
            $prevMeterReading = [];
        }
        $data['shopList'] = $shopList;

        return view('content.meter_reading.meter-reading-update',$data);
    }

    public function StoreData(Request $r){
        ini_set("pcre.backtrack_limit", "5000000000000000000");
        ini_set("memory_limit","4096M");
        ini_set('max_execution_time', 600);

//        return $r;
        if($r->update == 'Publish'){
            if($r->cycle_id != ''){
                $isUpdate = DB::table('007_bill_cycle_info')->where('id',$r->cycle_id)->update(['processed'=>2]);
                if($isUpdate){
                    session()->flash('server_message', 'Data successfully inserted.');
                    return redirect()->to('meter-reading/meter-reading-update');
                }else{
                    session()->flash('server_error', 'Data insert failed!');
                    return redirect()->to('meter-reading/meter-reading-update?cycle_id='.$r->cycle_id);
                }
            }else{
                session()->flash('server_error', 'Bill Cycle id not found');
                return redirect()->to('meter-reading/meter-reading-update?cycle_id='.$r->cycle_id);
            }
        }


        DB::beginTransaction();
        try {

            $prevMeterRedingDate = $r->prev_meter_reading_date;
            $prevMeterReding = $r->prev_meter_reading;
            $meterReding = $r->meter_reading;
            $childID = $r->reading_child_id;
            $itemCount = count($r->reading_child_id);
            for($i=0;$itemCount > $i;$i++){
               $MeterData =  DB::table('101d_month_wise_meter_reading_child')->where('id',$childID[$i])->first();

               if($MeterData->meter_reading_date != ''){
                   $pevDate = $MeterData->meter_reading_date;
               }else{
                   $pevDate = Date('Y-m-d',strtotime($r->meter_reading_date));
               }

               if($meterReding[$i] > 0){
//                   return $pevDate;
                   if($prevMeterRedingDate[$i]) {
                       DB::table('101d_month_wise_meter_reading_child')->where('id', $childID[$i])->update(
                           [
                               'is_update' => 1,
                               'meter_reading' => $meterReding[$i],
                               'previous_meter_reading' => $prevMeterReding[$i],
                               'previous_meter_reading_date' => Date('Y-m-d',strtotime($prevMeterRedingDate[$i])),
                               'meter_reading_date' => $pevDate
                           ]);
                   }else{
                       DB::table('101d_month_wise_meter_reading_child')->where('id', $childID[$i])->update(
                           [
                               'is_update' => 1,
                               'meter_reading' => $meterReding[$i],
                               'previous_meter_reading' => $prevMeterReding[$i],
                               'meter_reading_date' => $pevDate
                           ]);
                   }
               }
            }
            DB::commit();
            session()->flash('server_message', 'Data successfully inserted.');
            return redirect()->to('meter-reading/meter-reading-update?cycle_id='.$r->cycle_id.'&page='.$r->page.'&qty='.$r->qty);
        } catch (\Exception $e) {
            DB::rollback();
//            return $e->getMessage();
            session()->flash('server_error', "$e->getMessages()");
            return redirect()->to('meter-reading/meter-reading-update?cycle_id='.$r->cycle_id.'&page='.$r->page.'&qty='.$r->qty);
        }
    }
}
