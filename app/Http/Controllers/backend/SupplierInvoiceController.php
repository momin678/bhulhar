<?php

namespace App\Http\Controllers\backend;

use App\DebitCreditVoucher;
use App\Http\Controllers\Controller;
use App\Journal;
use App\JournalRecord;
use App\Models\AccountHead;
use App\Models\CostCenter;
use App\PartyInfo;
use App\PaymentVoucher;
use App\PayMode;
use App\PayTerm;
use App\ProjectDetail;
use App\SupplierInvoice;
use App\SupplierInvoiceItem;
use App\SupplierInvoiceItemTemp;
use App\SupplierInvoiceTemp;
use App\TaxInvoice;
use App\TaxInvoiceItem;
use App\Truck;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Svg\Tag\Rect;

class SupplierInvoiceController extends Controller
{
    public function supplier_invoice(Request $request){
        if (Auth::user()->hasPermission('app.invoice.invoice_create'))
        {
            $trucks= Truck::all();
            $customers= PartyInfo::where('pi_type','Customer')->get();
            $suppliers= PartyInfo::where('pi_type','Supplier')->orWhere('pi_type','Third Party')->get();

            if($request->has('supplier_id')){
                $supplier_id=$request->supplier_id;

                if($request->from !='' && $request->to !=''){
                    $old_date = explode('/', $request->from);
                    $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
                    $new_date = date('Y-m-d', strtotime($new_data));
                    $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);
                    $old_date2 = explode('/', $request->to);
                    $new_data2 = $old_date2[0].'-'.$old_date2[1].'-'.$old_date2[2];
                    $new_date2 = date('Y-m-d', strtotime($new_data2));
                    $new_date2 = \DateTime::createFromFormat("Y-m-d", $new_date2);

                    $records= TaxInvoiceItem::where('supplier_id',$request->supplier_id)->where('is_invoiced', 0)->whereBetween('date',[$new_date,$new_date2])->orderBy('id','desc')->paginate(15)->withQueryString();
                }else{
                    $records= TaxInvoiceItem::where('supplier_id',$request->supplier_id)->where('is_invoiced', 0)->orderBy('id','desc')->paginate(15)->withQueryString();
                }
                // return $records;

                return view('backend.supplier-invoice.supplier-invoice', compact('customers', 'trucks','suppliers','records','supplier_id'));
            }

            return view('backend.supplier-invoice.supplier-invoice', compact('customers', 'trucks','suppliers'));
        }

