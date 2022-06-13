<?php

namespace App\Http\Controllers\Mapping;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopMappingController extends Controller
{
    public function index(){
        return view('content.shop.mapping.shop-mapping',['action'=>'list']);
    }
    public function create(){

        return view('content.shop.mapping.shop-mapping',['action'=>'new']);
    }
    public function edit($id){

        return view('content.shop.mapping.shop-mapping',['action'=>'edit']);
    }
    public function delete($id){

        return view('content.shop.mapping.shop-mapping',['action'=>'delete']);
    }

    public function store(Request $r){
        return $r;
    }
}
