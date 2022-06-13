<?php

namespace App\Http\Controllers\Otp;

use PDF;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    public function index(){
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"], ['name' => "Over The Counter Payment List"]
        ];
          return view('content.otp.otp',['action'=>'list'],['breadcrumbs' => $breadcrumbs]);
      }
      public function create(){
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"],['name' => "Over The Counter Payment"], ['name' => "Create"]
        ];
          return view('content.otp.otp',['action'=>'new'],['breadcrumbs' => $breadcrumbs]);
      }

      public function edit($id){   
         
        $pdf = PDF::loadView('content.otp.otpReport',['action'=>'edit','paymentID' => $id],[],[
          'mode'                 => '',
                'format'               => 'A4-L',
                'default_font_size'    => '12',
                'default_font'         => 'sans-serif',
                'margin_left'          => 5,
                'margin_right'         => 5,
                'margin_top'           => 10,
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
        // return view('content.otp.otpReport',['action'=>'edit','paymentID' => $id]);
      }

}
