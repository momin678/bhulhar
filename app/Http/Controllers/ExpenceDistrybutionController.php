<?php

namespace App\Http\Controllers;

use App\ExpenceDistrybution;
use App\ExpenseDistributionDetails;
use App\ExpenseDistrybution;
use App\ExpenseDistrybutionItem;
use App\PurchaseExpense;
use App\Truck;
use Illuminate\Http\Request;

class ExpenceDistrybutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     private function dateFormat($date)
    {
        $old_date = explode('/', $date);

        $new_data = $old_date[0] . '-' . $old_date[1] . '-' . $old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));
        $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);
        return $new_date->format('Y-m-d');
    }



    public function index()
    {
       $expenceDistrybutions = ExpenseDistrybution::orderBy('id','desc')->get();
       $vehicles = Truck::get();
       $total_amount = PurchaseExpense::where('is_distribute',0)->where('invoice_type','Garage')->sum('total_amount');
       return view('backend.expense-distribution.index',compact('expenceDistrybutions','total_amount','vehicles'));
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
        // return $request->all();

        $distribute=new ExpenseDistrybution();
        $distribute->note = $request->note;
        $distribute->date=$this->dateFormat($request->date);
        $distribute->total_amount=$request->total_expense;
        $distribute->expense_type=$request->expense_type;
        $distribute->expense_from=$this->dateFormat($request->expense_from);
        $distribute->expense_to=$this->dateFormat($request->expense_to);
        $distribute->save();
        $expenses =  PurchaseExpense::whereBetween('date',[ $this->dateFormat($request->expense_from), $this->dateFormat($request->expense_to)])->where('is_distribute',0)->where('invoice_type',$request->expense_type)->get();
        if($expenses){
            foreach($expenses as $expense){
                $expense->is_distribute = 1;
                $expense->save();
                $expenseDistrybutionDetails = new ExpenseDistributionDetails();
                $expenseDistrybutionDetails->expense_id =  $expense->id;
                $expenseDistrybutionDetails->expense_distrybution_id = $distribute->id;
                $expenseDistrybutionDetails->save();
            }

         }


        foreach($request->v_amount as $key=>$amount)
        {
            $item=new ExpenseDistrybutionItem();
            $item->expense_distrybution_id=$distribute->id;
            $item->vehicle_id=$key;
            $item->amount=$amount;
            $item->save();

        }

        return view('backend.expense-distribution.show',compact('distribute'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExpenceDistrybution  $expenceDistrybution
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $distribute=ExpenseDistrybution::find($id);
        return view('backend.expense-distribution.show',compact('distribute'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExpenceDistrybution  $expenceDistrybution
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $distribute=ExpenseDistrybution::find($id);
        return view('backend.expense-distribution.edit',compact('distribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExpenceDistrybution  $expenceDistrybution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $distribute= ExpenseDistrybution::find($id);
        $expenseDistrybutionDetails =  $distribute->ex_distrybution_details;
        if($expenseDistrybutionDetails){
            foreach($expenseDistrybutionDetails as $expenseDistrybutionDetail){
                $expenses = PurchaseExpense::find($expenseDistrybutionDetail->expense->id);
                $expenses->is_distribute = 0;
                $expenses->save();
                $expenseDistrybutionDetail->delete();
            }

         }

        $distribute->note = $request->note;
        $distribute->date=$this->dateFormat($request->date);
        $distribute->total_amount=$request->total_expense;
        $distribute->expense_type=$request->expense_type;
        $distribute->expense_from=$this->dateFormat($request->expense_from);
        $distribute->expense_to=$this->dateFormat($request->expense_to);
        $distribute->save();
        $expenses =  PurchaseExpense::whereBetween('date',[ $this->dateFormat($request->expense_from), $this->dateFormat($request->expense_to)])->where('is_distribute',0)->where('invoice_type',$request->expense_type)->get();
        if($expenses){
            foreach($expenses as $expense){
                $expense->is_distribute = 1;
                $expense->save();
                $expenseDistrybutionDetails = new ExpenseDistributionDetails();
                $expenseDistrybutionDetails->expense_id =  $expense->id;
                $expenseDistrybutionDetails->expense_distrybution_id = $distribute->id;
                $expenseDistrybutionDetails->save();
            }
         }
         $distribute->items->each->delete();

        foreach($request->v_amount as $key=>$amount)
        {
            $item=new ExpenseDistrybutionItem();
            $item->expense_distrybution_id=$distribute->id;
            $item->vehicle_id=$key;
            $item->amount=$amount;
            $item->save();
        }
        $distribute= ExpenseDistrybution::find($id);

        return view('backend.expense-distribution.show',compact('distribute'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExpenceDistrybution  $expenceDistrybution
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenceDistrybution $expenceDistrybution)
    {
        //
    }
}
