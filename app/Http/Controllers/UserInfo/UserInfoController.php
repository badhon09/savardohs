<?php

namespace App\Http\Controllers\UserInfo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserInfoController extends Controller
{
  public function index(){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"], ['name' => "User Info List"]
    ];
      return view('content.user.user_info.user_info',['action'=>'list'],['breadcrumbs' => $breadcrumbs]);
  }
  public function create(){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"],['link' => "user-info/user-info-list", 'name' => "User Info"], ['name' => "Create"]
    ];
      return view('content.user.user_info.user_info',['action'=>'new'],['breadcrumbs' => $breadcrumbs]);
  }
  public function edit($id){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"], ['link' => "user-info/user-info-list", 'name' => "User Info"], ['name' => "Update"]
    ];
      return view('content.user.user_info.user_info',['action'=>'edit','breadcrumbs' => $breadcrumbs,'editID' => $id]);
  }
  public function delete($id){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"],['link' => "user-info/user-info-list", 'name' => "User Info"], ['name' => "Delete"]
    ];
      return view('content.user.user_info.user_info',['action'=>'delete','breadcrumbs' => $breadcrumbs,'deleteID' => $id]);
  }

  public function store(Request $r){
      return $r;
  }
}
