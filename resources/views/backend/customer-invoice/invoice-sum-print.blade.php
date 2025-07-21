<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/print.css') }}">

    <title>Invoice</title>
</head>

<style>
    .headerGroup:after {
        content: 'Text';
        background-image: url('img/balraj-header.png');
    }
    .table-font tr td{
        font-size: 13px !important;
    }
    .table-font tr th{
        font-size: 13px !important;
    }
    .table-header tr th{
        font-size: 13px !important;
    }
    tbody, td, tfoot, th, thead, tr {
        border-color: #4b4949d2;
    }
    .sort-invoice-footer, .footer-block {
        height: 130px;
		background-color: none;
    }
    .description{
        min-width: 350px !important;
    }
    .company-info{
        color: white;
        background-color: rgb(230 108 96);
        padding-bottom: 5px;
    }
    h2{
        font-family: Cambria;
    }
    .bg-color{
        background: #4b494949 !important;
    }
    @media print{
        
        .bg-color{
            background: #4b494949 !important;
        }
    }
</style>

<body onload="window.print();">
    @php
    $company_name= \App\Setting::where('config_name', 'company_name')->first();
    $company_address= \App\Setting::where('config_name', 'company_address')->first();
    $company_tele= \App\Setting::where('config_name', 'company_tele')->first();
    $company_email= \App\Setting::where('config_name', 'company_email')->first();
    $trn_no= \App\Setting::where('config_name', 'trn_no')->first();
    $company_logo= \App\Setting::where('config_name', 'company_logo')->first();
    $company_trn= \App\Setting::where('config_name', 'trn_no')->first();
    @endphp
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <table width="100%">
            <thead>
                <tr>
                    <td class="headerGroup">
                        <div class="header-block">
                            {{-- <table class="table table-bordered">
                                <tr>
                                    <th>Tax Invoice</th>
                                </tr>
                            </table> --}}
                        </div>
                    </td>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td class="footerGroup">
                        <div class="footer-block"></div>
                    </td>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <td>
                        <div class="page-container">
                            <div class="page">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <h2>Tax Invoice</h2>
                                        <p>TRN: {{$company_trn->config_value}}</p>
                                    </div>
                                </div>
                                <div class="row mb-2 mt-1 " style="margin-right: 0px; margin-left:0px;background:#d7eaef">
                                    <div class="col-12 d-flex"  style="border: 1px solid #4b4949d2;">
    
                                        <div class="col-8 d-flex flex-column d-flex align-items-center">
                                            <div class="row customer-box-2 flex-fill">
                                                @if($invoice->column_show->customer_name_check == 1)
    
                                                <div class="col-3">
                                                    <span class="text-left invoice-p"> CUSTOMER</span>
                                                </div>
                                                <div class="col-9">
                                                    <span class="text-right invoice-p">: {{$invoice->customer?
                                                        $invoice->customer->pi_name:''}}</span>
                                                </div>
    
                                                @endif
                                                @if($invoice->column_show->customer_address_check == 1)
                                                <div class="col-3">
                                                    <span class="text-left invoice-p">ADDRESS</span>
                                                </div>
                                                <div class="col-9">
                                                    <span class="text-right invoice-p">: {{$invoice->customer?
                                                        $invoice->customer->address:''}}</span>
                                                </div>
                                                @endif
                                                @if($invoice->column_show->customer_trn_check == 1)
                                                <div class="col-3">
                                                    <span class="text-left invoice-p">TRN</span>
                                                </div>
                                                <div class="col-9">
                                                    <span class="text-right invoice-p">: {{$invoice->customer?
                                                        $invoice->customer->trn_no:''}}</span>
                                                </div>
                                                @endif
                                                @if($invoice->column_show->customer_phone_check == 1)
                                                <div class="col-3">
                                                    <span class="text-left invoice-p">PHONE</span>
                                                </div>
    
                                                <div class="col-9">
                                                    <span class="text-right invoice-p">: {{$invoice->customer?
                                                        $invoice->customer->phone_no:''}}</span>
                                                </div>
                                                @endif
                                                @if($invoice->column_show->pay_term == 1)
                                                <div class="col-3">
                                                    <span class="text-left invoice-p">PAY TERM</span>
                                                </div>
    
                                                <div class="col-9">
                                                    <span class="text-right invoice-p">: {{ $invoice->pay_term }} Days</span>
                                                </div>
                                                @endif
    
    
                                            </div>
                                        </div>
                                        <div class="col-4 d-flex flex-column d-flex align-items-center">
                                            <div class="row customer-box d-flex align-items-center">
                                                <div class="col-3">
                                                    <span class="text-left invoice-p">INVOICE</span>
                                                </div>
                                                <div class="col-9">
                                                    <span class="text-right invoice-p">: {{$invoice->invoice_no }}</span>
                                                </div>
                                                <div class="col-3">
                                                    <span class="text-left invoice-p">DATE</span>
                                                </div>
                                                <div class="col-9">
                                                    <span
                                                        class="text-right invoice-p">: {{date('d/m/Y',strtotime($invoice->date))}}</span>
                                                </div>
    
                                               @if($invoice->column_show->lpo_check == 1)
                                                <div class="col-3">
                                                    <span class="text-left invoice-p">LPO </span>
                                                </div>
    
                                                <div class="col-9">
                                                    <span class="text-right invoice-p">: {{$invoice->lpo_number }}</span>
                                                </div>
                                                @endif
                                                @if($invoice->column_show->month == 1)
                                                <div class="col-3">
                                                    <span class="text-left invoice-p">MONTH</span>
                                                </div>
    
                                                <div class="col-9">
                                                    <span class="text-right invoice-p">: {{$invoice->month?date('M-Y', strtotime($invoice->month)):null}}</span>
                                                </div>
                                                @endif
    
    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="page">
                                @php
                                    $invoice_total= $invoice->amount+$invoice->vat_amount;
                                @endphp
                                @if ($invoice_total<10000)
                                <table class="table table-sm table-bordered table-font">
                                    <tr class="bg-color">
                                        <th class="text-center bg-color" >SL No.</th>
                                        <th class="text-center bg-color" >Particular Description</th>
                                        <th class="text-center bg-color" >Quantity</th>
                                        <th class="text-center bg-color" >Rate</th>
                                        <th class="text-center bg-color" >VAT Rate(%)</th>
                                        <th class="text-center bg-color" >Total Amount</th>
                                    </tr>
                                        @php
                                        $taxable_amount=0;
                                        $vat=0;
                                        $total_amount=0;
                                        $sl = 1;
                                        $toll_fees = 0;    
                                        @endphp
                                        @foreach ($invoice_items as $item)
                                            <tr>
                                                <td>{{$sl}}</td>
                                                <td class="description">From {{$item->crusher}} To {{$item->destination}}</td>
                                                <td>{{$item->total_qty}}</td>
                                                <td>{{$item->rate}}</td>
                                                <td>{{$item->vat_rate}}</td>
                                                <td>{{$item->rate * $item->total_qty}}</td>
                                            </tr>
                                            @php
                                                $vat_amount= (($item->rate * $item->total_qty) * $item->vat_rate / 100);
                                                $taxable_amount= $taxable_amount+ ($item->rate * $item->total_qty);
                                                $vat = $vat+ $vat_amount ;
                                                $total_amount = $total_amount+ ($item->rate * $item->total_qty) + $vat_amount ;
                                                $sl +=1;
                                            @endphp
                                        @endforeach
                                        @foreach ($invoice_items->where('toll_fee', '>', 0) as $item)
                                            <tr>
                                                <td>{{$sl}}</td>
                                                <td class="description">Toll {{$item->crusher}} To {{$item->destination}}</td>
                                                <td>1</td>
                                                <td>{{$item->toll_fee}}</td>
                                                <td class="text-center">0</td>
                                                <td>{{$item->toll_fee}}</td>
                                            </tr>
                                            @php
                                                $toll_fees += $item->toll_fee;
                                                $sl +=1;
                                            @endphp
                                        @endforeach
                                    <tr>
                                        <th class="text-center" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="2" ></th>
                                        <th class="text-center" colspan="3"  >Total Quantity </th>
                                        <th class="text-center"   >{{ number_format($invoice_items->sum('total_qty'),2) }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="2" ></th>
                                        <th class="text-center" colspan="3"  >Taxable Amount <small>(AED)</small></th>
                                        <th class="text-center"   >{{ number_format($taxable_amount,2) }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="2" ></th>
                                        <th class="text-center" colspan="3"  >VAT<small>(5%)</small></th>
                                        <th class="text-center" colspan="2"  > {{ number_format($invoice_items->sum('total_vat_amount'),2) }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="2" ></th>
                                        <th class="text-center" colspan="3"  >Total Amount <small>(AED)</small></th>
                                        <th class="text-center"   > {{ number_format($invoice_items->sum('total_vat_amount')+$taxable_amount+$toll_fees,2) }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="2" ></th>
                                        <th class="text-center" colspan="3"  >Paid Amount <small>(AED)</small></th>
                                        <th class="text-center"   > {{number_format($invoice->paid_amount,2)}}</th>
                                    </tr> 
                                    <tr>
                                        <th class="text-center" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="2" ></th>
                                        <th class="text-center" colspan="3"  >Due Amount <small>(AED)</small></th>
                                        <th class="text-center" > {{number_format(($invoice_items->sum('total_vat_amount')+$taxable_amount+$toll_fees)-$invoice->paid_amount,2)}}</th>
                                    </tr>                                    
                                </table> 
                                @else
                                <table class="table table-sm table-bordered table-font">
                                    <tr class="bg-color">
                                        <th class="text-center bg-color" >SL No.</th>
                                        <th class="text-center bg-color" >Description</th>
                                        <th class="text-center bg-color" >Rate</th>
                                        <th class="text-center bg-color" >Quantity</th>
                                        <th class="text-center bg-color" >Gross Amount</th>
                                        <th class="text-center bg-color" >VAT Rate(%)</th>
                                        <th class="text-center bg-color" >VAT Amount</th>
                                        <th class="text-center bg-color" >Net Amount</th>
                                    </tr>
                                        @php
                                            $taxable_amount=0;
                                            $vat=0;
                                            $total_amount=0;
                                            $sl = 1;
                                            $toll_fees = 0;   
                                        @endphp
                                        @foreach ($invoice_items as $item)
                                            <tr>
                                                <td>{{$sl}}</td>
                                                <td class="description-two">From {{$item->crusher}} To {{$item->destination}}</td>
                                                <td>{{$item->rate}}</td>
                                                <td>{{$item->total_qty}}</td>
                                                <td>{{number_format($item->rate*$item->total_qty,2)}}</td>
                                                <td class="text-center">{{floatval($item->vat_rate)}}</td>
                                                <td>{{number_format($item->total_vat_amount,2)}}</td>
                                                <td>{{($item->rate * $item->total_qty)+$item->total_vat_amount}}</td>
                                            </tr>
                                            @php
                                                $vat_amount= (($item->rate * $item->total_qty) * $item->vat_rate / 100);
                                                $taxable_amount= $taxable_amount+ ($item->rate * $item->total_qty);
                                                $vat = $vat+ $vat_amount ;
                                                $total_amount = $total_amount+ ($item->rate * $item->total_qty) + $vat_amount;
                                                $sl +=1;
                                            @endphp
                                        @endforeach
                                        @foreach ($invoice_items->where('toll_fee', '>', 0) as $item)
                                            <tr>
                                                <td>{{$sl}}</td>
                                                <td class="description">Toll {{$item->crusher}} To {{$item->destination}}</td>
                                                <td>{{$item->toll_fee}}</td>
                                                <td>1</td>
                                                <td>{{$item->toll_fee}}</td>
                                                <td class="text-center">0</td>
                                                <td>0.00</td>
                                                <td>{{$item->toll_fee}}</td>
                                            </tr>
                                            @php
                                                $toll_fees += $item->toll_fee;
                                                $sl +=1;
                                            @endphp
                                        @endforeach
                                    <tr>
                                        <th class="text-center" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="4"></th>
                                        <th class="text-center" colspan="3"  >Total Quantity</th>
                                        <th class="text-center" colspan="2"  >{{ number_format($invoice_items->sum('total_qty'),2) }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="4"></th>
                                        <th class="text-center" colspan="3"  >Taxable Amount <small>(AED)</small></th>
                                        <th class="text-center" colspan="2"  >{{ number_format($invoice->items->sum('amount'),2) }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="4"></th>
                                        <th class="text-center" colspan="3"  >VAT Amount <small>(5%)</small></th>
                                        <th class="text-center" colspan="2"  > {{ number_format($invoice->items->sum('vat_amount'),2) }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="4"></th>
                                        <th class="text-center" colspan="3"  >Total Amount <small>(AED)</small></th>
                                        <th class="text-center" colspan="2"  > {{ number_format($t_amount =  $invoice->items->sum('amount')+$invoice->items->sum('vat_amount')+$invoice->items->sum('toll_fee')-$invoice->items->sum('discount'),2) }}</th>
                                    </tr> 
                                    <tr>
                                        <th class="text-center" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="4" ></th>
                                        <th class="text-center" colspan="3"  >Paid Amount <small>(AED)</small></th>
                                        <th class="text-center" colspan="2"  > {{number_format($invoice->paid_amount,2)}}</th>
                                    </tr> 
                                    <tr>
                                        <th class="text-center" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="4" ></th>
                                        <th class="text-center" colspan="3"  >Due Amount <small>(AED)</small></th>
                                        <th class="text-center" colspan="2"  > {{number_format($t_amount-$invoice->paid_amount,2)}}</th>
                                    </tr>
                                </table> 
                                @endif
                            </div>


                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>




    <!-- ============ srtart absolute header/footer image========== -->
    <div class="header">
         <img src="{{ asset('img/Prince-head.png') }}" alt="header image" width="100%" style="float:left; background-size: cover;  height: 110px !important;"> <br>
            <!--<span class="company-info" style="background-color: #ed1b24; color:white; padding:3px 25px 3px 25px; font-size: 20px !important;"><strong>Tel.: {{$company_tele->config_value}}, Email: {{$company_email->config_value}} TRN: {{$company_trn->config_value}}</strong></span>-->
            <!--<div style="border-bottom: 1px solid black; margin-top:3px;"></div>-->
    </div>
    <div class="footer sort-invoice-footer">
        <div class="row">
            <div class="col-6">
                <p style="padding-left:50px;"><b>Customer Signature</b></p>
            </div>
            <div class="col-6 text-right">
                <p style="text-align: right; padding-right: 50px;"><b>Authorised Signature</b></p>
            </div>
        </div>
        <img src="{{ asset('img/balraj-footer.png') }}" alt="Footer image" width="100%" height="50px"
            style="float:left; background-size: cover; padding-left:30px;padding-right:30px;"><br>
            <span style="color: #000000; padding-left:30px; font-size:6px;">
                Business Software Solutions by
                <img src="{{ asset('img/zisprink.png') }}" style="height: 20px"  alt="">
            </span>
    </div>
    <div class="img">
        <img src="{{ asset('storage/upload/settings/'.$company_logo->config_value)}}" class="img-fluid" style="position: fixed; top:300px; left:80px; opacity:0.05; height:490px;" alt="">
    </div>
    <!-- ============ end absolute header/footer image========== -->

    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>
