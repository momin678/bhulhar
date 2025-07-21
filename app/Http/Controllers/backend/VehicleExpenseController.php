<?php

namespace App\Http\Controllers\backend;

use App\DebitCreditVoucher;
use App\Http\Controllers\Controller;
use App\Journal;
use App\JournalRecord;
use App\Models\AccountHead;
use App\Models\CostCenter;
use App\PartyInfo;
use App\PayMode;
use App\PayTerm;
use App\Product;
use App\ProjectDetail;
use App\Stock;
use App\Truck;
use App\TxnType;
use App\VatRate;
use App\VehicleExpense;
use App\VehicleExpenseDetail;
use App\TaxInvoiceItem;
use App\TokenGeneration;
use App\Models\Payroll\Employee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Svg\Tag\Rect;
use App\TruckRecords;
use App\DriverCommission;
class VehicleExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = ProjectDetail::all();
        $modes = PayMode::all();
        $terms = PayTerm::all();
        $cCenters = CostCenter::all();
        $txnTypes = TxnType::all();
        $acHeads = AccountHead::all();
        $pInfos = PartyInfo::all();
        $vats = VatRate::orderBy('id','desc')->get();
        $expences = VehicleExpense::OrderBy('id', 'desc')->get();
        return view('backend.vehicle-expense.index', compact('projects',  'modes', 'terms', 'cCenters', 'txnTypes', 'acHeads', 'vats', 'pInfos', 'expences'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = ProjectDetail::all();
        $modes = PayMode::all();
        $terms = PayTerm::all();
        $cCenters = CostCenter::all();
        $txnTypes = TxnType::all();
        $acHeads = AccountHead::all();
        $pInfos = PartyInfo::all();
        $vats = VatRate::orderBy('id','desc')->get();
        $vehicles = Truck::all();
        return view('backend.vehicle-expense.create', compact('projects', 'modes', 'terms', 'cCenters', 'txnTypes', 'acHeads', 'vats', 'pInfos', 'vehicles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'date'              =>  'required',
                'invoice_no'        =>  'required',
                'party_info'        => 'required',
                'pay_mode'          => 'required',
                'narration'         => 'required',
                'vehicle_id'        => 'required',
            ],
            [
                'date.required'         => 'Date is required',
                'invoice_no.required'   => 'nvoice No is required',
                'party_info.required'   => 'Party Info is required',
                'pay_mode.required'     => 'Pay Mode is required',
                'narration.required'    => 'Narration is required',
                'vehicle_id.required'   => 'vehicle is required',

            ]
        );
        $multi_head=$request->input('group-a');
        $total_vat=0;
        $total_amount_withvat=0;
        $total_amount=0;
        foreach($multi_head as $each_head){
            $vat_amount=$each_head['multi_total_amount'] - $each_head['multi_amount'];
            $total_vat= $total_vat+ $vat_amount;
            $total_amount_withvat= $total_amount_withvat + $each_head['multi_total_amount'];
            $total_amount= $total_amount + $each_head['multi_amount'];
        }
        // voucher scan upload
        if($request->hasFile('voucher_scan')){
            $voucher_scan= $request->file('voucher_scan');
            $name= $voucher_scan->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext= $voucher_scan->getClientOriginalExtension();
            $voucher_file_name= $name.time().'.'.$ext;
            $voucher_scan->storeAs( 'public/upload/documents', $voucher_file_name);
        }

        $expense = new VehicleExpense;
        $expense->project_id = $request->project;
        $expense->vehicle_id = $request->vehicle_id;
        $expense->cost_center_id = $request->cost_center_name;
        $expense->party_id = $request->party_info;
        $expense->payment_mode = $request->pay_mode;
        $expense->invoice_no = $request->invoice_no;
        $expense->date = $request->date;
        $expense->amount = $total_amount;
        $expense->vat_amount = $total_vat;
        $expense->total_amount = $total_amount_withvat;
        $expense->narration = $request->narration;
        if($request->hasFile('voucher_scan')){
            $expense->file = $voucher_file_name;
        }
        $expense->save();
        foreach($multi_head as $each_head){
            $expense_recode = new VehicleExpenseDetail;
            $expense_recode->vehicle_expense_id = $expense->id;
            $expense_recode->ac_id = $each_head['multi_acc_head'];
            $expense_recode->vat_amount = $each_head['multi_total_amount'] - $each_head['multi_amount'];
            $expense_recode->amount = $each_head['multi_amount'];
            $expense_recode->total_amount = $each_head['multi_total_amount'];
            $expense_recode->save();
        }
        // journal create of expense entry
        $sub_invoice = Carbon::now()->format('Ymd');
        $latest_journal_no = Journal::withTrashed()->whereDate('created_at', Carbon::today())->where('journal_no', 'LIKE', "%{$sub_invoice}%")->latest()->first();
        if ($latest_journal_no) {
            $journal_no = substr($latest_journal_no->journal_no,0,-1);
            $journal_code = $journal_no + 1;
            $journal_no = $journal_code . "J";
        } else {
            $journal_no = Carbon::now()->format('Ymd') . '001' . "J";
        }
        $ApproveJournal=new Journal();
        $ApproveJournal->project_id=$request->project;
        $ApproveJournal->journal_no=$journal_no;
        $ApproveJournal->date=$request->date;
        $ApproveJournal->invoice_no=$request->invoice_no;
        $ApproveJournal->cost_center_id=$request->cost_center_name;
        $ApproveJournal->party_info_id=$request->party_info;
        $ApproveJournal->account_head_id=123;
        $ApproveJournal->editedby_id=Auth::id();
        $ApproveJournal->authorized=Auth::id();
        $ApproveJournal->approved=true;
        $ApproveJournal->pay_mode=$request->pay_mode;
        $ApproveJournal->tax_rate=0;
        $ApproveJournal->amount=$total_amount;
        $ApproveJournal->vat_amount=$total_vat;
        $ApproveJournal->total_amount=$total_amount_withvat;
        $ApproveJournal->narration=$request->narration;
        $ApproveJournal->authorized_by=Auth::id();
        $ApproveJournal->approved_by=Auth::id();
        $ApproveJournal->created_by=Auth::id();
        $ApproveJournal->voucher_type='dd';
        if($request->hasFile('voucher_scan')){
            $ApproveJournal->voucher_scan  = $voucher_file_name;
        }
        $ApproveJournal->save();
        $type='';
        foreach($multi_head as $each_head){
            $ac_head= AccountHead::find($each_head['multi_acc_head']);
            if($ac_head->account_type_id== 1 || $ac_head->account_type_id== 4){
                // if it is expense or asset
                if($request->transaction_type=='Decrease'){
                    $type='CR';
                }else{
                    $type='DR';
                }
                $jl_record= new JournalRecord();
                $jl_record->journal_id     = $ApproveJournal->id;
                $jl_record->project_details_id  = $request->project;
                $jl_record->cost_center_id      = $request->cost_center_name;
                $jl_record->party_info_id       = $request->party_info;
                $jl_record->journal_no          = $journal_no;
                $jl_record->account_head_id     = $each_head['multi_acc_head'];
                $jl_record->master_account_id   = $ac_head->master_account_id;
                $jl_record->account_head        = $ac_head->fld_ac_head;
                $jl_record->amount              = $each_head['multi_amount'];
                $jl_record->total_amount        = $each_head['multi_total_amount'];
                $jl_record->vat_rate_id         = $each_head['multi_tax_rate'];
                $jl_record->transaction_type    = $type;
                $jl_record->journal_date        = $request->date;
                $jl_record->is_main_head        = 1;
                $jl_record->save();
            }elseif($ac_head->account_type_id== 2 || $ac_head->account_type_id== 3 || $ac_head->account_type_id== 5){

                if($request->transaction_type=='Decrease'){
                    $type='DR';
                }else{
                    $type='CR';
                }
                $jl_record= new JournalRecord();
                $jl_record->journal_id     = $ApproveJournal->id;
                $jl_record->project_details_id  = $request->project;
                $jl_record->cost_center_id      = $request->cost_center_name;
                $jl_record->party_info_id       = $request->party_info;
                $jl_record->journal_no          = $journal_no;
                $jl_record->account_head_id     = $each_head['multi_acc_head'];
                $jl_record->master_account_id   = $ac_head->master_account_id;
                $jl_record->account_head        = $ac_head->fld_ac_head;
                $jl_record->amount              = $each_head['multi_amount'];
                $jl_record->total_amount        = $each_head['multi_total_amount'];
                $jl_record->vat_rate_id         = $each_head['multi_tax_rate'];
                $jl_record->transaction_type    = $type;
                $jl_record->journal_date        = $request->date;
                $jl_record->is_main_head        = 1;
                $jl_record->save();
            }
        }

        // vat entry to journal
        if($total_vat>0){
            $vat_ac_head= AccountHead::find(32); // vat account head
            $jl_record= new JournalRecord();
            $jl_record->journal_id     = $ApproveJournal->id;
            $jl_record->project_details_id  = $request->project;
            $jl_record->cost_center_id      = $request->cost_center_name;
            $jl_record->party_info_id       = $request->party_info;
            $jl_record->journal_no          = $journal_no;
            $jl_record->account_head_id     = $vat_ac_head->id;
            $jl_record->master_account_id   = $vat_ac_head->master_account_id;
            $jl_record->account_head        = $vat_ac_head->fld_ac_head;
            $jl_record->amount              = $total_vat;
            $jl_record->total_amount        = 0;
            $jl_record->vat_rate_id         = 0;
            $jl_record->transaction_type    = $type;
            $jl_record->journal_date        = $request->date;
            $jl_record->is_main_head        = 0;
            $jl_record->save();
        }

        // Opposit entry of journal
        if($request->pay_mode=='Cash' || $request->pay_mode=='Card'){
            $ac_head= AccountHead::find(1); // cash account
            $opposit_type= $type=='DR' ? 'CR' : 'DR';
            $jl_record= new JournalRecord();
            $jl_record->journal_id     = $ApproveJournal->id;
            $jl_record->project_details_id  = $request->project;
            $jl_record->cost_center_id      = $request->cost_center_name;
            $jl_record->party_info_id       = $request->party_info;
            $jl_record->journal_no          = $journal_no;
            $jl_record->account_head_id     = $ac_head->id;
            $jl_record->master_account_id   = $ac_head->master_account_id;
            $jl_record->account_head        = $ac_head->fld_ac_head;
            $jl_record->amount              = $total_amount_withvat;
            $jl_record->total_amount        = $each_head['multi_total_amount'];
            $jl_record->vat_rate_id         = 0;
            $jl_record->transaction_type    = $opposit_type;
            $jl_record->journal_date        = $request->date;
            $jl_record->is_main_head        = 0;
            $jl_record->save();

        }elseif($request->pay_mode=='Credit'){
            if($type=='DR'){
                $ac_head= AccountHead::find(35); // accounts payable
                $opposit_type='CR';
            }else{
                $ac_head= AccountHead::find(33); // accounts receivable
                $opposit_type='DR';
            }

            $jl_record= new JournalRecord();
            $jl_record->journal_id     = $ApproveJournal->id;
            $jl_record->project_details_id  = $request->project;
            $jl_record->cost_center_id      = $request->cost_center_name;
            $jl_record->party_info_id       = $request->party_info;
            $jl_record->journal_no          = $journal_no;
            $jl_record->account_head_id     = $ac_head->id;
            $jl_record->master_account_id   = $ac_head->master_account_id;
            $jl_record->account_head        = $ac_head->fld_ac_head;
            $jl_record->amount              = $total_amount_withvat;
            $jl_record->total_amount        = $each_head['multi_total_amount'];
            $jl_record->vat_rate_id         = 0;
            $jl_record->transaction_type    = $opposit_type;
            $jl_record->journal_date        = $request->date;
            $jl_record->is_main_head        = 0;
            $jl_record->save();

        }elseif($request->pay_mode == 'NonCash'){
            // Non cash credit

            if($type=='DR'){
                $opposit_noncash='CR';
            }else{
                $opposit_noncash='DR';
            }

            $ac_head_2= AccountHead::find($request->acc_head_2);

            $jl_record= new JournalRecord();
            $jl_record->journal_id     = $ApproveJournal->id;
            $jl_record->project_details_id  = $request->project;
            $jl_record->cost_center_id      = $request->cost_center_name;
            $jl_record->party_info_id       = $request->party_info;
            $jl_record->journal_no          = $journal_no;
            $jl_record->account_head_id     = $request->acc_head_2;
            $jl_record->master_account_id   = $ac_head_2->master_account_id;
            $jl_record->account_head        = $ac_head_2->fld_ac_head;
            $jl_record->amount              = $total_amount_withvat;
            $jl_record->total_amount        = $each_head['multi_total_amount'];
            $jl_record->vat_rate_id         = 0;
            $jl_record->transaction_type    = $opposit_noncash;
            $jl_record->journal_date        = $request->date;
            $jl_record->is_main_head        = 0;
            $jl_record->save();
        }

        //Debit Voucher Or Credit Voucher
        $voucher_type="DR";
        if(($request->pay_mode == 'Cash' || $request->pay_mode == 'Card')  && ($type== 'DR' ) ){
            // if it is expense or asset
            $voucher_type = 'DR';
        }elseif( ($request->pay_mode == 'Cash' || $request->pay_mode == 'Card')  && ($type=='CR')){
            // if it is income, liability or equity
            $voucher_type = 'CR';
        }elseif($request->pay_mode == 'Credit'){
            $voucher_type            = 'JOURNAL';
        }
        $ApproveJournal->voucher_type          = $voucher_type;
        $ApproveJournal->save();

        $dr_cr_voucher= new DebitCreditVoucher();
        $dr_cr_voucher->journal_id      = $ApproveJournal->id;
        $dr_cr_voucher->project_id      = $ApproveJournal->project_id;
        $dr_cr_voucher->cost_center_id  = 1;
        $dr_cr_voucher->party_info_id   = $ApproveJournal->party_info_id;
        $dr_cr_voucher->account_head_id = 0;
        $dr_cr_voucher->pay_mode        = $ApproveJournal->pay_mode;
        $dr_cr_voucher->amount          = $ApproveJournal->total_amount;
        $dr_cr_voucher->narration       = $ApproveJournal->narration;
        $dr_cr_voucher->type            = $voucher_type;
        $dr_cr_voucher->date            = $ApproveJournal->date;
        $dr_cr_voucher->save();

        return back()->with('success','Expense Entry Successfull');
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
    public function vehicle_expense_view_modal(Request $request){
        $expenses = VehicleExpense::find($request->id);
        $expence_list = VehicleExpenseDetail::where('vehicle_expense_id', $expenses->id)->get();
        return view('backend.vehicle-expense.vehicle-expense-view', compact('expenses', 'expence_list'));
    }
    public function vehicle_expense_reports(Request $request){
        $to = '';
        $from = '';
        $startOfYear = '';
        $subDayStartOfYear = '';
        if($request->from && $request->to){
            $old_date = explode('/', $request->from);
            $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
            $new_date = date('Y-m-d', strtotime($new_data));
            $date = Carbon::createFromDate($new_date);
            $startOfYear = $date->copy()->startOfYear();
            $startOfYear = date('Y-m-d', strtotime($startOfYear));
            $subDayStartOfYear = date('Y-m-d', strtotime('-1 day', strtotime($new_date)));
            $old_date2 = explode('/', $request->to);
            $new_data2 = $old_date2[0].'-'.$old_date2[1].'-'.$old_date2[2];
            $new_date2 = date('Y-m-d', strtotime($new_data2));

            $from = $new_date;
            $to = $new_date2;
        }
        // dd($from);
        $trucks = Truck::orderBy('id', 'asc');
        $trucks_list = Truck::all();
        $truck_info = null;
        if($request->truck_id){
            $truck_info = Truck::find($request->truck_id);
            $trucks = $trucks->where('id', $request->truck_id);
        }
        $trucks = $trucks->get();
        return view('backend.report.vehicle-expense-report', compact('trucks', 'truck_info', 'trucks_list', 'to', 'from', 'startOfYear', 'subDayStartOfYear'));
    }
    public function item_expense(Request $request){
        $projects = ProjectDetail::all();
        $modes = PayMode::all();
        $terms = PayTerm::all();
        $cCenters = CostCenter::all();
        $txnTypes = TxnType::all();
        $acHeads = AccountHead::all();
        $pInfos = PartyInfo::all();
        $vats = VatRate::orderBy('id','desc')->get();
        $vehicles = Truck::all();
        $products=Product::orderBy('category_id','ASC')->get();
        $tokens = TokenGeneration::whereDoesntHave('exit_token')->get();
        return view('backend.vehicle-expense.item-expense', compact('projects', 'modes', 'terms', 'cCenters', 'txnTypes', 'acHeads', 'vats', 'pInfos', 'vehicles', 'products', 'tokens'));
    }

    public function find_stock(Request $request){
        $stock = Stock::where('product_id',$request->id)->first();
        // dd($stock);
        if ($stock) {
            return $stock;
        } else {
            return 0;
        }


    }
    public function item_expense_store(Request $request){
        // return($request);
        // dd($request->all());
        $request->validate(
            [
                'date'              =>  'required',
                'invoice_no'        =>  'required',
                'party_info'        => 'required',
                'pay_mode'          => 'required',
                'vehicle_id'        => 'required',
                // 'token_no'        => 'required',
            ],
            [
                'date.required'         => 'Date is required',
                'invoice_no.required'   => 'nvoice No is required',
                'party_info.required'   => 'Party Info is required',
                'pay_mode.required'     => 'Pay Mode is required',
                'vehicle_id.required'   => 'vehicle is required',
            ]
        );
        $multi_head=$request->inputs;
        $total_vat=0;
        $total_amount_withvat=0;
        $total_amount=0.00;
       // return([$request,$total_amount,$total_amount_withvat, $total_vat]);
        // voucher scan upload
        if($request->hasFile('voucher_scan')){
            $voucher_scan= $request->file('voucher_scan');
            $name= $voucher_scan->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $ext= $voucher_scan->getClientOriginalExtension();
            $voucher_file_name= $name.time().'.'.$ext;
            $voucher_scan->storeAs( 'public/upload/documents', $voucher_file_name);
        }
        $old_date = explode('/', $request->date);
        $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));

        $expense = new VehicleExpense;
        $expense->project_id = $request->project;
        $expense->vehicle_id = $request->vehicle_id;
        $expense->cost_center_id = $request->cost_center_name;
        $expense->party_id = $request->party_info;
        $expense->payment_mode = $request->pay_mode;
        $expense->invoice_no = $request->invoice_no;
        $expense->date = $new_date;
        $expense->amount = $total_amount;
        $expense->vat_amount = $total_vat;
        $expense->total_amount = $total_amount_withvat;
        $expense->others_cost = $request->others_cost;
        $expense->token_no = $request->token_no;
        $expense->narration = $request->narration;
        $expense->type = 'Item';
        if($request->hasFile('voucher_scan')){
            $expense->file = $voucher_file_name;
        }
        $expense->save();

          // start journal
          $sub_invoice=Carbon::now()->format('Ymd');
          $j_no=Journal::whereDate('created_at', Carbon::today())->where('journal_no','LIKE',"%{$sub_invoice}%")->orderBy('id','DESC')->first();
          if($j_no) {
              $j_code=rtrim($j_no->journal_no,'J');
              $no=$j_code+1;
              $jcode=$no.'J';
          } else {
              $jcode=Carbon::now()->format('Ymd').'001'.'J';
          }
          $journal=new Journal();
          $journal->transection_type  = "Labour Cost";
          $journal->transaction_type  = "Labour Cost";
          $journal->without_gst       = 0;
          $journal->gst_subtotal      = 0;
          $journal->project_id = $expense->project_id;
          $journal->journal_no=$jcode;
          $journal->date= $new_date;
          $journal->invoice_no=$expense->token_no;
          $journal->pay_mode= $expense->payment_mode;
          $journal->cost_center_id= 1;
          $journal->party_info_id= 1;
          $journal->account_head_id= 0;
          $journal->authorized= true;
          $journal->approved= true;
          $journal->amount= $request->sub_total;
          $journal->tax_rate= 0;
          $journal->vat_amount= 0;
          $journal->total_amount= $request->sub_total;
          $journal->narration= "Labour charge by paid ". $expense->payment_mode ;
          $journal->voucher_type= 'DR';
          $journal->created_by= Auth::id();
          $journal->authorized_by= Auth::id();
          $journal->approved_by= Auth::id();
          $journal->save();
        $new_total_amount = 0;
        foreach($multi_head as $each_head){
            $stock = Stock::where('product_id',$each_head['job_group_id'])->first();
            if($each_head['job_group_id'] && $each_head['qty'] && $each_head['rate'] && $stock && $stock->pcs>=$each_head['qty']){
                $expense_recode = new VehicleExpenseDetail;
                $expense_recode->vehicle_expense_id = $expense->id;
                $expense_recode->date =  $expense->date;
                $expense_recode->ac_id = $each_head['job_group_id'];
                $expense_recode->quantity = $each_head['qty'];
                $expense_recode->vat_amount = 0;
                $expense_recode->amount = $each_head['rate'];
                $expense_recode->remark = $each_head['remark'];
                $expense_recode->total_amount = $each_head['qty'] * $each_head['rate'];
                $expense_recode->save();
                $new_total_amount = $new_total_amount + ($each_head['qty'] * $each_head['rate']);
                if($stock->gallon && $stock->gallon>$each_head['qty']){
                    $stock->gallon = $stock->gallon-$each_head['qty'];
                    $stock->save();
                }
                if($stock->liter && $stock->liter>$each_head['qty']){
                    $stock->liter = $stock->liter-$each_head['qty'];
                    $stock->save();
                }
                if($stock->pcs && $stock->pcs>$each_head['qty']){
                    $stock->pcs = $stock->pcs-$each_head['qty'];
                    $stock->save();
                }

                $labour_cost_head= AccountHead::where('item_id',$stock->product_id)->first();
                $journal_temps = new JournalRecord();
                $journal_temps->journal_id = $journal->id;
                $journal_temps->project_details_id = $journal->project_id;
                $journal_temps->cost_center_id = 1;
                $journal_temps->party_info_id = 1;
                $journal_temps->journal_no = $journal->journal_no;
                $journal_temps->account_head_id = $labour_cost_head->id;
                $journal_temps->master_account_id = $labour_cost_head->master_account_id;
                $journal_temps->account_head = $labour_cost_head->fld_ac_head;
                $journal_temps->amount = $each_head['qty']*$stock->avg_unit_price;
                $journal_temps->total_amount = $each_head['qty']*$stock->avg_unit_price;
                $journal_temps->transaction_type = "CR";
                $journal_temps->journal_date = $journal->date;
                $journal_temps->account_type_id     = $labour_cost_head->account_type_id;
                $journal_temps->gst_amount          = 0;
                $journal_temps->gst_subtotal        = 0;
                $journal_temps->vat_rate_id         = 0;
                $journal_temps->invoice_no          = 'n/a';
                $journal_temps->save();
            }
        }
        $expense->amount = $new_total_amount;
        $expense->total_amount = $new_total_amount;
        $expense->save();


        //Expense Account
        $labour_cost_head= AccountHead::find(28);
        $journal_temps = new JournalRecord();
        $journal_temps->journal_id = $journal->id;
        $journal_temps->project_details_id = $journal->project_id;
        $journal_temps->cost_center_id = 1;
        $journal_temps->party_info_id = 1;
        $journal_temps->journal_no = $journal->journal_no;
        $journal_temps->account_head_id = $labour_cost_head->id;
        $journal_temps->master_account_id = $labour_cost_head->master_account_id;
        $journal_temps->account_head = $labour_cost_head->fld_ac_head;
        $journal_temps->amount = $request->sub_total;
        $journal_temps->total_amount = $request->sub_total;
        $journal_temps->transaction_type = "DR";
        $journal_temps->journal_date = $journal->date;
        $journal_temps->account_type_id     = $labour_cost_head->account_type_id;
        $journal_temps->gst_amount          = 0;
        $journal_temps->gst_subtotal        = 0;
        $journal_temps->vat_rate_id         = 0;
        $journal_temps->invoice_no          = 'n/a';
        $journal_temps->save();


        return back()->with('success','Expense Entry Successfull');
    }
    public function get_token_info(Request $request){
        $token = TokenGeneration::where('token_no',$request->value)->first();
        return $token;
    }
    public function driver_commission(Request $request){
        $to = '';
        $from = '';
        $startOfYear = '';
        $subDayStartOfYear = '';
        if($request->from && $request->to){
            $old_date = explode('/', $request->from);
            $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
            $new_date = date('Y-m-d', strtotime($new_data));
            $date = Carbon::createFromDate($new_date);
            $startOfYear = $date->copy()->startOfYear();
            $startOfYear = date('Y-m-d', strtotime($startOfYear));
            $subDayStartOfYear = date('Y-m-d', strtotime('-1 day', strtotime($new_date)));
            $old_date2 = explode('/', $request->to);
            $new_data2 = $old_date2[0].'-'.$old_date2[1].'-'.$old_date2[2];
            $new_date2 = date('Y-m-d', strtotime($new_data2));
            $from = $new_date;
            $to = $new_date2;
        }
        $drivers = Employee::where('division', 3)->get();
        $driver_info = Employee::find($request->driver_id);
        // dd($driver_info);
        return view('backend.report.driver-commission-report', compact( 'to', 'from', 'startOfYear', 'subDayStartOfYear', 'drivers', 'driver_info'));
    }
    public function driver_detail_view(Request $request){
        $records = TruckRecords::orderBy('date', 'asc')->where('driver_name', $request->id);
        $from = $request->from;
        $to = $request->to;
        if($request->from && $request->to){
            $records = $records->whereBetween('date', [$request->from, $request->to]);
        }
        $records = $records->get();
        $driver_info = Employee::find($request->id);
        return view('backend.report.driver-commission-detail', compact( 'records', 'driver_info', 'from', 'to'));
    }
    public function driver_commission_print(Request $request){
        $records = TruckRecords::orderBy('date', 'asc')->where('driver_name', $request->id);
        $from = $request->from;
        $to = $request->to;
        if($request->from && $request->to){
            $records = $records->whereBetween('date', [$request->from, $request->to]);
        }
        $records = $records->get();
        $driver_info = Employee::find($request->id);
        return view('backend.report.driver-commission-print', compact( 'records', 'driver_info', 'from', 'to'));
    }
    public function driver_commission_update(Request $request){
        $records = $request->id;
        $commissions = $request->commission;
        // dd($records,$commissions);
        foreach($records as $key => $id){
            $truck_reocrd = TruckRecords::find($id);
            $truck_reocrd->commision = $commissions[$key];
            $truck_reocrd->save();
            $commission = DriverCommission::where('truck_record_id', $truck_reocrd->id)->first();
            if($commission){
                $commission->amount = $truck_reocrd->commision;
                $commission->save();
            }
        }
        return back()->with('success','Driver Commission Successfull');
    }

}
