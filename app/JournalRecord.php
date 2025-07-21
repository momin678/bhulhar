<?php

namespace App;
use App\Models\AccountHead;
use App\Models\CostCenter;
use App\Models\MasterAccount;
use Illuminate\Database\Eloquent\Model;

class JournalRecord extends Model
{
    protected $guarded = [];  
    
    public function journal(){
        return $this->belongsTo(Journal::class);
    }

    public function ac_head(){
        return $this->belongsTo(AccountHead::class,'account_head_id');
    }

    public function master_ac(){
        return $this->belongsTo(MasterAccount::class,'master_account_id');
    }

    public function openingBalanceLadgerDR($id,$date)
    {
        // dd($this);
        return JournalRecord::where('journal_date','<',$date)->where('account_head_id',$id)->where('transaction_type','DR')->sum('amount');
        // $sum=0;
        // $records=JournalRecord::where('account_head_id',$id)->where('journal_date','<',$date)->distinct()->get('journal_id');
        // foreach($records as $r)
        // {
        //     $sum=$sum+JournalRecord::where('journal_id',$r->journal_id)->where('account_head_id','!=',$id)->where('transaction_type','CR')->sum('amount');
        // }
        // return $sum;
    }


    public function openingBalanceLadgerCR($id,$date)
    {
        return JournalRecord::where('journal_date','<',$date)->where('account_head_id',$id)->where('transaction_type','CR')->sum('amount');
        // $sum=0;
        // $records=JournalRecord::where('account_head_id',$id)->where('journal_date','<',$date)->distinct()->get('journal_id');
        // foreach($records as $r)
        // {
        //     // DD(JournalRecord::where('journal_id',$r->journal_id)->where('account_head_id','!=',$id)->where('transaction_type','CR')->get());
        //     $sum=$sum+JournalRecord::where('journal_id',$r->journal_id)->where('account_head_id','!=',$id)->where('transaction_type','DR')->sum('amount');
        // }
        // // dd($sum);
        // return $sum;
    }


    public function balanceCD($id)
    {
       $records = JournalRecord::where('account_head_id', $id)->where('journal_id', '!=',0)->get();
       $dr=0;
       $cr=0;
       foreach($records as $r)
       {
        $reverse= $r->transaction_type== "DR" ? "CR" : "DR";
        foreach ($r_count=JournalRecord::where('journal_id',$r->journal_id)->where('transaction_type', $reverse)->get() as $ledger_record)
        {
            if($r_count->count()>1)
            {
                if($r->transaction_type=='DR')
                {
                    $dr=$dr+ $ledger_record->amount;
                }
                else
                {
                    $cr=$cr+ $ledger_record->amount;
                }
            }
            else
            {
                if($r->transaction_type=='DR')
                {
                    $dr=$dr+ $r->amount;
                }
                else
                {
                    $cr=$cr+ $r->amount;
                }
            }
        }
       }
       return $dr-$cr;
    }


    public function masterbalanceCD($id)
    {
       $records = JournalRecord::where('master_account_id', $id)->where('journal_id', '!=',0)->get();
       $dr=0;
       $cr=0;
       foreach($records as $r)
       {
        $reverse= $r->transaction_type== "DR" ? "CR" : "DR";
        foreach ($r_count=JournalRecord::where('journal_id',$r->journal_id)->where('transaction_type', $reverse)->get() as $ledger_record)
        {
            if($r_count->count()>1)
            {
                if($r->transaction_type=='DR')
                {
                    $dr=$dr+ $ledger_record->amount;
                }
                else
                {
                    $cr=$cr+ $ledger_record->amount;
                }
            }
            else
            {
                if($r->transaction_type=='DR')
                {
                    $dr=$dr+ $r->amount;
                }
                else
                {
                    $cr=$cr+ $r->amount;
                }
            }
        }
       }
       return $dr-$cr;
    }


    
    public function accCD($id)
    {
       $records = JournalRecord::where('account_head_id', $id)->where('journal_id', '!=',0)->get();
       $dr=JournalRecord::where('account_head_id', $id)->where('journal_id', '!=',0)->where('transaction_type','DR')->sum('amount');
       $cr=JournalRecord::where('account_head_id', $id)->where('journal_id', '!=',0)->where('transaction_type','CR')->sum('amount');
      
       return $dr-$cr;
    }

    public function party()
    {
        return $this->belongsTo(PartyInfo::class,'party_info_id');
    }

    

    public function inventoryBalance()
    {
        $inventoryCredit=JournalRecord::where('master_account_id',$this->master_account_id)->where('transaction_type','CR')->sum('amount');
        $inventoryDebit=JournalRecord::where('master_account_id',$this->master_account_id)->where('transaction_type','DR')->sum('amount');
        return $inventoryDebit-$inventoryCredit;

    }


