<?php

namespace App\Http\Controllers\backend;
use App\Branch;
use App\Brand;
use App\Category;
use App\CostCenterType;
use App\DebitCreditVoucher;
use App\Http\Controllers\Controller;
use App\Product as ItemList;
use App\Journal;
use App\JournalRecord;
use App\Models\AccountHead;
use App\PartyInfo;
use App\PayMode;
use App\PayTerm;
use App\Product;
use App\ProjectDetail;
use App\Purchase;
use App\PurchaseItem;
use App\PurchaseTemp;
use App\PurchaseTempItem;
use App\Service;
use App\Stock;
use App\SubBrand;
use App\Unit;
use App\PaymentInvoice;
use App\Payment;
use App\Models\InvoiceNumber;
use Carbon\Carbon;
use Illuminate\Auth\Events\Failed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\MockObject\Stub\ReturnArgument;

class PurchaseController extends Controller
{
    public function index()
    {
        $delete_invoice_temp = PurchaseTemp::whereDate('created_at', '<', Carbon::today())->delete();
        $sub_invoice = Carbon::now()->format('Ymd');
        $latest_invoice_no = PurchaseTemp::whereDate('created_at', Carbon::today())->where('purchase_no', 'LIKE', "%{$sub_invoice}%")->orderBy('id','desc')->first();
        if ($latest_invoice_no) {
            $purchase_no = $latest_invoice_no->purchase_no + 1;
        } else {
            $purchase_no = Carbon::now()->format('Ymd') . '001';
        }
        $purchase = new PurchaseTemp;
        $purchase->purchase_no = $purchase_no;
        $purchase->save();
        $modes = PayMode::get();
        $terms = PayTerm::get();
        $branches = Branch::get();
        $customers = PartyInfo::get();
        $purchases = Purchase::orderBy('id','DESC')->paginate(25);
        $projects = ProjectDetail::get();
        $itms = ItemList::orderBy('id','ASC')->get();
        $latest = PartyInfo::withTrashed()->orderBy('id','DESC')->first();
        if ($latest) {
            $pi_code = preg_replace('/^PI-/', '', $latest->pi_code);
            ++$pi_code;
        } else {
            $pi_code = 1;
        }
        if ($pi_code < 10) {
            $cc = "PI-000" . $pi_code;
        } elseif ($pi_code < 100) {
            $cc = "PI-00" . $pi_code;
        } elseif ($pi_code < 1000) {
            $cc = "PI-0" . $pi_code;
        } else {
            $cc = "PI-" . $pi_code;
        }
        $costTypes = CostCenterType::get();
        $brands=Brand::get();
        $categories=Category::get();
        $gl_code=null;
        $unites=Unit::get();
        return view('backend.purchase.index', compact('unites','costTypes', 'cc', 'customers', 'modes', 'terms', 'branches', 'customers', 'purchase', 'purchases', 'projects', 'itms', 'gl_code','categories','brands'));
    }


    public function purchaseTemp(Request $request)
    {
        // return $request->all();
        $product = Product::find($request->product_id);
        // return $product;
        $project = ProjectDetail::where('id', $request->branch)->first();
        $temp = new PurchaseTempItem();
        $temp->purchase_no = $request->purchase_no;
        $temp->product_id = $product->id;
        $temp->barcode = $product->barcode;
        $temp->cat_id = $product->category_id;
        $temp->brand_id = $product->brand_id;
        $temp->sub_brand_id = $product->sub_brand;
        $temp->amount = $request->amount;
        $temp->unit = $product->unit_id;
        $temp->unit_price=$request->price;
        $temp->discount_price=$request->discount_price;
        $temp->price = $request->unit_price;
        $temp->vat = (5/100)*$temp->price;
        $temp->total_price = $temp->price+$temp->vat;
        // return $temp;
        $temp->save();
        $total_cost_price = PurchaseTempItem::where('purchase_no', $request->purchase_no)->sum('total_price');
        $vat_price = PurchaseTempItem::where('purchase_no', $request->purchase_no)->sum('vat');

        if ($request->ajax()) {
                return Response()->json([
                   'page' => view('backend.ajax.purchase', ['temp' => $temp, 'i' => 1])->render(),
                    'total_cost_price' => number_format((float)($total_cost_price), 2, '.', ''),
                    'vat_price' => number_format((float)($vat_price), 2, '.', ''),

                ]);
        }
    }

