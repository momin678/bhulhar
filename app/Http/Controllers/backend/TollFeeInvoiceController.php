<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Journal;
use App\JournalRecord;
use App\Models\AccountHead;
use App\PayMode;
use App\TollFeeInvoice;
use App\TollFeeInvoiceItem;
use App\TollFeeInvoiceItemTemp;
use App\TollFeeInvoiceTemp;
use App\TollFees;
use App\TollFeesPayment;
use App\TollFeesRecharge;
use App\Setup;
use App\TollAmountRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TollFeeInvoiceController extends Controller
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
        $toll_invoice = TollFeeInvoice::find($id);
        $pay_modes  = PayMode::get();
        $toll_items = TollFeeInvoiceItem::where('invoice_id', $toll_invoice->id)->get();
        $toll_setup = Setup::where('name', 'Toll Setup')->first();
        return view('backend.toll-fee-invoice.invoice-view', compact('toll_invoice','pay_modes', 'toll_items', 'toll_setup'));
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
    public function toll_fee_invoice_confirm(Request $request){
        $temp_invoice = TollFeeInvoiceTemp::find($request->temp_invoice_id);
        $toll_items = TollFeeInvoiceItemTemp::where('invoice_id', $temp_invoice->id)->get();
        // dd($toll_items);
        $toll_setup = Setup::where('name', 'Toll Setup')->first();
        if($toll_setup->value == 'Automatic'){
            $toll_names = TollFees::all();
            foreach($toll_names as $item){
                // $toll_balance = TollFeesRecharge::where('toll_fees_id', $item->id)->where('remaining', '>', 0)->whereMonth('date','<=', date('m', strtotime($temp_invoice->date)))->get();
                $toll_balance = TollFeesRecharge::where('toll_fees_id', $item->id)->where('remaining', '>', 0)->get();
                foreach($toll_items as $toll_ite){
                    $toll_amount = TollAmountRecord::where('truck_record_id', $toll_ite->item_id)->where('toll_id', $item->id)->get();
                    if($toll_amount->sum('amount') > $toll_balance->sum('remaining')){
                        $notification= array(
                            'message'       => $item->name.' balance not enough!',
                            'alert-type'    => 'error'
                        );
                        return back()->with($notification);
                    }
                }
            }
        }
        $toll_fee_invoice                = new TollFeeInvoice();
        $toll_fee_invoice->tax_invoice_id= $temp_invoice->tax_invoice_id;
        $toll_fee_invoice->invoice_no    = $temp_invoice->invoice_no;
        $toll_fee_invoice->new_invoice_no= $temp_invoice->new_invoice_no;
        $toll_fee_invoice->customer_id   = $temp_invoice->customer_id;
        $toll_fee_invoice->project_id    = $temp_invoice->project_id;
        $toll_fee_invoice->date          = $temp_invoice->date;
        $toll_fee_invoice->cost_center_id= $temp_invoice->cost_center_id;
        $toll_fee_invoice->pay_mode      = $request->pay_mode;
        $toll_fee_invoice->amount        = $temp_invoice->amount;
        $toll_fee_invoice->created_by    = Auth::id();
        $toll_fee_invoice->status        = 'Approved';
        $toll_fee_invoice->save();

        // dd($toll_items);
        foreach($toll_items as $item){
            $inv_item                   = new TollFeeInvoiceItem;
            $inv_item->invoice_id       = $toll_fee_invoice->id;
            $inv_item->invoice_no       = $toll_fee_invoice->invoice_no;
            $inv_item->item_id          = $item->item_id;
            $inv_item->truck_id         = $item->truck_id;
            $inv_item->customer_id      = $item->customer_id;
            $inv_item->date             = $item->date;
            $inv_item->qty              = 1;
            $inv_item->destination      = $item->destination;
            $inv_item->source           = $item->source;
            $inv_item->rate             = $item->rate;
            $inv_item->amount           = $item->amount;
            $inv_item->save();
            if($item->amount>0 && $toll_setup->value == 'Automatic'){
                $toll_amount_records = TollAmountRecord::where('truck_record_id', $item->item_id)->get();
                foreach($toll_amount_records as $amount_record){
                    $payment = new TollFeesPayment;
                    $payment->item_id = $item->item_id;
                    $payment->truck_id = $item->truck_id;
                    $payment->toll_fees_id = $amount_record->toll_id;
                    $payment->date = $item->date;
                    $payment->description = $item->truck_record->crusher.' '.$item->truck_record->destination. " Toll Payment";
                    $payment->trip_number = 1;
                    $payment->rate = $item->rate;
                    $payment->amount = $amount_record->amount;
                    $payment->save();
                    
                    $toll_balance = TollFees::find($amount_record->toll_id);
                    $toll_balance->amount = $toll_balance->amount - $payment->amount;
                    $toll_balance->save();
                    
                    $toll_balance = TollFeesRecharge::orderBy('id', 'asc')->where('toll_fees_id',$amount_record->toll_id)->where('remaining', '>', 0)->get();
                    // $toll_balance = TollFeesRecharge::orderBy('id', 'asc')->where('toll_fees_id', $item->toll_fee_id)->where('remaining', '>', 0)->whereMonth('date','<=', date('m', strtotime($temp_invoice->date)))->get();
                    $current_toll_amount = $item->amount;
                    foreach($toll_balance as $balance){
                        if($current_toll_amount>0 && $balance->remaining>0){
                            if($current_toll_amount > $balance->remaining){
                                $balance->expense += $balance->remaining;
                                $current_toll_amount = $current_toll_amount - $balance->remaining;
                                $balance->remaining = 0;
                                $balance->save();
                            }else{
                                $balance->expense += $current_toll_amount;
                                $balance->remaining = $balance->remaining - $current_toll_amount;
                                $balance->save();
                                $current_toll_amount = 0;
                            }
                        }
                    }
                }

            }
            $item->delete();
        }
        
        $temp_invoice->delete();

        // Journal Entry
        // $sub_invoice = Carbon::now()->format('Ymd');
        // $latest_journal_no = Journal::withTrashed()->whereDate('created_at', Carbon::today())->where('journal_no', 'LIKE', "%{$sub_invoice}%")->latest()->first();

        // if ($latest_journal_no) {
        //     $journal_no = substr($latest_journal_no->journal_no,0,-1);
        //     $journal_code = $journal_no + 1;
        //     $journal_no = $journal_code . "J";
        // } else {
        //     $journal_no = Carbon::now()->format('Ymd') . '001' . "J";
        // }
        // $journal= new Journal();
        // $journal->transection_type  = "Toll Fee Invoice";
        // $journal->transaction_type  = "Toll Fee Invoice";
        // $journal->without_gst       = 0;
        // $journal->gst_subtotal      = 0;
        // $journal->project_id        = $toll_fee_invoice->project_id;
        // $journal->journal_no        = $journal_no;
        // $journal->date              = $toll_fee_invoice->date;
        // $journal->pay_mode          = $toll_fee_invoice->pay_mode;
        // $journal->invoice_no        = $toll_fee_invoice->invoice_no;
        // $journal->cost_center_id    = 1;
        // $journal->party_info_id     = $toll_fee_invoice->customer_id;
        // $journal->account_head_id   = 123;
        // $journal->amount            = $toll_fee_invoice->amount;
        // $journal->tax_rate          = 0;
        // $journal->vat_amount        = 0;
        // $journal->total_amount      = 0;
        // $journal->narration         = 'Toll Fee invoice by '. $toll_fee_invoice->pay_mode ;
        // $journal->created_by        = Auth::id();
        // $journal->voucher_type      = 'default';
        // $journal->authorized        = 1;
        // $journal->approved          = 1;
        // $journal->authorized_by     = Auth::id();
        // $journal->approved_by       = Auth::id();
        // $journal->save();

        // // Main Entry
        // $acc_head= AccountHead::find(30); // Toll fee account
        // $jl_record= new JournalRecord();
        // $jl_record->journal_id          = $journal->id;
        // $jl_record->project_details_id  = $journal->project_id ;
        // $jl_record->cost_center_id      = $journal->cost_center_id;
        // $jl_record->party_info_id       = $journal->party_info_id;
        // $jl_record->journal_no          = $journal->journal_no;
        // $jl_record->account_head_id     = $acc_head->id;
        // $jl_record->master_account_id   = $acc_head->master_account_id;
        // $jl_record->account_head        = $acc_head->fld_ac_head;
        // $jl_record->amount              = $journal->amount;
        // $jl_record->total_amount        = $journal->total_amount;
        // $jl_record->is_main_head        = 1;
        // $jl_record->transaction_type    = 'CR';
        // $jl_record->journal_date        = $journal->date;
        // $jl_record->account_type_id     = $acc_head->account_type_id;
        // $jl_record->gst_amount          = 0;
        // $jl_record->gst_subtotal        = 0;
        // $jl_record->vat_rate_id         = 0;
        // $jl_record->invoice_no          = 'n/a';
        // $jl_record->save();

        // if($request->pay_mode=='Cash'){
        //     $ac_head_cr= AccountHead::find(1); // Cash Operating Account
        // }elseif($request->pay_mode=='Card'){
        //     $ac_head_cr= AccountHead::find(2); // Bank Account
        // }
        // $jl_record= new JournalRecord();
        // $jl_record->journal_id          = $journal->id;
        // $jl_record->project_details_id  = $journal->project_id;
        // $jl_record->cost_center_id      = $journal->cost_center_id;
        // $jl_record->party_info_id       = $journal->party_info_id;
        // $jl_record->journal_no          = $journal_no;
        // $jl_record->account_head_id     = $ac_head_cr->id;
        // $jl_record->master_account_id   = $ac_head_cr->master_account_id;
        // $jl_record->account_head        = $ac_head_cr->fld_ac_head;
        // $jl_record->amount              = $journal->amount;
        // $jl_record->total_amount        = $journal->amount;
        // $jl_record->transaction_type    = 'DR';
        // $jl_record->journal_date        = $journal->date;
        // $jl_record->account_type_id     = $ac_head_cr->account_type_id;
        // $jl_record->gst_amount          = 0;
        // $jl_record->gst_subtotal        = 0;
        // $jl_record->vat_rate_id         = 0;
        // $jl_record->invoice_no          = 'n/a';
        // $jl_record->save();

        $notification= array(
            'message'       => 'Toll invoice generated successfully!',
            'alert-type'    => 'success'
        );
        return redirect('business-operation/search-customer-invoice')->with($notification);
    }
    public function toll_fee_invoice_sumview($id){
        $toll_invoice = TollFeeInvoice::find($id);
        $toll_items = TollFeeInvoiceItem::where('invoice_id', $toll_invoice->id)->get();
        // $toll_names = TollFees::all();
        return view('backend.toll-fee-invoice.invoice-sum-view', compact('toll_invoice', 'toll_items'));
    }
    public function toll_fee_invoice_sum_print($id){
        $toll_invoice = TollFeeInvoice::find($id);
        $toll_items = TollFeeInvoiceItem::where('invoice_id', $toll_invoice->id)->get();
        // $toll_names = TollFees::all();
        return view('backend.toll-fee-invoice.invoice-sum-print', compact('toll_invoice', 'toll_items'));
    }
}
