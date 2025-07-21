<?php

namespace App\Http\Controllers\backend\Payroll;

use App\Http\Controllers\Controller;
use App\Mapping;
use App\Models\Payroll\EmployeeBank;
use App\Models\AccountHead;
use App\Models\Payroll\BankBranch;
use App\Models\Payroll\Employee;
use App\Models\Payroll\EmployeeSalary;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class EmployeeBankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //Gate::authorize('app.mapping.index');
        $employeeBanks = EmployeeBank::orderBy('id', 'desc')->get();
        $employees = Employee::orderBy('id', 'desc')->get();
        $bankBranch = BankBranch::orderBy('id', 'desc')->get();
        // $accoutHeads = AccountHead::all();
        // dd($facitities);
        return view('backend.payroll.employee_banks.index', compact('employeeBanks','bankBranch','employees'));
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
            'bank_name' => 'required',
        ]);
        EmployeeBank::create([
            'employee_id' => $request->employee_id,
            'account_title' => $request->account_title,
            'bank_name' => $request->bank_name,
            'branch_name' => $request->branch_name,
            'account_number' => $request->account_number,
            'routing_number' => $request->routing_number,
        ]);
        $notification= array(
            'message'       => 'Emloyee Banks Added successfully!',
            'alert-type'    => 'success'
        );
        return redirect('employee-banks')->with($notification);
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
        
        $employeeBnak_info = EmployeeBank::find($id);
        $employeeBanks = EmployeeBank::orderBy('id', 'desc')->get();
        $employees = Employee::orderBy('id', 'desc')->get();
        $bankBranch = BankBranch::orderBy('id', 'desc')->get();
        return view('backend.payroll.employee_banks.edit', compact('employeeBnak_info', 'employeeBanks','bankBranch','employees'));
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
            'bank_name' => 'required',
        ]);
        EmployeeBank::find($id)->update([
            'employee_id' => $request->employee_id,
            'account_title' => $request->account_title,
            'bank_name' => $request->bank_name,
            'branch_name' => $request->branch_name,
            'account_number' => $request->account_number,
            'routing_number' => $request->routing_number,
        ]);
        $notification= array(
            'message'       => 'Employee Banks Update successfully!',
            'alert-type'    => 'success'
        );
        return redirect('employee-banks')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employeeBank = EmployeeBank::find($id);
        $employeeBank->delete();
        $notification = array(
            'message'       => 'Employee Bank Deleted successfully!',
            'alert-type'    => 'success'
        );
        return redirect('employee-banks')->with($notification);
    }

    public function employeeInfo(Request $request) {
        // return 1;
        if ($request->has('emp')) {
            $emp_name=Employee::find($request->emp);
        }elseif($request->has('id')){
            $emp_name = Employee::where('emp_id', $request->id)->first();
        }elseif($request->has('division')){
            $emp_name = Employee::where('division', $request->division)->get();
        }
       
        if ($request->ajax()) {
            return Response()->json([
                'page' => $emp_name,
            ]);
        }
    }

    public function bankInfo(Request $request)
    {
        // return 1;
        $emp_name=BankBranch::find($request->id);
        if($emp_name->count()>0)
        {
            if ($request->ajax()) {
                return Response()->json([
                    'page' => $emp_name,

                ]);
            }
        }
    }

}
