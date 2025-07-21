<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/print.css') }}">
    <script src="{{ asset('assets/backend')}}/app-assets/vendors/js/vendors.min.js"></script>
    <title>Invoice</title>
</head>

<style>
    @media print {
        .table-header th {
            color: #212529 !important;
        }
    }
    .headerGroup:after {
        /* content: 'Text'; */
        background-image: url('img/balraj-header.png');
    }

    tr td {
        font-size: 10px !important;
        padding: 0px, 3px;
    }


     tr th {
        font-size: 11px !important;
        text-align: center !important;
        text-transform: uppercase;
    }
    tr th {
        font-size: 11px !important;
        text-align: center !important;
    }
    .description {
        min-width: 350px !important;
    }

    .company-info {
        color: white;
        background-color: rgb(230 108 96);
        padding-bottom: 5px;
    }

    h2 {
        font-family: Cambria;
    }
    .th-60 {
        width: 60px;
    }
    .text-right {
        text-align: right !important;
        padding-right: 10px !important;
    }

    .invoice-header {
            color: #040404;
            text-transform: uppercase;
            letter-spacing: 2px;
            /* text-align: center; */
            font-weight: 700;
            line-height: .5
        }

    .invoice-header1 {
            color: #040404;
            text-transform: uppercase;
            font-size: 50px;
            letter-spacing: 2px;
            /* text-align: center; */
            font-weight: 600;
            line-height: 1
        }

    .invoice-p {
        font-size: 12px;
        font-weight: 500;
        color: #3a3735;
        list-style: 1.3;
    }

    .image-box {
        display: flex;

    }

    .invoice-logo {
        width: 160px;
        height: auto;
        margin-left:40px;
        margin-top: -20px;
    }

    .tax-title {
        text-transform: uppercase;
        font-size: 25px;
        font-weight: 700;
        /* font-style: italic; */
        text-align: center;
    }

    .hr-1 {
        background-color: #0d23cd;
        height: 6px !important;
        opacity: .6 !important;
        width: 100%;
        margin-bottom: 10px
    }

    .hr-2 {
        background: #18181a;
        height: 2px !important;
        opacity: .6 !important;
        width: 100%;

    }

    .customer-box {
        padding: 20px 10px 10px 10px;
    }

    .customer-box-2 {
        padding: 20px 10px 10px 10px;

    }

    .flex-fill {
        flex: 1;
    }

    .customer-details-title {
        background: white;
        margin-top: -38px;
        height: 35px;
        width: 221px;
        margin-left: 88px;
        display: block;
        text-align: center;
    }

    .footer {
        width: 100%;
        position: fixed;
        bottom: -15px;
        left: 0;

        /* box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.1); */
    }
    body {
    font-family: Arial, sans-serif;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #000;
        margin-top: 1rem; /* .mt-4 in Bootstrap translates to a margin-top of 1.5rem (24px), adjust as necessary */
    }

    .custom-table th,
    .custom-table td {
        border-left: 1px solid #000; /* Add your desired border color */
        border-right: 1px solid #000; /* Add your desired border color */

        padding: 8px;
        text-align: left;
    }

    .custom-table thead th {
        background-color: #f2f2f2; /* Light gray background for header */
        color: ##212529 !important !important;

    }

    .text-right {
        text-align: right;
    }

    .pr-1 {
        padding-right: 0.25rem; /* Adjust padding as needed */
    }

    .mt-4 {
        margin-top: 1.5rem; /* Adjust margin as needed */
    }

    /* Adjust width for specific columns */
    .th-60 {
        width: 60px;
    }

    .trFontSize {
        font-size: 14px; /* Adjust font size as needed */
    }

    .t-row:hover {
        background-color: #f9f9f9; /* Light gray background on row hover */
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
    $invoice_log= \App\Setting::where('config_name', 'invoice_img')->first();
    $invoice_arabic= \App\Setting::where('config_name', 'invoice_arabic')->first();

    $company_trn= \App\Setting::where('config_name', 'trn_no')->first();
    @endphp
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper ">
        <table  style="min-width: 100%">
            <thead>
                <tr>
                    <td class="headerGroup">
                        <div class="header-block " style="padding: 2px 10px;">
                            <div class="row">
                                <div class="col-12" style="background: rgb(215 209 208)">
                                    <div class="tex-left">
                                        <div class="row full-height d-flex align-items-center">
                                            <div class="col-2 d-flex justify-content-center align-items-center image-box pl-1">
                                                <img src="{{ asset('storage/upload/settings/' . $invoice_log->config_value) }}" class="invoice-logo" alt="">
                                            </div>
                                            <div class="col-10 d-flex justify-content-center align-items-center">
                                                <div class="text-center">
                                                    <h1 class="text-uppercase invoice-header pt-1 mt-3" style="font-size:30px">{{$company_name->config_value}}</h1>
                                                    <h1 class="text-uppercase invoice-header1 mt-2"  style="letter-spacing: 0px" >{{$invoice_arabic->config_value}}</h1>

                                                    <p class="m-0 invoice-p pl-0 pr-0 pb-1" style="padding-right: 5px;text-align:center">
                                                        {{$company_address->config_value}},
                                                        {{$company_tele->config_value}},<br>
                                                        {{$company_trn->config_value}},
                                                        Email:{{$company_email->config_value}}
                                                    </p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                          </div>
                        </div>
                    </td>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td class="footerGroup ">
                        <div class="footer-block"></div>
                    </td>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <td>
                        <div class="page-container">
                            <div class="row mt-2">
                                <div class="col-12 text-center">
                                   <h4 class="tax-title" style="font-size:21px; text-align:center">{{$invoice->invoice_type}}</h4>
                               </div>
                           </div>
                            <div class="row mb-2 mt-1 " style="margin-right: 0px; margin-left:0px;background:#d7eaef">
                                <div class="col-12 d-flex mt-1">

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
                            <div class="page">
                                @php
                                    $invoice_total= $invoice->amount+$invoice->vat_amount;
                                    $taxable_amount=0;
                                    $vat=0;
                                    $total_amount=0;

                                @endphp
                                @if ($invoice_total<10000)
                                <table class="table table-sm table-bordered table-font w-100">
                                    <tr class="bg-color">
                                        <th>SL No.</th>
                                        <th>Particular Description</th>
                                        <th class="text-right">Quantity</th>
                                        <th class="text-right">Rate</th>
                                        <th class="text-right">Total Amount</th>
                                        <th class="text-right">VAT Rate</th>
                                    </tr>

                                        @foreach ($invoice_items as $item)
                                        <tr>
                                            <td>{{$loop->index+1}}</td>
                                            <td class="description">From {{$item->crusher}} To {{$item->destination}}</td>
                                            <td class="text-right">{{$item->total_qty}}</td>
                                            <td class="text-right">{{$item->rate}}</td>
                                            <td class="text-right">{{$item->rate * $item->total_qty}}</td>
                                            <td class="text-right">{{$item->vat_rate}}</td>
                                        </tr>
                                            @php
                                                $vat_amount= (($item->rate * $item->total_qty) * $item->vat_rate / 100);
                                                $taxable_amount= $taxable_amount+ ($item->rate * $item->total_qty);
                                                $vat = $vat+ $vat_amount ;
                                                $total_amount = $total_amount+ ($item->rate * $item->total_qty) + $vat_amount ;
                                            @endphp
                                        @endforeach

                                    <tr>
                                        <th class="text-right" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="2" ></th>
                                        <th class="text-right bg-color" colspan="3"  >Total Quantity </th>
                                        <th class="text-right bg-color"   >{{ number_format($invoice_items->sum('total_qty'),2) }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="2" ></th>
                                        <th class="text-right bg-color" colspan="3"  >Taxable Amount <small>(AED)</small></th>
                                        <th class="text-right bg-color"   >{{ round($taxable_amount,2) }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="2" ></th>
                                        <th class="text-right bg-color" colspan="3"  >VAT <small>(5%)</small></th>
                                        <th class="text-right bg-color"   > {{ round($vat,2) }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="2" ></th>
                                        <th class="text-right bg-color" colspan="3"  >Total Amount <small>(AED)</small></th>
                                        <th class="text-right bg-color"   > {{ $invoice->vat_amount+$invoice->amount }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="2" ></th>
                                        <th class="text-right bg-color" colspan="3"  >Paid Amount <small>(AED)</small></th>
                                        <th class="text-right bg-color"   > {{$invoice->paid_amount}}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="2" ></th>
                                        <th class="text-right bg-color" colspan="3"  >Due Amount <small>(AED)</small></th>
                                        <th class="text-right bg-color"   > {{$invoice->due_amount}}</th>
                                    </tr>
                                </table>
                                @else
                                <table class="table table-sm table-bordered table-font w-100">
                                    <tr class="bg-color">
                                        <th>SL No.</th>
                                        <th>Description</th>
                                        <th class="text-right" >Rate</th>
                                        <th class="text-right" >Quantity</th>
                                        <th class="text-right" >Gross Amount</th>
                                        <th class="text-right" >Tax Rate</th>
                                        <th class="text-right" >Tax Amount</th>
                                        <th class="text-right" >Net Amount</th>
                                    </tr>

                                        @foreach ($invoice_items as $item)
                                        <tr>
                                            <td>{{$loop->index+1}}</td>
                                            <td class="description-two">From {{$item->crusher}} To {{$item->destination}}</td>
                                            <td class="text-right">{{$item->rate}}</td>
                                            <td class="text-right">{{$item->total_qty}}</td>
                                            <td class="text-right">{{$item->rate * $item->total_qty}}</td>
                                            <td class="text-right">{{floatval($item->vat_rate)}}</td>
                                            <td class="text-right">{{$item->total_vat_amount}}</td>
                                            <td class="text-right">{{($item->rate * $item->total_qty)+$item->total_vat_amount}}</td>
                                        </tr>
                                            @php
                                                $vat_amount= (($item->rate * $item->total_qty) * $item->vat_rate / 100);
                                                $taxable_amount= $taxable_amount+ ($item->rate * $item->total_qty);
                                                $vat = $vat+ $vat_amount ;
                                                $total_amount = $total_amount+ ($item->rate * $item->total_qty) + $vat_amount ;
                                            @endphp
                                        @endforeach

                                    <tr>
                                        <th class="text-right" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="4"></th>
                                        <th class="text-right bg-color" colspan="3"  >Total Quantity</th>
                                        <th class="text-right bg-color" colspan="2"  >{{ number_format($invoice_items->sum('total_qty'),2) }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="4"></th>
                                        <th class="text-right bg-color" colspan="3"  >Taxable Amount <small>(AED)</small></th>
                                        <th class="text-right bg-color" colspan="2"  >{{ round($taxable_amount,2) }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="4"></th>
                                        <th class="text-right bg-color" colspan="3"  >VAT <small>(5%)</small></th>
                                        <th class="text-right bg-color" colspan="2"  > {{ round($vat,2) }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="4"></th>
                                        <th class="text-right bg-color" colspan="3"  >Total Amount <small>(AED)</small></th>
                                        <th class="text-right bg-color" colspan="2"  > {{ $invoice->vat_amount+$invoice->amount }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="4" ></th>
                                        <th class="text-right bg-color" colspan="3"  >Paid Amount <small>(AED)</small></th>
                                        <th class="text-right bg-color" colspan="2"  > {{$invoice->paid_amount}}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="4" ></th>
                                        <th class="text-right bg-color" colspan="3"  >Due Amount <small>(AED)</small></th>
                                        <th class="text-right bg-color" colspan="2"  > {{$invoice->due_amount}}</th>
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

        {{-- <h2 class="text-center">{{ $company_name->config_value }}</h2> --}}
        {{-- <span class="company-info"
            style="background-color: rgb(230 108 96); color:white; padding:3px 15px 5px 15px;">Tel.:
            {{$company_tele->config_value}} Email: {{$company_email->config_value}} TRN No:
            {{$company_trn->config_value}}</span> --}}
        {{-- <div style="border-bottom: 1px solid black; margin-top:4px;"></div> --}}
    </div>
    {{-- <div class="footer">

        <span style="color: #000; padding-left:0px; font-size:13px;height:50px">
            Business Software Solutions by
            <img src="{{ asset('img/zisprink.png') }}" style="max-height: 40px; " class="img-fluid" alt="">
        </span>
    </div> --}}
    <div class="img">
        <img src="{{ asset('storage/upload/settings/' . $invoice_log->config_value) }}" class="img-fluid"
            style="position: fixed; top:250px; left:150px; opacity:0.2; height:400px;" alt="">
    </div>
    <!-- ============ end absolute header/footer image========== -->

    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
    var $table = $('#invoiceTable');
    var totalColumns = $table.find('tr').first().children('th').length;

    $table.find('.colspan').each(function() {
        var $row = $(this);
        $row.attr('colspan', totalColumns - 1);
    });
});
    </script>
</body>

</html>
