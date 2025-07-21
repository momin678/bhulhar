<?php

namespace App\Http\Controllers\backend;

use App\Document;
use App\DocumentTemp;
use App\Http\Controllers\Controller;
use App\JobProject;
use App\Journal;
use App\JournalRecordsTemp;
use App\JournalTemp;
use App\Models\AccountHead;
use App\Models\CostCenter;
use App\PartyInfo;
use App\Payment;
use App\PaymentInvoice;
use App\PayMode;
use App\PayTerm;
use App\ProjectDetail;
use App\PurchaseExpense;
use App\PurchaseExpenseItem;
use App\Receipt;
use App\ReceiptSale;
use App\Sale;
use App\SaleItem;
use App\TxnType;
use App\VatRate;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\JournalRecord;
use App\PaidFromList;
use App\Models\InvoiceNumber;
use App\PurchaseExpenseItemTemp;
use App\PurchaseExpenseTemp;
use App\AddBillNumber;
use App\Stock;
use App\Truck;
use App\SupplierInvoice;
use DB;
use App\Models\MasterAccount;
use App\Models\Payroll\Employee;
use Illuminate\Support\Facades\DB as FacadesDB;

class purchaseExpenseController extends Controller
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
        $latest_journal_no = Journal::withTrashed()->whereDate('created_at', Carbon::today())->where('journal_no', 'LIKE', "%{$sub_invoice}%")->orderBy('id','DESC')->first();
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
    private function purchase_expense_no()
    {
        $sub_invoice = Carbon::now()->format('Ymd');
        // return $sub_invoice;
        $let_purch_exp = InvoiceNumber::where('purchase_no', 'LIKE', "%{$sub_invoice}%")->first();
        if ($let_purch_exp) {
            $purch_no = preg_replace('/^P-/', '', $let_purch_exp->purchase_no);
            $purch_code = $purch_no + 1;
            $purch_no="P-" . $purch_code;
        } else {
            $purch_no = "P-" .Carbon::now()->format('Ymd') . '001';
        }
        return $purch_no;
    }

    private function temp_purchase_expense_no()
    {
        $sub_invoice = Carbon::now()->format('Y');
        // return $sub_invoice;
        $let_purch_exp = InvoiceNumber::where('purchase_no', 'LIKE', "%{$sub_invoice}%")->first();
        if ($let_purch_exp) {
            $purch_no = preg_replace('/^P-/', '', $let_purch_exp->purchase_no);
            $purch_code = $purch_no + 1;
            $purch_no="P-" . $purch_code;
        } else {
            $purch_no = "P-" .Carbon::now()->format('Y') . '0001';
        }
        return $purch_no;
    }
    private function payment_no()
    {
        $sub_invoice = Carbon::now()->format('Ymd');
        $let_purch_exp = Payment::whereDate('created_at', Carbon::today())->where('payment_no', 'LIKE', "%{$sub_invoice}%")->latest('id')->first();
        if ($let_purch_exp) {
            $purch_code = substr($let_purch_exp->payment_no,3);
            // dd($purch_code);
            $purch_code = $purch_code + 1;
            $payment_no = "PV-".$purch_code;
        } else {
            $payment_no = "PV-".Carbon::now()->format('Ymd') . '001';
        }
        return $payment_no;
    }
    public function purchase_expense(Request $records)
    {
        $modes = PayMode::whereIn('title',['Cash','Credit','Bank', 'Card', 'Petty Cash'])->get();
        $vats = VatRate::get();
        $account_heads = AccountHead::whereIn('master_account_id',[4,3])->get();
        $invoices = [];

        $clients = PartyInfo::whereIn('pi_type',['Supplier'])->get();
        $suppliers = PartyInfo::where('pi_type','Supplier')->get();
        $projects=ProjectDetail::all();
        $cost_center = Truck::all();
        $paid_from_lists =[];

        return view('backend.purchase-expense.purchase-expense', compact('account_heads','vats','modes','suppliers','clients','projects','cost_center', 'paid_from_lists'));
    }

    public function purchase_expense_bill(Request $records)
    {

        $modes = PayMode::whereIn('title',['Cash','Credit','Bank', 'Card', 'Petty Cash'])->get();
        $vats = VatRate::get();
        $account_heads = AccountHead::whereIn('master_account_id',[4,3])->get();
        $invoices = [];

        $clients = PartyInfo::whereIn('pi_type',['Supplier'])->get();
        $suppliers = PartyInfo::where('pi_type','Supplier')->get();
        $projects=ProjectDetail::all();
        $cost_center = Truck::all();
        $paid_from_lists =[];

        $masterAcc = MasterAccount::whereIn('id',[4,3])->get();
        $countries= DB::table('countries')->get();
        $parties= PartyInfo::where('pi_type','Supplier')->orWhere('pi_type','Third Party')->orWhere('pi_type','Owner')->get();
        $drivers = Employee::where('division', 3)->get();

        return view('backend.purchase-expense.purchase-expense-bill', compact('account_heads','vats','modes','suppliers','clients','projects','cost_center', 'paid_from_lists', 'masterAcc', 'drivers','parties','countries'));
    }


    public function purchase_expense_office(Request $records)
    {

        $modes = PayMode::whereIn('title',['Cash','Credit','Bank', 'Card', 'Petty Cash'])->get();
        $vats = VatRate::get();
        $account_heads = AccountHead::whereIn('master_account_id',[4,3])->get();
        $invoices = [];

        $clients = PartyInfo::whereIn('pi_type',['Supplier'])->get();
        $suppliers = PartyInfo::where('pi_type','Supplier')->get();
        $projects=ProjectDetail::all();
        $cost_center = Truck::all();
        $paid_from_lists =[];

        return view('backend.purchase-expense.purchase-expense-office', compact('account_heads','vats','modes','suppliers','clients','projects','cost_center', 'paid_from_lists'));
    }


    public function check_invoice_no(Request $request){
        $PurchaseExpenseTemp = PurchaseExpenseTemp::where('client_id', $request->client)
        ->where('invoice_no', $request->invoice)
        ->exists();
        $PurchaseExpense = PurchaseExpense::where('client_id', $request->client)
        ->where('invoice_no', $request->invoice)
        ->exists();


        if($PurchaseExpenseTemp || $PurchaseExpense){
            return true;

        }
        return false;
    }


    public function expensepost(Request $request)
    {
        $request->validate(
            [
                'date'              =>  'required',
                'pay_mode'          => 'required',
                'narration'         => 'required'
            ],
            [
                'date.required'         => 'Date is required',
                'pay_mode.required'     => 'Pay Mode is required',
                'narration.required'    => 'Narration is required',
            ]
        );
        //Update date formate
        $update_date_format = $this->dateFormat($request->date);

        //file
        //purchase expense entry
        $purch_no = $this->temp_purchase_expense_no();
        // dd($purch_no);
        $purch_ex = new PurchaseExpenseTemp();
        $purch_ex->date = $update_date_format;
        $purch_ex->pay_mode =  $request->pay_mode;
        $purch_ex->purchase_no = $purch_no;
        $purch_ex->head_id = 0;
        $purch_ex->total_amount = $request->total_amount;
        $purch_ex->vat = $request->total_vat;
        $purch_ex->amount = $request->taxable_amount;
        $purch_ex->narration = $request->narration;
        $purch_ex->client_id = $request->client_info;
        $purch_ex->invoice_type =  $request->expense_type;
        $purch_ex->invoice_no = $request->invoice_no;
        $purch_ex->gst_subtotal = 0;
        $purch_ex->created_by = Auth::id();
        $purch_ex->authorized_by = Auth::id();
        $purch_ex->authorized = 1;
        $purch_ex->paid_amount = $request->pay_mode == 'Credit' ?  0 : $purch_ex->total_amount;
        $purch_ex->due_amount = $request->pay_mode == 'Credit' ?  $purch_ex->total_amount : 0;
        if ($request->pay_mode == 'Cheque') {
            $purch_ex->issuing_bank = $request->issuing_bank;
            $purch_ex->bank_branch = $request->bank_branch;
            $purch_ex->cheque_no =  $request->cheque_no;
            $purch_ex->deposit_date = $this->dateFormat($request->deposit_date);
        }
        $purch_ex->save();
        //end purchase expense entry
        $purchase_number = InvoiceNumber::find(1);
        $purchase_number->purchase_no = $purch_ex->purchase_no;
        $purchase_number->save();
        //records entry
        $multi_head = $request->input('inputs');
        foreach ($multi_head as $each_head) {
            //purchase record
            $purc_exp_itm = new PurchaseExpenseItemTemp();
            $purc_exp_itm->head_id = $each_head['description'];
            if(isset($each_head['cost_center'])){
                $purc_exp_itm->cost_center = $each_head['cost_center']? $each_head['cost_center']: null;
            }
            // $purc_exp_itm->bill_no = $each_head['bill_no'];
            $purc_exp_itm->amount = $each_head['taxable'];
            $purc_exp_itm->vat = $each_head['vat_amount'];
            $purc_exp_itm->rate = $each_head['amount'];
            $purc_exp_itm->qty = $each_head['qty'];

            $purc_exp_itm->total_amount = $each_head['sub_gross_amount'];
            $purc_exp_itm->due_amount =  $request->pay_mode == 'Credit' ?  $each_head['sub_gross_amount'] : 0;
            $purc_exp_itm->party_id = $purch_ex->client_id;
            $purc_exp_itm->purchase_expense_id = $purch_ex->id;
            $purc_exp_itm->date = $purch_ex->date;
            $purc_exp_itm->gst_subtotal = 0;
            $purc_exp_itm->save();
            //end purchase record
        }
        if($request->hasFile('files')){
            $files = $request->file('files');
            foreach($files as $file){
                $document = new DocumentTemp();
                $ext= $file->getClientOriginalExtension();
                $name = hexdec(uniqid()).time().'.'.$ext;
                $file->storeAs('public/upload/documents', $name);
                $document->purchase_id = $purch_ex->id;
                $document->extension = $ext;
                $document->file_path = '/storage/upload/documents/'.$name;
                $document->save();
            }
        }
        //end records entry

        $purchase_exp = PurchaseExpenseTemp::with('documents')->where('id',$purch_ex->id)->first();
        $items= PurchaseExpenseItemTemp::where('purchase_expense_id',$purch_ex->id)->get();
        $new=0;
        return view('backend.purchase-expense.authorize-preview', compact('purchase_exp','new','items'));
    }


    public function expensepost_bill(Request $request)
    {
        $request->validate(
            [
                'date'              =>  'required',
                'pay_mode'          => 'required',
                'narration'         => 'required'
            ],
            [
                'date.required'         => 'Date is required',
                'pay_mode.required'     => 'Pay Mode is required',
                'narration.required'    => 'Narration is required',
            ]
        );
        //Update date formate
        $update_date_format = $this->dateFormat($request->date);

        //file
        //purchase expense entry
        $purch_no = $this->temp_purchase_expense_no();
        // dd($purch_no);
        $purch_ex = new PurchaseExpenseTemp();
        $purch_ex->date = $update_date_format;
        $purch_ex->pay_mode =  $request->pay_mode;
        $purch_ex->purchase_no = $purch_no;
        $purch_ex->head_id = 0;
        $purch_ex->total_amount = $request->total_amount;
        $purch_ex->vat = $request->total_vat;
        $purch_ex->invoice_type =  'bill';
        $purch_ex->amount = $request->taxable_amount;
        $purch_ex->narration = $request->narration;
        $purch_ex->client_id = $request->client_info;
        // $purch_ex->party_id =  $request->party_info;
        $purch_ex->invoice_no = $request->invoice_no;
        $purch_ex->gst_subtotal = 0;
        $purch_ex->created_by = Auth::id();
        $purch_ex->authorized_by = Auth::id();
        $purch_ex->authorized = 1;
        $purch_ex->paid_amount = $request->pay_mode == 'Credit' ?  0 : $purch_ex->total_amount;
        $purch_ex->due_amount = $request->pay_mode == 'Credit' ?  $purch_ex->total_amount : 0;
        if ($request->pay_mode == 'Cheque') {
            $purch_ex->issuing_bank = $request->issuing_bank;
            $purch_ex->bank_branch = $request->bank_branch;
            $purch_ex->cheque_no =  $request->cheque_no;
            $purch_ex->deposit_date = $this->dateFormat($request->deposit_date);
        }
        $purch_ex->save();
        //end purchase expense entry
        $purchase_number = InvoiceNumber::find(1);
        $purchase_number->purchase_no = $purch_ex->purchase_no;
        $purchase_number->save();
        //records entry
        $multi_head = $request->input('inputs');
        foreach ($multi_head as $each_head) {
            //purchase record
            $purc_exp_itm = new PurchaseExpenseItemTemp();
            $purc_exp_itm->head_id = $each_head['description'];
            $purc_exp_itm->cost_center = $each_head['cost_center']? $each_head['cost_center']: null;
            // $purc_exp_itm->bill_no = $each_head['bill_no'];
            $purc_exp_itm->amount = $each_head['taxable'];
            $purc_exp_itm->vat = $each_head['vat_amount'];
            $purc_exp_itm->rate = $each_head['amount'];
            $purc_exp_itm->qty = $each_head['qty'];

            $purc_exp_itm->total_amount = $each_head['sub_gross_amount'];
            $purc_exp_itm->due_amount =  $request->pay_mode == 'Credit' ?  $each_head['sub_gross_amount'] : 0;
            $purc_exp_itm->party_id = $purch_ex->client_id;
            $purc_exp_itm->purchase_expense_id = $purch_ex->id;
            $purc_exp_itm->date = $purch_ex->date;
            $purc_exp_itm->gst_subtotal = 0;
            $purc_exp_itm->save();
            //end purchase record
        }
        if($request->hasFile('files')){
            $files = $request->file('files');
            foreach($files as $file){
                $document = new DocumentTemp();
                $ext= $file->getClientOriginalExtension();
                $name = hexdec(uniqid()).time().'.'.$ext;
                $file->storeAs('public/upload/documents', $name);
                $document->purchase_id = $purch_ex->id;
                $document->extension = $ext;
                $document->file_path = '/storage/upload/documents/'.$name;
                $document->save();
            }
        }
        //end records entry

        $purchase_exp = PurchaseExpenseTemp::with('documents')->where('id',$purch_ex->id)->first();
        $items= PurchaseExpenseItemTemp::where('purchase_expense_id',$purch_ex->id)->get();
        $new=0;
        return view('backend.purchase-expense.authorize-preview-bill', compact('purchase_exp','new','items'));
    }

    public function purchase_expense_list(Request $request)
    {
        $expenses_list = FacadesDB::table('purchase_expenses')
        ->join('party_infos', 'party_infos.id', '=', 'purchase_expenses.client_id');
        if($request->client_id){
            $expenses_list = $expenses_list->where('client_id', $request->client_id);
        }
        if($request->from_date && $request->to_date){
            $from_date = $this->dateFormat($request->from_date);
            $to_date = $this->dateFormat($request->to_date);
            $expenses_list = $expenses_list->whereBetween('date', [$from_date,$to_date]);
        }
        $expenses_list = $expenses_list->select(['client_id',  'date','party_infos.pi_name as name'])
        ->groupBy(['client_id', 'date','name'])
        ->orderBy('date', 'desc')
        ->get();
        // dd($expenses_list);
        $i = 0;
        $clients = PartyInfo::whereIn('pi_type', ['Supplier'])->get();
        $cost_center = Truck::all();
        $account_heads = AccountHead::where('account_type_id',4)->get();
        $account_head_id = $request->account_head_id;
        $cost_center_id = $request->cost_center_id;
        $modes = PayMode::whereIn('title',['Cash','Credit','Bank', 'Card'])->get();
        $paid_from_lists =[];
        $pay_mode = $request->pay_mode;
        $paid_from_id = $request->paid_from;
        // dd($paid_from);

        return view('backend.purchase-expense.list', compact('i', 'clients', 'expenses_list', 'cost_center', 'account_heads', 'account_head_id', 'cost_center_id','modes', 'pay_mode', 'paid_from_lists', 'paid_from_id'));
        // for tax invoice
        // $excel_expenses = PurchaseExpense::whereBetween('date', ['2025-03-01', '2025-05-31'])->orderBy('date', 'asc')->get();
        // return view('backend.purchase-expense.excel-tax-file', compact('i', 'clients', 'excel_expenses', 'cost_center', 'account_heads', 'account_head_id', 'cost_center_id','modes', 'pay_mode', 'paid_from_lists', 'paid_from_id'));
    }



    public function bill_list(Request $request)
    {
        $expenses_list = FacadesDB::table('purchase_expenses')
        ->join('party_infos', 'party_infos.id', '=', 'purchase_expenses.client_id')
        ->where('purchase_expenses.invoice_type','=','bill');
        if($request->client_id){
            $expenses_list = $expenses_list->where('client_id', $request->client_id);
        }
        if($request->from_date && $request->to_date){
            $from_date = $this->dateFormat($request->from_date);
            $to_date = $this->dateFormat($request->to_date);
            $expenses_list = $expenses_list->whereBetween('date', [$from_date,$to_date]);
        }
        $expenses_list = $expenses_list->select(['client_id',  'date','party_infos.pi_name as name'])
        ->groupBy(['client_id', 'date','name'])
        ->orderBy('date', 'desc')
        ->get();
        // dd($expenses_list);
        $i = 0;
        $clients = PartyInfo::whereIn('pi_type', ['Supplier'])->get();
        $cost_center = Truck::all();
        $account_heads = AccountHead::where('account_type_id',4)->get();
        $account_head_id = $request->account_head_id;
        $cost_center_id = $request->cost_center_id;
        $modes = PayMode::whereIn('title',['Cash','Credit','Bank', 'Card'])->get();
        $paid_from_lists =[];
        $pay_mode = $request->pay_mode;
        $paid_from_id = $request->paid_from;
        // dd($paid_from);

        return view('backend.purchase-expense.bill-list', compact('i', 'clients', 'expenses_list', 'cost_center', 'account_heads', 'account_head_id', 'cost_center_id','modes', 'pay_mode', 'paid_from_lists', 'paid_from_id'));
    }


    public function garage_list(Request $request,$type)
    {

        $expenses_list = FacadesDB::table('purchase_expenses')
        ->join('party_infos', 'party_infos.id', '=', 'purchase_expenses.client_id')
        ->where('purchase_expenses.invoice_type','=',$type);
        if($request->client_id){
            $expenses_list = $expenses_list->where('client_id', $request->client_id);
        }
        if($request->from_date && $request->to_date){
            $from_date = $this->dateFormat($request->from_date);
            $to_date = $this->dateFormat($request->to_date);
            $expenses_list = $expenses_list->whereBetween('date', [$from_date,$to_date]);
        }
        $expenses_list = $expenses_list->select(['client_id',  'date','party_infos.pi_name as name'])
        ->groupBy(['client_id', 'date','name'])
        ->orderBy('date', 'desc')
        ->get();
        // dd($expenses_list);
        $i = 0;
        $clients = PartyInfo::whereIn('pi_type', ['Supplier'])->get();
        $cost_center = Truck::all();
        $account_heads = AccountHead::where('account_type_id',4)->get();
        $account_head_id = $request->account_head_id;
        $cost_center_id = $request->cost_center_id;
        $modes = PayMode::whereIn('title',['Cash','Credit','Bank', 'Card'])->get();
        $paid_from_lists =[];
        $pay_mode = $request->pay_mode;
        $paid_from_id = $request->paid_from;
        // dd($paid_from);

        return view('backend.purchase-expense.garage-list', compact( 'type','i', 'clients', 'expenses_list', 'cost_center', 'account_heads', 'account_head_id', 'cost_center_id','modes', 'pay_mode', 'paid_from_lists', 'paid_from_id'));
    }



    public function payment_voucher2_list()
    {
        $payments = Payment::orderBy('id', 'desc')->get();
        $i = 0;
        return view('backend.purchase-expense.payments', compact('payments', 'i'));
    }

    public function purch_exp_modal(Request $request)
    {
        $purchase_exp = PurchaseExpense::find($request->id);
        return view('backend.purchase-expense.preview', compact('purchase_exp'));
    }

    public function auth_purch_exp_modal(Request $request)
    {
        $purchase_exp = PurchaseExpenseTemp::find($request->id);
        $items=PurchaseExpenseItemTemp::where('purchase_expense_id',$purchase_exp->id)->get();
        return view('backend.purchase-expense.authorize-preview', compact('purchase_exp','items'));
    }

    public function approve_purch_exp_modal(Request $request)
    {
        $purchase_exp = PurchaseExpenseTemp::find($request->id);
        return view('backend.purchase-expense.approve-preview', compact('purchase_exp'));
    }


    public function payment_modal(Request $request)
    {
        $payment = Payment::find($request->id);
        return view('backend.purchase-expense.payment-preview', compact('payment'));
    }

    public function payment_voucher2()
    {
        $expenses = PurchaseExpense::where('due_amount', '>', 0)->get();
        $parties = PartyInfo::where('pi_type','Supplier')->get();
        $i = 0;
        $modes = PayMode::whereNotIn('id', [2,6])->get();

        return view('backend.purchase-expense.payment-voucher', compact('expenses', 'i', 'parties', 'modes'));
    }
    public function add_bill_number(Request $request){
        $exit_bill = AddBillNumber::where('bill_id', $request->bill_no)->first();
        if(!$exit_bill){
            $add = new AddBillNumber;
            $add->cost_center_id = $request->cost_center_id;
            $add->bill_id = $request->bill_no;
            $add->save();
        }
        $add_lists = AddBillNumber::where('cost_center_id', $request->cost_center_id)->get();
        return view('backend.purchase-expense.add-bill-number', compact('add_lists'));
    }
    public function partyInfoInvoice2(Request $request)
    {
        $info = PartyInfo::where('id', $request->value)->first();
        $expenses = PurchaseExpense::where('due_amount', '>', 0)->where('party_id', $info->id)->get();
        $service_expense = SupplierInvoice::where('due_amount', '>', 0)->where('supplier_id', $info->id)->get();
        // dd($service_expense);
        $due_amount = $expenses->sum('due_amount')+$service_expense->sum('due_amount');
        if ($request->ajax()) {
            return Response()->json([
                'page' => view('backend.purchase-expense.receipt-invoice', ['expenses' => $expenses, 'i' => 1, 'service_expense'=>$service_expense])->render(),
                'info' => $info,
                'due_amount' => $due_amount
            ]);
        }
    }

    public function findinvoiceRec(Request $request)
    {
        $purchase = PurchaseExpense::find($request->value);
        return $purchase;
    }

    public function invoice_no_validation(Request $request)
    {
        // return 1;
        // return $request->all();
        if($request->party==null){
            return Response()->json([
                'error' => 'Please Select Party First!',
            ]);
        }
        $check = PurchaseExpense::where('party_id', $request->party)->where('invoice_no', $request->inv)->first();
        if ($check) {
            return Response()->json([
                'warning' => $request->inv . ' Invoice No Already Exist!',
            ]);
        }
        else
        {
            $check = PurchaseExpenseTemp::where('party_id', $request->party)->where('invoice_no', $request->inv)->first();
        if ($check) {
            return Response()->json([
                'warning' => $request->inv . ' Invoice No Already Exist Temporarily!',
            ]);
        }

        }
    }



    public function receipt_post(Request $request)
    {
        // return $request->all();
        $update_date_format = $this->dateFormat($request->date);
        $sub_invoice = Carbon::now()->format('Ymd');
        $let_purch_exp = Payment::whereDate('created_at', Carbon::today())->where('payment_no', 'LIKE', "%{$sub_invoice}%")->latest('id')->first();
        if ($let_purch_exp) {
            $purch_no = $let_purch_exp->payment_no + 1;
        } else {
            $purch_no = Carbon::now()->format('Ymd') . '001';
        }

        if ($request->pay_mode == "Cheque") {
            $deposit_date = $this->dateFormat($request->deposit_date);
            $payment = new Payment();
            $payment->date = $update_date_format;
            $payment->pay_mode =  $request->pay_mode;
            $payment->payment_no = $purch_no;
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
            $payment->deposit_date = $deposit_date;
            $payment->status = 'Pending';
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

            $payment = new Payment();
            $payment->date = $update_date_format;
            $payment->pay_mode =  $request->pay_mode;
            $payment->payment_no = $purch_no;
            $payment->head_id = 0;
            $payment->total_amount = $request->pay_amount;
            $payment->vat = 0;
            $payment->party_id =  $request->party_info;
            $payment->narration = $request->narration;
            $payment->paid_amount = 0;
            $payment->due_amount = 0;
            $payment->status = 'Realised';

            $payment->save();

            $journal = new Journal();
            $journal->project_id        = 1;
            $journal->transection_type        = 'PAYMENT VOUCHER';
            $journal->transaction_type        = 'CREDIT';
            $journal->payment_id        = $payment->id;
            $journal->journal_no        = $journal_no;
            $journal->date              = $update_date_format;
            $journal->pay_mode          = $request->pay_mode;
            $journal->voucher_type          = 'CREDIT';
            $journal->invoice_no        = 0;
            $journal->cost_center_id    = $cost_center_id;
            $journal->party_info_id     = $request->party_info;
            $journal->account_head_id   = 123;
            $journal->amount            = $request->pay_amount;
            $journal->tax_rate          = 0;
            $journal->vat_amount        = 0;
            $journal->total_amount      = $request->pay_amount;
            $journal->narration         = $request->narration;
            $journal->created_by        = Auth::id();
            $journal->authorized_by = Auth::id();
            $journal->approved_by    = Auth::id();
            $journal->save();

            $income_head = AccountHead::find(5);
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
            $jl_record->transaction_type    = 'DR';
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
            $jl_record->transaction_type    = 'CR';
            $jl_record->journal_date        = $update_date_format;
            $jl_record->account_type_id = $pay_head->account_type_id;
            $jl_record->is_main_head        = 0;
            $jl_record->save();
            $type = '';
            $all_invoicess = '';
        }

        $purchase = PurchaseExpense::where('due_amount', '>', 0)->where('party_id', $request->party_info)->orderBy('date', 'asc')->first();
        $advance = 0;
        if ($purchase) {
            $pay_amount = $request->pay_amount;
            while ($pay_amount > 0) {
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
                $purc_exp_itm = new PaymentInvoice();
                $purc_exp_itm->sale_id = $purchase->id;
                $purc_exp_itm->payment_id = $payment->id;
                $purc_exp_itm->Total_amount = $amount;
                $purc_exp_itm->vat = 0;
                $purc_exp_itm->amount = $amount;
                $purc_exp_itm->party_id = $request->party_info;
                $purc_exp_itm->save();
                $purchase = PurchaseExpense::where('due_amount', '>', 0)->where('party_id', $request->party_info)->orderBy('date', 'asc')->first();
                if (!$purchase) {
                    $advance = $pay_amount;
                    $pay_amount = 0;
                }
            }
        }

        $payment->due_amount = PurchaseExpense::where('due_amount', '>', 0)->where('party_id', $request->party_info)->sum('due_amount');
        $payment->advance = $advance;
        $payment->save();

        return view('backend.purchase-expense.payment-preview', compact('payment'));
    }


    public function receipt_voucher2()
    {
        $sales = Sale::where('due_amount', '>', 0)->get();
        $parties = PartyInfo::get();
        $i = 0;
        $modes = PayMode::whereIn('id', [1, 3])->get();

        return view('backend.sale.receipt-voucher', compact('sales', 'i', 'parties', 'modes'));
    }




    public function findsaleRec(Request $request)
    {
        $sale = Sale::find($request->value);
        return $sale;
    }
    public function purchase_expense_invoice()
    {
        $parties = PartyInfo::get();
        $invoicess = PurchaseExpenseItem::leftjoin('purchase_expenses', 'purchase_expense_items.purchase_expense_id', '=', 'purchase_expenses.id')
            ->orderBy('purchase_expenses.date', 'DESC')
            ->select('purchase_expense_items.*')
            ->paginate(30);
        return view('backend.purchase-expense.invoice', compact('invoicess', 'parties'));
    }

    public function find_invoice(Request $request)
    {
        if ($request->id != null && $request->invoice_no != null) {
            $invoicess = PurchaseExpenseItem::leftjoin('purchase_expenses', 'purchase_expense_items.purchase_expense_id', '=', 'purchase_expenses.id')
                ->where('purchase_expense_items.invoice_no', 'like', "%{$request->invoice_no}%")
                ->where('purchase_expenses.party_id', $request->id)
                ->orderBy('purchase_expenses.date', 'DESC')
                ->select('purchase_expense_items.*')
                ->get();
        } elseif ($request->id != null) {
            $invoicess = PurchaseExpenseItem::leftjoin('purchase_expenses', 'purchase_expense_items.purchase_expense_id', '=', 'purchase_expenses.id')
                ->where('purchase_expenses.party_id', $request->id)
                ->orderBy('purchase_expenses.date', 'DESC')
                ->select('purchase_expense_items.*')
                ->get();
        } elseif ($request->invoice_no != null) {
            $invoicess = PurchaseExpenseItem::leftjoin('purchase_expenses', 'purchase_expense_items.purchase_expense_id', '=', 'purchase_expenses.id')
                ->where('purchase_expense_items.invoice_no', 'like', "%{$request->invoice_no}%")
                ->orderBy('purchase_expenses.date', 'DESC')
                ->select('purchase_expense_items.*')
                ->get();
        } else {
            $invoicess = PurchaseExpenseItem::leftjoin('purchase_expenses', 'purchase_expense_items.purchase_expense_id', '=', 'purchase_expenses.id')
                ->orderBy('purchase_expenses.date', 'DESC')
                ->select('purchase_expense_items.*')
                ->get();
        }
        return view('backend.purchase-expense.ajax-invoice', compact('invoicess'));
    }

    public function find_invoice_date(Request $request)
    {
        $date = $this->dateFormat($request->date);

        $invoicess = PurchaseExpenseItem::leftjoin('purchase_expenses', 'purchase_expense_items.purchase_expense_id', '=', 'purchase_expenses.id')
            ->where('purchase_expenses.date', $date)
            ->orderBy('purchase_expenses.date', 'DESC')
            ->select('purchase_expense_items.*')
            ->get();
        return view('backend.purchase-expense.ajax-invoice', compact('invoicess'));
    }

    public function search_purch(Request $request)
    {
        $expenses = PurchaseExpense::where('purchase_no', 'like', "%{$request->value}%")->orWhere('invoice_no', 'like', "%{$request->value}%")->get();
        if ($request->party != '') {
            $expenses = $expenses->where('party_id', $request->party);
        }
        if ($request->date != '') {
            $date = $this->dateFormat($request->date);
            $expenses = $expenses->where('date', $date);
        }
        return view('backend.purchase-expense.search-purch', compact('expenses'));
    }

    public function purchase_authorize()
    {
        $parties = PartyInfo::get();
        $i = 0;
        $expenses = PurchaseExpenseTemp::where('authorized', false)->orderBy('id', 'DESC')->get();
        return view('backend.purchase-expense.authorize', compact('expenses', 'parties', 'i'));
    }

    public function purchase_authorization($id)
    {
        $purch = PurchaseExpenseTemp::find($id);
        $purch->authorized = true;
        $purch->authorized_by = Auth::id();
        $purch->save();
        $notification = array(
            'message'       => 'Authorized Successfully!',
            'alert-type'    => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function purchase_approve($type)
    {
        $parties = PartyInfo::get();
        $i = 0;
        $expenses = PurchaseExpenseTemp::where('authorized', 1)->where('invoice_type',$type)->orderBy('id', 'DESC')->get();

        return view('backend.purchase-expense.approve', compact('expenses', 'parties', 'i','type'));
    }

    public function purchase_approve_bill()
    {
        $parties = PartyInfo::get();
        $i = 0;
        $expenses = PurchaseExpenseTemp::where('invoice_type','bill')->where('authorized', true)->orderBy('id', 'DESC')->get();

        return view('backend.purchase-expense.approve-bill', compact('expenses', 'parties', 'i'));
    }



    public function purchase_approval($id)
    {

        $purch = PurchaseExpenseTemp::find($id);
        // dd($purch);
        $purch_ex = new PurchaseExpense();
        $purch_ex->date = $purch->date;
        $purch_ex->pay_mode =  $purch->pay_mode;
        $purch_ex->purchase_no =$purch->purchase_no;
        $purch_ex->invoice_no = $purch->invoice_no;
        $purch_ex->total_amount = $purch->total_amount;
        $purch_ex->vat = $purch->vat;
        $purch_ex->amount = $purch->amount;
        $purch_ex->party_id =  $purch->client->id;
        $purch_ex->narration = $purch->narration;
        $purch_ex->gst_subtotal = $purch->gst_subtotal;
        $purch_ex->created_by = $purch->created_by;
        $purch_ex->paid_amount = $purch->paid_amount;
        $purch_ex->due_amount = $purch->due_amount;
        $purch_ex->authorized_by = $purch->authorized_by;
        $purch_ex->invoice_type = $purch->invoice_type;
        $purch_ex->approved_by = Auth::id();
        $purch_ex->client_id = $purch->client->id;
        $purch_ex->save();
        $url=$purch->invoice_type=='bill'? 'accounting/purchase-approve-bill': ($purch->invoice_type=='Garage'?'accounting/purchase-approve-bill/Garage':'accounting/purchase-approve-bill/Office');

        $journal_no = $this->journal_no();
        $journal = new Journal();
        $journal->project_id        = $purch_ex->project_id;
        $journal->purchase_expense_id = $purch_ex->id;
        $journal->transection_type  = 'Purchase/Expense Entry';
        $journal->transaction_type  = 'Increase';
        $journal->journal_no        = $journal_no;
        $journal->date              = $purch_ex->date;
        $journal->pay_mode          = $purch_ex->pay_mode;
        $journal->cost_center_id    = 0;
        $journal->party_info_id     = $purch_ex->client_id;
        $journal->account_head_id   = 123;
        $journal->voucher_type      = 'CREDIT';

        $journal->amount            = $purch_ex->total_amount;
        $journal->tax_rate          = 0;
        $journal->vat_amount        = $purch_ex->vat;
        $journal->total_amount      = $purch_ex->total_amount;
        $journal->gst_subtotal = 0;
        $journal->narration         =  $purch_ex->narration;
        $journal->approved_by = $purch_ex->approved_by;
        $journal->authorized_by         = $purch_ex->authorized_by;
        $journal->created_by = $purch_ex->created_by;
        $journal->voucher_scan  = $purch_ex->voucher_scan;
        $journal->voucher_scan2  = $purch_ex->voucher_scan2;
        if($purch->pay_mode == 'Cheque'){
            $purch_ex->issuing_bank = $purch->issuing_bank;
            $purch_ex->bank_branch = $purch->bank_branch;
            $purch_ex->cheque_no =  $purch->cheque_no;
            $purch_ex->deposit_date = $purch->deposit_date;
        }
        $journal->save();

         if ($purch_ex->vat > 0) {
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
            $jl_record->amount              = $purch_ex->vat;
            $jl_record->invoice_no              = 'N/A';
            $jl_record->total_amount        = 0;
            $jl_record->vat_rate_id         = 0;
            $jl_record->transaction_type    = 'DR';
            $jl_record->journal_date        = $journal->date;
            $jl_record->account_type_id = $vat_ac_head->account_type_id;
            $jl_record->is_main_head        = 0;
            $jl_record->save();
        }
        //end paymode journal

        foreach ($purch->items as $item) {
            $purc_exp_itm = new PurchaseExpenseItem();
            $purc_exp_itm->head_id = $item->head_id;
            $purc_exp_itm->cost_center = $item->cost_center;
            $purc_exp_itm->bill_no = $item->bill_no;
            $purc_exp_itm->qty = $item->qty;
            $purc_exp_itm->unit_id = $item->unit_id;
            $purc_exp_itm->rate = $item->rate;
            $purc_exp_itm->amount = $item->amount;
            $purc_exp_itm->vat = $item->vat;
            $purc_exp_itm->total_amount = $item->total_amount;
            $purc_exp_itm->due_amount = $item->due_amount;

            $purc_exp_itm->party_id = $item->party_id;
            $purc_exp_itm->purchase_expense_id = $purch_ex->id;
            $purc_exp_itm->date = $purch_ex->date;
            $purc_exp_itm->gst_subtotal = $item->gst_subtotal;
            $purc_exp_itm->pay_mode = $purch_ex->pay_mode;
            $purc_exp_itm->paid_from_id = $purch_ex->paid_from_id;
            $purc_exp_itm->save();

            $ac_head=AccountHead::where('id',$purc_exp_itm->head_id)->first();
            if(!$ac_head){
                $ac_head = AccountHead::find(28);
            }
            if($ac_head){
                $jl_record = new JournalRecord();
                $jl_record->journal_id          = $journal->id;
                $jl_record->project_details_id  = $journal->project_id;
                $jl_record->cost_center_id      = $journal->cost_center_id;
                $jl_record->party_info_id       = $journal->party_info_id;
                $jl_record->journal_no          = $journal->journal_no;
                $jl_record->account_head_id     = $ac_head->id;
                $jl_record->master_account_id   = $ac_head->master_account_id;
                $jl_record->account_head        = $ac_head->fld_ac_head;
                $jl_record->amount              = $purc_exp_itm->amount;
                $jl_record->total_amount        = $purc_exp_itm->amount;
                $jl_record->vat_rate_id         = 0;
                $jl_record->invoice_no          = 0;
                $jl_record->transaction_type    = 'DR';
                $jl_record->journal_date        = $journal->date;
                $jl_record->is_main_head        = 1;
                $jl_record->account_type_id     = $ac_head->account_type_id;
                $jl_record->save();
            }
            if($purc_exp_itm->cost_center=='' && $purch_ex->invoice_type=='bill'){
                if($ac_head->master_account_id==3){
                    $stock=Stock::where('product_id',$ac_head->item_id)->first();
                    if($stock) {
                        $s_total = $stock->pcs*$stock->avg_unit_price;
                        $i_total = $purc_exp_itm->qty*$purc_exp_itm->rate;
                        $s_i_total =  $s_total + $i_total;
                        $s_i_qty =  $purc_exp_itm->qty + $stock->pcs;
                        $w_avg = 0;
                        if($s_i_qty > 0){
                            $w_avg = $s_i_total/$s_i_qty ;
                        }
                        $stock->pcs=number_format($s_i_qty ,0,'.','');
                        $stock->avg_unit_price=number_format($w_avg ,0,'.','');
                        $stock->save();

                    } else {
                        // dd($purc_exp_itm->rate);
                        $stock=new Stock();
                        $stock->product_id=$ac_head->item_id;
                        $stock->pcs=number_format($purc_exp_itm->qty,0,'.','');
                        $stock->avg_unit_price=number_format($purc_exp_itm->rate,0,'.', '');
                        $stock->save();
                    }
                }
            }
        }

        //Paymode journal
        if($purch_ex->due_amount>0){
            $ac_head = AccountHead::find(5); // accounts payable
            $jl_record = new JournalRecord();
            $jl_record->journal_id          = $journal->id;
            $jl_record->project_details_id  = 1;
            $jl_record->cost_center_id      = $journal->cost_center_id;
            $jl_record->party_info_id       = $journal->party_info_id;
            $jl_record->journal_no          =  $journal->journal_no;
            $jl_record->account_head_id     = $ac_head->id;
            $jl_record->master_account_id   = $ac_head->master_account_id;
            $jl_record->account_head        = $ac_head->fld_ac_head;
            $jl_record->amount              = $purch_ex->due_amount;
            $jl_record->total_amount        = $purch_ex->due_amount;
            $jl_record->vat_rate_id         = 0;
            $jl_record->transaction_type    = 'CR';
            $jl_record->journal_date        = $journal->date;
            $jl_record->invoice_no          = 'N/A';
            $jl_record->account_type_id     = $ac_head->account_type_id;
            $jl_record->is_main_head        = 0;
            $jl_record->save();
        }
        if ($purch_ex->pay_mode == 'Cash' || $purch_ex->pay_mode == 'Petty Cash' || $purch_ex->pay_mode == 'Card' || $purch_ex->pay_mode == 'Cheque') {
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
            $payment = new Payment();
            $payment->date = $purch_ex->date;
            $payment->pay_mode =  $purch_ex->pay_mode;
            $payment->payment_no = $payment_no;
            $payment->head_id = 0;
            $payment->total_amount = $purch_ex->paid_amount;
            $payment->vat = 0;
            $payment->party_id = $purch_ex->client_id;
            $payment->narration = $purch_ex->narration;
            $payment->paid_amount = 0;
            $payment->due_amount = 0;
            if($purch_ex->pay_mode == 'Cheque'){
                $payment->issuing_bank = $purch_ex->issuing_bank;
                $payment->branch = $purch_ex->bank_branch;
                $payment->deposit_date = $purch_ex->deposit_date;
                $payment->cheque_no = $purch_ex->cheque_no;
                $payment->status = 'Pending';
            }else{
                $payment->status = 'Realised';
            }
            $payment->save();

            $payment_invoice = InvoiceNumber::first();
            $payment_invoice->payment_no = $payment->payment_no;
            $payment_invoice->save();

            $purc_exp_itm = new PaymentInvoice();
            $purc_exp_itm->sale_id = $purch_ex->id;
            $purc_exp_itm->payment_id = $payment->id;
            $purc_exp_itm->total_amount = $payment->total_amount;
            $purc_exp_itm->vat = 0;
            $purc_exp_itm->amount = $payment->total_amount;
            $purc_exp_itm->party_id = $payment->party_id;
            $purc_exp_itm->save();

            if($purch_ex->pay_mode != 'Cheque'){
                $pay_head = $purch_ex->pay_mode == 'Cash' ? 1 : ($purch_ex->pay_mode == 'Petty Cash'?10:2);
                $ac_head = AccountHead::find($pay_head);
                $jl_record = new JournalRecord();
                $jl_record->journal_id          = $journal->id;
                $jl_record->project_details_id  = $journal->project_id;
                $jl_record->cost_center_id      = $journal->cost_center_id;
                $jl_record->party_info_id       = $journal->party_info_id;
                $jl_record->journal_no          = $journal->journal_no;
                $jl_record->account_head_id     = $ac_head->id;
                $jl_record->master_account_id   = $ac_head->master_account_id;
                $jl_record->account_head        = $ac_head->fld_ac_head;
                $jl_record->amount              = $purc_exp_itm->amount;
                $jl_record->total_amount        = $purc_exp_itm->amount;
                $jl_record->vat_rate_id         = 0;
                $jl_record->transaction_type    = 'CR';
                $jl_record->journal_date        = $journal->date;
                $jl_record->invoice_no          = 'N/A';
                $jl_record->account_type_id     = $ac_head->account_type_id;
                $jl_record->is_main_head        = 0;
                $jl_record->save();
            }

        }
        //end payment voucher
        foreach($purch->documents as $document){
            $file = new Document();
            $file->extension = $document->extension;
            $file->file_path = $document->file_path;
            $file->purchase_id = $purch_ex->id;
            $file->save();
        }

        //end payment voucher

        $purch->items->each->delete();
        $purch->delete();
        $notification = array(
            'message'       => 'Approve Successfully!',
            'alert-type'    => 'success'
        );
        // return back()->with($notification);
        return redirect($url)->with($notification);
    }

    public function payment_declined($id)
    {
        $payment=Payment::find($id);
        $payment->status="Declined";
        $payment->save();
        $notification = array(
            'message'       => 'Declined!',
            'alert-type'    => 'warning'
        );
        return redirect()->back()->with($notification);
    }

    public function payment_realised($id)
    {
        $payment=Payment::find($id);
        if($payment->status=='Realised')
        {
            $notification = array(
                'message'       => 'Already Realised!',
                'alert-type'    => 'warning'
            );
            return redirect()->back()->with($notification);
        }
        $payment->status="Realised";
        $payment->save();
        $journal_no = $this->journal_no();
        $journal = new Journal();
        $journal->project_id        = 1;
        $journal->transection_type        = 'PAYMENT VOUCHER';
        $journal->transaction_type        = 'CREDIT';
        $journal->payment_id        = $payment->id;
        $journal->journal_no        = $journal_no;
        $journal->date              = $payment->date;
        $journal->pay_mode          = 'Cash';
        $journal->voucher_type          = 'Payment Voucher';
        $journal->invoice_no        = 0;
        $journal->cost_center_id    = 0;
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

        $payment_head = AccountHead::find(5);
        $jl_record = new JournalRecord();
        $jl_record->journal_id     = $journal->id;
        $jl_record->project_details_id  = $journal->project_id;
        $jl_record->cost_center_id      = $journal->cost_center_id ;
        $jl_record->party_info_id       = $journal->party_info_id  ;
        $jl_record->journal_no          = $journal_no;
        $jl_record->account_head_id     = $payment_head->id;
        $jl_record->master_account_id   = $payment_head->master_account_id;
        $jl_record->account_head        = $payment_head->fld_ac_head;
        $jl_record->amount              = $journal->amount;
        $jl_record->total_amount        = $journal->amount;
        $jl_record->vat_rate_id         = 0;
        $jl_record->transaction_type    = 'DR';
        $jl_record->journal_date        = $journal->date;
        $jl_record->account_type_id = $payment_head->account_type_id;
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
        $jl_record->transaction_type    = 'CR';
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

    public function payment_deposit(Request $request, $id)
    {
        $payment=Payment::find($id);
        // dd($request->all());
        $payment->deposit_date=$this->dateFormat($request->deposit_date);
        $payment->save();
        $notification = array(
            'message'       => 'Success!',
            'alert-type'    => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function purchase_expense_edit($purchase)
    {

        $purchase=PurchaseExpenseTemp::find($purchase);
       // return $purchase;
        // dd($purchase);
        $modes = PayMode::whereIn('title',['Cash','Credit','Bank', 'Card', 'Petty Cash'])->get();
        $vats = VatRate::get();
        $account_heads = AccountHead::whereIn('master_account_id',[4,3])->get();
        $invoices = [];
        $clients = PartyInfo::whereIn('pi_type',['Supplier'])->get();
        $suppliers = PartyInfo::where('pi_type','Supplier')->get();
        $projects=ProjectDetail::all();
        $cost_center = Truck::all();
        $paid_from_lists =[];
        $projects=ProjectDetail::all();

        return view('backend.purchase-expense.purchase-expense-edit', compact('modes','projects','vats', 'account_heads','purchase','clients','suppliers','cost_center', 'paid_from_lists'));
    }


    public function expense_edit_post(Request $request, $id)
    {
        $request->validate(
            [
                'date'              =>  'required',
                'pay_mode'          => 'required',
            ],
            [
                'date.required'         => 'Date is required',
                'pay_mode.required'     => 'Pay Mode is required',
            ]
        );
       //  return $request;
        //Update date formate
        $update_date_format = $this->dateFormat($request->date);
        //purchase expense entry
        $purch_ex = PurchaseExpenseTemp::find($id);

        $purch_ex->date = $update_date_format;
        $purch_ex->pay_mode =  $request->pay_mode;
        $purch_ex->head_id = 0;
        $purch_ex->total_amount = $request->total_amount;
        $purch_ex->vat = $request->total_vat;
        $purch_ex->amount = $request->taxable_amount;
        $purch_ex->narration = $request->narration;
        $purch_ex->client_id = $request->client_info;
        // $purch_ex->party_id =  $request->party_info;
        $purch_ex->invoice_no = $request->invoice_no;
        $purch_ex->gst_subtotal = 0;
        $purch_ex->created_by = Auth::id();
        $purch_ex->authorized_by = Auth::id();
        $purch_ex->authorized = 1;
        $purch_ex->paid_amount = $request->pay_mode == 'Credit' ?  0 : $purch_ex->total_amount;
        $purch_ex->due_amount = $request->pay_mode == 'Credit' ?  $purch_ex->total_amount : 0;
        if ($request->pay_mode == 'Cheque') {
            $purch_ex->issuing_bank = $request->issuing_bank;
            $purch_ex->bank_branch = $request->bank_branch;
            $purch_ex->cheque_no =  $request->cheque_no;
            $purch_ex->deposit_date = $this->dateFormat($request->deposit_date);
        }
        $purch_ex->save();
        //end purchase expense entry
        $purchase_number = InvoiceNumber::find(1);
        $purchase_number->purchase_no = $purch_ex->purchase_no;
        $purchase_number->save();
        //records entry
        $purch_ex->items->each->delete();
        $multi_head = $request->input('inputs');
        foreach ($multi_head as $each_head) {
            //purchase record
            $purc_exp_itm = new PurchaseExpenseItemTemp();
            $purc_exp_itm->head_id = $each_head['description'];
            if(isset($each_head['cost_center'])){
                $purc_exp_itm->cost_center = $each_head['cost_center']? $each_head['cost_center']: null;
            }            // $purc_exp_itm->bill_no = $each_head['bill_no'];
            $purc_exp_itm->amount = $each_head['taxable'];
            $purc_exp_itm->vat = $each_head['vat_amount'];
            $purc_exp_itm->rate = $each_head['amount'];
            $purc_exp_itm->qty = $each_head['qty'];

            $purc_exp_itm->total_amount = $each_head['sub_gross_amount'];
            $purc_exp_itm->due_amount =  $request->pay_mode == 'Credit' ?  $each_head['sub_gross_amount'] : 0;
            $purc_exp_itm->party_id = $purch_ex->client_id;
            $purc_exp_itm->purchase_expense_id = $purch_ex->id;
            $purc_exp_itm->date = $purch_ex->date;
            $purc_exp_itm->gst_subtotal = 0;
            $purc_exp_itm->save();
            //end purchase record
        }
        if($request->hasFile('files')){
            $files = $request->file('files');
            foreach($files as $file){
                $document = new DocumentTemp();
                $ext= $file->getClientOriginalExtension();
                $name = hexdec(uniqid()).time().'.'.$ext;
                $file->storeAs('public/upload/documents', $name);
                $document->purchase_id = $purch_ex->id;
                $document->extension = $ext;
                $document->file_path = '/storage/upload/documents/'.$name;
                $document->save();
            }
        }
        //end records entry

        $purchase_exp = PurchaseExpenseTemp::with('documents')->where('id',$purch_ex->id)->first();
        $items= PurchaseExpenseItemTemp::where('purchase_expense_id',$purch_ex->id)->get();
        $new=0;
        $notification = array(
            'message'       => 'Update Successfully!',
            'alert-type'    => 'success'
        );
        return view('backend.purchase-expense.authorize-preview', compact('purchase_exp','new','items'))->with($notification);
    }

    public function purchase_delete($id)
    {
        $purch=PurchaseExpenseTemp::find($id);
        // dd($purch);
        $purch->items->each->delete();
        $purch->delete();
        $notification = array(
            'message'       => 'Deleted Successfully!',
            'alert-type'    => 'success'
        );
        return back()->with($notification);
        // if($purch->invoice_type == 'bill'){
        //     return redirect('/purchase/purchase-approve-bill')->with($notification);
        // }else{
        //     return redirect('/purchase/purchase-approve-bill/'.$purch->invoice_type.'')->with($notification);
        // }
    }

     public function payable()
    {
        $suppliers = PartyInfo::where('pi_type', 'Supplier')->get();
        // $suppliers=DB::table('party_infos')
        // ->where('party_infos.pi_type','Supplier')
        // ->join('purchase_expenses', 'party_infos.id', '=', 'purchase_expenses.party_id')
        // ->select('party_infos.id','party_infos.pi_code','party_infos.pi_name',
        // DB::raw('SUM(CASE WHEN purchase_expenses.party_id =party_infos.id THEN purchase_expenses.due_amount ELSE 0 END ) as due_amount')
        // )
        // ->groupBy('party_infos.id','party_infos.pi_code','party_infos.pi_name')
        // ->orderByDesc('due_amount')
        // ->get();
        return view('backend.purchase-expense.payable',compact('suppliers'));
    }

    public function search_supplier_due(Request $request)
    {

        // $payables= PurchaseExpenseItem::where('due_amount', '>', 0)->where('cost_center', $request->party)->orderBy('id', 'asc')->get();
        $suppliers = PartyInfo::where('id', $request->party)->get();
        return view('backend.purchase-expense.payable-table',compact('suppliers'));

    }

    public function payable_view(Request $request)
    {
        $info = PartyInfo::where('id', $request->id)->first();
        $expenses = PurchaseExpense::where('due_amount', '>', 0)->where('party_id', $info->id)->get();
        $suppliers = SupplierInvoice::where('due_amount', '>', 0)->where('supplier_id', $info->id)->get();
        $due_amount = $expenses->sum('due_amount')+$suppliers->sum('due_amount');
        return view('backend.purchase-expense.payable-view', compact('expenses','info', 'suppliers'));
    }

    public function search_expense_amount(Request $request)
    {

        $fromDate = $this->dateFormat($request->from);
        $toDate = $this->dateFormat($request->to);
        $invoiceType = $request->type;

        $totalAmount = PurchaseExpense::whereBetween('date', [$fromDate, $toDate])
                                      ->where('is_distribute', 0)
                                      ->where('invoice_type', $invoiceType)
                                      ->sum('total_amount');

        return $totalAmount;

    }

    public function available_pay_amount(Request $request){
        $balance = 0;
        if($request->pay_mode=='Cash'){
            $cash_cr = JournalRecord::where('account_head_id',1)->whereYear('created_at',date('Y'))->where('transaction_type','CR')->get()->sum('total_amount');
            $cash_dr = JournalRecord::where('account_head_id',1)->whereYear('created_at',date('Y'))->where('transaction_type','DR')->get()->sum('total_amount');
            $balance = $cash_dr - $cash_cr;
        }
        if($request->pay_mode=='Card' || $request->pay_mode=='Bank' || $request->pay_mode=='Cheque'){
            $bank_cr = JournalRecord::where('account_head_id',2)->whereYear('created_at',date('Y'))->where('transaction_type','CR')->get()->sum('total_amount');
            $bank_dr = JournalRecord::where('account_head_id',2)->whereYear('created_at',date('Y'))->where('transaction_type','DR')->get()->sum('total_amount');
            $balance = $bank_dr - $bank_cr;
        }if($request->pay_mode=='Petty Cash'){
            $cash_cr = JournalRecord::where('account_head_id',10)->whereYear('created_at',date('Y'))->where('transaction_type','CR')->get()->sum('total_amount');
            $cash_dr = JournalRecord::where('account_head_id',10)->whereYear('created_at',date('Y'))->where('transaction_type','DR')->get()->sum('total_amount');
            $balance = $cash_dr - $cash_cr;
        }
        if($request->pay_mode=='VISA Card'){
            $cash_cr = JournalRecord::where('account_head_id',153)->whereYear('created_at',date('Y'))->where('transaction_type','CR')->get()->sum('total_amount');
            $cash_dr = JournalRecord::where('account_head_id',153)->whereYear('created_at',date('Y'))->where('transaction_type','DR')->get()->sum('total_amount');
            $balance = $cash_dr - $cash_cr;
        }
        return $balance;
    }
    public function head_store(Request $request){
        $request->validate(
            [
                'name'        => 'required',
            ],[
                'name.required' => 'A/C Head is required',
        ]);
        $masterAcc = MasterAccount::find( $request->master_acc_id);
        $accHeadL = AccountHead::where('ma_code', $masterAcc->mst_ac_code)->latest()->first();
        $accHead = new AccountHead();
        if ($accHeadL) {
            $accHead->ac_code = $accHeadL->ac_code + 1;
        } else {
            $accHead->ac_code = 100;
        }
        $accHead->ma_code = $masterAcc->mst_ac_code;
        $accHead->fld_ac_head = $request->name;
        $accHead->fld_ac_code = $masterAcc->mst_ac_code . "-" . $accHead->ac_code;
        $accHead->fld_ms_ac_head = $masterAcc->mst_ac_head;
        $accHead->fld_definition = $masterAcc->mst_definition;
        $accHead->account_type_id= $masterAcc->account_type_id;
        $accHead->master_account_id= $masterAcc->id;
        // dd($accHead);
        $accHead->save();
        return $accHead;
    }
}
