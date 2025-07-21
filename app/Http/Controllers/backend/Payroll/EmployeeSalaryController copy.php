<?php

namespace App\Http\Controllers\backend\Payroll;

use App\Http\Controllers\Controller;
use App\Mapping;
use App\Models\Payroll\EmployeeSalary;
use App\Models\Payroll\Employee;
use App\Models\Payroll\SalaryStructure;
use App\Models\AccountHead;
use App\Models\Payroll\SalaryStructureStory;
use App\Models\Payroll\SalaryType;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class EmployeeSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //Gate::authorize('app.mapping.index');
        $employeeSalarys = EmployeeSalary::orderBy('id', 'desc')->get();
        $employees = Employee::all();
        $wages_type = SalaryType::all();
        $salaryStructure = SalaryStructure::all()->toArray();

        // dd($salaryStructure['1']['id']);
        return view('backend.payroll.employee_salary.index', compact('employeeSalarys', 'employees', 'salaryStructure','wages_type'));
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
            'basic' => 'required',
            'employee_id' => 'required|unique:employee_salaries',
        ]);
        $emp_info = Employee::find($request->employee_id);
        // dd($emp_info);
        $info = EmployeeSalary::create([
            'employee_id' => $request->employee_id,
            'basic' => $request->basic,
            'house_rent' => $request->house_rent,
            'transportation' => $request->transportation,
            'bonus' => $request->bonus,
            'telephone_bill' => $request->telephone_bill,
            'ta' => $request->ta,
            'da' => $request->da,
            'medical_expenses' => $request->medical_expenses,
            'vacation_bonus' => $request->vacation_bonus,
            'tax_reduction' => $request->tax_reduction,
            'providant_fund' => $request->providant_fund,
            'gratuity' => $request->gratuity,
            'others' => $request->others,
            'total' => $request->total
        ]);

        SalaryStructureStory::create([
            'employee_id' => $info->employee_id,
            'basic' => $info->basic,
            'house_rent' => $info->house_rent,
            'transportation' => $info->transportation,
            'bonus' => $info->bonus,
            'telephone_bill' => $info->telephone_bill,
            'ta' => $info->ta,
            'da' => $info->da,
            'medical_expenses' => $info->medical_expenses,
            'vacation_bonus' => $info->vacation_bonus,
            'tax_reduction' => $info->tax_reduction,
            'providant_fund' => $info->providant_fund,
            'gratuity' => $info->gratuity,
            'others' => $info->others,
            'form' => $emp_info->joining_date,
            'total' => $info->total
        ]);

        $notification= array(
            'message'       => 'Employee Salary Added successfully!',
            'alert-type'    => 'success'
        );
        return redirect('employee-salary')->with($notification);
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
        
        $employeeSalary_info = EmployeeSalary::find($id);
        $employeeSalarys = EmployeeSalary::orderBy('id', 'desc')->get();
        $employees = Employee::all();
        $wages_type =  Employee::where('id', $employeeSalary_info->employee_id)->first();
        // dd($wages_type);
        $salaryStructure = SalaryStructure::all()->toArray();
        return view('backend.payroll.employee_salary.edit', compact('employeeSalary_info', 'employeeSalarys', 'employees', 'salaryStructure','wages_type'));
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
        // dd($request->all());
        $request->validate([
            'basic' => 'required',
        ]);

        $check=EmployeeSalary::find($id);
        

         EmployeeSalary::find($id)->update([
            'employee_id' => $request->employee_id,
            'basic' => $request->basic,
            'house_rent' => $request->house_rent,
            'transportation' => $request->transportation,
            'bonus' => $request->bonus,
            'telephone_bill' => $request->telephone_bill,
            'ta' => $request->ta,
            'da' => $request->da,
            'medical_expenses' => $request->medical_expenses,
            'vacation_bonus' => $request->vacation_bonus,
            'tax_reduction' => $request->tax_reduction,
            'providant_fund' => $request->providant_fund,
            'gratuity' => $request->gratuity,
            'others' => $request->others,
            'total' => $request->total,
        ]);

        //update to date
        
        // $info = EmployeeSalary::find($id);
        $last = SalaryStructureStory::where('employee_id', $request->employee_id)->get()->last();
        $to_date = EmployeeSalary::find($id);
        SalaryStructureStory::find($last->id)->update([
            'to' => $to_date->updated_at,
        ]);

    //create new story
        SalaryStructureStory::create([
            'employee_id' => $to_date->employee_id,
            'basic' => $to_date->basic,
            'house_rent' => $to_date->house_rent,
            'transportation' => $to_date->transportation,
            'bonus' => $to_date->bonus,
            'telephone_bill' => $to_date->telephone_bill,
            'ta' => $to_date->ta,
            'da' => $to_date->da,
            'medical_expenses' => $to_date->medical_expenses,
            'vacation_bonus' => $to_date->vacation_bonus,
            'tax_reduction' => $to_date->tax_reduction,
            'providant_fund' => $to_date->providant_fund,
            'gratuity' => $to_date->gratuity,
            'others' => $to_date->others,
            'total' => $to_date->total,
            'form' => $to_date->updated_at,
        ]);

        $notification= array(
            'message'       => 'Employee Salary Update successfully!',
            'alert-type'    => 'success'
        );
        return redirect('employee-salary')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employeeSalary = EmployeeSalary::find($id);
        $employeeSalary->delete();
        $notification = array(
            'message'       => 'Employee Salary Deleted successfully!',
            'alert-type'    => 'success'
        );
        return redirect('employee-salary')->with($notification);
    }
}
