<?php

namespace App\Http\Controllers\backend\Payroll;

use App\Http\Controllers\Controller;
use App\Mapping;
use App\Models\Payroll\EmployeeSalary;
use App\Models\Payroll\Employee;
use App\Models\Payroll\SalaryStructure;
use App\Models\AccountHead;
use App\Models\Payroll\ComponentType;
use App\Models\Payroll\ExtraSalaryComponentHistory;
use App\Models\Payroll\GradeWiseSalaryComponentHistory;
use App\Models\Payroll\PaySalary;
use App\Models\Payroll\SalaryComponent;
use App\Models\Payroll\SalaryProcess;
use App\Models\Payroll\SalaryStructureStory;
use App\Models\Payroll\SalaryType;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use Carbon\Carbon;
class SalaryprocessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        Gate::authorize('app.mapping.index');
        $employeeSalarys = SalaryProcess::where('status', 1)->orderBy('id', 'desc')->get();
        $employees = Employee::all();
        $wages_type = SalaryType::all();
        $salaryStructure = SalaryStructure::all()->toArray();

        // dd($salaryStructure['1']['id']);
        return view('backend.payroll.salary_process.index', compact('employeeSalarys', 'employees', 'salaryStructure','wages_type'));
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
        Gate::authorize('app.mapping.index');
        $date = Carbon::now();
        $monthName = $request->month;
        $year = $request->year;

        $check=SalaryProcess::where('month', $monthName)->where('year', $year)->where('status', 0)->get();
        // dd($monthName);


        if(count($check) == 0)
        {
            $employees = EmployeeSalary::orderBy('id', 'desc')->get();

            foreach ($employees as $item){
                    SalaryProcess::create([
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
            }

            $notification= array(
                'message'       => 'Salary Sheet Create successfully!',
                'alert-type'    => 'success'
            );
            
        }else{
            $notification= array(
                'message'       => 'This months salary sheet already created!',
                'alert-type'    => 'success'
            );
        };


        return redirect('pay-salary')->with($notification);
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
        
        
        // $employeeSalary_info = SalaryProcess::where('employee_id',$id)->where('status', 1)->get();
        // dd($employeeSalary_info->salary_component_id);
        $components = SalaryComponent::orderBy('id', 'desc')->get();
        $component_types = ComponentType::orderBy('id', 'desc')->get();
        $employee = Employee::find($id);
        // dd($wages_type);
        $salaryStructure = SalaryStructure::all()->toArray();
        return view('backend.payroll.salary_process.edit', compact('components', 'component_types', 'employee'));
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
        $process =  SalaryProcess::where('employee_id',$id)->where('status',1)->first();
        $month = $process->month;
        $year = $process->year;
        SalaryProcess::where('employee_id',$id)->where('status',1)->delete();


        foreach ($request->records['head'] as $key => $value) {
            
            SalaryProcess::create([
                    'type_id' => $request->records['type'][$key],
                    'employee_id' => $id,
                    'salary_component_id' => $request->records['head'][$key],
                    'month' => $month,
                    'year' => $year,
                    'amount' => $request->records['amount'][$key],
                ]);
        }
        $request->validate([
            'basic' => 'required',
        ]);
        SalaryProcess::find($id)->update([
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
            'deduction' => $request->deduction,
            'others' => $request->others,
            'total' => $request->total,
        ]);
        $notification= array(
            'message'       => 'Employee Salary Update successfully!',
            'alert-type'    => 'success'
        );
        return redirect('salary-process')->with($notification);
    }

    public function crearteSalary(Request $request)
    {
        Gate::authorize('app.mapping.index');
        $date = Carbon::now();
        $monthName = $request->month;
        $year = $request->year;
        // dd($monthName, $year);

        $check=SalaryProcess::where('month', $monthName)->where('year', $year)->get();

        $monthNumber = date_parse($request->month);
        $month = $monthNumber['month'];

        // dd($month);
        
        // $salary_month=$year.'-'.$monthName.'-'.'01';


        if(count($check) == 0) {
            
            // $emp = Employee::get();
            // foreach ($emp as $item){
            //     $story = SalaryStructureStory::where('employee_id',$item->id)->whereMonth()
            // }
            $employees = Employee::get();
            
            foreach ($employees as $item){

                $date = GradeWiseSalaryComponentHistory::where('grade_id',$item->grade)->whereMonth('date','<=',$month)->whereYear('date','>=',$year)->whereMonth('date','<=',$month)->whereYear('date','<=',$year)->orderBy('date', 'desc')->first();
                // dd($date->date);
                $gradeWises = GradeWiseSalaryComponentHistory::where('grade_id',$item->grade)->where('date',$date->date)->get();
                // dd($gradeWises);
                foreach($gradeWises as $salary){
                    SalaryProcess::create([
                        'employee_id' => $item->id,
                        'salary_component_id' => $salary->salary_component_id,
                        'amount' => $salary->value,
                        'month' =>$monthName,
                        'year' => $year,
                    ]);
                }
                $date = ExtraSalaryComponentHistory::where('employee_id',$item->id)->whereMonth('date','<=',$month)->whereYear('date','>=',$year)->whereMonth('date','<=',$month)->whereYear('date','<=',$year)->orderBy('date', 'desc')->first();
                // dd($date);
                $extra = ExtraSalaryComponentHistory::where('employee_id',$item->id)->where('date',$date)->get();

                foreach($extra as $salary){
                    SalaryProcess::create([
                        'employee_id' => $item->id,
                        'salary_component_id' => $salary->salary_component_id,
                        'amount' => $salary->value,
                        'month' =>$monthName,
                        'year' => $year,
                    ]);
                }
                
            }

            $notification= array(
                'message'       => 'Create successfully!',
                'alert-type'    => 'success'
            );
            
        }else{
            $notification= array(
                'message'       => 'This months salary sheet already created!',
                'alert-type'    => 'success'
            );
        };

        
        return redirect('salary-process')->with($notification);
        
    }

    public function confirm() {
        Gate::authorize('app.mapping.index');
        $date = Carbon::now();
        $monthName = $date->subMonth()->format('F');
        $year = $date->format('Y');

        $check=SalaryProcess::where('status', 1)->get();
        // dd($check);


        if(count($check) != 0)
        {
            $employees = SalaryProcess::where('status', 1)->get();

            foreach ($employees as $item){
                
                 SalaryProcess::find($item->id)->update([
                        'status' => 0,
                    ]);
                    $info =  SalaryProcess::where('id', $item->id)->first();
                    // dd($info);
                PaySalary::create([
                    'salary_process_id' => $item->id,
                    'employee_id' => $item->employee_id,
                    'month' =>$info->month,
                    'year' => $info->year,
                    'payable' => $item->total,
                    'paid' => 0,
                    'due' => $item->total
                ]);
            }

            $notification= array(
                'message'       => 'Salary Sheet Create successfully!',
                'alert-type'    => 'success'
            );
            
        }else{
            $notification= array(
                'message'       => 'There have nothing to confirm!',
                'alert-type'    => 'success'
            );
        };


        return redirect('pay-salary')->with($notification);
    }
}
