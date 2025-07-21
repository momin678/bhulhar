<?php

namespace App\Http\Controllers\backend\Payroll;

use App\Http\Controllers\Controller;
use App\Mapping;
use App\Models\Payroll\SalaryType;
use App\Models\AccountHead;
use App\Models\Payroll\Department;
use App\Models\Payroll\Division;
use App\Models\Payroll\Nationality;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //Gate::authorize('app.mapping.index');
        $items = Department::orderBy('id', 'desc')->get();
        $divisions = Division::orderBy('id', 'desc')->get();
        // $accoutHeads = AccountHead::all();
        // dd($facitities);
        return view('backend.payroll.department.index', compact('items', 'divisions'));
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
            'name' => 'required',
        ]);
        Department::create([
            'division_id' => $request->division_id,
            'name' => $request->name
        ]);
        $notification= array(
            'message'       => 'Designation Added successfully!',
            'alert-type'    => 'success'
        );
        return redirect('hr/payroll/department')->with($notification);
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
        
        $info = Department::find($id);
        $items = Department::orderBy('id', 'desc')->get();
        $divisions = Division::orderBy('id', 'desc')->get();
        return Response()->json([
            'page' => view('backend.payroll.department.edit-modal', ['info' => $info,
                                                                     'items' => $items,
                                                                     'divisions' => $divisions])->render(),

        ]);
        // return view('backend.payroll.department.edit', compact('info', 'items'));
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
        // dd(1);
        $request->validate([
            'name' => 'required',
        ]);
        Department::find($id)->update([
            'division_id' => $request->division_id,
            'name' => $request->name,
        ]);
        $notification= array(
            'message'       => 'Designation Updated Successfully!',
            'alert-type'    => 'success'
        );
        return redirect('hr/payroll/department')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $salaryTypes = SalaryType::find($id);
    //     $salaryTypes->delete();
    //     $notification = array(
    //         'message'       => 'Salary type Deleted successfully!',
    //         'alert-type'    => 'success'
    //     );
    //     return redirect('salary-types')->with($notification);
    // }
}
