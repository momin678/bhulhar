<?php

use App\Invoice;
use App\InvoiceTemp;
use App\Journal;
use App\PartyInfo;
use App\Payment;
use App\PaymentVoucher;
use App\Product;
use App\Purchase;
use App\PurchaseTemp;
use App\ReceiptVoucher;
use App\Setting;
use App\TempPaymentVoucher;
use App\TempReceiptVoucher;
use App\VatRate;
use Carbon\Carbon;

    // date formate change come from input field
    if(!function_exists('change_date_format')){
        function change_date_format($date){
            $date_array = explode('/',$date);
            $date_string = implode('-',$date_array);
            $date = date('Y-m-d',strtotime($date_string));
            return $date;
        }
    }
    // date formate convert come from databse table field
    if(!function_exists('convert_date_format')){
        function convert_date_format($date){
            $new_date = date('d/m/Y',strtotime($date));
            return $new_date;
        }
    }
    // new journal no create
    if(!function_exists('new_journal_no')){
        function new_journal_no(){
            $sub_invoice = Carbon::now()->format('Ymd');
            $latest_journal_no = Journal::withTrashed()->whereDate('created_at', Carbon::today())->where('journal_no', 'LIKE', "%{$sub_invoice}%")->latest('id')->first();
            if($latest_journal_no){
                $journal_no = substr($latest_journal_no->journal_no, 0, -1);
                $journal_code = $journal_no + 1;
                $journal_no = $journal_code . "J";
            }else{
                $journal_no = Carbon::now()->format('Ymd') . '001' . "J";
            }
            return $journal_no;
        }
    }
    // new temp purchase no create
    if(!function_exists('new_temp_purchase_no')){
        function new_temp_purchase_no(){
            $sub_invoice = Carbon::now()->format('Ymd');
            $latest_temp_purchase_no = PurchaseTemp::withTrashed()->whereDate('created_at', Carbon::today())->where('purchase_no', 'LIKE', "%{$sub_invoice}%")->latest('id')->first();
            if($latest_temp_purchase_no){
                $temp_purchase_no = substr($latest_temp_purchase_no->purchase_no, 2);
                $temp_purchase_code = $temp_purchase_no + 1;
                $temp_purchase_no = "P-".$temp_purchase_code;
            }else{
                $temp_purchase_no =  "P-".Carbon::now()->format('Ymd') . '001';
            }
            return $temp_purchase_no;
        }
    }
    // new purchase no create
    if(!function_exists('new_purchase_no')){
        function new_purchase_no(){
            $sub_invoice = Carbon::now()->format('Ymd');
            $latest_purchase_no = Purchase::withTrashed()->whereDate('created_at', Carbon::today())->where('purchase_no', 'LIKE', "%{$sub_invoice}%")->latest('id')->first();
            if($latest_purchase_no){
                $purchase_no = substr($latest_purchase_no->purchase_no, 2);
                $purchase_code = $purchase_no + 1;
                $purchase_no = "P-".$purchase_code;
            }else{
                $purchase_no =  "P-".Carbon::now()->format('Ymd') . '001';
            }
            return $purchase_no;
        }
    }
    // new sale/tax invoice no create
    if(!function_exists('temp_tax_invoice_no')){
        function temp_tax_invoice_no(){
            $sub_invoice = Carbon::now()->format('y');
            $latest_invoice_no = InvoiceTemp::where('invoice_no', 'LIKE', "%{$sub_invoice}%")->orderBy('invoice_no','desc')->first();
            if ($latest_invoice_no) {
                $invoice_no = substr($latest_invoice_no->invoice_no, 2);
                $invoice_code = $invoice_no + 1;
                $invoice_no = "S-".$invoice_code;
            } else {
                $invoice_no = "S-".Carbon::now()->format('y') . '0001';
            }
            return $invoice_no;
        }
    }
    // new sale/tax invoice no create
    if(!function_exists('tax_invoice_no')){
        function tax_invoice_no(){
            $sub_invoice = Carbon::now()->format('y');
            // dd($sub_invoice);
            $latest_invoice_no = Invoice::withTrashed()->where('invoice_no', 'LIKE', "%{$sub_invoice}%")->orderBy('invoice_no','desc')->first();
            // dd($latest_invoice_no);
            if ($latest_invoice_no) {
                $invoice_no = substr($latest_invoice_no->invoice_no, 2);
                $invoice_code = $invoice_no + 1;
                $invoice_no = "S-".$invoice_code;
            } else {
                $invoice_no = "S-".Carbon::now()->format('y') . '0001';
            }
            return $invoice_no;
        }
    }
    // party info pi_code create
    if(!function_exists('pi_code_create')){
        function pi_code_create(){
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
            return $cc;
        }
    }
    // temp in receipt no
    if(!function_exists('temp_receipt_no')){
        function temp_receipt_no(){
            $sub_invoice = Carbon::now()->format('Ymd');
            $latest_receipt_no = TempReceiptVoucher::whereDate('created_at', Carbon::today())->where('receipt_no', 'LIKE', "%{$sub_invoice}%")->orderBy('receipt_no','desc')->first();
            if ($latest_receipt_no) {
                $receipt_no = substr($latest_receipt_no->receipt_no, 3);
                $invoice_code = $receipt_no + 1;
                $receipt_no = "RV-".$invoice_code;
            } else {
                $receipt_no = "RV-".Carbon::now()->format('Ymd') . '001';
            }
            return $receipt_no;
        }
    }
    // receipt no
    if(!function_exists('receipt_no')){
        function receipt_no(){
            $sub_invoice = Carbon::now()->format('Ymd');
            $latest_receipt_no = ReceiptVoucher::whereDate('created_at', Carbon::today())->where('receipt_no', 'LIKE', "%{$sub_invoice}%")->orderBy('receipt_no','desc')->first();
            if ($latest_receipt_no) {
                $receipt_no = substr($latest_receipt_no->receipt_no, 3);
                $invoice_code = $receipt_no + 1;
                $receipt_no = "RV-".$invoice_code;
            } else {
                $receipt_no = "RV-".Carbon::now()->format('Ymd') . '001';
            }
            return $receipt_no;
        }
    }
    // temp in payment no
    if(!function_exists('temp_payment_no')){
        function temp_payment_no(){
            $sub_invoice = Carbon::now()->format('Ymd');
            $latest_payment_no = TempPaymentVoucher::whereDate('created_at', Carbon::today())->where('payment_no', 'LIKE', "%{$sub_invoice}%")->orderBy('payment_no','desc')->first();
            if ($latest_payment_no) {
                $payment_no = substr($latest_payment_no->payment_no, 3);
                $invoice_code = $payment_no + 1;
                $payment_no = "PV-".$invoice_code;
            } else {
                $payment_no = "PV-".Carbon::now()->format('Ymd') . '001';
            }
            return $payment_no;
        }
    }
    //  in payment no
    if(!function_exists('payment_no')){
        function payment_no(){
            $sub_invoice = Carbon::now()->format('Ymd');
            $latest_payment_no = Payment::whereDate('created_at', Carbon::today())->where('payment_no', 'LIKE', "%{$sub_invoice}%")->orderBy('payment_no','desc')->first();
            if ($latest_payment_no) {
                $payment_no = substr($latest_payment_no->payment_no, 3);
                $invoice_code = $payment_no + 1;
                $payment_no = "PV-".$invoice_code;
            } else {
                $payment_no = "PV-".Carbon::now()->format('Ymd') . '001';
            }
            return $payment_no;
        }
    }
    // company name
    if(!function_exists('company_name')){
        function company_name(){
            $company_name= Setting::where('config_name', 'company_name')->first();
            return $company_name->config_value;
        }
    }
    // company email
    if(!function_exists('company_email')){
        function company_email(){
            $company_email= Setting::where('config_name', 'company_email')->first();
            return $company_email->config_value;
        }
    }
    // company tele
    if(!function_exists('company_tele')){
        function company_tele(){
            $company_tele= Setting::where('config_name', 'company_tele')->first();
            return $company_tele->config_value;
        }
    }
    // company address
    if(!function_exists('company_address')){
        function company_address(){
            $company_address= Setting::where('config_name', 'company_address')->first();
            return $company_address->config_value;
        }
    }
    // company trn no
    if(!function_exists('trn_no')){
        function trn_no(){
            $trn_no= Setting::where('config_name', 'trn_no')->first();
            return $trn_no->config_value;
        }
    }
    // company trn no
    if(!function_exists('company_po_box')){
        function company_po_box(){
            return '816';
        }
    }
    if(!function_exists('vat_rate')){
        function vat_rate(){
            $vat_rate = VatRate::find(1);
            return $vat_rate->value;
        }
    }
    // product code 
    if(!function_exists('product_code')){
        function product_code(){
            $latest_barcode=Product::orderBy('id','DESC')->first();
            if($latest_barcode){
                $code=preg_replace('/^AS-/', '', $latest_barcode->barcode);
                $newcode=$code+1;
                $barcode="AS-".$newcode;
            }else{
                $barcode="AS-1000";
            }
            return $barcode;
        }
    }


?>