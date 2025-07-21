

@extends('layouts.backend.app')
@section('content')
@include('layouts.backend.partial.style')
<style>
    .print-show{
        display: none;
    }
    @media print{
        .master-tab-section{
            display: none !important;
        }
        .print-show{
            display: block !important;
        }
        .nav.nav-tabs ~ .tab-content {
            border-left: 1px #ffffff;
            border-right: 1px #ffffff;
            border-bottom: 1px #ffffff;
            padding-left: 0;
        }
    }
</style>
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @include('clientReport.daily-report._header')
            <div class="tab-content bg-white">
                <div class="tab-pane active">
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="cardStyleChange p-1">
                           <!-- Bordered table start -->
                            <div class="row" id="table-bordered">
                                <div class="col-12">
                                    <div class="card cardStyleChange">
                                        {{-- <div class="conpany-header">
                                            @include('layouts.backend.partial.modal-header-info')
                                        </div> --}}
                                        <div class="card-body print-hidden">
                                            <div class="d-flex mt-2">
                                                <h4 class="card-title flex-grow-1">Route Wise Report:
                                                    @if ($from && $to)
                                                        {{" From ".date('d-m-Y', strtotime($from))." To ". date('d-m-Y', strtotime($to)) }}
                                                    @endif
                                                    @if($date)
                                                        {{ date('d-m-Y', strtotime($date)) }}
                                                    @endif
                                                </h4>
                                                {{-- <div>
                                                    <button type="button" class="btn mExcelButton formButton mr-1" title="Export" onclick="exportTableToCSV('general-ledger-29 Jan 2023.csv')">
                                                        <div class="d-flex">
                                                            <div class="formSaveIcon">
                                                                <img src="{{asset('assets/backend/app-assets/icon/excel-icon.png')}}" width="25">
                                                            </div>
                                                            <div><span>Export To CSV</span></div>
                                                        </div>
                                                    </button>
                                                    <a href="#" class="btn btn_create mPrint formButton" title="Print" onclick="window.print()">
                                                        <div class="d-flex">
                                                            <div class="formSaveIcon">
                                                                <img src="{{asset('assets/backend/app-assets/icon/print-icon.png')}}" width="25">
                                                            </div>
                                                            <div><span>Print</span></div>
                                                        </div>
                                                    </a>
                                                </div> --}}
                                            </div>
                                            <div class="mt-2">
                                                <form action="" method="GET" class="row pl-1">
                                                    <div class="form-group col-md-1" style="padding: 0;">
                                                        <label for="">Date</label>
                                                        <input type="text" class="inputFieldHeight form-control" name="date" placeholder="Select Date" id="date">
                                                    </div>
                                                    <div class="col-md-1" style="padding: 0;">
                                                        <label for="">From</label>
                                                        <input type="text" class="inputFieldHeight form-control" name="from" placeholder="From" id="from">
                                                    </div>
                                                    <div class="col-md-1" style="padding: 0;">
                                                        <label for="">To</label>
                                                        <input type="text" class="inputFieldHeight form-control" name="to" placeholder="To" id="to">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="">Customer Name</label>
                                                        <select name="customer_id" class="form-control inputFieldHeight common-select2">
                                                            <option value="">Select...</option>
                                                            @foreach ($customers as $item)
                                                                <option value="{{$item->id}}">{{$item->pi_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="">From</label>
                                                        <select name="crusher_name" class="form-control inputFieldHeight common-select2">
                                                            <option value="">Select...</option>
                                                            @foreach ($crusher as $item)
                                                                <option value="{{$item->name}}">{{$item->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="">To</label>
                                                        <select name="destination_name" class="form-control inputFieldHeight common-select2">
                                                            <option value="">Select...</option>
                                                            @foreach ($destination as $item)
                                                                <option value="{{$item->name}}">{{$item->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 row" style="padding-right: 0;">
                                                        <div class="col-md-6 text-right mt-2">
                                                            <button type="submit" class="btn mSearchingBotton mb-2 formButton" title="Search">
                                                                <div class="d-flex">
                                                                    <div class="formSaveIcon">
                                                                        <img src="{{asset('assets/backend/app-assets/icon/searching-icon.png')}}" width="25">
                                                                    </div>
                                                                    <div><span>Search</span></div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                        <div class="col-md-6 text-right mt-2">
                                                            <button type="button" class="btn mPrint formButton" title="Print" onclick="window.print()">
                                                                <div class="d-flex">
                                                                    <div class="formSaveIcon">
                                                                        <img src="{{asset('assets/backend/app-assets/icon/print-icon.png')}}" width="25">
                                                                    </div>
                                                                    <div><span>Print</span></div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    
                                                </form>
                                            </div>
                                        </div>
                                        <div class="card-body" id="cusher-destination">
                                            <h4 class="card-title flex-grow-1 print-show text-center">Route Wise Report:
                                                @if ($from && $to)
                                                    {{" From ".date('d-m-Y', strtotime($from))." To ". date('d-m-Y', strtotime($to)) }}
                                                @endif
                                                @if($date)
                                                    {{ date('d-m-Y', strtotime($date)) }}
                                                @endif
                                            </h4>
                                            <div class="table-responsive">
                                                <table class="table mb-0 table-sm table-bordered">
                                                    <thead  class="thead-light">
                                                        <tr style="height: 50px;">
                                                            <th>SL No</th>
                                                            <th>From</th>
                                                            <th>To</th>
                                                            <th>Date</th>
                                                            <th class="text-right pr-1">Rate</th>
                                                            <th class="text-right pr-1">Weight</th>
                                                            <th class="text-right pr-1">Total Amount</th>
                                                        </tr>
                                                    </thead>
                                                    @php
                                                        $taxable_amount=0;
                                                        $vat=0;
                                                        $total_amount=0;
                                                        $toll_fees = 0;
                                                        $total_qty = 0;
                                                    @endphp
                                                    <tbody>
                                                        @foreach ($invoice_items as $key => $item)
                                                        @php
                                                            $total_amount += $item->rate * $item->total_qty;
                                                            $total_qty += $item->total_qty;
                                                        @endphp
                                                        <tr>
                                                            <td>{{$key+1}}</td>
                                                            <td class="description">{{$item->crusher}}</td>
                                                            <td class="description">{{$item->destination}}</td>
                                                            <td class="description">{{date('d-m-Y', strtotime($item->record_date))}}</td>
                                                            <td class="text-right pr-1">{{$item->rate}}</td>
                                                            <td class="text-right pr-1">{{$item->total_qty}}</td>
                                                            <td class="text-right pr-1">{{$item->rate * $item->total_qty}}</td>
                                                        </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td colspan="5" class="text-right pr-2">Total: </td>
                                                            <td class="text-right pr-1">{{$total_qty}}</td>
                                                            <td class="text-right pr-1">{{number_format($total_amount,2)}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="conpany-header">
                                            @include('layouts.backend.partial.modal-footer-info')
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- Bordered table end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>

</script>
