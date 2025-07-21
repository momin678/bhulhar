<?php

namespace App\Http\Controllers\backend;

use App\Asset;
use App\AssetType;
use App\DebitCreditVoucher;
use App\Fifo;
use App\Http\Controllers\Controller;
use App\ItemList;
use App\Journal;
use App\JournalRecord;
use App\Models\AccountHead;
use App\Models\MasterAccount;
use App\Models\MstACType;
use App\MstCatType;
use App\PartyInfo;
use App\Stock;
use App\StockTransection;
use App\VatRate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpeningBalanceController extends Controller
{
    public function opening_asset()
    {
        $types=AssetType::get();
        return view('backend.opening-balance.opening-asset',compact('types'));
    }

    public function opening_asset_store(Request $request)
    {
        // dd($request->all());
        $total_dr=0;
        $total_cr=0;
        // **************************************************
        $sub_invoice = Carbon::now()->format('Ymd');
        $latest_journal_no = Journal::withTrashed()->whereDate('created_at', Carbon::today())->where('journal_no', 'LIKE', "%{$sub_invoice}%")->orderBy('id','desc')->first();
        if ($latest_journal_no) {
            $journal_no = substr($latest_journal_no->journal_no,0,-1);
            $journal_code = $journal_no + 1;
            $journal_no = $journal_code . "J";
        } else {
            $journal_no = Carbon::now()->format('Ymd') . '001' . "J";
        }

        // return $journal_no;
        $journal= new Journal();
        $journal->project_id        = 1;
        $journal->journal_no        = $journal_no;
        $journal->date              = $request->date;
        $journal->pay_mode          = 'NonCash';
        $journal->invoice_no        = 'opening-0';
        $journal->cost_center_id    = 1;
        $journal->party_info_id     = 1;
        $journal->account_head_id   = 123;
        $journal->amount            =  $request->total_amount;
        $journal->tax_rate          = 0;
        $journal->vat_amount        = 0;
        $journal->total_amount      =  $journal->amount;
        $journal->narration         = 'Opening Asset by '. $journal->pay_mode;
        $journal->created_by        = Auth::id();
        $journal->authorized_by=Auth::id();
        $journal->approved_by=Auth::id();
        $journal->authorized        = 1;
        $journal->approved        = 1;
        $journal->voucher_type      = 'default.jpg';
        $journal->opening_balance_entry      = 1;

        $journal->save();
        // **************************************************
        $multi_head=$request->input('group-a');

        foreach($multi_head as $each_head){
            $masterAcc=MasterAccount::where('asset_type_id',$each_head['type'])->where('depreciation',false)->first();
            $masterAcc2=MasterAccount::where('asset_type_id',$each_head['type'])->where('depreciation',true)->first();

            if(!$masterAcc)
            {
                $typeCat = MstACType::where('id', 1)->first();
                $cat = MstCatType::where('id', 1)->latest()->first();
                $latest_master = MasterAccount::withTrashed()->whereBetween('mst_ac_code', [$cat->value, $cat->value + 99])->orderBy('id','DESC')->first();
                $masterAcc = new MasterAccount;
                if ($latest_master) {
                    $masterAcc->mst_ac_code = $latest_master->mst_ac_code + 1;
                } else {
                    $masterAcc->mst_ac_code = $cat->value;
                }

                $asset_type=AssetType::find($each_head['type']);
                $masterAcc->mst_ac_head     = $asset_type->title;
                $masterAcc->asset_type_id     = $asset_type->id;
                $masterAcc->account_type_id = 1;
                $masterAcc->mst_definition  = 'Fixed Asset';
                $masterAcc->mst_ac_type     = 1;
                $masterAcc->vat_type        = 'N/A';
                $masterAcc->reserved        = 0;
                $masterAcc->category_id     = 1;
                $masterAcc->save();
                $latest_master = MasterAccount::withTrashed()->whereBetween('mst_ac_code', [$cat->value, $cat->value + 99])->orderBy('id','DESC')->first();
                $masterAcc2 = new MasterAccount;
                if ($latest_master) {
                    $masterAcc2->mst_ac_code = $latest_master->mst_ac_code + 1;
                } else {
                    $masterAcc2->mst_ac_code = $cat->value;
                }

                $asset_type=AssetType::find($each_head['type']);
                $masterAcc2->mst_ac_head     = 'Accomulated Depreciation-'.$asset_type->title;
                $masterAcc2->asset_type_id     = $asset_type->id;
                $masterAcc2->account_type_id = 1;
                $masterAcc2->mst_definition  = 'Fixed Asset';
                $masterAcc2->mst_ac_type     = 1;
                $masterAcc2->vat_type        = 'N/A';
                $masterAcc2->reserved        = 0;
                $masterAcc2->category_id     = 1;
                $masterAcc2->depreciation     = 1;
                $masterAcc2->save();
            }
            $asset=new Asset();
            $asset->name= $each_head['item_name'];
            $asset->asset_no=0;
            $asset->purchase_no= 0;
            $asset->purchase_date= $request->date;
            $asset->purchase_id=0;
            $asset->description= $each_head['description'];
            $asset->cost_value=$each_head['cost_price'];
            $asset->recognition=$each_head['recognition'];
            $asset->salvage_value=$each_head['salvage_value'];
            $asset->depratiation_value=$each_head['cost_price']-$each_head['salvage_value']-$each_head['previouse_depreciation'];
            $asset->acommulated_depreciation=$each_head['previouse_depreciation'];
            $asset->depratiation=$asset->depratiation_value/($each_head['period']*12);
            $asset->depratiation_period=$each_head['period'];
            $asset->asset_type=$each_head['type'];
            $dateee=Carbon::createFromFormat('Y-m-d',  $each_head['recognition']);
            $asset->next_depretiation= $dateee->format('Y-m-t');

            $asset->final_date= $dateee->addYears($each_head['period']);
            $asset->net_book_value=  $asset->cost_value;
            $asset->latest_depretiation=  $each_head['recognition'];
            $asset->save();
            $accHeadL = AccountHead::where('ma_code', $masterAcc->mst_ac_code)->latest()->first();
            $accHead = new AccountHead();
            if ($accHeadL) {
                $accHead->ac_code = $accHeadL->ac_code + 1;
            } else {
                $accHead->ac_code = 100;
            }
            $accHead->ma_code = $masterAcc->mst_ac_code;
            $accHead->fld_ac_head = $asset->name;
            $accHead->fld_ac_code = $masterAcc->mst_ac_code . "-" . $accHead->ac_code;
            $accHead->fld_ms_ac_head = $masterAcc->mst_ac_head;
            $accHead->fld_definition = $masterAcc->mst_definition;
            $accHead->account_type_id= $masterAcc->account_type_id;
            $accHead->master_account_id= $masterAcc->id;
            $accHead->asset_id = $asset->id;
            $accHead->save();
            $accHeadL = AccountHead::where('ma_code', $masterAcc2->mst_ac_code)->latest()->first();
            $accHead = new AccountHead();
            if ($accHeadL) {
                $accHead->ac_code = $accHeadL->ac_code + 1;
            } else {
                $accHead->ac_code = 100;
            }
            $accHead->ma_code = $masterAcc2->mst_ac_code;
            $accHead->fld_ac_head = 'Accomulated Depreciation-'.$asset->name;
            $accHead->fld_ac_code = $masterAcc2->mst_ac_code . "-" . $accHead->ac_code;
            $accHead->fld_ms_ac_head = $masterAcc2->mst_ac_head;
            $accHead->fld_definition = $masterAcc2->mst_definition;
            $accHead->account_type_id= $masterAcc2->account_type_id;
            $accHead->master_account_id= $masterAcc2->id;
            $accHead->asset_id = $asset->id;
            $accHead->depreciation     = 1;
            $accHead->save();

            $dr_acc_head= AccountHead::where('asset_id',$asset->id)->first();
            $jl_record= new JournalRecord();
            $jl_record->journal_id     = $journal->id;
            $jl_record->project_details_id  = 1;
            $jl_record->cost_center_id      = 1;
            $jl_record->party_info_id       = 1;
            $jl_record->journal_no          = $journal_no;
            $jl_record->account_head_id     = $dr_acc_head->id;
            $jl_record->master_account_id   = $dr_acc_head->master_account_id;
            $jl_record->account_head        = $dr_acc_head->fld_ac_head;
            $jl_record->amount              = $asset->cost_value;
            $jl_record->total_amount        = $jl_record->amount ;
            $jl_record->vat_rate_id         = 1;
            $jl_record->transaction_type    = 'DR';
            $jl_record->journal_date        =  $journal->date;
            $jl_record->account_type_id = $dr_acc_head->account_type_id;
            $jl_record->is_main_head        = 1;
            $jl_record->opening_balance_entry        = 1;
            $jl_record->save();

            if($each_head['previouse_depreciation']>0)
           {
            $cr_acc_head= AccountHead::where('asset_id',$asset->id)->where('depreciation',true)->first();
            $jl_record= new JournalRecord();
            $jl_record->journal_id     = $journal->id;
            $jl_record->project_details_id  = 1;
            $jl_record->cost_center_id      = 1;
            $jl_record->party_info_id       = 1;
            $jl_record->journal_no          = $journal_no;
            $jl_record->account_head_id     = $cr_acc_head->id;
            $jl_record->master_account_id   = $cr_acc_head->master_account_id;
            $jl_record->account_head        = $cr_acc_head->fld_ac_head;
            $jl_record->amount              = $each_head['previouse_depreciation'];
            $jl_record->total_amount        = $jl_record->amount ;
            $jl_record->vat_rate_id         = 1;
            $jl_record->transaction_type    = 'CR';
            $jl_record->journal_date        =  $journal->date;
            $jl_record->account_type_id = $cr_acc_head->account_type_id;
            $jl_record->is_main_head        = 1;
            $jl_record->opening_balance_entry      = 1;
            $jl_record->save();
            $total_cr=$total_cr+$each_head['previouse_depreciation'];
           }
            $total_dr=$total_dr+$asset->cost_value;
        }

        if($total_dr!=$total_cr)
        {
            $adjustment= AccountHead::find(771);
            $jl_record= new JournalRecord();
            $jl_record->journal_id     = $journal->id;
            $jl_record->project_details_id  = 1;
            $jl_record->cost_center_id      = 1;
            $jl_record->party_info_id       = 1;
            $jl_record->journal_no          = $journal_no;
            $jl_record->account_head_id     = $adjustment->id;
            $jl_record->master_account_id   = $adjustment->master_account_id;
            $jl_record->account_head        = $adjustment->fld_ac_head;
            $jl_record->amount              = $total_dr>$total_cr ? ($total_dr-$total_cr):($total_cr>$total_dr);
            $jl_record->total_amount        = $jl_record->amount ;
            $jl_record->vat_rate_id         = 1;
            $jl_record->transaction_type    = $total_dr>$total_cr ? 'CR':'DR';
            $jl_record->journal_date        =  $journal->date;
            $jl_record->account_type_id = $adjustment->account_type_id;
            $jl_record->is_main_head        = 1;
            $jl_record->opening_balance_entry      = 1;
            $jl_record->save();
        }
        $dr_cr_voucher= new DebitCreditVoucher();
        $dr_cr_voucher->journal_id      = $journal->id;
        $dr_cr_voucher->project_id      =  $journal->project_id;
        $dr_cr_voucher->cost_center_id  = 1;
        $dr_cr_voucher->party_info_id   =  $journal->party_info_id;
        $dr_cr_voucher->account_head_id = 0;
        $dr_cr_voucher->pay_mode        = $journal->pay_mode;
        $dr_cr_voucher->amount          = $journal->total_amount;
        $dr_cr_voucher->narration       = $journal->narration;
        $dr_cr_voucher->type            =  'Opening Asset Entry';
        $dr_cr_voucher->date            = $journal->date;
        $dr_cr_voucher->save();

        return back()->with('success',"Successfully Added");
    }



    public function opening_expence()
    {
        return view('backend.opening-balance.opening-expense');
    }


    public function opening_expense_store(Request $request)
    {

        $total_dr=0;
        $total_cr=0;
        // **************************************************
        $sub_invoice = Carbon::now()->format('Ymd');
        $latest_journal_no = Journal::withTrashed()->whereDate('created_at', Carbon::today())->where('journal_no', 'LIKE', "%{$sub_invoice}%")->orderBy('id','desc')->first();
        if ($latest_journal_no) {
            $journal_no = substr($latest_journal_no->journal_no,0,-1);
            $journal_code = $journal_no + 1;
            $journal_no = $journal_code . "J";
        } else {
            $journal_no = Carbon::now()->format('Ymd') . '001' . "J";
        }
        // return $journal_no;
        $journal= new Journal();
        $journal->project_id        = 1;
        $journal->journal_no        = $journal_no;
        $journal->date              = $request->date;
        $journal->pay_mode          = 'NonCash';
        $journal->invoice_no        = 'opening-0';
        $journal->cost_center_id    = 1;
        $journal->party_info_id     = 1;
        $journal->account_head_id   = 123;
        $journal->amount            =  $request->total_amount;
        $journal->tax_rate          = 0;
        $journal->vat_amount        = 0;
        $journal->total_amount      =  $journal->amount;
        $journal->narration         = 'Opening Expense By-'. $journal->pay_mode;
        $journal->created_by        = Auth::id();
        $journal->authorized_by=Auth::id();
        $journal->approved_by=Auth::id();
        $journal->authorized        = 1;
        $journal->approved        = 1;
        $journal->voucher_type      = 'default.jpg';
        $journal->opening_balance_entry      = 1;

        $journal->save();
        // **************************************************
        $multi_head=$request->input('group-a');

        foreach($multi_head as $each_head){
            $accHead=AccountHead::where('master_account_id',4)->where('fld_ac_head','like', "%{$each_head['item_name']}%")->first();

            if(!$accHead)
            {
                $masterAcc = MasterAccount::find(4);
                $accHeadL = AccountHead::where('ma_code', $masterAcc->mst_ac_code)->latest()->first();
                $accHead = new AccountHead();
                if ($accHeadL) {
                    $accHead->ac_code = $accHeadL->ac_code + 1;
                } else {
                    $accHead->ac_code = 100;
                }
                $accHead->ma_code = $masterAcc->mst_ac_code;
                $accHead->fld_ac_head = $each_head['item_name'];
                $accHead->fld_ac_code = $masterAcc->mst_ac_code . "-" . $accHead->ac_code;
                $accHead->fld_ms_ac_head = $masterAcc->mst_ac_head;
                $accHead->fld_definition = $masterAcc->mst_definition;
                $accHead->account_type_id= $masterAcc->account_type_id;
                $accHead->master_account_id= $masterAcc->id;
                $accHead->save();

            }


            $dr_acc_head= AccountHead::find($accHead->id);
            $jl_record= new JournalRecord();
            $jl_record->journal_id     = $journal->id;
            $jl_record->project_details_id  = 1;
            $jl_record->cost_center_id      = 1;
            $jl_record->party_info_id       = 1;
            $jl_record->journal_no          = $journal_no;
            $jl_record->account_head_id     = $dr_acc_head->id;
            $jl_record->master_account_id   = $dr_acc_head->master_account_id;
            $jl_record->account_head        = $dr_acc_head->fld_ac_head;
            $jl_record->amount              = $each_head['cost_price'];
            $jl_record->total_amount        = $jl_record->amount ;
            $jl_record->vat_rate_id         = 1;
            $jl_record->transaction_type    = 'DR';
            $jl_record->journal_date        =  $journal->date;
            $jl_record->account_type_id = $dr_acc_head->account_type_id;
            $jl_record->is_main_head        = 1;
            $jl_record->opening_balance_entry      = 1;

            $jl_record->save();
            $total_dr=$total_dr+$each_head['cost_price'];
        }

        if($total_dr>0)
        {
            $adjustment= AccountHead::find(771);
            $jl_record= new JournalRecord();
            $jl_record->journal_id     = $journal->id;
            $jl_record->project_details_id  = 1;
            $jl_record->cost_center_id      = 1;
            $jl_record->party_info_id       = 1;
            $jl_record->journal_no          = $journal_no;
            $jl_record->account_head_id     = $adjustment->id;
            $jl_record->master_account_id   = $adjustment->master_account_id;
            $jl_record->account_head        = $adjustment->fld_ac_head;
            $jl_record->amount              = $total_dr;
            $jl_record->total_amount        = $jl_record->amount ;
            $jl_record->vat_rate_id         = 1;
            $jl_record->transaction_type    = 'CR';
            $jl_record->journal_date        =  $journal->date;
            $jl_record->account_type_id = $adjustment->account_type_id;
            $jl_record->is_main_head        = 1;
            $jl_record->opening_balance_entry      = 1;
            $jl_record->save();
        }
        $dr_cr_voucher= new DebitCreditVoucher();
        $dr_cr_voucher->journal_id      = $journal->id;
        $dr_cr_voucher->project_id      =  $journal->project_id;
        $dr_cr_voucher->cost_center_id  = 1;
        $dr_cr_voucher->party_info_id   =  $journal->party_info_id;
        $dr_cr_voucher->account_head_id = 0;
        $dr_cr_voucher->pay_mode        = $journal->pay_mode;
        $dr_cr_voucher->amount          = $journal->total_amount;
        $dr_cr_voucher->narration       = $journal->narration;
        $dr_cr_voucher->type            =  'Opening Asset Entry';
        $dr_cr_voucher->date            = $journal->date;
        $dr_cr_voucher->save();

        return back()->with('success',"Successfully Added");
    }



    public function opening_inventory()
    {
        $items=ItemList::get();
        return view('backend.opening-balance.opening-inventory',compact('items'));
    }



    public function opening_inventory_store(Request $request)
    {

        $total_dr=0;
        $total_cr=0;
        // **************************************************
        $sub_invoice = Carbon::now()->format('Ymd');
        $latest_journal_no = Journal::withTrashed()->whereDate('created_at', Carbon::today())->where('journal_no', 'LIKE', "%{$sub_invoice}%")->orderBy('id','desc')->first();
        if ($latest_journal_no) {
            $journal_no = substr($latest_journal_no->journal_no,0,-1);
            $journal_code = $journal_no + 1;
            $journal_no = $journal_code . "J";
        } else {
            $journal_no = Carbon::now()->format('Ymd') . '001' . "J";
        }
        // return $journal_no;
        $journal= new Journal();
        $journal->project_id        = 1;
        $journal->journal_no        = $journal_no;
        $journal->date              = $request->date;
        $journal->pay_mode          = 'NonCash';
        $journal->invoice_no        = 'opening-0';
        $journal->cost_center_id    = 1;
        $journal->party_info_id     = 1;
        $journal->account_head_id   = 123;
        $journal->amount            =  $request->total_amount;
        $journal->tax_rate          = 0;
        $journal->vat_amount        = 0;
        $journal->total_amount      =  $journal->amount;
        $journal->narration         = 'Opening Inventory By-'. $journal->pay_mode;
        $journal->created_by        = Auth::id();
        $journal->authorized_by=Auth::id();
        $journal->approved_by=Auth::id();
        $journal->authorized        = 1;
        $journal->approved        = 1;
        $journal->voucher_type      = 'default.jpg';
        $journal->opening_balance_entry      = 1;
        $journal->save();
        // **************************************************
        $multi_head=$request->input('group-a');

        foreach($multi_head as $each_head){
            $item=ItemList::find($each_head['item_name']);

            $item_stock = new StockTransection();
            $item_stock->item_id =  $each_head['item_name'];
            $item_stock->transection_id = 0;
            $item_stock->quantity = $each_head['quantity'];
            $item_stock->stock_effect = 1;
            $item_stock->tns_type_code = "P";
            $item_stock->tns_description = "Purchase";
            $item_stock->date = $request->date;
            $item_stock->save();

            $vat_rate = VatRate::find($item->vat_rate);
            $unit_price = $item->purchase_rate;

            $item_fifos = new Fifo();
            $item_fifos->item_id = $item->id;
            $item_fifos->purchase_id = 0;
            $item_fifos->quantity = $each_head['quantity'];
            $item_fifos->unit_cost_price = $each_head['unit_price'];
            $item_fifos->consumed = 0;
            $item_fifos->remaining =  $each_head['quantity'];
            $item_fifos->save();

            $newStock=Stock::where('item_id',$item->id)->first();
            if(!$newStock)
            {
                $newStock=new Stock();
                $newStock->item_id=$item->id;
                $newStock->quantity=$each_head['quantity'];
                $newStock->total_purchase_value=$each_head['total_price'];
                $newStock->unit_purchase_value=$newStock->total_purchase_value/$newStock->quantity;
            }
            else
            {
                $newStock->quantity = $newStock->quantity+$each_head['quantity'];
                $newStock->total_purchase_value=$newStock->total_purchase_value+$each_head['total_price'];
                $newStock->unit_purchase_value=$newStock->total_purchase_value/$newStock->quantity;
            }
            $newStock->save();

            $dr_acc_head= AccountHead::where('item_id',$item->id)->first();
            $jl_record= new JournalRecord();
            $jl_record->journal_id     = $journal->id;
            $jl_record->project_details_id  = 1;
            $jl_record->cost_center_id      = 1;
            $jl_record->party_info_id       = 1;
            $jl_record->journal_no          = $journal_no;
            $jl_record->account_head_id     = $dr_acc_head->id;
            $jl_record->master_account_id   = $dr_acc_head->master_account_id;
            $jl_record->account_head        = $dr_acc_head->fld_ac_head;
            $jl_record->amount              = $each_head['total_price'];
            $jl_record->total_amount        = $jl_record->amount ;
            $jl_record->vat_rate_id         = 1;
            $jl_record->transaction_type    = 'DR';
            $jl_record->journal_date        =  $journal->date;
            $jl_record->account_type_id = $dr_acc_head->account_type_id;
            $jl_record->is_main_head        = 1;
            $jl_record->opening_balance_entry      = 1;
            $jl_record->save();
            $total_dr=$total_dr+$each_head['total_price'];
        }

        if($total_dr>0)
        {
            $adjustment= AccountHead::find(771);
            $jl_record= new JournalRecord();
            $jl_record->journal_id     = $journal->id;
            $jl_record->project_details_id  = 1;
            $jl_record->cost_center_id      = 1;
            $jl_record->party_info_id       = 1;
            $jl_record->journal_no          = $journal_no;
            $jl_record->account_head_id     = $adjustment->id;
            $jl_record->master_account_id   = $adjustment->master_account_id;
            $jl_record->account_head        = $adjustment->fld_ac_head;
            $jl_record->amount              = $total_dr;
            $jl_record->total_amount        = $jl_record->amount ;
            $jl_record->vat_rate_id         = 1;
            $jl_record->transaction_type    = 'CR';
            $jl_record->journal_date        =  $journal->date;
            $jl_record->account_type_id = $adjustment->account_type_id;
            $jl_record->is_main_head        = 1;
            $jl_record->opening_balance_entry      = 1;
            $jl_record->save();
        }
        $dr_cr_voucher= new DebitCreditVoucher();
        $dr_cr_voucher->journal_id      = $journal->id;
        $dr_cr_voucher->project_id      =  $journal->project_id;
        $dr_cr_voucher->cost_center_id  = 1;
        $dr_cr_voucher->party_info_id   =  $journal->party_info_id;
        $dr_cr_voucher->account_head_id = 0;
        $dr_cr_voucher->pay_mode        = $journal->pay_mode;
        $dr_cr_voucher->amount          = $journal->total_amount;
        $dr_cr_voucher->narration       = $journal->narration;
        $dr_cr_voucher->type            =  'Opening Asset Entry';
        $dr_cr_voucher->date            = $journal->date;
        $dr_cr_voucher->save();

        return back()->with('success',"Successfully Added");
    }

    public function opening_cash_asset()
    {
        $items=AccountHead::where('master_account_id',1)->whereNotIn('id',[27,829])->get();
        return view('backend.opening-balance.opening-cash-asset',compact('items'));
    }



    public function opening_cash_asset_store(Request $request)
    {

        // dd($request->all());

        $total_dr=0;
        $total_cr=0;
        // **************************************************
        $sub_invoice = Carbon::now()->format('Ymd');
        $latest_journal_no = Journal::withTrashed()->whereDate('created_at', Carbon::today())->where('journal_no', 'LIKE', "%{$sub_invoice}%")->orderBy('id','desc')->first();
        if ($latest_journal_no) {
            $journal_no = substr($latest_journal_no->journal_no,0,-1);
            $journal_code = $journal_no + 1;
            $journal_no = $journal_code . "J";
        } else {
            $journal_no = Carbon::now()->format('Ymd') . '001' . "J";
        }
        // return $journal_no;
        $journal= new Journal();
        $journal->project_id        = 1;
        $journal->journal_no        = $journal_no;
        $journal->date              = $request->date;
        $journal->pay_mode          = 'NonCash';
        $journal->invoice_no        = 'opening-0';
        $journal->cost_center_id    = 1;
        $journal->party_info_id     = 1;
        $journal->account_head_id   = 123;
        $journal->amount            =  $request->total_amount;
        $journal->tax_rate          = 0;
        $journal->vat_amount        = 0;
        $journal->total_amount      =  $journal->amount;
        $journal->narration         = 'Opening Cash Assets By-'. $journal->pay_mode;
        $journal->created_by        = Auth::id();
        $journal->authorized_by=Auth::id();
        $journal->approved_by=Auth::id();
        $journal->authorized        = 1;
        $journal->approved        = 1;
        $journal->voucher_type      = 'default.jpg';
        $journal->opening_balance_entry      = 1;
        $journal->save();
        // **************************************************
        $multi_head=$request->input('group-a');

        foreach($multi_head as $each_head){
            $dr_acc_head= AccountHead::find($each_head['item_name']);
            $jl_record= new JournalRecord();
            $jl_record->journal_id     = $journal->id;
            $jl_record->project_details_id  = 1;
            $jl_record->cost_center_id      = 1;
            $jl_record->party_info_id       = 1;
            $jl_record->journal_no          = $journal_no;
            $jl_record->account_head_id     = $dr_acc_head->id;
            $jl_record->master_account_id   = $dr_acc_head->master_account_id;
            $jl_record->account_head        = $dr_acc_head->fld_ac_head;
            $jl_record->amount              = $each_head['total_price'];
            $jl_record->total_amount        = $jl_record->amount ;
            $jl_record->vat_rate_id         = 1;
            $jl_record->transaction_type    = 'DR';
            $jl_record->journal_date        =  $journal->date;
            $jl_record->account_type_id = $dr_acc_head->account_type_id;
            $jl_record->is_main_head        = 1;
            $jl_record->opening_balance_entry      = 1;
            $jl_record->save();
            $total_dr=$total_dr+$each_head['total_price'];
        }

        if($total_dr>0)
        {
            $adjustment= AccountHead::find(771);
            $jl_record= new JournalRecord();
            $jl_record->journal_id     = $journal->id;
            $jl_record->project_details_id  = 1;
            $jl_record->cost_center_id      = 1;
            $jl_record->party_info_id       = 1;
            $jl_record->journal_no          = $journal_no;
            $jl_record->account_head_id     = $adjustment->id;
            $jl_record->master_account_id   = $adjustment->master_account_id;
            $jl_record->account_head        = $adjustment->fld_ac_head;
            $jl_record->amount              = $total_dr;
            $jl_record->total_amount        = $jl_record->amount ;
            $jl_record->vat_rate_id         = 1;
            $jl_record->transaction_type    = 'CR';
            $jl_record->journal_date        =  $journal->date;
            $jl_record->account_type_id = $adjustment->account_type_id;
            $jl_record->is_main_head        = 1;
            $jl_record->opening_balance_entry      = 1;
            $jl_record->save();
        }
        $dr_cr_voucher= new DebitCreditVoucher();
        $dr_cr_voucher->journal_id      = $journal->id;
        $dr_cr_voucher->project_id      =  $journal->project_id;
        $dr_cr_voucher->cost_center_id  = 1;
        $dr_cr_voucher->party_info_id   =  $journal->party_info_id;
        $dr_cr_voucher->account_head_id = 0;
        $dr_cr_voucher->pay_mode        = $journal->pay_mode;
        $dr_cr_voucher->amount          = $journal->total_amount;
        $dr_cr_voucher->narration       = $journal->narration;
        $dr_cr_voucher->type            =  'Opening Asset Entry';
        $dr_cr_voucher->date            = $journal->date;
        $dr_cr_voucher->save();

        return back()->with('success',"Successfully Added");
    }



    public function opening_reciavable_payable()
    {
        $items=AccountHead::whereIn('master_account_id',[1,2])->whereNotIn('id',[1,2])->get();
        $parties=PartyInfo::get();
        return view('backend.opening-balance.opening-receivable-payable', compact('items','parties'));
    }


    public function opening_reciavable_payable_store(Request $request)
    {

        $total_dr=0;
        $total_cr=0;
        // **************************************************
        $sub_invoice = Carbon::now()->format('Ymd');
        $latest_journal_no = Journal::withTrashed()->whereDate('created_at', Carbon::today())->where('journal_no', 'LIKE', "%{$sub_invoice}%")->orderBy('id','desc')->first();
        if ($latest_journal_no) {
            $journal_no = substr($latest_journal_no->journal_no,0,-1);
            $journal_code = $journal_no + 1;
            $journal_no = $journal_code . "J";
        } else {
            $journal_no = Carbon::now()->format('Ymd') . '001' . "J";
        }
        // return $journal_no;
        $journal= new Journal();
        $journal->project_id        = 1;
        $journal->journal_no        = $journal_no;
        $journal->date              = $request->date;
        $journal->pay_mode          = 'NonCash';
        $journal->invoice_no        = 'opening-0';
        $journal->cost_center_id    = 1;
        $journal->party_info_id     = 1;
        $journal->account_head_id   = 123;
        $journal->amount            =  $request->total_amount;
        $journal->tax_rate          = 0;
        $journal->vat_amount        = 0;
        $journal->total_amount      =  $journal->amount;
        $journal->narration         = 'Opening Asset/Liability By-'. $journal->pay_mode;
        $journal->created_by        = Auth::id();
        $journal->authorized_by=Auth::id();
        $journal->approved_by=Auth::id();
        $journal->authorized        = 1;
        $journal->approved        = 1;
        $journal->voucher_type      = 'default.jpg';
        $journal->opening_balance_entry      = 1;
        $journal->save();
        // **************************************************
        $multi_head=$request->input('group-a');

        foreach($multi_head as $each_head){
            $dr_acc_head= AccountHead::find($each_head['item_name']);
            $jl_record= new JournalRecord();
            $jl_record->journal_id     = $journal->id;
            $jl_record->project_details_id  = 1;
            $jl_record->cost_center_id      = 1;
            $jl_record->party_info_id       = 1;
            $jl_record->journal_no          = $journal_no;
            $jl_record->account_head_id     = $dr_acc_head->id;
            $jl_record->master_account_id   = $dr_acc_head->master_account_id;
            $jl_record->account_head        = $dr_acc_head->fld_ac_head;
            $jl_record->amount              = $each_head['total_price'];
            $jl_record->total_amount        = $jl_record->amount ;
            $jl_record->vat_rate_id         = 1;
            $jl_record->transaction_type    = $dr_acc_head->master_account_id==1?'DR':'CR';
            $jl_record->journal_date        =  $journal->date;
            $jl_record->account_type_id = $dr_acc_head->account_type_id;
            $jl_record->is_main_head        = 1;
            $jl_record->opening_balance_entry      = 1;
            $jl_record->save();
            if($dr_acc_head->master_account_id==1)
            {
                $total_dr=$total_dr+$each_head['total_price'];
            }
            else
            {
                $total_cr=$total_cr+$each_head['total_price'];
            }
        }

        if($total_dr!=$total_cr)
        {
            $adjustment= AccountHead::find(771);
            $jl_record= new JournalRecord();
            $jl_record->journal_id     = $journal->id;
            $jl_record->project_details_id  = 1;
            $jl_record->cost_center_id      = 1;
            $jl_record->party_info_id       = 1;
            $jl_record->journal_no          = $journal_no;
            $jl_record->account_head_id     = $adjustment->id;
            $jl_record->master_account_id   = $adjustment->master_account_id;
            $jl_record->account_head        = $adjustment->fld_ac_head;
            $jl_record->amount              = $total_dr>$total_cr ? ($total_dr-$total_cr):($total_cr-$total_dr);
            $jl_record->total_amount        = $jl_record->amount ;
            $jl_record->vat_rate_id         = 1;
            $jl_record->transaction_type    = $total_dr>$total_cr ? 'CR':'DR';
            $jl_record->journal_date        =  $journal->date;
            $jl_record->account_type_id = $adjustment->account_type_id;
            $jl_record->is_main_head        = 1;
            $jl_record->opening_balance_entry      = 1;
            $jl_record->save();
        }
        $journal->amount            =  $total_dr>$total_cr? $total_dr:$total_cr;
        $journal->total_amount      =  $journal->amount;
        $journal->save();
        $dr_cr_voucher= new DebitCreditVoucher();
        $dr_cr_voucher->journal_id      = $journal->id;
        $dr_cr_voucher->project_id      =  $journal->project_id;
        $dr_cr_voucher->cost_center_id  = 1;
        $dr_cr_voucher->party_info_id   =  $journal->party_info_id;
        $dr_cr_voucher->account_head_id = 0;
        $dr_cr_voucher->pay_mode        = $journal->pay_mode;
        $dr_cr_voucher->amount          = $journal->total_amount;
        $dr_cr_voucher->narration       = $journal->narration;
        $dr_cr_voucher->type            =  'Opening Asset/Liability Entry';
        $dr_cr_voucher->date            = $journal->date;
        $dr_cr_voucher->save();

        return back()->with('success',"Successfully Added");
    }


    public function opening_others()
    {
        $items=AccountHead::whereIn('master_account_id',[227])->orWhereIn('id',[834,833,476])->get();
        return view('backend.opening-balance.opening-others',compact('items'));
    }


    public function opening_others_store(Request $request)
    {


        // dd($request->all());
        $total_dr=0;
        $total_cr=0;
        // **************************************************
        $sub_invoice = Carbon::now()->format('Ymd');
        $latest_journal_no = Journal::withTrashed()->whereDate('created_at', Carbon::today())->where('journal_no', 'LIKE', "%{$sub_invoice}%")->orderBy('id','desc')->first();
        if ($latest_journal_no) {
            $journal_no = substr($latest_journal_no->journal_no,0,-1);
            $journal_code = $journal_no + 1;
            $journal_no = $journal_code . "J";
        } else {
            $journal_no = Carbon::now()->format('Ymd') . '001' . "J";
        }
        // return $journal_no;
        $journal= new Journal();
        $journal->project_id        = 1;
        $journal->journal_no        = $journal_no;
        $journal->date              = $request->date;
        $journal->pay_mode          = 'NonCash';
        $journal->invoice_no        = 'opening-0';
        $journal->cost_center_id    = 1;
        $journal->party_info_id     = 1;
        $journal->account_head_id   = 123;
        $journal->amount            =  $request->total_amount;
        $journal->tax_rate          = 0;
        $journal->vat_amount        = 0;
        $journal->total_amount      =  $journal->amount;
        $journal->narration         = 'Opening Entry By-'. $journal->pay_mode;
        $journal->created_by        = Auth::id();
        $journal->authorized_by=Auth::id();
        $journal->approved_by=Auth::id();
        $journal->authorized        = 1;
        $journal->approved        = 1;
        $journal->voucher_type      = 'default.jpg';
        $journal->opening_balance_entry      = 1;
        $journal->save();
        // **************************************************
        $multi_head=$request->input('group-a');

        foreach($multi_head as $each_head){
            $dr_acc_head= AccountHead::find($each_head['item_name']);
            $jl_record= new JournalRecord();
            $jl_record->journal_id     = $journal->id;
            $jl_record->project_details_id  = 1;
            $jl_record->cost_center_id      = 1;
            $jl_record->party_info_id       = 1;
            $jl_record->journal_no          = $journal_no;
            $jl_record->account_head_id     = $dr_acc_head->id;
            $jl_record->master_account_id   = $dr_acc_head->master_account_id;
            $jl_record->account_head        = $dr_acc_head->fld_ac_head;
            $jl_record->amount              = $each_head['total_price'];
            $jl_record->total_amount        = $jl_record->amount ;
            $jl_record->vat_rate_id         = 1;
            $jl_record->transaction_type    =  'CR';
            $jl_record->journal_date        =  $journal->date;
            $jl_record->Note        =  $each_head['note'];
            $jl_record->account_type_id = $dr_acc_head->account_type_id;
            $jl_record->is_main_head        = 1;
            $jl_record->opening_balance_entry      = 1;
            $jl_record->save();

                $total_cr=$total_cr+$each_head['total_price'];

        }

        if($total_dr!=$total_cr)
        {
            $adjustment= AccountHead::find(771);
            $jl_record= new JournalRecord();
            $jl_record->journal_id     = $journal->id;
            $jl_record->project_details_id  = 1;
            $jl_record->cost_center_id      = 1;
            $jl_record->party_info_id       = 1;
            $jl_record->journal_no          = $journal_no;
            $jl_record->account_head_id     = $adjustment->id;
            $jl_record->master_account_id   = $adjustment->master_account_id;
            $jl_record->account_head        = $adjustment->fld_ac_head;
            $jl_record->amount              = $total_dr>$total_cr ? ($total_dr-$total_cr):($total_cr-$total_dr);
            $jl_record->total_amount        = $jl_record->amount ;
            $jl_record->vat_rate_id         = 1;
            $jl_record->transaction_type    = $total_dr>$total_cr ? 'CR':'DR';
            $jl_record->journal_date        =  $journal->date;
            $jl_record->account_type_id = $adjustment->account_type_id;
            $jl_record->is_main_head        = 1;
            $jl_record->opening_balance_entry      = 1;
            $jl_record->save();
        }
        $journal->amount            =  $total_dr>$total_cr? $total_dr:$total_cr;
        $journal->total_amount      =  $journal->amount;
        $journal->save();
        $dr_cr_voucher= new DebitCreditVoucher();
        $dr_cr_voucher->journal_id      = $journal->id;
        $dr_cr_voucher->project_id      =  $journal->project_id;
        $dr_cr_voucher->cost_center_id  = 1;
        $dr_cr_voucher->party_info_id   =  $journal->party_info_id;
        $dr_cr_voucher->account_head_id = 0;
        $dr_cr_voucher->pay_mode        = $journal->pay_mode;
        $dr_cr_voucher->amount          = $journal->total_amount;
        $dr_cr_voucher->narration       = $journal->narration;
        $dr_cr_voucher->type            =  'Opening Asset/Liability Entry';
        $dr_cr_voucher->date            = $journal->date;
        $dr_cr_voucher->save();

        return back()->with('success',"Successfully Added");
    }


}
