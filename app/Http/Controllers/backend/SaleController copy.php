<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\JobProject;
use App\JobProjectInvoice;
use App\Journal;
use App\JournalRecord;
use App\JournalRecordsTemp;
use App\JournalTemp;
use App\Models\AccountHead;
use App\Models\CostCenter;
use App\PartyInfo;
use App\Payment;
use App\PayMode;
use App\PayTerm;
use App\ProjectDetail;
use App\Receipt;
use App\ReceiptSale;
use App\Sale;
use App\SaleItem;
use App\TxnType;
use App\VatRate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $sub_invoice = Carbon::now()->format('Ymd');
        // return $sub_invoice;
        $let_sale = Sale::whereDate('created_at', Carbon::today())->where('invoice_no', 'LIKE', "%{$sub_invoice}%")->latest('id')->first();
        if ($let_sale) {
            $sale_no = $let_sale->invoice_no + 1;
        } else {
            $sale_no = Carbon::now()->format('Ymd') . '001';
        }
        return $sale_no;
    }

    private function payment_no()
    {
        $sub_invoice = Carbon::now()->format('Ymd');
        $let_purch_exp = Receipt::whereDate('created_at', Carbon::today())->where('payment_no', 'LIKE', "%{$sub_invoice}%")->latest('id')->first();
        if ($let_purch_exp) {
            $payment_no = $let_purch_exp->payment_no + 1;
        } else {
            $payment_no = Carbon::now()->format('Ymd') . '001';
        }
        return $payment_no;
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
        $parties = PartyInfo::all();
        $pInfos  = PartyInfo::all();
        $vats = VatRate::orderBy('id', 'desc')->get();
        $sale_no = $this->sale_no();
        return view('backend.sale.sale', compact('projects', 'sale_no', 'modes', 'terms', 'pInfos', 'cCenters', 'txnTypes', 'acHeads', 'vats', 'parties'));
    }

    public function saleIssuepost(Request $request)
    {
        // dd($request->all());
        // return $request->all();
        // return $request->voucher_scan;
        $request->validate(
            [
                'date'              =>  'required',
                'party_info'        => 'required',
                'pay_mode'          => 'required',
                'narration'         => 'required'
            ],
            [
                'date.required'         => 'Date is required',
                'party_info.required'   => 'Party Info is required',
                'pay_mode.required'     => 'Pay Mode is required',
                'narration.required'    => 'Narration is required',
            ]
        );


        if ($request->hasFile('voucher_scan')) {
            $voucher_scan = $request->file('voucher_scan');
            $name = $voucher_scan->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $voucher_scan->getClientOriginalExtension();
            $voucher_file_name = $name . time() . '.' . $ext;
            $voucher_scan->storeAs('public/upload/documents', $voucher_file_name);
        }

        if ($request->hasFile('voucher_scan2')) {
            $voucher_scan2 = $request->file('voucher_scan2');
            $name = $voucher_scan2->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $voucher_scan2->getClientOriginalExtension();
            $voucher_file_name2 = $name . time() . '.' . $ext;
            $voucher_scan2->storeAs('public/upload/documents2', $voucher_file_name2);
        }
        //Update date formate
        $update_date_format = $this->dateFormat($request->date);

        //purchase expense entry
        $sale_no = $this->sale_no();
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
        $sale->narration = $request->narration;
        $sale->gst_subtotal = 0;
        $sale->paid_amount = $request->pay_mode == 'Credit' ?  0 : $sale->total_amount;
        $sale->due_amount = $request->pay_mode == 'Credit' ?  $sale->total_amount : 0;
        if ($request->hasFile('voucher_scan')) {
            $sale->voucher_scan = $voucher_file_name;
        }
        if ($request->hasFile('voucher_scan2')) {
            $sale->voucher_scan2 = $voucher_file_name2;
        }
        $sale->save();
        //end purchase expense entry

        //journal entry
        $journal_no = $this->journal_no();
        $journal = new JournalTemp();
        $journal->project_id        = $sale->project_id;
        $journal->invoice_id        = $sale->id;
        $journal->transection_type = 'Sale';
        $journal->transaction_type = 'Increase';
        $journal->journal_no        = $journal_no;
        $journal->date              = $sale->date;
        $journal->pay_mode          = $sale->pay_mode;
        $journal->cost_center_id    = 0;
        $journal->party_info_id     = $sale->party_id;
        $journal->account_head_id   = 0;
        $journal->amount            = $sale->total_amount;
        $journal->tax_rate          = 0;
        $journal->vat_amount        = $sale->vat;
        $journal->total_amount      = $sale->amount;
        $journal->gst_subtotal = 0;
        $journal->narration         =  $sale->narration;
        $journal->created_by        = Auth::id();
        $journal->voucher_scan  = $sale->voucher_scan;
        $journal->voucher_scan2  = $sale->voucher_scan2;
        $journal->save();
        //end journal entry

        //income/revinue entry
        $income_head = AccountHead::find(7);
        $jl_record = new JournalRecordsTemp();
        $jl_record->journal_temp_id     = $journal->id;
        $jl_record->project_details_id  = 1;
        $jl_record->cost_center_id      = 0;
        $jl_record->party_info_id       = $sale->party_id;
        $jl_record->journal_no          = $journal_no;
        $jl_record->account_head_id     = $income_head->id;
        $jl_record->master_account_id   = $income_head->master_account_id;
        $jl_record->account_head        = $income_head->fld_ac_head;
        $jl_record->amount              = $sale->amount;
        $jl_record->total_amount        = $sale->amount;
        $jl_record->vat_rate_id         = 0;
        $jl_record->transaction_type    = 'CR';
        $jl_record->journal_date        = $update_date_format;
        $jl_record->account_type_id = $income_head->account_type_id;
        $jl_record->is_main_head        = 0;
        $jl_record->save();

        //vat
        if ($sale->vat > 0) {
            $vat_head = AccountHead::find(17);
            $jl_record = new JournalRecordsTemp();
            $jl_record->journal_temp_id     = $journal->id;
            $jl_record->project_details_id  = 1;
            $jl_record->cost_center_id      = 0;
            $jl_record->party_info_id       = $sale->party_id;
            $jl_record->journal_no          = $journal_no;
            $jl_record->account_head_id     = $vat_head->id;
            $jl_record->master_account_id   = $vat_head->master_account_id;
            $jl_record->account_head        = $vat_head->fld_ac_head;
            $jl_record->amount              = $sale->vat;
            $jl_record->total_amount        = $sale->vat;
            $jl_record->vat_rate_id         = 0;
            $jl_record->transaction_type    = 'CR';
            $jl_record->journal_date        = $update_date_format;
            $jl_record->account_type_id = $vat_head->account_type_id;
            $jl_record->is_main_head        = 0;
            $jl_record->save();
        }
        //end income/revinue entry

        //payment record
        $ac_head = AccountHead::find(3); // accounts payable
        $jl_record = new JournalRecordsTemp();
        $jl_record->journal_temp_id     = $journal->id;
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
        //endpayment record

        if($request->pay_mode == 'Cash' || $request->pay_mode == 'Card' )
        {

            $total_vat = 0;
            $total_amount_withvat = 0;
            $total_amount = 0;
            $cost_center_id = 0;
            if ($request->cost_center_name != null) {
                $cost_center_id = $request->cost_center_name;
            }

            $payment = new Receipt();
            $payment->job_project_id = $request->project_id;
            $payment->date = $update_date_format;
            $payment->pay_mode =  $request->pay_mode;
            $payment->receipt_no = $sale->total_amount;
            $payment->head_id = 0;
            $payment->total_amount = $sale->total_amount;
            $payment->vat = 0;
            $payment->party_id =  $request->party_info;
            $payment->narration = $request->narration;
            $payment->status = 'Realised';
            $payment->paid_amount = $sale->total_amount;
            $payment->due_amount = 0;
            $payment->save();



        $pay_head = $request->pay_mode == 'Cash' ? 1 : 2 ;
        $ac_head = AccountHead::find($pay_head);
        //COGS Journal
        $journal_no = $this->journal_no();
        $journal = new JournalTemp();
        $journal->project_id        = $sale->project_id;
        $journal->invoice_id        = $sale->id;
        $journal->transection_type = 'COGS ENTRY';
        $journal->transaction_type = 'Increase';
        $journal->journal_no        = $journal_no;
        $journal->date              = $sale->date;
        $journal->pay_mode          = $sale->pay_mode;
        $journal->cost_center_id    = 0;
        $journal->party_info_id     = $sale->party_id;
        $journal->account_head_id   = 0;
        $journal->amount            = 0;
        $journal->tax_rate          = 0;
        $journal->vat_amount        = 0;
        $journal->total_amount      = 0;
        $journal->gst_subtotal = 0;
        $journal->narration         =  $sale->narration;
        $journal->created_by        = Auth::id();
        $journal->voucher_scan  = $sale->voucher_scan;
        $journal->voucher_scan2  = $sale->voucher_scan2;
        $journal->save();
        }



        $multi_head = $request->input('group-a');
        $t_cogs = 0;
        foreach ($multi_head as $each_head) {
            // $ac_head = AccountHead::find($each_head['multi_acc_head']);
            $type = 'CR';
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
        return view('backend.sale.preview', compact('sale'));
    }

    public function sale_list()
    {
        $parties = PartyInfo::get();
        $sales = Sale::get();
        $i = 0;
        return view('backend.sale.list', compact('sales', 'i', 'parties'));
    }

    public function sale_modal(Request $request)
    {
        $sale = Sale::find($request->id);
        return view('backend.sale.preview', compact('sale'));
    }

    public function search_sale(Request $request)
    {
        $sales = Sale::where('invoice_no', 'like', "%{$request->value}%")->get();
        if ($request->party != '') {
            $sales = $sales->where('party_id', $request->party);
        }
        if ($request->date != '') {
            $date = $this->dateFormat($request->date);
            $sales = $sales->where('date', $date);
        }
        return view('backend.sale.search-sale', compact('sales'));
    }

    public function receipt_voucher2()
    {
        $sales = Sale::where('due_amount', '>', 0)->get();
        $parties = PartyInfo::get();
        $i = 0;
        $modes = PayMode::whereNotIn('id', [2])->get();
        $invoices = JobProject::where('is_invoice',1)->latest()->paginate(20);

        return view('backend.sale.receipt-voucher', compact('sales', 'i', 'parties', 'modes','invoices'));
    }
    public function partyInfosale2(Request $request)
    {
        // return $request->all();
        // return 1;
        $info = PartyInfo::where('id', $request->value)->first();
        $sales = Sale::where('due_amount', '>', 0)->where('party_id', $info->id)->get();
        if ($request->ajax()) {
            return Response()->json([
                'page' => view('backend.sale.receipt-invoice', ['sales' => $sales, 'i' => 1])->render(),
                'info' => $info,

            ]);
        }
    }

    public function payment_post(Request $request)
    {
        // return $request->all();
        $update_date_format = $this->dateFormat($request->date);
        $sub_invoice = Carbon::now()->format('Ymd');
        $job_project=JobProject::find( $request->project_id);
        $let_purch_exp = Receipt::whereDate('created_at', Carbon::today())->where('receipt_no', 'LIKE', "%{$sub_invoice}%")->latest('id')->first();
        if ($let_purch_exp) {
            $purch_no = $let_purch_exp->receipt_no + 1;
        } else {
            $purch_no = Carbon::now()->format('Ymd') . '001';
        }

        if ($request->pay_mode == "Cheque") {
            $deposit_date=$this->dateFormat($request->deposit_date);
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
            $payment->due_amount = $request->due_amount-$request->pay_amount;
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
            $payment->job_project_id = $request->project_id;
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
            $payment->due_amount = $request->due_amount-$request->pay_amount;
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
            $journal->amount            =$payment->total_amount;
            $journal->tax_rate          = 0;
            $journal->vat_amount        = 0;
            $journal->total_amount      =$payment->total_amount;
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


        $sale = JobProjectInvoice::where('due_amount', '>', 0)->where('job_project_id', $payment->job_project_id)->orderBy('date', 'asc')->first();
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
                    $sale = JobProjectInvoice::where('due_amount', '>', 0)->where('job_project_id', $payment->job_project_id)->orderBy('date', 'asc')->first();
                    if (!$sale) {
                        $advance=$pay_amount;
                        $pay_amount = 0;
                    }
                }
            }


        $recept = $payment;
        return view('backend.sale.receipt-preview', compact('recept'));
    }

    public function receipt_voucher_list_show()
    {
        $sales = Sale::where('due_amount', '>', 0)->get();
        $receipt_list = Receipt::orderBy('date','desc')->paginate(40);
        $parties = PartyInfo::get();
        $i = 0;
        $modes = PayMode::all();

        return view('backend.sale.receipt-list', compact('sales', 'i', 'parties', 'modes', 'receipt_list'));
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
        if ($request->mode != '')
        {
            $receipt_list = $receipt_list->where('pay_mode', $request->mode);
        }
        $i=0;
        return view('backend.sale.search-receipt', compact('receipt_list','i'));
    }


    public function find_job_project(Request $request)
    {
        $proj = JobProject::find($request->value);
        $party=PartyInfo::find($proj->customer_id);
        $due=$proj->invoicess->where('due_amount','>',0)->sum('due_amount');
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
        $payment=Receipt::find($id);
        $payment->status="Declined";
        $payment->save();
        $notification = array(
            'message'       => 'Declined!',
            'alert-type'    => 'warning'
        );
        return redirect()->back()->with($notification);

    }

    public function receipt_realised($id)
    {
        $receipt=Receipt::find($id);
        if($receipt->status=='Realised')
        {
            $notification = array(
                'message'       => 'Already Realised!',
                'alert-type'    => 'warning'
            );
            return redirect()->back()->with($notification);
        }
        $receipt->status="Realised";
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
        $jl_record->cost_center_id      = $journal->cost_center_id ;
        $jl_record->party_info_id       = $journal->party_info_id  ;
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
        $jl_record->cost_center_id      = $journal->cost_center_id ;
        $jl_record->party_info_id       = $journal->party_info_id  ;
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
        $receipt=Receipt::find($id);
        // dd($request->all());
        $receipt->deposit_date=$this->dateFormat($request->deposit_date);
        $receipt->save();
        $notification = array(
            'message'       => 'Success!',
            'alert-type'    => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
