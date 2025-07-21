@extends('layouts.backend.app')
@section('content')
@push('css')
@include('layouts.backend.partial.style')
<style>
    thead{
        background: transparent !important;
        color: #ffffff;
    }
    .page-header h2,
    .page-header h4{
        color: #333333 !important;
        font-weight: 400;
    }
    .page-header h2{
        letter-spacing: 0.5px;
    }
    #summery-table .table-heading-title{
        color: #333333 !important;
        font-weight: 500 !important;
        letter-spacing: 0.3 !important;
        font-size: 16px !important;
        line-height: 25px !important;
        padding-left:10px !important;
        text-transform: capitalize !important;
        background: transparent !important;
    }
    #summery-table{
        border-collapse: collapse;
        border:1px solid #999999;
    }
    #summery-table th,
    #summery-table td{
        text-align: center;
        border: 1px solid #999999;
        color: #333333;
        font-weight: 400;
        font-size:14px !important;
    }
    .accordion .pluseMinuseIcon.collapsed::before{
        content: "\f067";;
        cursor: pointer;
        border: 1px solid rgb(123, 123, 123);
    }
    .accordion .pluseMinuseIcon::before {
        font-family: 'FontAwesome';
        content: "\f068";
        cursor: pointer;
        border: 1px solid rgb(123, 123, 123);
    }
    .print-header-footer{
        display: none !important;
    }
    tr td{
        cursor: pointer;
    }
    @media print{
        .print-header-footer{
            display: block !important;
        }
        .master-tab-section{
            display: none !important;
        }
        .thermal-print2{
            display: none !important;
        }
        .thermal-table-add{
            width: 75px !important;
            font-size: 10px;
            max-width: 75px !important;
        }
        .dropdown-filter-dropdown{
            display: none;
        }
        .nav.nav-tabs ~ .tab-content {
            border-left: 1px solid #fff !important;
            border-right: 1px solid #fff !important;
            border-bottom: 1px solid #fff !important;
            padding-left: 0;
        }
        .thermal-header-print2 {
            width: 175px !important;
            min-width: 300px !important;
            text-align: center !important;
            align-content: center !important;
        }
        .print-header-tityle-style-thermal{
            font-size:13px;
            text-align: center !important;
        }
        .print-address-style-thermal{
            font-size:9px;
            text-align: center !important;
        }
        @page {
            margin: 0px !important;
            padding: 0px !important;
        }
    }
</style>
    @php
        $grand_total_value = 0;
        $grand_total_pcs = 0;
    @endphp
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                @include('clientReport.accounting._header', ['activeMenu' => 'reports'])
                <div class="tab-content bg-white journaCreation">
                    <div class="p-1 print-hidden">
                        @include('clientReport.report.sub-header', [
                            'activeMenu' => 'vat-reports',
                        ])
                    </div>
                    <div class="tab-pane active p-2">
                        <div class="content-body">
                            <section id="widgets-Statistics">
                                <div class="cardStyleChange" id="print-table">
                                    <span class="print-header-footer ">
                                        @include('layouts.backend.partial.modal-header-info')
                                    </span>
                                    <div class="card-body px-1 py-0 print-hideen">
                                        <div class="row">

                                            <div class="col-md-9 padding-right">
                                                <form action="" method="GET">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <input type="text" class="inputFieldHeight form-control datepicker" name="date" placeholder="Single Date" id="date" autocomplete="off">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="text" class="inputFieldHeight form-control datepicker" name="from" placeholder="From" id="from" autocomplete="off">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="text" class="inputFieldHeight form-control datepicker" name="to" placeholder="To" id="to" autocomplete="off">
                                                        </div>
                                                        <div class="col-md-2 text-right">
                                                            <button type="submit"
                                                                class="btn mSearchingBotton mb-2 formButton" title="Search">
                                                                <div class="d-flex">
                                                                    <div class="formSaveIcon">
                                                                        <img src="{{ asset('assets/backend/app-assets/icon/searching-icon.png') }}"
                                                                            width="25">
                                                                    </div>
                                                                    <div><span>Search</span></div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                            <div class="col-md-3 text-right col-right-padding">
                                                <button type="button" class="btn mExcelButton formButton mr-1"
                                                    title="Export"
                                                    onclick="exportTableToCSV('general-ledger-{{ date('d M Y') }}.csv')">
                                                    <div class="d-flex">
                                                        <div class="formSaveIcon">
                                                            <img src="{{ asset('assets/backend/app-assets/icon/excel-icon.png') }}"
                                                                width="25">
                                                        </div>
                                                        <div><span>Excel</span></div>
                                                    </div>
                                                </button>
                                                <a href="#" class="btn btn_create mPrint formButton" title="Print"
                                                    onclick="window.print()">
                                                    <div class="d-flex">
                                                        <div class="formSaveIcon">
                                                            <img src="{{ asset('assets/backend/app-assets/icon/print-icon.png') }}"
                                                                width="25">
                                                        </div>
                                                        <div><span>Print</span></div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0" style="padding: 0 !important;">
                                        <table class="table table-sm table-bordered table-hover text-center">
                                            <tr style="background: gray; color:#ffffff;">
                                                <th>SL. NO</th>
                                                <th>DATE</th>
                                                <th>NARRATION</th>
                                                <th>INPUT VAT</th>
                                                <th>OUTPUT VAT</th>
                                                <th>BALANCE</th>
                                            </tr>
                                            @php
                                                $t_balance=0;
                                                $cash_in = 0;
                                                $cash_out = 0;
                                            @endphp
                                            @foreach ($journal_records as $key => $item)
                                                @php
                                                    $cash_in = null;
                                                    $cash_out = null;
                                                    if($item->account_head_id==18){
                                                        $cash_in = $item->amount;
                                                    }else {
                                                        $cash_out = $item->amount;
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{date('d/m/Y', strtotime($item->journal_date))}}</td>
                                                    @if($item->journal)
                                                    <td>
                                                        @if ($item->journal->invoice_no)
                                                        Customer Invoice - {{$item->journal->invoice_no}}
                                                        @endif
                                                        @if($item->journal->purchase_expense_id)
                                                        Purchase/Expense - {{$item->journal->purchaseExp->purchase_no}}
                                                        @endif
                                                        @if($item->journal->payment_id)
                                                        Payment Voucher - {{$item->journal->payment_voucher->payment_no}}
                                                        @endif
                                                        @if($item->journal->receipt_id)
                                                        Revceive Voucher - {{$item->journal->receipt_voucher->receipt_no}}
                                                        @endif
                                                    </td>
                                                    @else
                                                    <td>Not Found</td>
                                                    @endif
                                                    <td>{{$cash_in?number_format($balance_in=$cash_in,2,'.',''):$balance_in=null}}</td>
                                                    <td>{{$cash_out?number_format($balance_out=$cash_out,2,'.',''):$balance_out=null}}</td>
                                                    <td>
                                                        {{number_format($t_balance=($t_balance+$balance_in)-$balance_out,2,'.','') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                    <div class="divFooter mb-1 ml-1 print-header-footer ">
                                        Business Software Solutions by
                                        <span style="color: #0005" class="spanStyle"><img class="img-fluid" src="{{ asset('img/zisprink.png') }}" alt="" width="70"></span>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        $(document).on('change', '#date', function(e){
            $("#from").val('');
            $("#to").val('');
        });
        $(document).on('change', '#from', function(e){
            $("#date").val('');
        });
        $(document).on('change', '#to', function(e){
            $("#date").val('');
        });
    </script>
@endpush