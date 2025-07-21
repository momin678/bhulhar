
@extends('layouts.backend.app')
@section('content')
@include('layouts.backend.partial.style')
<style>
    .tabPadding{
        padding: 5px;
    }
    .padding-right{
        padding-right: 10px;
    }
    td{
        font-size: 12px !important;
    }

    th{
        font-size: 14px !important;
    }
    @media(min-width:1300px){
        .padding-right{
            padding-right: 0px !important;
        }
    }

    .card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 0rem !important;
}

tr:nth-child(even) {background-color: #f2f2f2;}
</style>
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @include('clientReport.accounting._header', ['activeMenu' => 'reports'])
            <div class="tab-content bg-white">
                <div class="tab-pane active p-2">
                    <div class="content-body">
                        <div class="d-flex justify-content-between align-items-center">
                            @include('clientReport.report.sub-header', [
                                'activeMenu' => 'accounting-report',
                            ])

                        </div>
                        <section id="widgets-Statistics">
                            <div class="cardStyleChange">
                                <div class="card-body">
                                    <div class="d-flex mt-2 pl-2">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <form action="" method="GET" class="d-flex row">
                                                    <div class="row form-group col-md-8">
                                                        <input type="text" class="inputFieldHeight form-control datepicker" name="date"  placeholder="Select Date"  required autocomplete="off">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button type="submit" class="btn mSearchingBotton mb-2 formButton" title="Search" >
                                                            <div class="d-flex">
                                                                <div class="formSaveIcon">
                                                                    <img src="{{asset('assets/backend/app-assets/icon/searching-icon.png')}}" width="25">
                                                                </div>
                                                                <div><span>Search</span></div>
                                                            </div>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-md-6 padding-right">
                                                <form action="" method="GET" >
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <input type="text" class="inputFieldHeight form-control datepicker" name="from" placeholder="From"   id="from" required autocomplete="off">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <input type="text" class="inputFieldHeight form-control datepicker" name="to"
                                                            placeholder="To"  id="to" required autocomplete="off">
                                                        </div>
                                                        <div class="col-md-2 text-right" >
                                                            <button type="submit" class="btn mSearchingBotton mb-2 formButton" title="Search" >
                                                                <div class="d-flex">
                                                                    <div class="formSaveIcon">
                                                                        <img src="{{asset('assets/backend/app-assets/icon/searching-icon.png')}}" width="25">
                                                                    </div>
                                                                    <div><span>Search</span></div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-md-3 text-right col-right-padding">
                                                <button type="button" class="btn mExcelButton formButton mr-1" title="Export" onclick="exportTableToCSV('trial-balance-{{ date('d M Y') }}.csv')">
                                                    <div class="d-flex">
                                                        <div class="formSaveIcon">
                                                            <img src="{{asset('assets/backend/app-assets/icon/excel-icon.png')}}" width="25">
                                                        </div>
                                                        <div><span>Excel</span></div>
                                                    </div>
                                                </button>
                                                <a href="#" class="btn btn_create mPrint formButton" title="Print"  onclick="handlePrintClick('Trial-Balance')">
                                                    <div class="d-flex">
                                                        <div class="formSaveIcon">
                                                            <img src="{{asset('assets/backend/app-assets/icon/print-icon.png')}}" width="25">
                                                        </div>
                                                        <div><span>Print</span></div>
                                                    </div>
                                                </a>
                                            </div>
                                            <input type="hidden" name="hidden_date_from" value="{{ isset($from)? $from:"" }}" id="hidden_date_from">
                                            <input type="hidden" name="hidden_date_to" value="{{ isset($to)? $to:"" }}" id="hidden_date_to">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body pt-0 pb-0" id="Trial-Balance">
                                <table class="table table-sm table-hover table-bordered">
                                    <tr>
                                        <th colspan="7" class="text-center">
                                            <h5>Trial Balance</h5>
                                            <h6>{{ date('d F Y', strtotime($date)) }} -
                                                {{ date('d F Y', strtotime($date1)) }}</h6>
                                        </th>
                                    </tr>
                                    <tr style="background-color: #34465b;color: #fff;">
                                        <th></th>
                                        <th class="text-center" colspan="2">Opening Balance</th>
                                        <th class="text-center" colspan="2">Transactions</th>
                                        <th class="text-center" colspan="2">Closing Balance</th>
                                    </tr>
                                    <tr>
                                        <th class="pl-2">A/C Head</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right pr-2">Credit</th>

                                    </tr>
                                    @php
                                        $total_oprning_dr = 0;
                                        $total_oprning_cr = 0;
                                        $total_transection_dr = 0;
                                        $total_transection_cr = 0;
                                        $total_closing_dr = 0;
                                        $total_closing_cr = 0;

                                    @endphp
                                    {{-- @foreach (App\JournalRecord::whereIn('master_account_id', [1, 2, 4, 5, 6, 7, 8])->distinct()->get('account_head_id') as $unique_master_ac) --}}

                                    @foreach (App\JournalRecord::whereIn('account_type_id',[1,2,4,6])->distinct()->get('account_head_id') as $unique_master_ac)

                                    <tr class="head-ledger" id="{{$unique_master_ac->ac_head?$unique_master_ac->ac_head->id:''}}">
                                            <td class="pl-2">{{ $unique_master_ac->ac_head?$unique_master_ac->ac_head->fld_ac_head:'' }}  </td>
                                            <td class="text-right">
                                                {{ number_format($opening_dr = $unique_master_ac->headOpeningBalance($unique_master_ac->account_head_id, $date) > 0 ? $unique_master_ac->headOpeningBalance($unique_master_ac->account_head_id, $date) : '0',2,'.','') }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($opening_cr = $unique_master_ac->headOpeningBalance($unique_master_ac->account_head_id, $date) < 0 ? $unique_master_ac->headOpeningBalance($unique_master_ac->account_head_id, $date) * -1 : '0',2,'.','') }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($transection_dr = $unique_master_ac->headTransection($unique_master_ac->account_head_id, $date, $date1, 'DR'),2,'.','') }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($transection_cr = $unique_master_ac->headTransection($unique_master_ac->account_head_id, $date, $date1, 'CR'),2,'.','') }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($closing_dr = $unique_master_ac->headClosingBalance($unique_master_ac->account_head_id, $date1) > 0 ? $unique_master_ac->headClosingBalance($unique_master_ac->account_head_id, $date1) : '0',2,'.','') }}
                                            </td>
                                            <td class="text-right pr-2">
                                                {{ number_format($closing_cr = $unique_master_ac->headClosingBalance($unique_master_ac->account_head_id, $date1) < 0 ? $unique_master_ac->headClosingBalance($unique_master_ac->account_head_id, $date1) * -1 : '0',2,'.','') }}
                                            </td>
                                        </tr>

                                        @php
                                            $total_oprning_dr = $total_oprning_dr + $opening_dr;
                                            $total_oprning_cr = $total_oprning_cr + $opening_cr;
                                            $total_transection_dr = $total_transection_dr + $transection_dr;
                                            $total_transection_cr = $total_transection_cr + $transection_cr;
                                            $total_closing_dr = $total_closing_dr + $closing_dr;
                                            $total_closing_cr = $total_closing_cr + $closing_cr;

                                        @endphp
                                    @endforeach


                                    @foreach (App\JournalRecord::whereNotIn('account_type_id', [1, 2, 4,6])->distinct()->distinct()->get('master_account_id') as $unique_mst)
                                        <tr class="master-head-ledger" id="{{$unique_mst->master_account_id}}">
                                            <td class="pl-2">{{ $unique_mst->master_ac->mst_ac_head }} </td>

                                            <td class="text-right">
                                                {{ number_format($opening_dr = $unique_mst->inventoryOpeningBalance($date) > 0 ? $unique_mst->inventoryOpeningBalance($date) : 0 ,2,'.','')}}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($opening_cr = $unique_mst->inventoryOpeningBalance($date) < 0 ? $unique_mst->inventoryOpeningBalance($date) * -1 : 0,2,'.','') }}
                                            </td>

                                            <td class="text-right">
                                                {{ number_format($transection_dr = $unique_mst->inventoryTransection($date, $date1, 'DR'),2,'.','') }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($transection_cr = $unique_mst->inventoryTransection($date, $date1, 'CR'),2,'.','') }}
                                            </td>


                                            <td class="text-right">
                                                {{ number_format($closing_dr = $unique_mst->inventoryClosingBalance($date1) > 0 ? $unique_mst->inventoryClosingBalance($date1) : 0 ,2,'.','')}}
                                            </td>
                                            <td class="text-right pr-2">
                                                {{ number_format($closing_cr = $unique_mst->inventoryClosingBalance($date1) < 0 ? $unique_mst->inventoryClosingBalance($date1)*(-1) : 0,2,'.','') }}
                                            </td>
                                        </tr>
                                        @php
                                            $total_oprning_dr = $total_oprning_dr + $opening_dr;
                                            $total_oprning_cr = $total_oprning_cr + $opening_cr;
                                            $total_transection_dr = $total_transection_dr + $transection_dr;
                                            $total_transection_cr = $total_transection_cr + $transection_cr;
                                            $total_closing_dr = $total_closing_dr + $closing_dr;
                                            $total_closing_cr = $total_closing_cr + $closing_cr;

                                        @endphp
                                    @endforeach
                                    <tr>
                                        <th class="pl-2">Grand Total</th>
                                        <th class="text-right">{{ number_format($total_oprning_dr,2,'.','') }}</th>
                                        <th class="text-right">{{ number_format($total_oprning_cr,2,'.','') }}</th>

                                        <th class="text-right">{{ number_format($total_transection_dr,2,'.','') }}</th>
                                        <th class="text-right">{{ number_format($total_transection_cr,2,'.','') }}</th>

                                        <th class="text-right">{{ number_format($total_closing_dr,2,'.','') }}</th>
                                        <th class="text-right pr-2">{{ number_format($total_closing_cr,2,'.','') }}</th>

                                    </tr>
                    </table>
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
@endpush
<style>
    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }
    #customers td, #customers th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #customers tr:nth-child(even){background-color: #f2f2f2;}

    #customers tr:hover {background-color: #ddd;}
    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
        text-transform: uppercase;

    }
    .graph-7{background: url(../img/graphs/graph-7.jpg) no-repeat;}
    .graph-image img{display: none;}
    @media screen {
    div.divFooter {
        display: none;
    }
    }
    @media print {
        div.divFooter {
            position: fixed;
            bottom: 0;
        }
    }
    th{
        text-transform: uppercase;
    }
