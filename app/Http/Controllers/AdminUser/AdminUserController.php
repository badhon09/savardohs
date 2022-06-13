<?php

namespace App\Http\Controllers\AdminUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
  public function index(){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"], ['name' => "Admin List"]
    ];
      return view('content.user.admin_user.admin_user',['action'=>'list'],['breadcrumbs' => $breadcrumbs]);
  }
  public function create(){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"],['link' => "admin-user/admin-user-list", 'name' => "Admin"], ['name' => "Create"]
    ];
      return view('content.user.admin_user.admin_user',['action'=>'new'],['breadcrumbs' => $breadcrumbs]);
  }
  public function edit($id){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"], ['link' => "admin-user/admin-user-list", 'name' => "Admin"], ['name' => "Update"]
    ];
      return view('content.user.admin_user.admin_user',['action'=>'edit','breadcrumbs' => $breadcrumbs,'editID' => $id]);
  }
}
