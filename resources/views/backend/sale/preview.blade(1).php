<style>
    .row{
        display: flex;
    }
    .col-md-1{
        max-width: 8.33% !important;
    }
    .col-md-2{
        max-width: 16.66% !important;
    }
    .col-md-8{
        max-width: 66.66% !important;
    }
    .col-md-10{
        max-width: 83.33% !important;
    }
    .col-md-11{
        max-width: 91.66% !important;
    }
    .customer-static-content{
        background: #ada8a81c;
    }
    .customer-dynamic-content{
        background: #706f6f33;
    }
    .proview-table tr td, .proview-table tr th{
        border: 1px solid black !important;
    }
    .customer-dynamic-content2{
        background: #fff !important;
    }
    .customer-content{
        border: 1px solid black !important;
    }
    @media print and (color) {
        .proview-table {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
    @media print{
        .row{
            display: flex;
        }
        .col-md-1{
            max-width: 8.33% !important;
        }
        .col-md-2{
            max-width: 16.66% !important;
        }
        .col-md-8{
            max-width: 66.66% !important;
        }
        .col-md-10{
            max-width: 83.33% !important;
        }
        .col-md-11{
            max-width: 91.66% !important;
        }
        .customer-static-content{
            background: #ada8a81c;
        }
        .customer-dynamic-content{
            background: #706f6f33;
        }
        .proview-table tr td, table tr th{
            border: 1px solid black !important;
        }
        #widgets-Statistics{
            padding: 2px !important;
        }
        .customer-dynamic-content2{
            background: #fff !important;
        }
        .customer-content{
            border: 1px solid black !important;
        }
    }
</style>
@php
      $whole = floor($sale->total_budget);
    $fraction = number_format($sale->total_budget - $whole, 2);
    $f = new NumberFormatter('en', NumberFormatter::SPELLOUT);
    $amount_in_word = $f->format($whole);
    $amount_in_word2 = $f->format($fraction);
@endphp
<section class="print-hideen border-bottom">
    <div class="d-flex flex-row-reverse">
        <div class="py-1 pr-1"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
            <div class="py-1 pr-1"><a href="#" onclick="window.print();" class="btn btn-icon btn-secondary"><i class="bx bx-printer"></i></a></div>

            <div class="py-1 pr-1 w-100 pl-2">
                <h4>{{$sale->invoice_type=="Tax Invoice"? 'Tax Invoice':'Proforma Invoice'}}</h4>
            </div>
        </div>
</section>
@php
    $trn_no= \App\Setting::where('config_name', 'trn_no')->first();
    $company_name= \App\Setting::where('config_name', 'company_name')->first();
@endphp
@include('layouts.backend.partial.modal-header-info')
<section id="widgets-Statistics">
    <div class="row">
        <div class="col-md-12">
            <div class="customer-info">
                <div class="row ml-1 mr-1 customer-content">
                    <div class="col-md-2 customer-static-content">
                        M/S: <br>
                        Address: <br>
                        Attention: <br>
                        Contact No: <br>
                        Customer Trn: <br>
                    </div>
                    <div class="col-md-10 customer-dynamic-content">
                        .{{$sale->party->pi_name}} <br>
                        .{{$sale->party->address}} <br>
                        .<br>
                        .{{$sale->party->con_no}} <br>
                        .{{$sale->party->trn_no}} <br>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <h5 class="ml-1 mr-1" style="background: #E6BC99; border: 1px solid black; margin-top: 5px;margin-bottom:0px;"> {{$sale->invoice_type=="Tax Invoice"? 'Tax Invoice':'Proforma Invoice'}}</h5>
                <p style="color: #e85933;margin-bottom:5px !important;">{{'('.$trn_no->config_value.')'}}</p>
            </div>
            <div class="company-info">
                <div class="row ml-1 mr-1 customer-content">
                    <div class="col-md-2 customer-static-content">
                        TAX INVOICE: <br>
                        D.o No: <br>
                        Quotation No: <br>
                        Site/Project: <br>
                    </div>
                    <div class="col-md-7 customer-dynamic-content2">
                        . <span class="text-danger">{{$sale->invoice_no}}</span> <br>
                        .<br>
                        .<br>
                        .{{$sale->project?$sale->project->project_name:''}} <br>
                    </div>
                    <div class="col-md-3 customer-dynamic-content2">
                        <span>
                            Date: {{date('d/m/Y',strtotime($sale->date))}} <br><br>
                        </span>
                        <span>
                            L.P.O NO:<br> <br>
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row" style="padding: 15px;">
        <div class="col-md-12">
            <table class="table table-sm table-bordered border-botton proview-table" style="color: black; ">
                <thead style="background: #E6BC99 !important;color: black;">
                    <tr >
                        <th style="color: black !important;">S. No.</th>
                        <th style="color: black !important;">Description</th>
                        <th style="color: black !important;">Qty</th>
                        <th style="color: black !important;">Unit</th>
                        <th style="color: black !important;">Rate</th>
                        <th style="color: black !important;">Amount <small>(@if(!empty($currency->symbole)){{$currency->symbole}}@endif)</small></th>
                    </tr>
                </thead>
                @php
                    $cc=0;
                @endphp
                <tbody class="user-table-body">
                        @foreach ($sale->tasks as $item)
                        <tr>
                            <td>{{++$cc}}</td>
                            <td>{{$item->item_description}}</td>
                            <td>{{$item->qty}}</td>
                            <td>{{$item->unit_name->name}}</td>
                            <td>{{number_format($item->rate,2)}}</td>
                            <td>{{number_format($item->budget,2)}}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right pr-1" style="background: #ada8a81c">Total</td>
                            <td style="background: #ada8a81c">{{number_format($sale->budget,2)}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right pr-1" style="background: #ada8a81c">Vat <small>({{$standard_vat_rate}}%)</small></td>
                            <td style="background: #ada8a81c">{{number_format($sale->vat,2)}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td colspan="3" class="text-right pr-1" style="background: #ada8a81c">Total(AED):</small></td>
                            <td style="background: yellow">{{number_format($sale->total_budget,2)}}</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-center" style="text-transform: uppercase">
                                {{ $amount_in_word }}
                                @if ($fraction > 0)
                                    {{ '& ' . substr($amount_in_word2, 10) }}
                                @endif {{ $currency->symbole }}
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-between aligin-items-center mt-3" style="padding: 15px;">
        <div class="w-100">
            Receiver's Sign ------------------------------------------
            <span>
                علامة المتلقي
            </span>
        </div>
        <div class="d-flex justify-content-between aligin-items-center mb-1 w-100 pl-2">
            <span style="width:100px !important; color:#313131;font-size:15px;font-weight:bold; line-height:23px !important;" class="pl-2">
                For <br> {{$company_name->config_value}}
            </span>
        </div>
    </div>

    <div class="divFooter w-100 mb-1 ml-1"style="text-align: center !important">
        <p class="text-center" style="text-align: center !important">
            تليفون : ٠٦٧٤٨۰۲۲۳، ص.ب : ۸۲۱٦، منطقة الصناعية الجديدة، عجمان - ا.ع.م <br>
            Tel: 06 7480223, P.O. Box: 8216, New Industrial Area, Ajman - U.A.E. <br> Email:
            binhindifabrication@yahoo.com
        </p>
        <p class="mt-1 text-left"> Business Software Solutions by <span style="color: #0005" class="spanStyle"><img class="img-fluid" src="{{ asset('img/zisprink.png')}}" alt="" width="70"></span></p>
    </div>
</section>

