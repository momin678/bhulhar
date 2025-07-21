<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\PayMode;
use App\TollFeeInvoice;
use App\TollFeeInvoiceItemTemp;
use App\TollFeeInvoiceTemp;
use App\Setup;
use Illuminate\Http\Request;

class TollFeeInvoiceTempController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $toll_setup = Setup::where('name', 'Toll Setup')->first();
        $toll_invoice = TollFeeInvoiceTemp::find($id);
        $pay_modes = PayMode::all();
        $toll_items = TollFeeInvoiceItemTemp::where('invoice_id', $toll_invoice->id)->get();
        // dd($toll_items);
        return view('backend.toll-fee-invoice.invoice-view', compact('toll_invoice', 'toll_items', 'pay_modes', 'toll_setup'));
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
