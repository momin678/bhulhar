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
    <div class="content-wrapper">
        <table width="100%">
            <thead>
                <tr>
                    <td class="headerGroup">
                        <div class="header-block " style="padding: 2px 10px;">
                            <div class="row">
                                <div class="col-12">
                                    <div class="tex-left">
                                        <div class="row full-height d-flex align-items-center">
                                            @include('layouts.backend.partial.modal-header-info')
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
                            <div class="page">
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        {{-- <p>Date <span>{{ date('d/m/Y',strtotime($invoice->date)) }} : </span> <span style="font-size: 20px;">تاريخ</span></p> --}}
                                    </div>
                                    <div class="col-md-12 text-center mt-1">
                                        <h2>Supplier Invoice</h2>
                                    </div>
                                </div>
                                <table class="table table-bordered table-header">
                                    <tr >
                                        <th>INVOICE NO</th>
                                        <th class="text-left">: {{ $invoice->status=='Draft' ? "Draft Invoice": $invoice->invoice_no }}</th>
                                        <th>PAYMODE</th>
                                        <th>: {{ $invoice->pay_mode }}</th>

                                    </tr>
                                    <tr >
                                        <th>ADDRESS</th>
                                        <th class="text-left">: {{ $invoice->address == null? "NA":$invoice->address }}</th>
                                        <th>DATE</th>
                                        <th>: {{ date('d/m/Y',strtotime($invoice->date)) }}</th>
                                    </tr>

                                    <tr >
                                        <th>TRN</th>
                                        <th class="text-left">: {{ $invoice->supplier->trn_no }}</th>
                                        <th>LPO Number</th>
                                        <th class="text-left">:{{ $invoice->lpo_number }}</th>
                                    </tr>
                                    <tr >
                                        <th>Pay Terms</th>
                                        <th class="text-left">:
                                            @foreach ($terms as $item)
                                                @if ($item->value == $invoice->pay_terms)
                                                    {{$item->title}}
                                                @endif
                                            @endforeach</th>
                                        <th>Due Date</th>
                                        <th class="text-left">:{{ $invoice->due_date }}</th>
                                    </tr>

                                </table>
                            </div>
                            <div class="page">
                                @php
                                    $invoice_total= $invoice->amount+$invoice->vat_amount;
                                @endphp
                                @if ($invoice_total<10000)
                                <table class="table table-sm table-bordered table-font">
                                    <tr>
                                        <th class="text-center" >SL No.</th>
                                        <th class="text-center"  style="min-width: 450px; max-width: 500px;">Particular Description</th>
                                        <th class="text-center" >Quantity</th>
                                        <th class="text-center" >Rate</th>
                                        <th class="text-right pl-1" >Total Amount</th>
                                    </tr>
                                        @php
                                        $taxable_amount=0;
                                        $vat=0;
                                        $total_amount=0;
                                        @endphp
                                        @foreach ($invoice->items as $item)
                                        <tr>
                                            <td>{{$loop->index+1}}</td>
                                            <td>{{$item->description}}</td>
                                            <td>{{$item->qty}}</td>
                                            <td>{{$item->rate}}</td>
                                            <td class="text-right pl-1">{{$item->amount + $item->vat_amount}}</td>
                                        </tr>
                                            @php
                                                $taxable_amount= $taxable_amount+ $item->amount;
                                                $vat = $vat+ $item->vat_amount;
                                                $total_amount = $total_amount+ ($item->amount+ $item->vat_amount);
                                            @endphp
                                        @endforeach

                                    <tr>
                                        <th class="text-center" colspan="1" ></th>
                                        <th class="text-right" colspan="3"  >TAXABLE AMOUNT <small>(AED)</small></th>
                                        <th class="text-right"   >{{$taxable_amount}}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" colspan="1" ></th>
                                        <th class="text-right" colspan="3"  >VAT <small>(5%)</small></th>
                                        <th class="text-right"   > {{$vat}}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" colspan="1" ></th>
                                        <th class="text-right" colspan="3"  >Total Amount <small>(AED)</small></th>
                                        <th class="text-right"   > {{$total_amount}}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" colspan="1"></th>
                                        <th class="text-right" colspan="3"  >Paid Amount <small>(AED)</small></th>
                                        <th class="text-right" colspan="2"  > {{$invoice->paid_amount}}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" colspan="1"></th>
                                        <th class="text-right" colspan="3"  >Due Amount <small>(AED)</small></th>
                                        <th class="text-right" colspan="2"  > {{$invoice->due_amount}}</th>
                                    </tr>
                                </table>
                                @else
                                <table   class="table table-sm table-bordered table-font">
                                    <tr>
                                        <th class="text-center" >SL No.</th>
                                        <th class="text-center" style="min-width: 450px; max-width: 500px;">Particular Description</th>
                                        <th class="text-center" >Quantity</th>
                                        <th class="text-center" >Rate</th>
                                        <th class="text-center" >Amount</th>
                                        <th class="text-center" >VAT</th>
                                        <th class="text-right pl-1" >Total Amount</th>
                                    </tr>
                                        @php
                                        $taxable_amount=0;
                                        $vat=0;
                                        $total_amount=0;
                                        @endphp
                                        @foreach ($invoice->items as $item)
                                        <tr>
                                            <td>{{$loop->index+1}}</td>
                                            <td>{{$item->description}}</td>
                                            <td>{{$item->qty}}</td>
                                            <td>{{$item->rate}}</td>
                                            <td>{{$item->amount}}</td>
                                            <td>{{$item->vat_amount}}</td>
                                            <td class="text-right pl-1">{{$item->amount + $item->vat_amount}}</td>
                                        </tr>
                                            @php
                                                $taxable_amount= $taxable_amount+ $item->amount;
                                                $vat = $vat+ $item->vat_amount;
                                                $total_amount = $total_amount+ ($item->amount+ $item->vat_amount);
                                            @endphp
                                        @endforeach

                                    <tr>
                                        <th class="text-center" colspan="1"></th>
                                        <th class="text-center" colspan=32"  >TAXABLE AMOUNT <small>(AED)</small></th>
                                        <th class="text-center" colspan="2"  >{{$taxable_amount}}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" colspan="1"></th>
                                        <th class="text-center" colspan=32"  >VAT <small>(5%)</small></th>
                                        <th class="text-center" colspan="2"  > {{$vat}}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" colspan="1"></th>
                                        <th class="text-center" colspan=32"  >Total Amount <small>(AED)</small></th>
                                        <th class="text-center" colspan="2"  > {{$total_amount}}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" colspan="1"></th>
                                        <th class="text-center" colspan=32"  >Paid Amount <small>(AED)</small></th>
                                        <th class="text-center" colspan="2"  > {{$invoice->paid_amount}}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" colspan="1"></th>
                                        <th class="text-center" colspan=32"  >Due Amount <small>(AED)</small></th>
                                        <th class="text-center" colspan="2"  > {{$invoice->due_amount}}</th>
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
    {{-- <div class="header">
        <img src="{{ asset('img/knooz-header.png') }}" alt="header image" width="100%" height="150px"
            style="float:left; background-size: cover; padding-top:10px; padding-left:40px;padding-right:40px; padding-bottom:50px;"> <br> --}}
            {{-- <h2 class="text-center">{{ $company_name->config_value }}</h2> --}}
            {{-- <span class="company-info" style="background-color: rgb(230 108 96); color:white; padding:3px 15px 5px 15px;">Tel.: {{$company_tele->config_value}} Email: {{$company_email->config_value}} TRN No: {{$company_trn->config_value}}</span> --}}
            {{-- <div style="border-bottom: 1px solid black; margin-top:4px;"></div> --}}
    {{-- </div> --}}
    <div class="footer">
        @include('layouts.backend.partial.modal-footer-info')

    </div>
    <div class="img">
        {{-- <img src="{{ asset('storage/upload/settings/' . $invoice_log->config_value) }}" class="img-fluid"
            style="position: fixed; top:350px; left:180px; opacity:0.2; height:500px;" alt=""> --}}
    </div>
    <!-- ============ end absolute header/footer image========== -->

    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>
