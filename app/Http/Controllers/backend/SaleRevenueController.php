<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Journal;
use App\JournalRecord;
use App\Models\AccountHead;
use App\Models\InvoiceNumber;
use App\Models\MasterAccount;
use App\Models\Payroll\Employee;
use App\PartyInfo;
use App\PayMode;
use App\Receipt;
use App\ReceiptSale;
use App\SaleReturn;
use App\SaleRevenue;
use App\SaleRevenueItem;
use App\TaxInvoice;
use App\TaxInvoiceItemTemp;
use App\TaxInvoiceTemp;
use App\TempPRNO;
use App\Truck;
use App\TruckRecords;
use App\VatRate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SaleRevenueController extends Controller
{

    public function index(Request $request){
        $from = $request->from ? $this->dateFormat($request->from) : date('Y-m-d');
        $to = $request->to ? $this->dateFormat($request->to) : $from;

        $sales = TaxInvoice::where('type' , 'sale')->orderBy('id','desc')->paginate(300);
        return view('backend.sale-revenue.index', compact('sales'));
        // for excel tax invoice
        // $sales = TaxInvoice::whereBetween('date', ['2025-04-01', '2025-06-31'])->get();
        // return view('backend.sale-revenue.excel-tax-file', compact('sales'));
    }

    public function create(){

        $pInfos = PartyInfo::orderby('pi_name')->where('pi_type','Customer')->get();
        $modes = PayMode::whereIn('id',[1,2,4])->get();
        $vats = VatRate::get();
        $account_heads = AccountHead::where('master_account_id', 5)->get();
        $masterAcc = MasterAccount::whereIn('id',[5])->get();
        $cost_center = Truck::all();
        $countries= DB::table('countries')->get();
        $drivers = Employee::where('division', 3)->get();
        $owners = PartyInfo::orderBy('pi_name')->where('pi_type', 'Owner')->get();

        return view('backend.sale-revenue.create',compact('pInfos','modes','vats','account_heads','masterAcc','cost_center','countries','drivers','owners'));
    }

    public function store(Request $request){
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

        $multi_head = $request->input('group-a');

        if(empty($multi_head)){
            $notification= array(
                'message'       => 'Add Minimum One Service !!!',
                'alert-type'    => 'warning'
            );
            return redirect()->back()->with($notification);
        }


        $voucher_file_name='';
        if($request->hasFile('voucher_scan')){
            $voucher_scan= $request->file('voucher_scan');
            $name= $voucher_scan->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext= $voucher_scan->getClientOriginalExtension();
            $voucher_file_name= $name.time().'.'.$ext;
            $voucher_scan->storeAs( 'public/upload/documents', $voucher_file_name);
        }

        $voucher_file_name2='';
        if($request->hasFile('voucher_scan2')){
            $voucher_scan2= $request->file('voucher_scan2');
            $name= $voucher_scan2->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext= $voucher_scan2->getClientOriginalExtension();
            $voucher_file_name2= $name.time().'.'.$ext;
            $voucher_scan2->storeAs( 'public/upload/documents2', $voucher_file_name2);
        }

        $date = $request->date ? $request->date : date('d/m/Y');
        $old_date = explode('/', $date);
        $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));
        $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);

        $tax_invoice                = new TaxInvoiceTemp();
        $tax_invoice->customer_id   = $request->party_info ;
        $tax_invoice->project_id    = 0;
        $tax_invoice->date          = $new_date ;
        $tax_invoice->cost_center_id = 1;
        $tax_invoice->pay_mode      = $request->pay_mode ;
        $tax_invoice->amount        = $request->taxable_amount;
        $tax_invoice->discount_amount    = $request->total_discount_amount;
        $tax_invoice->vat_amount    = $request->total_vat;
        $tax_invoice->total_toll_fee    = 0;
        $tax_invoice->total_amount   = $request->total_amount;
        $tax_invoice->sale_no   = $request->sale_no;

        $tax_invoice->paid_amount   = $request->pay_mode == 'Credit' ?  0 :  $request->paid_amount;;
        $tax_invoice->invoice_type   = 'Tax Invoice';
        $tax_invoice->type   = 'sale';


        $tax_invoice->due_amount    =  $request->pay_mode == 'Credit' ?  $tax_invoice->total_amount  : $tax_invoice->total_amount - $request->paid_amount;
        $tax_invoice->voucher_file_name2    = $request->voucher_file_name2;
        $tax_invoice->voucher_file_name    = $request->voucher_file_name;
        $tax_invoice->lpo_number    = $request->lpo_number;
        $tax_invoice->narration    = $request->narration;
        $tax_invoice->month         = $request->month?$request->month.'-01':null;
        $tax_invoice->pay_term      = $request->pay_term;

        $tax_invoice->status = 'Approve';


        $tax_invoice->created_by    = Auth::id();
        $tax_invoice->authorized_by=Auth::id();

        $tax_invoice_save = $tax_invoice->save();

        $i=0;
        foreach ($multi_head as $each_head) {
            $inv_item = new TaxInvoiceItemTemp();
            $inv_item->invoice_id = $tax_invoice->id;
            $inv_item->head_id = $each_head['account_head_id'];

            $inv_item->invoice_no = $tax_invoice->invoice_no;
            $inv_item->item_id = 0;
            $inv_item->truck_id = $each_head['vehicle_id'];
            $inv_item->customer_id = $request->party_info;
            $inv_item->description = 0;
            $inv_item->crusher = 0;
            $inv_item->destination = 0;
            $inv_item->qty = $each_head['qty'];
            $inv_item->rate = $each_head['rate'];
            $inv_item->amount = $each_head['amount'];
            $inv_item->vat_rate = $each_head['vat_rate'];
            $inv_item->vat_amount = $each_head['vat_amount'];
            $inv_item->discount = 0;
            $inv_item->total_amount = $each_head['sub_gross_amount'];
            $inv_item->toll_fee = 0;
            $inv_item->supplier_id = 0;
            $inv_item->date = $new_date;
            $inv_item->save();
        }
        $sale = $tax_invoice;
        $items=TaxInvoiceItemTemp::where('invoice_id',$tax_invoice->id)->get();

        $new=0;

        return view('backend.sale-revenue.preview', compact('sale','new','items'));
    }
    public function approveList(){
        $sales = TaxInvoiceTemp::where('type' , 'sale')->orderBy('id','desc')->paginate(40);
        return view('backend.sale-revenue.approve',compact('sales'));
    }

    public function show($id){
        $sale = TaxInvoiceTemp::with('items')->find($id);
        return view('backend.sale-revenue.preview',compact('sale'));
    }
    public function approve_show($id){
        $sale = TaxInvoice::with('items')->find($id);
        return view('backend.sale-revenue.preview',compact('sale'));
    }
    public function edit($id){
        $sale = TaxInvoiceTemp::find($id);
        $pInfos = PartyInfo::orderby('pi_name')->where('pi_type','Customer')->get();
        $modes = PayMode::whereIn('id',[1,2,4])->get();
        $vats = VatRate::get();
        $account_heads = AccountHead::where('master_account_id', 5)->get();
        $masterAcc = MasterAccount::whereIn('id',[5])->get();
        $cost_center = Truck::all();
        $countries= DB::table('countries')->get();
        $drivers = Employee::where('division', 3)->get();
        $owners = PartyInfo::orderBy('pi_name')->where('pi_type', 'Owner')->get();

        return view('backend.sale-revenue.edit',compact('sale','pInfos','modes','vats','account_heads','owners', 'masterAcc','countries','drivers','cost_center'));
    }

    public function update(Request $request, $id)
    {
        $multi_head = $request->input('group-a');

        if (empty($multi_head)) {
            $notification = array(
                'message' => 'Add Minimum One Service !!!',
                'alert-type' => 'warning'
            );
            return redirect()->back()->with($notification);
        }

        $request->validate(
            [
                'date' => 'required',
                'party_info' => 'required',
                'pay_mode' => 'required',
                'narration' => 'required'
            ],
            [
                'date.required' => 'Date is required',
                'party_info.required' => 'Party Info is required',
                'pay_mode.required' => 'Pay Mode is required',
                'narration.required' => 'Narration is required',
            ]
        );

        $update_date_format = $this->dateFormat($request->date);
        $voucher_file_name = '';
        if ($request->hasFile('voucher_scan')) {
            $voucher_scan = $request->file('voucher_scan');
            $name = $voucher_scan->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $voucher_scan->getClientOriginalExtension();
            $voucher_file_name = $name . time() . '.' . $ext;
            $voucher_scan->storeAs('public/upload/documents', $voucher_file_name);
        }

        $voucher_file_name2 = '';
        if ($request->hasFile('voucher_scan2')) {
            $voucher_scan2 = $request->file('voucher_scan2');
            $name = $voucher_scan2->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext = $voucher_scan2->getClientOriginalExtension();
            $voucher_file_name2 = $name . time() . '.' . $ext;
            $voucher_scan2->storeAs('public/upload/documents2', $voucher_file_name2);
        }

        $date = $request->date ? $request->date : date('d/m/Y');
        $old_date = explode('/', $date);
        $new_data = $old_date[0] . '-' . $old_date[1] . '-' . $old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));
        $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);

        $tax_invoice = TaxInvoiceTemp::find($id);
        $tax_invoice->customer_id = $request->party_info;
        $tax_invoice->project_id = 0;
        $tax_invoice->date = $new_date;
        $tax_invoice->cost_center_id = 1;
        $tax_invoice->pay_mode = $request->pay_mode;
        $tax_invoice->amount = $request->taxable_amount;
        $tax_invoice->discount_amount = $request->total_discount_amount;
        $tax_invoice->vat_amount = $request->total_vat;
        $tax_invoice->total_toll_fee = 0;
        $tax_invoice->total_amount = $request->total_amount;
        $tax_invoice->sale_no = $request->sale_no;

        $tax_invoice->paid_amount = $request->pay_mode == 'Credit' ? 0 : $request->paid_amount;
        $tax_invoice->invoice_type = 'Tax Invoice';
        $tax_invoice->type = 'sale';

        $tax_invoice->due_amount = $request->pay_mode == 'Credit' ? $tax_invoice->total_amount : $tax_invoice->total_amount - $request->paid_amount;
        $tax_invoice->voucher_file_name2 = $request->voucher_file_name2;
        $tax_invoice->voucher_file_name = $request->voucher_file_name;
        $tax_invoice->lpo_number = $request->lpo_number;
        $tax_invoice->narration = $request->narration;
        $tax_invoice->month = $request->month ? $request->month . '-01' : null;
        $tax_invoice->pay_term = $request->pay_term;
        $tax_invoice->status = 'Approve';

        $tax_invoice->created_by = Auth::id();
        $tax_invoice->authorized_by = Auth::id();

        $tax_invoice->save();

        if ($tax_invoice->save()) {
            $tax_invoice->items->each->delete();
        }

        foreach ($multi_head as $each_head) {

                $inv_item = new TaxInvoiceItemTemp();
                $inv_item->invoice_id = $tax_invoice->id;
                $inv_item->head_id = $each_head['account_head_id'];

                $inv_item->invoice_no = $tax_invoice->invoice_no;
                $inv_item->item_id = 0;
                $inv_item->truck_id = $each_head['vehicle_id'];
                $inv_item->customer_id = $request->party_info;
                $inv_item->description = 0;
                $inv_item->crusher = 0;
                $inv_item->destination = 0;
                $inv_item->qty = $each_head['qty'];
                $inv_item->rate = $each_head['rate'];
                $inv_item->amount = $each_head['amount'];
                $inv_item->vat_rate = $each_head['vat_rate'];
                $inv_item->vat_amount = $each_head['vat_amount'];
                $inv_item->discount = 0;
                $inv_item->total_amount = $each_head['sub_gross_amount'];
                $inv_item->toll_fee = 0;
                $inv_item->supplier_id = 0;
                $inv_item->date = $new_date;
                $inv_item->save();
        }

        $sale = TaxInvoiceTemp::find($id);
        $items = TaxInvoiceItemTemp::where('invoice_id', $tax_invoice->id)->get();

        $new = 0;

        return view('backend.sale-revenue.preview', compact('sale', 'new', 'items'));
    }

    public function destroy($id)
    {
        $invoice= TaxInvoiceTemp::find($id);
        
        $invoice->items->each->delete();
        $invoice->delete();
        $notification= array(
            'message'       => 'Invoice Deleted!',
            'alert-type'    => 'success'
        );
        return back()->with(['message' => 'The sale revenue and its items have been deleted successfully', 'alert-type' => 'success']);
    }

    public function approval($id){

        $sale = SaleRevenue::find($id);
        $sale->approved_by = Auth::id();
        $sale->invoice_no = $this->invoice_no('INV');
        $sale->save();

        $journal_no = $this->journal_no();
        $journal = new Journal();
        $journal->project_id        = 1;
        $journal->invoice_id        = $sale->id;
        $journal->transection_type = 'Sale';
        $journal->transaction_type = 'Increase';
        $journal->journal_no        = $journal_no;
        $journal->date              =  $sale->date;
        $journal->pay_mode          = 'CREDIT';
        $journal->cost_center_id    = 0;
        $journal->party_info_id     = $sale->party_id;
        $journal->account_head_id   = 123;
        $journal->voucher_type   = 'CREDIT';

        $journal->amount            = $sale->total_amount;
        $journal->tax_rate          = 0;
        $journal->vat_amount        =  $sale->total_amount - $sale->amount;
        $journal->total_amount      =  $sale->total_amount;
        $journal->gst_subtotal = 0;
        $journal->narration         = $sale->narration;
        $journal->approved_by = $sale->approved_by;
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
        $jl_record->amount              = $sale->total_amount;
        $jl_record->total_amount        = $sale->total_amount;
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
                $payment_no = $this->receive_no();
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
                $payment->receipt_from = 'sale-revenue';
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
            }

        $notification = array(
            'message'       => 'Approved Successfully!',
            'alert-type'    => 'success'
        );
        return redirect()->route('sale.revenues.approve')->with($notification);

    }

    private function receive_no(){
        $sub_invoice = 'RV'.Carbon::now()->format('y');
        $let_purch_exp = Receipt::where('receipt_no', 'LIKE', "%{$sub_invoice}%")->orderBy('id','desc')->first();
        if ($let_purch_exp) {
            $purch_code =preg_replace('/^'.$sub_invoice.'/', '', $let_purch_exp->receipt_no);
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

        return $payment_no;
    }

    private function invoice_no($prefix="TEM")
    {
        $sub_invoice = $prefix . Carbon::now()->format('y');
        $let_purch_exp = SaleRevenue::where('invoice_no', 'LIKE', "%{$sub_invoice}%")->first();
        if ($let_purch_exp) {
            $purch_no = preg_replace('/^'.$sub_invoice.'/', '', $let_purch_exp->invoice_no);

            $purch_code = $purch_no + 1;
            if($purch_code<10)
            {
                $purch_no=$sub_invoice.'00'.$purch_code;
            }
            elseif($purch_code<100)
            {
                $purch_no=$sub_invoice.'00'.$purch_code;
            }
            elseif($purch_code<1000)
            {
                $purch_no=$sub_invoice.'0'.$purch_code;
            }
            else
            {
                $purch_no=$sub_invoice.$purch_code;

            }
        } else {
            $purch_no = $sub_invoice . '001';
        }
        return $purch_no;
    }

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
        $latest_journal_no = Journal::withTrashed()->whereDate('created_at', Carbon::today())->where('journal_no', 'LIKE', "%{$sub_invoice}%")->latest('id')->first();
        if ($latest_journal_no) {
            $journal_no = substr($latest_journal_no->journal_no, 0, -1);
            $journal_code = $journal_no + 1;
            $journal_no = $journal_code . "J";
        } else {
            $journal_no = Carbon::now()->format('Ymd') . '001' . "J";
        }

        return $journal_no;
    }
    public function sale_no_validation(Request $request)
    {
        if($request->party==null){
            return Response()->json([
                'error' => 'Please Select Party First!',
            ]);
        }
        $check = TaxInvoiceTemp::where('customer_id', $request->party)->where('sale_no', $request->inv)->first();
        if ($check) {
            return Response()->json([
                'warning' => $request->inv . ' Invoice No Already Exist!',
            ]);
        }
        else
        {
            $check = TaxInvoice::where('customer_id', $request->party)->where('sale_no', $request->inv)->first();
        if ($check) {
            return Response()->json([
                'warning' => $request->inv . ' Invoice No Already Exist Temporarily!',
            ]);
        }

        }
    }
}
