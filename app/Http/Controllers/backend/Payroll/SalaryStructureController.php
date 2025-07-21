<?php

namespace App\Http\Controllers\backend\Payroll;

use App\Http\Controllers\Controller;
use App\Mapping;
use App\Models\Payroll\SalaryStructure;
use App\Models\AccountHead;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class SalaryStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //Gate::authorize('app.mapping.index');
        $salaryStructures = SalaryStructure::orderBy('id', 'desc')->get();
        // $accoutHeads = AccountHead::all();
        // dd($facitities);
        return view('backend.payroll.salary_structures.index', compact('salaryStructures'));
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
        // dd($request);
        $request->validate([
            'head' => 'required',
        ]);
        SalaryStructure::create([
            'head' => $request->head,
            'type' => $request->type,
            'value' => $request->value
        ]);
        $notification= array(
            'message'       => 'Salary Structures Added successfully!',
            'alert-type'    => 'success'
        );
        return redirect('salary-structures')->with($notification);
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
        
        $salaryStructures_info = SalaryStructure::find($id);
        $salaryStructures = SalaryStructure::orderBy('id', 'desc')->get();
        return view('backend.payroll.salary_structures.edit', compact('salaryStructures_info', 'salaryStructures'));
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
            'head' => 'required',
        ]);
        SalaryStructure::find($id)->update([
            'head' => $request->head,
            'type' => $request->type,
            'value' => $request->value
        ]);
        $notification= array(
            'message'       => 'Salary Structures Update successfully!',
            'alert-type'    => 'success'
        );
        return redirect('salary-structures')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $salaryStructure = SalaryStructure::find($id);
        $salaryStructure->delete();
        $notification = array(
            'message'       => 'Salary Structures Deleted successfully!',
            'alert-type'    => 'success'
        );
        return redirect('salary-structures')->with($notification);
    }
}
