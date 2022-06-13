<?php

namespace App\Http\Controllers\ShopType;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopTypeController extends Controller
{
  public function index(){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"], ['name' => Config('revenue.label')." Type List"]
    ];
      return view('content.shop.shop_type.shop_type',['action'=>'list'],['breadcrumbs' => $breadcrumbs]);
  }
  public function create(){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"],['link' => "shop-type/shop-type-list", 'name' => Config('revenue.label')." Type"], ['name' => "Create"]
    ];
      return view('content.shop.shop_type.shop_type',['action'=>'new'],['breadcrumbs' => $breadcrumbs]);
  }
  public function edit($id){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"], ['link' => "shop-type/shop-type-list", 'name' => Config('revenue.label')." Type"], ['name' => "Update"]
    ];
      return view('content.shop.shop_type.shop_type',['action'=>'edit','breadcrumbs' => $breadcrumbs,'editID' => $id]);
  }
  public function delete($id){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"],['link' => "shop-type/shop-type-list", 'name' => Config('revenue.label')." Type"], ['name' => "Delete"]
    ];
      return view('content.shop.shop_type.shop_type',['action'=>'delete','breadcrumbs' => $breadcrumbs,'deleteID' => $id]);
  }

  public function store(Request $r){
      return $r;
  }
}
