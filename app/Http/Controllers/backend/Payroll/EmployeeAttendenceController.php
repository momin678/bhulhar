<?php

namespace App\Http\Controllers\backend\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Payroll\Employee;
use App\Models\Payroll\EmployeeAttendence;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmployeeAttendenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request);
        // dd('kjhdfgj');
        $employees= Employee::get();
        $date = $request->date;
        if($request->has('date')){
            $attendances = EmployeeAttendence::where('date', $request->date)->get();
            // dd($attendances);
            return view('backend.payroll.attendence.index', compact('attendances', 'employees', 'date'));
        }
        return view('backend.payroll.attendence.index', compact('employees', 'date'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('app.attendance.index');
        $employees= Employee::all();
        return view('backend.attendance.employee.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // //Gate::authorize('app.mapping.index');
        $request->validate([
            'date'          => 'required|date',
            'status'        => 'required',
        ]);

        $isExist= EmployeeAttendence::where('date', $request->date)->get();
        if($isExist->count() > 0){
            $notification= array(
                'message'       => 'Already have these attandance!',
                'alert-type'    => 'warning'
            );
            return back()->with($notification);
        }

        foreach ($request->status as $key => $attendance) {
            EmployeeAttendence::create([
                'employee_id'        => $key,
                'status'            => $attendance,
                'date'              => $request->date
            ]);            
        }
        $notification= array(
            'message'       => 'Attandance Create Successfull!',
            'alert-type'    => 'success'
        );
        return back()->with($notification);
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
        //
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
    public function new_employee_attendance(Request $request){
        Gate::authorize('app.attendance.index');
        $employees= Employee::all();
        $date = $request->date;
        if($request->has('date')){
            $attendances = EmployeeAttendence::where('date', $request->date)->get();
            return view('backend.attendance.employee.new-index', compact('attendances', 'employees', 'date'));
        }
        return view('backend.attendance.employee.new-index', compact('employees', 'date'));
    }
    public function employee_attendance_print(Request $request){
        $employees= Employee::all();
        $date = $request->date;
        if($request->has('date')){
            $attendances = EmployeeAttendence::where('date', $request->date)->get();
            return view('backend.attendance.employee.attendance-print', compact('attendances', 'employees', 'date'));
        }
        return view('backend.attendance.employee.attendance-print', compact('employees', 'date'));
    }
}
