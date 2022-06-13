<?php

namespace App\Http\Controllers\Revenue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
  public function index(){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"], ['name' => "Revenue List"]
    ];
      return view('content.revenue.revenue.revenue',['action'=>'list'],['breadcrumbs' => $breadcrumbs]);
  }
  public function create(){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"],['link' => "revenue/revenue-list", 'name' => "Revenue"], ['name' => "Create"]
    ];
      return view('content.revenue.revenue.revenue',['action'=>'new'],['breadcrumbs' => $breadcrumbs]);
  }
  public function edit($id){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"], ['link' => "revenue/revenue-list", 'name' => "Revenue"], ['name' => "Update"]
    ];
      return view('content.revenue.revenue.revenue',['action'=>'edit','breadcrumbs' => $breadcrumbs,'editID'=>$id]);
  }
  public function delete($id){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"],['link' => "revenue/revenue-list", 'name' => "Revenue"], ['name' => "Delete"]
    ];
      return view('content.revenue.revenue.revenue',['action'=>'delete'],['breadcrumbs' => $breadcrumbs]);
  }

  public function store(Request $r){
      return $r;
  }
}
