<?php

namespace App\Http\Controllers\backend;

use App\Driver;
use App\Http\Controllers\Controller;
use App\Models\Payroll\Employee;
use App\PartyInfo;
use App\TokenGeneration;
use App\Truck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TokenGenerationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $max_token = TokenGeneration::max('token_no');
        if($max_token){
            $max_token = $max_token+1;
        }else{
            $max_token = 10001;
        }
        $countries= DB::table('countries')->get();
        $parties= PartyInfo::where('pi_type','Supplier')->orWhere('pi_type','Third Party')->get();
        $tokens = TokenGeneration::all();
        $trucks = Truck::all();
        $drivers = Employee::where('division', 3)->get();
        return view('backend.token-gen.index', compact('tokens', 'trucks', 'drivers', 'max_token', 'countries', 'parties'));
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
        // $request->validate(
        //     [
        //         'token_no'=> 'required',
        //         'truck_id'=> 'required',
        //         'driver_id'=> 'required',
        //     ]
        // );
        $token = new TokenGeneration;
        $token->token_no = $request->token_no;
        $token->truck_id = $request->truck_id;
        $token->driver_id = $request->driver_id;
        $token->save();
        $notification= array(
            'message'       => 'Token Create successfully!',
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
}
