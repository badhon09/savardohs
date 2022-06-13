<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use PDF;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
class ElectricBillReoprtController extends Controller
{
    public function getPDFAll(Request $request)
    {
    ini_set("pcre.backtrack_limit", "5000000000000000000");
    ini_set("memory_limit","4096M");
    ini_set('max_execution_time', 600);
//        return $request;
        $meter_no = $request->meter_no;
        $datas = DB::table('101e_month_wise_meter_reading_publish_master AS pm')
            ->join('101f_month_wise_meter_reading_publish_child AS pc', 'pm.id', '=', 'pc.meter_reading_publish_master_id')
            ->join('007_bill_cycle_info AS ci', 'pm.bill_cycle_id', '=', 'ci.id')
            ->join('008_shop_info AS si', 'pc.shop_id', '=', 'si.id')
            ->select('pc.id as pc_id', 'si.id', 'si.shop_name_bn', 'si.shop_name_bn', 'si.shop_new_num',
                'si.meter_number', 'si.area_in_sft', 'pm.issue_date', 'pm.due_date', 'ci.bill_cycle_name',
                'ci.bill_cycle_name_bn', 'pc.current_meter_reading_date', 'pc.current_meter_reading',
                'pc.previous_meter_reading_date', 'pc.previous_meter_reading', 'pc.used_unit',
                'pc.billing_rate', 'pc.bill_amount', 'pc.demand_note_amt', 'pc.vat_rate',
                'pc.vat_amount', 'pc.total_bill', 'pc.penalty_rate', 'pc.penalty', 'pc.total_bill_after_penalty')
            ->where('pc.id', '=', $request->pc_id)
            ->get();
        $path = public_path('pdf/' . $datas[0]->bill_cycle_name);
        if (empty($datas[0]->meter_number)) {
            $meter_number = 0;
        } else {
            $meter_number = $datas[0]->meter_number;
        }
        $filename = date('d-m-Y', strtotime($datas[0]->issue_date)) . '-' . $meter_number . '-' . $datas[0]->id . '.pdf';

        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        $pdf = PDF::loadView('pdf.electric_bill', ['data' => $datas], [],
            [
                'mode' => '',
                'format' => 'A4-L',
                'default_font_size' => '12',
                'default_font' => 'sans-serif',
                'margin_left' => 5,
                'margin_right' => 5,
                'margin_top' => 5,
                'margin_bottom' => 5,
                'margin_header' => 0,
                'margin_footer' => 5,
                'orientation' => 'L',
                'title' => 'Laravel mPDF',
                'author' => '',
                'watermark' => '',
                'show_watermark' => false,
                'watermark_font' => 'sans-serif',
                'display_mode' => 'fullpage',
                'watermark_text_alpha' => 0.1,
                'custom_font_dir' => '',
                'custom_font_data' => [],
                'auto_language_detection' => false,
                'temp_dir' => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
                'pdfa' => false,
                'pdfaauto' => false,
            ]
        );
        $pdf->save($path . '/' . $filename);
        $res = '';
        $res .= '<a class="btn btn-success">Downloaded</a>';
        return response()->json(['status' => $res]);
    }

