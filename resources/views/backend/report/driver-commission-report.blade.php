
@extends('layouts.backend.app')
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
</style>

<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @include('clientReport.daily-report._header')
            <div class="tab-content bg-white">
                <div class="tab-pane active">
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="cardStyleChange p-1">
                                <div class="row" id="table-bordered">
                                    <div class="col-12">
                                        <div class="card cardStyleChange">
                                            <div class="conpany-header">
                                                @include('layouts.backend.partial.modal-header-info')
                                            </div>
                                            <div class="card-body print-hidden">
                                                <div class="d-flex mt-2">
                                                    <h4 class="card-title flex-grow-1">Driver Commission Reports:
                                                        @if ($driver_info)
                                                            {{$driver_info->full_name}}
                                                        @endif
                                                        @if ($from && $to)
                                                        {{date('d/m/Y', strtotime($from))}} to {{date('d/m/Y', strtotime($to))}}
                                                        @endif
                                                    </h4>
                                                </div>
                                                <div>
                                                    <form action="" method="GET" class="row">
                                                        <div class="col-2">
                                                            <label for="">From</label>
                                                            <input type="text" class="inputFieldHeight form-control" name="from" placeholder="From" id="from">
                                                        </div>
                                                        <div class="col-2">
                                                            <label for="">To</label>
                                                            <input type="text" class="inputFieldHeight form-control" name="to" placeholder="To" id="to">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="">Driver Name</label>
                                                            <select name="driver_id" class="form-control inputFieldHeight common-select2">
                                                                <option value="">Select...</option>
                                                                @foreach ($drivers as $item)
                                                                    <option value="{{$item->id}}">{{$item->full_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-2 text-right mt-2">
                                                            <button type="submit" class="btn mSearchingBotton formButton" title="Search">
                                                                <div class="d-flex">
                                                                    <div class="formSaveIcon">
                                                                        <img src="{{asset('assets/backend/app-assets/icon/searching-icon.png')}}" width="25">
                                                                    </div>
                                                                    <div><span>Search</span></div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                        <div class="col-md-2 text-right mt-2">
                                                            <button type="button" class="btn mPrint formButton" title="Print" onclick="handlePrintClick('daylireport')">
                                                                <div class="d-flex">
                                                                    <div class="formSaveIcon">
                                                                        <img src="{{asset('assets/backend/app-assets/icon/print-icon.png')}}" width="25">
                                                                    </div>
                                                                    <div><span>Print</span></div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div id="daylireport">
                                                <h4 class=" print-show mt-2 mb-2 text-center" style="display: none">Driver Commission Reports:
                                                    @if ($driver_info)
                                                        {{$driver_info->full_name}}
                                                    @endif
                                                   @if ($from && $to)
                                                    {{date('d/m/Y', strtotime($from))}} to {{date('d/m/Y', strtotime($to))}}
                                                    @endif
                                                </h4>

                                                <div class="card-body col-md-8">

                                                    <div class="table-responsive" style="min-height: 400px;">
                                                        <table class="table mb-0 table-sm accordion">
                                                            <thead class="">
                                                                <tr style="height: 50px;">
                                                                    <th class="font-size">Driver Name</th>
                                                                    <th class="font-size text-right pr-1 ">Total Commission</th>
                                                                </tr>
                                                            </thead>
                                                            @foreach ($driver_info?$drivers->where('id', $driver_info->id):$drivers as $item)
                                                                <tr id="{{$item->id}}" class="details" style="cursor: pointer">
                                                                    <td>{{$item->full_name}}</td>
                                                                    <td class="text-right pr-1">{{number_format($item->commission($item->id, $from, $to),2)}}</td>
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="conpany-header print-none">
                                                @include('layouts.backend.partial.modal-footer-info')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="voucherPreviewModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div id="voucherPreviewShow">

            </div>
        </div>
    </div>
</div>
<input type="hidden" name="from_date" id="from_date" value="{{$from}}">
<input type="hidden" name="to_date" id="to_date" value="{{$to}}">
@endsection

@push('js')
<script>
    $(document).on("click", ".details", function(e) {
        e.preventDefault();
        var id = $(this).attr('id');
        var from = $('#from_date').val();
        var to = $('#to_date').val();
        $.ajax({
            url: "{{ route('driver-detail-view') }}",
            type: "post",
            cache: false,
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                from: from,
                to: to,
            },
            success: function(response) {
                document.getElementById("voucherPreviewShow").innerHTML = response;
                $('#voucherPreviewModal').modal('show')
            }
        });
    });
    function total(){
        let total_amount = 0;
        $('.t-row').each(function () {
            let $row = $(this);
            let amount = $row.find('.r-rate').val();
            console.log(amount);
            total_amount += Number(amount);
        });
        $('#total_driver_amount').text(total_amount);
    }
    $(document).on('input', '.r-rate', function () {
        let $currentRow = $(this).closest('tr');
        let crusher = $currentRow.find('.crusher').text();
        let destination = $currentRow.find('.r-destination').text();
        let newRate = parseFloat($(this).val());
        $('.t-row').each(function () {
            let tr = $(this).closest('.t-row');
            let $row = $(this);
            let rowCrusher = $row.find('.crusher').text();
            let rowDestination = $row.find('.r-destination').text();
            if (crusher === rowCrusher && destination === rowDestination) {
                $row.find('.r-rate').val(newRate);
            }
        });
        total();
    });
</script>
@endpush
