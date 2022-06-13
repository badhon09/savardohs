<?php

namespace App\Http\Controllers\Institute;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institute;

class InstituteController extends Controller
{
  public function index(){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"], ['name' => "Institute List"]
    ];
      return view('content.institute.institute_info',['action'=>'list'],['breadcrumbs' => $breadcrumbs]);
  }
  public function create(){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"],['link' => "institute/institute-list", 'name' => "Institute"], ['name' => "Create"]
    ];
      return view('content.institute.institute_info',['action'=>'new'],['breadcrumbs' => $breadcrumbs]);
  }
  public function edit($id){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"], ['link' => "institute/institute-list", 'name' => "Institute"], ['name' => "Update"]
    ];
      return view('content.institute.institute_info',['action'=>'edit','breadcrumbs' => $breadcrumbs,'editID' => $id]);
  }
  public function delete($id){
    $breadcrumbs = [
        ['link' => "home", 'name' => "Home"],['link' => "institute/institute-list", 'name' => "Institute"], ['name' => "Delete"]
    ];
      return view('content.institute.institute_info',['action'=>'delete','breadcrumbs' => $breadcrumbs,'deleteID' => $id]);
  }

  public function store(Request $r){
      return $r;
  }

}