    public function getPDF(Request $request)
    {
        ini_set("pcre.backtrack_limit", "5000000000000000000");
        ini_set("memory_limit","4096M");
        ini_set('max_execution_time', 600);
        $meter_no = $request->meter_no;
        $billing_cycle = $request->billing_cycle;
        $datas = DB::table('101e_month_wise_meter_reading_publish_master AS pm')
            ->join('101f_month_wise_meter_reading_publish_child AS pc', 'pm.id', '=', 'pc.meter_reading_publish_master_id')
            ->join('007_bill_cycle_info AS ci', 'pm.bill_cycle_id', '=', 'ci.id')
            ->join('008_shop_info AS si', 'pc.shop_id', '=', 'si.id')
            ->select('pc.id as pc_id', 'si.id', 'si.shop_name_bn', 'si.shop_name_bn', 'si.shop_new_num',
                'si.meter_number', 'si.area_in_sft', 'pm.issue_date', 'pm.due_date', 'ci.bill_cycle_name',
                'ci.bill_cycle_name_bn', 'pc.current_meter_reading_date', 'pc.current_meter_reading',
                'pc.previous_meter_reading_date', 'pc.previous_meter_reading', 'pc.used_unit',
                'pc.billing_rate', 'pc.bill_amount', 'pc.demand_note_amt', 'pc.vat_rate',
                'pc.vat_amount', 'pc.total_bill', 'pc.penalty_rate', 'pc.penalty', 'pc.total_bill_after_penalty')
            ->where('si.meter_number', '=', $meter_no)
            ->where('pm.bill_cycle_id', '=', $billing_cycle)
            ->where('pm.revenue_head_id', '=', 6)
            ->get();
        if (count($datas)<1)
        {
            return '<h1 style="text-align: center;">No Data Found.</h1>';
        }
        else {
            $filename = date('m-Y', strtotime($datas[0]->issue_date)) . '-' . $datas[0]->meter_number . $datas[0]->id . '.pdf';
            $pdf = PDF::loadView('pdf.electric_bill_meter', ['data' => $datas], [],
                [
                    'mode' => '',
                    'format' => 'A4-L',
                    'default_font_size' => '12',
                    'default_font' => 'sans-serif',
                    'margin_left' => 5,
                    'margin_right' => 5,
                    'margin_top' => 5,
                    'margin_bottom' => 5,
                    'margin_header' => 0,
                    'margin_footer' => 5,
                    'orientation' => 'L',
                    'title' => 'Laravel mPDF',
                    'author' => '',
                    'watermark' => '',
                    'show_watermark' => false,
                    'watermark_font' => 'sans-serif',
                    'display_mode' => 'fullpage',
                    'watermark_text_alpha' => 0.1,
                    'custom_font_dir' => '',
                    'custom_font_data' => [],
                    'auto_language_detection' => false,
                    'temp_dir' => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
                    'pdfa' => false,
                    'pdfaauto' => false,
                ]
            );
            return $pdf->stream($filename);
        }
    }

    public function checkPdf(Request $request)
    {
        ini_set("pcre.backtrack_limit", "5000000000000000000");
        ini_set("memory_limit","4096M");
        ini_set('max_execution_time', 600);
        $billing_cycle = $request->billing_cycle;
        $data = DB::table('101d_month_wise_meter_reading_child AS bc')
            ->leftJoin('101c_month_wise_meter_reading_master AS bm', 'bc.meter_reading_master_id', '=', 'bm.id')
            ->leftJoin('008_shop_info AS si', 'bc.shop_id', '=', 'si.id')
            ->leftJoin('002A_billing_dept AS bd', 'bm.billing_dept_id', '=', 'bd.id')
            ->leftJoin('007_bill_cycle_info AS bci', 'bm.bill_cycle_id', '=', 'bci.id')
            ->leftJoin('006_revenue_head AS rh', 'bm.revenue_head_id', '=', 'rh.id')
            ->select('bm.billing_dept_id', 'bd.billing_dept_name', 'bm.bill_cycle_id', 'bci.bill_cycle_name',
                'bm.revenue_head_id', 'rh.revenue_head_name', 'si.shop_new_num', 'si.meter_number', 'si.area_in_sft',
                'bc.meter_reading AS current_reading', 'bc.updated_at', 'bc.meter_reading_date')
            ->where('bm.revenue_head_id', '=', '6')
            ->where('bm.billing_dept_id', '=', '2')
            ->where('bm.bill_cycle_id', '=', $billing_cycle)
            ->get();
        if (count($data)<1)
        {
            return '<h1 style="text-align: center;">No Data Found.</h1>';
        }
        else {
            $datas = collect($data)->groupBy('bill_cycle_name');
            $result = [];
            $s = 0;
            foreach ($datas as $i => $item) {
                foreach ($item as $j => $row) {
                    if ($j == 0) {
                        $result[$s]['bill_cycle_id'] = $row->bill_cycle_id;
                        $result[$s]['bill_cycle_name'] = $row->bill_cycle_name;
                        $result[$s]['billing_dept_id'] = $row->billing_dept_id;
                        $result[$s]['billing_dept_name'] = $row->billing_dept_name;
                        $result[$s]['revenue_head_id'] = $row->revenue_head_id;
                        $result[$s]['revenue_head_name'] = $row->revenue_head_name;
                        $result[$s]['bill_cycle_name'] = $row->bill_cycle_name;
                        $result[$s]['row_item'] = [];
                    }
                    $result[$s]['row_item'][$j]['shop_new_num'] = $row->shop_new_num;
                    $result[$s]['row_item'][$j]['meter_number'] = $row->meter_number;
                    $result[$s]['row_item'][$j]['area_in_sft'] = $row->area_in_sft;
                    $result[$s]['row_item'][$j]['current_reading'] = $row->current_reading;
                    $result[$s]['row_item'][$j]['updated_at'] = $row->updated_at;
                    $result[$s]['row_item'][$j]['meter_reading_date'] = $row->meter_reading_date;
                }
                $s++;
            }
            $pdf = PDF::loadView('pdf.electric_bill_check', ['result' => $result], [],
                [
                    'mode' => '',
                    'format' => 'A4-P',
                    'default_font_size' => '12',
                    'default_font' => 'sans-serif',
                    'margin_left' => 5,
                    'margin_right' => 5,
                    'margin_top' => 5,
                    'margin_bottom' => 15,
                    'margin_header' => 0,
                    'margin_footer' => 5,
                    'orientation' => 'P',
                    'title' => 'Laravel mPDF',
                    'author' => '',
                    'watermark' => '',
                    'show_watermark' => false,
                    'watermark_font' => 'sans-serif',
                    'display_mode' => 'fullpage',
                    'watermark_text_alpha' => 0.1,
                    'custom_font_dir' => '',
                    'custom_font_data' => [],
                    'auto_language_detection' => false,
                    'temp_dir' => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
                    'pdfa' => false,
                    'pdfaauto' => false,
                ]
            );
            return $pdf->stream('Electric_Bill.pdf');
        }
    }

