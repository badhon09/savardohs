<?php

namespace App\Http\Controllers\UserType;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserTypeController extends Controller
{
  public function index(){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"], ['name' => "User Type List"]
    ];
      return view('content.user.user_type.user_type',['action'=>'list'],['breadcrumbs' => $breadcrumbs]);
  }
  public function create(){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"],['link' => "user-type/user-type-list", 'name' => "User Type"], ['name' => "Create"]
    ];
      return view('content.user.user_type.user_type',['action'=>'new'],['breadcrumbs' => $breadcrumbs]);
  }
  public function edit($id){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"], ['link' => "user-type/user-type-list", 'name' => "User Type"], ['name' => "Update"]
    ];
      return view('content.user.user_type.user_type',['action'=>'edit','breadcrumbs' => $breadcrumbs,'editID' => $id]);
  }
  public function delete($id){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"],['link' => "user-type/user-type-list", 'name' => "User Type"], ['name' => "Delete"]
    ];
      return view('content.user.user_type.user_type',['action'=>'delete','breadcrumbs' => $breadcrumbs,'deleteID' => $id]);
  }

  public function store(Request $r){
      return $r;
  }
}
