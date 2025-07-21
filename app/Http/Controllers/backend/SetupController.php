<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Setup;
class SetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setups = Setup::all();
        return view('backend.setup.index', compact('setups'));
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
        $request->validate([
            'name'   => 'required|unique:setups',
            'value'   => 'required'
        ]);

        $setup= new Setup;
        $setup->name      = $request->name;
        $setup->value      = $request->value;
        $setup->save();

        $notification= array(
            'message'       => 'Setup Saved!',
            'alert-type'    => 'success'
        );
        return redirect('company-setup')->with($notification);
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
        $request->validate([
            'name'   => 'required',
            'value'   => 'required'
        ]);

        $setup= Setup::find($id);
        $setup->name      = $request->name;
        $setup->value      = $request->value;
        $setup->save();

        $notification= array(
            'message'       => 'Setup Updated!',
            'alert-type'    => 'success'
        );
        return redirect('company-setup')->with($notification);
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
    public function setup_edit_modal(Request $request){
        $edit_setup= Setup::find($request->id);
        return view('backend.setup.setting-edit-modal', compact('edit_setup'));
    }
}
