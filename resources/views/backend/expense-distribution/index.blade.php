
@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@endpush
@section('content')
@include('backend.tab-file.style')
<style>
        tr:nth-child(even) {
        background-color: #c8d6e357;
    }
    a.text-dark:hover, a.text-dark:focus {
        color: #ffffff !important;
    }
    .btn-outline-secondary {
        border-radius: 40px;
        padding: 0.2px 9px 0.2px 9px !important;
    }

    .table .thead-light th {
        color:#F2F4F4 ;
        background-color: #34465b;
        border-color: #DFE3E7;
    }
</style>

<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @include('clientReport.accounting._header', ['activeMenu' => 'expense'])
            <div class="tab-content bg-white p-2">
                <div class="tab-pane active">
                    <div>
                        @include('clientReport.purchase.purchase-bill', [
                                'activeMenu' => 'distribution',
                                ])
                        <section class="mt-3">
                            <div class="mt-2">
                                <div class="row mb-1">
                                    <div class="col-md-6">
                                        <form>
                                            <input type="text" name="search_value" class="form-control inputFieldHeight inputFieldHeight" placeholder="Search By Code, Name">
                                        </form>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button type="button" class="btn btn-primary btn_create formButton" title="Add" data-toggle="modal" data-target="#costCenter" style="padding-top: 6px;padding-bottom: 6px;">
                                            <div class="d-flex">
                                                <div class="formSaveIcon">
                                                    <img src="{{asset('storage/upload/icon/add-icon.png')}}" width="25">
                                                </div>
                                                <div><span>Add</span></div>
                                            </div>
                                        </button>
                                        {{-- <a href="" class="btn btn-xs mPrint formButton" id="listPrint" title="Print"><img  src="{{asset('storage/upload/icon/print-icon.png')}}" alt="" srcset="" class="img-fluid" width="30"> Print</a> --}}
                                        <a href="#" class="btn btn-xs mExcelButton formButton" onclick="exportTableToCSV('Expence-Distrybutions.csv')" title="Export to Excel"><img  src="{{asset('storage/upload/icon/excel-icon.png')}}" alt="" srcset="" class="img-fluid" width="30">Excel</a href="#">
                                    </div>
                                </div>
                                <div class="cardStyleChange">
                                    <table class="table mb-0 table-sm table-hover table_table">
                                        <thead  class="thead-light">
                                            <tr class="text-center" style="height: 40px;">
                                                <th style="padding-left: 18px;width:10%;">SI</th>
                                                <th style="width:20%;">Note</th>
                                                <th style="width:20%;">Date</th>
                                                <th>Distributed From</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th style="width:20%;">Total Amount</th>
                                                <th style="padding-left: 20px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="user-table-body table_data">
                                            @foreach ($expenceDistrybutions as $key=>$data)
                                            <tr class="text-center trFontSize distribute_view"  url="{{route('expense-distribution.show',$data->id)}}" style="height: 40px;">
                                                <td style="padding-left: 18px;">{{ $key+1}}</td>
                                                <td>{{ $data->note }}</td>
                                                <td>{{ date('d/m/Y', strtotime($data->date)) }}</td>
                                                <td>{{$data->expense_type}}</td>
                                                <td>{{ date('d/m/Y', strtotime($data->expense_from)) }}</td>
                                                <td>{{ date('d/m/Y', strtotime($data->expense_to)) }}</td>

                                                <td>{{ $data->total_amount }}</td>
                                                <td>
                                                    <div style="margin-top: -12px;">
                                                        <a href="{{ route('expense-distribution.show', $data->id) }}" class="btn" style="height: 30px; width: 30px;" title="Edit"><img src="{{ asset('storage/upload/icon/edit-icon.png')}}" style=" height: 25px; width: 25px;"></a>
                                                        {{-- <a href="{{ route('expense-distribution.distroy',$data->id) }}" onclick="return confirm('about to delete master account. Please, Confirm?')"  class="btn" style="height: 25px; width: 25px;padding: 0.467rem 0.8rem;" title="Delete"><img src="{{ asset('storage/upload/icon/delete-icon.png')}}" style=" height: 25px; width: 25px; margin-left: -12px;"></a> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="costCenter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 15px;background:#364a60;">
                <h5 class="modal-title" id="exampleModalLabel" style="font-family:Cambria;font-size: 2rem;color:white;">Expense Distribution</h5>
                <div class="d-flex align-items-center">
                    <button type="button" class="project-btn bg-danger text-white" data-dismiss="modal" aria-label="Close" style="padding: 3px 12px;" data-bs-toggle="tooltip" data-bs-placement="right" title="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{-- @include('alerts.alerts') --}}
                </div>
            </div>
            <div class="modal-body" style="padding: 5px 5px;">
                <section id="widgets-Statistics" class="mr-1 ml-1 mb-1">
                    <div class="row pt-2">
                        <div class="col-12 cost-center-form">
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-body">
                                        <div class=" form-group">
                                            <label>Form Date</label>
                                            <input type="text"  class="form-control inputFieldHeight datepicker" autocomplete="off" name="expense_from" id="expense_from" value="" placeholder="DD/MM/YYYY"  >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-body">
                                        <div class=" form-group">
                                            <label>To Date</label>
                                            <input type="text" class="form-control inputFieldHeight datepicker" autocomplete="off" name="expense_to" id="expense_to" value="" placeholder="DD/MM/YYYY"  >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="form-body">
                                        <div class=" form-group">
                                            <label>Type</label>
                                            <select name="expense_type" id="expense_type" class="form-control inputFieldHeight" required>
                                                <option value="Garage">Garage</option>
                                                <option value="Office">Office</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-1">
                                    <div class="form-body">
                                        <div class=" form-group">
                                            <a  class="btn-info btn  mt-2 inputFieldHeight" id="search-expense-ammount">Search</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('expense-distribution.store') }}" method="POST" id="distribution_form">
                                @csrf
                                <div class="row match-height">
                                    <div class="col-md-2">
                                        <div class="form-body">
                                                <div class=" form-group">
                                                    <label> Date</label>
                                                    <input type="text" id="" class="form-control date inputFieldHeight datepicker" name="date" value="{{date('d/m/Y')}}" placeholder="DD/MM/YYYY" >
                                                </div>
                                            </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-body">
                                            <div class=" form-group">
                                                <label>Note</label>
                                                <input type="text" id="note" class="form-control note inputFieldHeight" name="note" value="" placeholder="Note" required>
                                                @error('note')
                                                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-body">
                                            <div class=" form-group">
                                                <label>Form Date</label>
                                                <input type="text"  class="form-control expense_from_ inputFieldHeight " readonly name="expense_from" id="expense_from_" value="" placeholder="DD/MM/YYYY"  >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-body">
                                            <div class=" form-group">
                                                <label>To Date</label>
                                                <input type="text" class="form-control expense_to_ inputFieldHeight " readonly name="expense_to" id="expense_to_" value="" placeholder="DD/MM/YYYY"  >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-body">
                                            <div class=" form-group">
                                                <label>Type</label>
                                                <input type="text" class="form-control expense_type_ inputFieldHeight " readonly name="expense_type" id="expense_type_" value="" placeholder="Type"  >
                                            </div>
                                        </div>
                                    </div>
                                   <div class="col-md-2">
                                        <div class="form-body">
                                            <div class=" form-group">
                                                <label>Total</label>
                                                <input type="text" id="total_expense" class="form-control inputFieldHeight" name="total_expense" value="" placeholder="Total" readonly required>
                                                @error('total')
                                                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                   </div>
                                   <div class="col-md-12">
                                    <div class="cardStyleChange table-responsive">
                                        <table class="table mb-0 table-sm table-hover">
                                            <thead  class="thead-light">
                                                <tr class="text-center" style="height: 20px;">
                                                    <th style="padding-left: 18px;width:10%;">SI</th>
                                                    <th style="width:20%;">Vehicle</th>
                                                    <th style="width:20%;">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody class="user-table-body">
                                                <input type="hidden" value="{{$vehicles->count()}}" id="total_vehicle">
                                                @foreach ($vehicles as $key => $vehicle)
                                                <tr class="text-center trFontSize" style="height: 20px;">
                                                    <td style="padding-left: 18px;">{{ ++$key}}</td>
                                                    <td>{{ $vehicle->vehicle_number }} <input type="hidden" value="{{$vehicle->id}}" name="vehicle_id[{{$vehicle->id}}]"></td>
                                                    <td><input type="text"  class="form-control inputFieldHeight individual_vehicle_amount" name="v_amount[{{$vehicle->id}}]"  placeholder="Amount" ></td>
                                                </tr>
                                                @endforeach

                                                <tr>
                                                    <td colspan="2" class="text-right">Total</td>
                                                    <td><input type="number" step="any" name="individual_total" id="individual_total" class="form-control individual_total inputFieldHeight" required readonly></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                  </div>
                                  <div class="col-12 d-flex justify-content-end ">
                                    <button type="submit" class="btn btn-primary mr-1">Submit</button>
                                    {{-- <button type="reset" class="btn btn-light-secondary">Reset</button> --}}
                                </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="distributeShowModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">

        <div id="distribute_view_content">

        </div>
      </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="distributeEditModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">

        <div id="distribute_view_content_edit">

        </div>
      </div>
    </div>
