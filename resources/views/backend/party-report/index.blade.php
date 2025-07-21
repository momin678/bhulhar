
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
    .print-header-footer {
                display: none ;
            }

     td{
        text-align: center !important;
    }
    th{
        text-align: center !important;
    }
    .trFontSize {
    font-size: 11px !important;
    }
    @media(min-width:1300px){
        .padding-right{
            padding-right: 0px !important;
        }
    }
    @media print {
           @page {
            max-width: 10px;

           }
            .print-header-footer {
                display: block !important;
            }
            body {
                margin: 0px;
                padding: 0px;
            }
            .bg-secondary {
                background-color: #475F7B !important;
                color:#000 !important;
            }
            #print-table {
                margin-right: 10px;
                margin-left: 10px
            }
        }
</style>
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @include('clientReport.party._header', [
                'activeMenu' => 'report',
            ])
            <div class="tab-content bg-white">
                <div class="tab-pane active">
                    <div class="content-body pt-1">
                        <section id="widgets-Statistics">

                            <div class="cardStyleChange">
                                <div class="card-body px-1 py-0 mt-2 pl-2">
                                    <div class="d-flex">
                                        <div class="col-md-12">
                                            <form action="" method="GET" class="d-flex row">
                                                <div class="row form-group col-md-3 mr-0">
                                                    <select name="party_name" id="party_name" class="form-control common-select2" required>
                                                        <option value="">Select...</option>
                                                        @foreach ($parties as $item)
                                                        <option value="{{$item->id}}" {{$party!=null? ($item->id==$party->id?'selected':''):''}}>{{$item->pi_name}} ({{$item->pi_type}})</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="row form-group col-md-3 mr-0">
                                                    <input type="text" class="form-control inputFieldHeight datepicker" placeholder="From Date/Single Date" name="date" autocomplete="off">
                                                </div>
                                                <div class="row form-group col-md-3 mr-0">
                                                    <input type="text" class="form-control inputFieldHeight datepicker" placeholder="To Date/Single Date" name="date2" autocomplete="off">
                                                </div>

                                                <div class="col-md-3 mr-0">
                                                    <button type="submit" class="btn mSearchingBotton mb-2 formButton inputFieldHeight" title="Search" >
                                                        <div class="d-flex">
                                                            <div class="formSaveIcon">
                                                                <img src="{{asset('assets/backend/app-assets/icon/searching-icon.png')}}" width="25">
                                                            </div>
                                                            <div><span>Search</span></div>
                                                        </div>
                                                    </button>
                                                    <a href="#" class="btn btn_create mPrint formButton mb-2" title="Print"
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
                                            </form>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            @if($records!=null)
                            <div class="card-body pt-0 pb-0">
                                <div id="print-table">
                                    <span class="print-header-footer" >
                                        @include('layouts.backend.partial.modal-header-info')
                                    </span>
                                    <table  class="table table-sm table-bordered table-hover">
                                        <tr>
                                            <th colspan="7" class="text-center">
                                                <h6>{{$party->pi_name}} @if(!empty($currency->licence_name)){{$currency->licence_name}} @endif-{{$party->trn_no}}</h6>
                                                <h6>Ledger</h6>

                                                <h6>{{$date!=null?date('d F Y', strtotime($date)):''}} {{$date2!=null? '-'.date('d F Y', strtotime($date2)):''}}</h6>
                                            </th>
                                        </tr>

                                        <tr class="text-center trFontSize" style="background-color:#34465b;color:white;">
                                            <th>Date</th>
                                            {{-- <th style="width: 150px">Branch</th> --}}

                                            <th style="width: 150px">Account Head</th>
                                            {{-- <th>Transection</th> --}}
                                            <th>Narration</th>
                                            <th>Debit <small>({{$currency->symbole}})</small></th>
                                            <th>Credit <small>({{$currency->symbole}})</small></th>
                                            <th>Balance <small>({{$currency->symbole}})</small></th>
                                        </tr>
                                        @php
                                        $balance=0;
                                    @endphp
                                    @if ($date != null)
                                        @php
                                        $balance=App\PartyInfo::opening($party,$date);
                                        @endphp
                                        <tr class="text-center trFontSize">
                                            <td colspan="3">Opening Balance</td>
                                            <td>{{$balance>=0? $balance:0}}</td>
                                            <td>{{$balance>=0? 0:(-1)*$balance}}</td>

                                            <td>{{$balance>=0? 'DR '.$balance:'CR '.((-1)*$balance)}} </td>
                                        </tr>
                                    @endif
                                    @foreach ($records as $record)
                                    @php
                                        $journal=App\Journal::find($record->journal_id);
                                    @endphp

                                        <tr  class="text-center trFontSize journalDetails" v-type="main" style="cursor: pointer;" id="{{ $record->journal_id }}">
                                            <td>{{date('d-M-Y', strtotime($journal->date))}}</td>
                                            {{-- <td>{{$journal->project->proj_name}}</td> --}}
                                            @if($journal->records()->whereIn('account_head_id',[1,27])->where('transaction_type','DR')->first())
                                            <td>{{$journal->records()->where('transaction_type','DR')->first()? $journal->records()->where('transaction_type','DR')->first()->ac_head->fld_ac_head:'Not Found'}} </td>

                                            {{-- <td>
                                                @foreach ($journal->records()->where('transaction_type','CR')->get() as $item)
                                                {{$item->ac_head->fld_ac_head}},

                                                @endforeach
                                            </td> --}}


                                            @else

                                                <td>{{$journal->records()->where('transaction_type','CR')->first()? $journal->records()->where('transaction_type','CR')->first()->ac_head->fld_ac_head:'Not Found'}} </td>
                                                {{-- <td>
                                                    @foreach ($journal->records()->where('transaction_type','DR')->get() as $item)
                                                    {{$item->ac_head->fld_ac_head}},

                                                    @endforeach
                                                </td> --}}
                                            @endif



                                            <td>
                                                @if($journal->purchaseExp!=null)
                                                By Puchase Invoice {{$journal->purchaseExp->invoice_no}} dated {{date('d-M-Y', strtotime($journal->date))}}
                                                @elseif($journal->jobProject !=null)
                                                By Project {{$journal->jobProject->project_name}}
                                                @elseif($journal->invoice )
                                                By Invoice {{$journal->invoice->invoice_no}} dated {{date('d-M-Y', strtotime($journal->date))}}

                                                @elseif($journal->receipt !=null)
                                                By Receipt {{$journal->receipt->receipt_no}} dated {{date('d-M-Y', strtotime($journal->date))}}
                                                @elseif($journal->payment !=null)
                                                By Payment {{$journal->payment->payment_no}} dated {{date('d-M-Y', strtotime($journal->date))}}
                                                @else
                                                By Journal: {{'0'.$journal->journal_no}}; dated {{date('d-M-Y', strtotime($journal->date))}}

                                                @endif

                                            </td>

                                            {{-- <td>{{$record->journal->narration}}</td> --}}
                                            {{-- <td>By  {{$record->invoice? 'Invoice No '.$record->invoice->invoice_no:($record->receipt_voucher? 'Receipt No '.$record->receipt_voucher->new_receipt_voucher_no:($record->charity? 'Charity No '.'0'.$record->charity->id:''))}}
                                                @foreach ($journal->records()->where('transaction_type','DR')->get() as $item)
                                                {{$item->ac_head->fld_ac_head}},

                                                @endforeach
                                            </td> --}}
                                            {{-- <td>{{'AUD '.$journal->total_amount}}</td> --}}
                                            @php
                                                $cr=$journal->records()->where('account_head_id','5')->where('transaction_type','CR')->sum('amount');
                                                $dr=$journal->records()->where('account_head_id','5')->where('transaction_type','DR')->sum('amount');
                                                $cr2=$journal->records()->where('account_head_id','3')->where('transaction_type','CR')->sum('amount');
                                                $dr2=$journal->records()->where('account_head_id','3')->where('transaction_type','DR')->sum('amount');
                                                // $cr3=$journal->records()->where('account_head_id','853')->where('transaction_type','CR')->sum('amount');

                                                // $dr3=$journal->records()->where('account_head_id','853')->where('transaction_type','DR')->sum('amount');
                                                $amount = $dr-$cr2+$dr2 - $cr;
                                                $tdr=$dr+$dr2;
                                                $tcr=$cr2+$cr;
                                                $balance=$balance-$cr+$dr-$cr2+$dr2;
                                            @endphp
                                            @if($tdr==0 && $tcr==0)
                                            @php
                                                $t_dr=$journal->records()->whereIn('account_head_id',[1,2])->where('transaction_type','DR')->sum('amount');
                                                $t_cr=$journal->records()->whereIn('account_head_id',[1,2])->where('transaction_type','CR')->sum('amount');
                                            @endphp
                                            <td>{{number_format($t_dr,2,'.','')}}</td>
                                            <td>{{number_format($t_cr,2,'.','')}}</td>

                                            @elseif ($amount<0)
                                                <td>0</td>
                                                <td>{{number_format($amount*(-1),2,'.','')}}</td>
                                            @else
                                                <td>{{number_format($amount,2,'.','')}}</td>
                                                <td>0</td>
                                            @endif
                                            <td>{{$balance>=0? 'DR '.number_format($balance,2,'.',''):'CR '.number_format(((-1)*$balance),2,'.','')}} </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th colspan="5" class="text-right">Total</th>
                                        <th>{{$balance>=0? 'DR '.number_format($balance,2,'.',''):'CR '.number_format(((-1)*$balance),2,'.','')}} </th>
                                    </tr>




                                    </table>
                                    <div class="divFooter mb-1 ml-1 print-header-footer " >
                                        Business Software Solutions by
                                        <span style="color: #0005" class="spanStyle"><img class="img-fluid" src="{{ asset('img/zisprink.png')}}" alt="" width="70"></span>
                                    </div>
                              </div>
                            </div>
                            @endif
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-lg" id="voucherPreviewModal" tabindex="-1" rrole="dialog"
aria-labelledby="myLargeModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div id="voucherPreviewShow">

        </div>
    </div>
