<?php

namespace App\Http\Controllers\backend;

use App\backend\LabourExpenseDetail;
use App\Http\Controllers\Controller;
use App\LabourExpense;
use App\Models\Payroll\Employee;
use App\Models\Payroll\Grade;
use App\Models\Payroll\GradeWiseSalaryComponent;
use App\Truck;
use Illuminate\Http\Request;

class LabourExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expanses = LabourExpense::orderBy('id', 'desc')->get();
        return view('backend.labour-expense.index', compact('expanses'));
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
        $request->validate(
            [
                'date'              =>  'required',
                'vehicle_id'        => 'required',
            ],
            [
                'date.required'         => 'Date is required',
                'vehicle_id.required'   => 'vehicle is required',
            ]
        );
        $multi_head=$request->inputs;
        $total_amount_withvat=0;
        $total_amount=0;
        $total_hours=0;
        $total_labour=0;
        foreach($multi_head as $each_head){
            $total_labour +=1;
            $total_hours +=$each_head['qty'];
            $total_amount_withvat= $total_amount_withvat + $each_head['amt'];
            $total_amount= $total_amount + $total_amount_withvat;
        }
       // return([$request,$total_amount,$total_amount_withvat, $total_vat]);
        // voucher scan upload
        if($request->hasFile('voucher_scan')){
            $voucher_scan= $request->file('voucher_scan');
            $name= $voucher_scan->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext= $voucher_scan->getClientOriginalExtension();
            $voucher_file_name= $name.time().'.'.$ext;
            $voucher_scan->storeAs( 'public/upload/labour-expanse', $voucher_file_name);
        }
        $old_date = explode('/', $request->date);
        $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));
        $truck = Truck::find($request->vehicle_id);
        $expense = new LabourExpense;
        $expense->truck_id = $request->vehicle_id;
        $expense->truck_number = $truck->vehicle_number;
        $expense->date = $new_date;
        $expense->total_hours = $total_hours;
        $expense->total_labour = $total_labour;
        $expense->total_amount = $total_amount_withvat;
        if($request->hasFile('voucher_scan')){
            $expense->file = $voucher_file_name;
        }
        $expense->save();
        $new_total_amount = 0;
        foreach($multi_head as $each_head){
            $expense_recode = new LabourExpenseDetail;
            $expense_recode->labour_expenses_id = $expense->id;
            $expense_recode->truck_id = $request->vehicle_id;
            $expense_recode->truck_number = $truck->vehicle_number;
            $expense_recode->labour_id = $each_head['job_group_id'];
            $expense_recode->hours = $each_head['qty'];
            $expense_recode->remark = $each_head['remark'];
            $expense_recode->date = $new_date;
            // labour cost per hour
            // $employee = Employee::find($each_head['job_group_id']);
            // $salry_components = GradeWiseSalaryComponent::where('grade_id',$employee->grade)->get();
            // $salry_amount = $salry_components->sum('value');
            // $daily = $salry_amount/30;
            // $hourly = number_format($daily/8,2);
            $hourly = $each_head['rate'];
            $expense_recode->rate = $hourly;
            $expense_recode->total_amount = number_format($hourly*$each_head['qty'],2);
            $expense_recode->save();
            $new_total_amount += number_format($hourly*$each_head['qty'],2);
        }
        $expense->total_amount = $new_total_amount;
        $expense->save();
        return back()->with('success','Expense Entry Successfull');
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
    public function labour_expense_add(Request $request){
        $employees = Employee::all();
        $vehicles = Truck::all();
        return view('backend.labour-expense.create', compact('employees', 'vehicles'));
    }
    public function labour_salary_per_hour(Request $request){
        $employee = Employee::find($request->id);
        $salry_components = GradeWiseSalaryComponent::where('grade_id',$employee->grade)->get();
        $salry_amount = $salry_components->sum('value');
        $daily = $salry_amount/30;
        $hourly = number_format($daily/8,2);
        return $hourly;
    }
    public function labour_expense_view_modal(Request $request){
        $expenses = LabourExpense::find($request->id);
        $expence_list = LabourExpenseDetail::where('labour_expenses_id', $expenses->id)->get();
        return view('backend.labour-expense.labour-expense-view', compact('expenses', 'expence_list'));
    }
}
