<?php

namespace App;

use App\Models\AccountHead;
use App\Models\CostCenter;
use App\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Journal extends Model
{
    use  SoftDeletes;
    public function records(){
        return $this->hasMany(JournalRecord::class);
    }
    public function project()
    {
        return $this->belongsTo(ProjectDetail::class, 'project_id');
    }

    public function purchaseExp()
    {
        return $this->belongsTo(PurchaseExpense::class, 'purchase_expense_id');
    }


    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id');
    }

    public function profitCenter()
    {
        return $this->belongsTo(ProfitCenter::class, 'profit_center_id');
    }

    public function PartyInfo()
    {
        return $this->belongsTo(PartyInfo::class, 'party_info_id');
    }

    public function accHead()
    {
        return $this->belongsTo(AccountHead::class, 'account_head_id');
    }

    public function taxRate()
    {
        return $this->belongsTo(VatRate::class, 'tax_rate');
    }

    public function creditPartyInfo()
    {
        return $this->belongsTo(PartyInfo::class, 'credit_party_info');
    }

    public function dateJournal($date,$partyInfo)
    {
        $count=0;
        $journals=Journal::whereDate('date',$date)->where('party_info_id',$partyInfo->id)->get();
        foreach($journals as $j)
        {
            $count=$count+$j->records->count();
        }

        return $count;

    }

    // work by mominul
    public function voucher_type(){
        return $this->hasOne(DebitCreditVoucher::class,'journal_id');
    }

    public function party()
    {
        return $this->belongsTo(PartyInfo::class, 'party_info_id');
    }
    public function invoice(){
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
    public function receipt_voucher(){
        return $this->belongsTo(ReceiptVoucher::class, 'receipt_id');
    }
    public function payment_voucher(){
        return $this->belongsTo(PaymentVoucher::class, 'payment_id');
    }
    public function charity(){
        return $this->belongsTo(CharityConllection::class, 'cahrity_id');
    }


    public static function student_opening_balance($student,$from_date){
        $party=PartyInfo::where('student_id',$student)->first();

        $cr=JournalRecord::where('party_info_id', $party->id)->where('journal_date','<', $from_date)->where('account_head_id','26')->where('transaction_type','CR')->sum('amount');
        $dr=JournalRecord::where('party_info_id', $party->id)->where('journal_date','<', $from_date)->where('account_head_id','26')->where('transaction_type','DR')->sum('amount');
        $cr2=JournalRecord::where('party_info_id', $party->id)->where('journal_date','<', $from_date)->where('account_head_id','27')->where('transaction_type','CR')->sum('amount');
        $dr2=JournalRecord::where('party_info_id', $party->id)->where('journal_date','<', $from_date)->where('account_head_id','27')->where('transaction_type','DR')->sum('amount');
        $cr3=JournalRecord::where('party_info_id', $party->id)->where('journal_date','<', $from_date)->where('account_head_id','853')->where('transaction_type','CR')->sum('amount');

        $dr3=JournalRecord::where('party_info_id', $party->id)->where('journal_date','<', $from_date)->where('account_head_id','853')->where('transaction_type','DR')->sum('amount');
        $amount = $dr-$cr2+$dr2-$cr3+$dr3 - $cr;
        $balance=$cr+$dr-$cr2+$dr2-$cr3+$dr3;
        return $balance;
    }
}
