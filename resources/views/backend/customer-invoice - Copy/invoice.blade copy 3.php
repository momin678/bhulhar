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
        /* content: 'Text'; */
        background-image: url('img/balraj-header.png');
    }
    .table-font tr td{
        font-size: 10px !important;
    }
    .table-font tr th{
        font-size: 10px !important;
    }
    .table-header tr th{
        font-size: 10px !important;
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
    .text-right{
        text-align: right;
        padding-right: 10px !important;
    }
    .invoice-header {
        color: #aa0c0c;
        text-transform: uppercase;
        font-size: 28px;
        font-weight: 600;
    }
    .invoice-p {
        font-size: 16px;
        font-weight: 500;
        color: #3a3735;
    }
    .image-box {
        display: flex;

    }
    .invoice-logo {
        width: 180px;
        height: auto;
    }
    .tax-title {
        text-transform: uppercase;
        font-size: 25px;
        font-weight: 700;
        font-style: italic;
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
        border: 1px solid;
        padding: 20px 10px 10px 10px;
        border-radius: 15px;
    }
    .customer-box-2 {
        border: 1px solid;
        padding: 20px 10px 10px 10px;
        border-radius: 15px;
        margin-left: 25px;
        height: 107px;
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
            bottom: 0;
            left: 0;
            background-color: white;
            padding: 10px 30px;
            box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.1);
        }
    .customer-info-title {
        color: #010101;
        font-weight: 900;
        line-height: 22px;
    }
    .customer-info-p {
        line-height: 20px;
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
    <div class="content-wrapper ">
        <table width="100%">
            <thead>
                <tr>
                    <td class="headerGroup">
                        <div class="header-block " style="padding: 2px 10px;">
                            <div class="row">
                                <div class="col-9">
                                    <div>
                                        <h1 class="text-upparcase invoice-header"> al asma`a tramsform l.l.c</h1>
                                        <p class="m-0 invoice-p">P.O Box 3522, RAX U.A.E</p>
                                        <p  class="m-0 invoice-p">Tel No. - 07-2268823, Mob. No. - 055-88331936</p>
                                        <p  class="m-0 invoice-p">TRN - 10034018800003</p>
                                        <p  class="m-0 invoice-p">E-mail - alasmaatransport@hotmail.com</p>
                                    </div>
                                </div>
                                <div class="col-3 image-box">
                                   <img src="{{asset('icon/invoice-logo.png')}}" class="invoice-logo" alt="">
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
                            <div class="page">
                                <div class="row mb-2" style="margin-right: 0px; margin-left:0px">
                                    <div class="col-6">
                                        <div class="hr-1"></div>
                                        <div class="hr-2"></div>
                                    </div>
                                    <div class="col-3">
                                        <h4 class="tax-title" style="margin-top:-8px">{{$invoice->invoice_type}}</h4>
                                    </div>
                                    <div class="col-3">
                                        <div class="hr-1"></div>
                                        <div class="hr-2"></div>
                                    </div>
                                    <div class="col-12 d-flex mt-3 p-0">
                                        <table class="table table-bordered table-header">
                                            <tr>
                                                <th colspan="11" style="width: 65%">
                                                    <div class="customer-info">
                                                        @if($invoice->column_show->customer_name_check = 1)
                                                        <span class="customer-info-title">BILL TO :</span> <span class="customer-info-p">{{$invoice->customer? $invoice->customer->pi_name:''}}</span> <br>
                                                        @endif
                                                        @if($invoice->column_show->customer_address_check = 1)
                                                        <span  class="customer-info-title">ADDRESS :</span> <span class="customer-info-p">{{$invoice->customer? $invoice->customer->address:''}}</span><br>
                                                        @endif
                                                        @if($invoice->column_show->customer_phone_check = 1)
                                                        <span class="customer-info-title">PHONE NO :</span> <span class="customer-info-p">{{$invoice->customer? $invoice->customer->phone_no:''}}</span><br>
                                                        @endif
                                                        @if($invoice->column_show->customer_phone_check = 1)
                                                        <span class="customer-info-title">FAX NO :</span> <span class="customer-info-p"> {{$invoice->customer? $invoice->customer->con_no:''}}</span><br>
                                                        @endif
                                                        @if($invoice->column_show->customer_trn_check = 1)
                                                        <span class="customer-info-title">CUST TRN :</span> <span class="customer-info-p">{{$invoice->customer? $invoice->customer->trn_no:''}}</span><br>
                                                        @endif
                                                    </div>
                                                </th>
                                                <th colspan="3" style="width: 15%">
                                                    <div class="customer-info">
                                                        <span class="customer-info-title">INVOICE NO:</span> <br>
                                                        <span class="customer-info-title">INVOICE DATE :</span> <br>
                                                        <span class="customer-info-title">LPO NO :</span> <br>
                                                        <span class="customer-info-title">DATE OF SUPPLY:</span> <br>
                                                        <span class="customer-info-title">CURRENCY :</span> <br>
                                                    </div>
                                                </th>
                                                <th colspan="2" style="width: 20%">
                                                    <div class="customer-info">
                                                    <span class="customer-info-p">{{$invoice->invoice_no }}</span> <br>
                                                    <span class="customer-info-p">{{date('d/m/Y',strtotime($invoice->date))}}</span><br>
                                                    <span class="customer-info-p">{{$invoice->lpo_number}}</span><br>
                                                    <span class="customer-info-p">{{date('d/m/Y',strtotime($invoice->due_date))}}</span><br>
                                                    <span class="customer-info-p">AED</span><br>
                                                </div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="7">
                                                    <span class="customer-info-title">Payment Terms:</span>
                                                </th>
                                                <th colspan="9"></th>
                                            </tr>
                                            @isset($invoice)
                                            @php
                                                $invoice_total= $invoice->total_amount;
                                            @endphp
                                            @if ($invoice_total<10000)
                                                    <tr style="height: 50px;">
                                                        <th>SL No.</th>
                                                        <th>Date</th>
                                                        <th>Truck</th>
                                                        <th>Material</th>
                                                        <th>Crusher/Site</th>
                                                        <th>Description</th>
                                                        <th>Serial</th>
                                                        <th class="text-right pr-1">QTY</th>
                                                        <th class="text-right pr-1">Rate</th>
                                                        <th class="text-right pr-1">Amount</th>
                                                        <th class="text-right pr-1">VAT Rate</th>
                                                        <th class="text-right pr-1">Discount</th>
                                                        <th class="text-right pr-1">VAT Amount</th>
                                                        <th class="text-right pr-1">Total Amount</th>
                                                        <th class="text-right pr-1">Toll Fee</th>
                                                        <th class="text-right pr-1">Toll Fee Total</th>
                                                    </tr>
                                                 <tbody>
                                                    @foreach ($invoice->items as $item)
                                                    <tr class="trFontSize t-row">
                                                        <td>{{$item->id}}</td>
                                                        <td>{{date('d/m/Y', strtotime($item->date))}}</td>
                                                        <td>{{$item->truck?$item->truck->vehicle_number:''}}</td>
                                                        <td>{{$item->record?$item->record->material:''}}</td>
                                                        <td>{{$item->record?$item->record->crusher:''}}</td>
                                                        <td>{{$item->description}}</td>
                                                        <td>{{$item->truck?$item->truck->serial_no:''}}</td>

                                                        <td class="text-right pr-1">{{$item->qty}}</td>
                                                        <td class="text-right pr-1">{{$item->rate}}</td>
                                                        <td class="text-right pr-1">{{$item->amount}}</td>
                                                        <td class="text-right pr-1">{{$item->vat_rate}}</td>
                                                        <td class="text-right pr-1">{{$item->discount}}</td>
                                                        <td class="text-right pr-1">{{$item->vat_amount}}</td>
                                                        <td class="text-right pr-1">{{$item->total_amount}}</td>
                                                        <td class="text-right pr-1">{{$item->toll_fee}}</td>
                                                        <td class="text-right pr-1">{{number_format($item->toll_fee * $item->qty,2,'.','')}}</td>
                                                    </tr>
                                                    @endforeach


                                                    <tr class="trFontSize">
                                                        <td colspan="15" class="text-right pr-1">Amount: </td>
                                                        <td class="text-right pr-1">{{ $invoice->amount}}</td>
                                                        {{-- <td></td> --}}
                                                    </tr>
                                                    <tr class="trFontSize">
                                                        <td colspan="15" class="text-right pr-1">Discount: </td>
                                                        <td class="text-right pr-1">{{ $invoice->discount_amount}}</td>
                                                        {{-- <td></td> --}}
                                                    </tr>
                                                    <tr class="trFontSize">
                                                        <td colspan="15" class="text-right pr-1">Total Vat: </td>
                                                        <td class="text-right pr-1">{{ $invoice->vat_amount}}</td>
                                                        {{-- <td></td> --}}
                                                    </tr>
                                                    <tr class="trFontSize">
                                                        <td colspan="15" class="text-right pr-1">Total Toll Fee: </td>
                                                        <td class="text-right pr-1">{{ $invoice->total_toll_fee}}</td>
                                                        {{-- <td></td> --}}
                                                    </tr>
                                                    <tr class="trFontSize">
                                                        <td colspan="15" class="text-right pr-1">Total Amount: </td>
                                                        <td class="text-right pr-1">{{ $invoice->total_amount}}</td>
                                                        {{-- <td></td> --}}
                                                    </tr>
                                                    <tr class="trFontSize">
                                                        <td colspan="15" class="text-right pr-1">Paid Amount: </td>
                                                        <td class="text-right pr-1">{{ $invoice->paid_amount}}</td>
                                                        {{-- <td></td> --}}
                                                    </tr>

                                                </tbody>
                                                @else
                                                        <tr style="height: 50px;">
                                                            <th>SL No.</th>
                                                            <th>Date</th>
                                                            <th>Truck</th>
                                                            <th>Material</th>
                                                            <th>Crusher/Site</th>
                                                            <th>Description</th>
                                                            <th>Serial</th>
                                                            <th class="text-right pr-1">QTY</th>
                                                            <th class="text-right pr-1">Rate</th>
                                                            <th class="text-right pr-1">Amount</th>
                                                            <th class="text-right pr-1">VAT Rate</th>
                                                            <th class="text-right pr-1">Discount</th>
                                                            <th class="text-right pr-1">VAT Amount</th>
                                                            <th class="text-right pr-1">Total Amount</th>
                                                            <th class="text-right pr-1">Toll Fee</th>
                                                            <th class="text-right pr-1">Toll Fee Total</th>

                                                        </tr>
                                                    <tbody class="table-sm">

                                                        @foreach ($invoice->items as $item)

                                                        <tr class="trFontSize t-row">
                                                            <td>{{$item->id}}</td>
                                                            <td>{{date('d/m/Y', strtotime($item->date))}}</td>
                                                            <td>{{$item->truck?$item->truck->vehicle_number:''}}</td>
                                                            <td>{{$item->record?$item->record->material:''}}</td>
                                                            <td>{{$item->record?$item->record->crusher:''}}</td>
                                                            <td>{{$item->description}}</td>
                                                            <td>{{$item->truck?$item->truck->serial_no:''}}</td>

                                                            <td class="text-right pr-1">{{$item->qty}}</td>
                                                            <td class="text-right pr-1">{{$item->rate}}</td>
                                                            <td class="text-right pr-1">{{$item->amount}}</td>
                                                            <td class="text-right pr-1">{{$item->vat_rate}}</td>
                                                            <td class="text-right pr-1">{{$item->discount}}</td>
                                                            <td class="text-right pr-1">{{$item->vat_amount}}</td>
                                                            <td class="text-right pr-1">{{$item->total_amount}}</td>
                                                            <td class="text-right pr-1">{{$item->toll_fee}}</td>
                                                            <td class="text-right pr-1">{{number_format($item->toll_fee * $item->qty,2,'.','')}}</td>

                                                        </tr>
                                                        @endforeach

                                                        <tr class="trFontSize">
                                                            <td colspan="15" class="text-right pr-1">Amount: </td>
                                                            <td class="text-right pr-1">{{ $invoice->vat_amount+$invoice->amount}}</td>
                                                            {{-- <td></td> --}}
                                                        </tr>
                                                        <tr class="trFontSize">
                                                            <td colspan="15" class="text-right pr-1">Discount: </td>
                                                            <td class="text-right pr-1">{{ $invoice->vat_amount+$invoice->discount_amount}}</td>
                                                            {{-- <td></td> --}}
                                                        </tr>
                                                        <tr class="trFontSize">
                                                            <td colspan="15" class="text-right pr-1">Total Vat: </td>
                                                            <td class="text-right pr-1">{{ $invoice->vat_amount}}</td>
                                                            {{-- <td></td> --}}
                                                        </tr>
                                                        <tr class="trFontSize">
                                                            <td colspan="15" class="text-right pr-1">Total Toll Fee: </td>
                                                            <td class="text-right pr-1">{{ $invoice->total_toll_fee}}</td>
                                                            {{-- <td></td> --}}
                                                        </tr>
                                                        <tr class="trFontSize">
                                                            <td colspan="15" class="text-right pr-1">Total Amount: </td>
                                                            <td class="text-right pr-1">{{ $invoice->total_amount}}</td>
                                                            {{-- <td></td> --}}
                                                        </tr>
                                                        <tr class="trFontSize">
                                                            <td colspan="15" class="text-right pr-1">Paid Amount: </td>
                                                            <td class="text-right pr-1">{{ $invoice->paid_amount}}</td>
                                                            {{-- <td></td> --}}
                                                        </tr>

                                                    </tbody>
                                                @endif
                                                @endisset

                                        </table>
                                    </div>
                                </div>
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
            {{-- <span class="company-info" style="background-color: rgb(230 108 96); color:white; padding:3px 15px 5px 15px;">Tel.: {{$company_tele->config_value}} Email: {{$company_email->config_value}} TRN No: {{$company_trn->config_value}}</span> --}}
            {{-- <div style="border-bottom: 1px solid black; margin-top:4px;"></div> --}}
    </div>
    <div class="footer">

            <span style="color: #000; padding-left:30px; font-size:10px;">
                Business Software Solutions by
                <img src="{{ asset('img/zisprink.png') }}" style="max-height: 25px; " class="img-fluid" alt="">
            </span>
    </div>
    <div class="img">
        <img src="{{asset('icon/invoice-logo.png')}}" class="img-fluid" style="position: fixed; top:350px; left:60px; opacity:0.2; height:500px;" alt="">
    </div>
    <!-- ============ end absolute header/footer image========== -->

    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>
