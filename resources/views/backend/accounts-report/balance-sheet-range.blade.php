

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
    @media print{

        .row{
            display: flex;
        }
        .col-md-6{
            max-width: 50% !important;
        }
    }
    .card-body {
        flex: 1 1 auto;
        min-height: 1px;
        padding: 0rem !important;
    }
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
                                'activeMenu' => 'financial-report',
                            ])
                            <div class="d-flex-align-items-center gap-2">
                                <button type="button" class="btn mExcelButton formButton mr-1" title="Export" onclick="exportTableToCSV('balance-sheet-{{ date('d M Y') }}.csv')">
                                    <div class="d-flex">
                                        <div class="formSaveIcon">
                                            <img src="{{asset('assets/backend/app-assets/icon/excel-icon.png')}}" width="25">
                                        </div>
                                        <div><span>Export To CSV</span></div>
                                    </div>
                                </button>
                                <a href="#" class="btn btn_create mPrint formButton" title="Print"
                                onclick="handlePrintClick('blance-sheet')">
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
                        <section id="widgets-Statistics">
                            <div class="row mt-1" style="margin-left: 5px !important">
                                <div class="col-md-12">
                                    <form action="" method="GET" class="d-flex row">


                                        <div class="row form-group col-md-3">
                                            <input type="text" class="form-control inputFieldHeight datepicker" placeholder="From Date/Single Date" name="date" autocomplete="off">
                                        </div>
                                        <div class="row form-group col-md-3">
                                            <input type="text" class="form-control inputFieldHeight datepicker" placeholder="To Date/Single Date" name="date2" autocomplete="off">
                                        </div>

                                        <div class="col-md-3">
                                            <button type="submit" class="btn mSearchingBotton mb-2 formButton inputFieldHeight" title="Search" >
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
                            </div>
                            <div class="card-body pt-0 pb-0" id="blance-sheet">
                                <div class="row">
                                    <div class="col-12">
                                        <table  class="table table-sm table-hover">
                                                    <tr>
                                                        <th colspan="4" class="text-center">
                                                            <h5>Balance Sheet</h5>
                                                            <h6>{{ date(' d F Y', strtotime($date)) }} - {{ date(' d F Y', strtotime($date2)) }}</h6>
                                                        </th>
                                                    </tr>
                                        </table>
                                    </div>
                                    @php
                                        $total_debit=$total_debit = App\JournalRecord::openingProfitBalanceSheet($date)>0? App\JournalRecord::openingProfitBalanceSheet($date):0;
                                        $total_credit=App\JournalRecord::openingProfitBalanceSheet($date)<0? App\JournalRecord::openingProfitBalanceSheet($date)*(-1):0;
                                        $total_debit_adj=0;
                                        $total_credit_adj=0;
                                    @endphp
                                    <div class="col-6">
                                            <table  class="table table-sm table-hover">
                                                @if($total_debit>0)
                                                <tr>
                                                    <th>Opening <small>(Profit)</small></th>
                                                    <th class="text-right">{{$currency->symbole}} {{$total_debit}}</th>
                                                </tr>
                                                @endif
                                            <tr>
                                                <th>Asset</th>
                                                <th class="text-right">Amount</th>
                                            </tr>

                                            @foreach (App\JournalRecord::whereIn('account_type_id',[1])->distinct()->get('account_head_id') as $unique_master_ac)
                                                    <tr class="head-ledger" id="{{$unique_master_ac->ac_head->id}}">
                                                        <td>{{$unique_master_ac->ac_head->fld_ac_head}} </td>
                                                        <td class="text-right">{{$currency->symbole}} {{$debit_balance=$unique_master_ac->headDrCrTransaction($date,$date2) }}</td>
                                                    </tr>
                                                     @php
                                                        $total_debit=$total_debit+$debit_balance;
                                                    @endphp
                                            @endforeach

                                              @foreach (App\JournalRecord::whereIn('account_type_id',[6])->whereNotIn('account_head_id',[421,460])->distinct()->get('account_head_id') as $unique_master_ac)
                                                 @if($unique_master_ac->ac_head->id!=457)
                                                    <tr class="head-ledger" id="{{$unique_master_ac->ac_head->id}}">
                                                        <td>{{$unique_master_ac->ac_head->fld_ac_head}} </td>
                                                        <td class="text-right">{{$currency->symbole}} {{$debit_balance=$unique_master_ac->headDrCrTransaction($date,$date2)}}</td>
                                                    </tr>
                                                     @php
                                                        $total_debit=$total_debit+$debit_balance;
                                                    @endphp
                                                 @endif
                                            @endforeach

                                        </table>

                                    </div>


                                    <div class="col-6">
                                            <table  class="table table-sm table-hover">
                                                @if($total_credit>0)
                                                <tr>
                                                    <th>Opening <small>(Loss)</small></th>
                                                    <th class="text-right">{{$currency->symbole}} {{$total_credit}}</th>
                                                </tr>
                                                @endif

                                            <tr>
                                                <th>Liability & Owner's Equity</th>
                                                <th class="text-right">Amount</th>
                                            </tr>

                                            @foreach (App\JournalRecord::whereIn('account_type_id',[2])->distinct()->get('account_head_id') as $unique_master_ac)

                                                  <tr class="head-ledger" id="{{$unique_master_ac->ac_head->id}}">
                                                        <td>{{$unique_master_ac->ac_head->fld_ac_head}}</td>
                                                        <td class="text-right">{{$currency->symbole}} {{$credit_balance=($unique_master_ac->headDrCrTransaction($date,$date2)*(-1))}}</td>
                                                    </tr>

                                                 @php
                                                    $credit_balance=$credit_balance==null? 0:$credit_balance;
                                                $total_credit=$total_credit+ $credit_balance;
                                               @endphp
                                            @endforeach

                                              @foreach (App\JournalRecord::whereIn('account_type_id',[6])->whereNotIn('account_head_id',[14])->distinct()->get('account_head_id') as $unique_master_ac)

                                                  <tr class="head-ledger" id="{{$unique_master_ac->ac_head->id}}">
                                                        <td>{{$unique_master_ac->ac_head->fld_ac_head}}</td>
                                                        <td class="text-right">{{$currency->symbole}} {{$credit_balance=($unique_master_ac->headDrCrTransaction($date,$date2)*(-1))}}</td>
                                                    </tr>

                                                 @php
                                                    $credit_balance=$credit_balance==null? 0:$credit_balance;
                                                $total_credit=$total_credit+ $credit_balance;
                                               @endphp
                                            @endforeach


                                        </table>

                                    </div>


                                    <div class="col-6">
                                            <table  class="table table-sm table-hover">
                                                @if($total_credit>$total_debit)
                                                @php
                                                $loss=$total_credit-$total_debit;

                                                @endphp
                                            <tr>
                                                <td>Loss</td>
                                                <td class="text-right">{{$currency->symbole}} {{number_format($loss,2)}}   </td>
                                            </tr>
                                            @php
                                            $total_debit_adj=$total_debit+$loss;
                                            $total_credit_adj=$total_credit
                                            @endphp
                                            @endif

                                        </table>

                                    </div>


                                    <div class="col-6">
                                        <table  class="table table-sm table-hover">
                                            @if($total_credit<$total_debit)
                                            <td>Profit</td>
                                                <td class="text-right">{{$currency->symbole}} {{$profit=$total_debit-$total_credit}}</td>
                                                @php
                                                $total_credit_adj=$total_credit+ $profit;
                                                $total_debit_adj=$total_debit;

                                                @endphp
                                            @endif

                                        </table>

                                    </div>


                                       <div class="col-6">
                                            <table  class="table table-sm table-hover">

                                              <tr>
                                                   <th></th>
                                                    <th class="text-right">{{$currency->symbole}} {{$total_debit_adj}}</th>
                                                </tr>
                                        </table>

                                    </div>

                                       <div class="col-6">
                                            <table  class="table table-sm table-hover">


                                            <tr>
                                                <th></th>
                                                <th class="text-right">{{$currency->symbole}} {{$total_credit_adj}}</th>
                                            </tr>

                                        </table>

                                    </div>
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


