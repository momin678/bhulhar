<?php

namespace App\Http\Controllers\backend;

use App\Cursher;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CursherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $crushers = Cursher::all();
        return view('backend.crusher.index', compact('crushers'));
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
        $crusher = new Cursher;
        $crusher->name = $request->name;
        $crusher->save();
        $notification= array(
            'message'       => 'Crusher name add successfully!',
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
        $crusher = Cursher::find($id);
        $crusher->name = $request->name;
        $crusher->save();
        $notification= array(
            'message'       => 'Crusher name Update successfully!',
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
    public function crusher_edit_model(Request $request){
        $crusher = Cursher::find($request->crusher_id);
        return view('backend.crusher.edit', compact('crusher'));
    }
}
