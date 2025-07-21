<?php

namespace App\Http\Controllers\backend;

use App\Cursher;
use App\Destination;
use App\Http\Controllers\Controller;
use App\Rate;
use App\TollFees;
use App\TollRate;
use App\TruckRecords;
use Illuminate\Http\Request;

class RateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rates = Rate::orderBy('id', 'desc')->get();
        $cursers = Cursher::all();
        $destination = Destination::all();
        // dd($destination);
        $tolls = TollFees::all();
        return view('backend.rate.index', compact('rates', 'cursers', 'destination', 'tolls'));
    }
    public function toll_store(Request $request)
    {

        $rate = new TollFees;
        $rate->name = $request->toll_name;
        $rate->amount = $request->toll_amount;

        $rate->save();

        $notification= array(
            'message'       => 'Toll added successfully!',
            'alert-type'    => 'success'
        );

        return back()->with($notification);
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
                'cursher_id'=> 'required',
                'destination_id'=> 'required',
            ],
            [
                'cursher_id.required'   => 'Source is required',
                'destination_id.required'   => 'Destination is required',
            ]
        );
        $check = Rate::where('cursher_id', $request->cursher_id)->where('destination_id', $request->destination_id)->first();
        if($check){
            $notification= array(
                'message'       => 'This Source to Destination already exit!',
                'alert-type'    => 'error'
            );
            return back()->with($notification);
        }
        // dd(count($request->inputs));
        $rate = new Rate;
        $rate->cursher_id = $request->cursher_id;
        $rate->destination_id = $request->destination_id;
        $rate->customer_rate = $request->customer_rate;
        $rate->supplier_rate = $request->supplier_rate;
        $rate->commission_rate = $request->commission_rate;
        $rate->save();
        if(count($request->inputs)>0){
            $multi_head=$request->inputs;
            foreach($multi_head as $each_head){
                if($each_head['rate']>0){
                    $toll_name = TollFees::find($each_head['toll_id']);
                    $toll_rate = new TollRate;
                    $toll_rate->cursher_id = $request->cursher_id;
                    $toll_rate->destination_id = $request->destination_id;
                    $toll_rate->toll_id = $each_head['toll_id'];
                    $toll_rate->type = $toll_name->type;
                    $toll_rate->amount = $each_head['rate'];
                    $toll_rate->save();
                }
            }
        }
        $notification= array(
            'message'       => 'Rate added successfully!',
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
        $request->validate(
            [
                'cursher_id'=> 'required',
                'destination_id'=> 'required',
            ],
            [
                'cursher_id.required'   => 'Source is required',
                'destination_id.required'   => 'Destination is required',
            ]
        );
        $rate = Rate::find($id);
        $rate->cursher_id = $request->cursher_id;
        $rate->destination_id = $request->destination_id;
        $rate->customer_rate = $request->customer_rate;
        $rate->supplier_rate = $request->supplier_rate;
        $rate->commission_rate = $request->commission_rate;
        $rate->save();
        // dd($request->inputs);
        if(count($request->inputs)>0){
            TollRate::where('cursher_id', $rate->cursher_id)->where('destination_id', $rate->destination_id)->delete();
            $multi_head=$request->inputs;
            foreach($multi_head as $each_head){
                if($each_head['rate']>0){
                    $toll_name = TollFees::find($each_head['toll_id']);
                    $toll_rate = new TollRate;
                    $toll_rate->cursher_id = $request->cursher_id;
                    $toll_rate->destination_id = $request->destination_id;
                    $toll_rate->toll_id = $each_head['toll_id'];
                    $toll_rate->type = $toll_name->type;
                    $toll_rate->amount = $each_head['rate'];
                    $toll_rate->save();
                }
            }
        }
        $rate->save();
        $notification= array(
            'message'       => 'Rate update successfully!',
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
    public function rate_edit_model(Request $request){
        $rate = Rate::find($request->rate_id);
        $cursers = Cursher::all();
        $destination = Destination::all();
        $tolls = TollFees::all();
        $toll_rates = TollRate::where('cursher_id', $rate->cursher_id)->where('destination_id', $rate->destination_id)->get();
        return view('backend.rate.edit', compact('rate', 'cursers', 'destination', 'tolls', 'toll_rates'));
    }
    public function check_exit_rate(Request $request){
        $cruser_id = Cursher::where('name', $request->cursher_id)->first();
        $destination_id = Destination::where('name', $request->destination_id)->first();
        $check = Rate::where('cursher_id', $cruser_id->id)->where('destination_id', $destination_id->id)->first();
        $trip_count = TruckRecords::where('driver_name', $request->driver_id)->get();
        return [$check, count($trip_count)];
    }
    public function check_exit_tkt_number(Request $request){
        $check = TruckRecords::where('tkt_number', $request->tkt_number)->first();
        return $check;
    }
    public function check_exit_toll_fee(Request $request){
       // return $request;
        $cruser_id = Cursher::find($request->cursher_id);
        $destination_id = Destination::find($request->destination_id);
        $weight = $request->wight;
        $total_amount = 0;
        $rate = 0;
        // dd($destination_id);
        if($cruser_id && $destination_id){
            $amount = TollRate::where('cursher_id', $cruser_id->id)->where('destination_id', $destination_id->id)->sum('amount');
            $rate = TollRate::where('cursher_id', $cruser_id->id)->where('destination_id', $destination_id->id)->where('type', 'Changeable')->get();
            $fnrc_toll = 0;
            // foreach($rate as $r){
            //     $add_amount = 0;
            //     $get_amount = ($r->amount*$weight)/10;
            //     $integer = floor($get_amount);
            //     $fraction = number_format($get_amount - $integer,2);
            //     if($fraction> .5){
            //         $add_amount = 10;
            //     }
            //     $fnrc_toll += $integer*10 + $add_amount;
            // }
            $total_amount = $amount+$fnrc_toll;
        }
        return $total_amount;
    }
}
