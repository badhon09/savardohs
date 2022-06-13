<?php

namespace App\Http\Controllers;

use App\Models\Dohs\FlatInfo;
use Illuminate\Http\Request;

class FlatInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"], ['name' => "Index"]
        ];
        return view('content.flat-info-create', ['breadcrumbs' => $breadcrumbs]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dohs\FlatInfo  $flatInfo
     * @return \Illuminate\Http\Response
     */
    public function show(FlatInfo $flatInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dohs\FlatInfo  $flatInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(FlatInfo $flatInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dohs\FlatInfo  $flatInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FlatInfo $flatInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dohs\FlatInfo  $flatInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(FlatInfo $flatInfo)
    {
        //
    }
}
