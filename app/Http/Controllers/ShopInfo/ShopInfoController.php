<?php

namespace App\Http\Controllers\ShopInfo;

use App\Http\Controllers\Controller;
use App\Models\ShopInfo;
use Illuminate\Http\Request;

class ShopInfoController extends Controller
{
  public function index(){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"], ['name' => Config('revenue.label')." Info List"]
    ];
      return view('content.shop.shop_info.shop_info',['action'=>'list'],['breadcrumbs' => $breadcrumbs]);
  }
  public function create(){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"],['link' => "shop-info/shop-info-list", 'name' => Config('revenue.label')." Info"], ['name' => "Create"]
    ];
      return view('content.shop.shop_info.shop_info',['action'=>'new'],['breadcrumbs' => $breadcrumbs]);
  }
  public function edit($id){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"], ['link' => "shop-info/shop-info-list", 'name' => Config('revenue.label')." Info"], ['name' => "Update"]
    ];
      return view('content.shop.shop_info.shop_info',['action'=>'edit'],['breadcrumbs' => $breadcrumbs,'editID'=>$id]);
  }
  public function delete($id){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"],['link' => "shop-info/shop-info-list", 'name' => Config('revenue.label')." Info"], ['name' => "Delete"]
    ];
      return view('content.shop.shop_info.shop_info',['action'=>'delete'],['breadcrumbs' => $breadcrumbs]);
  }

  public function store(Request $r){
      return $r;
  }
}
