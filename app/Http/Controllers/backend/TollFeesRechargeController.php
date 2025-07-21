<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Journal;
use App\JournalRecord;
use App\Models\AccountHead;
use App\Models\CostCenter;
use App\PartyInfo;
use App\PayMode;
use App\PayTerm;
use App\ProjectDetail;
use App\TollFees;
use App\TollFeesRecharge;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;

class TollFeesRechargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $toll_names = TollFees::all();
        $suppliers= PartyInfo::where('pi_type','Supplier')->orWhere('pi_type','Third Party')->get();
        $pay_modes= PayMode::all();
        $projects= ProjectDetail::all();
        $cost_centers= CostCenter::all();
        $pay_modes= PayMode::all();
        $terms = PayTerm::get();
        return view('backend.toll-fees.toll-fees-recharge', compact('toll_names', 'suppliers', 'pay_modes', 'projects', 'cost_centers', 'terms'));
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
        ]);
        $old_date = explode('/', $request->date);
        $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));

        $recharge = new TollFeesRecharge;
        $recharge->toll_fees_id = $request->toll_fees_id;
        $recharge->date = $new_date;
        $recharge->amount = $request->amount;
        $recharge->expense = 0.00;
        $recharge->remaining = $request->amount;
        $recharge->pay_mode = $request->pay_mode;
        $recharge->customer_id = $request->customer_id;
        $recharge->remaining = $request->amount;
        $save = $recharge->save();
        if($save){
            $toll = TollFees::find($request->toll_fees_id);
            $toll->amount = $toll->amount+$request->amount;
            $toll->save();
        }
        
        // Journal Entry
        $sub_invoice = Carbon::now()->format('Ymd');

        $latest_journal_no = Journal::withTrashed()->whereDate('created_at', Carbon::today())->where('journal_no', 'LIKE', "%{$sub_invoice}%")->latest()->first();

        if ($latest_journal_no) {
            $journal_no = substr($latest_journal_no->journal_no,0,-1);
            $journal_code = $journal_no + 1;
            $journal_no = $journal_code . "J";
        } else {
            $journal_no = Carbon::now()->format('Ymd') . '001' . "J";
        }
        $journal= new Journal();
        $journal->transection_type  = "Toll Fee recharge";
        $journal->transaction_type  = "Toll Fee recharge";
        $journal->without_gst       = $recharge->amount;
        $journal->gst_subtotal      = 0;
        $journal->project_id        = $request->project;
        $journal->journal_no        = $journal_no;
        $journal->date              = $new_date;
        $journal->pay_mode          = $request->pay_mode;
        $journal->invoice_no        = $recharge->id;
        $journal->cost_center_id    = $request->cost_center?$request->cost_center:0;
        $journal->party_info_id     = $request->customer_id;
        $journal->account_head_id   = 123;
        $journal->amount            = $recharge->amount;
        $journal->tax_rate          = 0;
        $journal->vat_amount        = 0;
        $journal->total_amount      = $recharge->amount;
        $journal->narration         = 'Toll Fee by '. $request->pay_mode ;
        $journal->created_by        = Auth::id();
        $journal->voucher_type      = 'default';
        $journal->authorized        = 1;
        $journal->approved          = 1;
        $journal->authorized_by     = Auth::id();
        $journal->approved_by       = Auth::id();
        $journal->save();
        
        // Main Entry
        $acc_head= AccountHead::find(30); // Toll fee account
        $jl_record= new JournalRecord();
        $jl_record->journal_id          = $journal->id;
        $jl_record->project_details_id  = $journal->project_id ;
        $jl_record->cost_center_id      = $journal->cost_center_id;
        $jl_record->party_info_id       = $journal->party_info_id;
        $jl_record->journal_no          = $journal->journal_no;
        $jl_record->account_head_id     = $acc_head->id;
        $jl_record->master_account_id   = $acc_head->master_account_id;
        $jl_record->account_head        = $acc_head->fld_ac_head;
        $jl_record->amount              = $journal->amount;
        $jl_record->total_amount        = $journal->total_amount;
        $jl_record->is_main_head        = 1;
        $jl_record->transaction_type    = 'DR';
        $jl_record->journal_date        = $journal->date;
        $jl_record->account_type_id     = $acc_head->account_type_id;
        $jl_record->gst_amount          = 0;
        $jl_record->gst_subtotal        = 0;
        $jl_record->vat_rate_id         = 0;
        $jl_record->invoice_no          = 'n/a';
        $jl_record->save();

        if($request->pay_mode=='Cash'){
            $ac_head_cr= AccountHead::find(1); // Cash Operating Account           
        }elseif($request->pay_mode=='Card'){
            $ac_head_cr= AccountHead::find(2); // Bank Account
        }
        $jl_record= new JournalRecord();
        $jl_record->journal_id          = $journal->id;
        $jl_record->project_details_id  = $journal->project_id;
        $jl_record->cost_center_id      = $journal->cost_center_id;
        $jl_record->party_info_id       = $journal->party_info_id;
        $jl_record->journal_no          = $journal_no;
        $jl_record->account_head_id     = $ac_head_cr->id;
        $jl_record->master_account_id   = $ac_head_cr->master_account_id;
        $jl_record->account_head        = $ac_head_cr->fld_ac_head;
        $jl_record->amount              = $recharge->amount;
        $jl_record->total_amount        = $recharge->amount;
        $jl_record->transaction_type    = 'CR';
        $jl_record->journal_date        = $journal->date;
        $jl_record->account_type_id     = $ac_head_cr->account_type_id;
        $jl_record->gst_amount          = 0;
        $jl_record->gst_subtotal        = 0;
        $jl_record->vat_rate_id         = 0;
        $jl_record->invoice_no          = 'n/a';
        $jl_record->save();

        return back()->with('success', 'Toll Fees Recharge Complete');
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
    public function toll_fees_view_modal(Request $request){
        $toll_name = TollFees::find($request->id);
        $toll_recharges = TollFeesRecharge::where('toll_fees_id', $request->id)->orderBy('date', 'asc')->get();
        return view('backend.toll-fees.recharge-view', compact('toll_name', 'toll_recharges'));
    }
}
