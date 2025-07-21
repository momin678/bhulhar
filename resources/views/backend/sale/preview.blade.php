<style>
    .row {
        display: flex;
    }

    .col-md-1 {
        max-width: 8.33% !important;
    }

    .col-md-2 {
        max-width: 16.66% !important;
    }

    .col-md-8 {
        max-width: 66.66% !important;
    }

    .col-md-10 {
        max-width: 83.33% !important;
    }

    .col-md-11 {
        max-width: 91.66% !important;
    }

    .customer-static-content {
        background: #ada8a81c;
    }

    .customer-dynamic-content {
        background: #706f6f33;
    }

    .proview-table tr td,
    .proview-table tr th {
        border: 1px solid black !important;
    }

    .customer-dynamic-content2 {
        background: #fff !important;
    }

    .customer-content {
        border: 1px solid black !important;
    }

    @media print and (color) {
        .proview-table {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }

    @media print {
        .row {
            display: flex;
        }

        .col-md-1 {
            max-width: 8.33% !important;
        }

        .col-md-2 {
            max-width: 16.66% !important;
        }

        .col-md-8 {
            max-width: 66.66% !important;
        }

        .col-md-10 {
            max-width: 83.33% !important;
        }

        .col-md-11 {
            max-width: 91.66% !important;
        }

        .customer-static-content {
            background: #ada8a81c;
        }

        .customer-dynamic-content {
            background: #706f6f33;
        }

        .proview-table tr td,
        table tr th {
            border: 1px solid black !important;
        }

        #widgets-Statistics {
            padding: 2px !important;
        }

        .customer-dynamic-content2 {
            background: #fff !important;
        }

        .customer-content {
            border: 1px solid black !important;
        }
    }
</style>
@php
    $whole = floor($sale->total_budget);
    $fraction = number_format($sale->total_budget - $whole, 2);
    $f = new NumberFormatter('en', NumberFormatter::SPELLOUT);
    $amount_in_word = $f->format($whole);
    $amount_in_word2 = $f->format((int) ($fraction * 100));
@endphp
<section class=" border-bottom" style="padding: 5px 15px;background:#364a60;">
    <div class="d-flex flex-row-reverse">
        <div class="" style="margin-top: 6px;"><a href="#" class="close btn-icon btn btn-danger"
                data-dismiss="modal" aria-label="Close" style="padding-bottom: 8px;" title="Close"><span
                    aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
        {{-- <div class="" style="padding-right: 3px;margin-top: 6px;"><a href="#" onclick="window.print();" class="btn btn-icon btn-success" title="Print"><i class="bx bx-printer"></i></a></div> --}}
        <div class="" style="padding-right: 3px;margin-top: 6px;"><a href="{{ route('sale-print', $sale->id) }}"
                target="_blank" class="btn btn-icon btn-success" title="Print"><i class="bx bx-printer"></i></a></div>
        @if ($sale->invoice_type == 'Proforma Invoice')
            <div class="" style="padding-right: 3px;margin-top: 6px;"><a
                    href="{{ route('convert-to-tax-invoice', $sale->id) }}" class="btn btn-icon btn-info"
                    title="Convert into tax invoice"><i class='bx bx-transfer-alt'></i></a></div>
        @endif
        <div class="w-100">
            <h4 style="font-family:Cambria;font-size: 2rem;color:white;">
                {{ $sale->invoice_type == 'Tax Invoice' ? 'Tax Invoice' : ($sale->invoice_type == 'Proforma Invoice' ? 'Proforma Invoice' : 'Invoice') }}
            </h4>
        </div>
    </div>
</section>
@php
    $trn_no = \App\Setting::where('config_name', 'trn_no')->first();
    $company_name = \App\Setting::where('config_name', 'company_name')->first();
@endphp
@include('layouts.backend.partial.modal-header-info')

