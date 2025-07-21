

@extends('layouts.backend.app')
@section('content')
@include('layouts.backend.partial.style')
@php
      use Illuminate\Support\Carbon;
@endphp
<style>

    .commonSelect2Style span{
        width: 100% !important;
    }
    .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b{
        display: none;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b{
        display: none;
    }
    .font-size{
        font-size: 16px !important;
        font-weight: 600;
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
    @media print{
        .collapsed{
            display: none;
        }
    }
    @media print{
        .text-success{
            color: black !important;
        }
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
                                            <div class="row" id="table-bordered">
                                                <div class="col-12">
                                                    <div class="card cardStyleChange">
                                                        <section id="widgets-Statistics">
                                                            <div class="conpany-header">
                                                                @include('layouts.backend.partial.modal-header-info')
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12 text-center">
                                                                    <h4> Stock Report</h4>
                                                                    {{-- <h5>{{ date('d/m/Y', strtotime($from))}}  @if (!empty($from)) To {{date('d/m/Y', strtotime($to))}}  @endif</h5> --}}
                                                                </div>
                                                            </div>

                                                            <div class="row pt-2">
                                                                <div class="col-md-4 print-hidden float-right">
                                                                    {{-- <div class="mt-2 row">

                                                                        <form action="" method="GET" class=" row col-8">
                                                                            <div class="col-3">
                                                                                <label for="">Single/From</label>
                                                                                <input type="text" class="inputFieldHeight form-control" autocomplete="off" name="from" placeholder="From Date" id="from">
                                                                            </div>
                                                                            <div class="col-3">
                                                                                <label for="">To</label>
                                                                                <input type="text" class="inputFieldHeight form-control" autocomplete="off" name="to" placeholder="To Date" id="to">
                                                                            </div>


                                                                            <div class="col-md-2  " style="margin-top: 20px;">
                                                                                <button type="submit" class="btn mSearchingBotton mb-2 formButton" title="Search">
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
                                                                    </div> --}}
                                                                     </div>
                                                                    {{-- <i id="url">
                                                                        <a href="{{ route('printStockPosition') }}" class="btn btn-sm btn-info float-right"
                                                                    target="_blank">Print</a>
                                                                    </i> --}}
                                                                    <button class="btn  btn-info btn-sm float-right ml-1 mb-1 mr-1 print-hidden" onclick="exportTableToCSV('stockPosition-{{ date('d M Y') }}.csv')">Export To CSV</button>

                                                                    <button type="button" class="btn mPrint formButton  float-right  mb-1 mr-1 print-hidden" title="Print" onclick="handlePrintClick('stock-report')">
                                                                        <div class="d-flex">
                                                                            <div class="formSaveIcon">
                                                                                <img src="{{asset('assets/backend/app-assets/icon/print-icon.png')}}" width="25">
                                                                            </div>
                                                                            <div><span>Print</span></div>
                                                                        </div>
                                                                    </button>
                                                                </div>
                                                                <div class="table-responsive" id="stock-report">
                                                                    <h4 class="text-center mb-2 print-show " style="display: none"> Stock Report</h4>

                                                                    <table class="table table-bordered table-sm" style="width: 80%">
                                                                       <tr style="height: 30px; text-align:center">
                                                                        <th>Item Name</th>
                                                                            <th>Qty</th>
                                                                            <th>Value</th>

                                                                       </tr>
                                                                       @php
                                                                           $total = 0;
                                                                       @endphp
                                                                       <tbody class="user-table-body">
                                                                            @foreach ($Stock as $item)
                                                                                <tr  style="height: 30px; text-align:center">
                                                                                    <td style="width: 23%" class="text-left">
                                                                                        <a href="{{route('product-purchase-sale-report',$item->id)}}" target="blank">{{ $item->product? $item->product->name:'' }}</a>
                                                                                    </td>
                                                                                    <td>{{$item->pcs}} </td>
                                                                                    <td>{{$item->pcs*$item->avg_unit_price}}</td>
                                                                                    @php
                                                                                        $total = $total + ($item->pcs*$item->avg_unit_price)
                                                                                    @endphp

                                                                                </tr>
                                                                            @endforeach
                                                                            <tr>

                                                                                <td colspan="2" class="text-right pr-1">Total </td>
                                                                                <td  style="height: 30px; text-align:center">{{$total}}</td>

                                                                            </tr>
                                                                       </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="conpany-header">
                                                                @include('layouts.backend.partial.modal-footer-info')
                                                            </div>

                                                        </section>
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
    </div>
</div>

@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            $(document).on("change", "#search", function(e) {
                if ($(this).val() != '') {

                var item = $(this).val();
                // alert(category);

                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('item.fetch') }}",
                    method: "POST",
                    data: {
                        item: item,
                        _token: _token,
                    },
                    success: function(response) {
                        $(".user-table-body").empty().append(response.page);
                        $("#url").empty().append(response.url);
                        $("#sub_brand2").empty();
                    }

                })
            }
            });

            $(document).on("change", "#category", function(e) {
                if ($(this).val() != '') {

                var category = $(this).val();
                // alert(category);

                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('categoryProduct.fetch') }}",
                    method: "POST",
                    data: {
                        category: category,
                        _token: _token,
                    },
                    success: function(response) {
                        $(".user-table-body").empty().append(response.page);
                        $("#url").empty().append(response.url);
                        $("#sub_brand2").empty();
                    }

                })
            }
            });
        });
    </script>
