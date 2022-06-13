<?php

namespace App\Http\Controllers\Shop\Mapping;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopMappingController extends Controller
{
    public function index(){
        $breadcrumbs = [
            ['link' => "shop/mapping/mapping-list", 'name' => Config('revenue.label')." Mapping"], ['name' => "List"]
        ];
        return view('content.shop.mapping.shop-mapping',['action'=>'list','breadcrumbs' => $breadcrumbs]);
    }
    public function create(){
        $breadcrumbs = [
            ['link' => "shop/mapping/mapping-list", 'name' => Config('revenue.label')." Mapping"], ['name' => "Create"]
        ];
        return view('content.shop.mapping.shop-mapping',['action'=>'new','breadcrumbs' => $breadcrumbs]);
    }

    public function store(Request $r){
        return $r;
    }
}
