<?php

namespace App\Http\Controllers\Report;

use PDF;
use App\Http\Controllers\Controller;
use lemonpatwari\BanglaNumber\NumberToBangla;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function user(){
      $breadcrumbs = [
          ['link' => "home", 'name' => "Home"], ['name' => "User Payment Report"]
      ];
        return view('content.report.report',['action'=>'user'],['breadcrumbs' => $breadcrumbs]);
    }

    public function userPdf($id){

      $pdf = PDF::loadView('content.report.pdf-report',['action'=>'user', 'paymentID' => $id],[],[
          'mode'                 => 'utf-8',
          'format'               => 'A4-P',
          'default_font_size'    => '12',
          'default_font'         => 'FreeSerif',
          'margin_left'          => 5,
          'margin_right'         => 5,
          'margin_top'           => 5,
          'margin_bottom'        => 5,
          'margin_header'        => 0,
          'margin_footer'        => 10,
          'orientation'          => 'P',
          'title'                => 'Laravel mPDF',
          'author'               => '',
          'watermark'            => '',
          'show_watermark'       => false,
          'watermark_font'       => 'sans-serif',
          'display_mode'         => 'fullpage',
          'watermark_text_alpha' => 0.1,
          'custom_font_dir'      => '',
          'custom_font_data' 	   => [],
          'auto_language_detection'  => false,
          'temp_dir'               => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
          'pdfa' 			=> false,
          'pdfaauto' 		=> false,
      ]);
      return $pdf->stream($id.'.pdf');
    }

    public function pdf_meter_bill(){
      $numto = new NumberToBangla();

      $pdf = PDF::loadView('content.report.pdf-report',['action'=>'meterBill'],[],[
          'mode'                 => 'utf-8',
          'format'               => 'A4-L',
          'default_font_size'    => '12',
          'default_font'         => 'FreeSerif',
          'margin_left'          => 5,
          'margin_right'         => 5,
          'margin_top'           => 5,
          'margin_bottom'        => 5,
          'margin_header'        => 0,
          'margin_footer'        => 0,
          'orientation'          => 'L',
          'title'                => 'Laravel mPDF',
          'author'               => '',
          'watermark'            => '',
          'show_watermark'       => false,
          'watermark_font'       => 'sans-serif',
          'display_mode'         => 'fullpage',
          'watermark_text_alpha' => 0.1,
          'custom_font_dir'      => '',
          'custom_font_data' 	   => [],
          'auto_language_detection'  => false,
          'temp_dir'               => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
          'pdfa' 			=> false,
          'pdfaauto' 		=> false,
      ]);
      return $pdf->stream('document.pdf');
    }

    public function settlement(){
      $breadcrumbs = [
          ['link' => "home", 'name' => "Home"],['name' => "Online Settlement Report"]
      ];
      return view('content.report.report',['action'=>'settlement'],['breadcrumbs' => $breadcrumbs]);
    }

    public function pdf_settlement(){
      $startDate=$_GET['startDate'];
      $endDate=$_GET['endDate'];
      $pdf = PDF::loadView('content.report.pdf-report',['action'=>'pdfSettlement'],[],[
        'mode'                 => 'utf-8',
        'format'               => 'A4-p',
        'default_font_size'    => '12',
        'default_font'         => 'FreeSerif',
        'margin_left'          => 5,
        'margin_right'         => 5,
        'margin_top'           => 5,
        'margin_bottom'        => 5,
        'margin_header'        => 0,
        'margin_footer'        => 10,
        'orientation'          => 'p',
        'title'                => 'Settlement Report',
        'author'               => '',
        'watermark'            => '',
        'show_watermark'       => false,
        'watermark_font'       => 'sans-serif',
        'display_mode'         => 'fullpage',
        'watermark_text_alpha' => 0.1,
        'custom_font_dir'      => '',
        'custom_font_data' 	   => [],
        'auto_language_detection'  => false,
        'temp_dir'               => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
        'pdfa' 			=> false,
        'pdfaauto' 		=> false,
      ]);
      return $pdf->stream('settlement_report('.$startDate.' to '.$endDate.').pdf');
    }

    public function realization(){
      $breadcrumbs = [
          ['link' => "home", 'name' => "Home"],['name' => "Payment Realization Report"]
      ];
      return view('content.report.report',['action'=>'realization'],['breadcrumbs' => $breadcrumbs]);
    }

    public function pdf_realization(){
      $startDate=$_GET['startDate'];
      $endDate=$_GET['endDate'];
      $pdf = PDF::loadView('content.report.pdf-report',['action'=>'pdfRealization'],[],[
        'mode'                 => 'utf-8',
        'format'               => 'A4-P',
        'default_font_size'    => '12',
        'default_font'         => 'FreeSerif',
        'margin_left'          => 5,
        'margin_right'         => 5,
        'margin_top'           => 5,
        'margin_bottom'        => 5,
        'margin_header'        => 0,
        'margin_footer'        => 10,
        'orientation'          => 'p',
        'title'                => 'Realization Report',
        'author'               => '',
        'watermark'            => '',
        'show_watermark'       => false,
        'watermark_font'       => 'sans-serif',
        'display_mode'         => 'fullpage',
        'watermark_text_alpha' => 0.1,
        'custom_font_dir'      => '',
        'custom_font_data' 	   => [],
        'auto_language_detection'  => false,
        'temp_dir'               => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
        'pdfa' 			=> false,
        'pdfaauto' 		=> false,
      ]);
      return $pdf->stream('Realization_report('.$startDate.' to '.$endDate.').pdf');
    }

    public function meter_bill(){
      $breadcrumbs = [
          ['link' => "home", 'name' => "Home"],['name' => "Meter Bill"]
      ];
      return view('content.report.report',['action'=>'meterBill'],['breadcrumbs' => $breadcrumbs]);
    }

    public function electric_bill(){
      $breadcrumbs = [
          ['link' => "home", 'name' => "Home"],['name' => "Meter Bill"]
      ];
      return view('content.report.report',['action'=>'electricBill'],['breadcrumbs' => $breadcrumbs]);
    }

    public function various_rate_info(){
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"],['name' => "Various Rate Info"]
        ];
        return view('content.report.report',['action'=>'variousRateInfo'],['breadcrumbs' => $breadcrumbs]);
    }

}
