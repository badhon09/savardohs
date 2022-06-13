<?php

namespace App\Http\Controllers\MeterReding;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MeterReadingController extends Controller
{
    public function index(){
        $breadcrumbs = [
            ['link' => "meter-reading/meter-reading-list", 'name' => "Meter Reading"], ['name' => "List"]
        ];
        return view('content.meter_reading.meter-reading',['action'=>'list','breadcrumbs' => $breadcrumbs]);
    }
    public function create(){
        $breadcrumbs = [
            ['link' => "meter-reading/meter-reading-list", 'name' => "Meter Reading"], ['name' => "Create"]
        ];
        return view('content.meter_reading.meter-reading',['action'=>'new','breadcrumbs' => $breadcrumbs]);
    }
    public function update(){
        $breadcrumbs = [
            ['link' => "meter-reading/meter-reading-list", 'name' => "Meter Reading"], ['name' => "Create"]
        ];
        return view('content.meter_reading.meter-reading',['action'=>'edit','breadcrumbs' => $breadcrumbs]);
    }
    public function publish(){
        $breadcrumbs = [
            ['link' => "meter-reading/meter-reading-list", 'name' => "Meter Reading"], ['name' => "Create"]
        ];
        return view('content.meter_reading.meter-reading',['action'=>'publish','breadcrumbs' => $breadcrumbs]);
    }

    public function publishCommonArea(){
        $breadcrumbs = [
            ['link' => "meter-reading/meter-reading-publish-common-area", 'name' => "Meter Reading"], ['name' => "Publish"]
        ];
        return view('content.meter_reading.meter-reading',['action'=>'publishCommonArea','breadcrumbs' => $breadcrumbs]);
    }

    public function meterCommon(){
        $breadcrumbs = [
            ['link' => "meter-reading/meter-reading-list", 'name' => "Meter Reading"], ['name' => "Common Master"]
        ];
        return view('content.meter_reading.meter-reading',['action'=>'meterCommon','breadcrumbs' => $breadcrumbs]);
    }



}