    public function headBalance($id)
    {
        $dr = JournalRecord::where('account_head_id', $id)->where('transaction_type','DR')->sum('amount');
        $cr = JournalRecord::where('account_head_id', $id)->where('transaction_type','CR')->sum('amount');
        return $dr-$cr;


    }


    public function headOpeningBalance($id,$date)
    {
       
        $dr = JournalRecord::where('account_head_id', $id)->where('transaction_type','DR')->where('journal_date','<',$date)->sum('amount');
        $cr = JournalRecord::where('account_head_id', $id)->where('transaction_type','CR')->where('journal_date','<',$date)->sum('amount');
       
        return $dr-$cr;


    }

    public function inventoryOpeningBalance($date)
    {
        $inventoryCredit=JournalRecord::where('master_account_id',$this->master_account_id)->where('transaction_type','CR')->where('journal_date','<',$date)->sum('amount');
        $inventoryDebit=JournalRecord::where('master_account_id',$this->master_account_id)->where('transaction_type','DR')->where('journal_date','<',$date)->sum('amount');
        return $inventoryDebit-$inventoryCredit;

    }

    public function headClosingBalance($id,$date)
    {
        $dr = JournalRecord::where('account_head_id', $id)->where('transaction_type','DR')->where('journal_date','<=',$date)->sum('amount');
        $cr = JournalRecord::where('account_head_id', $id)->where('transaction_type','CR')->where('journal_date','<=',$date)->sum('amount');
        return $dr-$cr;


    }

    public function inventoryClosingBalance($date)
    {
        $inventoryCredit=JournalRecord::where('master_account_id',$this->master_account_id)->where('transaction_type','CR')->where('journal_date','<=',$date)->sum('amount');
        $inventoryDebit=JournalRecord::where('master_account_id',$this->master_account_id)->where('transaction_type','DR')->where('journal_date','<=',$date)->sum('amount');
        // dd($inventoryCredit-$inventoryDebit);
        return $inventoryDebit-$inventoryCredit;

    }

    public function headTransection($id,$date,$date2,$type)
    {

        return JournalRecord::where('account_head_id', $id)->where('transaction_type',$type)->where('journal_date','>=',$date)->where('journal_date','<=',$date2)->sum('amount');

    }


    public function inventoryTransection($date,$date2,$type)
    {
        return JournalRecord::where('master_account_id',$this->master_account_id)->where('transaction_type',$type)->where('journal_date','>=',$date)->where('journal_date','<=',$date2)->sum('amount');
    }



    public static function openingProfit($date)
    {
        $dr=JournalRecord::whereIn('account_type_id',[4,3])->where('transaction_type','DR')->where('journal_date','<',$date)->sum('amount');
        $cr=JournalRecord::whereIn('account_type_id',[4,3])->where('transaction_type','CR')->where('journal_date','<',$date)->sum('amount');
        return $dr-$cr;

    }


    public static function openingProfitBalanceSheet($date)
    {
        $dr=JournalRecord::whereIn('account_type_id',[1,6,2])->where('transaction_type','DR')->where('journal_date','<',$date)->sum('amount');
        $cr=JournalRecord::whereIn('account_type_id',[1,6,2])->where('transaction_type','CR')->where('journal_date','<',$date)->sum('amount');
        return $dr-$cr;

    }

    public function headDrCrTransaction($date,$date2)
    {
        $dr=JournalRecord::where('account_head_id', $this->account_head_id)->where('transaction_type','DR')->whereBetween('journal_date',[$date,$date2])->sum('amount');
        $cr=JournalRecord::where('account_head_id', $this->account_head_id)->where('transaction_type','CR')->whereBetween('journal_date',[$date,$date2])->sum('amount');
        return $dr-$cr;


    }

    public function inventoryDrCrTransection($date,$date2)
    {
        $dr= JournalRecord::where('master_account_id',$this->master_account_id)->where('transaction_type','DR')->whereBetween('journal_date',[$date,$date2])->sum('amount');
        $cr= JournalRecord::where('master_account_id',$this->master_account_id)->where('transaction_type','CR')->whereBetween('journal_date',[$date,$date2])->sum('amount');
        return $dr-$cr;

    }
    public static function dailyHeadOpeningBalance($id,$date,$from, $to)
    {
       if($from && $to){
            $dr = JournalRecord::where('account_head_id', $id)->where('transaction_type','DR')->whereBetween('journal_date',[$from, $to])->sum('amount');
            $cr = JournalRecord::where('account_head_id', $id)->where('transaction_type','CR')->where('journal_date',[$from, $to])->sum('amount');
       }else{
            $dr = JournalRecord::where('account_head_id', $id)->where('transaction_type','DR')->where('journal_date','<',$date)->sum('amount');
            $cr = JournalRecord::where('account_head_id', $id)->where('transaction_type','CR')->where('journal_date','<',$date)->sum('amount');
       }
    //    dd($cr);
        return $dr-$cr;


    }
}
