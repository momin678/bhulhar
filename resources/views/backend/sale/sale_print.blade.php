<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend') }}/app-assets/css/bootstrap.css">
        <link rel="stylesheet" href="{{ asset('css/print.css') }}">

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #fff !important;
        }

        .customer-static-content {
            background: #ada8a81c;
        }

        .customer-dynamic-content {
            background: #706f6f33;
        }

        .customer-dynamic-content2{
            background: #fff !important;
        }
        .customer-content{
            border: 1px solid black !important;
        }
    </style>

    <title>Invoice</title>
</head>

<body onload="window.print();">
    @php
        $whole = floor($sale->total_budget);
        $fraction = number_format($sale->total_budget - $whole, 2);
        $f = new NumberFormatter('en', NumberFormatter::SPELLOUT);
        $amount_in_word = $f->format($whole);
        $amount_in_word2 = $f->format((int)($fraction*100));
    @endphp
    @php
        $trn_no = \App\Setting::where('config_name', 'trn_no')->first();
        $company_name = \App\Setting::where('config_name', 'company_name')->first();
    @endphp

    @php
        $trn_no = \App\Setting::where('config_name', 'trn_no')->first();
        $company_name = \App\Setting::where('config_name', 'company_name')->first();
    @endphp
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <table width="100%">
            <thead>
                <tr>
                    <td class="headerGroup">
                        <div class="header-block">
                            {{-- print header --}}
                        </div>
                    </td>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td class="footerGroup">
                        <div class="footer-block">
                            {{-- print footer --}}
                        </div>
                    </td>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <td>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="customer-info">
                                    <div class="row ml-1 mr-1 ">
                                        <div class="col-sm-2 customer-static-content">
                                            M/S: <br>
                                            Address: <br>
                                            Attention: <br>
                                            Contact No: <br>
                                            Customer TRN: <br>
                                        </div>
                                        <div class="col-sm-10 customer-dynamic-content">
                                            {{ $sale->party->pi_name }} <br>
                                            {{ $sale->party->address }} <br>
                                            {{ $sale->attention}}<br>
                                            @if ($sale->party->phone_no==$sale->party->con_no && $sale->party->con_no!='.' && $sale->party->con_no!='')
                                            {{$sale->party->phone_no}}
                                            @elseif($sale->party->con_no && $sale->party->phone_no && $sale->party->con_no!='.' && $sale->party->phone_no!='.')
                                            {{$sale->party->con_no.', '. $sale->party->phone_no}}
                                            @else
                                            {{$sale->party->con_no && $sale->party->con_no!='.'? $sale->party->con_no:($sale->party->phone_no?$sale->party->phone_no:'')}}

                                            @endif
                                            <br>
                                            {{ $sale->party->trn_no }} <br>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h5 class="ml-1 mr-1" style="background: #E6BC99; margin-top: 5px;margin-bottom:5px;">
                                        {{ $sale->invoice_type == 'Tax Invoice' ? 'Tax Invoice' : ($sale->invoice_type == 'Proforma Invoice' ? 'Proforma Invoice' : 'Invoice') }}
                                    </h5>
                                    @if ($sale->invoice_type == 'Tax Invoice')
                                        <p style="color: #e85933;margin-bottom:5px !important;">
                                            {{ '(' . $trn_no->config_value . ')' }}</p>
                                    @endif
                                </div>
                                <div class="company-info">
                                    <div class="row ml-1 mr-1 ">
                                        <div class="col-sm-2 customer-static-content">
                                            {{ $sale->invoice_type == 'Tax Invoice' ? 'Tax Invoice' : ($sale->invoice_type == 'Proforma Invoice' ? 'Proforma Invoice' : 'Invoice') }}: <br>
                                            D.o No: <br>
                                            Quotation No: <br>
                                            Site/Project: <br>
                                        </div>
                                        <div class="col-sm-7 customer-dynamic-content">
                                            <span class="text-danger">{{ $sale->invoice_no }}</span> <br>
                                            {{$sale->do_no}} <br>
                                            {{$sale->quotation_no}} <br>
                                            {{$sale->site_project}} <br>
                                        </div>
                                        <div class="col-sm-3 customer-dynamic-content">
                                            <span>
                                                Date: {{ date('d/m/Y', strtotime($sale->date)) }} <br><br>
                                            </span>
                                            <span>
                                                LPO NO: {{$sale->lpo_no}}<br> <br>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row" style="padding: 15px;">
                            <div class="col-sm-12">
                                <table class="table-sm table-bordered border-botton  w-100" style="color: black; ">
                                    <thead style="background-color: #706f6f33 !important;color: black;">
                                        <tr >
                                            <th class="text-center" style="color: black !important;width:50px;">S.no</th>
                                            <th class="text-center" style="color: black !important;"> Description</th>
                                            <th class="text-center" style="color: black !important;width:70px"> Qty</th>
                                            <th class="text-center" style="color: black !important;width:70px"> Unit</th>
                                            <th class="text-center" style="color: black !important;width:70px"> Rate</th>
                                            <th class="text-center"  style="color: black !important;width:130px"> Amount <small>(@if(!empty($currency->symbole)){{$currency->symbole}}@endif)</small></th>
                                        </tr>
                                    </thead>
                                    @php
                                        $cc = 0;
                                    @endphp
                                    <tbody class="user-table-body">
                                        @foreach ($sale->tasks as $item)
                                            <tr class="text-center">
                                                <td class="text-center" style="padding-right: 7px; vertical-align: top !important;">{{ ++$cc }}</td>
                                                <td>
                                                    <pre class="text-left border-0">{{ $item->item_description }}</pre>
                                                </td>
                                                <td>{{ floatval($item->qty) }}</td>
                                                <td>{{ $item->unit }}</td>
                                                <td class="text-center">{{ $item->rate }}</td>
                                                <td class="text-center">{{ $item->budget }}</td>
                                            </tr>
                                        @endforeach





                                        <tr>
                                            <td class="text-center" colspan="3"></td>
                                            <td class="text-left pr-1" colspan="2" style="background: #706f6f33">Total</td>
                                            <td class="text-center" style="background: #706f6f33">
                                                {{ $sale->budget }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center" colspan="3"></td>

                                            <td class="text-left pr-1" colspan="2" style="background: #706f6f33">VAT{{'@'. $standard_vat_rate }}%
                                            </td>
                                            <td class="text-center" style="background: #706f6f33">
                                                {{ $sale->vat}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center" colspan="3"></td>

                                            <td class="text-left pr-1" colspan="2" style="">Total(AED):</small></td>
                                            <td class="text-center" style="">
                                                {{ $sale->total_budget }}
                                            </td>
                                        </tr>
                                        <tr>

                                            <td colspan="6" class="text-center text-dark text-capitalize"
                                                style="border-center:1px solid #f2dede;font-size:14px;font-weight:500;">
                                                In Words: {{ $amount_in_word }} Dirhams
                                                @if ($fraction > 0)
                                                    {{ '& ' . $amount_in_word2 }}
                                                @else
                                                    No
                                                @endif Fils
                                            </td>


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
        @include('layouts.backend.partial.modal-header-info')
    </div>
    <div class="footer">
        <div class="d-flex justify-content-between aligin-items-center " style="padding: 5px;">
            <div class="w-100">
                Receiver's Sign -------------------------------------
                <span>
                    علامة المتلقي
                </span>
            </div>
            <div class="d-flex justify-content-between aligin-items-center  w-100 ">
                <span style=" color:#313131;font-size:15px;font-weight:bold; line-height:23px !important;"
                    class="pl-2">
                    For <br> {{ $company_name->config_value }}
                </span>
            </div>
        </div>

        {{-- <div class="divFoote  invoice-view-wrapper" style="background: #f6f5f5 ; padding-top:10px ; padding-bottom:10px">
            <p class="text-center" style="text-align: center !important">
                تليفون : ٠٦٧٤٨۰۲۲۳، ص.ب : ۸۲۱٦، منطقة الصناعية الجديدة، عجمان - ا.ع.م <br>
                Tel: 06 7480223, P.O. Box: 8216, New Industrial Area, Ajman - U.A.E. <br> Email:
                binhindifabrication@yahoo.com</p>
        </div> --}}
        <div class="divFooter text-left">
            Business Software Solutions by
            <span style="color: #0005" class="spanStyle"><img class="img-fluid"
                    src="{{ asset('img/zisprink.png') }}" alt="" width="70"></span>
        </div>
    </div>
    <!-- ============ end absolute header/footer image========== -->

    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>