    public function previewSavePurchase(Request $request)
    {
        $old_date = explode('/', $request->date);
        $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));

        $invoice = PurchaseTemp::where('purchase_no', $request->purchase_no)->orderBy('id','DESC')->first();
        $invoice->date = $new_date;
        $invoice->project_id = $request->branch;
        $invoice->customer_name = $request->customer_name;
        $invoice->trn_no = $request->trn_no;
        $invoice->pay_mode = $request->pay_mode;
        $invoice->pay_terms = $request->pay_terms;
        $invoice->due_date = $request->due_date;
        $invoice->contact_no = $request->contact_no;
        $invoice->address = $request->address;
        $invoice->vehicle_no = $request->vehicle_no;
        $invoice->vehicle_make_model = $request->vehicle_make_model;
        $invoice->supplier_invoice = $request->supplier_invoice;

        $invoice->save();
        $amountFrom=$request->amount_from;
        $amountTo=$request->amount_to;

        return redirect()->route('PurchasePreview', [$invoice,$amountFrom,$amountTo])->with('success', 'Purchase Preview');
    }

    public function PurchasePreview($purchase)
    {

        $purchase=PurchaseTemp::where('id',$purchase)->first();
        if(!$purchase)
        {
            return redirect()->route('taxInvoIssue')->with('error', 'Page Not Found');

        }
        $items=PurchaseTempItem::where('purchase_no',$purchase->purchase_no)->orderBy('id','ASC')->get();
        $modes = PayMode::get();
        $terms = PayTerm::get();
        $branches = Branch::get();
        $customers = PartyInfo::get();
        $purchases = Purchase::orderBy('id','DESC')->paginate(25);
        $projects = ProjectDetail::get();
        // $gl_code = Mapping::where('fld_txn_type', "sale")->first();

        $i=1;
        return view('backend.purchase.purchasePreview',compact('purchase','items','modes','terms','branches','customers','purchases','projects','i'));

    }


    public function finalSavePurchase(Request $request)
    {
        $project = ProjectDetail::where('id', $request->branch)->first();
        $sub_invoice = Carbon::now()->format('Ymd');
        $latest_invoice_no = Purchase::whereDate('created_at', Carbon::today())->where('purchase_no', 'LIKE', "%{$sub_invoice}%")->orderBy('id','DESC')->first();

        if ($latest_invoice_no) {
            $invoice_no = $latest_invoice_no->purchase_no + 1;
        } else {
            $invoice_no = Carbon::now()->format('Ymd') . '001';
        }
        $old_date = explode('/', $request->date);
        $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));
        $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);
        $gl_code = null;
        $invoice = new Purchase();
        $invoice->purchase_no =  $invoice_no;
        $invoice->date = $new_date;
        $invoice->project_id = $request->branch;
        $invoice->customer_name = $request->customer_name;
        $invoice->trn_no = $request->trn_no;
        $invoice->pay_mode = $request->pay_mode;
        $invoice->pay_terms = $request->pay_terms;
        $invoice->due_date = $request->due_date;
        $invoice->total_price = $request->total_gross;
        $invoice->paid_price = $request->amount_from;
        $invoice->due_price = $request->amount_to;
        $invoice->discount_price = $request->discount_amount;
        $invoice->contact_no = $request->contact_no;
        $invoice->address = $request->address;
        $invoice->vehicle_no = $request->vehicle_no;
        $invoice->vehicle_make_model = $request->vehicle_make_model;
        $invoice->supplier_invoice = $request->supplier_invoice;
        $invoice->gl_code = $gl_code ? $gl_code->fld_ac_code : null;
        $invoice->save();
        $items = PurchaseTempItem::where('purchase_no', $request->invoice_no)->get();
        foreach ($items as $item) {
            $invoice_item = new PurchaseItem();
            $invoice_item->purchase_no =  $invoice_no;
            $invoice_item->date = $new_date;
            $invoice_item->purchase_id = $invoice->id;
            $invoice_item->product_id = $item->product_id;
            $invoice_item->barcode = $item->barcode;
            $invoice_item->cat_id = $item->cat_id;
            $invoice_item->brand_id = $item->brand_id;
            $invoice_item->sub_brand_id = $item->sub_brand_id;
            $invoice_item->amount = $item->amount;
            $invoice_item->unit = $item->unit;
            $invoice_item->unit_price = $item->unit_price;
            $invoice_item->price = $item->price;
            $invoice_item->vat = $item->vat;
            $invoice_item->total_price = $item->total_price;
            $invoice_item->discount_price = $item->discount_price;
            $invoice_item->service_id = $item->service_id;
            $invoice_item->save();

            $stock=Stock::where('product_id',$item->product_id)->first();
            if($stock) {
                $stock->pcs=$stock->pcs+$item->amount;
            } else {
                $stock=new Stock();
                $stock->product_id=$item->product_id;
                $stock->pcs=$stock->pcs+$item->amount;
            }
            $stock->save();
        }
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
        $p_info=PartyInfo::where('pi_code',$request->customer_name)->first();
        $journal=new Journal();
        $journal->transection_type  = "Purchase";
        $journal->transaction_type  = "Purchase";
        $journal->without_gst       = number_format((float)(  $invoice->taxableAmount()), 2,'.','');
        $journal->gst_subtotal      = number_format((float)(  $invoice->vatAmount()), 2,'.','');
        $journal->project_id=$project->id;
        $journal->journal_no=$jcode;
        $journal->date= $new_date;
        $journal->invoice_no=$invoice->purchase_no;
        $journal->pay_mode= $invoice->pay_mode;
        $journal->cost_center_id= 1;
        $journal->party_info_id= $p_info->id;
        $journal->account_head_id= 0;
        $journal->authorized= true;
        $journal->approved= true;
        $journal->amount= number_format((float)(  $invoice->TotalAmount()), 2,'.','');
        $journal->tax_rate= 5;
        $journal->vat_amount= number_format((float)(  $invoice->vatAmount()), 2,'.','');
        $journal->total_amount= number_format((float)(  $invoice->taxableAmount()), 2,'.','');
        $journal->narration= "Good Purchase on ". $invoice->pay_mode ;
        $journal->voucher_type='DR';
        $journal->created_by= Auth::id();
        $journal->authorized_by= Auth::id();
        $journal->approved_by= Auth::id();
        $journal->save();

        //Purchase Expense Account
        $purchase_head= AccountHead::find(22);
        $journal_temps = new JournalRecord();
        $journal_temps->journal_id = $journal->id;
        $journal_temps->project_details_id = $journal->project_id;
        $journal_temps->cost_center_id = 1;
        $journal_temps->party_info_id = $p_info->id;
        $journal_temps->journal_no = $journal->journal_no;
        $journal_temps->account_head_id = $purchase_head->id;
        $journal_temps->master_account_id = $purchase_head->master_account_id;
        $journal_temps->account_head = $purchase_head->fld_ac_head;
        $journal_temps->amount = $journal->total_amount+$invoice->discount_price;
        $journal_temps->transaction_type = "DR";
        $journal_temps->journal_date = $journal->date;
        $journal_temps->account_type_id     = $purchase_head->account_type_id;
        $journal_temps->gst_amount          = number_format((float)(  $invoice->taxableAmount()), 2,'.','');
        $journal_temps->gst_subtotal        = number_format((float)(  $invoice->vatAmount()), 2,'.','');
        $journal_temps->vat_rate_id         = 5;
        $journal_temps->invoice_no          = $invoice->purchase_no;
        $journal_temps->save();

        // liablity or payable account
        $purchase_head = AccountHead::find(5);
        $journal_temps = new JournalRecord();
        $journal_temps->journal_id = $journal->id;
        $journal_temps->project_details_id = $journal->project_id;
        $journal_temps->cost_center_id = 1;
        $journal_temps->party_info_id = $p_info->id;
        $journal_temps->journal_no = $journal->journal_no;
        $journal_temps->account_head_id = $purchase_head->id;
        $journal_temps->master_account_id = $purchase_head->master_account_id;
        $journal_temps->account_head = $purchase_head->fld_ac_head;
        $journal_temps->amount = $journal->amount;
        $journal_temps->transaction_type = "CR";
        $journal_temps->journal_date = $journal->date;
        $journal_temps->account_type_id     = $purchase_head->account_type_id;
        $journal_temps->gst_amount          = number_format((float)(  $invoice->taxableAmount()), 2,'.','');
        $journal_temps->gst_subtotal        = number_format((float)(  $invoice->vatAmount()), 2,'.','');
        $journal_temps->vat_rate_id         = 5;
        $journal_temps->invoice_no          = $invoice->purchase_no;
        $journal_temps->save();

        //Vat Payable Account dr
        $vat_head= AccountHead::find(17);
        $journal_temps=new JournalRecord();
        $journal_temps->journal_id=$journal->id;
        $journal_temps->project_details_id=$project->id;
        $journal_temps->cost_center_id=1;
        $journal_temps->party_info_id=$p_info->id;
        $journal_temps->journal_no= $journal->journal_no;
        $journal_temps->account_head_id= $vat_head->id;
        $journal_temps->master_account_id= $vat_head->master_account_id;
        $journal_temps->account_head= $vat_head->fld_ac_head;
        $journal_temps->amount=$journal->vat_amount;
        $journal_temps->transaction_type="DR";
        $journal_temps->journal_date= $journal->date;
        $journal_temps->account_type_id     = $vat_head->account_type_id;
        $journal_temps->gst_amount          = $journal->vat_amount;
        $journal_temps->gst_subtotal        = $journal->total_amount;
        $journal_temps->vat_rate_id         = 5;
        $journal_temps->invoice_no          = $invoice->purchase_no;
        $journal_temps->save();

        //debit credit voucher
        $dr_cr_voucher= new DebitCreditVoucher();
        $dr_cr_voucher->journal_id      = $journal->id;
        $dr_cr_voucher->project_id      =  $journal->project_id;
        $dr_cr_voucher->cost_center_id  = 1;
        $dr_cr_voucher->party_info_id   =  $journal->party_info_id;
        $dr_cr_voucher->account_head_id = 0;
        $dr_cr_voucher->pay_mode        = $journal->pay_mode;
        $dr_cr_voucher->amount          = $journal->total_amount;
        $dr_cr_voucher->narration       = $journal->narration;
        $dr_cr_voucher->type            = $journal->pay_mode=="Credit"? "JOURNAL":"CR";
        $dr_cr_voucher->date            = $journal->date;
        $dr_cr_voucher->save();

        // payment voucher
        if($invoice->paid_price>0){

            $sub_invoice = Carbon::now()->format('Y');
            $let_purch_exp = InvoiceNumber::where('payment_no', 'LIKE', "%{$sub_invoice}%")->first();
            if ($let_purch_exp) {
                $payment_no = substr($let_purch_exp->payment_no,2);
                $payment_no = $payment_no + 1;
                $payment_no = "PV".$payment_no;
            } else {
                $payment_no = "PV".Carbon::now()->format('Y') . '0001';
            }
            $payment = new Payment();
            $payment->date = $new_date;
            $payment->pay_mode =  $invoice->pay_mode;
            $payment->payment_no =  $payment_no;
            $payment->head_id = 0;
            $payment->total_amount = $invoice->paid_price;
            $payment->vat = 0;
            $payment->party_id =  $p_info->id;
            $payment->narration = 'Payment Voucher By '. $invoice->pay_mode;
            $payment->paid_amount = 0;
            $payment->due_amount = 0;
            $payment->status = 'Realised';
            $payment->voucher_file = null;
            $payment->extension = null;
            $payment->save();

            $purc_exp_itm = new PaymentInvoice();
            $purc_exp_itm->sale_id = $invoice->id;
            $purc_exp_itm->payment_id = $payment->id;
            $purc_exp_itm->total_amount = $payment->total_amount;
            $purc_exp_itm->vat = 0;
            $purc_exp_itm->amount = $payment->total_amount;
            $purc_exp_itm->party_id = $payment->party_id;
            $purc_exp_itm->save();

            $payment_invoice = InvoiceNumber::first();
            $payment_invoice->payment_no = $payment->payment_no;
            $payment_invoice->save();
        }
        // Opposit entry of journal
        if($invoice->paid_price>0 && ($invoice->pay_mode=='Cash' || $invoice->pay_mode=='Card')){

            $sub_invoice = Carbon::now()->format('Ymd');
            $latest_journal_no = Journal::withTrashed()->whereDate('created_at', Carbon::today())->where('journal_no', 'LIKE', "%{$sub_invoice}%")->orderBy('id', 'desc')->first();
            if ($latest_journal_no) {
                $journal_no = substr($latest_journal_no->journal_no,0,-1);
                $journal_code = $journal_no + 1;
                $journal_no = $journal_code . "J";
            } else {
                $journal_no = Carbon::now()->format('Ymd') . '001' . "J";
            }
            $journal= new Journal();
            $journal->transection_type  = "Payment";
            $journal->transaction_type  = "Payment";
            $journal->without_gst       = 0;
            $journal->gst_subtotal      = 0;
            $journal->project_id        = $invoice->project_id;
            $journal->journal_no        = $journal_no;
            $journal->date              = $invoice->date;
            $journal->pay_mode          = $invoice->pay_mode;
            $journal->invoice_no        = $invoice->purchase_no;
            $journal->cost_center_id    = 1;
            $journal->party_info_id     = $p_info->id;
            $journal->account_head_id   = 0;
            $journal->amount            = $invoice->paid_price+$invoice->discount_price;
            $journal->tax_rate          = 0;
            $journal->vat_amount        = 0;
            $journal->total_amount      = $invoice->paid_price+$invoice->discount_price;
            $journal->narration         = 'Payment to 3rd party supplier by '. $invoice->pay_mode;
            $journal->created_by        = Auth::id();
            $journal->voucher_type      = 'default';
            $journal->authorized        = 1;
            $journal->approved          = 1;
            $journal->authorized_by     = Auth::id();
            $journal->approved_by       = Auth::id();
            $journal->save();
            if($invoice->pay_mode=='Cash'){
                $ac_head= AccountHead::find(1); // cash account
            }else{
                $ac_head= AccountHead::find(2); // bank account
            }
            $jl_record= new JournalRecord();
            $jl_record->journal_id          = $journal->id;
            $jl_record->project_details_id  = $invoice->project_id;
            $jl_record->cost_center_id      = 1;
            $jl_record->party_info_id       = $p_info->id;
            $jl_record->journal_no          = $journal->journal_no;
            $jl_record->account_head_id     = $ac_head->id;
            $jl_record->master_account_id   = $ac_head->master_account_id;
            $jl_record->account_head        = $ac_head->fld_ac_head;
            $jl_record->amount              = $invoice->paid_price;
            $jl_record->total_amount        = $invoice->paid_price;
            $jl_record->transaction_type    = 'CR';
            $jl_record->journal_date        = $invoice->date;
            $jl_record->account_type_id     = $ac_head->account_type_id;
            $jl_record->gst_amount          = 0;
            $jl_record->gst_subtotal        = 0;
            $jl_record->vat_rate_id         = 0;
            $jl_record->invoice_no          = $invoice->purchase_no;
            $jl_record->save();
            if($invoice->discount_price>0){
                $ac_head= AccountHead::find(23);
                $jl_record= new JournalRecord();
                $jl_record->journal_id          = $journal->id;
                $jl_record->project_details_id  = $invoice->project_id;
                $jl_record->cost_center_id      = 1;
                $jl_record->party_info_id       = $p_info->id;
                $jl_record->journal_no          = $journal->journal_no;
                $jl_record->account_head_id     = $ac_head->id;
                $jl_record->master_account_id   = $ac_head->master_account_id;
                $jl_record->account_head        = $ac_head->fld_ac_head;
                $jl_record->amount              = $invoice->discount_price;
                $jl_record->total_amount        = $invoice->discount_price;
                $jl_record->transaction_type    = 'CR';
                $jl_record->journal_date        = $invoice->date;
                $jl_record->account_type_id     = $ac_head->account_type_id;
                $jl_record->gst_amount          = 0;
                $jl_record->gst_subtotal        = 0;
                $jl_record->vat_rate_id         = 0;
                $jl_record->invoice_no          = $invoice->purchase_no;
                $jl_record->save();
            }
            // payable account
            $acc_head= AccountHead::find(5);
            $jl_record= new JournalRecord();
            $jl_record->journal_id     = $journal->id;
            $jl_record->project_details_id  = $invoice->project_id;
            $jl_record->cost_center_id      = 1;
            $jl_record->party_info_id       = $p_info->id;
            $jl_record->journal_no          = $journal->journal_no;
            $jl_record->account_head_id     = $acc_head->id;
            $jl_record->master_account_id   = $acc_head->master_account_id;
            $jl_record->account_head        = $acc_head->fld_ac_head;
            $jl_record->amount              = $invoice->paid_price+$invoice->discount_price;
            $jl_record->total_amount        = $invoice->paid_price+$invoice->discount_price;
            $jl_record->transaction_type    = 'DR';
            $jl_record->account_type_id     = $acc_head->account_type_id;
            $jl_record->journal_date        = $invoice->date;
            $jl_record->gst_amount          = 0;
            $jl_record->gst_subtotal        = 0;
            $jl_record->vat_rate_id         = 0;
            $jl_record->invoice_no          = $invoice->purchase_no;
            $jl_record->save();

            $voucher_type="DR";
            if( $invoice->pay_mode  == 'Cash' || $invoice->pay_mode  == 'Card'){
                // if it is expense or asset
                $voucher_type = 'DR';
            }elseif($invoice->pay_mode  == 'Credit'){
                $voucher_type            = 'JOURNAL';
            }
            $journal->voucher_type          = $voucher_type;
            $journal->save();
            $dr_cr_voucher= new DebitCreditVoucher();
            $dr_cr_voucher->journal_id      = $journal->id;
            $dr_cr_voucher->project_id      = $invoice->project_id;
            $dr_cr_voucher->cost_center_id  = 1;
            $dr_cr_voucher->party_info_id   = $p_info->id;
            $dr_cr_voucher->account_head_id = 0;
            $dr_cr_voucher->pay_mode        = $invoice->pay_mode ;
            $dr_cr_voucher->amount          = $invoice->paid_price+$invoice->discount_price;
            $dr_cr_voucher->narration       = 'Payment to 3rd party supplier '. $invoice->pay_mode ;
            $dr_cr_voucher->type            = $voucher_type;
            $dr_cr_voucher->date            = $invoice->date;
            $dr_cr_voucher->save();

        }elseif($invoice->discount_price>0){
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
            $journal->transection_type  = "Purchase Payment";
            $journal->transaction_type  = "Purchase Payment";
            $journal->without_gst       = 0;
            $journal->gst_subtotal      = 0;
            $journal->project_id        = $invoice->project_id;
            $journal->journal_no        = $journal_no;
            $journal->date              = $invoice->date;
            $journal->pay_mode          = $invoice->pay_mode;
            $journal->invoice_no        = $invoice->purchase_no;
            $journal->cost_center_id    = 1;
            $journal->party_info_id     = $p_info->id;
            $journal->account_head_id   = 0;
            $journal->amount            = $invoice->discount_price;
            $journal->tax_rate          = 0;
            $journal->vat_amount        = 0;
            $journal->total_amount      = $invoice->discount_price;
            $journal->narration         = 'Payment to 3rd party supplier by '. $invoice->pay_mode;
            $journal->created_by        = Auth::id();
            $journal->voucher_type      = 'default';
            $journal->authorized        =1;
            $journal->approved          =1;
            $journal->authorized_by     = Auth::id();
            $journal->approved_by       = Auth::id();
            $journal->save();
            $ac_head= AccountHead::find(23);
            $jl_record= new JournalRecord();
            $jl_record->journal_id          = $journal->id;
            $jl_record->project_details_id  = $invoice->project_id;
            $jl_record->cost_center_id      = 1;
            $jl_record->party_info_id       = $p_info->id;
            $jl_record->journal_no          = $journal->journal_no;
            $jl_record->account_head_id     = $ac_head->id;
            $jl_record->master_account_id   = $ac_head->master_account_id;
            $jl_record->account_head        = $ac_head->fld_ac_head;
            $jl_record->amount              = $invoice->discount_price;
            $jl_record->total_amount        = $invoice->discount_price;
            $jl_record->transaction_type    = 'CR';
            $jl_record->journal_date        = $invoice->date;
            $jl_record->account_type_id     = $ac_head->account_type_id;
            $jl_record->gst_amount          = 0;
            $jl_record->gst_subtotal        = 0;
            $jl_record->vat_rate_id         = 0;
            $jl_record->invoice_no          = $invoice->purchase_no;
            $jl_record->save();

            $acc_head= AccountHead::find(5);
            $jl_record= new JournalRecord();
            $jl_record->journal_id     = $journal->id;
            $jl_record->project_details_id  = $invoice->project_id;
            $jl_record->cost_center_id      = 1;
            $jl_record->party_info_id       = $p_info->id;
            $jl_record->journal_no          = $journal->journal_no;
            $jl_record->account_head_id     = $acc_head->id;
            $jl_record->master_account_id   = $acc_head->master_account_id;
            $jl_record->account_head        = $acc_head->fld_ac_head;
            $jl_record->amount              = $invoice->discount_price;
            $jl_record->total_amount        = $invoice->discount_price;
            $jl_record->transaction_type    = 'DR';
            $jl_record->account_type_id     = $acc_head->account_type_id;
            $jl_record->journal_date        = $invoice->date;
            $jl_record->gst_amount          = 0;
            $jl_record->gst_subtotal        = 0;
            $jl_record->vat_rate_id         = 0;
            $jl_record->invoice_no          = $invoice->purchase_no;
            $jl_record->save();
            $voucher_type="DR";
            if( $invoice->pay_mode  == 'Cash' || $invoice->pay_mode  == 'Card'){
                // if it is expense or asset
                $voucher_type = 'DR';
            }elseif($invoice->pay_mode  == 'Credit'){
                $voucher_type            = 'JOURNAL';
            }
            $journal->voucher_type          = $voucher_type;
            $journal->save();
            $dr_cr_voucher= new DebitCreditVoucher();
            $dr_cr_voucher->journal_id      = $journal->id;
            $dr_cr_voucher->project_id      = $invoice->project_id;
            $dr_cr_voucher->cost_center_id  = 1;
            $dr_cr_voucher->party_info_id   = $p_info->id;
            $dr_cr_voucher->account_head_id = 0;
            $dr_cr_voucher->pay_mode        = $invoice->pay_mode ;
            $dr_cr_voucher->amount          = $invoice->discount_price;
            $dr_cr_voucher->narration       = 'Payment to 3rd party supplier '. $invoice->pay_mode ;
            $dr_cr_voucher->type            = $voucher_type;
            $dr_cr_voucher->date            = $invoice->date;
            $dr_cr_voucher->save();
        }
          //end journal
        return redirect()->route('purchaseView', $invoice)->with('success', 'Succesfully Generated');
    }


    public function purchaseView($invoice)
    {
        $purchase = Purchase::where('id', $invoice)->first();
        $modes = PayMode::get();
        $terms = PayTerm::get();
        $branches = Branch::get();
        $customers = PartyInfo::get();
        $purchases = Purchase::orderBy('id','DESC')->paginate(25);
        $projects = ProjectDetail::get();
        $itms = ItemList::get();
        $i = 0;
        // dd(1);
        return view('backend.purchase.purchaseView', compact('purchase', 'modes', 'terms', 'branches', 'customers', 'purchases', 'projects', 'itms', 'i'));
    }

    public function purchasePrint($invoice)
    {
        // dd(1);
        $invoice = Purchase::where('id', $invoice)->first();
        // return $invoice;

            return view('backend.purchase.purchasePrint', compact('invoice'));

    }

    public function itemPurchDelete($item, Request $request)
    {
        $itm = PurchaseTempItem::where('id', $item)->first();
        $invoice_no = $itm->purchase_no;
        $itm->delete();
        $temp = PurchaseTemp::where('purchase_no', $invoice_no)->orderBy('id','DESC')->first();
        // if ($request->ajax()) {
        //     return Response()->json([
        //         'page' => view('backend.ajax.invoice', ['invoice_draft' => $invoice_draft, 'i' => 1])->render(),
        //         'total_cost_price' => $total_cost_price,

        //     ]);
        // }

        $total_cost_price = PurchaseTempItem::where('purchase_no', $request->purchase_no)->sum('total_price');
        if ($request->ajax()) {
                return Response()->json([
                   'page' => view('backend.ajax.purchase', ['temp' => $temp, 'i' => 1])->render(),
                    'total_cost_price' => number_format((float)($total_cost_price), 2, '.', ''),
                ]);
        }
    }


    public function searchPurchase(Request $request)
    {
        // return $request->all();
        $purchases = Purchase::where('purchase_no', 'LIKE', "%{$request->value}%")->get();

        // $invoicess=Invoice::orderBy('id','DESC')->paginate(25);

        if ($request->ajax()) {
            return Response()->json([
                'page' => view('backend.ajax.purchaseRight', ['purchases' => $purchases, 'i' => 1])->render()
            ]);
        }
    }

    public function refresh_purchase(Request $request)
    {
        $purchases = Purchase::orderBy('id','DESC')->paginate(25);
        if ($request->ajax()) {
            return Response()->json([
                'page' => view('backend.ajax.purchaseRight', ['purchases' => $purchases, 'i' => 1])->render()
            ]);
        }
    }

    public function purchaseDuePay(Request $request)
    {
        // return $request->all();

        $purchase=Purchase::where('id',$request->purchase_due_id)->first();
        if($purchase->due_price<$request->due)
        {
            return Response()->json(['error' =>"Wrong Entry"]);
        }
        $purchase->paid_price=$request->due+$purchase->paid_price;
        $purchase->due_price=$purchase->due_price-$request->due;
        $purchase->save();
        if ($request->ajax()) {

                return Response()->json([
                    'paid' => number_format((float)($purchase->paid_price), 2, '.', ''),
                    'due' => number_format((float)($purchase->due_price), 2, '.', '')

                ]);

        }
    }

    public function report(Request $request)
    {
        $date=null;
        $from=null;
        $to=null;

        if($request->date)
        {
            $old_date = explode('/', $request->date);
            $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
            $new_date = date('Y-m-d', strtotime($new_data));
            // $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);

            $purchases=Purchase::where('date', $new_date)->orderBy('id','DESC')->get();
            $date=$new_date;
        }
        elseif($request->from)
        {
            $old_date = explode('/', $request->from);
            $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
            $new_date = date('Y-m-d', strtotime($new_data));
            $old_date2 = explode('/', $request->to);
            $new_data2 = $old_date2[0].'-'.$old_date2[1].'-'.$old_date2[2];
            $new_date2 = date('Y-m-d', strtotime($new_data2));

            $purchases=Purchase::where('date','>=', $new_date)->where('date','<=', $new_date2)->orderBy('id','DESC')->get();
            $from=$new_date;
            $to=$new_date2;
        }
        else
        {
            $purchases=Purchase::where('date', date('Y-m-d'))->orderBy('id','DESC')->get();
        }

        return view('backend.report.purchaseReport',compact('purchases','date','from','to'));
    }


    public function purchasePrintDate($date)
    {
        $time = strtotime($date);
        $searchDate = date('m/d/Y',$time);
        $date=$date;
        $purchases=Purchase::where('date',$date)->get();
        return view('backend.report.purchasePrint',compact('purchases','searchDate'));
    }

    public function purchasePrintreport2()
    {
        // dd(1);
        $date=date('Y-m-d');
        $time = strtotime($date);
        $searchDate = date('m/d/Y',$time);
        $purchases=Purchase::where('date', date('Y-m-d'))->orderBy('id','DESC')->get();
        return view('backend.report.purchasePrint',compact('purchases','searchDate'));
    }

    public function purchasePrintRange($from,$to)
    {
        $date=$from;
        $time = strtotime($date);
        $searchDate = date('m/d/Y',$time);
        $date=$to;
        $time = strtotime($date);
        $searchDateto = date('m/d/Y',$time);
        $purchases=Purchase::where('date','>=', $from)->where('date','<=', $to)->orderBy('id','DESC')->get();
        return view('backend.report.purchasePrint',compact('purchases','searchDate','searchDateto'));
    }

  // work by mominul
     public function party_wish_report(Request $request){
        $parties = PartyInfo::all();
        $partyInfo = null;
        $purchase_lists = null;
        if($request->party_name){
            $partyInfo = PartyInfo::find($request->party_name);
            $partyInfo = $partyInfo;
            $purchase_lists = Purchase::where('customer_name', $partyInfo->pi_code)->get();
        }
        return view('backend.report.party-wish-report', compact('parties', 'purchase_lists', 'partyInfo'));
    }
    public function purchase_due_payment(Request $request){
        $due_purchases = Purchase::where('due_price', '>', 0)->get();
        return view('backend.purchase.purchase-due-payment', compact('due_purchases'));
    }

    public function purchase_due_pay($id){
        $purchases = Purchase::find($id);
        $items = PurchaseItem::where('purchase_id', $purchases->id)->get();
        $modes = PayMode::get();
        return view('backend.purchase.purchase-due-pay', compact('purchases', 'items', 'modes'));
    }
    public function final_due_payment(Request $request){
        // dd($request->all());
        $purchase = Purchase::find($request->purchase_id);
        $purchase->paid_price = $purchase->paid_price + $request->due_amount;
        $purchase->due_price = $purchase->due_price - $request->due_amount;
        $purchase->save();

        $party_info = PartyInfo::where('pi_code', $purchase->customer_name)->first();
        $old_date = explode('/', $request->date);
        $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));

        $sub_invoice = Carbon::now()->format('Y');
        $let_purch_exp = InvoiceNumber::where('payment_no', 'LIKE', "%{$sub_invoice}%")->first();
        if ($let_purch_exp) {
            $payment_no = substr($let_purch_exp->payment_no,2);
            $payment_no = $payment_no + 1;
            $payment_no = "PV".$payment_no;
        } else {
            $payment_no = "PV".Carbon::now()->format('Y') . '0001';
        }
        $payment = new Payment();
        $payment->date = $new_date;
        $payment->pay_mode =  $request->pay_mode;
        $payment->payment_no =  $payment_no;
        $payment->head_id = 0;
        $payment->total_amount = $request->due_amount;
        $payment->vat = 0;
        $payment->party_id =  $party_info->id;
        $payment->narration = 'Payment Voucher By '. $request->pay_mode;
        $payment->paid_amount = 0;
        $payment->due_amount = 0;
        $payment->status = 'Realised';
        $payment->voucher_file = null;
        $payment->extension = null;
        $payment->save();

        $purc_exp_itm = new PaymentInvoice();
        $purc_exp_itm->sale_id = $purchase->id;
        $purc_exp_itm->payment_id = $payment->id;
        $purc_exp_itm->total_amount = $payment->total_amount;
        $purc_exp_itm->vat = 0;
        $purc_exp_itm->amount = $payment->total_amount;
        $purc_exp_itm->party_id = $payment->party_id;
        $purc_exp_itm->save();

        $payment_invoice = InvoiceNumber::first();
        $payment_invoice->payment_no = $payment->payment_no;
        $payment_invoice->save();

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
        $journal->transection_type  = "Due Purchase Payment";
        $journal->transaction_type  = "Due Purchase Payment";
        $journal->without_gst       = 0;
        $journal->gst_subtotal      = 0;
        $journal->project_id        = $purchase->project_id;
        $journal->journal_no        = $journal_no;
        $journal->date              = $new_date;
        $journal->invoice_no        = 0;
        $journal->cost_center_id    = 1;
        $journal->party_info_id     = $purchase->partyInfo($purchase->customer_name)->id;
        $journal->account_head_id   = 0;
        $journal->amount            = $request->due_amount;
        $journal->tax_rate          = 0;
        $journal->vat_amount        = 0;
        $journal->total_amount      = $request->due_amount;
        $journal->narration         = 'Purchase Due Payment';
        $journal->pay_mode          = $request->pay_mode;
        $journal->voucher_type      = 'DR';
        $journal->authorized        = 1;
        $journal->approved          = 1;
        $journal->created_by        = Auth::id();
        $journal->authorized_by     = Auth::id();
        $journal->approved_by       = Auth::id();
        $journal->save();

        $ac_head_dr= AccountHead::find(5);

        $jl_record= new JournalRecord();
        $jl_record->journal_id          = $journal->id;
        $jl_record->project_details_id  = $purchase->project_id;
        $jl_record->cost_center_id      = 1;
        $jl_record->party_info_id       = $purchase->partyInfo($purchase->customer_name)->id;
        $jl_record->journal_no          = $journal_no;
        $jl_record->account_head_id     = $ac_head_dr->id;
        $jl_record->master_account_id   = $ac_head_dr->master_account_id;
        $jl_record->account_head        = $ac_head_dr->fld_ac_head;
        $jl_record->amount              = $request->due_amount;
        $jl_record->transaction_type    = 'DR';
        $jl_record->journal_date        = $new_date;
        $jl_record->account_type_id     = $ac_head_dr->account_type_id;
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
        $jl_record->project_details_id  = $purchase->project_id;
        $jl_record->cost_center_id      = 1;
        $jl_record->party_info_id       = $purchase->partyInfo($purchase->customer_name)->id;
        $jl_record->journal_no          = $journal_no;
        $jl_record->account_head_id     = $ac_head_cr->id;
        $jl_record->master_account_id   = $ac_head_cr->master_account_id;
        $jl_record->account_head        = $ac_head_cr->fld_ac_head;
        $jl_record->amount              = $request->due_amount;
        $jl_record->transaction_type    = 'CR';
        $jl_record->journal_date        = $new_date;
        $jl_record->account_type_id     = $ac_head_cr->account_type_id;
        $jl_record->gst_amount          = 0;
        $jl_record->gst_subtotal        = 0;
        $jl_record->vat_rate_id         = 0;
        $jl_record->invoice_no          = 'n/a';
        $jl_record->save();

        $dr_cr_voucher= new DebitCreditVoucher();
        $dr_cr_voucher->journal_id      = $journal->id;
        $dr_cr_voucher->project_id      =  $journal->project_id;
        $dr_cr_voucher->cost_center_id  =  $journal->cost_center_id ;
        $dr_cr_voucher->party_info_id   =  $journal->party_info_id;
        $dr_cr_voucher->account_head_id = 0;
        $dr_cr_voucher->pay_mode        = $journal->pay_mode;
        $dr_cr_voucher->amount          = $journal->total_amount;
        $dr_cr_voucher->narration       = $journal->narration;
        $dr_cr_voucher->type            = 'DR';
        $dr_cr_voucher->date            = $journal->date;
        $dr_cr_voucher->save();
        return redirect()->route('purchase-due-payment')->with('success', 'Payment Successful');

    }
}
