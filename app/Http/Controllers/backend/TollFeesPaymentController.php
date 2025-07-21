<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\TollFeeInvoiceItem;
use App\TollFees;
use App\TollFeesPayment;
use App\Truck;
use App\TollAmountRecord;
use Illuminate\Http\Request;

class TollFeesPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $toll_names = TollFees::all();
        $trucks = Truck::all();
        return view('backend.toll-fees.toll-fees-payment', compact('toll_names', 'trucks'));
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
        $request->validate([
            'toll_fees_id'=>'required',
            'date'=>'required',
            'amount'=>'required',
            'truck_id'=>'required',
        ]);
        $toll = TollFees::find($request->toll_fees_id);
        if($toll->amount<$request->amount){
            return back()->with('error', 'Payemnt amount grater then current amount');
        }
        $old_date = explode('/', $request->date);
        $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));
        
        $recharge = new TollFeesPayment;
        $recharge->toll_fees_id = $request->toll_fees_id;
        $recharge->date = $new_date;
        $recharge->description = $request->description;
        $recharge->trip_number = $request->trip_number;
        $recharge->rate = $request->rate;
        $recharge->amount = $request->amount;
        $recharge->truck_id = $request->truck_id;
        $save = $recharge->save();
        if($save){
            $toll->amount = $toll->amount-$request->amount;
            $toll->save();
        }
        return back()->with('success', 'Toll Fees Payment Complete');
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
    public function toll_fees_payment_view_modal(Request $request){
        $toll_name = TollFees::find($request->id);
        $toll_payemnt = TollAmountRecord::where('toll_id', $request->id)->where('is_invoice',1)->get();
        return view('backend.toll-fees.payement-view', compact('toll_name', 'toll_payemnt'));
    }
    public function toll_name_wise_report(Request $request){
        $toll_name = TollFees::all();
        $toll_list = TollFees::orderBy('id', 'asc');
        $toll_info = '';
        if($request->toll_id){
            $toll_list = $toll_list->where('id', $request->toll_id)->get();
            $toll_info = TollFees::find($request->toll_id)->first();
        }else{
            $toll_list = $toll_list->get();
        }
        return view('backend.report.toll-fee-name-report', compact('toll_name', 'toll_list', 'toll_info'));
    }
    public function vehicle_wise_toll_report(Request $request){
        $vehicles = Truck::all();
        $truck_list = Truck::orderBy('id', 'asc');
        $toll_info = '';
        if($request->truck_id){
            $truck_list = $truck_list->where('id', $request->truck_id)->get();
            $toll_info = Truck::find($request->truck_id)->first();
        }else{
            $truck_list = $truck_list->get();
        }
        return view('backend.report.vehicle-wise-toll-report', compact('vehicles', 'truck_list', 'toll_info'));
    }
    public function toll_fee_report(Request $request){
        $toll_name = TollFees::all();
        $date = '';
        $to = '';
        $from = '';
        $expenses = TollFeesPayment::orderBy('id', 'asc');
        if($request->date){
            $old_date = explode('/', $request->date);
            $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
            $new_date = date('Y-m-d', strtotime($new_data));

            $date = $new_date;
            $expenses = $expenses->where('date', $new_date);
        }if($request->from && $request->to){
            $old_date = explode('/', $request->from);
            $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
            $new_date = date('Y-m-d', strtotime($new_data));
            // $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);
            $old_date2 = explode('/', $request->to);
            $new_data2 = $old_date2[0].'-'.$old_date2[1].'-'.$old_date2[2];
            $new_date2 = date('Y-m-d', strtotime($new_data2));
            // $new_date2 = \DateTime::createFromFormat("Y-m-d", $new_date2);

            $from = $new_date;
            $to = $new_date2;
            $expenses = $expenses->whereBetween('date', [$new_date, $new_date2]);
        }
        if($request->date || ($request->from && $request->to)){
            $expenses = $expenses->get();
        }else{
            $expenses = $expenses->where('date', date('Y-m-d'))->get();
        }
        if($request->date==null && $request->from==null && $request->to==null){
            $date = date('Y-m-d');
        }
        return view('backend.report.toll-fee-report', compact('expenses', 'date', 'to', 'from', 'toll_name'));
    }
}
