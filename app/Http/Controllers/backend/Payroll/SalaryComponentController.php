<?php

namespace App\Http\Controllers\backend\Payroll;

use App\Http\Controllers\Controller;
use App\Mapping;
use App\Models\Payroll\SalaryStructure;
use App\Models\AccountHead;
use App\Models\Payroll\SalaryComponent;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class SalaryComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //Gate::authorize('app.mapping.index');
        $components = SalaryComponent::orderBy('id', 'desc')->get();
        // $accoutHeads = AccountHead::all();
        // dd($facitities);
        
        return view('backend.payroll.salary_components.index', compact('components'));
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
        SalaryComponent::create([
            'name' => $request->head,
        ]);
        $notification= array(
            'message'       => 'Added successfully!',
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
        
        $componemts_info = SalaryComponent::find($id);
        $components = SalaryComponent::orderBy('id', 'desc')->get();
        return Response()->json([
            'page' => view('backend.payroll.salary_components.edit-modal', ['components' => $components,
                                                                            'componemts_info' => $componemts_info])->render(),

        ]);
        // return view('backend.payroll.salary_components.edit', compact('componemts_info', 'components'));
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
        SalaryComponent::find($id)->update([
            'name' => $request->head
        ]);
        $notification= array(
            'message'       => 'Update successfully!',
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
        $salaryStructure = SalaryComponent::find($id);
        $salaryStructure->delete();
        $notification = array(
            'message'       => 'Deleted successfully!',
            'alert-type'    => 'success'
        );
        return redirect('salary-structures')->with($notification);
    }
}
