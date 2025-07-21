<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public function items($invoice_no)
    {
        $items=PurchaseItem::where('purchase_id', $invoice_no)->get();
        return $items;
    }
    
      public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class,'purchase_id');
    }

    public function project()
    {
        return $this->belongsTo(ProjectDetail::class,'project_id');

    }

    public function vatAmount()
    {
        return $this->hasMany(PurchaseItem::class,'purchase_id')->sum('vat');
    }

    public function TotalAmount()
    {
        return $this->hasMany(PurchaseItem::class,'purchase_id')->sum('total_price');
    }
    public function taxableAmount()
    {
        return $this->hasMany(PurchaseItem::class,'purchase_id')->sum('price');
    }


    public function partyInfo($pi)
    {
        $pi=PartyInfo::where('pi_code',$pi)->first();
        return $pi;
    }

    public function taxbleSup($invoice_no)
    {
        return $this->items($invoice_no)->sum('total_unit_price');
    }

    public function vat($invoice_no)
    {
        return $this->items($invoice_no)->sum('vat_amount');
    }

    public function grossTotal($invoice_no)
    {
        return $this->items($invoice_no)->sum('cost_price');
    }

    public function itemStock($itm)
    {
        // return $itm;
        return $this->hasMany(StockTransection::class, 'transection_id')->where('item_id',$itm)->where('stock_effect', -1)->sum('quantity');
    }

    public function invoiceAmount()
    {
        return $this->hasOne(InvoiceAmount::class,'invoice_id');
    }
    public function fifoInvoice()
    {
        return $this->hasMany(FifoInvoice::class,'invoice_id')->orderBy('id','desc');

    }

    public function deliveryNote()
    {
        return $this->belongsTo(DeliveryNote::class,'delivery_note_id');
    }

    //  work by mominul
    public function receipt_voucher($id){
        $paid_amount = ReceiptVoucher::where("tax_invoice_id", $id)->get();
        return $paid_amount->sum("paid_amount");
    }

    public function journal()
    {
        // dd(1);
        return $this->hasOne(Journal::class,'purchase_no','purchase_no');
    }
}
