<?php

namespace App\Http\Controllers\PaymentMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentMasterController extends Controller
{
  public function index(){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"], ['name' => "Payment List"]
    ];
      return view('content.payment.master.payment_master',['action'=>'list'],['breadcrumbs' => $breadcrumbs]);
  }
  public function create(){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"],['link' => "payment-master/payment-master-list", 'name' => "Payment"], ['name' => "Create"]
    ];
      return view('content.payment.master.payment_master',['action'=>'new'],['breadcrumbs' => $breadcrumbs]);
  }
  public function edit($id){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"], ['link' => "payment-master/payment-master-list", 'name' => "Payment"], ['name' => "Update"]
    ];
      return view('content.payment.master.payment_master',['action'=>'edit'],['breadcrumbs' => $breadcrumbs]);
  }
  public function delete($id){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"],['link' => "payment-master/payment-master-list", 'name' => "Payment"], ['name' => "Delete"]
    ];
      return view('content.payment.master.payment_master',['action'=>'delete'],['breadcrumbs' => $breadcrumbs]);
  }

  public function store(Request $r){
      return $r;
  }
}
