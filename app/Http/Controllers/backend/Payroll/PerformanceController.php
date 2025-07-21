<?php

namespace App\Http\Controllers\backend\Payroll;

use App\Http\Controllers\Controller;
use App\Mapping;
use App\Models\Payroll\EmployeeBank;
use App\Models\AccountHead;
use App\Models\Payroll\BankBranch;
use App\Models\Payroll\Employee;
use App\Models\Payroll\EmployeeSalary;
use App\Models\Payroll\YearlyPerformance;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class PerformanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //Gate::authorize('app.mapping.index');
        $performance = YearlyPerformance::orderBy('id', 'desc')->get();
        $employees = Employee::orderBy('id', 'desc')->get();
        // $accoutHeads = AccountHead::all();
        // dd($facitities);
        return view('backend.payroll.performance_management.yearly.index', compact('performance','employees'));
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
            'employee_id' => 'required',
        ]);

        if ($request->file('files')) {
            $name= $request->file('files')->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext= $request->file('files')->getClientOriginalExtension();
            $docuument= 'performance'.time().'.'.$ext;
            
            $request->file('files')->storeAs( 'public/upload/performance', $docuument);
        }

        YearlyPerformance::create([
            'employee_id' => $request->employee_id,
            'discussion' => $request->discussion,
            'performance_result' => $request->performance_result,
            'company_contribution' => $request->company_contribution,
            'proposed_compensation' => $request->proposed_compensation,
            'country_inflation_rate' => $request->country_inflation_rate,
            'docuument' => $docuument,
        ]);
        $notification= array(
            'message'       => 'Added successfully!',
            'alert-type'    => 'success'
        );
        return redirect('performance-management')->with($notification);
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
        
        $performance_info = YearlyPerformance::find($id);
        $performance = YearlyPerformance::orderBy('id', 'desc')->get();
        $employees = Employee::orderBy('id', 'desc')->get();
        return view('backend.payroll.performance_management.yearly.edit', compact('performance_info', 'performance','employees'));
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

    public function employeeInfo(Request $request)
    {
        // return 1;
        $emp_name=Employee::find($request->emp);
        $check=EmployeeSalary::where('employee_id',$request->emp)->get();
        if($check->count()>0)
        {
            $check_unique = 'yes';
        }else{
            $check_unique = 'no';
        }
        if($emp_name->count()>0)
        {
            if ($request->ajax()) {
                return Response()->json([
                    'page' => $emp_name,
                    'wages' => $emp_name->items->salary_type,
                    'check_unique' => $check_unique,

                ]);
            }
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