        elseif (Auth::user()->hasPermission('app.invoice.invoice_authorize'))
        {
            return redirect('business-operation/authorize-supplier-invoice');
       }
       elseif (Auth::user()->hasPermission('app.invoice.invoice_approval'))
       {
           return redirect('business-operation/approval-supplier-invoice');
      }
      else
      {
        return redirect('business-operation/supplier-invoice-list');

      }
    }


    public function supplier_invoice_process(Request $request){
        // return $request;
        $supplier_id= $request->supplier_id;
        $records=$request->records;
        $records= TaxInvoiceItem::whereIn('id',$records)->get();
        $suppliers= PartyInfo::where('pi_type','Supplier')->get();
        $projects= ProjectDetail::all();
        $cost_centers= CostCenter::all();
        $pay_modes= PayMode::whereNotIn('id', [6])->get();
        // return $projects;
        return view('backend.supplier-invoice.supplier-invoice-process', compact('suppliers','records','supplier_id','projects','cost_centers','pay_modes'));
    }


    public function save_supplier_invoice(Request $request){
        // return $request;
        // return $record_data= TruckRecords::whereIn('id', $request->record_id)->get();
        // return $record= TruckRecords::find(8);

        $latest_inv_no = SupplierInvoiceTemp::latest()->first();
        if ($latest_inv_no) {
            $invoice_no= $latest_inv_no->invoice_no+1;
        } else {
            $invoice_no = Carbon::now()->format('Ym') . '000001';
        }
        $old_date = explode('/', $request->date);
        $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));
        $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);

        $tax_invoice                = new SupplierInvoiceTemp();
        $tax_invoice->invoice_no    = $invoice_no;
        $tax_invoice->supplier_id   = $request->supplier_id;
        $tax_invoice->project_id    = $request->project;
        $tax_invoice->date          = $new_date;
        $tax_invoice->pay_mode      = $request->pay_mode;
        $tax_invoice->cost_center_id=$request->cost_center;

        $tax_invoice->amount        = $request->total_amount;
        $tax_invoice->vat_amount    = $request->total_vat;
        $tax_invoice->paid_amount   = $request->payment_amount;
        $tax_invoice->due_amount    = $request->due_amount;
        $tax_invoice->invoice_scan  = 'default.jpg';
        $tax_invoice->created_by  = Auth::id();
        $tax_invoice->save();
        $i=0;
        $total_amount= 0;
        $total_vat=0;
        foreach($request->record_id as $record){
            $record_data= TaxInvoiceItem::find($record);
            // return $record_data->destination;
            $rate= $request->rate[$i];
            $amount= round($record_data->qty*$rate,2);
            $v_amount= round($amount * $request->v_rate / 100,2);
            $total_amount= $total_amount+ $amount;
            $total_vat= $total_vat + $v_amount;

            $desc= 'From '.$record_data->crusher.' To '.$record_data->destination;

            $inv_item                   = new SupplierInvoiceItemTemp();
            $inv_item->invoice_id       = $tax_invoice->id;
            $inv_item->invoice_no       = $tax_invoice->invoice_no;
            $inv_item->invoice_item_id  = $record;
            $inv_item->record_id        = $record_data->record->id;
            $inv_item->truck_id         = $record_data->truck_id;
            $inv_item->supplier_id      = $request->supplier_id;
            $inv_item->customer_id      = $record_data->customer_id;
            $inv_item->description      = $desc;
            $inv_item->crusher          = $record_data->crusher;
            $inv_item->destination      = $record_data->destination;
            $inv_item->qty              = $record_data->qty;
            $inv_item->rate             = $rate;
            $inv_item->amount           = $amount;
            $inv_item->vat_rate         = $request->v_rate;
            $inv_item->vat_amount       = $v_amount;
            $inv_item->date             = $new_date;
            $inv_item->save();

            // update status of invoice item: is_invoiced=1
            $record_data->is_invoiced=1;
            $record_data->save();

            $i++;
        }

        $total_vat                  = round($total_amount*$request->v_rate / 100, 2);
        $tax_invoice->amount        = $total_amount;
        $tax_invoice->vat_amount    = $total_vat;
        $tax_invoice->paid_amount   = $request->payment_amount;
        $tax_invoice->due_amount    = $total_amount+ $total_vat - $request->payment_amount;
        $tax_invoice->save();

        $notification= array(
            'message'       => 'Invoice generated successfully!',
            'alert-type'    => 'success'
        );

        return redirect('business-operation/supplier')->with($notification);
    }

    public function supplier_invoice_print($id){
        $invoice= SupplierInvoice::find($id);
        $terms = PayTerm::all();
        return view('backend.supplier-invoice.print-supplier-invoice', compact('invoice', 'terms'));
    }

    public function supplier_invoice_view($id){
        $invoice= SupplierInvoice::find($id);
        return view('backend.supplier-invoice.supplier-invoice-view', compact('invoice'));
    }

    public function supplier_invoice_sumview($id){
        $invoice= SupplierInvoice::find($id);
        $invoice_items= DB::table('supplier_invoice_items')
        ->select('crusher', 'destination','rate','vat_rate', DB::raw('sum(qty) as total_qty'))
        ->groupBy('crusher','destination','rate','vat_rate')
        ->where('invoice_id', $id)
        ->get();
        // return $invoice_items;
        return view('backend.supplier-invoice.supplier-invoice-sumview', compact('invoice','invoice_items'));
    }

    public function supplier_invoice_sum_print($id){
        $invoice= SupplierInvoice::find($id);
        $invoice_items= DB::table('supplier_invoice_items')
        ->select('crusher', 'destination','rate','vat_rate', DB::raw('sum(qty) as total_qty'))
        ->groupBy('crusher','destination','rate','vat_rate')
        ->where('invoice_id', $id)
        ->get();
        // return $invoice_items;
        $terms = PayTerm::all();
        return view('backend.supplier-invoice.print-supplier-invoice-sum', compact('invoice','invoice_items', 'terms'));
    }


    public function pre_decline_supplier_invoice($id)
    {
        $pre_inv=SupplierInvoiceTemp::find($id);
        if($pre_inv->status=="Authorize")
       {
        Gate::authorize('app.invoice.invoice_authorize');
        // dd(2);
        $pre_inv->status="Decline";
        $pre_inv->declined_by=Auth::id();
        $pre_inv->save();
        foreach($pre_inv->items as $item)
        {
            $record_data= TaxInvoiceItem::find($item->invoice_item_id);
            $record_data->is_invoiced=0;
            $record_data->save();
        }
       }
       elseif($pre_inv->status=="Approve")
       {
        Gate::authorize('app.invoice.invoice_approval');
        // dd(2);
        $pre_inv->status="Decline";
        $pre_inv->declined_by=Auth::id();
        $pre_inv->save();
        foreach($pre_inv->items as $item)
        {
            $record_data= TaxInvoiceItem::find($item->invoice_item_id);
            $record_data->is_invoiced=0;
            $record_data->save();
        }
       }

       $notification= array(
        'message'       => 'Invoice Authorized successfully!',
        'alert-type'    => 'success'
    );
    return back()->with($notification);
    }

    public function pre_authorize_supplier_invoice($id)
    {


        $pre_inv=SupplierInvoiceTemp::find($id);
        if($pre_inv->status=="Authorize")
       {
        Gate::authorize('app.invoice.invoice_authorize');
        // dd(2);
        $pre_inv->status="Approve";
        $pre_inv->authorized_by=Auth::id();
        $pre_inv->save();
        $notification= array(
            'message'       => 'Invoice Authorized successfully!',
            'alert-type'    => 'success'
        );
        return redirect('business-operation/authorize-supplier-invoice')->with($notification);
       }
       else
       {
        // dd(1);
        Gate::authorize('app.invoice.invoice_approval');
        $latest_inv_no = SupplierInvoice::latest()->first();
        if ($latest_inv_no) {
            $invoice_no= $latest_inv_no->invoice_no+1;
        } else {
            $invoice_no = Carbon::now()->format('Ym') . '000001';
        }

        $tax_invoice                = new SupplierInvoice();
        $tax_invoice->invoice_no    = $invoice_no;
        $tax_invoice->supplier_id   = $pre_inv->supplier_id;
        $tax_invoice->project_id    = $pre_inv->project_id;
        $tax_invoice->date          = $pre_inv->date ;
        $tax_invoice->pay_mode      = $pre_inv->pay_mode;
        $tax_invoice->cost_center_id= $pre_inv->cost_center_id;
        $tax_invoice->amount        = $pre_inv->amount;
        $tax_invoice->vat_amount    = $pre_inv->vat_amount;
        $tax_invoice->paid_amount   = $pre_inv->paid_amount;
        $tax_invoice->due_amount    = $pre_inv->due_amount;
        $tax_invoice->invoice_scan  = $pre_inv->invoice_scan;
        $tax_invoice->created_by  = $pre_inv->created_by;
        $tax_invoice->authorized_by  = $pre_inv->authorized_by;
        $tax_invoice->approved_by  = Auth::id();
        // dd($tax_invoice);
        $tax_invoice->save();

        $v_rate=0;

        foreach($pre_inv->items as $record){

            $inv_item                   = new SupplierInvoiceItem();
            $inv_item->invoice_id       = $tax_invoice->id;
            $inv_item->invoice_no       = $tax_invoice->invoice_no;
            $inv_item->invoice_item_id  = $record->invoice_item_id;
            $inv_item->record_id        = $record->record_id;
            $inv_item->truck_id         = $record->truck_id;
            $inv_item->supplier_id      = $record->supplier_id;
            $inv_item->customer_id      = $record->customer_id;
            $inv_item->description      = $record->description;
            $inv_item->crusher          = $record->crusher;
            $inv_item->destination      = $record->destination;
            $inv_item->qty              = $record->qty;
            $inv_item->rate             = $record->rate;
            $inv_item->amount           = $record->amount;
            $inv_item->vat_rate         = $record->vat_rate;
            $inv_item->vat_amount       = $record->vat_amount;
            $inv_item->date             = $record->date;
            $inv_item->save();
            $v_rate=$record->vat_rate;
        }

        //  Journal Entry
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
        $journal->transection_type  = "Supplier Invoice";
        $journal->transaction_type  = "Supplier Invoice";
        $journal->without_gst       = $tax_invoice->amount;
        $journal->gst_subtotal      = $tax_invoice->vat_amount;
        $journal->project_id        = $tax_invoice->project_id;
        $journal->journal_no        = $journal_no;
        $journal->date              = $tax_invoice->date;
        $journal->pay_mode          = $tax_invoice->pay_mode;
        $journal->invoice_no        = $tax_invoice->invoice_no;
        $journal->cost_center_id    = $tax_invoice->cost_center_id?$tax_invoice->cost_center_id:0;
        $journal->party_info_id     = $tax_invoice->supplier_id;
        $journal->account_head_id   = 123;
        $journal->amount            = $tax_invoice->amount+ $tax_invoice->vat_amount;
        $journal->tax_rate          = $v_rate;
        $journal->vat_amount        = $tax_invoice->vat_amount;
        $journal->total_amount      = $tax_invoice->amount+ $tax_invoice->vat_amount;
        $journal->narration         = 'Payment to 3rd party supplier ';
        $journal->created_by        = Auth::id();
        $journal->voucher_type      = 'default';
        $journal->authorized        = 1;
        $journal->approved          = 1;
        $journal->authorized_by     = Auth::id();
        $journal->approved_by       = Auth::id();
        $journal->save();

        // Main Entry
        $acc_head= AccountHead::find(28); // 3rd party supplier account head
        $jl_record= new JournalRecord();
        $jl_record->journal_id          = $journal->id;
        $jl_record->project_details_id  = $tax_invoice->project_id;
        $jl_record->cost_center_id      = $journal->cost_center_id;
        $jl_record->party_info_id       = $tax_invoice->supplier_id;
        $jl_record->journal_no          = $journal->journal_no;
        $jl_record->account_head_id     = $acc_head->id;
        $jl_record->master_account_id   = $acc_head->master_account_id;
        $jl_record->account_head        = $acc_head->fld_ac_head;
        $jl_record->amount              = $tax_invoice->amount;
        $jl_record->total_amount        = $tax_invoice->amount;
        $jl_record->transaction_type    = 'DR';
        $jl_record->journal_date        = $tax_invoice->date;
        $jl_record->account_type_id     = $acc_head->account_type_id;
        $jl_record->gst_amount          = 0;
        $jl_record->gst_subtotal        = 0;
        $jl_record->vat_rate_id         = 1;
        $jl_record->invoice_no          = 'n/a';
        $jl_record->save();

        // vat entry to journal
        if($inv_item->vat_amount>0){
            $vat_ac_head= AccountHead::find(17); // output vat account payble
            $jl_record= new JournalRecord();
            $jl_record->journal_id          = $journal->id;
            $jl_record->project_details_id  = $tax_invoice->project_id;
            $jl_record->cost_center_id      = $journal->cost_center_id;
            $jl_record->party_info_id       = $tax_invoice->supplier_id;
            $jl_record->journal_no          = $journal->journal_no;
            $jl_record->account_head_id     = $vat_ac_head->id;
            $jl_record->master_account_id   = $vat_ac_head->master_account_id;
            $jl_record->account_head        = $vat_ac_head->fld_ac_head;
            $jl_record->amount              =  $journal->vat_amount;
            $jl_record->total_amount        =  $journal->vat_amount;
            $jl_record->transaction_type    = 'DR';
            $jl_record->account_type_id     = $vat_ac_head->account_type_id;
            $jl_record->journal_date        = $tax_invoice->date;
            $jl_record->gst_amount          = $journal->total_amount;
            $jl_record->gst_subtotal        = $journal->vat_amount;
            $jl_record->vat_rate_id         = 1;
            $jl_record->invoice_no          = 'n/a';
            $jl_record->save();
        }
        if($tax_invoice->due_amount){
            $acc_head= AccountHead::find(5); // account payable
            $jl_record= new JournalRecord();
            $jl_record->journal_id          = $journal->id;
            $jl_record->project_details_id  = $tax_invoice->project_id;
            $jl_record->cost_center_id      = $journal->cost_center_id;
            $jl_record->party_info_id       = $tax_invoice->supplier_id;
            $jl_record->journal_no          = $journal->journal_no;
            $jl_record->account_head_id     = $acc_head->id;
            $jl_record->master_account_id   = $acc_head->master_account_id;
            $jl_record->account_head        = $acc_head->fld_ac_head;
            $jl_record->amount              = $tax_invoice->due_amount;
            $jl_record->total_amount        = $tax_invoice->due_amount;
            $jl_record->transaction_type    = 'CR';
            $jl_record->journal_date        = $tax_invoice->date;
            $jl_record->account_type_id     = $acc_head->account_type_id;
            $jl_record->gst_amount          = $journal->total_amount;
            $jl_record->gst_subtotal        = $journal->vat_amount;
            $jl_record->vat_rate_id         = 1;
            $jl_record->invoice_no          = 'n/a';
            $jl_record->save();
        }
        // Opposit entry of journal
        if($tax_invoice->pay_mode =='Cash' || $tax_invoice->pay_mode =='Card'){
            // payment voucher
            $payment_voucher                = new PaymentVoucher();
            $payment_voucher->type          = 'due';
            $payment_voucher->cost_center_id= $journal->cost_center_id;
            $payment_voucher->party_info_id = $journal->party_info_id;
            $payment_voucher->amount        = $tax_invoice->paid_amount;
            $payment_voucher->payment_date  = $journal->date;
            $payment_voucher->pay_mode      = $journal->pay_mode;
            $payment_voucher->narration     = $journal->narration;
            $payment_voucher->project_id    = $journal->project_id;
            $payment_voucher->date          = $journal->date;
            $payment_voucher->created_by    = Auth::id();
            $payment_voucher->authorized_by = Auth::id();
            $payment_voucher->approved_by   = Auth::id();
            $payment_voucher->save();

            if($payment_voucher->pay_mode=='Cash'){
                $ac_head_cr= AccountHead::find(1); // Cash Operating Account
            }elseif($payment_voucher->pay_mode=='Card'){
                $ac_head_cr= AccountHead::find(2); // Bank Account
            }

            $jl_record= new JournalRecord();
            $jl_record->journal_id          = $journal->id;
            $jl_record->project_details_id  = $payment_voucher->project_id;
            $jl_record->cost_center_id      = $payment_voucher->cost_center_id;
            $jl_record->party_info_id       = $payment_voucher->party_info_id;
            $jl_record->journal_no          = $journal_no;
            $jl_record->account_head_id     = $ac_head_cr->id;
            $jl_record->master_account_id   = $ac_head_cr->master_account_id;
            $jl_record->account_head        = $ac_head_cr->fld_ac_head;
            $jl_record->amount              = $payment_voucher->amount;
            $jl_record->transaction_type    = 'CR';
            $jl_record->account_type_id     = $ac_head_cr->account_type_id;
            $jl_record->journal_date        = $payment_voucher->date;
            $jl_record->gst_amount          = 0;
            $jl_record->gst_subtotal        = 0;
            $jl_record->vat_rate_id         = 0;
            $jl_record->invoice_no          = 'n/a';
            $jl_record->save();
        }

        $pre_inv->items->each->delete();
        $pre_inv->delete();
        $notification= array(
            'message'       => 'Invoice Approved successfully!',
            'alert-type'    => 'success'
        );

        return redirect('business-operation/approval-supplier-invoice')->with($notification);

       }
    }

    public function pre_supplier_invoice_view($id){
        Gate::authorize('app.invoice.invoice_view');
        $invoice= SupplierInvoiceTemp::find($id);
        return view('backend.supplier-invoice.pre-supplier-invoice-view', compact('invoice'));
    }

    public function supplier_invoice_list(Request $request){
        Gate::authorize('app.invoice.invoice_view');
        $invoices= SupplierInvoice::orderBy('id', 'asc');
        if($request->date){
            $old_date = explode('/', $request->date);
            $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
            $new_date = date('Y-m-d', strtotime($new_data));
            $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);
            $invoices = $invoices->where('date', $new_date);
        }
        if($request->from && $request->to){
            $old_date = explode('/', $request->from);
            $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
            $new_date = date('Y-m-d', strtotime($new_data));
            $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);
            $old_date2 = explode('/', $request->to);
            $new_data2 = $old_date2[0].'-'.$old_date2[1].'-'.$old_date2[2];
            $new_date2 = date('Y-m-d', strtotime($new_data2));
            $new_date2 = \DateTime::createFromFormat("Y-m-d", $new_date2);

            $invoices = $invoices->whereBetween('date', [$$new_date, $$new_date2]);
        }
        $invoices = $invoices->get();
        return view('backend.supplier-invoice.supplier-invoice-list', compact('invoices'));
    }

    public function authorize_supplier_invoice_list(){
        Gate::authorize('app.invoice.invoice_authorize');
        $invoices= SupplierInvoiceTemp::where('status',"Authorize")->get();
        return view('backend.supplier-invoice.authorize-supplier-invoice-list', compact('invoices'));
    }

    public function approval_supplier_invoice_list(){
        Gate::authorize('app.invoice.invoice_approval');
        $invoices= SupplierInvoiceTemp::where('status',"Approve")->get();
        return view('backend.supplier-invoice.authorize-supplier-invoice-list', compact('invoices'));
    }

    public function declined_supplier_invoice_list(){
        Gate::authorize('app.invoice.invoice_view');
        $invoices= SupplierInvoiceTemp::where('status',"Decline")->get();
        return view('backend.supplier-invoice.authorize-supplier-invoice-list', compact('invoices'));
    }
    public function search_supplier_invoice(Request $request){
        Gate::authorize('app.invoice.invoice_approval');
        $suppliers= PartyInfo::where('pi_type','Supplier')->get();
        $invoices = [];
        $temp_invoices = [];
        if($request->supplier_id){
            $invoices = SupplierInvoice::where('supplier_id', $request->supplier_id)->get();
            $temp_invoices= SupplierInvoiceTemp::where('supplier_id', $request->supplier_id)->get();
        }
        if($request->date){
            $old_date = explode('/', $request->date);
            $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
            $new_date = date('Y-m-d', strtotime($new_data));
            $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);
            // dd($new_date);
            $invoices = SupplierInvoice::where('date', $new_date)->get();
            $temp_invoices= SupplierInvoiceTemp::where('date', $new_date)->get();
        }
        if($request->from && $request->to){
            $old_date = explode('/', $request->from);
            $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
            $new_date = date('Y-m-d', strtotime($new_data));
            $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);
            $old_date2 = explode('/', $request->to);
            $new_data2 = $old_date2[0].'-'.$old_date2[1].'-'.$old_date2[2];
            $new_date2 = date('Y-m-d', strtotime($new_data2));
            $new_date2 = \DateTime::createFromFormat("Y-m-d", $new_date2);

            $invoices = SupplierInvoice::whereBetween('date', [$new_date, $new_date2])->get();
            $temp_invoices= SupplierInvoiceTemp::where('date', [$new_date, $new_date2])->get();
        }
        return view('backend.supplier-invoice.search-supplier-invoice', compact('suppliers', 'invoices', 'temp_invoices'));
    }

    public function delete_invoice($id){
        $invoice= SupplierInvoiceTemp::find($id);
        foreach($invoice->items as $inv_item){
            $record= TaxInvoiceItem::find($inv_item->invoice_item_id);
            $record->is_invoiced=0;
            $record->save();
        }

        $invoice->items->each->delete();
        $invoice->delete();
        $notification= array(
            'message'       => 'Invoice Deleted!',
            'alert-type'    => 'success'
        );

        return back()->with($notification);
    }
    public function supplier_draft_invoice_list(Request $request){
        Gate::authorize('app.invoice.invoice_create');
        $invoices= SupplierInvoiceTemp::where('status',"Draft")->get();
        return view('backend.supplier-invoice.draft-supplier-invoice-list', compact('invoices'));
    }
    public function draft_supplier_invoice_view($id){
        Gate::authorize('app.invoice.invoice_create');
        $invoice= SupplierInvoiceTemp::find($id);
        return view('backend.supplier-invoice.draft-pre-supplier-invoice-view', compact('invoice'));
    }
    public function submit_draft_supplier_invoice($id){
        $invoice= SupplierInvoiceTemp::find($id);
        $invoice->status = 'Authorize';
        $invoice->save();
        $notification= array(
            'message'       => 'Invoice Submit successfully!',
            'alert-type'    => 'success'
        );
        return redirect('business-operation/supplier-draft-invoice-list')->with($notification);
    }
    public function service_reports(Request $request){
        $date = '';
        $to = '';
        $from = '';
        $customer = '';
        $customers = PartyInfo::all();
        $tax_invoices = TaxInvoice::orderBy('id', 'asc');
        if($request->date){
            $old_date = explode('/', $request->date);
            $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
            $new_date = date('Y-m-d', strtotime($new_data));

            $date = $new_date;
            $tax_invoices = $tax_invoices->where('date', $new_date);
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
            $tax_invoices = $tax_invoices->whereBetween('date', [$new_date, $new_date2]);
        }if($request->customer_id){
            $customer = PartyInfo::find($request->customer_id);
            $tax_invoices = $tax_invoices->where('customer_id', $request->customer_id);
        }
        if($request->date || ($request->from && $request->to) || $request->truck_id){
            $tax_invoices = $tax_invoices->get();
            return view('backend.report.service-invoice-report', compact('customers', 'tax_invoices', 'date', 'to', 'from', 'customer'));
        }else{
            $tax_invoices = $tax_invoices->where('date', date('Y-m-d'))->get();
        }
        return view('backend.report.service-invoice-report', compact('customers', 'tax_invoices', 'date', 'to', 'from', 'customer'));
    }
}
