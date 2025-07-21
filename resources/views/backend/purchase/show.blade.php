@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@endpush
@section('content')
    @include('layouts.backend.partial.style')
    <style>
        .accordion .pluseMinuseIcon.collapsed::before {
            content: "\f067";
            ;
            cursor: pointer;
            border: 1px solid rgb(123, 123, 123);
        }

        .accordion .pluseMinuseIcon::before {
            font-family: 'FontAwesome';
            content: "\f068";
            cursor: pointer;
            border: 1px solid rgb(123, 123, 123);
        }

        .rowStyle {
            cursor: pointer;
            border-left: dotted;
            padding: 3px;
            margin-bottom: 2px;
        }

        .findMasterAcc {
            cursor: pointer;
        }

        .card {
            margin-bottom: 0px !important;
            box-shadow: -8px 12px 18px 0 rgb(25 42 70 / 13%);
            transition: all .3s ease-in-out, background 0s, color 0s, border-color 0s;
        }

        tr,
        td {
            text-align: center;
        }

        @media print {

            html,
            body {
                height: 99%;
            }
        }
    </style>
    @php
        $company_logo = \App\Setting::where('config_name', 'company_logo')->first();

    @endphp
    <div class="app-content content print-hideen">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
                    <a href="{{route('purchase.index')}}" class="nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false">
                        <div class="master-icon text-cente">
                            <img src="{{asset('assets/backend/app-assets/icon/list-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                        </div>
                        <div>Purchase List</div>
                    </a>
                    <a href="{{route('purchase.create')}}" class="nav-item nav-link " role="tab" aria-controls="nav-contact" aria-selected="false">
                        <div class="master-icon text-cente">
                            <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                        </div>
                        <div>Generate Purchase</div>
                    </a>
                </div>
                <div class="tab-content bg-white">
                    <div id="masterAccount" class="tab-pane active">
                        <section id="widgets-Statistics" class="mr-1 ml-1 mb-1">
                            <div class="row">
                                <div class="col-md-6  mt-2">
                                    <h4>BOQ</h4>
                                </div>
                                <div class="col-md-6 text-right mt-2">
                                    <a href="#" onclick="partyListPrint()" class="btn btn-xs mPrint formButton"
                                        title="Print"><img
                                            src="{{ asset('assets/backend/app-assets/icon/print-icon.png') }}"
                                            alt="" srcset="" class="img-fluid" width="30"> Print</a>

                                </div>
                            </div>

                        </section>
                        <hr style="margin:0px !important">

                        <div class="row" style="margin:10px 0px">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-7 pb-1">
                                        <div class="row">
                                            <div class="col-3">
                                                <strong>Customer Name</strong>
                                            </div>
                                            <div class="col-9">
                                                : {{ $purchase->customerInfo->pi_name }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 pb-1">
                                        <div class="row">
                                            <div class="col-6">
                                                <strong>BOQ Number</strong>
                                            </div>
                                            <div class="col-6" style="padding-left: 0px !important">
                                                : {{ $purchase->number }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 pb-1">
                                        <div class="row">
                                            <div class="col-3">
                                                <strong>Date</strong>
                                            </div>
                                            <div class="col-9">
                                                : {{ $purchase->date }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 pb-1">
                                        <div class="row">
                                            <div class="col-3">
                                                <strong>TRN</strong>
                                            </div>
                                            <div class="col-9">
                                                : {{ $purchase->customerInfo->trn_no }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 pb-1">
                                        <div class="row">
                                            <div class="col-3">
                                                <strong>Contact</strong>
                                            </div>
                                            <div class="col-9">
                                                : {{ $purchase->customerInfo->con_no }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 pb-1">
                                        <div class="row">
                                            <div class="col-2">
                                                <strong>Address</strong>
                                            </div>
                                            <div class="col-10">
                                                : {{ $purchase->customerInfo->address }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 pb-1">
                                        <div class="row">
                                            <div class="col-3">
                                                <strong>Barnch</strong>
                                            </div>
                                            <div class="col-9">
                                                : {{ $purchase->branch->proj_name }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                            <th>Rate</th>
                                            <th>Total AMount</th>
                                        </tr>

                                        @foreach ($purchase->items as $item)
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $item->unit }}</td>
                                                <td>{{ $item->rate }}</td>
                                                <td>{{ $item->total_amount }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td style="border:none" colspan="2"></td>
                                            <td colspan="2"><strong>Taxable Amount</strong></td>
                                            <td>{{ $purchase->total_cost }}</td>
                                        </tr>
                                        {{-- <tr>
                                            <td style="border:none" colspan="3"></td>
                                            <td colspan="2"><strong>Vat</strong> <small>(5%)</small></td>
                                            <td>{{ $purchase->vat }}</td>
                                        </tr> --}}
                                        {{-- <tr>
                                            <td style="border:none" colspan="3"></td>
                                            <td colspan="2"><strong>Total Amount</strong></td>
                                            <td>{{ $purchase->total_cost }}</td>
                                        </tr> --}}
                                    </table>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
        function partyListPrint() {
            // document.getElementById("mPrintHidden").style.display = "block";
            window.print();
        }
        $(document).ready(function() {
            $('#category').change(function() {
                // alert(1);
                if ($(this).val() != '') {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url: "{{ route('findMastedCode') }}",
                        method: "POST",
                        data: {
                            value: value,
                            _token: _token,
                        },
                        success: function(response) {
                            $("#mst_ac_code").val(response);
                        }

                    })
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var delay = (function() {
                var timer = 0;
                return function(callback, ms) {
                    clearTimeout(timer);
                    timer = setTimeout(callback, ms);
                };
            })();

            $(document).on("click", ".findMasterAcc", function(e) {
                e.preventDefault();
                var that = $(this);

                var urls = that.attr("data-target");
                delay(function() {
                    $.ajax({
                        url: urls,
                        type: 'GET',
                        cache: false,
                        dataType: 'json',
                        success: function(response) {
                            //   alert('ok');
                            // console.log(response);
                            $(".pagination").remove();
                            $(".user-table-body").empty().append(response.page);
                        },
                        error: function() {
                            //   alert('no');
                        }
                    });
                }, 999);
            });
            $(document).on("click", ".editAccHead", function(e) {
                e.preventDefault();
                var that = $(this);

                var urls = that.attr("data-target");
                delay(function() {
                    $.ajax({
                        url: urls,
                        type: 'GET',
                        cache: false,
                        dataType: 'json',
                        success: function(response) {
                            //   alert('ok');
                            // console.log(response);
                            $(".pagination").remove();
                            $(".user-table-body").empty().append(response.page);
                        },
                        error: function() {
                            //   alert('no');
                        }
                    });
                }, 999);
            });


        });
    </script>
@endpush

<style>
    <style>#customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #customers td,
    #customers th {
        border-bottom: 1px solid #ddd;
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
        }
    }

    @media print {

        html,
        body {
            height: 100vh;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden;
        }

    }
</style>
<section class="print-layout" id="mPrintHidden">

    @include('layouts.backend.partial.modal-header-info')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-12 mt-1 mb-2">
                            <h4>BOQ</h4>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-7 pb-1">
                                    <div class="row">
                                        <div class="col-4">
                                            <strong>Customer Name</strong>
                                        </div>
                                        <div class="col-8">
                                            : {{ $purchase->customerInfo->pi_name }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 pb-1">
                                    <div class="row">
                                        <div class="col-6">
                                            <strong>Purchase Number</strong>
                                        </div>
                                        <div class="col-6" style="padding-left: 0px !important">
                                            : {{ $purchase->number }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 pb-1">
                                    <div class="row">
                                        <div class="col-3">
                                            <strong>Date</strong>
                                        </div>
                                        <div class="col-9">
                                            : {{ $purchase->date }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 pb-1">
                                    <div class="row">
                                        <div class="col-3">
                                            <strong>TRN</strong>
                                        </div>
                                        <div class="col-9">
                                            : {{ $purchase->customerInfo->trn_no }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 pb-1">
                                    <div class="row">
                                        <div class="col-3">
                                            <strong>Contact</strong>
                                        </div>
                                        <div class="col-9">
                                            : {{ $purchase->customerInfo->con_no }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pb-1">
                                    <div class="row">
                                        <div class="col-2">
                                            <strong>Address</strong>
                                        </div>
                                        <div class="col-10">
                                            : {{ $purchase->customerInfo->address }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pb-1">
                                    <div class="row">
                                        <div class="col-3">
                                            <strong>Barnch</strong>
                                        </div>
                                        <div class="col-9">
                                            : {{ $purchase->branch->proj_name }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row ">
                        <table id="customers" class="table-sm w-100">
                            <tr>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Rate</th>
                                <th>Total AMount</th>
                            </tr>

                            @foreach ($purchase->items as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->unit }}</td>
                                    <td>{{ $item->rate }}</td>
                                    <td>{{ $item->total_amount }}</td>
                                </tr>
                            @endforeach
                            {{-- <tr>
                                <td style="border:none" colspan="3"></td>
                                <td colspan="2"><strong>Taxable Amountt</strong></td>
                                <td>{{ $purchase->taxable_amount }}</td>
                            </tr>
                            <tr>
                                <td style="border:none" colspan="3"></td>
                                <td colspan="2"><strong>Vat</strong> <small>(5%)</small></td>
                                <td>{{ $purchase->vat }}</td>
                            </tr> --}}
                            <tr>
                                <td style="border:none" colspan="2"></td>
                                <td colspan="2"><strong>Total Amount</strong></td>
                                <td>{{ $purchase->total_cost }}</td>
                            </tr>


                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>



    @include('layouts.backend.partial.modal-footer-info')
</section>
