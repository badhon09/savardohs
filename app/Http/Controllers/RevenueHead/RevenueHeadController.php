<?php

namespace App\Http\Controllers\RevenueHead;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RevenueHeadController extends Controller
{
  public function index(){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"], ['name' => "Revenue Head List"]
    ];
      return view('content.revenue.revenue_head.revenue_head',['action'=>'list'],['breadcrumbs' => $breadcrumbs]);
  }
  public function create(){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"],['link' => "revenue-head/revenue-head-list", 'name' => "Revenue Head"], ['name' => "Create"]
    ];
      return view('content.revenue.revenue_head.revenue_head',['action'=>'new'],['breadcrumbs' => $breadcrumbs]);
  }
  public function edit($id){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"], ['link' => "revenue-head/revenue-head-list", 'name' => "Revenue Head"], ['name' => "Update"]
    ];
      return view('content.revenue.revenue_head.revenue_head',['action'=>'edit','breadcrumbs' => $breadcrumbs,'editID' => $id]);
  }
  public function delete($id){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"],['link' => "revenue-head/revenue-head-list", 'name' => "Revenue Head"], ['name' => "Delete"]
    ];
      return view('content.revenue.revenue_head.revenue_head',['action'=>'delete','breadcrumbs' => $breadcrumbs,'deleteID' => $id]);
  }

  public function store(Request $r){
      return $r;
  }
}