</div>
@endsection


@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    <script>

        function printFunction(){
            window.print();
        }
        $(document).on("click", "#listPrint", function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{URL('cost-center-list-print')}}",
                type: "post",
                cache: false,
                data:{
                    _token:'{{ csrf_token() }}',
                },
                success: function(response){
                    document.getElementById("costCenterPrintShow").innerHTML = response;
                    $('#costCenterPrintModal').modal('show');
                    setTimeout(printFunction, 500);
                }
            });
        });
        $(document).ready(function() {

            var delay = (function() {
                var timer = 0;
                return function(callback, ms) {
                    clearTimeout(timer);
                    timer = setTimeout(callback, ms);
                };
            })();


            $(document).on("click", ".distribute_view", function(e) {
                e.preventDefault();
                var url= $(this).attr('url');
                $.ajax({
                    url: url,
                    type: "get",
                    cache: false,

                    success: function(response){
                        document.getElementById("distribute_view_content").innerHTML = response;
                        $('#distributeShowModal').modal('show')
                        $('.datepicker').datepicker("destroy").datepicker({
                        dateFormat: "dd/mm/yy"
                    });
                    }
                });
            });

            $(document).on("click", ".distribute_edit", function(e) {
            e.preventDefault();
            var url = $(this).attr('url');

            $.ajax({
                url: url,
                type: "get",
                cache: false,
                success: function(response) {
                    $("#distribute_view_content_edit").empty().html(response) ;

                    // Show the modal
                    $('#distributeEditModal').modal('show');

                    // Re-initialize the datepicker for the edit modal fields
                    $('.datepicker').datepicker("destroy").datepicker({
                        dateFormat: "dd/mm/yy"
                    });
                }
            });
        });


            $(document).on("click", "#search-expense-ammount", function(e) {
                e.preventDefault();
                var from = $('#expense_from').val();
                var to = $('#expense_to').val();
                var type = $('#expense_type').val();
                // alert(urls);
                    $.ajax({
                        url: "{{ route('search-expense-amount') }}",
                        type: 'GET',
                        cache: false,
                        dataType: 'json',
                        data: {
                            from: from,
                            to: to,
                            type:type
                        },
                        success: function(response) {
                            //   alert('ok');
                            console.log(response);
                            $('#expense_from_').val(from);
                            $('#expense_to_').val(to);
                            $('#expense_type_').val(type);
                            $('#total_expense').val(response.toFixed(2));
                            $vehicles= $('#total_vehicle').val();
                            var ind_amnt= response/$vehicles;
                            $('.individual_vehicle_amount').val(ind_amnt.toFixed(2));
                            ind_total_sum();


                        },
                        error: function() {
                            //   alert('no');
                        }
                    });

            });

            $(document).on("keyup", ".individual_vehicle_amount", function(e) {
                ind_total_sum();
            });

            $(document).on('submit', '#distribution_form', function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var data = new FormData(this);
                var tolerance = 0.1;
                var totalExpense = parseFloat($('#total_expense').val());
                var individualTotal = parseFloat($('#individual_total').val());
                if (Math.abs(totalExpense - individualTotal) < tolerance && individualTotal > 0) {
                    $('#costCenter').modal('hide')
                    $('#expense_from').val('');
                    $('#expense_to').val('');
                    $('#expense_type').val('');
                    $('.individual_vehicle_amount, .expense_from_, .expense_to_, .note,.expense_type_ ,.individual_total').val('');

                    $.ajax({
                    url: url,
                    method: 'POST',
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        document.getElementById("distribute_view_content").innerHTML = response;
                        $('#distributeShowModal').modal('show');
                        $('.table_table').load(location.href + ' .table_table');

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        toastr.warning('Something Wents wrong!');
                    }
                })
                }
                else
                {
                    toastr.warning('Total Amount And Total Expense Should Be Equal!');
                }

            });

            function ind_total_sum()
            {
                var total = 0;
                $('.individual_vehicle_amount').each(function() {
                var amount = parseFloat(this.value) || 0;
                total += amount;
                });

                $('#individual_total').val(total.toFixed(2));
            }

            // *********************************** edit jquery code here********************

            $(document).on("click", "#search-expense-ammount_edit", function(e) {
                e.preventDefault();
                var from = $('#expense_from__edit').val();
                var to = $('#expense_to__edit').val();
                var type = $('#expense_type__edit').val();
                // alert(urls);
                    $.ajax({
                        url: "{{ route('search-expense-amount') }}",
                        type: 'GET',
                        cache: false,
                        dataType: 'json',
                        data: {
                            from: from,
                            to: to,
                            type:type
                        },
                        success: function(response) {
                            //   alert('ok');
                            console.log(response);
                            $('#expense_from_edit').val(from);
                            $('#expense_to_edit').val(to);
                            $('#expense_type_edit').val(type);
                            $('#total_expense_edit').val(response.toFixed(2));
                            $vehicles= $('#total_vehicle_edit').val();
                            var ind_amnt= response/$vehicles;
                            $('.individual_vehicle_amount_edit').val(ind_amnt.toFixed(2));
                            ind_total_sum_edit();


                        },
                        error: function() {
                            //   alert('no');
                        }
                    });

            });

            $(document).on("keyup", ".individual_vehicle_amount_edit", function(e) {
                ind_total_sum_edit();
            });

            $(document).on('submit', '#distribution_form_edit', function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var data = new FormData(this);
                var tolerance = 0.1;
                var totalExpense = parseFloat($('#total_expense_edit').val());
                var individualTotal = parseFloat($('#individual_total_edit').val());
                if (Math.abs(totalExpense - individualTotal) < tolerance && individualTotal > 0) {
                    $.ajax({
                    url: url,
                    method: 'POST',
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        document.getElementById("distribute_view_content").innerHTML = response;
                        $('#distributeShowModal').modal('show');
                        $('.table_table').load(location.href + ' .table_table');
                        $('.datepicker').datepicker("destroy").datepicker({
                            dateFormat: "dd/mm/yy"
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        toastr.warning('Something Wents wrong!');
                    }
                })
                }
                else
                {
                    toastr.warning('Total Amount And Total Expense Should Be Equal!');
                }

            });

            function ind_total_sum_edit()
            {
                var total = 0;
                $('.individual_vehicle_amount_edit').each(function() {
                var amount = parseFloat(this.value) || 0;
                total += amount;
                });

                $('#individual_total_edit').val(total.toFixed(2));
            }
        });
    </script>
@endpush
