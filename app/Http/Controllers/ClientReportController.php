<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientReportController extends Controller
{
    public function setupReport(){
        return view('clientReport.setup.setup');
    }
    public function vehicle(){
        return view('backend.truck.module-note');
    }
    public function customer_inv(){
        return view('clientReport.customer-inv.customer-inv');
    }
    public function purchaseReport (){
        return view('clientReport.purchase.purchase');
    }
    public function paymentReport (){
        return view('clientReport.payment.purchase');
    }

    public function salesReport()
    {
        return view('clientReport.sales.sale');
    }

    public function accountingReport()
    {
        return view('clientReport.accounting.accounting');
    }

    public function report()
    {
        return view('clientReport.report.report');

    }
    public function projectReport(){
        return view('clientReport.project.report');
    }

    public function receiptReport()
    {
        return view('clientReport.receipt.report');

    }
    public function hrReport(){
        return view('clientReport.hrPayroll.hr_payroll');
    }

    public function partyReport()
    {
        return view('clientReport.party.report');

    }
    public function administrationReport(){
        return view('clientReport.administration');
    }

    public function lpo_bill_report(){
        return view('clientReport.lpo-bill.lpo-bill');
    }
    
    public function business_operation(){
        return view('clientReport.business-operation.business-operation');
    }
    
    public function service_inventory(){
        return view('clientReport.service-inentory.service-inentory');
    }
}