</style>
<style>
    .print-layout{
        display: none;
    }
    @media print{
        .print-layout{
            display: block;
            overflow: hidden;
        }
    }
 </style>
<section class="print-layout">
@include('layouts.backend.partial.modal-header-info')

<div class="card-body pt-0 pb-0">
      <table class="table table-sm table-hover table-bordered">
                                    <tr>
                                        <th colspan="7" class="text-center">
                                            <h5>Trial Balance</h5>
                                            <h6>{{ date('d F Y', strtotime($date)) }} -
                                                {{ date('d F Y', strtotime($date1)) }}</h6>
                                        </th>
                                    </tr>
                                    <tr style="background-color: #34465b;color: #fff;">
                                        <th></th>
                                        <th class="text-center" colspan="2">Opening Balance</th>
                                        <th class="text-center" colspan="2">Transactions</th>
                                        <th class="text-center" colspan="2">Closing Balance</th>
                                    </tr>
                                    <tr>
                                        <th class="pl-2">A/C Head</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right pr-2">Credit</th>

                                    </tr>
                                    @php
                                        $total_oprning_dr = 0;
                                        $total_oprning_cr = 0;
                                        $total_transection_dr = 0;
                                        $total_transection_cr = 0;
                                        $total_closing_dr = 0;
                                        $total_closing_cr = 0;

                                    @endphp
                                    {{-- @foreach (App\JournalRecord::whereIn('master_account_id', [1, 2, 4, 5, 6, 7, 8])->distinct()->get('account_head_id') as $unique_master_ac) --}}

                                    @foreach (App\JournalRecord::whereIn('account_type_id',[1,2,4,6])->distinct()->get('account_head_id') as $unique_master_ac)

                                    <tr class="head-ledger" id="{{$unique_master_ac->ac_head?$unique_master_ac->ac_head->id:''}}">
                                            <td class="pl-2">{{ $unique_master_ac->ac_head?$unique_master_ac->ac_head->fld_ac_head:'' }}  </td>
                                            <td class="text-right">
                                                {{ number_format($opening_dr = $unique_master_ac->headOpeningBalance($unique_master_ac->account_head_id, $date) > 0 ? $unique_master_ac->headOpeningBalance($unique_master_ac->account_head_id, $date) : '0',2,'.','') }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($opening_cr = $unique_master_ac->headOpeningBalance($unique_master_ac->account_head_id, $date) < 0 ? $unique_master_ac->headOpeningBalance($unique_master_ac->account_head_id, $date) * -1 : '0',2,'.','') }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($transection_dr = $unique_master_ac->headTransection($unique_master_ac->account_head_id, $date, $date1, 'DR'),2,'.','') }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($transection_cr = $unique_master_ac->headTransection($unique_master_ac->account_head_id, $date, $date1, 'CR'),2,'.','') }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($closing_dr = $unique_master_ac->headClosingBalance($unique_master_ac->account_head_id, $date1) > 0 ? $unique_master_ac->headClosingBalance($unique_master_ac->account_head_id, $date1) : '0',2,'.','') }}
                                            </td>
                                            <td class="text-right pr-2">
                                                {{ number_format($closing_cr = $unique_master_ac->headClosingBalance($unique_master_ac->account_head_id, $date1) < 0 ? $unique_master_ac->headClosingBalance($unique_master_ac->account_head_id, $date1) * -1 : '0',2,'.','') }}
                                            </td>
                                        </tr>

                                        @php
                                            $total_oprning_dr = $total_oprning_dr + $opening_dr;
                                            $total_oprning_cr = $total_oprning_cr + $opening_cr;
                                            $total_transection_dr = $total_transection_dr + $transection_dr;
                                            $total_transection_cr = $total_transection_cr + $transection_cr;
                                            $total_closing_dr = $total_closing_dr + $closing_dr;
                                            $total_closing_cr = $total_closing_cr + $closing_cr;

                                        @endphp
                                    @endforeach


                                    @foreach (App\JournalRecord::whereNotIn('account_type_id', [1, 2, 4,6])->distinct()->distinct()->get('master_account_id') as $unique_mst)
                                        <tr class="master-head-ledger" id="{{$unique_mst->master_account_id}}">
                                            <td class="pl-2">{{ $unique_mst->master_ac->mst_ac_head }} </td>

                                            <td class="text-right">
                                                {{ number_format($opening_dr = $unique_mst->inventoryOpeningBalance($date) > 0 ? $unique_mst->inventoryOpeningBalance($date) : 0 ,2,'.','')}}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($opening_cr = $unique_mst->inventoryOpeningBalance($date) < 0 ? $unique_mst->inventoryOpeningBalance($date) * -1 : 0,2,'.','') }}
                                            </td>

                                            <td class="text-right">
                                                {{ number_format($transection_dr = $unique_mst->inventoryTransection($date, $date1, 'DR'),2,'.','') }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($transection_cr = $unique_mst->inventoryTransection($date, $date1, 'CR'),2,'.','') }}
                                            </td>


                                            <td class="text-right">
                                                {{ number_format($closing_dr = $unique_mst->inventoryClosingBalance($date1) > 0 ? $unique_mst->inventoryClosingBalance($date1) : 0 ,2,'.','')}}
                                            </td>
                                            <td class="text-right pr-2">
                                                {{ number_format($closing_cr = $unique_mst->inventoryClosingBalance($date1) < 0 ? $unique_mst->inventoryClosingBalance($date1)*(-1) : 0,2,'.','') }}
                                            </td>
                                        </tr>
                                        @php
                                            $total_oprning_dr = $total_oprning_dr + $opening_dr;
                                            $total_oprning_cr = $total_oprning_cr + $opening_cr;
                                            $total_transection_dr = $total_transection_dr + $transection_dr;
                                            $total_transection_cr = $total_transection_cr + $transection_cr;
                                            $total_closing_dr = $total_closing_dr + $closing_dr;
                                            $total_closing_cr = $total_closing_cr + $closing_cr;

                                        @endphp
                                    @endforeach
                                    <tr>
                                        <th class="pl-2">Grand Total</th>
                                        <th class="text-right">{{ number_format($total_oprning_dr,2,'.','') }}</th>
                                        <th class="text-right">{{ number_format($total_oprning_cr,2,'.','') }}</th>

                                        <th class="text-right">{{ number_format($total_transection_dr,2,'.','') }}</th>
                                        <th class="text-right">{{ number_format($total_transection_cr,2,'.','') }}</th>

                                        <th class="text-right">{{ number_format($total_closing_dr,2,'.','') }}</th>
                                        <th class="text-right pr-2">{{ number_format($total_closing_cr,2,'.','') }}</th>

                                    </tr>
                                </table>
</div>
@include('layouts.backend.partial.modal-footer-info')
</section>
@push('js')



@endpush
