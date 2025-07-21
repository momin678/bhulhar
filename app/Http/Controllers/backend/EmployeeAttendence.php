<?php

namespace App\Http\Controllers\backend;

use App\Employee;
use App\EmployeeAttendance;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class EmployeeAttendence extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       //Gate::authorize('employee_attendance');
        $date=[];
        if($request->has('date')){
            $attendances = EmployeeAttendance::where('date', $request->date)->get();
            return view('backend.attendance.employee.new-index', compact('attendances'));
        }

        return view('backend.attendance.employee.new-index',compact(('')));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //Gate::authorize('employee_attendance');
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
       //Gate::authorize('employee_attendance');
        // return($request);
        $request->validate([
            // 'date'          => 'required|date',
            'status'        => 'required',
        ]);
        $old_date1 = explode('/', $request->date);

        $new_data1 = $old_date1[0].'-'.$old_date1[1].'-'.$old_date1[2];
        $new_date1 = date('Y-m-d', strtotime($new_data1));
        $date = \DateTime::createFromFormat("Y-m-d", $new_date1);



        foreach ($request->status as $key => $attendance) {
            $attendances= EmployeeAttendance::whereDate('date', $date)->where('employee_id', $key)->first();
           // return($attendance);
            if($attendances){
                $attendances->employee_id        = $key;
                $attendances->status            = $attendance;
                $attendances->date             = $date;
                $attendances->save();

            }
            else{
                EmployeeAttendance::create([
                    'employee_id'        => $key,
                    'status'            => $attendance,
                    'date'              => $date
                ]);
            }


        }
        $notification= array(
            'message'       => 'Attendance Created Successfully!',
            'alert-type'    => 'success'
        );
        return back()->with($notification);
    }
    public function new_teacher_store(Request $request)
    {
        //Gate::authorize('attendance');
        $request->validate([
            // 'date'          => 'required|date',
            'status'        => 'required',
        ]);
        $old_date1 = explode('/', $request->date);

        $new_data1 = $old_date1[0].'-'.$old_date1[1].'-'.$old_date1[2];
        $new_date1 = date('Y-m-d', strtotime($new_data1));
        $date = \DateTime::createFromFormat("Y-m-d", $new_date1);

        $isExist= EmployeeAttendance::where('date', $request->date)->get();
        if($isExist->count() > 0){
            $notification= array(
                'message'       => 'Already have these attendance!',
                'alert-type'    => 'warning'
            );
            return back()->with($notification);
        }

        foreach ($request->status as $key => $attendance) {
            EmployeeAttendance::create([
                'employee_id'        => $key,
                'status'            => $attendance,
                'date'              => $date
            ]);
        }
        $notification= array(
            'message'       => 'Attendance Created Successfully!',
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
       //Gate::authorize('employee_attendance');
        $employees= Employee::where('division','!=',6)->get();
        $date = $request->date;
        if($request->new_date){
            $old_date1 = explode('/', $request->new_date);

            $new_data1 = $old_date1[0].'-'.$old_date1[1].'-'.$old_date1[2];
            $new_date1 = date('Y-m-d', strtotime($new_data1));
            $new_date = \DateTime::createFromFormat("Y-m-d", $new_date1);

           // Convert the provided date string to a Carbon instance
            $date1 = Carbon::parse($new_date)->format('Y-m-d');
            // dd($date1);
             if($new_date){
            // $new_date = $request->new_date;
            $attendances = EmployeeAttendance::whereDate('date', '=', $date1)->whereIn('employee_id', function ($query) {
                $query->select('id')
                    ->from('employees')
                    ->where('division','!=', 6);})->get();


            // return($attendances);
            // dd($attendances);
            return view('backend.attendance.employee.new-index', compact('attendances', 'employees', 'date', 'date1','new_date'));
           }
        }
        // dd($employees);

        return view('backend.attendance.employee.new-index', compact('employees', 'date'));
    }
    public function new_teacher_attendance(Request $request){
        //Gate::authorize('attendance');

        $employees = Employee::where('division',6)->get();
        $date = $request->date;
        if($request->new_date){
            $old_date1 = explode('/', $request->new_date);

            $new_data1 = $old_date1[2].'-'.$old_date1[1].'-'.$old_date1[0];
            $new_date1 = date('Y-m-d', strtotime($new_data1));
            $new_date = \DateTime::createFromFormat("Y-m-d", $new_date1);

           // Convert the provided date string to a Carbon instance
            $date1 = Carbon::parse($new_date)->format('Y-m-d');
            //return($date1);

             if($new_date){
            // $new_date = $request->new_date;
            $attendances = EmployeeAttendance::whereDate('date', '=', $date1)->whereIn('employee_id', function ($query) {
                $query->select('id')
                    ->from('employees')
                    ->where('division',6);})->get();
            // return($attendances);
            return view('backend.attendance.teacher.new-index', compact('attendances', 'employees', 'date','date1', 'new_date'));
           }
        }
        return view('backend.attendance.teacher.new-index', compact('employees', 'date'));
    }
    public function employee_attendance_print(Request $request){
        // dd(1);
        $employees= Employee::where('division','!=', 6)->get();
        $date = $request->date;
        if($request->has('date')){
            $attendances = EmployeeAttendance::where('date', $request->date)->get();
            return view('backend.attendance.employee.attendance-print', compact('attendances', 'employees', 'date'));
        }
        return view('backend.attendance.employee.attendance-print', compact('employees', 'date'));
    }
    public function teacher_attendance_print(Request $request){
        $employees = Employee::where('division', 6)->get();
        // dd(1);
        $date = $request->date;
        if($request->has('date')){
            $attendances = EmployeeAttendance::where('date', $request->date)->get();
            return view('backend.attendance.teacher.attendance-print', compact('attendances', 'employees', 'date'));
        }
        return view('backend.attendance.teacher.attendance-print', compact('employees', 'date'));
    }
    public function new_employee_attendance_edit(Request $request){
       //Gate::authorize('employee_attendance');
        $employees= Employee::where('role', '!=', 5)->get();
        $date = $request->date;
        if($request->new_date){
            $old_date1 = explode('/', $request->new_date);

            $new_data1 = $old_date1[0].'-'.$old_date1[1].'-'.$old_date1[2];
            $new_date1 = date('Y-m-d', strtotime($new_data1));
            $new_date = \DateTime::createFromFormat("Y-m-d", $new_date1);

           // Convert the provided date string to a Carbon instance
            $date1 = Carbon::parse($new_date)->format('Y-m-d');
             if($new_date){
            // $new_date = $request->new_date;
            $attendances = EmployeeAttendance::whereDate('date', '=', $date1)->whereIn('employee_id', function ($query) {
                $query->select('id')
                    ->from('employees')
                    ->where('division','!=', 6);})->get();
            // return($attendances);
            return view('backend.attendance.employee.new-edit', compact('attendances', 'employees', 'date','date1', 'new_date'));
           }

        }
        return view('backend.attendance.employee.new-index', compact('employees', 'date'));
    }


    public function new_teacher_attendance_edit(Request $request){
        //Gate::authorize('attendance');
        $employees = Employee::where('division', 6)->get();
        $date = $request->date;
        if($request->new_date){
            $old_date1 = explode('/', $request->new_date);

            $new_data1 = $old_date1[0].'-'.$old_date1[1].'-'.$old_date1[2];
            $new_date1 = date('Y-m-d', strtotime($new_data1));
            $new_date = \DateTime::createFromFormat("Y-m-d", $new_date1);

           // Convert the provided date string to a Carbon instance
           $date1 = Carbon::parse($new_date)->format('Y-m-d');
          // return($date1);
           if($new_date){
            // $new_date = $request->new_date;
            $attendances = EmployeeAttendance::whereDate('date', '=', $date1)->whereIn('employee_id', function ($query) {
                $query->select('id')
                    ->from('employees')
                    ->where('division',6);})->get();
            // return($attendances);
            return view('backend.attendance.teacher.new-edit', compact('attendances', 'employees', 'date', 'date1'));
           }

        }
        return view('backend.attendance.teacher.new-index', compact('employees', 'date'));
    }

    public function new_employee_attendance_update(Request $request){
       //Gate::authorize('employee_attendance');
        //   dd( $request->all());
        foreach ($request->status as $key => $attendance) {
            // dd($attendance);
           $update_attendence = EmployeeAttendance::where('date', $request->new_date)->where('employee_id', $key)->first();
        //    dd($update_attendence);
           $update_attendence->status =  $attendance;
           $update_attendence->save();
        }
        $notification= array(
            'message'       => 'Update Successfull!',
            'alert-type'    => 'success'
        );
        return redirect()->back()->with($notification);
    }
    public function new_teacher_attendance_update(Request $request){
        //Gate::authorize('attendance');
          //dd( $request->all());
        foreach ($request->status as $key => $attendance) {
            // dd($attendance);
           $update_attendence = EmployeeAttendance::where('date', $request->new_date)->where('employee_id', $key)->first();
        //    dd($update_attendence);
           $update_attendence->status =  $attendance;
           $update_attendence->save();
        }
        $notification= array(
            'message'       => 'Teacher Attendance Updated Successfully!',
            'alert-type'    => 'success'
        );
        return redirect()->back()->with($notification);
    }
    public function search_holiday_recode(Request $request)
    {

        $old_date1 = explode('/', $request->date);
        $new_data1 = $old_date1[0] . '-' . $old_date1[1] . '-' . $old_date1[2];
        $new_date1 = date('Y-m-d', strtotime($new_data1));
        $date = \DateTime::createFromFormat("Y-m-d", $new_date1);
        $date = $date->format('Y-m-d');

        $check_recode = HolidayRecode::where('date', $date)->first();
        if($check_recode)
        {
            return $check_recode;
        }
        elseif(Carbon::createFromDate($date)->isSaturday() || Carbon::createFromDate($date)->isSunday())
        {

            return 'Weekend';
        }
        else
        {
            return $check_recode;

        }
    }
}
