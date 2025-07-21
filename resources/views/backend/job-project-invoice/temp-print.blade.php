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
        pre{
            margin: 0px !important;
        }

    </style>

    <title>Invoice</title>
</head>

<body onload="window.print();">

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
                                    <div class="row ml-1 mr-1"style="border: 2px solid #bdbdbd;">
                                        <div class="col-sm-2 customer-static-content" style="padding-left: 3px ">
                                            M/S: <br>
                                            Address: <br>
                                            Attention: <br>
                                            Contact No: <br>
                                            Customer TRN: <br>
                                        </div>
                                        <div class="col-sm-10 customer-dynamic-content">
                                            {{$tem_invoice->party->pi_name}} <br>
                                            {{$tem_invoice->party->address}} <br>
                                            {{$tem_invoice->attention}} <br>
                                            @if ($tem_invoice->party->phone_no==$tem_invoice->party->con_no && $tem_invoice->party->con_no!='.' && $tem_invoice->party->con_no!='')
                                            {{$tem_invoice->party->phone_no}}
                                            @elseif($tem_invoice->party->con_no && $tem_invoice->party->phone_no && $tem_invoice->party->con_no!='.' && $tem_invoice->party->phone_no!='.')
                                            {{$tem_invoice->party->con_no.', '. $tem_invoice->party->phone_no}}
                                            @else
                                            {{$tem_invoice->party->con_no && $tem_invoice->party->con_no!='.'? $tem_invoice->party->con_no:($tem_invoice->party->phone_no?$tem_invoice->party->phone_no:'')}}

                                            @endif
                                            <br>
                                            {{$tem_invoice->party->trn_no}} <br>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h5 class="ml-1 mr-1" style="background: #E6BC99;  margin-top: 5px;margin-bottom:0px;"> {{ $tem_invoice->tax_invoice}}</h5>
                                    @if ($tem_invoice->tax_invoice!='Proforma Invoice')
                                        <p style="color: #e85933;margin-bottom:5px !important;">{{'('.$trn_no->config_value.')'}}</p>
                                    @endif
                                </div>
                                <div class="company-info">
                                    <div class="row ml-1 mr-1 " style="border: 2px solid #bdbdbd;">
                                        <div class="col-sm-2 customer-static-content" style="padding-left: 3px ">
                                            {{$tem_invoice->tax_invoice}}: <br>
                                            D.o No: <br>
                                            Quotation No: <br>
                                            Project Name: <br>
                                        </div>
                                        <div class="col-sm-7 customer-dynamic-content">
                                             <span class="text-danger">{{$tem_invoice->invoice_no}}</span> <br>
                                             {{$tem_invoice->project?$tem_invoice->project->do_no:''}}<br>
                                             {{$tem_invoice->project->quotation?$tem_invoice->project->quotation->project_code:''}} <br>
                                            {{$tem_invoice->project?$tem_invoice->project->project_name:''}}<br>
                                        </div>
                                        <div class="col-sm-3 customer-dynamic-content pl-0">
                                            <span>
                                                Date: {{date('d/m/Y',strtotime($tem_invoice->date))}} <br><br>
                                            </span>
                                            <span>
                                                LPO NO:{{$tem_invoice->project?$tem_invoice->project->lpo_no:''}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <h6 style="margin-top: 15px; margin-bottom: 0px; color: red;">

                                    {{$tem_invoice->top_note}}

                                </h6>
                            </div>
                        </div>
                        <div class="row" style="padding: 15px;">
                            <div class="col-sm-12">
                                <table class="table-sm table-bordered border-botton  w-100" style="color: black;">
                                    <thead style="background-color: #706f6f33 !important;color: black;">
                                        <tr >
                                            <th class="text-center" style="color: black !important;width:50px;">S.no</th>
                                            <th class="text-center" style="color: black !important;"> Description</th>
                                            <th class="text-center" style="color: black !important;width:70px"> Unit</th>
                                            <th class="text-center" style="color: black !important;width:70px"> Qty</th>
                                            <th class="text-center" style="color: black !important;width:70px"> Rate</th>
                                            @if ($tem_invoice->project->discount>0)
                                            <th class="text-center" style="color: black !important;width:70px"> Discount</th>
                                            @endif
                                            <th class="text-center"  style="color: black !important;width:130px"> Amount <small>(@if(!empty($currency->symbole)){{$currency->symbole}}@endif)</small></th>
                                        </tr>
                                    </thead>
                                    @php
                                        $cc=0;
                                    @endphp
                                    <tbody class="user-table-body">
                                        @if ($tem_invoice->project->invoice_type == 'amount_base')
                                        @foreach ($tem_invoice->project->tasks as $key => $task)

                                            <tr>
                                                <td class="text-center" style="padding-right: 7px; vertical-align: top !important;">{{ ++$key }}</td>
                                                <td class="text-left">{{$task->task_name}} <br>
                                                    <pre class=" text-left border-0">{{$task->description}}</pre>
                                                </td>

                                                <td class="text-center" style="vertical-align: top !important"> {{$task->unit}} </td>
                                                <td class="text-center" style="vertical-align: top !important"> {{floatval($task->qty)}} </td>
                                                <td class="text-center" style="vertical-align: top !important"> {{$task->rate}} </td>
                                                @if ($tem_invoice->project->discount>0)
                                                <td class="text-center" style="vertical-align: top !important">{{number_format($task->discount, 2,'.','')}}</td>
                                                @endif
                                                <td class="text-center" style="vertical-align: top !important">{{number_format($task->amount, 2,'.','')}}</td>
                                                {{-- @if($key == 1)
                                                <td style=";text-align:right !important">{{$tem_invoice->due_amount }}</td>
                                                @else
                                                <td></td>
                                                @endif --}}

                                            </tr>

                                            @endforeach

                                        @else
                                            @foreach ($tem_invoice->tasks as $key => $item)
                                            <tr>
                                                <td class="text-center">{{++$key}}</td>
                                                <td class="text-left">{{$item->task_name }} <br>
                                                <pre class="text-left border-0">{{$item->description}}</pre>
                                                </td>
                                                <td class="text-center"> {{$item->unit}} </td>
                                                <td class="text-center"> {{floatval($item->qty)}} </td>
                                                <td class="text-center" > {{$item->rate}} </td>
                                                @if ($tem_invoice->project->discount>0)
                                                <td class="text-center" style="vertical-align: top !important">{{number_format($task->discount, 2,'.','')}}</td>
                                                @endif
                                                <td class="text-center" style="vertical-align: top !important">{{number_format($task->amount, 2,'.','')}}</td>
                                            </tr>
                                            @endforeach
                                        @endif
                                        @if ($tem_invoice->with_note)
                                            <tr>
                                                <td></td>
                                                <td colspan="5 {{$tem_invoice->project->discount>0?6:5}}">Note</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td colspan="5 {{$tem_invoice->project->discount>0?6:5}}">
                                                    Total works of amount:
                                                    {{ number_format($tem_invoice->project->total_budget + ($standard_vat_rate / 100) * $tem_invoice->project->total_budget,2,'.','') }}
                                                    (Including VAT)
                                                </td>
                                            </tr>
                                            @php
                                                $cc=0
                                            @endphp
                                            @foreach ($notes as $key => $data)
                                                <tr>
                                                    <td></td>
                                                    <td colspan="5 {{$tem_invoice->project->discount>0?6:5}}">
                                                        {{$data->top_note}} Invoice No :
                                                        {{ $data->invoice_no }} AED {{ $data->total_budget }} /- 
                                                        (@foreach ($data->receipts as $receipt)
                                                            {{ $receipt->payment->pay_mode == 'Cheque' ? $receipt->payment->cheque_no : $receipt->payment->pay_mode }}
                                                            <{{ $receipt->Total_amount }}>
                                                        @endforeach )
                                                    </td>
                                                </tr>
                                            @endforeach


                                    <tr>
                                        <td></td>
                                        <td colspan="5 {{$tem_invoice->project->discount>0?6:5}}">
                                            {{$tem_invoice->top_note}} Invoice No :
                                            {{ $tem_invoice->invoice_no }} AED {{ $tem_invoice->total_budget }} /- ()
                                        </td>
                                    </tr>
                                    @endif
                                        <tr>
                                            <td colspan="{{$tem_invoice->project->discount>0 ? 3 : 2}}" rowspan="5"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-left pr-1" style="background: #706f6f33"> Total Amount</td>
                                            <td style="background: #706f6f33;text-align:center !important">{{$tem_invoice->project->total_budget}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-left pr-1" style="background: #706f6f33"> Invoiced Amount</td>
                                            <td style="background: #706f6f33;text-align:center !important">{{$tem_invoice->budget }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-left pr-1" style="background: #706f6f33"> VAT {{'@'.$standard_vat_rate}}% </td>
                                            <td style="background: #706f6f33;text-align:center !important">{{$tem_invoice->vat}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-left pr-1" >Invoiced Total Amount ({{$currency->symbole}}) </td>
                                            <td style="background: #ada8a81c;text-align:center !important">{{$tem_invoice->total_budget}}</td>
                                        </tr>


                                        <tr>
                                            @php

                                                $whole = floor($tem_invoice->total_budget);
                                                $fraction = number_format($tem_invoice->total_budget - $whole, 2);
                                                $f = new NumberFormatter('en', NumberFormatter::SPELLOUT);
                                                $amount_in_word = $f->format($whole);
                                                $amount_in_word2 = $f->format((int)($fraction*100));
                                            @endphp
                                            <td colspan="{{$tem_invoice->project->discount>0 ? 7 : 6}}" class="text-right pr-1 text-dark text-uppercase"
                                                style="border-right:1px solid #f2dede;font-size:14px;font-weight:500;">
                                                In Words: {{ $amount_in_word }} Dirhams
                                                @if ($fraction > 0)
                                                    {{ '& ' . $amount_in_word2 }}
                                                @else
                                                No
                                                @endif Fils
                                            </td>
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
