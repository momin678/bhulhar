<?php

namespace App\Http\Controllers;

use App\Group;
use App\Invoice;
use App\ItemList;
use App\Models\BankDetail;
use App\Models\CostCenter;
use App\Models\MasterAccount;
use App\PartyInfo;
use App\ProfitCenter;
use App\ProjectDetail;
use App\Setting;
use App\Style;

use App\Fifo;
use App\FifoInvoice;
use App\InvoiceAmount;
use App\Employee;

use App\InvoiceItem;
use App\JobProject;
use App\JobProjectInvoice;
use App\JobProjectInvoiceTask;
use App\JobProjectTask;
use App\JobProjectTemInvoice;
use App\JobProjectTemInvoiceTask;
use App\Journal;
use App\JournalRecord;
use App\LpoPorjectTask;
use App\LpoProject;
use App\Permission;
use App\Role;
use App\Purchase;
use App\PurchaseDetail;
use App\Stock;
use App\Models\AccountHead;
use App\Payment;
use App\PurchaseExpense;
use App\Receipt;
use App\ReceiptSale;
use App\StockTransection;
use App\TempReceiptVoucher;
use App\TempReceiptVoucherDetail;
use App\TaxInvoice;
use App\InvoiceColumnCheck;
use App\TollAmountRecord;
use App\TruckRecords;
use App\TaxInvoiceItem;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $counter_sales= Invoice::where('')
        $date=date('Y-m-d');
        $sales = TaxInvoice::orderBy('id', 'desc')->where('date',$date)->get();
        $expenses = PurchaseExpense::orderBy('date', 'desc')->where('date',$date)->get();
        $payments = Payment::orderBy('date', 'desc')->where('date',$date)->get();
        $receipt_list = Receipt::orderBy('date', 'desc')->where('date',$date)->get();

        $receivable_cr = JournalRecord::where('account_head_id',3)->whereYear('created_at',date('Y'))->where('transaction_type','CR')->get()->sum('total_amount');
        $receivable_dr = JournalRecord::where('account_head_id',3)->whereYear('created_at',date('Y'))->where('transaction_type','DR')->get()->sum('total_amount');
        $receivable = $receivable_dr - $receivable_cr;

        $payble_cr = JournalRecord::where('account_head_id',5)->whereYear('created_at',date('Y'))->where('transaction_type','CR')->get()->sum('total_amount');
        $payble_dr = JournalRecord::where('account_head_id',5)->whereYear('created_at',date('Y'))->where('transaction_type','DR')->get()->sum('total_amount');
        $payble = $payble_cr - $payble_dr;

        $cash_cr = JournalRecord::where('account_head_id',1)->whereYear('created_at',date('Y'))->where('transaction_type','CR')->get()->sum('total_amount');
        $cash_dr = JournalRecord::where('account_head_id',1)->whereYear('created_at',date('Y'))->where('transaction_type','DR')->get()->sum('total_amount');
        $cash = $cash_dr - $cash_cr;
        $m_sales = TaxInvoice::orderBy('id', 'desc')->whereMonth('date',date('m'))->whereYear('date',date('Y'))->sum('total_amount');
        // dd($expenses);
        return view('home',compact('expenses','payments','receipt_list','sales', 'receivable', 'payble', 'cash', 'm_sales'));
    }

    public function under_construction(){
        return view('under-construction');
    }


    public function pdf($id)
    {
        if ($id == "bankDetails") {
            $bankDetails = BankDetail::latest()->get();
            return view('backend/pdf/bankDetailsPdf', compact('bankDetails'));
        }

        if ($id == "projDetails") {
            $projDetails = ProjectDetail::where('proj_type', '!=', "Draft")->latest()->get();
            return view('backend/pdf/projDetailsPdf', compact('projDetails'));
        }

        if ($id == "MasterAccDetails") {
            $masterDetails = MasterAccount::where('mst_ac_code', '!=', 'Draft')->latest()->get();
            return view('backend/pdf/MasterAccDetailsPdf', compact('masterDetails'));
        }

        if ($id == "costCenter") {
            $costCenters = CostCenter::latest()->get();
            return view('backend/pdf/costCentersPdf', compact('costCenters'));
        }


        if ($id == "profitCenter") {
            $profitDetails = ProfitCenter::where('activity', '!=', 'Draft')->latest()->get();
            return view('backend/pdf/profitCentersPdf', compact('profitDetails'));
        }

        if ($id == "partyCenter") {
            $partyInfos = PartyInfo::orderBy('id','DESC')->get();
            return view('backend/pdf/partyInfoPdf', compact('partyInfos'));
        }
    }




    public function SearchAjax(Request $request, $id)
    {

        if ($id == "masterAcc") {
            $masterDetails = MasterAccount::where('mst_ac_code', 'like', "%{$request->q}%")
                ->orWhere('mst_ac_head', 'like', "%{$request->q}%")
                ->orWhere('mst_definition', 'like', "%{$request->q}%")
                ->orWhere('mst_ac_type', 'like', "%{$request->q}%")
                ->orWhere('vat_type', 'like', "%{$request->q}%")
                ->latest()
                ->take(40)
                ->get();
            $i = 1;

            if ($request->ajax()) {
                return Response()->json(['page' => view('backend.ajax.masterAccTbody', ['masterDetails' => $masterDetails, 'i' => $i])->render()]);
            }
        }


        if ($id == "costCenter") {
            $costCenters = CostCenter::where('cc_code', 'like', "%{$request->q}%")
                ->orWhere('cc_name', 'like', "%{$request->q}%")
                ->latest()
                ->take(40)
                ->get();
            $i = 1;
            if ($request->ajax()) {
                return Response()->json(['page' => view('backend.ajax.costCenterTbody', ['costCenters' => $costCenters, 'i' => $i])->render()]);
            }
        }

        if ($id == "projectDetails") {
            $projDetails = ProjectDetail::where('proj_no', 'like', "%{$request->q}%")
                ->orWhere('proj_name', 'like', "%{$request->q}%")
                ->orWhere('cont_no', 'like', "%{$request->q}%")
                ->latest()
                ->take(40)
                ->get();
            $i = 1;

            if ($request->ajax()) {
                return Response()->json(['page' => view('backend.ajax.projectDetailsTbody', ['projDetails' => $projDetails, 'i' => $i])->render()]);
            }
        }

        if ($id == "bankDetails") {
            $bankDetails = BankDetail::where('bank_code', 'like', "%{$request->q}%")
                ->orWhere('bank_name', 'like', "%{$request->q}%")
                ->orWhere('ac_no', 'like', "%{$request->q}%")
                ->latest()
                ->take(40)
                ->get();
            $i = 1;
            if ($request->ajax()) {
                return Response()->json(['page' => view('backend.ajax.bankDetailsTbody', ['bankDetails' => $bankDetails, 'i' => $i])->render()]);
            }
        }


        if ($id == "profitCenter") {
            $profitDetails = ProfitCenter::where('pc_code', 'like', "%{$request->q}%")
                ->orWhere('pc_name', 'like', "%{$request->q}%")
                ->latest()
                ->take(40)
                ->get();
            $i = 1;
            if ($request->ajax()) {
                return Response()->json(['page' => view('backend.ajax.profitCenterTbody', ['profitDetails' => $profitDetails, 'i' => $i])->render()]);
            }
        }


        if ($id == "partyCenter") {
            $partyInfos = PartyInfo::where('pi_code', 'like', "%{$request->q}%")
                ->orWhere('pi_name', 'like', "%{$request->q}%")
                ->orWhere('trn_no', 'like', "%{$request->q}%")
                ->latest()
                ->take(40)
                ->get();
            $i = 1;
            if ($request->ajax()) {
                return Response()->json(['page' => view('backend.ajax.partyInfoTbody', ['partyInfos' => $partyInfos, 'i' => $i])->render()]);
            }
        }
        // work by mominul
        if ($id == "group") {
            $groups = Group::where('group_no', 'like', "%{$request->q}%")->orWhere('group_name', 'like', "%{$request->q}%")->get();
            $i = 1;
            if ($request->ajax()) {
                return Response()->json(['page' => view('backend.ajax.group', ['groups' => $groups, 'i' => $i])->render()]);
            }
        }
        if ($id == "style") {
            $styles = Style::where('style_no', 'like', "%{$request->q}%")->orWhere('style_name', 'like', "%{$request->q}%")->get();
            $i = 1;
            if ($request->ajax()) {
                return Response()->json(['page' => view('backend.ajax.style', ['styles' => $styles, 'i' => $i])->render()]);
            }
        }

        if ($id == "iteList") {
            $itme_lists = ItemList::orderBy('barcode', 'asc')
                ->where('barcode', 'like', "%{$request->q}%")
                ->orWhere('item_name', 'like', "%{$request->q}%")
                ->orWhere('unit', 'like', "%{$request->q}%")
                ->orWhere('sell_price', 'like', "%{$request->q}%")
                ->orWhere('vat_amount', 'like', "%{$request->q}%")
                ->latest()
                ->get();
            $i = 1;
            if ($request->ajax()) {
                return Response()->json(['page' => view('backend.ajax.itemList', ['itme_lists' => $itme_lists, 'i' => $i])->render()]);
            }
        }



    }

    public function requirement(){
        return view('api-controll-module.program-view.requirement-list');

    }
    public function moduls_list(){
        return view('api-controll-module.program-view.moduls');
    }
    public function invoice_delete(){
        $invoice = TaxInvoice::find(22);
        $invoice_column = InvoiceColumnCheck::where('tax_invoice_id', $invoice->id)->first();
        if($invoice_column){
            $invoice_column->forceDelete();
        }
        $invoice_items = TaxInvoiceItem::where('invoice_id', $invoice->id)->get();
        foreach($invoice_items as $inv_item){
            $record= TruckRecords::find($inv_item->item_id);
            $record->is_invoiced=0;
            $record->save();

            $toll_amount_record = TollAmountRecord::where('truck_record_id', $inv_item->item_id)->first();
            if($toll_amount_record){
                $toll_amount_record->is_invoice = 0;
                $toll_amount_record->save();
            }
            $inv_item->forceDelete();
        }
        $journal = Journal::where('invoice_no', $invoice->invoice_no)->first();
        if($journal){
            JournalRecord::where('journal_id', $journal->id)->forceDelete();
            $journal->forceDelete();
        }
        $receipt_item = ReceiptSale::where('sale_id', $invoice->id)->first();
        if($receipt_item){
            $receipt = Receipt::find($receipt_item->payment_id);
            if($receipt){
                $receipt->forceDelete();
            }
            $receipt_item->forceDelete();
        }
        $invoice->forceDelete();
        return back();
    }

}