    public function reportDownload()
    {
        $bill_cycle_data = DB::table('101e_month_wise_meter_reading_publish_master AS pm')
            ->join('007_bill_cycle_info AS ci', 'pm.bill_cycle_id', '=', 'ci.id')
            ->select(DB::raw('DISTINCT(pm.bill_cycle_id)'), 'ci.bill_cycle_name',
                'ci.bill_cycle_name_bn')
            ->get();
        return view('pdf.report_download')->with('bill_cycle_data', $bill_cycle_data);
    }


    public function getDataByBCid(Request $request)
    {
//        return $request;
        $bc_id = $request->bcId;
        $rev_id = $request->revId;
        $dep_id = $request->dep_id;
        $datas = DB::table('101e_month_wise_meter_reading_publish_master AS pm')
            ->join('101f_month_wise_meter_reading_publish_child AS pc', 'pm.id', '=', 'pc.meter_reading_publish_master_id')
            ->join('007_bill_cycle_info AS ci', 'pm.bill_cycle_id', '=', 'ci.id')
            ->join('008_shop_info AS si', 'pc.shop_id', '=', 'si.id')
            ->select('pc.id AS pc_id', 'si.id AS shop_id', 'si.shop_name_bn', 'si.shop_name_bn', 'si.shop_new_num',
                'si.meter_number', 'si.area_in_sft', 'pm.issue_date', 'pm.due_date',
                'ci.bill_cycle_name_bn', 'pc.current_meter_reading_date', 'pc.current_meter_reading',
                'pc.previous_meter_reading_date', 'pc.previous_meter_reading', 'pc.used_unit',
                'pc.billing_rate', 'pc.bill_amount', 'pc.demand_note_amt', 'pc.vat_rate',
                'pc.vat_amount', 'pc.total_bill', 'pc.penalty_rate', 'pc.penalty', 'pc.total_bill_after_penalty')
            ->where('pm.bill_cycle_id', '=', $bc_id)
            ->where('pm.revenue_head_id', '=', $rev_id)
            ->where('pm.billing_dept_id', '=', $dep_id)
//            ->limit(2)
            ->get();
        return response()->json(['data' => $datas]);
    }

