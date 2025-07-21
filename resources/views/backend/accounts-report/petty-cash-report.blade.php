
@extends('layouts.backend.app')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@section('content')
    @include('layouts.backend.partial.style')
    <style>
        .changeColStyle span {
            min-width: 16%;
        }

        .changeColStyle .select2-container--default .select2-selection--single .select2-selection__arrow b {
            display: none;
        }

        .journaCreation {
            background: #1214161c;
        }

        .transaction_type {
            padding-right: 5px;
            padding-left: 5px;
            padding-bottom: 5px;
        }

        @media only screen and (max-width: 1500px) {
            .custome-project span {
                max-width: 140px;
            }
        }

        thead {
            background: #34465b;
            color: #fff !important;
        }

        th {
            color: #fff !important;
            font-size: 11px !important;
            height: 25px !important;
            text-align: center !important;
        }

        td {
            font-size: 12px !important;
            height: 25px !important;
            text-align: center !important;

        }

        .table-sm th,
        .table-sm td {
            padding: 0rem;
        }

        tr:nth-child(even) {
            background-color: #c8d6e357;
        }

        tr {
            cursor: pointer;
        }
        #widgets-Statistics{
            border-left: 1px solid black;
            border-right: 1px solid black;
            border-bottom: 1px solid black;
        }
        .print-layout {
            display: none;
        }

        @media print{
            #widgets-Statistics{
                border:none;
            }
            .print-layout {
                display: block;
                overflow: hidden;
            }
            tr th{
                color: rgba(0, 0, 0, 0.774) !important;
            }
        }
        .bg-danger {
            background-color: #ff5b5c9e !important;
        }
    </style>
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="print-hideen">
                    @include('clientReport.report._header',['activeMenu' => 'petty-cash'])
                </div>
                <div class="tab-content journaCreation">
                    <div id="journaCreation" class="tab-pane bg-white active">
                        <section id="widgets-Statistics">

                            <div class="row ">

                                <div class="col-md-12 px-2">
                                    <div class="print-layout">
                                        {{-- @include('layouts.backend.partial.modal-header-info') --}}
                                        <h4 class="text-center">Petty Cash Reports</h4>
                                    </div>
                                    <div class="cardStyleChange" style="width: 100%">
                                        <div class="card-body bg-white">
                                            <form action="">
                                                <div class="row mt-1 print-hideen">
                                                    <div class="col-2">
                                                        <input type="text" name="date_from" id="date_from"
                                                            class="form-control inputFieldHeight datepicker by_date_search"
                                                            placeholder="Search by Date From">
                                                    </div>
                                                    <div class="col-2">
                                                        <input type="text" name="date_to" id="date_to"
                                                            class="form-control inputFieldHeight datepicker by_date_search"
                                                            placeholder="Search by Date To">
                                                    </div>
                                                    <div class="col-sm-1 text-right d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-dark formButton " id="submitButton">
                                                            <div class="d-flex">
                                                                <div class="formSaveIcon">
                                                                    <img  src="{{asset('assets/backend/app-assets/icon/search-icon.png')}}" alt="" srcset=""  width="25">
                                                                </div>
                                                                <div><span>Search</span></div>
                                                            </div>
                                                        </button>
                                                    </div>
                                                    <div class="col-7 d-flex justify-content-end">
                                                        <a href="#" class="btn btn_create mPrint formButton float-right" title="Print" onclick="window.print()">
                                                            <div class="d-flex">
                                                                <div class="formSaveIcon">
                                                                    <img src="{{ asset('assets/backend/app-assets/icon/print-icon.png') }}" width="25">
                                                                </div>
                                                                <div><span>Print</span></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </form>

                                            <table class="table table-bordered table-sm ">
                                                <thead class="thead">
                                                    <tr>
                                                        <th style="width: 13%">Date</th>
                                                        <th style="width: 13%">Bill/Transection</th>
                                                        <th style="width: 13%">Cash In</th>
                                                        <th style="width: 13%">Cash Out</th>
                                                        <th style="width: 13%">Balance</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="purch-body">
                                                    @php
                                                        $t_balance=0;
                                                        $cash_in = 0;
                                                        $cash_out = 0;
                                                    @endphp
                                                    @if($from)
                                                    <tr class="text-center trFontSize journalDetails"
                                                                    style="cursor: pointer;">
                                                                    <td>{{ date('d/m/Y',strtotime($from)) }}
                                                                    </td>
                                                                    <td>
                                                                        Opening Balance
                                                                    </td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td>

                                                                        {{$dr_amount =$unique_acc_head->headOpeningBalance($unique_acc_head->ac_head->id,$from)}}
                                                                    </td>

                                                                </tr>


                                                    @endif
                                                    @foreach ($petty_cashs as $item)
                                                    @php
                                                    $detail_record = $item->journal->journal_description($item->journal_id);
                                                @endphp
                                                        <tr>
                                                            <td>{{date('d/m/Y', strtotime($item->journal_date))}}</td>
                                                            <td>  {{ isset($detail_record['name']) ? $detail_record['name'] : 'N/A' }}</td>
                                                            <td> {{ $dr_amount = $item->transaction_type == 'DR' ? $item->amount : 0 }}</td>
                                                            <td> {{ $cr_amount = $item->transaction_type == 'CR' ? $item->amount : 0 }}</td>
                                                            <td>
                                                                {{number_format(($t_balance=$t_balance+$dr_amount-$cr_amount),2,'.','') }}
                                                            </td>
                                                        </tr>
                                                    </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
    {{-- modal --}}
    <!-- END: Content-->
    <div class="modal fade bd-example-modal-lg" id="voucherPreviewModal" tabindex="-1" rrole="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div id="voucherPreviewShow">

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="voucherDetailsPrintModal" tabindex="-1" rrole="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div id="voucherDetailsPrint">

                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    <script src="{{ asset('assets/backend') }}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="{{ asset('assets/backend') }}/app-assets/js/scripts/forms/select/form-select2.js"></script>
    <script src="{{ asset('assets/backend') }}/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
    <script src="{{ asset('assets/backend') }}/app-assets/js/scripts/forms/form-repeater.js"></script>
    {{-- js work by mominul start --}}

    <script>

    </script>
@endpush
