<?php

namespace App\Http\Controllers\Settlement;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettlementController extends Controller
{
    public function index(){
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"], ['name' => "Settlement List"]
        ];
          return view('content.settlement.settlement',['action'=>'list'],['breadcrumbs' => $breadcrumbs]);
      }
      public function create(){
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"],['link' => "settlement/settlement-list", 'name' => "Settlement"], ['name' => "Create"]
        ];
          return view('content.settlement.settlement',['action'=>'new'],['breadcrumbs' => $breadcrumbs]);
      }
      public function edit($id){
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"], ['link' => "settlement/settlement-list", 'name' => "Settlement"], ['name' => "Update"]
        ];
          return view('content.settlement.settlement',['action'=>'edit','breadcrumbs' => $breadcrumbs,'editID' => $id]);
      }
}
