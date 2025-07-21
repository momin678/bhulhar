<?php

namespace App\Http\Controllers\backend\Payroll;

use App\Http\Controllers\Controller;
use App\Mapping;
use App\Models\Payroll\PaySalary;
use App\Models\Payroll\PaymentInformation;
use App\Models\Payroll\Employee;
use App\Models\AccountHead;
use App\Models\Payroll\SalaryProcess;
use App\Models\Payroll\TimeList;
use App\Models\Payroll\TimeTrack;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use Carbon\Carbon;

class TimeTrackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //Gate::authorize('app.mapping.index');
        $paySalarys = Employee::orderBy('id', 'desc')->get();
        // $employees = Employee::all();
        // dd($facitities);
        return view('backend.payroll.time_track.index', compact('paySalarys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //Gate::authorize('app.mapping.index');
        $employees = Employee::orderBy('id', 'asc')->get();
        
        // $emp_salary_structure = PaySalary::where('due','!=',0)->get();
        return view('backend.payroll.time_track.time_entry', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $date = $request->date;
        if (!$request->date) {

            $date = Carbon::now()->format('Y-m-d');
        }
        
        // dd($request->employee_id);
        // $date = $request->date;
        // $year = $request->year;

        // $request->validate([
        //     'id' => 'required',
        // ]);
        foreach ($request->employee_id['id'] as $key => $value) {
            $id = $request->employee_id['id'][$key];
            $timeDifference = Carbon::parse($request->employee_id['out'][$key])->diffInMinutes(Carbon::parse($request->employee_id['entry'][$key]));
            $work_hours = intdiv($timeDifference, 60).':'. ($timeDifference % 60);
            TimeTrack::create([
                'employee_id' => $id,
                'date' => $date,
                'entry' => $request->employee_id['entry'][$key],
                'out' => $request->employee_id['out'][$key],
                'working_hours' => $work_hours,
            ]);
        }

        foreach ($request->employee_id['id'] as $key => $value) {
            $id = $request->employee_id['id'][$key];
            $month = $request->employee_id['month'][$key];
            $year = $request->employee_id['year'][$key];
            $salary_info = PaySalary::where('employee_id', $id)->where('month', $month)->where('year', $year)->first();
            TimeTrack::find($salary_info->id)->update([
                'paid' => $salary_info->paid + $request->employee_id['pay_salary'][$key],
                'due' => $salary_info->due - $request->employee_id['pay_salary'][$key],
            ]);
        }

        $notification= array(
            'message'       => 'Employee Salary Added successfully!',
            'alert-type'    => 'success'
        );
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
        //printDocument
    }

    public function printDocument()
    {
        
        //Gate::authorize('app.mapping.index');
        // $paySalarys = PaySalary::orderBy('id', 'desc')->get();
        // $employees = Employee::all();
        // dd($facitities);
        return view('backend.payroll.pay_salary.print');
    }

    public function employeeInfo(Request $request)
    {
        $emp_name=Employee::where('employee_wage_type', 1)->where('id',$request->emp)->orWhere('name', $request->emp)->get();
        // $check=EmployeeSalary::where('employee_id',$request->emp)->get();

        return Response()->json([
            'page' => view('backend.payroll.time_track.ajaxList', ['others' => $emp_name, 'index' => 0])->render(),

        ]);
    }
    
    public function timeEntry($id, $status)
    {
        $time = Carbon::now();
        if($status == 'in') {

            TimeTrack::create([
                'employee_id' => $id,
                'entry' => $time,
            ]);

            $notification= array(
                'message'       => 'Entry successfully!',
                'alert-type'    => 'success'
            );

        } elseif ($status == 'out') {
            $in = TimeTrack::where('employee_id', $id)->latest()->first();
            // dd($in->entry);
            $timeDifference = Carbon::parse($in->entry)->diffInMinutes(Carbon::parse($time));
            $work_hours = intdiv($timeDifference, 60).':'. ($timeDifference % 60);
            TimeTrack::find($in->id)->update([
                'out' => $time,
                'working_hours' => $work_hours,
            ]);

            $notification= array(
                'message'       => 'Out successfully!',
                'alert-type'    => 'success'
            );

        }

        
        return redirect('time-tracking/create')->with($notification);
            
    }


}