<style>
    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #customers td,
    #customers th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #customers tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #customers tr:hover {
        background-color: #ddd;
    }

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
        text-transform: uppercase;

    }

    .graph-7 {
        background: url(../img/graphs/graph-7.jpg) no-repeat;
    }

    .graph-image img {
        display: none;
    }

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

    th {
        text-transform: uppercase;
    }
</style>
<style>
    .print-layout {
        display: none;
    }

    @media print {
        .print-layout {
            display: block;
            overflow: hidden;
        }
    }
</style>
<section class="print-layout">
    @include('layouts.backend.partial.modal-header-info')
    <div class="card-body pt-0 pb-0">
        <div class="row">
            <div class="col-md-12">
                <table  class="table table-sm table-hover">
                            <tr>
                                <th colspan="4" class="text-center">
                                    <h5>Balance Sheet</h5>
                                    <h6>{{ date(' d F Y', strtotime($date)) }} - {{ date(' d F Y', strtotime($date2)) }}</h6>
                                </th>
                            </tr>
                </table>
            </div>
            @php
                $total_debit=$total_debit = App\JournalRecord::openingProfitBalanceSheet($date)>0? App\JournalRecord::openingProfitBalanceSheet($date):0;
                $total_credit=App\JournalRecord::openingProfitBalanceSheet($date)<0? App\JournalRecord::openingProfitBalanceSheet($date)*(-1):0;
                $total_debit_adj=0;
                $total_credit_adj=0;
            @endphp
            <div class="col-md-6">
                    <table  class="table table-sm table-hover">
                        @if($total_debit>0)
                        <tr>
                            <th>Opening <small>(Profit)</small></th>
                            <th class="text-right">{{$currency->symbole}} {{$total_debit}}</th>
                        </tr>
                        @endif
                    <tr>
                        <th>Asset</th>
                        <th class="text-right">Amount</th>
                    </tr>

                    @foreach (App\JournalRecord::whereIn('account_type_id',[1])->distinct()->get('account_head_id') as $unique_master_ac)
                            <tr class="head-ledger" id="{{$unique_master_ac->ac_head->id}}">
                                <td>{{$unique_master_ac->ac_head->fld_ac_head}} </td>
                                <td class="text-right">{{$currency->symbole}} {{$debit_balance=$unique_master_ac->headDrCrTransaction($date,$date2) }}</td>
                            </tr>
                             @php
                                $total_debit=$total_debit+$debit_balance;
                            @endphp
                    @endforeach

                      @foreach (App\JournalRecord::whereIn('account_type_id',[6])->whereNotIn('account_head_id',[421,460])->distinct()->get('account_head_id') as $unique_master_ac)
                         @if($unique_master_ac->ac_head->id!=457)
                            <tr class="head-ledger" id="{{$unique_master_ac->ac_head->id}}">
                                <td>{{$unique_master_ac->ac_head->fld_ac_head}} </td>
                                <td class="text-right">{{$currency->symbole}} {{$debit_balance=$unique_master_ac->headDrCrTransaction($date,$date2)}}</td>
                            </tr>
                             @php
                                $total_debit=$total_debit+$debit_balance;
                            @endphp
                         @endif
                    @endforeach

                </table>

            </div>


            <div class="col-md-6">
                    <table  class="table table-sm table-hover">
                        @if($total_credit>0)
                        <tr>
                            <th>Opening <small>(Loss)</small></th>
                            <th class="text-right">{{$currency->symbole}} {{$total_credit}}</th>
                        </tr>
                        @endif

                    <tr>
                        <th>Liability & Owner's Equity</th>
                        <th class="text-right">Amount</th>
                    </tr>

                    @foreach (App\JournalRecord::whereIn('account_type_id',[2])->distinct()->get('account_head_id') as $unique_master_ac)

                          <tr class="head-ledger" id="{{$unique_master_ac->ac_head->id}}">
                                <td>{{$unique_master_ac->ac_head->fld_ac_head}}</td>
                                <td class="text-right">{{$currency->symbole}} {{$credit_balance=($unique_master_ac->headDrCrTransaction($date,$date2)*(-1))}}</td>
                            </tr>

                         @php
                            $credit_balance=$credit_balance==null? 0:$credit_balance;
                        $total_credit=$total_credit+ $credit_balance;
                       @endphp
                    @endforeach

                      @foreach (App\JournalRecord::whereIn('account_type_id',[6])->whereNotIn('account_head_id',[14])->distinct()->get('account_head_id') as $unique_master_ac)

                          <tr class="head-ledger" id="{{$unique_master_ac->ac_head->id}}">
                                <td>{{$unique_master_ac->ac_head->fld_ac_head}}</td>
                                <td class="text-right">{{$currency->symbole}} {{$credit_balance=($unique_master_ac->headDrCrTransaction($date,$date2)*(-1))}}</td>
                            </tr>

                         @php
                            $credit_balance=$credit_balance==null? 0:$credit_balance;
                        $total_credit=$total_credit+ $credit_balance;
                       @endphp
                    @endforeach


                </table>

            </div>


            <div class="col-md-6">
                    <table  class="table table-sm table-hover">
                        @if($total_credit>$total_debit)
                        @php
                        $loss=$total_credit-$total_debit;

                        @endphp
                    <tr>
                        <td>Loss</td>
                        <td class="text-right">{{$currency->symbole}} {{number_format($loss,2)}}   </td>
                    </tr>
                    @php
                    $total_debit_adj=$total_debit+$loss;
                    $total_credit_adj=$total_credit
                    @endphp
                    @endif

                </table>

            </div>


            <div class="col-md-6">
                <table  class="table table-sm table-hover">
                    @if($total_credit<$total_debit)
                    <td>Profit</td>
                        <td class="text-right">{{$currency->symbole}} {{$profit=$total_debit-$total_credit}}</td>
                        @php
                        $total_credit_adj=$total_credit+ $profit;
                        $total_debit_adj=$total_debit;

                        @endphp
                    @endif

                </table>

            </div>


               <div class="col-md-6">
                    <table  class="table table-sm table-hover">

                      <tr>
                           <th></th>
                            <th class="text-right">{{$currency->symbole}} {{$total_debit_adj}}</th>
                        </tr>
                </table>

            </div>

               <div class="col-md-6">
                    <table  class="table table-sm table-hover">


                    <tr>
                        <th></th>
                        <th class="text-right">{{$currency->symbole}} {{$total_credit_adj}}</th>
                    </tr>

                </table>

            </div>
        </div>
    </div>
    @include('layouts.backend.partial.modal-footer-info')
</section>
