<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"], ['name' => "Menu List"]
        ];
        $menuList = DB::table('dohs_menu')->where('billing_dept_id',Auth::user()->billing_dept_id)->where('is_active',1)->get();
        
        return view('content.menu.menu-list')->with(compact('menuList','breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"], ['link' => "menu-list", 'name' => "Menu List"],['name' => "Menu create"]
        ];
        $parent_menu = DB::table('dohs_menu')->where('menu_parent_id',null)->where('sub_menu_id',null)->where('is_child',0)->get();
        $sub_menu = DB::table('dohs_menu')->whereNotNull('menu_parent_id')->where('sub_menu_id',null)->where('is_child',0)->get();
        return view('content.menu.menu-create')->with(compact('breadcrumbs','parent_menu','sub_menu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $request->validate([
            'menu_type' => 'required',
            'menu_name' => 'required|max:100',
            'menu_name_bn' => 'required|max:100',
            'route_id' => 'required|max:255',
            'seq_number' => 'required',
            'icon_name' => 'max:100',
        ]);
        if($request->menu_type == 3){
            $is_child =1;
        }else{
            $is_child =0;            
        }
        DB::table('dohs_menu')->insert([
            'billing_dept_id' => Auth::user()->billing_dept_id,
            'is_active' => '1',
            'is_child' => $is_child,
            'is_newtab' => $request->is_newtab,
            'menu_name' => $request->menu_name,
            'menu_name_bn' => $request->menu_name_bn,
            'menu_parent_id' => $request->menu_parent_id,
            'sub_menu_id' => $request->sub_menu_id,
            'route_id' => $request->route_id,
            'seq_number' => $request->seq_number,
            'icon_name' => $request->icon_name,
        ]);
        session()->flash('server_message', 'data insert succesfull');
        return redirect()->to('menu-list');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"], ['link' => "menu-list", 'name' => "Menu List"],['name' => "Menu Update"]
        ];

        $parent_menu = DB::table('dohs_menu')->where('menu_parent_id',null)->where('sub_menu_id',null)->where('is_child',0)->get();
        $sub_menu = DB::table('dohs_menu')->whereNotNull('menu_parent_id')->where('sub_menu_id',null)->where('is_child',0)->get();
        $data = DB::table('dohs_menu')->find($id);
        if($data->menu_parent_id == null && $data->sub_menu_id == null && $data->is_child == 0 ){
            //main menu type -1
            $menuType = 1;
        }elseif($data->menu_parent_id !== null && $data->sub_menu_id == null && $data->is_child == 0){
            //sub menu type -2
            $menuType = 2;
        }elseif($data->menu_parent_id !== null && $data->sub_menu_id !== null && $data->is_child == 1){
            //sub menu type -3
            $menuType = 3;
        }

        return view('content.menu.menu-edit')->with(compact('breadcrumbs','parent_menu','sub_menu','menuType','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        
        if($request->menu_type == 1){
            $request->validate([
                'menu_type' => 'required',
                'menu_name' => 'required|max:100',
                'menu_name_bn' => 'required|max:100',
                'route_id' => 'required|max:255',
                'seq_number' => 'required',
                'icon_name' => 'max:100',
            ]);
        }elseif($request->menu_type == 2){
            $request->validate([
                'menu_type' => 'required',
                'menu_name' => 'required|max:100',
                'menu_name_bn' => 'required|max:100',
                'menu_parent_id' => 'required',
                'route_id' => 'required|max:255',
                'seq_number' => 'required',
                'icon_name' => 'max:100',
            ]);            
        }else{
            $request->validate([
                'menu_type' => 'required',
                'menu_name' => 'required|max:100',
                'menu_name_bn' => 'required|max:100',
                'menu_parent_id' => 'required',
                'sub_menu_id' => 'required',
                'route_id' => 'required|max:255',
                'seq_number' => 'required',
                'icon_name' => 'max:100',
            ]);
        }
        $menuDt =  DB::table('dohs_menu')->find($id);
        $isFound =  DB::table('dohs_menu')
                        ->where('billing_dept_id',Auth::user()->billing_dept_id)
                        ->where('seq_number',$request->seq_number)
                        ->where('seq_number', '!=', $menuDt->seq_number)
                        ->count();
        if($isFound > 0){
            session()->flash('server_error', 'Seq Number already exist.');
            return redirect()->to('menu-edit/'.$id);
        }
        if($request->menu_type == 3){
            $is_child =1;
        }else{
            $is_child =0;            
        }
        DB::table('dohs_menu')->where('id', $id)->update([
            'billing_dept_id' => Auth::user()->billing_dept_id,
            'is_active' => $request->is_active,
            'is_child' => $is_child,
            'is_newtab' => $request->is_newtab,
            'menu_name' => $request->menu_name,
            'menu_name_bn' => $request->menu_name_bn,
            'menu_parent_id' => $request->menu_parent_id,
            'sub_menu_id' => $request->sub_menu_id,
            'route_id' => $request->route_id,
            'seq_number' => $request->seq_number,
            'icon_name' => $request->icon_name,
        ]);
        session()->flash('server_message', 'data update succesfull');
        return redirect()->to('menu-edit/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('dohs_menu')->where('id',$id)->delete();
        session()->flash('server_message', 'data delete succesfull');
        return redirect()->to('menu-delete/'.$id);
    }
}