<section id="widgets-Statistics">
    <div class="row pt-1">
        <div class="col-md-12">
            <div class="customer-info">
                <div class="row ml-1 mr-1 " style="border: 2px solid #bdbdbd;">
                    <div class="col-md-2 customer-static-content">
                        M/S: <br>
                        Address: <br>
                        Attention: <br>
                        Contact No: <br>
                        Customer TRN: <br>
                    </div>
                    <div class="col-md-10 customer-dynamic-content">
                        {{ $sale->party->pi_name }} <br>
                        {{ $sale->party->address }} <br>
                        {{ $sale->attention }}<br>
                        @if ($sale->party->phone_no == $sale->party->con_no && $sale->party->con_no != '.' && $sale->party->con_no != '')
                            {{ $sale->party->phone_no }}
                        @elseif($sale->party->con_no && $sale->party->phone_no && $sale->party->con_no != '.' && $sale->party->phone_no != '.')
                            {{ $sale->party->con_no . ', ' . $sale->party->phone_no }}
                        @else
                            {{ $sale->party->con_no && $sale->party->con_no != '.' ? $sale->party->con_no : ($sale->party->phone_no ? $sale->party->phone_no : '') }}
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
                    <p style="color: #e85933;margin-bottom:5px !important;">{{ '(' . $trn_no->config_value . ')' }}</p>
                @endif
            </div>
            <div class="company-info">
                <div class="row ml-1 mr-1 " style="border: 2px solid #bdbdbd;">
                    <div class="col-md-2 customer-static-content">
                        {{ $sale->invoice_type == 'Tax Invoice' ? 'Tax Invoice' : ($sale->invoice_type == 'Proforma Invoice' ? 'Proforma Invoice' : 'Invoice') }}:
                        <br>
                        D.o No: <br>
                        Quotation No: <br>
                        Site/Project: <br>
                    </div>
                    <div class="col-md-7 customer-dynamic-content2">
                        <span class="text-danger">{{ $sale->invoice_no }}</span> <br>
                        {{ $sale->do_no }} <br>
                        {{ $sale->quotation_no }} <br>
                        {{ $sale->site_project }} <br>
                    </div>
                    <div class="col-md-3 customer-dynamic-content2">
                        <span>
                            Date: {{ date('d/m/Y', strtotime($sale->date)) }} <br><br>
                        </span>
                        <span>
                            LPO NO: {{ $sale->lpo_no }}<br> <br>
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
                    <tr class="text-center">
                        <th style="color: black !important;">Sl No.</th>
                        <th class="text-center" style="color: black !important;">Description</th>
                        <th style="color: black !important;">Qty</th>
                        <th style="color: black !important;">Unit</th>
                        <th class="text-center" style="color: black !important;">Rate</th>
                        <th class="text-center" style="color: black !important;">Amount <small>(@if (!empty($currency->symbole))
                                    {{ $currency->symbole }}
                                @endif)</small></th>
                    </tr>
                </thead>
                @php
                    $cc = 0;
                @endphp
                <tbody class="user-table-body">
                    @foreach ($sale->tasks as $item)
                        <tr class="text-center">
                            <td>{{ ++$cc }}</td>
                            <td class="text-left">
                                <pre class="text-left border-0">{{ $item->item_description }}</pre>
                            </td>
                            <td>{{ floor($item->qty) }}</td>
                            <td>{{ $item->unit }}</td>
                            <td class="text-center">{{ $item->rate }}</td>
                            <td class="text-center">{{ $item->budget }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="4"></td>
                        <td class="text-right pr-1" style="background: #ada8a81c">Total</td>
                        <td class="text-center" style="background: #ada8a81c">{{ $sale->budget }}</td>
                    </tr>
                    <tr>
                        <td class="text-center" colspan="4"></td>

                        <td class="text-right pr-1" style="background: #ada8a81c">VAT
                            <small>({{ $standard_vat_rate }}%)</small></td>
                        <td class="text-center" style="background: #ada8a81c">{{ $sale->vat }}</td>
                    </tr>
                    <tr>
                        <td class="text-center" colspan="4"></td>

                        <td class="text-right pr-1" style="background: #ada8a81c">Total(AED):</small></td>
                        <td class="text-center" style="background: yellow">{{ $sale->total_budget }}</td>
                    </tr>
                    <tr>

                        <td colspan="6" class="text-center text-dark text-capitalize"
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

    <section>
        <div class="row pt-4">
            <div class="col-12 text-center">
                <h3>Supporting Document</h3>
            </div>
            @if ($sale->voucher_scan != '' && $sale->voucher_scan2 != '')
                <div class="col-6 text-center">
                    @if (Str::endsWith($sale->voucher_scan, '.pdf'))
                        <!-- Display a PDF icon or link -->
                        <a href="{{ asset('storage/upload/sale/' . $sale->voucher_scan) }}" target="_blank">View
                            <img src="{{asset('icon/pdf-download-icon-2.png')}}" alt="Image" class="img-fluid" style="height: 50px"></a>
                    @else
                        <!-- Display the image -->
                        <a href="{{ asset('storage/upload/sale') }}/{{ $sale->voucher_scan }}" target="_blank"> <img
                                src="{{ asset('storage/upload/sale') }}/{{ $sale->voucher_scan }}" class="img-fluid"
                                style="width: 490px" alt=""></a>
                    @endif

                </div>
                <div class="col-6 text-center">


                    @if (Str::endsWith($sale->voucher_scan, '.pdf'))
                        <!-- Display a PDF icon or link -->
                        <a href="{{ asset('storage/upload/sale2/' . $sale->voucher_scan2) }}" target="_blank">View
                            <img src="{{asset('icon/pdf-download-icon-2.png')}}" alt="Image" class="img-fluid" style="height: 50px"></a>
                    @else
                        <!-- Display the image -->
                        <a href="{{ asset('storage/upload/sale2') }}/{{ $sale->voucher_scan2 }}" target="_blank">
                            <img src="{{ asset('storage/upload/sale2') }}/{{ $sale->voucher_scan2 }}"
                                class="img-fluid" style="width: 490px" alt=""></a>
                    @endif



                </div>
            @elseif($sale->voucher_scan != '' && $sale->voucher_scan2 == '')
                <div class="col-12 text-center">
                    @if (Str::endsWith($sale->voucher_scan, '.pdf'))
                        <!-- Display a PDF icon or link -->
                        <a href="{{ asset('storage/upload/sale/' . $sale->voucher_scan) }}" target="_blank">View
                            <img src="{{asset('icon/pdf-download-icon-2.png')}}" alt="Image" class="img-fluid" style="height: 50px"></a>
                    @else
                        <!-- Display the image -->
                        <a href="{{ asset('storage/upload/sale') }}/{{ $sale->voucher_scan }}" target="_blank"> <img
                                src="{{ asset('storage/upload/sale') }}/{{ $sale->voucher_scan }}" class="img-fluid"
                                style="width: 490px" alt=""></a>
                    @endif
                </div>
            @elseif($sale->voucher_scan == '' && $sale->voucher_scan2 != '')
                <div class="col-12 text-center">

                    @if (Str::endsWith($sale->voucher_scan, '.pdf'))
                        <!-- Display a PDF icon or link -->
                        <a href="{{ asset('storage/upload/sale2/' . $sale->voucher_scan2) }}" target="_blank">View
                            <img src="{{asset('icon/pdf-download-icon-2.png')}}" alt="Image" class="img-fluid" style="height: 50px"></a>
                    @else
                        <!-- Display the image -->
                        <a href="{{ asset('storage/upload/sale2') }}/{{ $sale->voucher_scan2 }}" target="_blank">
                            <img src="{{ asset('storage/upload/sale2') }}/{{ $sale->voucher_scan2 }}"
                                class="img-fluid" style="width: 490px" alt=""></a>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <div class="d-flex justify-content-between aligin-items-center mt-3" style="padding: 15px;">
        <div class="w-100">
            Receiver's Sign ------------------------------------------
            <span>
                علامة المتلقي
            </span>
        </div>
        <div class="d-flex justify-content-between aligin-items-center mb-1 w-100 ">
            <span style=" color:#313131;font-size:15px;font-weight:bold; line-height:23px !important;" class="pl-2">
                For <br> {{ $company_name->config_value }}
            </span>
        </div>
    </div>

    <div class="divFoote  invoice-view-wrapper" style="background: #f6f5f5 ; padding-top:10px ; padding-bottom:10px">
        <p class="text-center" style="text-align: center !important">
            تليفون : ٠٦٧٤٨۰۲۲۳، ص.ب : ۸۲۱٦، منطقة الصناعية الجديدة، عجمان - ا.ع.م <br>
            Tel: 06 7480223, P.O. Box: 8216, New Industrial Area, Ajman - U.A.E. <br> Email:
            binhindifabrication@yahoo.com</p>
    </div>
    <div class="divFooter mb-1 ml-1 invoice-view-wrapper  footer-margin">
        Business Software Solutions by
        <span style="color: #0005" class="spanStyle"><img class="img-fluid"
                src="{{ asset('img/zisprink.png') }}" alt="" width="70"></span>
    </div>
</section>
<div class="img receipt-bg invoice-view-wrapper">
    <img src="{{ asset('img/finallogo.PNG') }}" class="img-fluid"
        style="position: fixed; top: 420px; left: 200px; opacity: 0.2; width: 650px !important; height: 250px;"
        alt="">

    {{-- <img src="{{ asset('img/finallogo.jpeg') }}" class="img-fluid" style="position: fixed; top:100px; left:0px; opacity:0.1;width:100%; " alt=""> --}}
</div>
