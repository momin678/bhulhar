<?php

namespace App\Http\Controllers\backend;

use App\Driver;
use App\Models\Payroll\Grade;
use App\TruckRecords;
use App\Http\Controllers\Controller;
use App\Models\Payroll\Employee;
use App\Models\Payroll\EmployeeTemp;
use Carbon\Carbon;
use App\PartyInfo;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drivers = Employee::where('division',3)->orderBy('id','desc')->get();
        $grads = Grade::all();
        return view('backend.driver.index', compact('drivers', 'grads'));
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
        $eid_latest = EmployeeTemp::whereYear('created_at', date('Y'))->orderBy('id', 'desc')->first();
        if ($eid_latest) {
            $eid = $eid_latest->emp_id + 1;
        } else {

            $eid_latest = EmployeeTemp::orderBy('id', 'desc')->first();
            if ($eid_latest) {
                $eid = $eid_latest->emp_id + 1;
                $eid = substr($eid, 2, -4);
                $numb = $eid > 99 ? $eid : ($eid > 9 ? '0' . $eid : '00' . $eid);
                $eid = date('Y') . $numb;

                // dd($eid);
            } else {

                $eid = Carbon::now()->format('Y') . '001';
            }
        }

        $driver = new EmployeeTemp;
        $driver->full_name = $request->name;
        $driver->emp_id = $eid;
        $driver->grade = $request->grade;
        $driver->division = 3;
        $driver->status = 1;
        $driver->save();

        $driver_e = new Employee;
        $driver_e->emp_id = $eid;
        $driver_e->full_name = $request->name;
        $driver_e->grade = $request->grade;
        $driver_e->division = 3;
        $driver_e->save();

        $latest = PartyInfo::withTrashed()->orderBy('id','DESC')->first();
        if ($latest) {
            $pi_code=preg_replace('/^PI-/', '', $latest->pi_code );
            ++$pi_code;
        } else {
            $pi_code = 1;
        }
        if($pi_code<10)
        {
            $c_code="PI-000".$pi_code;
        }
        elseif($pi_code<100)
        {
            $c_code="PI-00".$pi_code;
        }
        elseif($pi_code<1000)
        {
            $c_code="PI-0".$pi_code;
        }
        else
        {
            $c_code="PI-".$pi_code;
        }

        $draftCost = new PartyInfo();
        $draftCost->pi_code = $c_code;
        $draftCost->pi_name = $request->name;
        $draftCost->pi_type = 'Employee';
        $draftCost->emp_id = $driver_e->id;
        $draftCost->save();
        $notification= array(
            'message'       => 'Driver name add successfully!',
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
        // dd($request->all());
        $driver = Employee::find($id);
        $driver->full_name = $request->name;
        $driver->division = 3;
        $driver->grade = $request->grade;
        $driver->save();
        $temp = EmployeeTemp::where('emp_id', $driver->emp_id)->first();
        $temp->grade = $request->grade;
        $temp->full_name = $request->name;
        $temp->save();
        
        $draftCost = PartyInfo::where('emp_id', $driver->id)->first();
        if($draftCost){
            $draftCost->pi_name = $request->name;
            $draftCost->save();
        }

        $notification= array(
            'message'       => 'Driver name Update successfully!',
            'alert-type'    => 'success'
        );

        return back()->with($notification);
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
    public function driver_edit_model(Request $request){
        $driver = Employee::find($request->driver_id);
        $grads = Grade::all();
        return view('backend.driver.edit', compact('driver', 'grads'));
    }
    public function driver_report(Request $request){
    // return $request;
        $drivers = Employee::all();
        $services = [];
        $from = $request->from ? $request->from : date('d/m/Y');
        $to = $request->to ? $request->to : date('d/m/Y');
        $id = $request->driver_id ? $request->driver_id : 0;



        $driver_info = $drivers->where('id', $request->driver_id)->first();
        if ($request->driver_id) {
            $query = TruckRecords::where('driver_name', $request->driver_id);

            if ($request->from && $request->to) {
                $fromDate = Carbon::createFromFormat('d/m/Y', $request->from)->startOfDay();
                $toDate = Carbon::createFromFormat('d/m/Y', $request->to)->endOfDay();
                $query->whereBetween('date', [$fromDate, $toDate]);
            }

            $services = $query->orderBy('date', 'desc')->get();
        }
        // dd($services);
        $form = $request->from ? $request->from : date('m/d/Y');
        return view('backend.driver.driver-report', compact('drivers', 'services', 'driver_info','from','to','id'));
    }
}
