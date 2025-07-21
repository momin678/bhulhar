<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\TaxInvoice;
use App\JournalRecord;
use App\Models\AccountHead;
use App\PartyInfo;
use App\Payment;
use App\PaymentInvoice;
use App\PurchaseExpense;
use App\Receipt;
use App\Purchase;
use App\ReceiptSale;
use App\SupplierInvoice;
use App\Models\FundAllocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AccountsReportController extends Controller
{

    private function dateFormat($date)
    {
        $old_date = explode('/', $date);

        $new_data = $old_date[0].'-'.$old_date[1].'-'.$old_date[2];
        $new_date = date('Y-m-d', strtotime($new_data));
        $new_date = \DateTime::createFromFormat("Y-m-d", $new_date);
        return $new_date->format('Y-m-d');
    }

    public function new_general_ledger(Request $request){
        if($request->search!=null)
        {
            $sreach = explode('/',$request->search);
            $id=$sreach[0];
            $type=$sreach[1];

            if($request->from!=null && $request->to!=null)
            {
                $from=$this->dateFormat($request->from);
                $to=$this->dateFormat($request->to);
                $journal_heads=JournalRecord::where('journal_id', '!=', 0)->whereIn('account_type_id',[1,2,4,6])->where('opening_balance_entry', false)->distinct()->get('account_head_id');
                $master_groups=JournalRecord::where('journal_id', '!=', 0)->whereNotIn('account_type_id', [1, 2, 4,6])->where('opening_balance_entry', false)->distinct()->get('master_account_id');
                $openings=JournalRecord::where('journal_id', '!=', 0)->where('opening_balance_entry', true)->distinct()->get('account_head_id');
                if($type=='head')
                {
                    $unique_acc_head=JournalRecord::where('journal_id', '!=', 0)->whereIn('account_type_id',[1,2,4,6])->where('opening_balance_entry', false)->where('account_head_id',$id)->distinct()->select('account_head_id')->first();
                    return view('backend.accounts-report.g-ledger-range-head', compact('journal_heads','master_groups','openings','from','to','unique_acc_head'));
                }
                else
                {

                        $unique_mst=JournalRecord::where('journal_id', '!=', 0)->whereNotIn('account_type_id', [1, 2, 4,6])->where('opening_balance_entry', false)->where('master_account_id',$id)->distinct()->select('master_account_id')->first();
                        // dd($request->all(),$id,$unique_mst);

                        return view('backend.accounts-report.g-ledger-range-head', compact('journal_heads','master_groups','openings','from','to','unique_mst'));
                }
            }
            elseif($request->from==null && $request->to!=null)
            {
                $from=$this->dateFormat($request->to);
                $to=$this->dateFormat($request->to);
                $journal_heads=JournalRecord::where('journal_id', '!=', 0)->whereIn('account_type_id',[1,2,4,6])->where('opening_balance_entry', false)->distinct()->get('account_head_id');
                $master_groups=JournalRecord::where('journal_id', '!=', 0)->whereNotIn('account_type_id', [1, 2, 4,6])->where('opening_balance_entry', false)->distinct()->get('master_account_id');
                $openings=JournalRecord::where('journal_id', '!=', 0)->where('opening_balance_entry', true)->distinct()->get('account_head_id');

                if($type=='head')
                {
                    $unique_acc_head=JournalRecord::where('journal_id', '!=', 0)->whereIn('account_type_id',[1,2,4,6])->where('opening_balance_entry', false)->where('account_head_id',$id)->distinct()->select('account_head_id')->first();
                    return view('backend.accounts-report.g-ledger-range-head', compact('journal_heads','master_groups','openings','from','to','unique_acc_head'));
                }
                else
                {
                        $unique_mst=JournalRecord::where('journal_id', '!=', 0)->whereNotIn('account_type_id', [1, 2, 4,6])->where('opening_balance_entry', false)->where('master_account_id',$id)->distinct()->select('master_account_id')->first();
                        return view('backend.accounts-report.g-ledger-range-head', compact('journal_heads','master_groups','openings','from','to','unique_mst'));
                }

            }
            elseif($request->to==null && $request->from!=null)
            {
                $from=$this->dateFormat($request->from);
                $to=$this->dateFormat($request->from);
                $journal_heads=JournalRecord::where('journal_id', '!=', 0)->whereIn('account_type_id',[1,2,4,6])->where('opening_balance_entry', false)->distinct()->get('account_head_id');
                $master_groups=JournalRecord::where('journal_id', '!=', 0)->whereNotIn('account_type_id', [1, 2, 4,6])->where('opening_balance_entry', false)->distinct()->get('master_account_id');
                $openings=JournalRecord::where('journal_id', '!=', 0)->where('opening_balance_entry', true)->distinct()->get('account_head_id');

                if($type=='head')
                {
                    $unique_acc_head=JournalRecord::where('journal_id', '!=', 0)->whereIn('account_type_id',[1,2,4,6])->where('opening_balance_entry', false)->where('account_head_id',$id)->distinct()->select('account_head_id')->first();
                    return view('backend.accounts-report.g-ledger-range-head', compact('journal_heads','master_groups','openings','from','to','unique_acc_head'));
                }
                else
                {
                        $unique_mst=JournalRecord::where('journal_id', '!=', 0)->whereNotIn('account_type_id', [1, 2, 4,6])->where('opening_balance_entry', false)->where('master_account_id',$id)->distinct()->select('master_account_id')->first();
                        return view('backend.accounts-report.g-ledger-range-head', compact('journal_heads','master_groups','openings','from','to','unique_mst'));
                }
            }
            else
            {
                $journal_heads=JournalRecord::where('journal_id', '!=', 0)->whereIn('account_type_id',[1,2,4,6])->where('opening_balance_entry', false)->distinct()->get('account_head_id');
                $master_groups=JournalRecord::where('journal_id', '!=', 0)->whereNotIn('account_type_id', [1, 2, 4,6])->where('opening_balance_entry', false)->distinct()->get('master_account_id');
                $openings=JournalRecord::where('journal_id', '!=', 0)->where('opening_balance_entry', true)->distinct()->get('account_head_id');
                if($type=='head')
                {
                    $unique_acc_head=JournalRecord::where('journal_id', '!=', 0)->whereIn('account_type_id',[1,2,4,6])->where('opening_balance_entry', false)->where('account_head_id',$id)->distinct()->select('account_head_id')->first();
                    return view('backend.accounts-report.g-ledger', compact('journal_heads','master_groups','openings','unique_acc_head'));
                }
                else
                {
                        $unique_mst=JournalRecord::where('journal_id', '!=', 0)->whereNotIn('account_type_id', [1, 2, 4,6])->where('opening_balance_entry', false)->where('master_account_id',$id)->distinct()->select('master_account_id')->first();
                        return view('backend.accounts-report.g-ledger', compact('journal_heads','master_groups','openings','unique_mst'));
                    }

            }

        }
        elseif($request->from!=null && $request->to!=null)
        {
            // dd($request->all(),'ok');

            $from=$this->dateFormat($request->from);
            $to=$this->dateFormat($request->to);
            $journal_heads=JournalRecord::where('journal_id', '!=', 0)->whereIn('account_type_id',[1,2,4,6])->where('opening_balance_entry', false)->distinct()->get('account_head_id');
            $master_groups=JournalRecord::where('journal_id', '!=', 0)->whereNotIn('account_type_id', [1, 2, 4,6])->where('opening_balance_entry', false)->distinct()->get('master_account_id');
            $openings=JournalRecord::where('journal_id', '!=', 0)->where('opening_balance_entry', true)->distinct()->get('account_head_id');

            return view('backend.accounts-report.g-ledger-range', compact('journal_heads','master_groups','openings','from','to'));

        }
        elseif($request->from==null && $request->to!=null)
        {
            $from=$this->dateFormat($request->to);
            $to=$this->dateFormat($request->to);
            $journal_heads=JournalRecord::where('journal_id', '!=', 0)->whereIn('account_type_id',[1,2,4,6])->where('opening_balance_entry', false)->distinct()->get('account_head_id');
            $master_groups=JournalRecord::where('journal_id', '!=', 0)->whereNotIn('account_type_id', [1, 2, 4,6])->where('opening_balance_entry', false)->distinct()->get('master_account_id');
            $openings=JournalRecord::where('journal_id', '!=', 0)->where('opening_balance_entry', true)->distinct()->get('account_head_id');

            return view('backend.accounts-report.g-ledger-range', compact('journal_heads','master_groups','openings','from','to'));

        }
        elseif($request->to==null && $request->from!=null)
        {
            $from=$this->dateFormat($request->from);
            $to=$this->dateFormat($request->from);
            $journal_heads=JournalRecord::where('journal_id', '!=', 0)->whereIn('account_type_id',[1,2,4,6])->where('opening_balance_entry', false)->distinct()->get('account_head_id');
            $master_groups=JournalRecord::where('journal_id', '!=', 0)->whereNotIn('account_type_id', [1, 2, 4,6])->where('opening_balance_entry', false)->distinct()->get('master_account_id');
            $openings=JournalRecord::where('journal_id', '!=', 0)->where('opening_balance_entry', true)->distinct()->get('account_head_id');

            return view('backend.accounts-report.g-ledger-range', compact('journal_heads','master_groups','openings','from','to'));

        }
        else
        {
            $journal_heads=JournalRecord::where('journal_id', '!=', 0)->whereIn('account_type_id',[1,2,4,6])->where('opening_balance_entry', false)->distinct()->get('account_head_id');
            $master_groups=JournalRecord::where('journal_id', '!=', 0)->whereNotIn('account_type_id', [1, 2, 4,6])->where('opening_balance_entry', false)->distinct()->get('master_account_id');
            $openings=JournalRecord::where('journal_id', '!=', 0)->where('opening_balance_entry', true)->distinct()->get('account_head_id');
            return view('backend.accounts-report.new-index', compact('journal_heads','master_groups','openings'));

        }
    }

    public function party_report(Request $request)
    {
        $date=null;
        $date2=null;
        $parties=PartyInfo::get();
        $party=null;
        $records=null;
        $opening=0;
        if($request->party_name)
        {
            $records=JournalRecord::whereIn('account_type_id',[1,2])->whereNotIn('account_head_id',[19])->where('party_info_id',$request->party_name)->select('journal_id')->distinct()->get();
            $party=PartyInfo::find($request->party_name);
            // dd($records);
        }

        if($request->date!==null && $request->date2!=null )
        {
            $date=$this->dateFormat($request->date);

            $date2=$this->dateFormat($request->date2);
            $records=JournalRecord::whereIn('account_type_id',[1,2])->whereNotIn('account_head_id',[19])->where('party_info_id',$request->party_name)->whereBetween('journal_date',[$date,$date2])->select('journal_id')->distinct()->get();

        }
        elseif($request->date!=null)
        {
            $date=$this->dateFormat($request->date);

            $records=JournalRecord::whereIn('account_type_id',[1,2])->whereNotIn('account_head_id',[19])->where('party_info_id',$request->party_name)->where('journal_date',$date)->select('journal_id')->distinct()->get();
        }
        elseif($request->date2!=null)
        {
            $date=$this->dateFormat($request->date2);

            $records=JournalRecord::whereIn('account_type_id',[1,2])->whereNotIn('account_head_id',[19])->where('party_info_id',$request->party_name)->where('journal_date', $date)->select('journal_id')->distinct()->get();
        }

        return view('backend.accounts-report.party-report',compact('records','date','parties','party','date2'));
    }

    public function new_trial_balance(Request $request){
        $date=date('Y-m-d');
        $date1=date('Y-m-d');
        // dd($request->all());
        // if()
        if($request->date)
        {
            $date=$this->dateFormat($request->date);
            $date1=$this->dateFormat($request->date);
        }

        if($request->from)
        {
            $date=$this->dateFormat($request->from);;
            $date1=$this->dateFormat($request->to);;
        }
        return view('backend.accounts-report.new-trial-balance',compact('date','date1'));
    }

    public function income_statement(Request $request){

        if($request->date!=null && $request->date2!=null)
        {
            $date=$this->dateFormat($request->date);
            $date2=$this->dateFormat($request->date2);
            $masters=JournalRecord::whereIn('account_type_id',[4])->distinct()->get('account_head_id');
            $groupMasters=JournalRecord::whereIn('account_type_id',[3])->distinct()->get('master_account_id');

            return view('backend.accounts-report.income-statement-range',compact('masters','groupMasters','date','date2'));

        }
        elseif($request->date!=null && $request->date2==null)
        {
            $date=$this->dateFormat($request->date);
            $date2=$this->dateFormat($request->date);
            $masters=JournalRecord::whereIn('account_type_id',[4])->distinct()->get('account_head_id');
            $groupMasters=JournalRecord::whereIn('account_type_id',[3])->distinct()->get('master_account_id');

            return view('backend.accounts-report.income-statement-range',compact('masters','groupMasters','date','date2'));

        }
        elseif($request->date==null && $request->date2!=null)
        {
            $date=$this->dateFormat($request->date2);
            $date2=$this->dateFormat($request->date2);
            $masters=JournalRecord::whereIn('account_type_id',[4])->distinct()->get('account_head_id');
            $groupMasters=JournalRecord::whereIn('account_type_id',[3])->distinct()->get('master_account_id');

            return view('backend.accounts-report.income-statement-range',compact('masters','groupMasters','date','date2'));

        }

        else
        {
            $masters=JournalRecord::whereIn('account_type_id',[4])->distinct()->get('account_head_id');
            $groupMasters=JournalRecord::whereIn('account_type_id',[3])->distinct()->get('master_account_id');

            return view('backend.accounts-report.income-statement',compact('masters','groupMasters'));
        }
    }


    public function daily_report(Request $request)
    {
        $date=date('Y-m-d');
        $from=null;
        $to=null;
        if($request->date)
        {
            $date=$this->dateformat($request->date);

            $sales=JournalRecord::whereIn('account_type_id',[3])->where('journal_date',$date)->select('journal_id')->distinct()->get();
            // $purchases=JournalRecord::whereIn('account_head_id',[851])->where('journal_date',$date)->select('journal_id')->distinct()->get();
            $purchases=DB::table('journal_records')
                        ->leftJoin('account_heads','account_heads.id','=','journal_records.account_head_id')
                        ->where('account_heads.account_type_id',1)
                        ->where('account_heads.fld_definition','Sell of Asset')
                        ->where('journal_records.journal_date',$date)
                        ->select('journal_records.journal_id')
                        ->distinct()
                        ->get();

            $receiveds=JournalRecord::whereIn('account_head_id',[3])->where('transaction_type','CR')->where('journal_date',$date)->select('journal_id')->distinct()->get();
            $payments=JournalRecord::whereIn('account_head_id',[5])->where('transaction_type','DR')->where('journal_date',$date)->select('journal_id')->distinct()->get();
            $expensess=JournalRecord::whereNotIn('account_type_id',[4])->where('master_account_id',4)->where('transaction_type','DR')->where('journal_date',$date)->select('journal_id')->distinct()->get();

            $cash_balance=(JournalRecord::whereIn('account_head_id',[1])->where('journal_date',$date)->where('transaction_type','DR')->sum('total_amount'))-(JournalRecord::whereIn('account_head_id',[1])->where('journal_date',$date)->where('transaction_type','CR')->sum('total_amount'));
            $bank_balance=(JournalRecord::whereIn('account_head_id',[2])->where('journal_date',$date)->where('transaction_type','DR')->sum('total_amount'))-(JournalRecord::whereIn('account_head_id',[2])->where('journal_date',$date)->where('transaction_type','CR')->sum('total_amount'));
            $receivable_balance=(JournalRecord::whereIn('account_head_id',[3])->where('journal_date',$date)->where('transaction_type','DR')->sum('total_amount'))-(JournalRecord::whereIn('account_head_id',[27])->where('journal_date',$date)->where('transaction_type','CR')->sum('total_amount'));
            $payable_balance=(JournalRecord::whereIn('account_head_id',[5])->where('journal_date',$date)->where('transaction_type','DR')->sum('total_amount'))-(JournalRecord::whereIn('account_head_id',[26])->where('journal_date',$date)->where('transaction_type','CR')->sum('total_amount'));

        }
        elseif($request->from)
        {
            $from=$this->dateformat($request->from);
            $to=$this->dateformat($request->to);
            $sales=JournalRecord::whereIn('account_type_id',[3])->where('journal_date','>=',$from)->where('journal_date','<=',$to)->select('journal_id')->distinct()->get();
            // $purchases=JournalRecord::whereIn('account_head_id',[851])->where('journal_date','>=',$from)->where('journal_date','<=',$to)->select('journal_id')->distinct()->get();
            $purchases=DB::table('journal_records')
            ->leftJoin('account_heads','account_heads.id','=','journal_records.account_head_id')
            ->where('account_heads.account_type_id',1)
            ->where('account_heads.fld_definition','Sell of Asset')
            ->where('journal_records.journal_date','>=',$from)
            ->where('journal_records.journal_date','<=',$to)
            ->select('journal_records.journal_id')
            ->distinct()
            ->get();

            $receiveds=JournalRecord::whereIn('account_head_id',[3])->where('transaction_type','CR')->where('journal_date','>=',$from)->where('journal_date','<=',$to)->select('journal_id')->distinct()->get();
            $payments=JournalRecord::whereIn('account_head_id',[5])->where('transaction_type','DR')->where('journal_date','>=',$from)->where('journal_date','<=',$to)->select('journal_id')->distinct()->get();
            $expensess=JournalRecord::whereNotIn('account_type_id',[4])->where('master_account_id',4)->where('transaction_type','DR')->where('journal_date','>=',$from)->where('journal_date','<=',$to)->select('journal_id')->distinct()->get();

            $cash_balance=(JournalRecord::whereIn('account_head_id',[1])->where('journal_date','>=',$from)->where('journal_date','<=',$to)->where('transaction_type','DR')->sum('total_amount'))-(JournalRecord::whereIn('account_head_id',[1])->where('journal_date','>=',$from)->where('journal_date','<=',$to)->where('transaction_type','CR')->sum('total_amount'));
            $bank_balance=(JournalRecord::whereIn('account_head_id',[2])->where('journal_date','>=',$from)->where('journal_date','<=',$to)->where('transaction_type','DR')->sum('total_amount'))-(JournalRecord::whereIn('account_head_id',[2])->where('journal_date','>=',$from)->where('journal_date','<=',$to)->where('transaction_type','CR')->sum('total_amount'));
            $receivable_balance=(JournalRecord::whereIn('account_head_id',[3])->where('journal_date','>=',$from)->where('journal_date','<=',$to)->where('transaction_type','DR')->sum('total_amount'))-(JournalRecord::whereIn('account_head_id',[27])->where('journal_date','>=',$from)->where('journal_date','<=',$to)->where('transaction_type','CR')->sum('total_amount'));
            $payable_balance=(JournalRecord::whereIn('account_head_id',[5])->where('journal_date','>=',$from)->where('journal_date','<=',$to)->where('transaction_type','DR')->sum('total_amount'))-(JournalRecord::whereIn('account_head_id',[26])->where('journal_date','>=',$from)->where('journal_date','<=',$to)->where('transaction_type','CR')->sum('total_amount'));

        }
        else
        {
            $sales=JournalRecord::whereIn('account_type_id',[3])->where('journal_date',date('Y-m-d'))->select('journal_id')->distinct()->get();
            // $purchases=JournalRecord::whereIn('account_head_id',[851])->where('journal_date',date('Y-m-d'))->select('journal_id')->distinct()->get();
            $purchases=DB::table('journal_records')
                        ->leftJoin('account_heads','account_heads.id','=','journal_records.account_head_id')
                        ->where('account_heads.account_type_id',1)
                        ->where('account_heads.fld_definition','Sell of Asset')
                        ->where('journal_records.journal_date',date('Y-m-d'))
                        ->select('journal_records.journal_id')
                        ->distinct()
                        ->get();
            $receiveds=JournalRecord::whereIn('account_head_id',[3])->where('transaction_type','CR')->where('journal_date',date('Y-m-d'))->select('journal_id')->distinct()->get();
            $payments=JournalRecord::whereIn('account_head_id',[5])->where('transaction_type','DR')->where('journal_date',date('Y-m-d'))->select('journal_id')->distinct()->get();
            $expensess=JournalRecord::whereNotIn('account_type_id',[4])->where('master_account_id',4)->where('transaction_type','DR')->where('journal_date',date('Y-m-d'))->select('journal_id')->distinct()->get();
            $cash_balance=(JournalRecord::whereIn('account_head_id',[1])->where('journal_date',date('Y-m-d'))->where('transaction_type','DR')->sum('total_amount'))-(JournalRecord::whereIn('account_head_id',[1])->where('journal_date',date('Y-m-d'))->where('transaction_type','CR')->sum('total_amount'));
            $bank_balance=(JournalRecord::whereIn('account_head_id',[2])->where('journal_date',date('Y-m-d'))->where('transaction_type','DR')->sum('total_amount'))-(JournalRecord::whereIn('account_head_id',[2])->where('journal_date',date('Y-m-d'))->where('transaction_type','CR')->sum('total_amount'));
            $receivable_balance=(JournalRecord::whereIn('account_head_id',[3])->where('journal_date',date('Y-m-d'))->where('transaction_type','DR')->sum('total_amount'))-(JournalRecord::whereIn('account_head_id',[27])->where('journal_date',date('Y-m-d'))->where('transaction_type','CR')->sum('total_amount'));
            $payable_balance=(JournalRecord::whereIn('account_head_id',[5])->where('journal_date',date('Y-m-d'))->where('transaction_type','DR')->sum('total_amount'))-(JournalRecord::whereIn('account_head_id',[26])->where('journal_date',date('Y-m-d'))->where('transaction_type','CR')->sum('total_amount'));
            $date=date('Y-m-d');

        }
        return view('backend.accounts-report.daily-report',compact('from','to','expensess','sales','purchases','receiveds','date','payments','cash_balance','bank_balance','receivable_balance','payable_balance'));
    }



    public function daily_summary(Request $request)
    {
        if($request->date){
            $date = $this->dateFormat($request->date);
        }else{
            $date=date('Y-m-d');
        }
        // dd($date);
        $from = null;
        $to = null;
        if($request->from && $request->to){
            $from=$this->dateFormat($request->from);
            $to=$this->dateFormat($request->to);
            $opening_balance_receive_cash = Receipt::where('pay_mode', 'like', '%'.'Cash'.'%')->whereBetween('date', [$from, $to])->sum('total_amount');
            // dd($opening_balance_receive_cash);
            $opening_balance_payment_cash = Payment::where('pay_mode', 'Cash')->whereBetween('date', [$from, $to])->sum('total_amount');
            $opening_balance_receive_bank = Receipt::whereIn('pay_mode', ['Card', 'Bank'])->whereBetween('date', [$from, $to])->sum('total_amount');
            $opening_balance_payment_bank = Payment::whereIn('pay_mode', ['Card', 'Bank'])->whereBetween('date', [$from, $to])->sum('total_amount');
            $fund_allocation = FundAllocation::where('approved', 1)->whereBetween('date', [$from, $to])->select('amount', 'account_id_to', 'account_id_from', 'transaction_cost')->get();
            $previous_fund_allocation = FundAllocation::where('approved', 1)->whereBetween('date', [$from, $to])->select('amount', 'account_id_to', 'account_id_from', 'transaction_cost')->get();
            // dd($fund_allocation);
            $today_cash_sale_receipts=ReceiptSale::join('receipts','receipts.id','=','receipt_sales.payment_id')->where('receipts.pay_mode','like', '%'.'Cash'.'%')->join('tax_invoices','tax_invoices.id','=','receipt_sales.sale_id')->whereBetween('tax_invoices.date',[$from, $to])->select('receipt_sales.*', 'receipts.total_amount')->sum('receipts.total_amount');
            // dd($today_cash_sale_receipts);
            $previous_cash_sale_receipts=ReceiptSale::join('receipts','receipts.id','=','receipt_sales.payment_id')->where('receipts.pay_mode','like', '%'.'Cash'.'%')->whereBetween('receipts.date',[$from, $to])->join('tax_invoices','tax_invoices.id','=','receipt_sales.sale_id')->whereBetween('tax_invoices.date', [$from, $to])->select('receipt_sales.*', 'receipts.total_amount')->sum('receipts.total_amount');

            $today_cash_bill_payments=PaymentInvoice::where('come_from', 'expenses')->join('payments','payments.id','=','payment_invoices.payment_id')->where('payments.pay_mode','Cash')->join('purchase_expenses','purchase_expenses.id','=','payment_invoices.sale_id')->whereBetween('purchase_expenses.date',[$from, $to])->select('payment_invoices.*')->sum('payment_invoices.total_amount');

            $today_cash_bill_payments += PaymentInvoice::where('come_from', 'service_expense')->join('payments','payments.id','=','payment_invoices.payment_id')->where('payments.pay_mode','Cash')->join('supplier_invoices','supplier_invoices.id','=','payment_invoices.sale_id')->whereBetween('supplier_invoices.date',[$from, $to])->select('payment_invoices.*')->sum('payment_invoices.total_amount');
            // dd($today_cash_bill_payments);
            $previous_cash_bill_payments=PaymentInvoice::where('come_from', 'expenses')->join('payments','payments.id','=','payment_invoices.payment_id')->where('payments.pay_mode','Cash')->whereBetween('payments.date',[$from, $to])->join('purchase_expenses','purchase_expenses.id','=','payment_invoices.sale_id')->whereBetween('purchase_expenses.date',[$from, $to])->select('payment_invoices.*')->sum('payment_invoices.total_amount');

            $previous_cash_bill_payments += PaymentInvoice::where('come_from', 'service_expense')->join('payments','payments.id','=','payment_invoices.payment_id')->where('payments.pay_mode','Cash')->whereBetween('payments.date',[$from, $to])->join('supplier_invoices','supplier_invoices.id','=','payment_invoices.sale_id')->whereBetween('supplier_invoices.date',[$from, $to])->select('payment_invoices.*')->sum('payment_invoices.total_amount');
            // dd($previous_cash_bill_payments);
            $today_advance_cash_received = Receipt::where('type', 'advance')->whereBetween('date', [$from, $to])->where('pay_mode', 'Cash')->sum('total_amount');
            $today_advance_cash_payment = Payment::where('type', 'advance')->whereBetween('date', [$from, $to])->where('pay_mode', 'Cash')->sum('total_amount');

            $today_bank_sale_receipts=ReceiptSale::join('receipts','receipts.id','=','receipt_sales.payment_id')->whereIn('receipts.pay_mode',['Card', 'Bank'])->join('tax_invoices','tax_invoices.id','=','receipt_sales.sale_id')->whereBetween('tax_invoices.date',[$from, $to])->select('receipt_sales.*', 'receipts.total_amount')->sum('receipts.total_amount');

            $previous_bank_sale_receipts=ReceiptSale::join('receipts','receipts.id','=','receipt_sales.payment_id')->whereIn('receipts.pay_mode',['Card', 'Bank'])->whereBetween('receipts.date',[$from, $to])->join('tax_invoices','tax_invoices.id','=','receipt_sales.sale_id')->whereBetween('tax_invoices.date', [$from, $to])->select('receipt_sales.*', 'receipts.total_amount')->sum('receipts.total_amount');

            $today_bank_bill_payments=PaymentInvoice::where('come_from', 'expenses')->join('payments','payments.id','=','payment_invoices.payment_id')->whereIn('payments.pay_mode',['Card','Bank'])->join('purchase_expenses','purchase_expenses.id','=','payment_invoices.sale_id')->whereBetween('purchase_expenses.date',[$from, $to])->select('payment_invoices.*')->sum('payment_invoices.total_amount');

            $today_bank_bill_payments += PaymentInvoice::where('come_from', 'service_expense')->join('payments','payments.id','=','payment_invoices.payment_id')->whereIn('payments.pay_mode',['Card','Bank'])->join('supplier_invoices','supplier_invoices.id','=','payment_invoices.sale_id')->whereBetween('supplier_invoices.date',[$from, $to])->select('payment_invoices.*')->sum('payment_invoices.total_amount');

            $previous_bank_bill_payments=PaymentInvoice::where('come_from', 'expenses')->join('payments','payments.id','=','payment_invoices.payment_id')->whereIn('payments.pay_mode',['Card','Bank'])->whereBetween('payments.date',[$from, $to])->join('purchase_expenses','purchase_expenses.id','=','payment_invoices.sale_id')->where('purchase_expenses.date',[$from, $to])->select('payment_invoices.*')->sum('payment_invoices.total_amount');

            $previous_bank_bill_payments += PaymentInvoice::where('come_from', 'service_expense')->join('payments','payments.id','=','payment_invoices.payment_id')->whereIn('payments.pay_mode',['Card','Bank'])->whereBetween('payments.date',[$from, $to])->join('supplier_invoices','supplier_invoices.id','=','payment_invoices.sale_id')->where('supplier_invoices.date',[$from, $to])->select('payment_invoices.*')->sum('payment_invoices.total_amount');

            $today_advance_bank_received = Receipt::where('type', 'advance')->whereBetween('date', [$from, $to])->whereIn('pay_mode', ['Bank','Card'])->sum('total_amount');
            $today_advance_bank_payment = Payment::where('type', 'advance')->whereBetween('date', [$from, $to])->whereIn('pay_mode', ['Bank','Card'])->sum('total_amount');
            $today_advance_visa_card_payment = Payment::where('type', 'advance')->whereBetween('date', [$from, $to])->where('pay_mode', 'Card')->sum('total_amount');

            $previous_account_receivable = TaxInvoice::whereBetween('date', [$from, $to])->where('due_amount', '>', 0)->sum('due_amount');;
            $today_account_receivable = TaxInvoice::whereBetween('date', [$from, $to])->where('due_amount', '>', 0)->sum('due_amount');;

            $previous_account_payable = PurchaseExpense::whereBetween('date', [$from, $to])->where('due_amount', '>', 0)->sum('due_amount');
            $previous_account_payable += SupplierInvoice::whereBetween('date', [$from, $to])->where('due_amount', '>', 0)->sum('due_amount');
            $today_account_payable = PurchaseExpense::whereBetween('date', [$from, $to])->where('due_amount', '>', 0)->sum('due_amount');
            $today_account_payable += SupplierInvoice::whereBetween('date', [$from, $to])->where('due_amount', '>', 0)->sum('due_amount');
            $today_payments = PaymentInvoice::join('payments','payments.id','=','payment_invoices.payment_id')->whereBetween('payments.date',[$from, $to])->join('purchase_expenses','purchase_expenses.id','=','payment_invoices.sale_id')->whereBetween('purchase_expenses.date',[$from, $to])->select('payment_invoices.*', 'payments.date', 'payments.type', 'payments.pay_mode', 'payments.total_amount')->get();
            $previous_payments = PaymentInvoice::join('payments','payments.id','=','payment_invoices.payment_id')->whereBetween('payments.date',[$from, $to])->join('purchase_expenses','purchase_expenses.id','=','payment_invoices.sale_id')->whereBetween('purchase_expenses.date',[$from, $to])->select('payment_invoices.*', 'payments.date', 'payments.type', 'payments.pay_mode', 'payments.total_amount')->get();

        }else{
            $opening_balance_receive_cash = Receipt::where('pay_mode', 'like', '%'.'Cash'.'%')->where('date', '<', $date)->sum('total_amount');
            $opening_balance_payment_cash = Payment::where('pay_mode', 'Cash')->where('date', '<', $date)->sum('total_amount');
            $opening_balance_receive_bank = Receipt::whereIn('pay_mode', ['Bank', 'Card'])->where('date', '<', $date)->sum('total_amount');
            $opening_balance_payment_bank = Payment::whereIn('pay_mode', ['Bank', 'Card'])->where('date', '<', $date)->sum('total_amount');
            $fund_allocation = FundAllocation::where('approved', 1)->where('date', $date)->select('amount', 'account_id_to', 'account_id_from', 'transaction_cost')->get();
            $previous_fund_allocation = FundAllocation::where('approved', 1)->where('date', '<', $date)->select('amount', 'account_id_to', 'account_id_from', 'transaction_cost')->get();
            // dd($fund_allocation);
            $today_cash_sale_receipts=ReceiptSale::join('receipts','receipts.id','=','receipt_sales.payment_id')->where('receipts.pay_mode','like', '%'.'Cash'.'%')->join('tax_invoices','tax_invoices.id','=','receipt_sales.sale_id')->where('tax_invoices.date',$date)->select('receipt_sales.*', 'receipts.total_amount')->sum('receipts.total_amount');
            $previous_cash_sale_receipts=ReceiptSale::join('receipts','receipts.id','=','receipt_sales.payment_id')->where('receipts.pay_mode','like', '%'.'Cash'.'%')->where('receipts.date',$date)->join('tax_invoices','tax_invoices.id','=','receipt_sales.sale_id')->where('tax_invoices.date','<', $date)->select('receipt_sales.*', 'receipts.total_amount')->sum('receipts.total_amount');

            $today_cash_bill_payments=PaymentInvoice::join('payments','payments.id','=','payment_invoices.payment_id')->where('payments.pay_mode','Cash')->join('purchase_expenses','purchase_expenses.id','=','payment_invoices.sale_id')->where('purchase_expenses.date',$date)->select('payment_invoices.*')->sum('payment_invoices.total_amount');
            // dd($today_cash_bill_payments);
            $previous_cash_bill_payments=PaymentInvoice::join('payments','payments.id','=','payment_invoices.payment_id')->where('payments.pay_mode','Cash')->where('payments.date',$date)->join('purchase_expenses','purchase_expenses.id','=','payment_invoices.sale_id')->where('purchase_expenses.date','<',$date)->select('payment_invoices.*')->sum('payment_invoices.total_amount');
            // dd($previous_cash_bill_payments);
            $today_advance_cash_received = Receipt::where('type', 'advance')->where('date', $date)->where('pay_mode', 'Cash')->sum('total_amount');
            $today_advance_cash_payment = Payment::where('type', 'advance')->where('date', $date)->where('pay_mode', 'Cash')->sum('total_amount');

            // $today_bank_sale_receipts=ReceiptSale::join('receipts','receipts.id','=','receipt_sales.payment_id')->where('receipts.pay_mode','like', '%'.'Card'.'%')->orWhere('receipts.pay_mode','like', '%'.'Bank'.'%')->join('tax_invoices','tax_invoices.id','=','receipt_sales.sale_id')->where('tax_invoices.date',$date)->select('receipt_sales.*', 'receipts.total_amount')->sum('receipts.total_amount');
            $today_bank_sale_receipts=ReceiptSale::join('receipts','receipts.id','=','receipt_sales.payment_id')->whereIn('receipts.pay_mode',['Bank', 'Card'])->join('tax_invoices','tax_invoices.id','=','receipt_sales.sale_id')->where('tax_invoices.date',$date)->select('receipt_sales.*')->get();
            $previous_bank_sale_receipts=ReceiptSale::join('receipts','receipts.id','=','receipt_sales.payment_id')->whereIn('receipts.pay_mode',['Bank', 'Card'])->where('receipts.date',$date)->join('tax_invoices','tax_invoices.id','=','receipt_sales.sale_id')->where('tax_invoices.date','<', $date)->select('receipt_sales.*', 'receipts.total_amount')->sum('receipts.total_amount');
            // dd($today_bank_sale_receipts);
            $today_bank_bill_payments=PaymentInvoice::join('payments','payments.id','=','payment_invoices.payment_id')->whereIn('payments.pay_mode',['Card', 'Bank'])->join('purchase_expenses','purchase_expenses.id','=','payment_invoices.sale_id')->where('purchase_expenses.date',$date)->select('payment_invoices.*')->sum('payment_invoices.total_amount');
            $previous_bank_bill_payments=PaymentInvoice::join('payments','payments.id','=','payment_invoices.payment_id')->whereIn('payments.pay_mode',['Card', 'Bank'])->where('payments.date',$date)->join('purchase_expenses','purchase_expenses.id','=','payment_invoices.sale_id')->where('purchase_expenses.date','<',$date)->select('payment_invoices.*')->sum('payment_invoices.total_amount');

            $today_advance_bank_received = Receipt::where('type', 'advance')->where('date', $date)->whereIn('pay_mode', ['Card','Bank'])->sum('total_amount');
            $today_advance_bank_payment = Payment::where('type', 'advance')->where('date', $date)->whereIn('pay_mode', ['Card','Bank'])->sum('total_amount');
            $today_advance_visa_card_payment = Payment::where('type', 'advance')->where('date', $date)->where('pay_mode', 'Card')->sum('total_amount');

            $previous_account_receivable = TaxInvoice::where('date', '<', $date)->where('due_amount', '>', 0)->sum('due_amount');
            $today_account_receivable = TaxInvoice::where('date', $date)->where('due_amount', '>', 0)->sum('due_amount');

            $previous_account_payable = PurchaseExpense::where('date', '<', $date)->where('due_amount', '>', 0)->sum('due_amount');
            $previous_account_payable += SupplierInvoice::where('date', '<', $date)->where('due_amount', '>', 0)->sum('due_amount');
            $today_account_payable = PurchaseExpense::where('date', $date)->where('due_amount', '>', 0)->sum('due_amount');
            $today_account_payable += SupplierInvoice::where('date', $date)->where('due_amount', '>', 0)->sum('due_amount');
            // dd($previous_account_payable);

            $today_payments = PaymentInvoice::join('payments','payments.id','=','payment_invoices.payment_id')->where('payments.date',$date)->join('purchase_expenses','purchase_expenses.id','=','payment_invoices.sale_id')->where('purchase_expenses.date',$date)->select('payment_invoices.*', 'payments.date', 'payments.type', 'payments.pay_mode', 'payments.total_amount')->get();

            $previous_payments = PaymentInvoice::join('payments','payments.id','=','payment_invoices.payment_id')->where('payments.date',$date)->join('purchase_expenses','purchase_expenses.id','=','payment_invoices.sale_id')->where('purchase_expenses.date','<',$date)->select('payment_invoices.*', 'payments.date', 'payments.type', 'payments.pay_mode', 'payments.total_amount')->get();
        }
        // dd($previous_account_payable);


        // dd($previous_payments);
        return view('backend.accounts-report.daily-summary',compact('from','to','date', 'today_cash_sale_receipts', 'previous_cash_sale_receipts', 'today_cash_bill_payments', 'previous_cash_bill_payments', 'today_advance_cash_received', 'today_advance_cash_payment', 'today_bank_sale_receipts', 'previous_bank_sale_receipts', 'today_bank_bill_payments', 'previous_bank_bill_payments', 'today_advance_bank_received', 'today_advance_bank_payment', 'opening_balance_receive_cash', 'opening_balance_payment_cash', 'opening_balance_receive_bank', 'opening_balance_payment_bank', 'previous_account_receivable', 'today_account_receivable', 'previous_account_payable', 'today_account_payable', 'fund_allocation', 'today_payments', 'previous_payments', 'previous_fund_allocation'));
        // $agent = new Agent();
        // if($agent->isDesktop()){
        //     return view('backend.accounts-report.daily-summary',compact('from','to','date', 'today_cash_sale_receipts', 'previous_cash_sale_receipts', 'today_cash_bill_payments', 'previous_cash_bill_payments', 'today_advance_cash_received', 'today_advance_cash_payment', 'today_bank_sale_receipts', 'previous_bank_sale_receipts', 'today_bank_bill_payments', 'previous_bank_bill_payments', 'today_advance_bank_received', 'today_advance_bank_payment', 'opening_balance_receive_cash', 'opening_balance_payment_cash', 'opening_balance_receive_bank', 'opening_balance_payment_bank', 'previous_account_receivable', 'today_account_receivable', 'previous_account_payable', 'today_account_payable', 'fund_allocation', 'today_payments', 'previous_payments', 'previous_fund_allocation'));

        // }else{
        //     return view('mobile.daily-summary',compact('from','to','date', 'today_cash_sale_receipts', 'previous_cash_sale_receipts', 'today_cash_bill_payments', 'previous_cash_bill_payments', 'today_advance_cash_received', 'today_advance_cash_payment', 'today_bank_sale_receipts', 'previous_bank_sale_receipts', 'today_bank_bill_payments', 'previous_bank_bill_payments', 'today_advance_bank_received', 'today_advance_bank_payment', 'opening_balance_receive_cash', 'opening_balance_payment_cash', 'opening_balance_receive_bank', 'opening_balance_payment_bank', 'previous_account_receivable', 'today_account_receivable', 'previous_account_payable', 'today_account_payable', 'fund_allocation', 'today_payments', 'previous_payments', 'previous_fund_allocation'));
        // }
    }

    // cash summery details
    public function cash_today_sale_received(Request $request){
        // dd($request->date);
        if($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $today_cash_sale_receipts=ReceiptSale::join('receipts','receipts.id','=','receipt_sales.payment_id')->where('receipts.pay_mode','like', '%'.'Cash'.'%')->join('tax_invoices','tax_invoices.id','=','receipt_sales.sale_id')->whereBetween('tax_invoices.date',[$from, $to])->select('receipt_sales.*')->get();
        }else{
            $date = $request->date?$request->date:date('Y-m-d');
            $today_cash_sale_receipts=ReceiptSale::join('receipts','receipts.id','=','receipt_sales.payment_id')->where('receipts.pay_mode','like', '%'.'Cash'.'%')->join('tax_invoices','tax_invoices.id','=','receipt_sales.sale_id')->where('tax_invoices.date',$date)->select('receipt_sales.*')->get();
        }
        $receipt_list = $today_cash_sale_receipts;
        $cash = true;
        return view('backend.accounts-report.receipt-report', compact('receipt_list', 'cash'));
        // $agent = new Agent();
        // if($agent->isDesktop()){
        //     return view('backend.accounts-report.receipt-report', compact('receipt_list', 'cash'));
        // }else{
        //     return view('mobile.receipt-report', compact('receipt_list', 'cash'));
        // }
    }
    public function cash_previous_receivable_receive(Request $request){
        if($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $previous_cash_sale_receipts=ReceiptSale::join('receipts','receipts.id','=','receipt_sales.payment_id')->where('receipts.pay_mode','like', '%'.'Cash'.'%')->whereBetween('receipts.date',[$from, $to])->join('tax_invoices','tax_invoices.id','=','receipt_sales.sale_id')->whereBetween('tax_invoices.date',[$from, $to])->select('receipt_sales.*')->get();
        }else{
            $date = $request->date?$request->date:date('Y-m-d');
            $previous_cash_sale_receipts=ReceiptSale::join('receipts','receipts.id','=','receipt_sales.payment_id')->where('receipts.pay_mode','like', '%'.'Cash'.'%')->where('receipts.date',$date)->join('tax_invoices','tax_invoices.id','=','receipt_sales.sale_id')->where('tax_invoices.date','<', $date)->select('receipt_sales.*')->get();
        }
        $receipt_list = $previous_cash_sale_receipts;
        $cash = true;
        return view('backend.accounts-report.receipt-report', compact('receipt_list', 'cash'));
        // $agent = new Agent();
        // if($agent->isDesktop()){
        //     return view('backend.accounts-report.receipt-report', compact('receipt_list', 'cash'));
        // }else{
        //     return view('mobile.receipt-report', compact('receipt_list', 'cash'));
        // }
    }
    public function cash_advance_receive(Request $request){
        if($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $today_advance_cash_received = Receipt::where('type', 'advance')->whereBetween('date', [$from, $to])->where('pay_mode', 'Cash')->get();
        }else{
            $date = $request->date?$request->date:date('Y-m-d');
            $today_advance_cash_received = Receipt::where('type', 'advance')->where('date', $date)->where('pay_mode', 'Cash')->get();
        }
        $receipt_list = $today_advance_cash_received;
        return view('backend.accounts-report.receipt-report2', compact('receipt_list'));
        // $agent = new Agent();
        // if($agent->isDesktop()){
        //     return view('backend.accounts-report.receipt-report2', compact('receipt_list'));
        // }else{
        //     return view('mobile.receipt-report2', compact('receipt_list'));
        // }
    }
    public function cash_today_payment_expense(Request $request){
        if($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $today_cash_bill_payments=PaymentInvoice::join('payments','payments.id','=','payment_invoices.payment_id')->where('payments.pay_mode','Cash')->join('purchase_expenses','purchase_expenses.id','=','payment_invoices.sale_id')->whereBetween('purchase_expenses.date',[$from, $to])->select('payment_invoices.*')->get();
        }else{
            $date = $request->date?$request->date:date('Y-m-d');
            $today_cash_bill_payments=PaymentInvoice::join('payments','payments.id','=','payment_invoices.payment_id')->where('payments.pay_mode','Cash')->join('purchase_expenses','purchase_expenses.id','=','payment_invoices.sale_id')->where('purchase_expenses.date',$date)->select('payment_invoices.*')->get();
        }
        $payments = $today_cash_bill_payments;
        return view('backend.accounts-report.payment-report', compact('payments'));
        // $agent = new Agent();
        // if($agent->isDesktop()){
        //     return view('backend.accounts-report.payment-report', compact('payments'));
        // }else{
        //     return view('mobile.payment-report', compact('payments'));
        // }
    }
    public function cash_previous_payable_payment(Request $request){
        if($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $previous_cash_bill_payments=PaymentInvoice::join('payments','payments.id','=','payment_invoices.payment_id')->where('payments.pay_mode','Cash')->whereBetween('payments.date',[$from, $to])->join('purchase_expenses','purchase_expenses.id','=','payment_invoices.sale_id')->whereBetween('purchase_expenses.date',[$from, $to])->select('payment_invoices.*')->get();
        }else{
            $date = $request->date?$request->date:date('Y-m-d');
            $previous_cash_bill_payments=PaymentInvoice::join('payments','payments.id','=','payment_invoices.payment_id')->where('payments.pay_mode','Cash')->where('payments.date',$date)->join('purchase_expenses','purchase_expenses.id','=','payment_invoices.sale_id')->where('purchase_expenses.date','<',$date)->select('payment_invoices.*')->get();
        }
        $payments = $previous_cash_bill_payments;
        return view('backend.accounts-report.payment-report', compact('payments'));
        // $agent = new Agent();
        // if($agent->isDesktop()){
        //     return view('backend.accounts-report.payment-report', compact('payments'));
        // }else{
        //     return view('mobile.payment-report', compact('payments'));
        // }
    }
    public function today_payment_expense(Request $request, $pay_mode){
        if($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $today_cash_bill_payments=PaymentInvoice::join('payments','payments.id','=','payment_invoices.payment_id')->where('payments.pay_mode',$pay_mode)->join('purchase_expenses','purchase_expenses.id','=','payment_invoices.sale_id')->whereBetween('purchase_expenses.date', [$from, $to])->select('payment_invoices.*')->get();
        }else{
            $date = $request->date?$request->date:date('Y-m-d');
            $today_cash_bill_payments=PaymentInvoice::join('payments','payments.id','=','payment_invoices.payment_id')->where('payments.pay_mode',$pay_mode)->join('purchase_expenses','purchase_expenses.id','=','payment_invoices.sale_id')->where('purchase_expenses.date',$date)->select('payment_invoices.*')->get();
        }
        $payments = $today_cash_bill_payments;
        return view('backend.accounts-report.payment-report', compact('payments'));
        // $agent = new Agent();
        // if($agent->isDesktop()){
        //     return view('backend.accounts-report.payment-report', compact('payments'));
        // }else{
        //     return view('mobile.payment-report', compact('payments'));
        // }
    }
    public function previous_payment_expense(Request $request, $pay_mode){
        if($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $previous_cash_bill_payments=PaymentInvoice::join('payments','payments.id','=','payment_invoices.payment_id')->where('payments.pay_mode',$pay_mode)->whereBetween('payments.date', [$from, $to])->join('purchase_expenses','purchase_expenses.id','=','payment_invoices.sale_id')->whereBetween('purchase_expenses.date', [$from, $to])->select('payment_invoices.*')->get();
        }else{
            $date = $request->date?$request->date:date('Y-m-d');
            $previous_cash_bill_payments=PaymentInvoice::join('payments','payments.id','=','payment_invoices.payment_id')->where('payments.pay_mode',$pay_mode)->where('payments.date',$date)->join('purchase_expenses','purchase_expenses.id','=','payment_invoices.sale_id')->where('purchase_expenses.date','<',$date)->select('payment_invoices.*')->get();
        }
        $payments = $previous_cash_bill_payments;
        return view('backend.accounts-report.payment-report', compact('payments'));
        // $agent = new Agent();
        // if($agent->isDesktop()){
        //     return view('backend.accounts-report.payment-report', compact('payments'));
        // }else{
        //     return view('mobile.payment-report', compact('payments'));
        // }
    }
    public function cash_advance_payment(Request $request){
        if($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $today_advance_cash_payment = Payment::where('type', 'advance')->whereBetween('date', [$from, $to])->where('pay_mode', 'Cash')->get();
        }else{
            $date = $request->date?$request->date:date('Y-m-d');
            $today_advance_cash_payment = Payment::where('type', 'advance')->where('date', $date)->where('pay_mode', 'Cash')->get();
        }
        $payments = $today_advance_cash_payment;
        return view('backend.accounts-report.payment-report2', compact('payments'));
        // $agent = new Agent();
        // if($agent->isDesktop()){
        //     return view('backend.accounts-report.payment-report2', compact('payments'));
        // }else{
        //     return view('mobile.payment-report2', compact('payments'));
        // }
    }
    // bank summery details
    public function bank_today_sale_received(Request $request){
        if($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $today_bank_sale_receipts=ReceiptSale::join('receipts','receipts.id','=','receipt_sales.payment_id')->whereIn('receipts.pay_mode',['Bank', 'Card'])->join('tax_invoices','tax_invoices.id','=','receipt_sales.sale_id')->whereBetween('tax_invoices.date', [$from, $to])->select('receipt_sales.*')->get();
        }else{
            $date = $request->date?$request->date:date('Y-m-d');
            $today_bank_sale_receipts=ReceiptSale::join('receipts','receipts.id','=','receipt_sales.payment_id')->whereIn('receipts.pay_mode',['Bank','Card'])->join('tax_invoices','tax_invoices.id','=','receipt_sales.sale_id')->where('tax_invoices.date',$date)->select('receipt_sales.*')->get();
        }
        $receipt_list = $today_bank_sale_receipts;
        $cash = false;
        return view('backend.accounts-report.receipt-report', compact('receipt_list', 'cash'));
        // $agent = new Agent();
        // if($agent->isDesktop()){
        //     return view('backend.accounts-report.receipt-report', compact('receipt_list', 'cash'));
        // }else{
        //     return view('mobile.receipt-report', compact('receipt_list', 'cash'));
        // }
    }
    public function bank_previous_receivable_receive(Request $request){
        if($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $previous_bank_sale_receipts=ReceiptSale::join('receipts','receipts.id','=','receipt_sales.payment_id')->whereIn('receipts.pay_mode',['Bank', 'Card'])->whereBetween('receipts.date', [$from, $to])->join('tax_invoices','tax_invoices.id','=','receipt_sales.sale_id')->whereBetween('tax_invoices.date', [$from, $to])->select('receipt_sales.*')->get();
        }else{
            $date = $request->date?$request->date:date('Y-m-d');
            $previous_bank_sale_receipts=ReceiptSale::join('receipts','receipts.id','=','receipt_sales.payment_id')->whereIn('receipts.pay_mode',['Bank', 'Card'])->where('receipts.date',$date)->join('tax_invoices','tax_invoices.id','=','receipt_sales.sale_id')->where('tax_invoices.date','<', $date)->select('receipt_sales.*')->get();
        }
        $receipt_list = $previous_bank_sale_receipts;
        $cash = false;
        return view('backend.accounts-report.receipt-report', compact('receipt_list', 'cash'));
        // $agent = new Agent();
        // if($agent->isDesktop()){
        //     return view('backend.accounts-report.receipt-report', compact('receipt_list', 'cash'));
        // }else{
        //     return view('mobile.receipt-report', compact('receipt_list', 'cash'));
        // }
    }
    public function bank_advance_receive(Request $request){
        if($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $today_advance_bank_received = Receipt::where('type', 'advance')->whereBetween('date', [$from, $to])->whereIn('pay_mode', ['Bank','Card'])->get();
        }else{
            $date = $request->date?$request->date:date('Y-m-d');
            $today_advance_bank_received = Receipt::where('type', 'advance')->where('date', $date)->whereIn('pay_mode', ['Bank','Card'])->get();
        }
        // dd($today_advance_bank_received);
        $receipt_list = $today_advance_bank_received;
        return view('backend.accounts-report.receipt-report2', compact('receipt_list'));
        // $agent = new Agent();
        // if($agent->isDesktop()){
        //     return view('backend.accounts-report.receipt-report2', compact('receipt_list'));
        // }else{
        //     return view('mobile.receipt-report2', compact('receipt_list'));
        // }
    }
    public function bank_today_payment_expense(Request $request){
        if($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $today_bank_bill_payments=PaymentInvoice::join('payments','payments.id','=','payment_invoices.payment_id')->whereIn('payments.pay_mode',['Bank','Card'])->join('purchase_expenses','purchase_expenses.id','=','payment_invoices.sale_id')->whereBetween('purchase_expenses.date', [$from, $to])->select('payment_invoices.*')->get();
        }else{
            $date = $request->date?$request->date:date('Y-m-d');
            $today_bank_bill_payments=PaymentInvoice::join('payments','payments.id','=','payment_invoices.payment_id')->whereIn('payments.pay_mode',['Bank','Card'])->join('purchase_expenses','purchase_expenses.id','=','payment_invoices.sale_id')->where('purchase_expenses.date',$date)->select('payment_invoices.*')->get();
        }
        $payments = $today_bank_bill_payments;
        return view('backend.accounts-report.payment-report', compact('payments'));
        // $agent = new Agent();
        // if($agent->isDesktop()){
        //     return view('backend.accounts-report.payment-report', compact('payments'));
        // }else{
        //     return view('mobile.payment-report', compact('payments'));
        // }
    }
    public function bank_previous_payable_payment(Request $request){
        if($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $previous_bank_bill_payments=PaymentInvoice::join('payments','payments.id','=','payment_invoices.payment_id')->whereIn('payments.pay_mode',['Bank','Card'])->whereBetween('payments.date', [$from, $to])->join('purchase_expenses','purchase_expenses.id','=','payment_invoices.sale_id')->whereBetween('purchase_expenses.date', [$from, $to])->select('payment_invoices.*')->get();
        }else{
            $date = $request->date?$request->date:date('Y-m-d');
            $previous_bank_bill_payments=PaymentInvoice::join('payments','payments.id','=','payment_invoices.payment_id')->whereIn('payments.pay_mode',['Bank','Card'])->where('payments.date',$date)->join('purchase_expenses','purchase_expenses.id','=','payment_invoices.sale_id')->where('purchase_expenses.date','<',$date)->select('payment_invoices.*')->get();
        }
        $payments = $previous_bank_bill_payments;
        // dd($payments);
        return view('backend.accounts-report.payment-report', compact('payments'));
        // $agent = new Agent();
        // if($agent->isDesktop()){
        //     return view('backend.accounts-report.payment-report', compact('payments'));
        // }else{
        //     return view('mobile.payment-report', compact('payments'));
        // }
    }
    public function bank_advance_payment(Request $request){
        if($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $today_advance_bank_payment = Payment::where('type', 'advance')->whereBetween('date', [$from, $to])->whereIn('pay_mode',['Bank','Card'])->get();
        }else{
            $date = $request->date?$request->date:date('Y-m-d');
            $today_advance_bank_payment = Payment::where('type', 'advance')->where('date', $date)->whereIn('pay_mode',['Bank','Card'])->get();
        }
        $payments = $today_advance_bank_payment;
        return view('backend.accounts-report.payment-report2', compact('payments'));
        // $agent = new Agent();
        // if($agent->isDesktop()){
        //     return view('backend.accounts-report.payment-report2', compact('payments'));
        // }else{
        //     return view('mobile.payment-report2', compact('payments'));
        // }
    }
    // till day receivable and payable
    public function previous_account_receivable(Request $request){
        if($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $previous_account_receivable = TaxInvoice::whereBetween('date', [$from, $to])->where('due_amount', '>', 0)->get();
        }else{
            $date = $request->date?$request->date:date('Y-m-d');
            $previous_account_receivable = TaxInvoice::where('date', '<', $date)->where('due_amount', '>', 0)->get();
        }
        return view('backend.accounts-report.receipt-report3', compact('previous_account_receivable'));
    }
    public function today_account_receivable(Request $request){
        if($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $previous_account_receivable = TaxInvoice::whereBetween('date', [$from, $to])->where('due_amount', '>', 0)->get();
        }else{
            $date = $request->date?$request->date:date('Y-m-d');
            $previous_account_receivable = TaxInvoice::where('date', $date)->where('due_amount', '>', 0)->get();
        }
        return view('backend.accounts-report.receipt-report3', compact('previous_account_receivable'));
    }
    public function previous_account_payable(Request $request){
        if($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $previous_account_payable = PurchaseExpense::whereBetween('date', [$from, $to])->where('due_amount', '>', 0)->get();
            $previous_account_payable2 = SupplierInvoice::whereBetween('date', [$from, $to])->where('due_amount', '>', 0)->get();
        }else{
            $date = $request->date?$request->date:date('Y-m-d');
            $previous_account_payable = PurchaseExpense::where('date', '<', $date)->where('due_amount', '>', 0)->get();
            $previous_account_payable2 = SupplierInvoice::where('date', $date)->where('due_amount', '>', 0)->get();
        }
        return view('backend.accounts-report.payment-report3', compact('previous_account_payable', 'previous_account_payable2'));
        // $agent = new Agent();
        // if($agent->isDesktop()){
        //     return view('backend.accounts-report.payment-report3', compact('previous_account_payable'));
        // }else{
        //     return view('mobile.payment-report3', compact('previous_account_payable'));
        // }
    }
    public function today_account_payable(Request $request){
        if($request->from && $request->to){
            $from = $request->from;
            $to = $request->to;
            $previous_account_payable = PurchaseExpense::whereBetween('date', [$from, $to])->where('due_amount', '>', 0)->get();
            $previous_account_payable2 = SupplierInvoice::whereBetween('date', [$from, $to])->where('due_amount', '>', 0)->get();
        }else{
            $date = $request->date?$request->date:date('Y-m-d');
            $previous_account_payable = PurchaseExpense::where('date', $date)->where('due_amount', '>', 0)->get();
            $previous_account_payable2 = SupplierInvoice::where('date', $date)->where('due_amount', '>', 0)->get();
        }
        return view('backend.accounts-report.payment-report3', compact('previous_account_payable', 'previous_account_payable2'));
        // $agent = new Agent();
        // if($agent->isDesktop()){
        //     return view('backend.accounts-report.payment-report3', compact('previous_account_payable'));
        // }else{
        //     return view('mobile.payment-report3', compact('previous_account_payable'));
        // }
    }

    public function fund_transfer(Request $request, $from, $to){
        if($request->from && $request->to){
            $date_from = $request->from;
            $date_to = $request->to;
            $fund_allocations = FundAllocation::whereBetween('date', [$date_from, $date_to])->where('account_id_from', $from)->where('account_id_to', $to)->get();
        }else{
            $date = $request->date?$request->date:date('Y-m-d');
            $fund_allocations = FundAllocation::where('date', $date)->where('account_id_from', $from)->where('account_id_to', $to)->get();

        }
        return view('backend.accounts-report.fund-transfer', compact('fund_allocations'));
        // $agent = new Agent();
        // if($agent->isDesktop()){
        //     return view('backend.accounts-report.fund-transfer', compact('fund_allocations'));
        // }else{
        //     $from = PayMode::find($from);
        //     $to = PayMode::find($to);
        //     // dd($from);
        //     return view('mobile.fund-transfer', compact('fund_allocations', 'from', 'to'));
        // }
    }

    public function daily_summary_copy(Request $request)
    {
        $date=date('Y-m-d');
        $from=null;
        $to=null;
        if($request->date)
        {
            $date=$this->dateformat($request->date);

            $sales=JournalRecord::whereIn('account_head_id',[3])->where('transaction_type','CR')->where('journal_date',$date)->select('journal_id')->distinct()->get();
            $payable=JournalRecord::whereIn('account_head_id',[5])->where('transaction_type','DR')->where('journal_date',$date)->select('journal_id')->distinct()->get();
            $income=JournalRecord::whereIn('account_head_id',[7])->where('transaction_type','CR')->where('journal_date',$date)->select('journal_id')->distinct()->get();

            $purchases=JournalRecord::whereIn('account_head_id',[8])->where('transaction_type','DR')->where('journal_date',$date)->select('journal_id')->distinct()->get();


            $receiveds=JournalRecord::whereIn('account_head_id',[3])->where('transaction_type','CR')->where('journal_date',$date)->select('journal_id')->distinct()->get();
            $payments=JournalRecord::whereIn('account_head_id',[5])->where('transaction_type','DR')->where('journal_date',$date)->select('journal_id')->distinct()->get();
            $expensess=JournalRecord::whereNotIn('account_type_id',[4])->where('master_account_id',4)->where('transaction_type','DR')->where('journal_date',$date)->select('journal_id')->distinct()->get();

            $cash_balance=(JournalRecord::whereIn('account_head_id',[1])->where('journal_date',$date)->where('transaction_type','DR')->sum('total_amount'))-(JournalRecord::whereIn('account_head_id',[1])->where('journal_date',$date)->where('transaction_type','CR')->sum('total_amount'));
            $bank_balance=(JournalRecord::whereIn('account_head_id',[2])->where('journal_date',$date)->where('transaction_type','DR')->sum('total_amount'))-(JournalRecord::whereIn('account_head_id',[2])->where('journal_date',$date)->where('transaction_type','CR')->sum('total_amount'));
            $receivable_balance=(JournalRecord::whereIn('account_head_id',[3])->where('journal_date',$date)->where('transaction_type','DR')->sum('total_amount'))-(JournalRecord::whereIn('account_head_id',[3])->where('journal_date',$date)->where('transaction_type','CR')->sum('total_amount'));
            $payable_balance=(JournalRecord::whereIn('account_head_id',[5])->where('journal_date',$date)->where('transaction_type','DR')->sum('total_amount'))-(JournalRecord::whereIn('account_head_id',[5])->where('journal_date',$date)->where('transaction_type','CR')->sum('total_amount'));

        }
        elseif($request->from)
        {
            $from=$this->dateformat($request->from);
            $to=$this->dateformat($request->to);
            $sales=JournalRecord::whereIn('account_head_id',[3])->where('transaction_type','CR')->where('journal_date','>=',$from)->where('journal_date','<=',$to)->select('journal_id')->distinct()->get();
            $payable=JournalRecord::whereIn('account_head_id',[5])->where('transaction_type','DR')->where('journal_date','>=',$from)->where('journal_date','<=',$to)->select('journal_id')->distinct()->get();
            $income=JournalRecord::whereIn('account_head_id',[7])->where('transaction_type','CR')->where('journal_date','>=',$from)->where('journal_date','<=',$to)->select('journal_id')->distinct()->get();
            $purchases=JournalRecord::whereIn('account_head_id',[8])->where('transaction_type','DR')->where('journal_date','>=',$from)->where('journal_date','<=',$to)->select('journal_id')->distinct()->get();

            // // $purchases=JournalRecord::whereIn('account_head_id',[851])->where('journal_date','>=',$from)->where('journal_date','<=',$to)->select('journal_id')->distinct()->get();
            // $purchases=DB::table('journal_records')
            // ->leftJoin('account_heads','account_heads.id','=','journal_records.account_head_id')
            // ->where('account_heads.account_type_id',1)
            // ->where('account_heads.fld_definition','Sell of Asset')
            // ->where('journal_records.journal_date','>=',$from)
            // ->where('journal_records.journal_date','<=',$to)
            // ->select('journal_records.journal_id')
            // ->distinct()
            // ->get();

            $receiveds=JournalRecord::whereIn('account_head_id',[3])->where('transaction_type','CR')->where('journal_date','>=',$from)->where('journal_date','<=',$to)->select('journal_id')->distinct()->get();
            $payments=JournalRecord::whereIn('account_head_id',[5])->where('transaction_type','DR')->where('journal_date','>=',$from)->where('journal_date','<=',$to)->select('journal_id')->distinct()->get();
            $expensess=JournalRecord::whereNotIn('account_type_id',[4])->where('master_account_id',4)->where('transaction_type','DR')->where('journal_date','>=',$from)->where('journal_date','<=',$to)->select('journal_id')->distinct()->get();

            $cash_balance=(JournalRecord::whereIn('account_head_id',[1])->where('journal_date','>=',$from)->where('journal_date','<=',$to)->where('transaction_type','DR')->sum('total_amount'))-(JournalRecord::whereIn('account_head_id',[1])->where('journal_date','>=',$from)->where('journal_date','<=',$to)->where('transaction_type','CR')->sum('total_amount'));
            $bank_balance=(JournalRecord::whereIn('account_head_id',[2])->where('journal_date','>=',$from)->where('journal_date','<=',$to)->where('transaction_type','DR')->sum('total_amount'))-(JournalRecord::whereIn('account_head_id',[2])->where('journal_date','>=',$from)->where('journal_date','<=',$to)->where('transaction_type','CR')->sum('total_amount'));
            $receivable_balance=(JournalRecord::whereIn('account_head_id',[3])->where('journal_date','>=',$from)->where('journal_date','<=',$to)->where('transaction_type','DR')->sum('total_amount'))-(JournalRecord::whereIn('account_head_id',[3])->where('journal_date','>=',$from)->where('journal_date','<=',$to)->where('transaction_type','CR')->sum('total_amount'));
            $payable_balance=(JournalRecord::whereIn('account_head_id',[5])->where('journal_date','>=',$from)->where('journal_date','<=',$to)->where('transaction_type','DR')->sum('total_amount'))-(JournalRecord::whereIn('account_head_id',[5])->where('journal_date','>=',$from)->where('journal_date','<=',$to)->where('transaction_type','CR')->sum('total_amount'));

        }
        else
        {
            $sales=JournalRecord::whereIn('account_head_id',[3])->where('transaction_type','CR')->where('journal_date',date('Y-m-d'))->select('journal_id')->distinct()->get();
            $payable=JournalRecord::whereIn('account_head_id',[5])->where('transaction_type','DR')->where('journal_date',date('Y-m-d'))->select('journal_id')->distinct()->get();
            $income=JournalRecord::whereIn('account_head_id',[7])->where('transaction_type','CR')->where('journal_date',date('Y-m-d'))->select('journal_id')->distinct()->get();

            $purchases=JournalRecord::whereIn('account_head_id',[8])->where('transaction_type','DR')->where('journal_date',date('Y-m-d'))->select('journal_id')->distinct()->get();

            $receiveds=JournalRecord::whereIn('account_head_id',[3])->where('transaction_type','CR')->where('journal_date',date('Y-m-d'))->select('journal_id')->distinct()->get();
            $payments=JournalRecord::whereIn('account_head_id',[5])->where('transaction_type','DR')->where('journal_date',date('Y-m-d'))->select('journal_id')->distinct()->get();
            $expensess=JournalRecord::whereNotIn('account_type_id',[4])->where('master_account_id',4)->where('transaction_type','DR')->where('journal_date',date('Y-m-d'))->select('journal_id')->distinct()->get();
            $cash_balance=(JournalRecord::whereIn('account_head_id',[1])->where('journal_date',date('Y-m-d'))->where('transaction_type','DR')->sum('total_amount'))-(JournalRecord::whereIn('account_head_id',[1])->where('journal_date',date('Y-m-d'))->where('transaction_type','CR')->sum('total_amount'));
            $bank_balance=(JournalRecord::whereIn('account_head_id',[2])->where('journal_date',date('Y-m-d'))->where('transaction_type','DR')->sum('total_amount'))-(JournalRecord::whereIn('account_head_id',[2])->where('journal_date',date('Y-m-d'))->where('transaction_type','CR')->sum('total_amount'));
            $receivable_balance=(JournalRecord::whereIn('account_head_id',[3])->where('journal_date',date('Y-m-d'))->where('transaction_type','DR')->sum('total_amount'))-(JournalRecord::whereIn('account_head_id',[3])->where('journal_date',date('Y-m-d'))->where('transaction_type','CR')->sum('total_amount'));
            $payable_balance=(JournalRecord::whereIn('account_head_id',[5])->where('journal_date',date('Y-m-d'))->where('transaction_type','DR')->sum('total_amount'))-(JournalRecord::whereIn('account_head_id',[5])->where('journal_date',date('Y-m-d'))->where('transaction_type','CR')->sum('total_amount'));
            $date=date('Y-m-d');

        }
        return view('backend.accounts-report.daily-summary',compact('from','to','expensess','sales','purchases','receiveds','date','payments','cash_balance','bank_balance','receivable_balance','payable_balance','payable','income'));
    }

    public function balance_sheet(Request $request){

        if($request->date!=null && $request->date2!=null)
        {
            $date=$this->dateFormat($request->date);
            $date2=$this->dateFormat($request->date2);
            return view('backend.accounts-report.balance-sheet-range',compact('date','date2'));

        }
        elseif($request->date!=null && $request->date2==null)
        {
            $date=$this->dateFormat($request->date);
            $date2=$this->dateFormat($request->date);
            return view('backend.accounts-report.balance-sheet-range',compact('date','date2'));

        }
        elseif($request->date==null && $request->date2!=null)
        {
            $date=$this->dateFormat($request->date2);
            $date2=$this->dateFormat($request->date2);
            return view('backend.accounts-report.balance-sheet-range',compact('date','date2'));

        }

        else
        {
            return view('backend.accounts-report.balance-sheet');
        }
    }

    public function head_ledger_show(Request $request){
        $acc_head=AccountHead::find($request->id);
        return view('backend.accounts-report.head-ledger-show', compact('acc_head'));
    }


    public function sale_reports(Request $request){
        $from = null;
        $to = null;
        $date = null;
        if($request->from){
            $from = $this->dateFormat($request->from);
            if($request->to){
                $to = $this->dateFormat($request->to);
            }else{
                $to = date('Y-m-d');
            }
        }
        if($request->date){
            $date = $this->dateFormat($request->date);
        }
        $taxInvoces = TaxInvoice::orderBy('id', 'asc');
        if($from && $to){
            $taxInvoces = $taxInvoces->whereBetween('date', [$from, $to]);
        }elseif($date){
            $taxInvoces = $taxInvoces->where('date', $date);
        }else{
            $taxInvoces = $taxInvoces->where('date', date('Y-m-d'));
        }
        $taxInvoces = $taxInvoces->get();
        // dd($taxInvoces);
        return view('backend.accounts-report.sale-reports', compact('from', 'to', 'date', 'taxInvoces'));
    }
    public function purchase_reports(Request $request){
        $from = null;
        $to = null;
        $date = null;
        if($request->from){
            $from = $this->dateFormat($request->from);
            if($request->to){
                $to = $this->dateFormat($request->to);
            }else{
                $to = date('Y-m-d');
            }
        }
        if($request->date){
            $date = $this->dateFormat($request->date);
        }
        $purchases = Purchase::OrderBy('id', 'desc');
        if($from && $to){
            $purchases = $purchases->whereBetween('date', [$from, $to]);
        }elseif($date){
            $purchases = $purchases->where('date', $date);
        }else{
            $purchases = $purchases->where('date', date('Y-m-d'));
        }
        $purchases = $purchases->get();
        // dd($purchases);
        return view('backend.accounts-report.purchase-reports', compact('from', 'to', 'date', 'purchases'));
    }
    public function receivable_reports(Request $request){
        $from = null;
        $to = null;
        $date = null;
        $party_info = null;
        if($request->from){
            $from = $this->dateFormat($request->from);
            if($request->to){
                $to = $this->dateFormat($request->to);
            }else{
                $to = date('Y-m-d');
            }
        }
        if($request->date){
            $date = $this->dateFormat($request->date);
        }
        if($request->party_id){
            $party_info = $request->party_id;
        }
        $partys = PartyInfo::all();
        return view('backend.accounts-report.receivable-reports', compact('partys', 'from', 'to', 'date','party_info'));
    }
    public function payable_reports(Request $request){
        $from = null;
        $to = null;
        $date = null;
        $party_info = null;
        if($request->from){
            $from = $this->dateFormat($request->from);
            if($request->to){
                $to = $this->dateFormat($request->to);
            }else{
                $to = date('Y-m-d');
            }
        }
        if($request->date){
            $date = $this->dateFormat($request->date);
        }
        if($request->party_id){
            $party_info = $request->party_id;
        }
        $partys = PartyInfo::all();
        return view('backend.accounts-report.payable-reports', compact('partys', 'from', 'to', 'date','party_info'));
    }    
    public function vat_report(Request $request){
        $from = null;
        $to = null;
        $date = null;
        $journal_records = JournalRecord::whereIn('account_head_id', [17,18])->orderBy('journal_date', 'desc');
        if($request->from){
            $from = $this->dateFormat($request->from);
            if($request->to){
                $to = $this->dateFormat($request->to);
            }else{
                $to = date('Y-m-d');
            }
            $journal_records = $journal_records->whereBetween('journal_date', [$from, $to]);
        }elseif($request->date){
            $journal_records = $journal_records->where('journal_date', $this->dateFormat($request->date));
        }
        $journal_records = $journal_records->get();
        return view('backend.accounts-report.vat-report', compact( 'from', 'to', 'journal_records'));
    }
}
