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
        /* background-color: white; */
        /* box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.1); */
    }
    body {
    font-family: Arial, sans-serif;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #000
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
        color: #212529 !important !important;

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
    $invoice_arabic= \App\Setting::where('config_name', 'invoice_arabic')->first();

    $trn_no= \App\Setting::where('config_name', 'trn_no')->first();
    $company_logo= \App\Setting::where('config_name', 'company_logo')->first();
    $invoice_log= \App\Setting::where('config_name', 'invoice_img')->first();

    $company_trn= \App\Setting::where('config_name', 'trn_no')->first();
    @endphp
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper ">
        <table style="min-width: 100%">
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
                        <div class="page-container w-100">

                            <div class="page">
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

                                @if($invoice)
                                @php
                                $invoice_total= $invoice->total_amount;
                                            $column =0 ;

                                @endphp
                                @if ($invoice_total<10000)
                                <table class="custom-table mt-4" id="invoiceTable">
                                    <thead>
                                        <tr style="border: 1px solid #000;">
                                            <th class="th-60">SL No.</th>
                                            @if($invoice->column_show->item_date_check == 1)
                                            @php
                                            $column++ ;
                                            @endphp
                                            <th class="th-60">Date</th>
                                            @endif
                                            @if($invoice->column_show->truck_check == 1)
                                            @php
                                            $column++ ;
                                            @endphp
                                            <th class="th-60">Truck</th>
                                            @endif
                                            @if($invoice->column_show->material_check == 1)
                                            @php
                                            $column++ ;
                                            @endphp
                                            <th class="th-60">Material</th>
                                            @endif
                                            @if($invoice->column_show->cursher_check == 1)
                                            @php
                                            $column++ ;
                                            @endphp
                                            <th class="th-60">Crusher</th>
                                            @endif
                                            @if($invoice->column_show->dstn_e_check == 1)
                                            @php
                                            $column++ ;
                                            @endphp
                                            <th class="th-60">Destination</th>
                                            @endif
                                            @if($invoice->column_show->serial_check == 1)
                                            @php
                                            $column++ ;
                                            @endphp
                                            <th class="th-60">DO. No</th>
                                            @endif
                                            @if($invoice->column_show->wgt_check == 1)
                                            @php
                                            $column++ ;
                                            @endphp
                                            <th class="th-60">Qty</th>
                                            @endif
                                            @if($invoice->column_show->rate_check == 1)
                                            @php
                                            $column++ ;
                                            @endphp
                                            <th class="th-60">Rate</th>
                                            @endif
                                            @if($invoice->column_show->amount_check == 1)
                                            @php
                                            $column++ ;
                                            @endphp
                                            <th class="th-60">Amount</th>
                                            @endif
                                            {{-- @if($invoice->column_show->vat_rate_check == 1)
                                            <th class="th-60 text-dark">VAT Rate</th>
                                            @endif
                                            @if($invoice->column_show->discount_check == 1)
                                            <th class="th-60">Discount</th>
                                            @endif
                                            @if($invoice->column_show->vat_amount_check == 1)
                                            <th class="th-60  text-dark">VAT</th>
                                            @endif --}}
                                            @if($invoice->column_show->tatl_amount_check == 1)
                                            @php
                                            $column++ ;
                                            @endphp
                                            <th class="th-60  text-dark">Total</th>
                                            @endif
                                            @if($invoice->column_show->toll_check == 1)
                                            @php
                                            $column++ ;
                                            @endphp
                                            <th class="th-60">Toll Fee</th>
                                            @endif
                                            {{-- @if($invoice->column_show->total_toll_check == 1)
                                            <th class="th-60">Fee Total</th>
                                            @endif --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoice->items as $key => $item)
                                        <tr class="trFontSize t-row">
                                            <td class="text-center">{{$key +1}}</td>
                                            @if($invoice->column_show->item_date_check == 1)
                                            <td>{{date('d/m/Y', strtotime($item->date))}}</td>
                                            @endif
                                            @if($invoice->column_show->truck_check == 1)
                                            <td>{{$item->truck?$item->truck->vehicle_number:''}}</td>
                                            @endif
                                            @if($invoice->column_show->material_check == 1)
                                            <td>{{$item->record?$item->record->material:''}}</td>
                                            @endif
                                            @if($invoice->column_show->cursher_check == 1)
                                            <td>{{$item->record?$item->record->crusher:''}}</td>
                                            @endif
                                            @if($invoice->column_show->dstn_e_check == 1)
                                            <td>{{$item->description}}</td>
                                            @endif
                                            @if($invoice->column_show->serial_check == 1)
                                            <td>{{$item->record?$item->record->serial_no:''}}</td>
                                            @endif
                                            @if($invoice->column_show->wgt_check == 1)
                                            <td class="">{{$item->qty}}</td>
                                            @endif
                                            @if($invoice->column_show->rate_check == 1)
                                            <td class="">{{ number_format($item->total_amount/$item->qty ,2,'.','')}} </td>
                                            @endif
                                            @if($invoice->column_show->amount_check == 1)
                                            <td class="">{{ $item->amount}}</td>
                                            @endif
                                            {{-- @if($invoice->column_show->vat_rate_check == 1)
                                            <td class="">{{$item->vat_rate}}</td>
                                            @endif --}}
                                            {{-- @if($invoice->column_show->discount_check == 1)
                                            <td class="">{{$item->discount}}</td>
                                            @endif --}}
                                            {{-- @if($invoice->column_show->vat_amount_check == 1)
                                            <td class="">{{$item->vat_amount}}</td>
                                            @endif --}}
                                            @if($invoice->column_show->tatl_amount_check == 1)
                                            <td class="">{{$item->total_amount}}</td>
                                            @endif
                                            @if($invoice->column_show->toll_check == 1)
                                            <td class="">{{$item->toll_fee}}</td>
                                            @endif
                                            {{-- @if($invoice->column_show->total_toll_check == 1)
                                            <td class="">{{number_format($item->toll_fee * $item->qty,3,'.','')}}</td>
                                            @endif --}}
                                        </tr>
                                        @endforeach

                                        <tr class="trFontSize"  style="border: 1px solid #000">
                                            <td colspan="{{ $column}}" class="text-right pr-1 colspan">Amount: </td>
                                            <td class="text-right pr-1">{{ $invoice->amount}}</td>
                                        </tr>
                                        {{-- <tr class="trFontSize"  style="border: 1px solid #000">
                                            <td colspan="{{ $column}}" class="text-right pr-1 colspan">Discount: </td>
                                            <td class="text-right pr-1">{{ $invoice->discount_amount}}</td>
                                        </tr> --}}
                                        <tr class="trFontSize"  style="border: 1px solid #000">
                                            <td colspan="{{ $column}}" class="text-right pr-1 colspan">Total VAT: </td>
                                            <td class="text-right pr-1">{{ $invoice->vat_amount?:0.00}}</td>
                                        </tr>
                                        <tr class="trFontSize"  style="border: 1px solid #000">
                                            <td colspan="{{ $column}}" class="text-right pr-1 colspan">Total Toll Fee: </td>
                                            <td class="text-right pr-1">{{ $invoice->total_toll_fee}}</td>
                                        </tr>
                                        <tr class="trFontSize"  style="border: 1px solid #000">
                                            <td colspan="{{ $column}}" class="text-right pr-1 colspan">Total Amount: </td>
                                            <td class="text-right pr-1">{{ $invoice->total_amount}}</td>
                                        </tr>
                                        <tr class="trFontSize"  style="border: 1px solid #000">
                                            <td colspan="{{ $column}}" class="text-right pr-1 colspan">Paid Amount: </td>
                                            <td class="text-right pr-1">{{ $invoice->paid_amount}}</td>
                                        </tr>
                                        <tr class="trFontSize"  style="border: 1px solid #000">
                                            <td colspan="{{ $column}}" class="text-right pr-1 colspan">In Word Narration:{{  $invoice->convertNumberToWords($invoice->total_amount)}}</td>
                                            <td class="text-right pr-1 "></td>

                                        </tr>
                                    </tbody>
                                </table>
                                @else

                                <table class="custom-table mt-4" id="invoiceTable">
                                    <thead>
                                        <tr style="border: 1px solid #000">
                                            <th class="th-60">SL No.</th>

                                            @if($invoice->column_show->item_date_check == 1)
                                            @php
                                            $column++ ;
                                            @endphp
                                            <th class="th-60">Date</th>
                                            @endif
                                            @if($invoice->column_show->truck_check == 1)
                                            @php
                                            $column++ ;
                                            @endphp
                                            <th class="th-60">Truck</th>
                                            @endif
                                            @if($invoice->column_show->material_check == 1)
                                            @php
                                            $column++ ;
                                            @endphp
                                            <th class="th-60">Material</th>
                                            @endif
                                            @if($invoice->column_show->cursher_check == 1)
                                            @php
                                            $column++ ;
                                            @endphp
                                            <th class="th-60">Crusher</th>
                                            @endif
                                            @if($invoice->column_show->dstn_e_check == 1)
                                            @php
                                            $column++ ;
                                            @endphp
                                            <th class="th-60">Destination</th>
                                            @endif
                                            @if($invoice->column_show->serial_check == 1)
                                            @php
                                            $column++ ;
                                            @endphp
                                            <th class="th-60">DO. No</th>
                                            @endif
                                            @if($invoice->column_show->wgt_check == 1)
                                            @php
                                            $column++ ;
                                            @endphp
                                            <th class="th-60">Qty</th>
                                            @endif
                                            @if($invoice->column_show->rate_check == 1)
                                            @php
                                            $column++ ;
                                            @endphp
                                            <th class="th-60">Rate</th>
                                            @endif
                                            @if($invoice->column_show->amount_check == 1)
                                            @php
                                            $column++ ;
                                            @endphp
                                            <th class="th-60">Amount</th>
                                            @endif
                                            @if($invoice->column_show->vat_rate_check == 1)
                                            @php
                                            $column++ ;
                                            @endphp
                                            <th class="th-60 text-dark">VAT Rate</th>
                                            @endif
                                            @if($invoice->column_show->discount_check == 1)
                                            @php
                                            $column++ ;
                                            @endphp
                                            <th class="th-60">Discount</th>
                                            @endif
                                            @if($invoice->column_show->vat_amount_check == 1)
                                            @php
                                            $column++ ;
                                            @endphp
                                            <th class="th-60  text-dark">VAT</th>
                                            @endif
                                            @if($invoice->column_show->tatl_amount_check == 1)
                                            @php
                                            $column++ ;
                                            @endphp
                                            <th class="th-60  text-dark">Total</th>
                                            @endif
                                            @if($invoice->column_show->toll_check == 1)
                                            @php
                                            $column++ ;
                                            @endphp
                                            <th class="th-60">Toll Fee</th>
                                            @endif
                                            {{-- @if($invoice->column_show->total_toll_check == 1)
                                            <th class="th-60">Fee Total</th>
                                            @endif --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoice->items as $key => $item)
                                        <tr class="trFontSize t-row">
                                            <td class="text-center">{{$key +1}}</td>
                                            @if($invoice->column_show->item_date_check == 1)
                                            <td>{{date('d/m/Y', strtotime($item->date))}}</td>
                                            @endif
                                            @if($invoice->column_show->truck_check == 1)
                                            <td>{{$item->truck?$item->truck->vehicle_number:''}}</td>
                                            @endif
                                            @if($invoice->column_show->material_check == 1)
                                            <td>{{$item->record?$item->record->material:''}}</td>
                                            @endif
                                            @if($invoice->column_show->cursher_check == 1)
                                            <td>{{$item->record?$item->record->crusher:''}}</td>
                                            @endif
                                            @if($invoice->column_show->dstn_e_check == 1)
                                            <td>{{$item->description}}</td>
                                            @endif
                                            @if($invoice->column_show->serial_check == 1)
                                            <td>{{$item->record?$item->record->serial_no:''}}</td>
                                            @endif
                                            @if($invoice->column_show->wgt_check == 1)
                                            <td class="">{{$item->qty}}</td>
                                            @endif
                                            @if($invoice->column_show->rate_check == 1)
                                            <td class="">{{$item->rate}}</td>
                                            @endif
                                            @if($invoice->column_show->amount_check == 1)
                                            <td class="">{{$item->amount}}</td>
                                            @endif
                                            @if($invoice->column_show->vat_rate_check == 1)
                                            <td class="">{{$item->vat_rate}}</td>
                                            @endif
                                            @if($invoice->column_show->discount_check == 1)
                                            <td class="">{{$item->discount}}</td>
                                            @endif
                                            @if($invoice->column_show->vat_amount_check == 1)
                                            <td class="">{{$item->vat_amount}}</td>
                                            @endif
                                            @if($invoice->column_show->tatl_amount_check == 1)
                                            <td class="">{{$item->total_amount}}</td>
                                            @endif
                                            @if($invoice->column_show->toll_check == 1)
                                            <td class="">{{$item->toll_fee}}</td>
                                            @endif
                                            {{-- @if($invoice->column_show->total_toll_check == 1)
                                            <td class="">{{number_format($item->toll_fee * $item->qty,3,'.','')}}</td>
                                            @endif --}}
                                        </tr>
                                        @endforeach

                                        <tr class="trFontSize"  style="border: 1px solid #000">
                                            <td colspan="{{ $column}}" class="text-right pr-1 colspan">Amount: </td>
                                            <td class="text-right pr-1">{{ $invoice->amount}}</td>
                                        </tr>
                                        <tr class="trFontSize"  style="border: 1px solid #000">
                                            <td colspan="{{ $column}}" class="text-right pr-1 colspan">Discount: </td>
                                            <td class="text-right pr-1">{{ $invoice->discount_amount}}</td>
                                        </tr>
                                        <tr class="trFontSize"  style="border: 1px solid #000">
                                            <td colspan="{{ $column}}" class="text-right pr-1 colspan">Total VAT: </td>
                                            <td class="text-right pr-1">{{ $invoice->vat_amount}}</td>
                                        </tr>
                                        <tr class="trFontSize"  style="border: 1px solid #000">
                                            <td colspan="{{ $column}}" class="text-right pr-1 colspan">Total Toll Fee: </td>
                                            <td class="text-right pr-1">{{ $invoice->total_toll_fee}}</td>
                                        </tr>
                                        <tr class="trFontSize"  style="border: 1px solid #000">
                                            <td colspan="{{ $column}}" class="text-right pr-1 colspan">Total Amount: </td>
                                            <td class="text-right pr-1">{{ $invoice->total_amount}}</td>
                                        </tr>
                                        <tr class="trFontSize"  style="border: 1px solid #000">
                                            <td colspan="{{ $column}}" class="text-right pr-1 colspan">Paid Amount: </td>
                                            <td class="text-right pr-1">{{ $invoice->paid_amount}}</td>
                                        </tr>
                                        <tr class="trFontSize"   style="border: 1px solid #000">
                                            <td colspan="{{ $column}}" class="text-right pr-1 colspan">In Word Narration:{{  $invoice->convertNumberToWords($invoice->total_amount)}}</td>
                                            <td class="text-right pr-1 "></td>

                                        </tr>
                                    </tbody>
                                </table>
                                @endif
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
            style="background-color: rgb(230 108 96); color:white; padding:3px {{ $column}}px 5px {{ $column}}px;">Tel.:
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
            style="position: fixed; top:350px; left:180px; opacity:0.2; height:500px;" alt="">
    </div>
    <!-- ============ end absolute header/footer image========== -->

    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script>
    //  $(document).ready(function() {
    //     var $table = $('#invoiceTable');
    //     var totalColumns = $table.find('tr').first().children('th').length;

    //     $table.find('.colspan').each(function() {
    //         var $row = $(this);
    //         $row.attr('colspan', totalColumns - 1);
    //     });
    // });
    </script>
</body>

</html>
