<?php

namespace App\Http\Controllers\ShopRateInfo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopRateInfoController extends Controller
{
  public function index(){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"], ['name' => Config('revenue.label')." Rate Info List"]
    ];
      return view('content.shop.shop_rate_info.shop_rate_info',['action'=>'list'],['breadcrumbs' => $breadcrumbs]);
  }
  public function create(){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"],['link' => "shop-rate-info/shop-rate-info-list", 'name' => Config('revenue.label')." Rate Info"], ['name' => "Create"]
    ];
      return view('content.shop.shop_rate_info.shop_rate_info',['action'=>'new'],['breadcrumbs' => $breadcrumbs]);
  }
  public function edit($id){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"], ['link' => "shop-rate-info/shop-rate-info-list", 'name' => Config('revenue.label')." Rate Info"], ['name' => "Update"]
    ];
      return view('content.shop.shop_rate_info.shop_rate_info',['action'=>'edit','breadcrumbs' => $breadcrumbs,'editID' => $id]);
  }
  public function delete($id){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"],['link' => "shop-rate-info/shop-rate-info-list", 'name' => Config('revenue.label')." Rate Info"], ['name' => "Delete"]
    ];
      return view('content.shop.shop_rate_info.shop_rate_info',['action'=>'delete','breadcrumbs' => $breadcrumbs,'deleteID' => $id]);
  }

  public function store(Request $r){
      return $r;
  }
}
