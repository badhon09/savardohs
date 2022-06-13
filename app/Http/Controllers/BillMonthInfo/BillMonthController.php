<?php

namespace App\Http\Controllers\BillMonthInfo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillMonthController extends Controller
{
  public function index(){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"], ['name' => "Bill Cycle Info List"]
    ];
      return view('content.billmonth.bill_month_info',['action'=>'list'],['breadcrumbs' => $breadcrumbs]);
  }
  public function create(){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"],['link' => "bill-month-info/bill-month-info-list", 'name' => "Bill Cycle Info"], ['name' => "Create"]
    ];
      return view('content.billmonth.bill_month_info',['action'=>'new'],['breadcrumbs' => $breadcrumbs]);
  }
  public function edit($id){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"], ['link' => "bill-month-info/bill-month-info-list", 'name' => "Bill Cycle Info"], ['name' => "Update"]
    ];
      return view('content.billmonth.bill_month_info',['action'=>'edit','breadcrumbs' => $breadcrumbs,'editID' => $id]);
  }
  public function delete($id){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"],['link' => "bill-month-info/bill-month-info-list", 'name' => "Bill Cycle Info"], ['name' => "Delete"]
    ];
      return view('content.billmonth.bill_month_info',['action'=>'delete','breadcrumbs' => $breadcrumbs,'deleteID' => $id]);
  }

  public function store(Request $r){
      return $r;
  }
}