    public function shopWise(Request $request)
    {
        ini_set("pcre.backtrack_limit", "5000000000000000000");
        ini_set("memory_limit","4096M");
        ini_set('max_execution_time', 600);
        $shop = $request->shop_no;
        $bcID = $request->billing_cycle;
        $data = DB::table('Electricity_Bill_Shop_Monthwise')
            ->where('shop_id', '=', $shop)
            ->where('bill_cycle_id', '=', $bcID)
            ->get();
        if (count($data)<1)
        {
            return '<h1 style="text-align: center;">No Data Found.</h1>';
        }
        else {
            $reportno = '005B';
            $filename = $data[0]->bill_cycle_name . '-' . $shop . '.pdf';
            $pdf = PDF::loadView('pdf.month_wise', ['data' => $data, 'reportno' => $reportno], [],
                [
                    'mode' => '',
                    'format' => 'A4-L',
                    'default_font_size' => '12',
                    'default_font' => 'sans-serif',
                    'margin_left' => 5,
                    'margin_right' => 5,
                    'margin_top' => 5,
                    'margin_bottom' => 5,
                    'margin_header' => 0,
                    'margin_footer' => 5,
                    'orientation' => 'L',
                    'title' => 'Laravel mPDF',
                    'author' => '',
                    'watermark' => '',
                    'show_watermark' => false,
                    'watermark_font' => 'sans-serif',
                    'display_mode' => 'fullpage',
                    'watermark_text_alpha' => 0.1,
                    'custom_font_dir' => '',
                    'custom_font_data' => [],
                    'auto_language_detection' => false,
                    'temp_dir' => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
                    'pdfa' => false,
                    'pdfaauto' => false,
                ]
            );
            return $pdf->stream($filename . '.pdf');
        }
    }

    public function monthWise(Request $request)
    {
        ini_set("pcre.backtrack_limit", "5000000000000000000");
        ini_set("memory_limit","4096M");
        ini_set('max_execution_time', 600);
        $bcID = $request->billing_cycle;
        $data = DB::table('Electricity_Bill_Common_Monthwise')
            ->where('bill_cycle_id', '=', $bcID)
            ->get();
        if (count($data)<1)
        {
            return '<h1 style="text-align: center;"> No data Found.</h1>';
        }
        else {
            $reportno = '004A';
            $filename = $data[0]->bill_cycle_name . '-' . $bcID . '.pdf';
            $pdf = PDF::loadView('pdf.month_wise', ['data' => $data, 'reportno' => $reportno], [],
                [
                    'mode' => '',
                    'format' => 'A4-L',
                    'default_font_size' => '12',
                    'default_font' => 'sans-serif',
                    'margin_left' => 5,
                    'margin_right' => 5,
                    'margin_top' => 5,
                    'margin_bottom' => 15,
                    'margin_header' => 0,
                    'margin_footer' => 5,
                    'orientation' => 'L',
                    'title' => 'Laravel mPDF',
                    'author' => '',
                    'watermark' => '',
                    'show_watermark' => false,
                    'watermark_font' => 'sans-serif',
                    'display_mode' => 'fullpage',
                    'watermark_text_alpha' => 0.1,
                    'custom_font_dir' => '',
                    'custom_font_data' => [],
                    'auto_language_detection' => true,
                    'temp_dir' => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
                    'pdfa' => false,
                    'pdfaauto' => false,
                ]
            );
            return $pdf->stream($filename . '.pdf');
        }
    }

