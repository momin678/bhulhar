
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
    </style>
    <div class="app-content content print-hideen">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                @include('clientReport.accounting._header', ['activeMenu' => 'expense'])
                <div class="tab-content journaCreation">
                    <div id="journaCreation" class="tab-pane bg-white active">
                        <div class="py-1 px-1">
                            @include('clientReport.purchase.purchase-bill', [
                                'activeMenu' => 'list',
                                ])
                        </div>
                        <section id="widgets-Statistics">
                            <div class="row ">
                                <div class="col-md-12 px-2">
                                    <div class="cardStyleChange" style="width: 100%">
                                        <div class="card-body bg-white">

                                            <div class="mb-2" id="Group-wise-Bill-List">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <h3 class="text-center h4  header-title"> Date and Supplier Group-wise Bill List</h3>
                                                    </div>
                                                    <div class="col-md-3 text-right  col-right-padding print-none pb-1">

                                                        <button type="button" class="btn btn-info  formButton" onclick="handlePrintClick('Group-wise-Bill-List')" title="Search">
                                                            <div class="d-flex">
                                                                <div class="formSaveIcon">
                                                                    <img src="{{asset('assets/backend/app-assets/icon/print-icon.png')}}" width="25">
                                                                </div>
                                                                <div><span>Print</span></div>
                                                            </div>
                                                        </button>
                                                        <a href="#" class="btn btn-xs mExcelButton  formButton" id="exportButton" title="Export to Excel">
                                                            <img src="{{asset('assets/backend/app-assets/icon/excel-icon.png')}}" class="img-fluid" width="20">
                                                            Excel
                                                        </a>
                                                    </div>
                                                 </div>
                                                <table class="table table-bordered table-sm ">
                                                    <thead class="thead">
                                                        <tr>
                                                            <th style="min-width:80px;">Date</th>
                                                            <th style="min-width: 140px;"> Supplier Name </th>
                                                            <th style="min-width:100px;"> Bill No</th>
                                                            <th style="min-width: 140px;"> Account Head </th>
                                                            <th style="min-width:100px;">Taxable<small>(@if(!empty($currency->symbole)){{$currency->symbole}}@endif)</small></th>
                                                            <th style="min-width:100px;">VAT <small>(@if(!empty($currency->symbole)){{$currency->symbole}}@endif)</small></th>

                                                            <th style="min-width:100px;">Amount <small>(@if(!empty($currency->symbole)){{$currency->symbole}}@endif)</small></th>
                                                        </tr>
                                                    </thead>

                                                    <tbody id="purch-body">
                                                        @foreach ($excel_expenses as $list)
                                                            <tr class="text-center border-bottom">
                                                                <td>{{ date('d/m/Y', strtotime($list->date)) }}</td>
                                                                <td>{{$list->party->pi_name ?? 'N/A'}}</td>
                                                                <td>{{$list->invoice_no ?? 'N/A'}}</td>
                                                                <td>
                                                                    @foreach ($list->items as $item)
                                                                        {{$item->head->fld_ac_head??''}}
                                                                    @endforeach
                                                                </td>
                                                                <td>{{$list->amount??0.00}}</td>
                                                                <td>{{$list->vat??0.00}}</td>
                                                                <td>{{$list->total_amount??0.00}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

    {{-- js work by mominul start --}}

    <script>
       $(document).ready(function(){
            document.getElementById('exportButton').addEventListener('click', function() {
                var table = document.querySelector('.table');
                var wb = XLSX.utils.table_to_book(table, {sheet:"Sheet1"});
                XLSX.writeFile(wb, "ExportedData.xlsx");
            });
            var total_amount = 0;
            var total_taxable=0;
            var total_vat=0;

            $('.item_taxable').each(function(){
                total_taxable += parseFloat($(this).html()) || 0;
            });
            $('.total_taxable').html(total_taxable.toFixed(2));

            $('.item_vat').each(function(){
                total_vat += parseFloat($(this).html()) || 0;
            });
            $('.total_vat').html(total_vat.toFixed(2));

            $('.total_amount').each(function(){
                total_amount += parseFloat($(this).html()) || 0;
            });
            $('.total_show').html(total_amount.toFixed(2));
        });
        $(document).on("click", ".purch_exp_view", function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            $.ajax({
                url: "{{ URL('purch-exp-modal') }}",
                type: "post",
                cache: false,
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                },
                success: function(response) {
                    document.getElementById("voucherPreviewShow").innerHTML = response;
                    $('#voucherPreviewModal').modal('show')
                }
            });
        });


        $('#search').keyup(function() {
            if ($(this).val() != '') {
                var value = $(this).val();
                var party = $('#party_search').val();
                var date = $('#date_search').val();

                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('search-purchase-expense') }}",
                    method: "POST",
                    data: {
                        value: value,
                        party: party,
                        date:date,
                        _token: _token,
                    },
                    success: function(response) {

                        $("#purch-body").empty().append(response);
                    }
                })
            }
        });

        $('#party_search').change(function() {
            if ($(this).val() != '') {
                var party = $(this).val();
                var value = $('#search').val();
                var date = $('#date_search').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('search-purchase-expense') }}",
                    method: "POST",
                    data: {
                        value: value,
                        party: party,
                        date:date,
                        _token: _token,
                    },
                    success: function(response) {

                        $("#purch-body").empty().append(response);
                    }
                })
            }
        });

        $('#date_search').change(function() {
            if ($(this).val() != '') {
                var date = $(this).val();
                var value = $('#search').val();
                var party = $('#party_search').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('search-purchase-expense') }}",
                    method: "POST",
                    data: {
                        value: value,
                        party: party,
                        date:date,
                        _token: _token,
                    },
                    success: function(response) {

                        $("#purch-body").empty().append(response);
                    }
                })
            }
        });
    </script>
@endpush
