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
                                        <h4 class="tax-title" style="margin-top:-8px">TAX INVOICE</h4>
                                    </div>
                                    <div class="col-3">
                                        <div class="hr-1"></div>
                                        <div class="hr-2"></div>
                                    </div>
                                    <div class="col-12 d-flex mt-3">
                                        <div class="col-7 d-flex flex-column ">
                                            <div class="row customer-box flex-fill">
                                                <div>
                                                    <h4 class="customer-details-title">Customer Details</h4>
                                                </div>

                                                <div class="col-2">
                                                    <span class="text-left invoice-p">Name:</span>
                                                </div>
                                                <div class="col-10">
                                                    <span class="text-right">M&P(MORTAR AND PALSSTER DRAYMIX LLC</span>
                                                </div>
                                                <div class="col-2">
                                                    <span class="text-left invoice-p">Address:</span>
                                                </div>
                                                <div class="col-10">
                                                    <span class="text-right">ABUDHABI, UAE</span>
                                                </div>
                                                <div class="col-2">
                                                    <span class="text-left invoice-p">TRN:</span>
                                                </div>
                                                <div class="col-10">
                                                    <span class="text-right">100253021200003</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-5 d-flex flex-column">
                                            <div class="row customer-box-2 flex-fill">
                                                <div class="col-5">
                                                    <span class="text-left invoice-p">Date:</span>
                                                </div>
                                                <div class="col-7">
                                                    <span class="text-right">30/04/2024</span>
                                                </div>
                                                <div class="col-5">
                                                    <span class="text-left invoice-p">Invoice No:</span>
                                                </div>
                                                <div class="col-7">
                                                    <span class="text-right">3055</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <table class="table table-bordered table-header">
                                    <tr >
                                        <th>SI NO</th>
                                        <th>DATE</th>
                                        <th> PARTICULARS</th>
                                        <th>DO.NO</th>
                                        <th> VECHICLE NO</th>
                                        <th>RATE(DHS)</th>
                                    </tr>
                                </table>
                            </div>
                            {{-- <div class="page">
                                @php
                                    $invoice_total= $invoice->amount+$invoice->vat_amount;
                                @endphp
                                @if ($invoice_total<10000)
                                <table class="table table-sm table-font table-bordered">
                                    <tr class="bg-color">
                                        <th>SL No.</th>
                                        <th>Particular Description</th>
                                        <th class="text-right pr-1" >Quantity</th>
                                        <th class="text-right pr-1" >Rate</th>
                                        <th class="text-right pr-1" >Total Amount</th>
                                    </tr>
                                        @php
                                        $taxable_amount=0;
                                        $vat=0;
                                        $total_amount=0;
                                        @endphp
                                        @foreach ($invoice->items as $item)
                                        <tr>
                                            <td>{{$loop->index+1}}</td>
                                            <td class="">{{$item->description}}</td>
                                            <td class="text-right">{{$item->qty}}</td>
                                            <td class="text-right">{{$item->rate}}</td>
                                            <td class="text-right">{{$item->amount + $item->vat_amount}}</td>
                                        </tr>
                                            @php
                                                $taxable_amount= $taxable_amount+ $item->amount;
                                                $vat = $vat+ $item->vat_amount;
                                                $total_amount = $total_amount+ ($item->amount+ $item->vat_amount);
                                            @endphp
                                        @endforeach

                                    <tr>
                                        <th class="text-right pr-1" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="2"></th>
                                        <th class="text-right pr-1 bg-color" colspan="2"  >Total Quantity</th>
                                        <th class="text-right pr-1 bg-color">{{number_format($invoice->items->sum('qty'), 2)}}</th>
                                    </tr>

                                    <tr>
                                        <th class="text-right pr-1" style="border-bottom: 1px solid white !important; border-left: 1px solid white !important" colspan="2" ></th>
                                        <th class="text-right pr-1 bg-color" colspan="2"  >Taxable Amount <small>(AED)</small></th>
                                        <th class="text-right pr-1 bg-color"   >{{ round($taxable_amount,2) }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right pr-1" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="2" ></th>
                                        <th class="text-right pr-1 bg-color" colspan="2"  >VAT <small>(5%)</small></th>
                                        <th class="text-right pr-1 bg-color" > {{ round($vat,2) }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right pr-1" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important" colspan="2" ></th>
                                        <th class="text-right pr-1 bg-color" colspan="2"  >Total Amount <small>(AED)</small></th>
                                        <th class="text-right pr-1 bg-color"   > {{ $invoice->vat_amount+$invoice->amount }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right pr-1" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="2" ></th>
                                        <th class="text-right pr-1 bg-color" colspan="2"  >Paid Amount <small>(AED)</small></th>
                                        <th class="text-right pr-1 bg-color"   > {{$invoice->paid_amount}}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right pr-1" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="2" ></th>
                                        <th class="text-right pr-1 bg-color" colspan="2"  >Due Amount <small>(AED)</small></th>
                                        <th class="text-right pr-1 bg-color"   > {{$invoice->due_amount}}</th>
                                    </tr>
                                </table>
                                @else
                                <table class="table table-sm table-font table-bordered">
                                    <tr class="bg-color">
                                        <th>SL No.</th>
                                        <th>Description</th>
                                        <th class="text-right pr-1" >Rate</th>
                                        <th class="text-right pr-1" >Quantity</th>
                                        <th class="text-right pr-1" >Gross Amount</th>
                                        <th class="text-right pr-1" >Tax Rate</th>
                                        <th class="text-right pr-1" >Tax Amount</th>
                                        <th class="text-right pr-1" >Net Amount</th>
                                    </tr>
                                        @php
                                        $taxable_amount=0;
                                        $vat=0;
                                        $total_amount=0;
                                        @endphp
                                        @foreach ($invoice->items as $item)
                                        <tr>
                                            <td>{{$loop->index+1}}</td>
                                            <td class="description">{{$item->description}}</td>
                                            <td>{{$item->rate}}</td>
                                            <td class="text-right">{{$item->qty}}</td>
                                            <td class="text-right">{{$item->amount}}</td>
                                            <td class="text-right">{{floatval($item->vat_rate)}}</td>
                                            <td class="text-right">{{$item->vat_amount}}</td>
                                            <td class="text-right">{{$item->amount + $item->vat_amount}}</td>
                                        </tr>
                                            @php
                                                $taxable_amount= $taxable_amount+ $item->amount;
                                                $vat = $vat+ $item->vat_amount;
                                                $total_amount = $total_amount+ ($item->amount+ $item->vat_amount);
                                            @endphp
                                        @endforeach

                                    <tr>
                                        <th class="text-right pr-1" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="3"></th>
                                        <th class="text-right pr-1 bg-color" colspan="4"  >Total Quantity</th>
                                        <th class="text-right pr-1 bg-color" colspan="2"  >{{number_format($invoice->items->sum('qty'), 2)}}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right pr-1" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="3"></th>
                                        <th class="text-right pr-1 bg-color" colspan="4"  >Taxable Amount <small>(AED)</small></th>
                                        <th class="text-right pr-1 bg-color" colspan="2"  >{{round($taxable_amount,2)}}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right pr-1" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="3"></th>
                                        <th class="text-right pr-1 bg-color" colspan="4"  >VAT <small>(5%)</small></th>
                                        <th class="text-right pr-1 bg-color" colspan="2"  > {{round($vat,2)}}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right pr-1" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="3"></th>
                                        <th class="text-right pr-1 bg-color" colspan="4"  >Total Amount <small>(AED)</small></th>
                                        <th class="text-right pr-1 bg-color" colspan="2"  > {{ $invoice->vat_amount+$invoice->amount }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right pr-1" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="3" ></th>
                                        <th class="text-right pr-1 bg-color" colspan="4"  >Paid Amount <small>(AED)</small></th>
                                        <th class="text-right pr-1 bg-color" colspan="2"  > {{$invoice->paid_amount}}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right pr-1" style="border-bottom: 1px solid white !important;  border-left: 1px solid white !important;" colspan="3" ></th>
                                        <th class="text-right pr-1 bg-color" colspan="4"  >Due Amount <small>(AED)</small></th>
                                        <th class="text-right pr-1 bg-color" colspan="2"  > {{$invoice->due_amount}}</th>
                                    </tr>
                                </table>
                                @endif
                            </div> --}}
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
