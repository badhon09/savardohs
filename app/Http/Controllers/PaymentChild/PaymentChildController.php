<?php

namespace App\Http\Controllers\PaymentChild;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentChildController extends Controller
{
  public function index(){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"], ['name' => "Payment List"]
    ];
      return view('content.payment.child.payment_child',['action'=>'list'],['breadcrumbs' => $breadcrumbs]);
  }
  public function create(){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"],['link' => "payment-child/payment-child-list", 'name' => "Payment"], ['name' => "Create"]
    ];
      return view('content.payment.child.payment_child',['action'=>'new'],['breadcrumbs' => $breadcrumbs]);
  }
  public function edit($id){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"], ['link' => "payment-child/payment-child-list", 'name' => "Payment"], ['name' => "Update"]
    ];
      return view('content.payment.child.payment_child',['action'=>'edit'],['breadcrumbs' => $breadcrumbs]);
  }
  public function delete($id){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"],['link' => "payment-child/payment-child-list", 'name' => "Payment"], ['name' => "Delete"]
    ];
      return view('content.payment.child.payment_child',['action'=>'delete'],['breadcrumbs' => $breadcrumbs]);
  }

  public function store(Request $r){
      return $r;
  }
}
