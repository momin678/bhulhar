<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobProjectInvoice extends Model
{
    protected $guarded = [];

    public function tasks(){
        return $this->hasMany(JobProjectInvoiceTask::class,'invoice_id');
    }

    public function party(){
        return $this->belongsTo(PartyInfo::class,'customer_id');
    }

    public function project(){
        return $this->belongsTo(JobProject::class,'job_project_id');
    }
    public function receipts(){
        return $this->hasMany(ReceiptSale::class,'sale_id');
    }

    public function tempReceipt()
    {
        return $this->hasOne(TempReceiptVoucherDetail::class,'sale_id');
    }

    public function tem_receipt_amount()
    {
        return $this->hasMany(TempReceiptVoucherDetail::class,'sale_id')->sum('Total_amount');
    }


}
