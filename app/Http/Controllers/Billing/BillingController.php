<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index(){
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"], ['name' => "Billing Department List"]
        ];
          return view('content.billing.billing',['action'=>'list'],['breadcrumbs' => $breadcrumbs]);
      }
      public function create(){
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"],['link' => "billing/billing-list", 'name' => "Billing Department"], ['name' => "Create"]
        ];
          return view('content.billing.billing',['action'=>'new'],['breadcrumbs' => $breadcrumbs]);
      }
      public function edit($id){
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"], ['link' => "billing/billing-list", 'name' => "Billing Department"], ['name' => "Update"]
        ];
          return view('content.billing.billing',['action'=>'edit','breadcrumbs' => $breadcrumbs,'editID' => $id]);
      }
}
