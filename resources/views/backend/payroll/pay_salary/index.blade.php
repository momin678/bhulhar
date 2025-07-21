
@extends('layouts.backend.app')
@section('content')
@include('backend.tab-file.style')
<style>
    .table .thead-light th {
        color:#F2F4F4 ;
        background-color: #34465b;
        border-color: #DFE3E7;
    }
    tr:nth-child(even) {
        background-color: #c8d6e357;
    }
</style>
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @include('clientReport.hrPayroll._payroll_process_header',['activeMenu' => 'pay-salary'])
            <div class="tab-content bg-white">
                <div id="studentProfileList" class="tab-pane active px-2">
                    <div class="card-body pb-0">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <form class="form form-vertical row" method="get" enctype="multipart/form-data">
                                        <div class="col-md-8 col-12">
                                            <label for="date">Month</label>
                                                <input type="month" class="inputFieldHeight form-control  @error('date') error @enderror"
                                                name="date" value="{{ isset($inputs) ? $inputs['date'] : old('date')}}"required>
                                                @error('date')
                                                <span class="error">{{ $message }}</span>
                                                @enderror
                                        </div>
                                        <div class="col-12 col-md-3 d-flex ">
                                            {{-- <button type="submit" class="btn btn-primary mr-1">Search</button> --}}
                                            <button type="submit" class="btn btn-primary formButton mPrint mt-2 mb-1" title="Searching" >
                                                <div class="d-flex">
                                                    <div class="formSaveIcon">
                                                        <img src="{{asset('assets/backend/app-assets/icon/view-icon.png')}}" alt="" srcset="" width="20">
                                                    </div>
                                                    <div><span> View</span></div>
                                                </div>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-8  d-flex align-items-center justify-content-end">
                                        <div class="d-flex">
                                            <button
                                                type="button"
                                                class=" btn btn-success employee"
                                                data-modal="#employee-modal"
                                                data-id="{{ route('pay-salary.create') }}">
                                                SALARY PAYMENT

                                            </button>

                                            <button
                                                type="button"
                                                class="ml-2 btn btn-info employee_modal_open"
                                                data-modal="#payslip-modal">
                                                PAYSLIP

                                            </button>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="cardStyleChange">
                                <div class="">
                                    {{-- <div class="d-flex justify-content-end gx-2 mt-1">
                                        <button
                                            type="button"
                                            class=" btn btn-success employee"
                                            data-modal="#employee-modal"
                                            data-id="{{ route('pay-salary.create') }}">
                                            SALARY PAYMENT

                                        </button>

                                        <button
                                            type="button"
                                            class="ml-2 btn btn-info employee_modal_open"
                                            data-modal="#payslip-modal">
                                            PAYSLIP

                                        </button>
                                    </div> --}}

                                    <div class="table-responsive mt-2">
                                        <form id="myform" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="table-responsive " style="height:75vh;max-height:75vh; overflow:auto;">

                                                <table class="table table-bordered table-sm employee_change table-light" id="2filter-table">
                                                    <thead  class="thead-light">
                                                        <tr class="text-center" style="height: 40px;">
                                                            <th>EMPLOYEE NO</th>
                                                            <th>Name</th>
                                                            <th>Designation</th>
                                                            <th>Month</th>
                                                            <th>Year</th>
                                                            <th>Due</th>
                                                            <th>Paid</th>
                                                            <th>Salary</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="t-body">
                                                        @foreach ($paySalarys as $key => $data)
                                                            <tr class="text-center pay-salary" id="{{ $data->id }}">
                                                                <td>{{ $data->items2?$data->items2->emp_id:'' }}</td>
                                                                <td>{{ $data->items2?$data->items2->full_name:'' }}</td>
                                                                <td>{{ $data->items2?($data->items2->dpt?$data->items2->dpt->name:''):'' }}</td>
                                                                <td>{{ $data->month }}</td>
                                                                <td>{{ $data->year }}</td>
                                                                <td>{{ $data->due }}</td>
                                                                <td>{{ $data->paid }}</td>
                                                                <td>{{ ($data->due != 0)?$data->due:'Paid' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </form>
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
@include('backend.payroll.pay_salary.modal')
@endsection
@push('js')

<script src="{{ asset('assets/backend')}}/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
<script src="{{ asset('assets/backend')}}/app-assets/js/scripts/forms/form-repeater.js"></script>

<script>
    // Use the plugin once the DOM has been loaded.
    $(function() {

        // Apply the plugin
        $('.3filter-table').excelTableFilter();
        $('#3filter-table').excelTableFilter();

    });

    // show inser modal for insert data
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script type='text/javascript'>
    //CheckAll checkbox
    $('body').on('click','#checkall',function(){
        var checked = $(this).is(':checked');
        if(checked){
            $(".checkbox").each(function(){
                $(this).prop("checked",true);
            });
        }else{
            $(".checkbox").each(function(){
                $(this).prop("checked",false);
            });
        }
    });
    $(document).on("click", ".pay-salary", function(e) {
        e.preventDefault();
        var id = $(this).attr('id');
        $.ajax({
            url: "{{ route('pay-salary-view') }}",
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
</script>

@include('backend.payroll.pay_salary.ajax')
@endpush
