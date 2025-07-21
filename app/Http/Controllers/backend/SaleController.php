<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\JobProject;
use App\JobProjectInvoice;
use App\JobProjectInvoiceTask;
use App\JobProjectTemInvoice;
use App\Journal;
use App\JournalRecord;
use App\JournalRecordsTemp;
use App\JournalTemp;
use App\Models\AccountHead;
use App\Models\CostCenter;
use App\Models\InvoiceNumber;
use App\PartyInfo;
use App\Payment;
use App\PaymentInvoice;
use App\PayMode;
use App\PayTerm;
use App\ProjectDetail;
use App\Receipt;
use App\ReceiptSale;
use App\Sale;
use App\SaleItem;
use App\SaleRevenue;
use App\TxnType;
use App\VatRate;
use App\TaxInvoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Storage;


use function GuzzleHttp\Promise\all;

class SaleController extends Controller
{




    private function dateFormat($date)
    {
        $old_date = explode('/', $date);

        $new_data = $old_date[0] . '-' . $old_date[1] . '-' . $old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));
        $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);
        return $new_date->format('Y-m-d');
    }

    private function journal_no()
    {
        $sub_invoice = Carbon::now()->format('Ymd');
        // return $sub_invoice;
        $latest_journal_no = JournalTemp::withTrashed()->whereDate('created_at', Carbon::today())->where('journal_no', 'LIKE', "%{$sub_invoice}%")->latest('id')->first();
        // return $latest_journal_no;
        if ($latest_journal_no) {
            $journal_no = substr($latest_journal_no->journal_no, 0, -1);
            $journal_code = $journal_no + 1;
            $journal_no = $journal_code . "J";
        } else {
            $journal_no = Carbon::now()->format('Ymd') . '001' . "J";
        }

        return $journal_no;
    }
    private function sale_no()
    {
        $sub_invoice = 'INV'.Carbon::now()->format('y');
        $invoice = InvoiceNumber::where('invoice_no', 'LIKE', "%{$sub_invoice}%")->first();
        if ($invoice) {
            $number = preg_replace('/^'.$sub_invoice.'/', '', $invoice->invoice_no);
            $number++;
            if($number<10)
            {
                $invoice_no=$sub_invoice.'000'.$number;
            }
            elseif($number<100)
            {
                $invoice_no=$sub_invoice.'00'.$number;
            }
            elseif($number<1000)
            {
                $invoice_no=$sub_invoice.'0'.$number;
            }
            else
            {
                $invoice_no=$sub_invoice.$number;

            }
        } else {
            $invoice_no  = $sub_invoice . '0001';
        }
        return $invoice_no;
    }

    private function direct_sale_no()
    {
        $sub_invoice = 'D'.Carbon::now()->format('y');
        // return $sub_invoice;
        $let_sale = InvoiceNumber::where('invoice_no_s_d', 'LIKE', "%{$sub_invoice}%")->first();
        if ($let_sale) {
            $let_sale_no =preg_replace('/^'.$sub_invoice.'/', '', $let_sale->invoice_no_s_d);
            $sale_no = $let_sale_no + 1;
            if($sale_no<10)
            {
                $sale_no=$sub_invoice.'000'.$sale_no;
            }
            elseif($sale_no<100)
            {
                $sale_no=$sub_invoice.'00'.$sale_no;
            }
            elseif($sale_no<1000)
            {
                $sale_no=$sub_invoice.'0'.$sale_no;
            }
            else
            {
                $sale_no=$sub_invoice.$sale_no;

            }
        } else {
            $sale_no = $sub_invoice . '0001';
        }

        return $sale_no;

    }

    private function payment_no()
    {
        $sub_invoice = 'RV'.Carbon::now()->format('y');
        $let_purch_exp = InvoiceNumber::where('receipt_invoice_number', 'LIKE', "%{$sub_invoice}%")->first();
        if ($let_purch_exp) {
            $receipt_no =preg_replace('/^'.$sub_invoice.'/', '', $let_purch_exp->receipt_invoice_number);
            $receipt_no++;
            if($receipt_no<10)
            {
                $receipt_no=$sub_invoice.'000'.$receipt_no;
            }
            elseif($receipt_no<100)
            {
                $receipt_no=$sub_invoice.'00'.$receipt_no;
            }
            elseif($receipt_no<1000)
            {
                $receipt_no=$sub_invoice.'0'.$receipt_no;
            }
            else
            {
                $receipt_no=$sub_invoice.$receipt_no;

            }
        } else {
            $receipt_no = $sub_invoice . '0001';
        }
        return $receipt_no;
    }


    public function saleIssue(Request $records)
    {
        $projects = ProjectDetail::all();
        $modes = PayMode::get();
        $terms = PayTerm::all();
        $sub_invoice = Carbon::now()->format('Ymd');
        $cCenters = CostCenter::all();
        $txnTypes = TxnType::all();
        // $acHeads = AccountHead::where('id',476)->get();
        $acHeads = AccountHead::where('account_type_id', '1')->where('fld_definition', 'Sell of Asset')
            ->get();
        $parties = PartyInfo::where('pi_type', 'Customer')->get();
        $pInfos  = PartyInfo::where('pi_type', 'Customer')->get();
        $vats = VatRate::orderBy('id', 'desc')->get();
        $sale_no = $this->sale_no();
        return view('backend.sale.sale', compact('projects', 'sale_no', 'modes', 'terms', 'pInfos', 'cCenters', 'txnTypes', 'acHeads', 'vats', 'parties'));
    }
    public function proforma_edit($id)
    {
        $projects = ProjectDetail::all();
        $modes = PayMode::get();
        $terms = PayTerm::all();
        $sub_invoice = Carbon::now()->format('Ymd');
        $cCenters = CostCenter::all();
        $txnTypes = TxnType::all();
        // $acHeads = AccountHead::where('id',476)->get();
        $acHeads = AccountHead::where('account_type_id', '1')->where('fld_definition', 'Sell of Asset')->get();
        $parties = PartyInfo::where('pi_type', 'Customer')->get();
        $pInfos  = PartyInfo::where('pi_type', 'Customer')->get();
        $vats = VatRate::orderBy('id', 'desc')->get();
        $sales = Sale::find($id);
        // dd($sales);
        // return($sales);
        return view('backend.sale.proforma-invoice-edit', compact('projects', 'sales', 'modes', 'terms', 'pInfos', 'cCenters', 'txnTypes', 'acHeads', 'vats', 'parties'));
    }
    public function saleIssuepost(Request $request)
    {
        // return $request->all();
        $request->validate(
            [
                'date'              =>  'required',
                'party_info'        => 'required',
                'pay_mode'          => 'required',
                // 'narration'         => 'required'
            ],
            [
                'date.required'         => 'Date is required',
                'party_info.required'   => 'Party Info is required',
                'pay_mode.required'     => 'Pay Mode is required',
                // 'narration.required'    => 'Narration is required',
            ]
        );

        if ($request->hasFile('voucher_scan')) {
            $voucher_scan = $request->file('voucher_scan');
            $name = $voucher_scan->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $voucher_scan->getClientOriginalExtension();
            $voucher_file_name = $name . time() . '.' . $ext;
            $voucher_scan->storeAs('public/upload/sale', $voucher_file_name);
        }

        if ($request->hasFile('voucher_scan2')) {
            $voucher_scan2 = $request->file('voucher_scan2');
            $name = $voucher_scan2->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $voucher_scan2->getClientOriginalExtension();
            $voucher_file_name2 = $name . time() . '.' . $ext;
            $voucher_scan2->storeAs('public/upload/sale2', $voucher_file_name2);
        }
        //Update date formate
        $update_date_format = $this->dateFormat($request->date);

        //purchase expense entry
        if($request->invoice_type == 'Direct Invoice')
        {
            $sale_no = $this->direct_sale_no();
        }
        else
        {
            $sale_no = $this->sale_no();
        }
        $sale = new Sale();
        $sale->date = $update_date_format;
        $sale->pay_mode =  $request->pay_mode;
        $sale->invoice_no = $sale_no;
        $sale->project_id = $request->project;
        $sale->invoice_type = $request->invoice_type;
        $sale->head_id = 0;
        $sale->total_amount = $request->total_amount;
        $sale->vat = $request->total_vat;
        $sale->amount = $request->taxable_amount;
        $sale->party_id =  $request->party_info;
        $sale->do_no = $request->do_no;
        $sale->lpo_no =  $request->lpo_no;
        $sale->quotation_no =  $request->quotation_no;
        $sale->site_project =  $request->site_project;
        $sale->attention =  $request->attention;
        $sale->narration = 0;
        $sale->created_by = Auth::id();
        $sale->gst_subtotal = 0;
        $sale->paid_amount = $request->pay_mode == 'Credit' ?  0 : $sale->total_amount;
        $sale->due_amount = $request->pay_mode == 'Credit' ?  $sale->total_amount : 0;

        if ($request->pay_mode == 'Cheque') {
            $sale->issuing_bank = $request->issuing_bank;
            $sale->branch = $request->bank_branch;
            $sale->cheque_no =  $request->cheque_no;
            $sale->deposit_date = $this->dateFormat($request->deposit_date);
        }
        if ($request->hasFile('voucher_scan')) {
            $sale->voucher_scan = $voucher_file_name;
        }
        if ($request->hasFile('voucher_scan2')) {
            $sale->voucher_scan2 = $voucher_file_name2;
        }
        $sale->save();

        if($request->invoice_type == 'Direct Invoice')
        {
            $sales_invoice = InvoiceNumber::first();
            $sales_invoice->invoice_no_s_d = $sale->invoice_no;
            $sales_invoice->save();        }
        else
        {
            $sales_invoice = InvoiceNumber::first();
            $sales_invoice->invoice_no = $sale->invoice_no;
            $sales_invoice->save();
        }
        //end purchase expense entry
        $multi_head = $request->input('group-a');
        $t_cogs = 0;
        foreach ($multi_head as $each_head) {
            //purchase record
            $purc_exp_itm = new SaleItem();
            $purc_exp_itm->item_description = $each_head['multi_acc_head'];
            $purc_exp_itm->qty = $each_head['qty'];
            $purc_exp_itm->unit_id = $each_head['unit'];
            $purc_exp_itm->rate = $each_head['rate'];
            $purc_exp_itm->amount = $each_head['amount'];
            $purc_exp_itm->vat = $request->invoice_type == 'Tax Invoice' ? ((5 / 100) * $purc_exp_itm->amount) : 0;
            $purc_exp_itm->total_amount = $purc_exp_itm->amount + $purc_exp_itm->vat;
            $purc_exp_itm->party_id = $request->party_info;
            $purc_exp_itm->sale_id = $sale->id;
            $purc_exp_itm->gst_subtotal = 0;
            $purc_exp_itm->save();
            //end purchase record
        }
        //end records entry
        $sale = $sale;
        $projects = ProjectDetail::all();
        $modes = PayMode::get();
        $terms = PayTerm::all();
        $sub_invoice = Carbon::now()->format('Ymd');
        $cCenters = CostCenter::all();
        $txnTypes = TxnType::all();
        // $acHeads = AccountHead::where('id',476)->get();
        $acHeads = AccountHead::where('account_type_id', '1')->where('fld_definition', 'Sell of Asset')
            ->get();
        $parties = PartyInfo::where('pi_type', 'Customer')->get();
        $pInfos  = PartyInfo::where('pi_type', 'Customer')->get();
        $vats = VatRate::orderBy('id', 'desc')->get();
        return view('backend.sale.authorize-preview', compact('sale', 'pInfos', 'vats', 'sale_no', 'projects', 'modes'));
    }

    public function sale_list()
    {
        $parties = PartyInfo::get();
        $sales = JobProjectInvoice::where('invoice_type', 'Tax Invoice')->orderBy('invoice_no','DESC')->paginate(20);
        $i = 0;
        return view('backend.sale.list', compact('sales', 'i', 'parties'));
    }
    public function sale_list_proforma()
    {
        $parties = PartyInfo::get();
        $sales = JobProjectInvoice::where('invoice_type', 'Proforma Invoice')->orderBy('id','DESC')->paginate(20);
        $i = 0;
        return view('backend.sale.list-proforma', compact('sales', 'i', 'parties'));
    }
    public function sale_list_direct()
    {
        $parties = PartyInfo::get();
        $sales = JobProjectInvoice::where('invoice_type', 'Direct Invoice')->orderBy('id','DESC')->paginate(20);
        $i = 0;
        return view('backend.sale.list-direct', compact('sales', 'i', 'parties'));
    }
    public function authorize_sale_modal(Request $request)
    {
        $projects = ProjectDetail::all();
        $modes = PayMode::get();
        $terms = PayTerm::all();
        $sub_invoice = Carbon::now()->format('Ymd');
        $cCenters = CostCenter::all();
        $txnTypes = TxnType::all();
        // $acHeads = AccountHead::where('id',476)->get();
        $acHeads = AccountHead::where('account_type_id', '1')->where('fld_definition', 'Sell of Asset')
            ->get();
        $parties = PartyInfo::all();
        $pInfos  = PartyInfo::all();
        $vats = VatRate::orderBy('id', 'desc')->get();
        $sale = Sale::find($request->id);
        $sale_no = $sale->invoice_no;
        return view('backend.sale.authorize-preview', compact('sale', 'pInfos', 'vats', 'sale_no', 'projects', 'modes'));
    }

    public function approve_sale_modal(Request $request)
    {
        $projects = ProjectDetail::all();
        $modes = PayMode::get();
        $terms = PayTerm::all();
        $sub_invoice = Carbon::now()->format('Ymd');
        $cCenters = CostCenter::all();
        $txnTypes = TxnType::all();
        // $acHeads = AccountHead::where('id',476)->get();
        $acHeads = AccountHead::where('account_type_id', '1')->where('fld_definition', 'Sell of Asset')
            ->get();
        $parties = PartyInfo::all();
        $pInfos  = PartyInfo::all();
        $vats = VatRate::orderBy('id', 'desc')->get();
        $sale = Sale::find($request->id);
        $sale_no = $sale->invoice_no;
        return view('backend.sale.authorize-preview', compact('sale', 'pInfos', 'vats', 'sale_no', 'projects', 'modes'));
    }

    public function sale_modal(Request $request)
    {
        $sale = JobProjectInvoice::find($request->id);
        if ($sale->invoice_from == 'project') {
            $invoice = $sale;
            $standard = VatRate::where('name', 'Standard')->first();
            $notes = JobProjectInvoice::where('id', '<=', $sale->id)->where('job_project_id', $sale->job_project_id)->orderBy('id', 'asc')->get();
            return view('backend.sale.approve-invoice-view', compact('invoice', 'standard', 'notes'));
        } else {
        //    return $sale;
            return view('backend.sale.preview', compact('sale'));
        }
    }



    public function sale_print($id)
    {
        $sale = JobProjectInvoice::find($id);
        if ($sale->invoice_from == 'project') {
            $invoice = $sale;
            $standard = VatRate::where('name', 'Standard')->first();
            $notes = JobProjectInvoice::where('id', '<', $sale->id)->where('job_project_id', $sale->job_project_id)->orderBy('id', 'asc')->get();
            return view('backend.sale.approve-invoice-view', compact('invoice', 'standard', 'notes'));
        } else {
            return view('backend.sale.sale_print', compact('sale'));
        }
    }

    public function auth_sale_print($id)
    {
        $projects = ProjectDetail::all();
        $modes = PayMode::get();
        $terms = PayTerm::all();
        $sub_invoice = Carbon::now()->format('Ymd');
        $cCenters = CostCenter::all();
        $txnTypes = TxnType::all();
        // $acHeads = AccountHead::where('id',476)->get();
        $acHeads = AccountHead::where('account_type_id', '1')->where('fld_definition', 'Sell of Asset')
            ->get();
        $parties = PartyInfo::all();
        $pInfos  = PartyInfo::all();
        $vats = VatRate::orderBy('id', 'desc')->get();
        $sale = Sale::find($id);
        $sale_no = $sale->invoice_no;
        return view('backend.sale.auth_sale_print', compact('sale', 'pInfos', 'vats', 'sale_no', 'projects', 'modes'));
    }





    public function search_sale(Request $request)
    {
        $sales = Sale::where('invoice_type','like', "%{$request->invoice_type}%")->where('invoice_no', 'like', "%{$request->value}%")->where('authorized', $request->type == 'authorize' ? 0 : 1)->get();
        // return $sales;
        if ($request->party != '') {
            $sales = $sales->where('party_id', $request->party);
        }
        if ($request->date != '') {
            $date = $this->dateFormat($request->date);
            $sales = $sales->where('date', $date);
        }
        return view('backend.sale.search-sale', compact('sales'));
    }

    public function search_sale_inv(Request $request)
    {
        $sales = JobProjectInvoice::where('invoice_type', $request->type)->where('invoice_no', 'like', "%{$request->value}%")->get();
        if ($request->party != '') {
            $sales = $sales->where('customer_id', $request->party);
        }
        if ($request->date != '') {
            $date = $this->dateFormat($request->date);
            $sales = $sales->where('date', $date);
        }
        return view('backend.sale.search-sale-inv', compact('sales'));
    }

    public function receipt_voucher2()
    {
        $parties = PartyInfo::where('pi_type', 'Customer')->get();
        $i = 0;
        $modes = PayMode::whereNotIn('id', [2,6])->get();
        return view('backend.sale.receipt-voucher', compact( 'i', 'parties', 'modes'));
    }
    public function receipt_voucher3()
    {
        $parties = PartyInfo::where('pi_type', 'Customer')->get();
        $i = 0;
        $modes = PayMode::whereNotIn('id', [2,6])->get();
        $invoices = TaxInvoice::where('pay_mode', 'Credit')->orWhere('due_amount','>',0)->get();
        $sale_invoices = SaleRevenue::whereNotNull('approved_by')->where('pay_mode','Creddit')->orWhere('due_amount', '>', 0)->get();
        return view('backend.sale.receipt-voucher2', compact('i', 'parties', 'modes', 'invoices','sale_invoices'));
    }
    public function partyInfosale2(Request $request)
    {
        // return $request->all();
        // return 1;
        $info = PartyInfo::where('id', $request->value)->first();
        $invoices = TaxInvoice::where('due_amount', '>', 0)->where('customer_id', $info->id)->get();
        $due = $invoices->where('due_amount', '>', 0)->sum('due_amount');
        // return $invoices->sum('due_amount');

        if ($request->ajax()) {
            return Response()->json([
                'page' => view('backend.sale.receipt-invoice', ['invoices' => $invoices, 'i' => 1])->render(),
                'info' => $info,
                'due' =>  $invoices->where('due_amount', '>', 0)->sum('due_amount')
            ]);
        }
    }

    public function partyInfodueInvoices(Request $request)
    {
        // return $request->all();
        // return 1;
        $info = PartyInfo::where('id', $request->value)->first();
        $invoices = TaxInvoice::where('pay_mode', 'Credit')->orWhere('due_amount','>',0)->where('customer_id', $info->id)->get();
        $sale_invoices = SaleRevenue::where('pay_mode', 'Credit')->orWhere('due_amount','>',0)->where('party_id', $info->id)->get();
        $due = '';
        // return $invoices->sum('due_amount');

        if ($request->ajax()) {
            return Response()->json([
                'page' => view('backend.sale.due-invoice', ['invoices' => $invoices, 'i' => 1, 'sale_invoices' => $sale_invoices])->render(),
                'info' => $info,
                'due' =>  ''
            ]);
        }
    }

    public function findInvoiceforReceipt(Request $request)
    {
        if($request->invoice_from == 'sale-revenue'){
            $invoice = SaleRevenue::find($request->value);
            $info = PartyInfo::where('id', $invoice->party_id)->first();
        }else{
            $invoice = TaxInvoice::find($request->value);
            $info = PartyInfo::where('id', $invoice->customer_id)->first();
        }


        $due = $invoice->due_amount;

        if ($request->ajax()) {
            return Response()->json([
                'info' => $info,
                'due' =>  $invoice->due_amount
            ]);
        }
    }

    public function payment_post(Request $request)
    {
        // return $request->all();
        $update_date_format = $this->dateFormat($request->date);
        $sub_invoice = Carbon::now()->format('Ymd');
        $job_project = JobProject::find($request->project_id);
        $let_purch_exp = Receipt::whereDate('created_at', Carbon::today())->where('receipt_no', 'LIKE', "%{$sub_invoice}%")->latest('id')->first();
        if ($let_purch_exp) {
            $purch_no = $let_purch_exp->receipt_no + 1;
        } else {
            $purch_no = Carbon::now()->format('Ymd') . '001';
        }

        if ($request->pay_mode == "Cheque") {
            $deposit_date = $this->dateFormat($request->deposit_date);
            $payment = new Receipt();
            $payment->job_project_id = $request->project_id;
            $payment->date = $update_date_format;
            $payment->pay_mode =  $request->pay_mode;
            $payment->receipt_no = $purch_no;
            $payment->head_id = 0;
            $payment->total_amount = $request->pay_amount;
            $payment->vat = 0;
            $payment->party_id =  $request->party_info;
            $payment->narration = $request->narration;
            $payment->issuing_bank = $request->issuing_bank;
            $payment->branch = $request->bank_branch;
            $payment->cheque_no = $request->cheque_no;
            $payment->deposit_date = $deposit_date;
            $payment->status = 'Pending';
            $payment->paid_amount = $request->pay_amount;
            $payment->due_amount = $request->due_amount - $request->pay_amount;
            $payment->save();
        } else {
            $multi_head = $request->input('group-a');
            $total_vat = 0;
            $total_amount_withvat = 0;
            $total_amount = 0;
            $cost_center_id = 0;
            if ($request->cost_center_name != null) {
                $cost_center_id = $request->cost_center_name;
            }
            $latest_journal_no = Journal::withTrashed()->whereDate('created_at', Carbon::today())->where('journal_no', 'LIKE', "%{$sub_invoice}%")->latest('id')->first();
            if ($latest_journal_no) {
                $journal_no = substr($latest_journal_no->journal_no, 0, -1);
                $journal_code = $journal_no + 1;
                $journal_no = $journal_code . "J";
            } else {
                $journal_no = Carbon::now()->format('Ymd') . '001' . "J";
            }
            $payment = new Receipt();
            $payment->date = $update_date_format;
            $payment->pay_mode =  $request->pay_mode;
            $payment->receipt_no = $purch_no;
            $payment->head_id = 0;
            $payment->total_amount = $request->pay_amount;
            $payment->vat = 0;
            $payment->party_id =  $request->party_info;
            $payment->narration = $request->narration;
            $payment->status = 'Realised';
            $payment->paid_amount = $request->pay_amount;
            $payment->due_amount = $request->due_amount - $request->pay_amount;
            $payment->save();

            $journal = new Journal();
            $journal->project_id        = 1;
            $journal->transection_type        = 'RECEIPT VOUCHER';
            $journal->transaction_type        = 'DEBIT';
            $journal->journal_no        = $journal_no;
            $journal->date              = $payment->date;
            $journal->voucher_type              = 'Receipt Voucher';
            $journal->receipt_id          = $payment->id;

            $journal->pay_mode          = $payment->pay_mode;
            $journal->invoice_no        = 0;
            $journal->cost_center_id    = $cost_center_id;
            $journal->party_info_id     = $payment->party_id;
            $journal->account_head_id   = 123;
            $journal->amount            = $payment->total_amount;
            $journal->tax_rate          = 0;
            $journal->vat_amount        = 0;
            $journal->total_amount      = $payment->total_amount;
            $journal->narration         =  $payment->narration;
            $journal->created_by        = Auth::id();
            $journal->authorized_by = Auth::id();
            $journal->approved_by    = Auth::id();
            $journal->save();


            $income_head = AccountHead::find(3);
            $jl_record = new JournalRecord();
            $jl_record->journal_id     = $journal->id;
            $jl_record->project_details_id  = 1;
            $jl_record->cost_center_id      = $cost_center_id;
            $jl_record->party_info_id       = $request->party_info;
            $jl_record->journal_no          = $journal_no;
            $jl_record->account_head_id     = $income_head->id;
            $jl_record->master_account_id   = $income_head->master_account_id;
            $jl_record->account_head        = $income_head->fld_ac_head;
            $jl_record->amount              = $request->pay_amount;
            $jl_record->total_amount        = $request->pay_amount;
            $jl_record->vat_rate_id         = 0;
            $jl_record->transaction_type    = 'CR';
            $jl_record->journal_date        = $update_date_format;
            $jl_record->account_type_id = $income_head->account_type_id;
            $jl_record->is_main_head        = 0;
            $jl_record->save();

            if ($request->pay_mode == 'Cash') {
                $dd = 1;
            } else {
                $dd = 2;
            }
            $pay_head = AccountHead::find($dd);
            $jl_record = new JournalRecord();
            $jl_record->journal_id     = $journal->id;
            $jl_record->project_details_id  = 1;
            $jl_record->cost_center_id      = $cost_center_id;
            $jl_record->party_info_id       = $request->party_info;
            $jl_record->journal_no          = $journal_no;
            $jl_record->account_head_id     = $pay_head->id;
            $jl_record->master_account_id   = $pay_head->master_account_id;
            $jl_record->account_head        = $pay_head->fld_ac_head;
            $jl_record->amount              = $request->pay_amount;
            $jl_record->total_amount        = $request->pay_amount;
            $jl_record->vat_rate_id         = 0;
            $jl_record->transaction_type    = 'DR';
            $jl_record->journal_date        = $update_date_format;
            $jl_record->account_type_id = $pay_head->account_type_id;
            $jl_record->is_main_head        = 0;
            $jl_record->save();
        }


        $sale = JobProjectInvoice::where('due_amount', '>', 0)->where('customer_id', $request->party_info)->orderBy('date', 'asc')->first();
        if ($sale) {
            $pay_amount = $request->pay_amount;
            while ($pay_amount > 0) {
                if ($pay_amount < $sale->due_amount) {
                    $amount = $pay_amount;
                    $sale->due_amount = $sale->due_amount - $pay_amount;
                    $sale->paid_amount = $sale->paid_amount + $pay_amount;
                    $pay_amount = 0;
                } else {
                    $amount = $sale->due_amount;
                    $sale->paid_amount = $sale->paid_amount + $sale->due_amount;
                    $pay_amount = $pay_amount - $sale->due_amount;
                    $sale->due_amount = 0;
                }
                $sale->save();
                $purc_exp_itm = new ReceiptSale();
                $purc_exp_itm->sale_id = $sale->id;
                $purc_exp_itm->payment_id = $payment->id;
                $purc_exp_itm->Total_amount = $amount;
                $purc_exp_itm->vat = 0;
                $purc_exp_itm->amount = $amount;
                $purc_exp_itm->party_id = $request->party_info;
                $purc_exp_itm->save();
                $sale = JobProjectInvoice::where('due_amount', '>', 0)->where('customer_id', $request->party_info)->orderBy('date', 'asc')->first();
                if (!$sale) {
                    $advance = $pay_amount;
                    $pay_amount = 0;
                }
            }
        }


        $recept = $payment;
        return view('backend.sale.receipt-preview', compact('recept'));
    }

    public function receipt_voucher_list_show()
    {
        $receipt_list = Receipt::orderBy('id', 'desc')->paginate(40);
        $parties = PartyInfo::get();
        $i = 0;
        $modes = PayMode::all();
        return view('backend.sale.receipt-list', compact( 'i', 'parties', 'modes', 'receipt_list'));
    }

    public function receipt_list_modal(Request $request)
    {
        $recept = Receipt::find($request->id);
        return view('backend.sale.receipt-preview', compact('recept'));
    }


    public function search_receipt(Request $request)
    {
        $receipt_list = Receipt::where('receipt_no', 'like', "%{$request->value}%")->get();
        if ($request->party != '') {
            $receipt_list = $receipt_list->where('party_id', $request->party);
        }
        if ($request->date != '') {
            $date = $this->dateFormat($request->date);
            $receipt_list = $receipt_list->where('date', $date);
        }
        if ($request->mode != '') {
            $receipt_list = $receipt_list->where('pay_mode', $request->mode);
        }
        $i = 0;
        return view('backend.sale.search-receipt', compact('receipt_list', 'i'));
    }


    public function find_job_project(Request $request)
    {
        $proj = JobProject::find($request->value);
        $party = PartyInfo::find($proj->customer_id);
        $due = $proj->invoicess->where('due_amount', '>', 0)->sum('due_amount');
        if ($request->ajax()) {
            return Response()->json([
                'page' => view('backend.sale.search-sale', ['proj' => $proj, 'i' => 1])->render(),
                'proj' => $proj,
                'party' => $party,
                'due' => $due
            ]);
        }
    }



    public function receipt_declined($id)
    {
        $payment = Receipt::find($id);
        $payment->status = "Declined";
        $payment->save();
        $notification = array(
            'message'       => 'Declined!',
            'alert-type'    => 'warning'
        );
        return redirect()->back()->with($notification);
    }

    public function receipt_realised($id)
    {
        $receipt = Receipt::find($id);
        if ($receipt->status == 'Realised') {
            $notification = array(
                'message'       => 'Already Realised!',
                'alert-type'    => 'warning'
            );
            return redirect()->back()->with($notification);
        }
        $receipt->status = "Realised";
        $receipt->save();
        $journal_no = $this->journal_no();
        $journal = new Journal();
        $journal->project_id        = 1;
        $journal->transection_type        = 'PAYMENT VOUCHER';
        $journal->transaction_type        = 'CREDIT';
        $journal->payment_id        = $receipt->id;
        $journal->journal_no        = $journal_no;
        $journal->date              = $receipt->date;
        $journal->pay_mode          = 'Cash';
        $journal->voucher_type          = 'Payment Voucher';
        $journal->invoice_no        = 0;
        $journal->cost_center_id    = 0;
        $journal->party_info_id     = $receipt->party_id;
        $journal->account_head_id   = 123;
        $journal->amount            = $receipt->total_amount;
        $journal->tax_rate          = 0;
        $journal->vat_amount        = 0;
        $journal->total_amount      = $receipt->total_amount;
        $journal->narration         = $receipt->narration;
        $journal->created_by        = Auth::id();
        $journal->authorized_by = Auth::id();
        $journal->approved_by    = Auth::id();
        $journal->save();

        $receipt_head = AccountHead::find(3);
        $jl_record = new JournalRecord();
        $jl_record->journal_id     = $journal->id;
        $jl_record->project_details_id  = $journal->project_id;
        $jl_record->cost_center_id      = $journal->cost_center_id;
        $jl_record->party_info_id       = $journal->party_info_id;
        $jl_record->journal_no          = $journal_no;
        $jl_record->account_head_id     = $receipt_head->id;
        $jl_record->master_account_id   = $receipt_head->master_account_id;
        $jl_record->account_head        = $receipt_head->fld_ac_head;
        $jl_record->amount              = $journal->amount;
        $jl_record->total_amount        = $journal->amount;
        $jl_record->vat_rate_id         = 0;
        $jl_record->transaction_type    = 'CR';
        $jl_record->journal_date        = $journal->date;
        $jl_record->account_type_id = $receipt_head->account_type_id;
        $jl_record->is_main_head        = 0;
        $jl_record->save();


        $pay_head = AccountHead::find(2);
        $jl_record = new JournalRecord();
        $jl_record->journal_id     = $journal->id;
        $jl_record->project_details_id  = $journal->project_id;
        $jl_record->cost_center_id      = $journal->cost_center_id;
        $jl_record->party_info_id       = $journal->party_info_id;
        $jl_record->journal_no          = $journal_no;
        $jl_record->account_head_id     = $pay_head->id;
        $jl_record->master_account_id   = $pay_head->master_account_id;
        $jl_record->account_head        = $pay_head->fld_ac_head;
        $jl_record->amount              = $journal->amount;
        $jl_record->total_amount        = $journal->amount;
        $jl_record->vat_rate_id         = 0;
        $jl_record->transaction_type    = 'DR';
        $jl_record->journal_date        = $journal->date;
        $jl_record->account_type_id = $pay_head->account_type_id;
        $jl_record->is_main_head        = 0;
        $jl_record->save();


        $notification = array(
            'message'       => 'Realised!',
            'alert-type'    => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function receipt_deposit(Request $request, $id)
    {
        $receipt = Receipt::find($id);
        // dd($request->all());
        $receipt->deposit_date = $this->dateFormat($request->deposit_date);
        $receipt->save();
        $notification = array(
            'message'       => 'Success!',
            'alert-type'    => 'success'
        );
        return redirect()->back()->with($notification);
    }


    public function sale_authorize()
    {
        $parties = PartyInfo::get();
        $i = 0;
        $sales = Sale::where('authorized', false)->orderBy('id', 'DESC')->get();
        return view('backend.sale.authorize', compact('sales', 'parties', 'i'));
    }



    public function sale_authorization($id)
    {
        $purch = Sale::find($id);
        $purch->authorized = true;
        $purch->authorized_by = Auth::id();
        $purch->save();
        $notification = array(
            'message'       => 'Authorized Successfully!',
            'alert-type'    => 'success'
        );
        return redirect('sales/sale-approve')->with($notification);
    }

    public function sale_approve()
    {
        $parties = PartyInfo::get();
        $i = 0;
        $sales = Sale::where('authorized', true)->orderBy('id', 'DESC')->get();
        return view('backend.sale.approve', compact('sales', 'parties', 'i'));
    }



    public function sale_approval($id)
    {
        $sale = Sale::find($id);
        // dd($invice);
        $invoice = new JobProjectInvoice();
        $invoice->invoice_no =  $sale->invoice_no;
        $invoice->invoice_from = 'Sales';
        $invoice->customer_id =  $sale->party_id;
        $invoice->budget = $sale->amount;
        $invoice->vat = $sale->vat;
        $invoice->total_budget = $sale->total_amount;
        $invoice->date = $sale->date;
        $invoice->due_amount = $sale->due_amount;
        $invoice->paid_amount =  $sale->paid_amount;
        $invoice->narration = $sale->narration;
        $invoice->invoice_type = $sale->invoice_type;
        $invoice->approved_by    = Auth::id();
        $invoice->do_no = $sale->do_no;
        $invoice->lpo_no =  $sale->lpo_no;
        $invoice->quotation_no =  $sale->quotation_no;
        $invoice->site_project =  $sale->site_project;

        $invoice->voucher_scan =  $sale->voucher_scan;
        $invoice->voucher_scan2 =  $sale->voucher_scan2;
        $invoice->attention =  $sale->attention;

        $invoice->save();

        foreach ($sale->items as $item) {
            $purc_exp_itm = new JobProjectInvoiceTask();
            $purc_exp_itm->task_name = $item->item_description;
            $purc_exp_itm->qty = $item->qty;
            $purc_exp_itm->unit = $item->unit_id;
            $purc_exp_itm->rate = $item->rate;
            $purc_exp_itm->budget = $item->amount;
            $purc_exp_itm->vat_id = $item->amount;
            $purc_exp_itm->total_budget = $item->total_amount;
            $purc_exp_itm->vat_id =  $purc_exp_itm->budget < $purc_exp_itm->total_budget ? 1 : 3;
            $purc_exp_itm->item_description = $item->item_description;
            $purc_exp_itm->invoice_id = $invoice->id;
            $purc_exp_itm->save();
        }
        if ($invoice->invoice_type == 'Tax Invoice') {
            $journal_no = $this->journal_no();
            $journal = new Journal();
            $journal->project_id        = 1;
            $journal->invoice_id        = $invoice->id;
            $journal->transection_type = 'Sale';
            $journal->transaction_type = 'Increase';
            $journal->journal_no        = $journal_no;
            $journal->date              =  $invoice->date;
            $journal->pay_mode          = 'CREDIT';
            $journal->cost_center_id    = 0;
            $journal->party_info_id     = $invoice->customer_id;
            $journal->account_head_id   = 123;
            $journal->voucher_type   = 'CREDIT';

            $journal->amount            = $invoice->total_budget;
            $journal->tax_rate          = 0;
            $journal->vat_amount        = $invoice->total_budget - $invoice->budget;
            $journal->total_amount      = $invoice->budget;
            $journal->gst_subtotal = 0;
            $journal->narration         =  $invoice->narration;
            $journal->approved_by = $invoice->approved_by;
            $journal->save();

            //journal record
            $ac_head = AccountHead::find(7);
            $jl_record = new JournalRecord();
            $jl_record->journal_id     = $journal->id;
            $jl_record->project_details_id  = $journal->project_id;
            $jl_record->cost_center_id      = $journal->cost_center_id;
            $jl_record->party_info_id       =  $journal->party_info_id;
            $jl_record->journal_no          =  $journal->journal_no;
            $jl_record->account_head_id     = $ac_head->id;
            $jl_record->master_account_id   = $ac_head->master_account_id;
            $jl_record->account_head        = $ac_head->fld_ac_head;
            $jl_record->amount              = $invoice->budget;
            $jl_record->total_amount        = $invoice->budget;
            $jl_record->vat_rate_id         = 0;
            $jl_record->invoice_no        = 0;
            $jl_record->transaction_type    = 'CR';
            $jl_record->journal_date        =  $journal->date;
            $jl_record->is_main_head        = 1;
            $jl_record->account_type_id = $ac_head->account_type_id;
            $jl_record->save();
            //end journal record

            //vat journal
            if ($journal->vat_amount > 0) {
                $vat_ac_head = AccountHead::find(17); // vat account head
                $jl_record = new JournalRecord();
                $jl_record->journal_id     = $journal->id;
                $jl_record->project_details_id  = $journal->project_id;
                $jl_record->cost_center_id      = $journal->cost_center_id;
                $jl_record->party_info_id       = $journal->party_info_id;
                $jl_record->journal_no          =  $journal->journal_no;
                $jl_record->account_head_id     = $vat_ac_head->id;
                $jl_record->master_account_id   = $vat_ac_head->master_account_id;
                $jl_record->account_head        = $vat_ac_head->fld_ac_head;
                $jl_record->amount              = $journal->vat_amount;
                $jl_record->invoice_no              = 'N/A';
                $jl_record->total_amount        = $journal->vat_amount;
                $jl_record->vat_rate_id         = 0;
                $jl_record->transaction_type    = 'CR';
                $jl_record->journal_date        = $journal->date;
                $jl_record->account_type_id = $vat_ac_head->account_type_id;
                $jl_record->is_main_head        = 0;
                $jl_record->save();
            }
            //end vat journal

            //Paymode journal
            $ac_head = AccountHead::find(3); // accounts Receivable
            $jl_record = new JournalRecord();
            $jl_record->journal_id     = $journal->id;
            $jl_record->project_details_id  = $journal->project_id;
            $jl_record->cost_center_id      = $journal->cost_center_id;
            $jl_record->party_info_id       = $journal->party_info_id;
            $jl_record->journal_no          =  $journal->journal_no;
            $jl_record->account_head_id     = $ac_head->id;
            $jl_record->master_account_id   = $ac_head->master_account_id;
            $jl_record->account_head        = $ac_head->fld_ac_head;
            $jl_record->amount              = $journal->amount;
            $jl_record->total_amount        = $journal->amount;
            $jl_record->vat_rate_id         = 0;
            $jl_record->transaction_type    = 'DR';
            $jl_record->journal_date        = $journal->date;
            $jl_record->invoice_no              = 'N/A';
            $jl_record->account_type_id = $ac_head->account_type_id;

            $jl_record->is_main_head        = 0;
            $jl_record->save();
            //end paymode journal

            //payment voucher
            if ($sale->pay_mode != 'Credit') {
                $payment_no = $this->payment_no();
                $payment = new Receipt();
                $payment->date =  $sale->date;
                $payment->pay_mode =   $sale->pay_mode;
                $payment->receipt_no = $payment_no;
                $payment->head_id = 0;
                $payment->total_amount =  $sale->total_amount;
                $payment->vat = 0;
                $payment->party_id =  $sale->party_id;
                $payment->narration =  $sale->narration;
                $payment->paid_amount = 0;
                $payment->due_amount = 0;
                $payment->status = $sale->pay_mode != 'Cheque' ? 'Realised' : 'Pending';
                if ($sale->pay_mode == 'Cheque') {
                    $payment->issuing_bank = $sale->issuing_bank;
                    $payment->branch = $sale->branch;
                    $payment->cheque_no = $sale->cheque_no;
                    $payment->deposit_date = $sale->deposit_date;
                }
                $payment->save();
                $purc_exp_itm = new ReceiptSale();
                $purc_exp_itm->sale_id = $sale->id;
                $purc_exp_itm->payment_id = $payment->id;
                $purc_exp_itm->Total_amount = $payment->total_amount;
                $purc_exp_itm->vat = 0;
                $purc_exp_itm->amount = $payment->total_amount;
                $purc_exp_itm->party_id = $payment->party_id;
                $purc_exp_itm->save();

                $update_number = InvoiceNumber::first();
                $update_number->receipt_invoice_number = $payment->receipt_no;
                $update_number->save();



                // **************************************************
                if ($sale->pay_mode != 'Cheque') {
                    $journal_no = $this->journal_no();
                    $journal_pay = new Journal();
                    $journal_pay->project_id        = 1;
                    $journal_pay->payment_id        = $payment->id;
                    $journal_pay->transection_type = 'Receipt';
                    $journal_pay->transaction_type = 'Increase';
                    $journal_pay->journal_no        = $journal_no;
                    $journal_pay->date              = $payment->date;
                    $journal_pay->pay_mode          =  $payment->pay_mode;
                    $journal_pay->cost_center_id    = 0;
                    $journal_pay->party_info_id     =  $payment->party_id;
                    $journal_pay->account_head_id   = 123;
                    $journal_pay->voucher_type   = 'CREDIT';

                    $journal_pay->amount            = $payment->total_amount;
                    $journal_pay->tax_rate          = 0;
                    $journal_pay->vat_amount        = 0;
                    $journal_pay->total_amount      = $payment->total_amount;
                    $journal_pay->gst_subtotal = 0;
                    $journal_pay->narration         =  $payment->narration;
                    $journal_pay->approved_by = Auth::id();
                    $journal_pay->save();

                    $ac_head = AccountHead::find(3);
                    $jl_record = new JournalRecord();
                    $jl_record->journal_id     = $journal_pay->id;
                    $jl_record->project_details_id  = $journal_pay->project_id;
                    $jl_record->cost_center_id      = $journal_pay->cost_center_id;
                    $jl_record->party_info_id       = $journal_pay->party_info_id;
                    $jl_record->journal_no          =  $journal_pay->journal_no;
                    $jl_record->account_head_id     = $ac_head->id;
                    $jl_record->master_account_id   = $ac_head->master_account_id;
                    $jl_record->account_head        = $ac_head->fld_ac_head;
                    $jl_record->amount              = $journal_pay->amount;
                    $jl_record->total_amount        = $journal_pay->amount;
                    $jl_record->vat_rate_id         = 0;
                    $jl_record->transaction_type    = 'CR';
                    $jl_record->journal_date        = $journal_pay->date;
                    $jl_record->invoice_no              = 'N/A';
                    $jl_record->account_type_id = $ac_head->account_type_id;

                    $jl_record->is_main_head        = 0;
                    $jl_record->save();

                    $pay_head = $sale->pay_mode == 'Cash' ? 1 : 2;
                    $ac_head = AccountHead::find($pay_head);
                    $jl_record = new JournalRecord();
                    $jl_record->journal_id     = $journal_pay->id;
                    $jl_record->project_details_id  = $journal_pay->project_id;
                    $jl_record->cost_center_id      = $journal_pay->cost_center_id;
                    $jl_record->party_info_id       = $journal_pay->party_info_id;
                    $jl_record->journal_no          =  $journal_pay->journal_no;
                    $jl_record->account_head_id     = $ac_head->id;
                    $jl_record->master_account_id   = $ac_head->master_account_id;
                    $jl_record->account_head        = $ac_head->fld_ac_head;
                    $jl_record->amount              = $journal_pay->amount;
                    $jl_record->total_amount        = $journal_pay->amount;
                    $jl_record->vat_rate_id         = 0;
                    $jl_record->transaction_type    = 'DR';
                    $jl_record->journal_date        = $journal_pay->date;
                    $jl_record->invoice_no              = 'N/A';
                    $jl_record->account_type_id = $ac_head->account_type_id;

                    $jl_record->is_main_head        = 0;
                    $jl_record->save();
                }
                // ************************************
            }
        }
        //end payment voucher

        $sale->items->each->delete();
        $sale->delete();
        $notification = array(
            'message'       => 'Authorized Successfully!',
            'alert-type'    => 'success'
        );
        return redirect('/sales/sale-approve')->with($notification);
    }

    public function sale_delete($id)
    {
        $sale = Sale::find($id);
        $sale->items->each->delete();
        $sale->delete();
        $notification = array(
            'message'       => 'Deleted Successfully!',
            'alert-type'    => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function saleIssueEdit(Request $request)
    {
        $request->validate(
            [
                'date'              =>  'required',
                'party_info'        => 'required',
                'pay_mode'          => 'required',
                // 'narration'         => 'required'
            ],
            [
                'date.required'         => 'Date is required',
                'party_info.required'   => 'Party Info is required',
                'pay_mode.required'     => 'Pay Mode is required',
                // 'narration.required'    => 'Narration is required',
            ]
        );
        // return($request);
        $update_date_format = $this->dateFormat($request->date);
        $sale = Sale::find($request->id);
        $sale->date = $update_date_format;
        $sale->pay_mode =  $request->pay_mode;
        $sale->project_id = $request->project;
        $sale->invoice_type = $request->invoice_type;

        $sale->head_id = 0;
        $sale->total_amount = $request->total_amount;
        $sale->vat = $request->total_vat;
        $sale->amount = $request->taxable_amount;
        $sale->party_id =  $request->party_info;
        $sale->narration = 0;
        $sale->edited_by = Auth::id();
        $sale->gst_subtotal = 0;
        $sale->paid_amount = $request->pay_mode == 'Credit' ?  0 : $sale->total_amount;
        $sale->due_amount = $request->pay_mode == 'Credit' ?  $sale->total_amount : 0;
        if ($request->pay_mode == 'Cheque') {
            $sale->issuing_bank = $request->issuing_bank;
            $sale->branch = $request->bank_branch;
            $sale->cheque_no =  $request->cheque_no;
            $sale->deposit_date = $this->dateFormat($request->deposit_date);
        }
        $sale->do_no = $request->do_no;
        $sale->lpo_no =  $request->lpo_no;
        $sale->quotation_no =  $request->quotation_no;
        $sale->site_project =  $request->site_project;


        if($request->hasFile('voucher_scan')){
            $voucher_scan= $request->file('voucher_scan');
            $name= $voucher_scan->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext= $voucher_scan->getClientOriginalExtension();
            $voucher_file_name= $name.time().'.'.$ext;

            if (($sale->voucher_scan)) {
                $currentFilePath = 'public/upload/sale/' . $sale->voucher_scan;
                Storage::delete($currentFilePath);
            }

            $voucher_scan->storeAs( 'public/upload/sale', $voucher_file_name);
        }

        $voucher_file_name2=$sale->voucher_scan2;
        if($request->hasFile('voucher_scan2')){
            $voucher_scan2= $request->file('voucher_scan2');
            $name= $voucher_scan2->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext= $voucher_scan2->getClientOriginalExtension();
            $voucher_file_name2= $name.time().'.'.$ext;
            if (($sale->voucher_scan2)) {
                $currentFilePath = 'public/upload/sale2/' . $sale->voucher_scan2;
                Storage::delete($currentFilePath);
            }
            $voucher_scan2->storeAs( 'public/upload/sale2', $voucher_file_name2);
        }

        $sale->voucher_scan =  $voucher_file_name;
        $sale->voucher_scan2 = $voucher_file_name2;
        $sale->save();

        foreach ($sale->items as $item) {
            $item->delete();
        }
        //end purchase expense entry
        $multi_head = $request->input('group-a');
        $t_cogs = 0;
        foreach ($multi_head as $each_head) {
            //purchase record
            $sale_item = new SaleItem();
            $sale_item->item_description = $each_head['multi_acc_head'];
            $sale_item->qty = $each_head['qty'];
            $sale_item->unit_id = $each_head['unit'];
            $sale_item->rate = $each_head['rate'];
            $sale_item->amount = $each_head['amount'];
            $sale_item->vat = $request->invoice_type == 'Tax Invoice' ? ((5 / 100) * $sale_item->amount) : 0;
            $sale_item->total_amount = $sale_item->amount + $sale_item->vat;
            $sale_item->party_id = $request->party_info;
            $sale_item->sale_id = $sale->id;
            $sale_item->gst_subtotal = 0;
            $sale_item->save();

            //end purchase record
        }
        //end records entry

        $projects = ProjectDetail::all();
        $modes = PayMode::get();
        $terms = PayTerm::all();
        $sub_invoice = Carbon::now()->format('Ymd');
        $cCenters = CostCenter::all();
        $txnTypes = TxnType::all();
        // $acHeads = AccountHead::where('id',476)->get();
        $acHeads = AccountHead::where('account_type_id', '1')->where('fld_definition', 'Sell of Asset')
            ->get();
        $parties = PartyInfo::where('pi_type', 'Customer')->get();
        $pInfos  = PartyInfo::where('pi_type', 'Customer')->get();
        $vats = VatRate::orderBy('id', 'desc')->get();
        $sale_no = $sale->invoice_no;
        return view('backend.sale.authorize-preview', compact('sale', 'pInfos', 'vats', 'sale_no', 'projects', 'modes'));
    }

     public function receivable()
    {

        $suppliers = DB::table('party_infos')
            ->where('party_infos.pi_type', 'Customer')
            ->join('tax_invoices', 'party_infos.id', '=', 'tax_invoices.customer_id')
            ->select(
                'party_infos.id',
                'party_infos.pi_code',
                'party_infos.pi_name',
                DB::raw('SUM(CASE WHEN tax_invoices.customer_id =party_infos.id  THEN tax_invoices.due_amount ELSE 0 END ) as due_amount')
            )
            ->groupBy('party_infos.id', 'party_infos.pi_code', 'party_infos.pi_name')
            ->orderByDesc('due_amount')
            ->get();

        $suppliers2 = DB::table('party_infos')
            ->where('party_infos.pi_type', 'Customer')
            ->join('sale_revenues', 'party_infos.id', '=', 'sale_revenues.party_id')
            ->select(
                'party_infos.id',
                'party_infos.pi_code',
                'party_infos.pi_name',
                DB::raw('SUM(CASE WHEN sale_revenues.party_id =party_infos.id  THEN sale_revenues.due_amount ELSE 0 END ) as due_amount')
            )
            ->groupBy('party_infos.id', 'party_infos.pi_code', 'party_infos.pi_name')
            ->orderByDesc('due_amount')
            ->get();

        return view('backend.sale.receivable', compact('suppliers','suppliers2'));
    }


    public function search_customer_due(Request $request)
    {
        $suppliers = DB::table('party_infos')
            ->where('party_infos.id', $request->party)
            ->join('tax_invoices', 'party_infos.id', '=', 'tax_invoices.customer_id')
            ->select(
                'party_infos.id',
                'party_infos.pi_code',
                'party_infos.pi_name',
                DB::raw('SUM(CASE WHEN tax_invoices.customer_id =party_infos.id  THEN tax_invoices.due_amount ELSE 0 END ) as due_amount')
            )
            ->groupBy('party_infos.id', 'party_infos.pi_code', 'party_infos.pi_name')
            ->orderByDesc('due_amount')
            ->get();

        if($suppliers->count() <= 0){
            $suppliers = DB::table('party_infos')
            ->where('party_infos.id', $request->party)
            ->join('sale_revenues', 'party_infos.id', '=', 'sale_revenues.party_id')
            ->select(
                'party_infos.id',
                'party_infos.pi_code',
                'party_infos.pi_name',
                DB::raw('SUM(CASE WHEN sale_revenues.party_id =party_infos.id  THEN sale_revenues.due_amount ELSE 0 END ) as due_amount')
            )
            ->groupBy('party_infos.id', 'party_infos.pi_code', 'party_infos.pi_name')
            ->orderByDesc('due_amount')
            ->get();

        }

        return view('backend.sale.receivable-table', compact('suppliers'));
    }


  public function receivable_view(Request $request)
    {
        $info = PartyInfo::where('id', $request->id)->first();
        $invoices = TaxInvoice::where('due_amount', '>', 0)->where('customer_id', $info->id)->get();
        $sale_invoices = SaleRevenue::where('due_amount', '>', 0)->where('party_id', $info->id)->whereNotNull('approved_by')->get();
        $due = $invoices->where('due_amount', '>', 0)->sum('due_amount');
        return view('backend.sale.receivable-view', compact('invoices', 'sale_invoices', 'info'));
    }
    public function all_invoice_list()
    {
        $parties = PartyInfo::get();
        $sales = JobProjectInvoice::orderBy('id', 'desc')->paginate(20);
        $i = 0;
        return view('backend.sale.all-invoice-list', compact('sales', 'i', 'parties'));
    }
    public function search_all_invoice_list(Request $request)
    {
        $sales = JobProjectInvoice::orderBy('id', 'desc');
        if ($request->value) {
            $sales = $sales->where('invoice_no', 'like', '%' . $request->value . '%');
        }
        if ($request->party) {
            $sales = $sales->where('customer_id', $request->party);
        }
        if ($request->date) {
            $date = $this->dateFormat($request->date);
            $sales = $sales->where('date', $date);
        }
        $sales = $sales->get();
        return view('backend.sale.search-all-invoice', compact('sales'));
    }

     public function transection()
    {
        $parties = PartyInfo::get();
        $transections = DB::select("
        SELECT id AS id, customer_id AS party_id, date AS date, invoice_no AS transection_no, invoice_type AS invoice_type, total_budget AS amount, 'Invoice' AS data_from FROM job_project_invoices WHERE invoice_type != 'Direct Invoice' AND 'id' < 0
        UNION
        SELECT id AS id, party_id AS party_id, date AS date, receipt_no AS transection_no, 'Receipt' AS invoice_type,total_amount AS amount ,'Receipt' AS data_from FROM receipts WHERE 'id' < 0
        ;
    ");

        $i = 0;
        return view('backend.sale.transections', compact('transections', 'i', 'parties'));
    }


    public function search_all_transection_list(Request $request)
    {
        // return $request->all();
        $parties = PartyInfo::get();
        if($request->party)
        {
            $transections = DB::select("
            SELECT id AS id, customer_id AS party_id, date AS date, invoice_no AS transection_no, invoice_type AS invoice_type, total_budget AS amount, 'Invoice' AS data_from FROM job_project_invoices WHERE customer_id = $request->party AND invoice_type != 'Direct Invoice'
            UNION
            SELECT id AS id, party_id AS party_id, date AS date, receipt_no AS transection_no, 'Receipt' AS invoice_type,total_amount AS amount ,'Receipt' AS data_from FROM receipts WHERE party_id = $request->party
            ;
        ");
        }
        else
        {
            $transections = DB::select("
            SELECT id AS id, customer_id AS party_id, date AS date, invoice_no AS transection_no, invoice_type AS invoice_type, total_budget AS amount, 'Invoice' AS data_from FROM job_project_invoices WHERE invoice_type != 'Direct Invoice'
            UNION
            SELECT id AS id, party_id AS party_id, date AS date, receipt_no AS transection_no, 'Receipt' AS invoice_type,total_amount AS amount ,'Receipt' AS data_from FROM receipts
            ;
        ");
        }

        $i = 0;
        return view('backend.sale.transections_items', compact('transections', 'i', 'parties'));
    }
}
