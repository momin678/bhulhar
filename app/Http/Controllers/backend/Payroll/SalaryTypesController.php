<?php

namespace App\Http\Controllers\backend\Payroll;

use App\Http\Controllers\Controller;
use App\Mapping;
use App\Models\Payroll\SalaryType;
use App\Models\AccountHead;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class SalaryTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //Gate::authorize('app.mapping.index');
        $salaryTypes = SalaryType::orderBy('id', 'desc')->get();
        // $accoutHeads = AccountHead::all();
        // dd($facitities);
        return view('backend.payroll.salary_types.index', compact('salaryTypes'));
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
            'salary_type' => 'required',
        ]);
        SalaryType::create([
            'salary_type' => $request->salary_type
        ]);
        $notification= array(
            'message'       => 'Salary type Added successfully!',
            'alert-type'    => 'success'
        );
        return redirect('salary-types')->with($notification);
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
        
        $salary_info = SalaryType::find($id);
        $salaryTypes = SalaryType::orderBy('id', 'desc')->get();
        return Response()->json([
            'page' => view('backend.payroll.salary_types.edit-modal', ['salary_info' => $salary_info,
                                                                            'salaryTypes' => $salaryTypes])->render(),

        ]);
        // return view('backend.payroll.salary_types.edit', compact('salary_info', 'salaryTypes'));
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
            'salary_type' => 'required',
        ]);
        SalaryType::find($id)->update([
            'salary_type' => $request->salary_type,
        ]);
        $notification= array(
            'message'       => 'Salary type Update successfully!',
            'alert-type'    => 'success'
        );
        return redirect('salary-types')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $salaryTypes = SalaryType::find($id);
        $salaryTypes->delete();
        $notification = array(
            'message'       => 'Salary type Deleted successfully!',
            'alert-type'    => 'success'
        );
        return redirect('salary-types')->with($notification);
    }
}