    public function shopOwner()
    {
        ini_set("pcre.backtrack_limit", "5000000000000000000");
        ini_set("memory_limit","4096M");
        ini_set('max_execution_time', 600);
        $data = DB::table('001_shop_details_with_user_info')
            ->get();
        if (count($data)<1)
        {
            return '<h1 style="text-align: center;">No Data Found.</h1>';
        }
        else {
            $pdf = PDF::loadView('pdf.shop_owner', ['data' => $data], [],
                [
                    'mode' => '',
                    'format' => 'A4-L',
                    'default_font_size' => '12',
                    'default_font' => 'sans-serif',
                    'margin_left' => 5,
                    'margin_right' => 5,
                    'margin_top' => 5,
                    'margin_bottom' => 13,
                    'margin_header' => 0,
                    'margin_footer' => 5,
                    'orientation' => 'L',
                    'title' => 'Laravel mPDF',
                    'author' => '',
                    'watermark' => '',
                    'show_watermark' => false,
                    'watermark_font' => 'sans-serif',
                    'display_mode' => 'fullpage',
                    'watermark_text_alpha' => 0.1,
                    'custom_font_dir' => '',
                    'custom_font_data' => [],
                    'auto_language_detection' => false,
                    'temp_dir' => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
                    'pdfa' => false,
                    'pdfaauto' => false,
                ]
            );
            return $pdf->stream('shop_owner.pdf');
        }
    }

    public function shopOwnerWithoutPaymaster()
    {
        ini_set("pcre.backtrack_limit", "5000000000000000000");
        ini_set("memory_limit","4096M");
        ini_set('max_execution_time', 600);
        $data = DB::table('002_shop_details_with_user_info_without_paymaster')
            ->get();
        if (count($data)<1)
        {
            return '<h1 style="text-align: center;">No Data Found.</h1>';
        }
        else {
            $pdf = PDF::loadView('pdf.shop_owner_without_paymaster', ['data' => $data], [],
                [
                    'mode' => '',
                    'format' => 'A4-L',
                    'default_font_size' => '12',
                    'default_font' => 'sans-serif',
                    'margin_left' => 5,
                    'margin_right' => 5,
                    'margin_top' => 5,
                    'margin_bottom' => 13,
                    'margin_header' => 0,
                    'margin_footer' => 5,
                    'orientation' => 'L',
                    'title' => 'Laravel mPDF',
                    'author' => '',
                    'watermark' => '',
                    'show_watermark' => false,
                    'watermark_font' => 'sans-serif',
                    'display_mode' => 'fullpage',
                    'watermark_text_alpha' => 0.1,
                    'custom_font_dir' => '',
                    'custom_font_data' => [],
                    'auto_language_detection' => false,
                    'temp_dir' => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
                    'pdfa' => false,
                    'pdfaauto' => false,
                ]
            );
            return $pdf->stream('shop_owner.pdf');
        }
    }

    public function shopOwnerWithoutOwner()
    {
        ini_set("pcre.backtrack_limit", "5000000000000000000");
        ini_set("memory_limit","4096M");
        ini_set('max_execution_time', 600);
        $data = DB::table('003_shop_details_with_user_info_without_owner')
            ->get();
        if (count($data)<1)
        {
            return '<h1 style="text-align: center;">No Data Found.</h1>';
        }
        else {
            $pdf = PDF::loadView('pdf.shop_owner_without_owner', ['data' => $data], [],
                [
                    'mode' => '',
                    'format' => 'A4-L',
                    'default_font_size' => '12',
                    'default_font' => 'sans-serif',
                    'margin_left' => 5,
                    'margin_right' => 5,
                    'margin_top' => 5,
                    'margin_bottom' => 13,
                    'margin_header' => 0,
                    'margin_footer' => 5,
                    'orientation' => 'L',
                    'title' => 'Laravel mPDF',
                    'author' => '',
                    'watermark' => '',
                    'show_watermark' => false,
                    'watermark_font' => 'sans-serif',
                    'display_mode' => 'fullpage',
                    'watermark_text_alpha' => 0.1,
                    'custom_font_dir' => '',
                    'custom_font_data' => [],
                    'auto_language_detection' => false,
                    'temp_dir' => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
                    'pdfa' => false,
                    'pdfaauto' => false,
                ]
            );
            return $pdf->stream('shop_owner.pdf');
        }
    }

