
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
        bottom: -10px;
        left: 0;

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
                <tr >
                    <td class="headerGroup w-100 colspan"  >
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
                            <div class="page ">
                                <div class="row mt-3">
                                    <div class="col-12 text-center">
                                            <h4 class="tax-title" style="font-size:21px; text-align:center">{{$toll_invoice->invoice_type}}</h4>
                                        </div>
                               </div>
                                <div class="row mb-2 mt-1 " style="margin-right: 0px; margin-left:0px;background:#d7eaef">

                                    <div class="col-12 d-flex mt-1">
                                        <div class="col-6 d-flex flex-column d-flex align-items-center">
                                            <div class="row customer-box d-flex align-items-center">
                                                <div class="col-3">
                                                    <span class="text-left invoice-p">INVOICE</span>
                                                </div>
                                                <div class="col-9">
                                                    <span class="text-right invoice-p">: {{$toll_invoice->invoice_no }}</span>
                                                </div>
                                                <div class="col-3">
                                                    <span class="text-left invoice-p">DATE</span>
                                                </div>
                                                <div class="col-9">
                                                    <span
                                                        class="text-right invoice-p">: {{date('d/m/Y',strtotime($toll_invoice->date))}}</span>
                                                </div>

                                                <div class="col-3">
                                                    <span class="text-left invoice-p">TRN</span>
                                                </div>
                                                <div class="col-9">
                                                    <span class="text-right invoice-p">: {{$toll_invoice->customer?
                                                        $toll_invoice->customer->trn_no:''}}</span>
                                                </div>

                                                <div class="col-3">
                                                    <span class="text-left invoice-p">LPO </span>
                                                </div>

                                                <div class="col-9">
                                                    <span class="text-right invoice-p">: {{$toll_invoice->lpo_number }}</span>
                                                </div>



                                            </div>
                                        </div>

                                        <div class="col-6 d-flex flex-column d-flex align-items-center">
                                            <div class="row customer-box-2 flex-fill">

                                                <div class="col-3">
                                                    <span class="text-left invoice-p">CUSTOMER</span>
                                                </div>
                                                <div class="col-9">
                                                    <span class="text-right invoice-p"> : {{$toll_invoice->customer?
                                                        $toll_invoice->customer->pi_name:''}}</span>
                                                </div>

                                                <div class="col-3">
                                                    <span class="text-left invoice-p">ADDRESS</span>
                                                </div>
                                                <div class="col-9">
                                                    <span class="text-right invoice-p">: {{$toll_invoice->customer?
                                                        $toll_invoice->customer->address:''}}</span>
                                                </div>

                                                <div class="col-3">
                                                    <span class="text-left invoice-p">TRN</span>
                                                </div>
                                                <div class="col-9">
                                                    <span class="text-right invoice-p">: {{$toll_invoice->customer?
                                                        $toll_invoice->customer->trn_no:''}}</span>
                                                </div>

                                                <div class="col-3">
                                                    <span class="text-left invoice-p">PHONE</span>
                                                </div>

                                                <div class="col-9">
                                                    <span class="text-right invoice-p">: {{$toll_invoice->customer?
                                                        $toll_invoice->customer->phone_no:''}}</span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <table class="table mb-0 table-sm table-hover" id="#invoiceTable">
                                    <thead  class="thead-light">
                                        <tr style="height: 50px;">
                                            <th>SL. No</th>
                                            <th style="width: 30%">Destination</th>
                                            <th style="width: 30%">Source</th>
                                            <th>TKT Number</th>
                                            <th class="text-right">Total Toll Fee</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-sm">
                                        @php $i = 1; @endphp
                                            @foreach ($toll_items as  $key => $item)

                                                @if ($toll_items->sum('amount')>0)
                                                    <tr>
                                                        <td>{{$i}}</td>
                                                        <td>{{$item->destination}}</td>
                                                        <td>{{$item->source}}</td>
                                                        <td>{{$item->truck_record->tkt_number}}</td>
                                                        <td class="text-right pr-1">{{$item->amount}}</td>
                                                    </tr>
                                                    @php $i++; @endphp
                                                @endif
                                            @endforeach
                                        <tr>
                                            <td colspan="3"></td>
                                            <td class="text-right pr-1">Total Toll Fee:</td>
                                            <td class="text-right pr-1">{{$toll_invoice->amount}}</td>
                                        </tr>
                                    </tbody>
                                </table>
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

        <span style="color: #000; padding-left:30px; font-size:10px;">
            Business Software Solutions by
            <img src="{{ asset('img/zisprink.png') }}" style="max-height: 25px; " class="img-fluid" alt="">
        </span>
    </div> --}}
    <div class="img">
        <img src="{{ asset('storage/upload/settings/' . $invoice_log->config_value) }}" class="img-fluid"
            style="position: fixed; top:350px; left:180px; opacity:0.2; height:500px;" alt="">
    </div>
    <!-- ============ end absolute header/footer image========== -->

    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: Bootstrap Bundle with Popper -->

</body>

</html>
