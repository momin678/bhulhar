<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use NumberFormatter;

class TaxInvoiceTemp extends Model
{
    public function items(){
        return $this->hasMany(TaxInvoiceItemTemp::class,'invoice_id');
    }

    public function customer(){
        return $this->belongsTo(PartyInfo::class,'customer_id');
    }
       public function party(){
        return $this->belongsTo(PartyInfo::class,'customer_id');
    }
    public function column_show(){
        return $this->hasOne(InvoiceColumnCheck::class,'tax_invoice_temp_id');
    }
    public function project(){
        return $this->belongsTo(ProjectDetail::class,'project_id');
    }
    // mominul
    public function created_by_user(){
        return $this->belongsTo(User::class, 'created_by');
    }
    public function authorized_by_user(){
        return $this->belongsTo(User::class, 'authorized_by');
    }
    public function approved_by_user(){
        return $this->belongsTo(User::class, 'approved_by');
    }
    public function declined_by_user(){
        return $this->belongsTo(User::class, 'declined_by');
    }
    public function toll_name(){
        return $this->belongsTo(TollFees::class, 'toll_name_id');
    }
    public static function convertNumberToWords($number)
    {
       $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
       return $formatter->format($number);

    }


}
