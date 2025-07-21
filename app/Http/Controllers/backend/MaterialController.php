<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Material;
use App\TempTruckRecord;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materials = Material::all();
        return view('backend.material.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $material = new Material;
        $material->name = $request->name;
        $material->save();
        $notification= array(
            'message'       => 'Material name add successfully!',
            'alert-type'    => 'success'
        );

        return back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $material = Material::find($id);
        $material->name = $request->name;
        $material->save();
        $notification= array(
            'message'       => 'Material name Update successfully!',
            'alert-type'    => 'success'
        );

        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function material_edit_model(Request $request){
        $material = Material::find($request->material_id);
        return view('backend.material.edit', compact('material'));
    }
    public function add_new_materialPost(Request $request){
        $material = new Material;
        $material->name = $request->m_name;
        $material->save();
        $temp_record = TempTruckRecord::find($request->id);
        $temp_record->material = $request->m_name;
        $temp_record->save();
        return response()->json(['material' => $material]);
    }
}
