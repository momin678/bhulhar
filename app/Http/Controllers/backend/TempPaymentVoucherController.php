<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Journal;
use App\JournalRecord;
use App\Models\AccountHead;
use App\Models\InvoiceNumber;
use App\PartyInfo;
use App\Payment;
use App\PaymentInvoice;
use App\PayMode;
use App\PurchaseExpense;
use App\TempPaymentVoucher;
use App\TempPaymentVoucherDetail;
use App\SupplierInvoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class TempPaymentVoucherController extends Controller
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

    private function payment_no()
    {
        $sub_invoice = Carbon::now()->format('Ymd');
        $let_purch_exp = Payment::whereDate('created_at', Carbon::today())->where('payment_no', 'LIKE', "%{$sub_invoice}%")->latest('id')->first();
        if ($let_purch_exp) {
            $purch_code = substr($let_purch_exp->payment_no,3);
            $purch_code = $purch_code + 1;
            $payment_no = "PV-".$purch_code;
        } else {
            $payment_no = "PV-".Carbon::now()->format('Ymd') . '001';
        }
        return $payment_no;
    }

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
    public function temp_payment_voucher_store(Request $request){
        // return $request->date;
        // dd($request->all());
        $update_date_format = $this->dateFormat($request->date);
        $sub_invoice = 'PV'.Carbon::now()->format('y');
        $let_purch_exp = InvoiceNumber::where('payment_no', 'LIKE', "%{$sub_invoice}%")->first();
        if ($let_purch_exp) {
            $purch_code =preg_replace('/^'.$sub_invoice.'/', '', $let_purch_exp->payment_no);
            $purch_code = $purch_code + 1;
            if($purch_code<10)
            {
                $payment_no=$sub_invoice.'000'.$purch_code;
            }
            elseif($purch_code<100)
            {
                $payment_no=$sub_invoice.'00'.$purch_code;
            }
            elseif($purch_code<1000)
            {
                $payment_no=$sub_invoice.'0'.$purch_code;
            }
            else
            {
                $payment_no=$sub_invoice.$purch_code;

            }
        } else {
            $payment_no = $sub_invoice . '0001';
        }

        $voucher_file_name = '';
        $ext = '';
        if($request->hasFile('voucher_file')){
            $voucher_scan = $request->file('voucher_file');
            $name = $voucher_scan->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $voucher_scan->getClientOriginalExtension();
            $voucher_file_name = $name.time(). '.' . $ext;
            $voucher_scan->storeAs('public/upload/documents', $voucher_file_name);
        }
        $payment = new TempPaymentVoucher();
        $payment->date = $update_date_format;
        $payment->pay_mode =  $request->pay_mode;
        $payment->payment_no = $payment_no;
        $payment->head_id = 0;
        $payment->total_amount = $request->pay_amount;
        $payment->vat = 0;
        $payment->party_id =  $request->party_info;
        $payment->narration = $request->narration;
        $payment->paid_amount = 0;
        $payment->due_amount = 0;
        $payment->issuing_bank = $request->issuing_bank;
        $payment->branch = $request->bank_branch;
        $payment->cheque_no = $request->cheque_no;
        $payment->voucher_file = $voucher_file_name;
        $payment->extension = $ext;

        if($request->deposit_date){
            $deposit_date = $this->dateFormat($request->deposit_date);
            $payment->deposit_date = $deposit_date;
        }
        $payment->save();

        $payment_invoice = InvoiceNumber::first();
        $payment_invoice->payment_no = $payment->payment_no;
        $payment_invoice->save();
        
                
        if(array_sum($request->due_pay_amount)>0){
            foreach($request->due_pay_amount as $key => $d_amount){
                if($d_amount>0){
                    if($request->type[$key] == 'expenses'){
                        $due_supplier = PurchaseExpense::find($request->ids[$key]);
                        $due_supplier->paid_amount = $due_supplier->paid_amount + $request->due_pay_amount[$key];
                        $due_supplier->due_amount = $due_supplier->due_amount - $request->due_pay_amount[$key];
                        $due_supplier->save();
                    }else{
                        $due_supplier = SupplierInvoice::find($request->ids[$key]);
                        $due_supplier->paid_amount = $due_supplier->paid_amount + $request->due_pay_amount[$key];
                        $due_supplier->due_amount = $due_supplier->due_amount - $request->due_pay_amount[$key];
                        $due_supplier->save();
                    }
                    $purc_exp_itm = new TempPaymentVoucherDetail();
                    $purc_exp_itm->sale_id = $due_supplier->id;
                    $purc_exp_itm->payment_id = $payment->id;
                    $purc_exp_itm->Total_amount = $request->due_pay_amount[$key];
                    $purc_exp_itm->vat = 0;
                    $purc_exp_itm->amount = $request->due_pay_amount[$key];
                    $purc_exp_itm->party_id = $payment->party_id;
                    $purc_exp_itm->come_from = $request->type[$key];
                    $purc_exp_itm->checked = 'yes';
                    $purc_exp_itm->save();
                }
            }
        }else{
            // dd($request->records);
            if($request->records && count($request->records)>0){
                // dd($request->type_input);
                $pay_amount = $request->pay_amount;
                foreach($request->records as $key => $record_id){
                    if($pay_amount >0){
                        // dd($request->type_input);
                        if($request->type_input[$key]=='expenses'){
                            $purchase = PurchaseExpense::find($record_id);
                            if ($pay_amount < $purchase->due_amount) {
                                $amount = $pay_amount;
                                $purchase->due_amount = $purchase->due_amount - $pay_amount;
                                $purchase->paid_amount = $purchase->paid_amount + $pay_amount;
                                $pay_amount = 0;
                            } else {
                                $amount = $purchase->due_amount;
                                $purchase->paid_amount = $purchase->paid_amount + $purchase->due_amount;
                                $pay_amount = $pay_amount - $purchase->due_amount;
                                $purchase->due_amount = 0;
                            }
                            $purchase->save();
                            $purc_exp_itm = new TempPaymentVoucherDetail();
                            $purc_exp_itm->sale_id = $purchase->id;
                            $purc_exp_itm->payment_id = $payment->id;
                            $purc_exp_itm->Total_amount = $amount;
                            $purc_exp_itm->vat = 0;
                            $purc_exp_itm->amount = $amount;
                            $purc_exp_itm->party_id = $payment->party_id;
                            $purc_exp_itm->come_from ='expenses';
                            $purc_exp_itm->checked = 'yes';
                            $purc_exp_itm->save();
                        }else{
                            $due_supplier = SupplierInvoice::find($record_id);
                            if($pay_amount < $due_supplier->due_amount){
                                $amount = $pay_amount;
                                $due_supplier->due_amount = $due_supplier->due_amount - $pay_amount;
                                $due_supplier->paid_amount = $due_supplier->paid_amount + $pay_amount;
                                $pay_amount = 0;
                            }else{
                                $amount = $due_supplier->due_amount;
                                $due_supplier->paid_amount = $due_supplier->paid_amount + $due_supplier->due_amount;
                                $due_supplier->due_amount = 0;
                                $pay_amount = $pay_amount - $due_supplier->due_amount;
                            }
                            $due_supplier->save();
                            $purc_exp_itm = new TempPaymentVoucherDetail();
                            $purc_exp_itm->sale_id = $due_supplier->id;
                            $purc_exp_itm->payment_id = $payment->id;
                            $purc_exp_itm->Total_amount = $amount;
                            $purc_exp_itm->vat = 0;
                            $purc_exp_itm->amount = $amount;
                            $purc_exp_itm->party_id = $payment->party_id;
                            $purc_exp_itm->come_from ='service_expense';
                            $purc_exp_itm->checked = 'yes';
                            $purc_exp_itm->save();
                        }
                    }
                }
            }else{
                $pay_amount = $request->pay_amount;
                while ($pay_amount > 0) {
                    $purchase = PurchaseExpense::where('due_amount', '>', 0)->where('party_id', $payment->party_id)->orderBy('date', 'asc')->first();
                    if($purchase){
                        if ($pay_amount < $purchase->due_amount) {
                            // dd($purchase->due_amount);
                            $amount = $pay_amount;
                            $purchase->due_amount = $purchase->due_amount - $pay_amount;
                            $purchase->paid_amount = $purchase->paid_amount + $pay_amount;
                            $pay_amount = 0;
                        } else {
                            $amount = $purchase->due_amount;
                            $purchase->paid_amount = $purchase->paid_amount + $purchase->due_amount;
                            $pay_amount = $pay_amount - $purchase->due_amount;
                            $purchase->due_amount = 0;
                        }
                        $purchase->save();
                        // dd($amount);
                        $purc_exp_itm = new TempPaymentVoucherDetail();
                        $purc_exp_itm->sale_id = $purchase->id;
                        $purc_exp_itm->payment_id = $payment->id;
                        $purc_exp_itm->Total_amount = $amount;
                        $purc_exp_itm->vat = 0;
                        $purc_exp_itm->amount = $amount;
                        $purc_exp_itm->party_id = $payment->party_id;
                        $purc_exp_itm->come_from = 'expenses';
                        $purc_exp_itm->save();
                    }else{
                        $due_supplier = SupplierInvoice::where('due_amount', '>', 0)->where('supplier_id', $payment->party_id)->orderBy('date', 'asc')->first();
                        if($due_supplier){
                            // dd($due_supplier);
                            if($pay_amount < $due_supplier->due_amount){
                                $amount = $pay_amount;
                                $due_supplier->due_amount = $due_supplier->due_amount - $pay_amount;
                                $due_supplier->paid_amount = $due_supplier->paid_amount + $pay_amount;
                                $pay_amount = 0;
                            }else{
                                $amount = $due_supplier->due_amount;
                                $due_supplier->paid_amount = $due_supplier->paid_amount + $due_supplier->due_amount;
                                $due_supplier->due_amount = 0;
                                $pay_amount = $pay_amount - $due_supplier->due_amount;
                            }
                            $due_supplier->save();
                            $purc_exp_itm = new TempPaymentVoucherDetail();
                            $purc_exp_itm->sale_id = $due_supplier->id;
                            $purc_exp_itm->payment_id = $payment->id;
                            $purc_exp_itm->Total_amount = $amount;
                            $purc_exp_itm->vat = 0;
                            $purc_exp_itm->amount = $amount;
                            $purc_exp_itm->party_id = $payment->party_id;
                            $purc_exp_itm->come_from = 'supplier';
                            $purc_exp_itm->save();
                        }
                    }                    
                }
            }
        }

        // $payment->due_amount = PurchaseExpense::where('due_amount', '>', 0)->where('party_id', $request->party_info)->sum('due_amount');
        // $payment->advance = $advance;
        // $payment->save();

        return view('backend.payment-voucher.payment-preview', compact('payment'));
    }
    public function payment_voucher_authorize($id){
        $payment_voucher = TempPaymentVoucher::find($id);
        $payment_voucher->is_authorize = 1;
        $payment_voucher->save();
        $notification = array(
            'message'       => 'Authorize successfull!',
            'alert-type'    => 'success'
        );
        return redirect()->back()->with($notification);
    }
    public function temp_payment_voucher_authorize(Request $request){
        $payments = TempPaymentVoucher::where('is_authorize', 0)->get();
        return view('backend.payment-voucher.payment-voucher-authorize', compact('payments'));
    }
    public function temp_payment_voucher_approve(Request $request){
        $payments = TempPaymentVoucher::where('is_authorize', 1)->get();
        return view('backend.payment-voucher.payment-voucher-approve', compact('payments'));
    }
    public function temp_payment_voucher_preview(Request $request){
        $payment = TempPaymentVoucher::find($request->id);
        return view('backend.payment-voucher.payment-preview', compact('payment'));
    }
    public function payment_voucher_approve($id){
        $temp_payment_voucher = TempPaymentVoucher::find($id);
        // dd($temp_payment_voucher);
        if($temp_payment_voucher->pay_mode == "Cheque"){
            $payment = new Payment();
            $payment->date = $temp_payment_voucher->date;
            $payment->pay_mode =  $temp_payment_voucher->pay_mode;
            $payment->payment_no = $temp_payment_voucher->payment_no;
            $payment->head_id = 0;
            $payment->total_amount = $temp_payment_voucher->total_amount;
            $payment->vat = 0;
            $payment->party_id =  $temp_payment_voucher->party_id;
            $payment->narration = $temp_payment_voucher->narration;
            $payment->paid_amount = 0;
            $payment->due_amount = 0;
            $payment->issuing_bank = $temp_payment_voucher->issuing_bank;
            $payment->branch = $temp_payment_voucher->branch;
            $payment->cheque_no = $temp_payment_voucher->cheque_no;
            $payment->deposit_date = $temp_payment_voucher->deposit_date;
            $payment->status = 'Pending';
            $payment->voucher_file = $temp_payment_voucher->voucher_file;
            $payment->extension = $temp_payment_voucher->extension;
            $payment->save();
            $payment_details = TempPaymentVoucherDetail::where('payment_id', $temp_payment_voucher->id)->get();
            foreach($payment_details as $detail){
                $purc_exp_itm = new PaymentInvoice();
                $purc_exp_itm->sale_id = $detail->sale_id;
                $purc_exp_itm->payment_id = $payment->id;;
                $purc_exp_itm->total_amount = $detail->total_amount;
                $purc_exp_itm->vat = 0;
                $purc_exp_itm->amount = $detail->amount;
                $purc_exp_itm->party_id = $detail->party_id;
                $purc_exp_itm->come_from = $detail->come_from;
                $purc_exp_itm->save();
                $detail->delete();
            }
        }else{
            $payment = new Payment();
            $payment->date = $temp_payment_voucher->date;
            $payment->pay_mode =  $temp_payment_voucher->pay_mode;
            $payment->payment_no =  $temp_payment_voucher->payment_no;
            $payment->head_id = 0;
            $payment->total_amount = $temp_payment_voucher->total_amount;
            $payment->vat = 0;
            $payment->party_id =  $temp_payment_voucher->party_id;
            $payment->narration = $temp_payment_voucher->narration;
            $payment->paid_amount = 0;
            $payment->due_amount = 0;
            $payment->status = 'Realised';
            $payment->voucher_file = $temp_payment_voucher->voucher_file;
            $payment->extension = $temp_payment_voucher->extension;
            $payment->save();
            $payment_details = TempPaymentVoucherDetail::where('payment_id', $temp_payment_voucher->id)->get();
            foreach($payment_details as $detail){
                $purc_exp_itm = new PaymentInvoice();
                $purc_exp_itm->sale_id = $detail->sale_id;
                $purc_exp_itm->payment_id = $payment->id;
                $purc_exp_itm->total_amount = $detail->total_amount;
                $purc_exp_itm->vat = 0;
                $purc_exp_itm->amount = $detail->amount;
                $purc_exp_itm->party_id = $detail->party_id;
                $purc_exp_itm->come_from = $detail->come_from;
                $purc_exp_itm->save();
                $detail->delete();
            }

            $cost_center_id = 0;
            if ($temp_payment_voucher->cost_center_name != null) {
                $cost_center_id = $temp_payment_voucher->cost_center_name;
            }
            $sub_invoice = Carbon::now()->format('Ymd');
            $latest_journal_no = Journal::withTrashed()->whereDate('created_at', Carbon::today())->where('journal_no', 'LIKE', "%{$sub_invoice}%")->latest('id')->first();
            if ($latest_journal_no) {
                $journal_no = substr($latest_journal_no->journal_no, 0, -1);
                $journal_code = $journal_no + 1;
                $journal_no = $journal_code . "J";
            } else {
                $journal_no = Carbon::now()->format('Ymd') . '001' . "J";
            }
            $update_date_format = $payment->date;
            $journal = new Journal();
            $journal->project_id        = 1;
            $journal->transection_type        = 'PAYMENT VOUCHER';
            $journal->transaction_type        = 'CREDIT';
            $journal->payment_id        = $payment->id;
            $journal->journal_no        = $journal_no;
            $journal->date              = $update_date_format;
            $journal->pay_mode          = $payment->pay_mode;
            $journal->voucher_type          = 'CREDIT';
            $journal->invoice_no        = 0;
            $journal->cost_center_id    = $cost_center_id;
            $journal->party_info_id     = $payment->party_id;
            $journal->account_head_id   = 123;
            $journal->amount            = $payment->total_amount;
            $journal->tax_rate          = 0;
            $journal->vat_amount        = 0;
            $journal->total_amount      = $payment->total_amount;
            $journal->narration         = $payment->narration;
            $journal->created_by        = Auth::id();
            $journal->authorized_by = Auth::id();
            $journal->approved_by    = Auth::id();
            $journal->save();

            $income_head = AccountHead::find(5);
            $jl_record = new JournalRecord();
            $jl_record->journal_id     = $journal->id;
            $jl_record->project_details_id  = 1;
            $jl_record->cost_center_id      = $cost_center_id;
            $jl_record->party_info_id       = $payment->party_id;
            $jl_record->journal_no          = $journal_no;
            $jl_record->account_head_id     = $income_head->id;
            $jl_record->master_account_id   = $income_head->master_account_id;
            $jl_record->account_head        = $income_head->fld_ac_head;
            $jl_record->amount              = $payment->total_amount;
            $jl_record->total_amount        = $payment->total_amount;
            $jl_record->vat_rate_id         = 0;
            $jl_record->transaction_type    = 'DR';
            $jl_record->journal_date        = $update_date_format;
            $jl_record->account_type_id = $income_head->account_type_id;
            $jl_record->is_main_head        = 0;
            $jl_record->save();

            if ($payment->pay_mode == 'Cash') {
                $dd = 1;
            } else {
                $dd = 2;
            }
            $pay_head = AccountHead::find($dd);
            $jl_record = new JournalRecord();
            $jl_record->journal_id     = $journal->id;
            $jl_record->project_details_id  = 1;
            $jl_record->cost_center_id      = $cost_center_id;
            $jl_record->party_info_id       = $payment->party_id;
            $jl_record->journal_no          = $journal_no;
            $jl_record->account_head_id     = $pay_head->id;
            $jl_record->master_account_id   = $pay_head->master_account_id;
            $jl_record->account_head        = $pay_head->fld_ac_head;
            $jl_record->amount              = $payment->total_amount;
            $jl_record->total_amount        = $payment->total_amount;
            $jl_record->vat_rate_id         = 0;
            $jl_record->transaction_type    = 'CR';
            $jl_record->journal_date        = $update_date_format;
            $jl_record->account_type_id = $pay_head->account_type_id;
            $jl_record->is_main_head        = 0;
            $jl_record->save();
        }

        $temp_payment_voucher->delete();
        $notification = array(
            'message'       => 'Approve successfull!',
            'alert-type'    => 'success'
        );
        return redirect()->back()->with($notification);
    }
    public function temp_payment_voucher_edit($id){
        $temp_payment_voucher = TempPaymentVoucher::find($id);
        $parties = PartyInfo::get();
        $modes = PayMode::whereNotIn('id', [2,6])->get();
        $payment_details = TempPaymentVoucherDetail::where('payment_id', $id)->get();
        $expenses = PurchaseExpense::where('due_amount', '>', 0)->where('party_id', $temp_payment_voucher->party_id)->get();
        $suppier_due = SupplierInvoice::where('due_amount', '>', 0)->where('supplier_id', $temp_payment_voucher->party_id)->get();
        $payment_ids = [];
        $supplier_ids = [];
        foreach($payment_details as $details){
            if($details->come_from=='expenses'){
                if(!in_array($details->sale_id, $payment_ids)){
                    array_push($payment_ids, $details->sale_id);
                }
            }else{
                if(!in_array($details->sale_id, $supplier_ids)){
                    array_push($supplier_ids, $details->sale_id);
                }
            }
        }
        foreach($expenses as $expense){
            if(!in_array($expense->id, $payment_ids)){
                array_push($payment_ids, $expense->id);
            }
        }
        foreach($suppier_due as $supplier){
            if(!in_array($supplier->id, $supplier_ids)){
                array_push($supplier_ids, $supplier->id);
            }
        }
        $new_expenses = PurchaseExpense::whereIn('id', $payment_ids)->get();
        // dd($new_expenses);
        $new_supplier = SupplierInvoice::whereIn('id', $supplier_ids)->get();
        $due = $expenses->where('due_amount', '>', 0)->sum('due_amount')+$suppier_due->where('due_amount', '>', 0)->sum('due_amount')+$payment_details->sum('total_amount');
        return view('backend.payment-voucher.temp-payment-voucher-edit', compact('temp_payment_voucher' ,'parties', 'modes', 'new_expenses', 'due', 'new_supplier'));
    }
    public function temp_payment_voucher_update(Request $request){
        // dd($request->all());
        $update_date_format = $this->dateFormat($request->date);
        // dd($update_date_format);
        $payment = TempPaymentVoucher::find($request->temp_payment_voucher_id);
        if ($request->pay_mode == "Cheque") {
            $deposit_date = $this->dateFormat($request->deposit_date);
            $payment->date = $update_date_format;
            $payment->pay_mode =  $request->pay_mode;
            $payment->total_amount = $request->pay_amount;
            $payment->narration = $request->narration;
            $payment->issuing_bank = $request->issuing_bank;
            $payment->branch = $request->bank_branch;
            $payment->cheque_no = $request->cheque_no;
            $payment->deposit_date = $deposit_date;
            $payment->paid_amount = $request->pay_amount;
            $payment->due_amount = $request->due_amount - $request->pay_amount;
            $payment->save();
        } else {
            $payment->date = $update_date_format;
            $payment->pay_mode =  $request->pay_mode;
            $payment->total_amount = $request->pay_amount;
            $payment->narration = $request->narration;
            $payment->paid_amount = $request->pay_amount;
            $payment->due_amount = $request->due_amount - $request->pay_amount;
            $payment->save();
        }

        $voucher_file_name = $payment->voucher_file;
        $ext = $payment->extension;
        if($request->hasFile('voucher_file')){
            if(Storage::exists('public/upload/documents/'. $payment->voucher_file)){
                Storage::delete('public/upload/documents/'. $payment->voucher_file);

            }
            $voucher_scan = $request->file('voucher_file');
            $name = $voucher_scan->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $voucher_scan->getClientOriginalExtension();
            $voucher_file_name = $name.time(). '.' . $ext;
            $voucher_scan->storeAs('public/upload/documents', $voucher_file_name);

        }
        $payment->voucher_file = $voucher_file_name;
        $payment->extension = $ext;
        $payment->save();
        // dd($payment);
        $payment_details = TempPaymentVoucherDetail::where('payment_id', $payment->id)->get();
        // dd($payment_details);
        foreach($payment_details as $details){
            if($details->come_from=='expenses'){
                $purchase = PurchaseExpense::find($details->sale_id);
                $purchase->due_amount = $purchase->due_amount + $details->total_amount;
                $purchase->paid_amount = $purchase->paid_amount - $details->total_amount;
                $purchase->save();
            }else{
                $purchase = SupplierInvoice::find($details->sale_id);
                $purchase->due_amount = $purchase->due_amount + $details->total_amount;
                $purchase->paid_amount = $purchase->paid_amount - $details->total_amount;
                $purchase->save();
            }
            $details->delete();
        }
        
        if(array_sum($request->due_pay_amount)>0){
            foreach($request->due_pay_amount as $key => $d_amount){
                if($d_amount>0){
                    if($request->type[$key] == 'expenses'){
                        $due_supplier = PurchaseExpense::find($request->ids[$key]);
                        $due_supplier->paid_amount = $due_supplier->paid_amount + $request->due_pay_amount[$key];
                        $due_supplier->due_amount = $due_supplier->due_amount - $request->due_pay_amount[$key];
                        $due_supplier->save();
                    }else{
                        $due_supplier = SupplierInvoice::find($request->ids[$key]);
                        $due_supplier->paid_amount = $due_supplier->paid_amount + $request->due_pay_amount[$key];
                        $due_supplier->due_amount = $due_supplier->due_amount - $request->due_pay_amount[$key];
                        $due_supplier->save();
                    }
                    $purc_exp_itm = new TempPaymentVoucherDetail();
                    $purc_exp_itm->sale_id = $due_supplier->id;
                    $purc_exp_itm->payment_id = $payment->id;
                    $purc_exp_itm->Total_amount = $request->due_pay_amount[$key];
                    $purc_exp_itm->vat = 0;
                    $purc_exp_itm->amount = $request->due_pay_amount[$key];
                    $purc_exp_itm->party_id = $payment->party_id;
                    $purc_exp_itm->come_from = $request->type[$key];
                    $purc_exp_itm->checked = 'yes';
                    $purc_exp_itm->save();
                }
            }
        }else{
            // dd($request->records);
            if($request->records && count($request->records)>0){
                // dd($request->type_input);
                $pay_amount = $request->pay_amount;
                foreach($request->records as $key => $record_id){
                    if($pay_amount >0){
                        // dd($request->type_input);
                        if($request->type_input[$key]=='expenses'){
                            $purchase = PurchaseExpense::find($record_id);
                            if ($pay_amount < $purchase->due_amount) {
                                $amount = $pay_amount;
                                $purchase->due_amount = $purchase->due_amount - $pay_amount;
                                $purchase->paid_amount = $purchase->paid_amount + $pay_amount;
                                $pay_amount = 0;
                            } else {
                                $amount = $purchase->due_amount;
                                $purchase->paid_amount = $purchase->paid_amount + $purchase->due_amount;
                                $pay_amount = $pay_amount - $purchase->due_amount;
                                $purchase->due_amount = 0;
                            }
                            $purchase->save();
                            $purc_exp_itm = new TempPaymentVoucherDetail();
                            $purc_exp_itm->sale_id = $purchase->id;
                            $purc_exp_itm->payment_id = $payment->id;
                            $purc_exp_itm->Total_amount = $amount;
                            $purc_exp_itm->vat = 0;
                            $purc_exp_itm->amount = $amount;
                            $purc_exp_itm->party_id = $payment->party_id;
                            $purc_exp_itm->come_from ='expenses';
                            $purc_exp_itm->checked = 'yes';
                            $purc_exp_itm->save();
                        }else{
                            $due_supplier = SupplierInvoice::find($record_id);
                            if($pay_amount < $due_supplier->due_amount){
                                $amount = $pay_amount;
                                $due_supplier->due_amount = $due_supplier->due_amount - $pay_amount;
                                $due_supplier->paid_amount = $due_supplier->paid_amount + $pay_amount;
                                $pay_amount = 0;
                            }else{
                                $amount = $due_supplier->due_amount;
                                $due_supplier->paid_amount = $due_supplier->paid_amount + $due_supplier->due_amount;
                                $due_supplier->due_amount = 0;
                                $pay_amount = $pay_amount - $due_supplier->due_amount;
                            }
                            $due_supplier->save();
                            $purc_exp_itm = new TempPaymentVoucherDetail();
                            $purc_exp_itm->sale_id = $due_supplier->id;
                            $purc_exp_itm->payment_id = $payment->id;
                            $purc_exp_itm->Total_amount = $amount;
                            $purc_exp_itm->vat = 0;
                            $purc_exp_itm->amount = $amount;
                            $purc_exp_itm->party_id = $payment->party_id;
                            $purc_exp_itm->come_from ='service_expense';
                            $purc_exp_itm->checked = 'yes';
                            $purc_exp_itm->save();
                        }
                    }
                }
            }else{
                $pay_amount = $request->pay_amount;
                while ($pay_amount > 0) {
                    $purchase = PurchaseExpense::where('due_amount', '>', 0)->where('party_id', $payment->party_id)->orderBy('date', 'asc')->first();
                    if($purchase){
                        if ($pay_amount < $purchase->due_amount) {
                            // dd($purchase->due_amount);
                            $amount = $pay_amount;
                            $purchase->due_amount = $purchase->due_amount - $pay_amount;
                            $purchase->paid_amount = $purchase->paid_amount + $pay_amount;
                            $pay_amount = 0;
                        } else {
                            $amount = $purchase->due_amount;
                            $purchase->paid_amount = $purchase->paid_amount + $purchase->due_amount;
                            $pay_amount = $pay_amount - $purchase->due_amount;
                            $purchase->due_amount = 0;
                        }
                        $purchase->save();
                        // dd($amount);
                        $purc_exp_itm = new TempPaymentVoucherDetail();
                        $purc_exp_itm->sale_id = $purchase->id;
                        $purc_exp_itm->payment_id = $payment->id;
                        $purc_exp_itm->Total_amount = $amount;
                        $purc_exp_itm->vat = 0;
                        $purc_exp_itm->amount = $amount;
                        $purc_exp_itm->party_id = $payment->party_id;
                        $purc_exp_itm->come_from = 'expenses';
                        $purc_exp_itm->save();
                    }else{
                        $due_supplier = SupplierInvoice::where('due_amount', '>', 0)->where('supplier_id', $payment->party_id)->orderBy('date', 'asc')->first();
                        if($due_supplier){
                            // dd($due_supplier);
                            if($pay_amount < $due_supplier->due_amount){
                                $amount = $pay_amount;
                                $due_supplier->due_amount = $due_supplier->due_amount - $pay_amount;
                                $due_supplier->paid_amount = $due_supplier->paid_amount + $pay_amount;
                                $pay_amount = 0;
                            }else{
                                $amount = $due_supplier->due_amount;
                                $due_supplier->paid_amount = $due_supplier->paid_amount + $due_supplier->due_amount;
                                $due_supplier->due_amount = 0;
                                $pay_amount = $pay_amount - $due_supplier->due_amount;
                            }
                            $due_supplier->save();
                            $purc_exp_itm = new TempPaymentVoucherDetail();
                            $purc_exp_itm->sale_id = $due_supplier->id;
                            $purc_exp_itm->payment_id = $payment->id;
                            $purc_exp_itm->Total_amount = $amount;
                            $purc_exp_itm->vat = 0;
                            $purc_exp_itm->amount = $amount;
                            $purc_exp_itm->party_id = $payment->party_id;
                            $purc_exp_itm->come_from = 'supplier';
                            $purc_exp_itm->save();
                        }
                    }
    
                    
                }
            }
        }
        $notification = array(
            'message'       => 'Update successfull!',
            'alert-type'    => 'success'
        );
        return redirect()->route('temp-payment-voucher-approve')->with($notification);
    }

    public function temp_payment_voucher_delete($id){
        $temp_payment_voucher = TempPaymentVoucher::find($id);

        foreach($temp_payment_voucher->temp_payment_voucher_details as $detail){
            if($detail->come_from=='expenses'){
                $purchase_expense = PurchaseExpense::find($detail->sale_id);
                $purchase_expense->due_amount = $purchase_expense->due_amount + $detail->amount;
                $purchase_expense->paid_amount = $purchase_expense->paid_amount - $detail->amount;
                $purchase_expense->save();
            }else{
                $purchase_expense = SupplierInvoice::find($detail->sale_id);
                $purchase_expense->due_amount = $purchase_expense->due_amount + $detail->amount;
                $purchase_expense->paid_amount = $purchase_expense->paid_amount - $detail->amount;
                $purchase_expense->save();
            }
            $detail->delete();
        }

        $temp_payment_voucher->delete();

        return back()->with(['alert-type' => 'success','message' => 'Successfully payment voucher deleted']);
    }


}
