
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
            @include('clientReport.hrPayroll._payroll_process_header',['activeMenu' => 'salary-process'])
            <div class="tab-content bg-white">
                <div id="studentProfileList" class="tab-pane active px-2">
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="cardStyleChange">
                                <div class="">
                                    <div class="d-flex justify-content-end gx-2 mt-1">
                                        <button
                                            type="button"style="background:#808080;margin-bottom: 5px;float: right; font-weight: bold:"
                                            class=" btn btn-success employee_modal_open"
                                            data-modal="#employee-modal">
                                            START SALARY PROCESS
                                        </button>

                                        <a href="{{route('generate-management-report')}}" target="_blank" style="background:#808080; margin-bottom: 5px;  float: right;  color: #ffffff;" class="btn mx-1" role="button">PRINT REPORT </a>

                                        {{-- <a href="{{route('')}}" onclick="return confirm('You are sure confirm ?')" style="background:#808080; margin-bottom: 5px;  float: right;  color: #ffffff;" class=" btn btn-success" role="button">Confirm </a> --}}
                                        
                                    </div>

                                    <div class="table-responsive mt-2">
                                        <form id="myform" method="POST" enctype="multipart/form-data" action="{{route('salary-process-confirm')}}">
                                            @csrf
                                            <div class="table-responsive " style="height:75vh;max-height:75vh; overflow:auto;">
                                                <table class="table table-bordered table-sm employee_change">
                                                    <thead  class="thead-light">
                                                        <tr class="text-center" style="height: 40px;">
                                                            <th>
                                                                <input type="checkbox" id="vehicle1" class="btn-select-all">
                                                                <label for="vehicle1" style="color: #F2F4F4;">S All</label>
                                                            </th>
                                                            <th>EMPLOYEE ID</th>
                                                            <th>NAME</th>
                                                            <th>Month</th>
                                                            <th>Basic Salary</th>
                                                            <th>Commission</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="t-body">
                                                        @foreach ($employees as $key => $data)
                                                            <tr class="text-center" style="border-bottom: 1px solid #dfe3e7">
                                                                <td>
                                                                    <input type="checkbox" class="checkbox-record" name="records[]" value="{{$data->id}}">
                                                                </td>
                                                                <td>{{ $data->items->emp_id }}</td>
                                                                <td class="employee" data-modal="#employee-modal" data-id="{{ route('salary-process.edit',$data->employee_id) }}"style="width: 50%">{{ $data->items?$data->items->full_name:'' }} <span style="font-weight: bold; color:#ff1919">{{$data->check($data->employee_id)?$data->deductProcessCheck($data->employee_id)?'(Done)':'(Review Need)':''}}</span></td>
                                                                <td>{{$data->month}}</td>
                                                                <td>{{ $data->basicSalary($data->employee_id,$data->month,$data->year) }}</td>
                                                                <td>{{ $data->commission($data->employee_id,$data->month,$data->year) }}</td>
                                                                <td>{{ $data->totalSalary($data->employee_id,$data->month,$data->year) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                @if (count($employees)>0)
                                                    <button type="submit" class="btn btn-primary formButton" title="Submit"  onclick="return confirm('Are you sure to Submit this?')">
                                                        <div class="d-flex">
                                                            <div class="formSaveIcon">
                                                                <img src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" width="20">
                                                            </div>
                                                            <div><span>Confirm</span></div>
                                                        </div>
                                                    </button>
                                                @endif
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

@include('backend.payroll.salary_process.modal')

@endsection

@push('js')


<script src="{{ asset('assets/backend')}}/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
<script src="{{ asset('assets/backend')}}/app-assets/js/scripts/forms/form-repeater.js"></script>
{{-- parent --}}
<script>
    $('.btn-select-all').click(function (event) {
        if (this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function () {
                this.checked = true;
            });
        } else {
            $(':checkbox').each(function () {
                this.checked = false;
            });
        }
    });
    @if (count($errors) > 0)
        $('#parentProfileAdd').modal('show');
    @endif
    function printFunction(){
        window.print();
    }

    $(document).on("click", ".parentViewProfile", function(e) {
        e.preventDefault();
        var id= $(this).attr('id');
        $.ajax({
            url: "{{URL('employee-view-profile-modal')}}",
            type: "get",
            cache: false,
            data:{
                _token:'{{ csrf_token() }}',
                id:id,
            },
            success: function(response){
                document.getElementById("profileViewDetails").innerHTML = response.page;
                $('#parentViewProfileModal').modal('show')
            }
        });
    });

    $(document).on("click", ".parentProfileEdit", function(e) {
        e.preventDefault();
        var url= $(this).attr('href');
        $.ajax({
            url: url,
            type: "get",
            data:{
                _token:'{{ csrf_token() }}',
            },
            success: function(response){
                document.getElementById("profileEditDetails").innerHTML = response.page;
                $('#parentEditProfileModal').modal('show');
            }
        });
    });
</script>
    <script>
        // Use the plugin once the DOM has been loaded.
        $(function() {
            // Apply the plugin

            $('#2filter-table').excelTableFilter();

        });

        // show inser modal for insert data
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @include('backend.payroll.salary_process.ajax')

    @endpush
