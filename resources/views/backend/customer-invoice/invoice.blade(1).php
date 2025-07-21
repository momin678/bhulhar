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

    .table-font tr td {
        font-size: 10px !important;
        padding: 0px, 3px;
    }


    .table-header tr th {
        font-size: 11px !important;
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
            color: #000;
            text-transform: uppercase;
            font-size: 50px;
            letter-spacing: 6px;
            /* text-align: center; */
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
        width: 140px;
        height: auto;
        margin-top: -26px;
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
    body {
    font-family: Arial, sans-serif;
}

.custom-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem; /* .mt-4 in Bootstrap translates to a margin-top of 1.5rem (24px), adjust as necessary */
}

.custom-table th,
.custom-table td {
    border: 1px solid #000; /* Add your desired border color */
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
        <table width="100%">
            <thead>
                <tr>
                    <td class="headerGroup">
                        <div class="header-block " style="padding: 2px 10px;">
                            <div class="row">
                                <div class="col-12">
                                    <div class="tex-left">
                                        <div class="row">
                                            <div class="col-2 image-box">
                                                <img src="{{ asset('storage/upload/settings/' . $invoice_log->config_value) }}" class="invoice-logo" alt="">
                                            </div>
                                            <div class="col-10 text-center">
                                                <h1 class="text-upparcase invoice-header">{{$company_name->config_value}} </h1>
                                                <h1 class="text-upparcase invoice-header" style="letter-spacing: 25px;text-align:center">{{$invoice_arabic->config_value}} </h1>

                                                <p class="m-0 invoice-p ">{{$company_address->config_value}}, {{$company_tele->config_value}}, <br>
                                                    {{$company_email->config_value}}  {{$company_trn->config_value}} </p>
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
                                <div class="row mb-2 mt-3 " style="margin-right: 0px; margin-left:0px">
                                    <div class="col-4">
                                        <div class="hr-1"></div>
                                        <div class="hr-2"></div>
                                    </div>
                                    <div class="col-4">
                                        <h4 class="tax-title" style="margin-top:-8px">{{$invoice->invoice_type}}</h4>
                                    </div>
                                    <div class="col-4">
                                        <div class="hr-1"></div>
                                        <div class="hr-2"></div>
                                    </div>
                                    <div class="col-12 d-flex mt-3">
                                        <div class="col-7 d-flex flex-column ">
                                            <div class="row customer-box flex-fill">
                                                <div>
                                                    <h4 class="customer-details-title">Customer Details</h4>
                                                </div>
                                                @if($invoice->column_show->customer_name_check == 1)

                                                <div class="col-2">
                                                    <span class="text-left invoice-p">Name:</span>
                                                </div>
                                                <div class="col-10">
                                                    <span class="text-right">{{$invoice->customer?
                                                        $invoice->customer->pi_name:''}}</span>
                                                </div>
                                                @endif
                                                @if($invoice->column_show->customer_address_check == 1)
                                                <div class="col-2">
                                                    <span class="text-left invoice-p">Address:</span>
                                                </div>
                                                <div class="col-10">
                                                    <span class="text-right">{{$invoice->customer?
                                                        $invoice->customer->address:''}}</span>
                                                </div>
                                                @endif
                                                @if($invoice->column_show->customer_phone_check == 1)
                                                <div class="col-2">
                                                    <span class="text-left invoice-p">Phone:</span>
                                                </div>

                                                <div class="col-10">
                                                    <span class="text-right">{{$invoice->customer?
                                                        $invoice->customer->phone_no:''}}</span>
                                                </div>
                                                @endif
                                                @if($invoice->column_show->customer_trn_check == 1)
                                                <div class="col-2">
                                                    <span class="text-left invoice-p">TRN:</span>
                                                </div>
                                                <div class="col-10">
                                                    <span class="text-right">1{{$invoice->customer?
                                                        $invoice->customer->trn_no:''}}</span>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-5 d-flex flex-column">
                                            <div class="row customer-box-2 flex-fill">
                                                <div class="col-5">
                                                    <span class="text-left invoice-p">Date:</span>
                                                </div>
                                                <div class="col-7">
                                                    <span
                                                        class="text-right">{{date('d/m/Y',strtotime($invoice->date))}}</span>
                                                </div>
                                                @if($invoice->column_show->lpo_check == 1)
                                                <div class="col-5">
                                                    <span class="text-left invoice-p">LPO No:</span>
                                                </div>

                                                <div class="col-7">
                                                    <span class="text-right">{{$invoice->lpo_number }}</span>
                                                </div>
                                                @endif

                                                <div class="col-5">
                                                    <span class="text-left invoice-p">Invoice No:</span>
                                                </div>
                                                <div class="col-7">
                                                    <span class="text-right">{{$invoice->invoice_no }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @isset($invoice)
                                @php
                                $invoice_total= $invoice->total_amount;
                                @endphp
                                @if ($invoice_total<10000)
                                <table class="custom-table mt-4" id="invoiceTable">
                                    <thead>
                                        <tr>
                                            <th class="th-60">SL No.</th>
                                            @if($invoice->column_show->item_date_check == 1)
                                            <th class="th-60">Date</th>
                                            @endif
                                            @if($invoice->column_show->truck_check == 1)
                                            <th class="th-60">Truck</th>
                                            @endif
                                            @if($invoice->column_show->material_check == 1)
                                            <th class="th-60">Material</th>
                                            @endif
                                            @if($invoice->column_show->cursher_check == 1)
                                            <th class="th-60">Crusher</th>
                                            @endif
                                            @if($invoice->column_show->dstn_e_check == 1)
                                            <th class="th-60">Description</th>
                                            @endif
                                            @if($invoice->column_show->serial_check == 1)
                                            <th class="th-60">DO. NO</th>
                                            @endif
                                            @if($invoice->column_show->wgt_check == 1)
                                            <th class="th-60">QTY</th>
                                            @endif
                                            @if($invoice->column_show->rate_check == 1)
                                            <th class="th-60">Rate</th>
                                            @endif
                                            @if($invoice->column_show->amount_check == 1)
                                            <th class="th-60">Amount</th>
                                            @endif
                                            @if($invoice->column_show->vat_rate_check == 1)
                                            <th class="th-60 text-dark">VAT Rate</th>
                                            @endif
                                            @if($invoice->column_show->discount_check == 1)
                                            <th class="th-60">Discount</th>
                                            @endif
                                            @if($invoice->column_show->vat_amount_check == 1)
                                            <th class="th-60  text-dark">VAT</th>
                                            @endif
                                            @if($invoice->column_show->tatl_amount_check == 1)
                                            <th class="th-60  text-dark">Total</th>
                                            @endif
                                            @if($invoice->column_show->toll_check == 1)
                                            <th class="th-60">Toll Fee</th>
                                            @endif
                                            @if($invoice->column_show->total_toll_check == 1)
                                            <th class="th-60">Fee Total</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoice->items as $item)
                                        <tr class="trFontSize t-row">
                                            <td>{{$item->id}}</td>
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
                                            <td>{{$item->truck?$item->truck->serial_no:''}}</td>
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
                                            @if($invoice->column_show->total_toll_check == 1)
                                            <td class="">{{number_format($item->toll_fee * $item->qty,2,'.','')}}</td>
                                            @endif
                                        </tr>
                                        @endforeach

                                        <tr class="trFontSize">
                                            <td colspan="15" class="text-right pr-1 colspan">Amount: </td>
                                            <td class="text-right pr-1">{{ $invoice->amount}}</td>
                                        </tr>
                                        <tr class="trFontSize">
                                            <td colspan="15" class="text-right pr-1 colspan">Discount: </td>
                                            <td class="text-right pr-1">{{ $invoice->discount_amount}}</td>
                                        </tr>
                                        <tr class="trFontSize">
                                            <td colspan="15" class="text-right pr-1 colspan">Total Vat: </td>
                                            <td class="text-right pr-1">{{ $invoice->vat_amount}}</td>
                                        </tr>
                                        <tr class="trFontSize">
                                            <td colspan="15" class="text-right pr-1 colspan">Total Toll Fee: </td>
                                            <td class="text-right pr-1">{{ $invoice->total_toll_fee}}</td>
                                        </tr>
                                        <tr class="trFontSize">
                                            <td colspan="15" class="text-right pr-1 colspan">Total Amount: </td>
                                            <td class="text-right pr-1">{{ $invoice->total_amount}}</td>
                                        </tr>
                                        <tr class="trFontSize">
                                            <td colspan="15" class="text-right pr-1 colspan">Paid Amount: </td>
                                            <td class="text-right pr-1">{{ $invoice->paid_amount}}</td>
                                        </tr>
                                        <tr class="trFontSize">
                                            <td class="text-right pr-1 colspan">In Word Narration:{{  $invoice->convertNumberToWords($invoice->total_amount)}}</td>
                                            <td class="text-right pr-1 "></td>

                                        </tr>
                                    </tbody>
                                </table>
                                @else
                                <table class="custom-table mt-4" id="invoiceTable">
                                    <thead>
                                        <tr>
                                            <th class="th-60">SL No.</th>
                                            @if($invoice->column_show->item_date_check == 1)
                                            <th class="th-60">Date</th>
                                            @endif
                                            @if($invoice->column_show->truck_check == 1)
                                            <th class="th-60">Truck</th>
                                            @endif
                                            @if($invoice->column_show->material_check == 1)
                                            <th class="th-60">Material</th>
                                            @endif
                                            @if($invoice->column_show->cursher_check == 1)
                                            <th class="th-60">Crusher</th>
                                            @endif
                                            @if($invoice->column_show->dstn_e_check == 1)
                                            <th class="th-60">Description</th>
                                            @endif
                                            @if($invoice->column_show->serial_check == 1)
                                            <th class="th-60">DO. NO</th>
                                            @endif
                                            @if($invoice->column_show->wgt_check == 1)
                                            <th class="th-60">QTY</th>
                                            @endif
                                            @if($invoice->column_show->rate_check == 1)
                                            <th class="th-60">Rate</th>
                                            @endif
                                            @if($invoice->column_show->amount_check == 1)
                                            <th class="th-60">Amount</th>
                                            @endif
                                            @if($invoice->column_show->vat_rate_check == 1)
                                            <th class="th-60">VAT Rate</th>
                                            @endif
                                            @if($invoice->column_show->discount_check == 1)
                                            <th class="th-60">Discount</th>
                                            @endif
                                            @if($invoice->column_show->vat_amount_check == 1)
                                            <th class="th-60">VAT</th>
                                            @endif
                                            @if($invoice->column_show->tatl_amount_check == 1)
                                            <th class="th-60">Total</th>
                                            @endif
                                            @if($invoice->column_show->toll_check == 1)
                                            <th class="th-60">Toll Fee</th>
                                            @endif
                                            @if($invoice->column_show->total_toll_check == 1)
                                            <th class="th-60">Fee Total</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoice->items as $item)
                                        <tr class="trFontSize t-row">
                                            <td>{{$item->id}}</td>
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
                                            <td>{{$item->truck?$item->truck->serial_no:''}}</td>
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
                                            @if($invoice->column_show->total_toll_check == 1)
                                            <td class="">{{number_format($item->toll_fee * $item->qty,2,'.','')}}</td>
                                            @endif
                                        </tr>
                                        @endforeach

                                        <tr class="trFontSize">
                                            <td colspan="15" class="text-right pr-1 colspan">Amount: </td>
                                            <td class="text-right pr-1">{{ $invoice->amount}}</td>
                                        </tr>
                                        <tr class="trFontSize">
                                            <td colspan="15" class="text-right pr-1 colspan">Discount: </td>
                                            <td class="text-right pr-1">{{ $invoice->discount_amount}}</td>
                                        </tr>
                                        <tr class="trFontSize">
                                            <td colspan="15" class="text-right pr-1 colspan">Total Vat: </td>
                                            <td class="text-right pr-1">{{ $invoice->vat_amount}}</td>
                                        </tr>
                                        <tr class="trFontSize">
                                            <td colspan="15" class="text-right pr-1 colspan">Total Toll Fee: </td>
                                            <td class="text-right pr-1">{{ $invoice->total_toll_fee}}</td>
                                        </tr>
                                        <tr class="trFontSize">
                                            <td colspan="15" class="text-right pr-1 colspan">Total Amount: </td>
                                            <td class="text-right pr-1">{{ $invoice->total_amount}}</td>
                                        </tr>
                                        <tr class="trFontSize">
                                            <td colspan="15" class="text-right pr-1 colspan">Paid Amount: </td>
                                            <td class="text-right pr-1">{{ $invoice->paid_amount}}</td>
                                        </tr>
                                        <tr class="trFontSize">
                                            <td class="text-right pr-1 colspan">In Word Narration:{{  $invoice->convertNumberToWords($invoice->total_amount)}}</td>
                                            <td class="text-right pr-1 "></td>

                                        </tr>
                                    </tbody>
                                </table>
                                @endif
                                @endisset
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
    <div class="footer">

        <span style="color: #000; padding-left:30px; font-size:10px;">
            Business Software Solutions by
            <img src="{{ asset('img/zisprink.png') }}" style="max-height: 25px; " class="img-fluid" alt="">
        </span>
    </div>
    <div class="img">
        <img src="{{ asset('storage/upload/settings/' . $invoice_log->config_value) }}" class="img-fluid"
            style="position: fixed; top:350px; left:310px; opacity:0.2; height:500px;" alt="">
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