</div>
</div>
@endsection
@push('js')
@endpush

@push('js')
    <script>
        $(document).on("click", ".journalDetails", function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            var v_type = $(this).attr('v-type');
            $.ajax({
                url: "{{ URL('voucher-preview-modal') }}",
                type: "post",
                cache: false,
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    v_type: v_type,
                },
                success: function(response) {
                    document.getElementById("voucherPreviewShow").innerHTML = response;
                    $('#voucherPreviewModal').modal('show')
                }
            });
        });
    </script>
@endpush


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
    @if($records!=null)
        <div class="card-body pt-0 pb-0">
            <div id="print-table">
                <span class="print-header-footer" >
                    @include('layouts.backend.partial.modal-header-info')
                </span>
                <table  class="table table-sm table-bordered table-hover">
                                        <tr>
                                            <th colspan="7" class="text-center">
                                                <h6>{{$party->pi_name}} @if(!empty($currency->licence_name)){{$currency->licence_name}} @endif-{{$party->trn_no}}</h6>
                                                <h6>Ledger</h6>

                                                <h6>{{$date!=null?date('d F Y', strtotime($date)):''}} {{$date2!=null? '-'.date('d F Y', strtotime($date2)):''}}</h6>
                                            </th>
                                        </tr>

                                        <tr class="text-center trFontSize" style="background-color:#34465b;color:white;">
                                            <th>Date</th>
                                            {{-- <th style="width: 150px">Branch</th> --}}

                                            <th style="width: 150px">Account Head</th>
                                            {{-- <th>Transection</th> --}}
                                            <th>Narration</th>
                                            <th>Debit <small>({{$currency->symbole}})</small></th>
                                            <th>Credit <small>({{$currency->symbole}})</small></th>
                                            <th>Balance <small>({{$currency->symbole}})</small></th>
                                        </tr>
                                        @php
                                        $balance=0;
                                    @endphp
                                    @if ($date != null)
                                        @php
                                        $balance=App\PartyInfo::opening($party,$date);
                                        @endphp
                                        <tr class="text-center trFontSize">
                                            <td colspan="3">Opening Balance</td>
                                            <td>{{$balance>=0? $balance:0}}</td>
                                            <td>{{$balance>=0? 0:(-1)*$balance}}</td>

                                            <td>{{$balance>=0? 'DR '.$balance:'CR '.((-1)*$balance)}} </td>
                                        </tr>
                                    @endif
                                    @foreach ($records as $record)
                                    @php
                                        $journal=App\Journal::find($record->journal_id);
                                    @endphp

                                        <tr  class="text-center trFontSize journalDetails" v-type="main" style="cursor: pointer;" id="{{ $record->journal_id }}">
                                            <td>{{date('d-M-Y', strtotime($journal->date))}}</td>
                                            {{-- <td>{{$journal->project->proj_name}}</td> --}}
                                            @if($journal->records()->whereIn('account_head_id',[1,27])->where('transaction_type','DR')->first())
                                            <td>{{$journal->records()->where('transaction_type','DR')->first()? $journal->records()->where('transaction_type','DR')->first()->ac_head->fld_ac_head:'Not Found'}} </td>

                                            {{-- <td>
                                                @foreach ($journal->records()->where('transaction_type','CR')->get() as $item)
                                                {{$item->ac_head->fld_ac_head}},

                                                @endforeach
                                            </td> --}}


                                            @else

                                                <td>{{$journal->records()->where('transaction_type','CR')->first()? $journal->records()->where('transaction_type','CR')->first()->ac_head->fld_ac_head:'Not Found'}} </td>
                                                {{-- <td>
                                                    @foreach ($journal->records()->where('transaction_type','DR')->get() as $item)
                                                    {{$item->ac_head->fld_ac_head}},

                                                    @endforeach
                                                </td> --}}
                                            @endif



                                            <td>
                                                @if($journal->purchaseExp!=null)
                                                By Puchase Invoice {{$journal->purchaseExp->invoice_no}} dated {{date('d-M-Y', strtotime($journal->date))}}
                                                @elseif($journal->jobProject !=null)
                                                By Project {{$journal->jobProject->project_name}}
                                                @elseif($journal->invoice )
                                                By Invoice {{$journal->invoice->invoice_no}} dated {{date('d-M-Y', strtotime($journal->date))}}

                                                @elseif($journal->receipt !=null)
                                                By Receipt {{$journal->receipt->receipt_no}} dated {{date('d-M-Y', strtotime($journal->date))}}
                                                @elseif($journal->payment !=null)
                                                By Payment {{$journal->payment->payment_no}} dated {{date('d-M-Y', strtotime($journal->date))}}
                                                @else
                                                By Journal: {{'0'.$journal->journal_no}}; dated {{date('d-M-Y', strtotime($journal->date))}}

                                                @endif

                                            </td>

                                            {{-- <td>{{$record->journal->narration}}</td> --}}
                                            {{-- <td>By  {{$record->invoice? 'Invoice No '.$record->invoice->invoice_no:($record->receipt_voucher? 'Receipt No '.$record->receipt_voucher->new_receipt_voucher_no:($record->charity? 'Charity No '.'0'.$record->charity->id:''))}}
                                                @foreach ($journal->records()->where('transaction_type','DR')->get() as $item)
                                                {{$item->ac_head->fld_ac_head}},

                                                @endforeach
                                            </td> --}}
                                            {{-- <td>{{'AUD '.$journal->total_amount}}</td> --}}
                                            @php
                                                $cr=$journal->records()->where('account_head_id','5')->where('transaction_type','CR')->sum('amount');
                                                $dr=$journal->records()->where('account_head_id','5')->where('transaction_type','DR')->sum('amount');
                                                $cr2=$journal->records()->where('account_head_id','3')->where('transaction_type','CR')->sum('amount');
                                                $dr2=$journal->records()->where('account_head_id','3')->where('transaction_type','DR')->sum('amount');
                                                // $cr3=$journal->records()->where('account_head_id','853')->where('transaction_type','CR')->sum('amount');

                                                // $dr3=$journal->records()->where('account_head_id','853')->where('transaction_type','DR')->sum('amount');
                                                $amount = $dr-$cr2+$dr2 - $cr;
                                                $tdr=$dr+$dr2;
                                                $tcr=$cr2+$cr;
                                                $balance=$balance-$cr+$dr-$cr2+$dr2;
                                            @endphp
                                            @if($tdr==0 && $tcr==0)
                                            @php
                                                $t_dr=$journal->records()->whereIn('account_head_id',[1,2])->where('transaction_type','DR')->sum('amount');
                                                $t_cr=$journal->records()->whereIn('account_head_id',[1,2])->where('transaction_type','CR')->sum('amount');
                                            @endphp
                                            <td>{{number_format($t_dr,2,'.','')}}</td>
                                            <td>{{number_format($t_cr,2,'.','')}}</td>

                                            @elseif ($amount<0)
                                                <td>0</td>
                                                <td>{{number_format($amount*(-1),2,'.','')}}</td>
                                            @else
                                                <td>{{number_format($amount,2,'.','')}}</td>
                                                <td>0</td>
                                            @endif
                                            <td>{{$balance>=0? 'DR '.number_format($balance,2,'.',''):'CR '.number_format(((-1)*$balance),2,'.','')}} </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th colspan="5" class="text-right">Total</th>
                                        <th>{{$balance>=0? 'DR '.number_format($balance,2,'.',''):'CR '.number_format(((-1)*$balance),2,'.','')}} </th>
                                    </tr>




                                    </table>
                <div class="divFooter mb-1 ml-1 print-header-footer " >
                    Business Software Solutions by
                    <span style="color: #0005" class="spanStyle"><img class="img-fluid" src="{{ asset('img/zisprink.png')}}" alt="" width="70"></span>
                </div>
            </div>
        </div>
    @endif
    {{-- @include('layouts.backend.partial.modal-footer-info') --}}
</section>