    public function zipDownload(Request $request)
    {
        $bc_id = $request->bc_id;
        $data = DB::table('007_bill_cycle_info')
            ->where('id', '=', $bc_id)
            ->get();
        $folderName = $data[0]->bill_cycle_name;
        $filename = $folderName . '.zip';
        $zip = new ZipArchive();
        if ($zip->open(public_path('pdf/' . $filename), ZipArchive::CREATE) === TRUE) {
            $files = File::files(public_path('/pdf/' . $folderName));
            // loop the files result
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }

            $zip->close();
        }
        return response()->download(public_path('pdf/' . $filename));
    }

    //NAmuna Chak
    public function nomuna_chak()
    {
        ini_set("pcre.backtrack_limit", "5000000000000000000");
        ini_set("memory_limit","4096M");
        ini_set('max_execution_time', 600);
        $pdf = PDF::loadView('pdf.namuna_chak', [], [],
            [
                'mode' => '',
                'format' => 'A4-P',
                'default_font_size' => '12',
                'default_font' => 'sans-serif',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 5,
                'margin_bottom' => 5,
                'margin_header' => 0,
                'margin_footer' => 5,
                'orientation' => 'P',
                'title' => 'Laravel mPDF',
                'author' => '',
                'watermark' => '',
                'show_watermark' => false,
                'watermark_font' => 'sans-serif',
                'display_mode' => 'fullpage',
                'watermark_text_alpha' => 0.1,
                'custom_font_dir' => '',
                'custom_font_data' => [],
                'auto_language_detection' => false,
                'temp_dir' => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
                'pdfa' => false,
                'pdfaauto' => false,
            ]
        );
        return $pdf->stream('shop_owner.pdf');
    }

    public function reportByMeter()
    {
        $data['bill_cycle'] = DB::table('101e_month_wise_meter_reading_publish_master AS pm')
            ->join('007_bill_cycle_info AS ci', 'pm.bill_cycle_id', '=', 'ci.id')
            ->select(DB::raw('DISTINCT(pm.bill_cycle_id)'), 'ci.bill_cycle_name',
                'ci.bill_cycle_name_bn')
            ->get();
        $data['meter'] = DB::table('101f_month_wise_meter_reading_publish_child AS pc')
            ->join('008_shop_info AS si', 'pc.shop_id', '=', 'si.id')
            ->select(DB::raw('DISTINCT(pc.shop_id)'), 'si.meter_number', 'si.shop_name'
            )
            ->whereNotNull('si.meter_number')
            ->get();
        return view('pdf.by_meter_view',$data);
    }

    public function checkBillView()
    {
        $datas = DB::table('101c_month_wise_meter_reading_master AS pm')
            ->join('007_bill_cycle_info AS ci', 'pm.bill_cycle_id', '=', 'ci.id')
            ->select(DB::raw('DISTINCT(pm.bill_cycle_id)'), 'ci.bill_cycle_name',
                'ci.bill_cycle_name_bn')
            ->get();
        return view('pdf.check_view')->with('data', $datas);
    }

    public function monthWiseView()
    {
        $datas = DB::table('101e_month_wise_meter_reading_publish_master AS pm')
            ->join('007_bill_cycle_info AS ci', 'pm.bill_cycle_id', '=', 'ci.id')
            ->select(DB::raw('DISTINCT(pm.bill_cycle_id)'), 'ci.bill_cycle_name',
                'ci.bill_cycle_name_bn')
            ->get();
        return view('pdf.month_wise_view')->with('data',$datas);
    }
    public function shopWiseView()
    {
        $data['bill_cycle'] = DB::table('101e_month_wise_meter_reading_publish_master AS pm')
            ->join('007_bill_cycle_info AS ci', 'pm.bill_cycle_id', '=', 'ci.id')
            ->select(DB::raw('DISTINCT(pm.bill_cycle_id)'), 'ci.bill_cycle_name',
                'ci.bill_cycle_name_bn')
            ->get();
        $data['shop'] = DB::table('101f_month_wise_meter_reading_publish_child AS pc')
            ->join('008_shop_info AS si', 'pc.shop_id', '=', 'si.id')
            ->select(DB::raw('DISTINCT(pc.shop_id)'), 'si.meter_number', 'si.shop_name','si.shop_new_num'
            )
            ->get();
        return view('pdf.shop_wise_view',$data);
    }
    public function commonMonthShopWiseView()
    {
        $data['bill_cycle'] = DB::table('101e_month_wise_meter_reading_publish_master AS pm')
            ->join('007_bill_cycle_info AS ci', 'pm.bill_cycle_id', '=', 'ci.id')
            ->select(DB::raw('DISTINCT(pm.bill_cycle_id)'), 'ci.bill_cycle_name',
                'ci.bill_cycle_name_bn')
            ->get();
        $data['shop'] = DB::table('101f_month_wise_meter_reading_publish_child AS pc')
            ->join('008_shop_info AS si', 'pc.shop_id', '=', 'si.id')
            ->select(DB::raw('DISTINCT(pc.shop_id)'), 'si.meter_number', 'si.shop_name','si.shop_new_num'
            )
            ->get();
        return view('pdf.common_month_shop_view',$data);
    }
    public function commonMonthShopWisePdf(Request $request)
    {
        ini_set("pcre.backtrack_limit", "5000000000000000000");
        ini_set("memory_limit","4096M");
        ini_set('max_execution_time', 600);
        $bcID = $request->billing_cycle;
        $shop_id = $request->shop_no;
        $data = DB::table('Electricity_Bill_Common_Monthwise')
            ->where('bill_cycle_id', '=', $bcID)
            ->where('shop_id', '=', $shop_id)
            ->get();
        if (count($data)<1)
        {
            return '<h1 style="text-align: center;"> No data Found.</h1>';
        }
        else
        {
            $reportno='004B';
            $filename = $data[0]->bill_cycle_name . '-' . $bcID . '.pdf';
            $pdf = PDF::loadView('pdf.month_wise', ['data' => $data, 'reportno'=>$reportno], [],
                [
                    'mode' => '',
                    'format' => 'A4-L',
                    'default_font_size' => '12',
                    'default_font' => 'sans-serif',
                    'margin_left' => 5,
                    'margin_right' => 5,
                    'margin_top' => 5,
                    'margin_bottom' => 5,
                    'margin_header' => 0,
                    'margin_footer' => 5,
                    'orientation' => 'L',
                    'title' => 'Laravel mPDF',
                    'author' => '',
                    'watermark' => '',
                    'show_watermark' => false,
                    'watermark_font' => 'sans-serif',
                    'display_mode' => 'fullpage',
                    'watermark_text_alpha' => 0.1,
                    'custom_font_dir' => '',
                    'custom_font_data' => [],
                    'auto_language_detection' => false,
                    'temp_dir' => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
                    'pdfa' => false,
                    'pdfaauto' => false,
                ]
            );
            return $pdf->stream($filename . '.pdf');
        }
    }

    public function shopWiseViewShop()
    {
        $datas = DB::table('101e_month_wise_meter_reading_publish_master AS pm')
            ->join('007_bill_cycle_info AS ci', 'pm.bill_cycle_id', '=', 'ci.id')
            ->select(DB::raw('DISTINCT(pm.bill_cycle_id)'), 'ci.bill_cycle_name',
                'ci.bill_cycle_name_bn')
            ->get();
        return view('pdf.shop_wise_view_shop')->with('data',$datas);
    }
    public function shopWiseViewShopPdf(Request $request)
    {
        ini_set("pcre.backtrack_limit", "5000000000000000000");
        ini_set("memory_limit","4096M");
        ini_set('max_execution_time', 600);
        $bcID = $request->billing_cycle;
        $data = DB::table('Electricity_Bill_Shop_Monthwise')
            ->where('bill_cycle_id', '=', $bcID)
            ->get();
        if (count($data)<1)
        {
            return '<h1 style="text-align: center;">No Data Found.</h1>';
        }
        else {
            $reportno = '005A';
            $filename = $data[0]->bill_cycle_name . '-' . $bcID . '.pdf';
            $pdf = PDF::loadView('pdf.month_wise', ['data' => $data, 'reportno' => $reportno], [],
                [
                    'mode' => '',
                    'format' => 'A4-L',
                    'default_font_size' => '12',
                    'default_font' => 'sans-serif',
                    'margin_left' => 5,
                    'margin_right' => 5,
                    'margin_top' => 5,
                    'margin_bottom' => 15,
                    'margin_header' => 0,
                    'margin_footer' => 5,
                    'orientation' => 'L',
                    'title' => 'Laravel mPDF',
                    'author' => '',
                    'watermark' => '',
                    'show_watermark' => false,
                    'watermark_font' => 'sans-serif',
                    'display_mode' => 'fullpage',
                    'watermark_text_alpha' => 0.1,
                    'custom_font_dir' => '',
                    'custom_font_data' => [],
                    'auto_language_detection' => false,
                    'temp_dir' => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
                    'pdfa' => false,
                    'pdfaauto' => false,
                ]
            );
            return $pdf->stream($filename . '.pdf');
        }
    }


    //Month Wise Sena mArket
    public function monthWiseSenaMarketView()
    {
        $data['bill_cycle'] = DB::table('101a_month_wise_bill_master AS pm')
            ->join('007_bill_cycle_info AS ci', 'pm.bill_cycle_id', '=', 'ci.id')
            ->select(DB::raw('DISTINCT(pm.bill_cycle_id)'), 'ci.bill_cycle_name',
                'ci.bill_cycle_name_bn')
            ->get();
        $data['shop'] = DB::table('101b_month_wise_bill_child AS pc')
            ->join('008_shop_info AS si', 'pc.shop_id', '=', 'si.id')
            ->select(DB::raw('DISTINCT(pc.shop_id)'), 'si.meter_number', 'si.shop_name','si.shop_new_num'
            )
            ->get();
        return view('pdf.sena_market_revenue_view',$data);
    }
    public function monthWiseSenaMarketPdf(Request $request)
    {
        ini_set("pcre.backtrack_limit", "5000000000000000000");
        ini_set("memory_limit","4096M");
        ini_set('max_execution_time', 600);
//        return Auth::user();
        $this->validate($request,[
           'billing_cycle'=>'required'
        ]);
        $bc_id = $request->billing_cycle;
        $shop_id = $request->shop_no;
        $limit = $request->limit;
        if ($shop_id == '' && $limit == '')
        {
            $data = DB::table('004_monthwise_sena_market_revenue')
            ->where('bill_cycle_id','=',$bc_id)
            ->where('billing_dept_id','=',Auth::user()->billing_dept_id)
            ->get();
        }
        else if ($shop_id == '')
        {
            $data = DB::table('004_monthwise_sena_market_revenue')
                ->where('bill_cycle_id','=',$bc_id)
                ->where('billing_dept_id','=',Auth::user()->billing_dept_id)
                ->limit($limit)->get();
        }
        else
        {
            $data = DB::table('004_monthwise_sena_market_revenue')
                ->where('bill_cycle_id','=',$bc_id)
                ->where('shop_id','=',$shop_id)
                ->where('billing_dept_id','=',Auth::user()->billing_dept_id)
                ->limit($limit)->get();
        }
//        return count($data);
        if (count($data)<1)
        {
            return '<h1 style="text-align: center;">No Data Found.</h1>';
        }
        else
        {
            $filename = $data[0]->bill_cycle_name.'.pdf';
            $pdf = PDF::loadView('pdf.sena_market_revenue_pdf_b', ['data' => $data], [],
                [
                    'mode' => '',
                    'format' => 'A4-L',
                    'default_font_size' => '12',
                    'default_font' => 'sans-serif',
                    'margin_left' => 10,
                    'margin_right' => 10,
                    'margin_top' => 10,
                    'margin_bottom' => 15,
                    'margin_header' => 0,
                    'margin_footer' => 5,
                    'orientation' => 'L',
                    'title' => 'Laravel mPDF',
                    'author' => '',
                    'watermark' => '',
                    'show_watermark' => false,
                    'watermark_font' => 'sans-serif',
                    'display_mode' => 'fullpage',
                    'watermark_text_alpha' => 0.1,
                    'custom_font_dir' => '',
                    'custom_font_data' => [],
                    'auto_language_detection' => false,
                    'temp_dir' => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
                    'pdfa' => false,
                    'pdfaauto' => false,
                ]
            );
            return $pdf->stream($filename . '.pdf');
        }

    }
}
