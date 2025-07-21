
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
            @include('clientReport.hrPayroll._payroll_process_header',['activeMenu' => 'decuction-entry'])
            <div class="tab-content bg-white">
                <div id="studentProfileList" class="tab-pane active px-2">
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="cardStyleChange">
                                <div class="">
                                    <div class="d-flex align-items-center justify-content-end">
                                        <button type="button" class="btn btn-primary add-line" style="padding:4px 10px" data-modal="#employee-modal" title="Add" data-toggle="#employee-modal" data-target="#studentProfileAdd">

                                            <div class="d-flex">
                                                <div class="formSaveIcon" style="margin-top:-6px;">
                                                    <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" width="25">
                                                </div>
                                                <div><span> Add new </span></div>
                                            </div>

                                        </button>
                                    </div>


                                    <div class="table-responsive mt-2">
                                        <form id="myform" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="table-responsive " style="height:75vh;max-height:75vh; overflow:auto;">

                                                <table class="table table-bordered table-sm employee_change">
                                                    <thead  class="thead-light">
                                                        <tr class="text-center" style="height: 40px;">
                                                            <th style="width: 10%"> EMP ID </th>
                                                            <th style="width: 18%"> Name </th>
                                                            <th style="width: 13%"> Department</th>
                                                            <th style="width: 18%"> Description </th>
                                                            <th style="width: 18%"> Amount </th>
                                                            <th style="width: 13%"> Date </th>
                                                            <th style="width: 10%"> Document </th>
                                                            <th> Action </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="t-body">
                                                        @foreach ($items as $key => $data)
                                                            <tr class="text-center" style="border-bottom: 1px solid rgb(243, 243, 243)">
                                                                <td >{{ $data->items->emp_id }}</td>
                                                                <td>{{ $data->items->full_name }}</td>
                                                                <td>{{ $data->items->div_name->name }}</td>
                                                                <td>{{ $data->description }}</td>
                                                                <td>{{ $data->due }}</td>
                                                                <td>{{ date('d/m/Y', strtotime($data->date)) }}</td>
                                                                <td>
                                                                    <img src="{{ asset('storage/upload/deduction-document/'.$data->document)}}" style="height:30px; margin-right:10px; margin-top:-1px padding-top:0px" class="img-fluid float-right" alt="" >
                                                                </td>
                                                                <td>
                                                                    @if ($data->due>0)
                                                                        <button class="btn-info btn btn-sm employee" style="padding:4px 10px;margin:0;line-hight:0" type="button" data-id="{{ route('deduction-entry.edit',$data) }}">
                                                                        Edit
                                                                    </button>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tr style="display:none" id="shows">
                                                        <td class="call-span: 7" style="border:none">
                                                            <div class="row">
                                                                <div class="col-sm-2 col-12 changeColStyle ">
                                                                    <button type="submit" style="padding: 0rem 1.8rem;margin-top:0px; margin-left: -10px; " id="button" class="btn mr-1 btn-primary formButton" title="Form Save">
                                                                        <div class="d-flex">
                                                                            <div><span> SUBMIT</span></div>
                                                                        </div>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
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

@include('backend.payroll.deduction_entry.modal')

@endsection

@push('js')
@include('backend.payroll.deduction_entry.ajax')
<script src="{{ asset('assets/backend')}}/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
<script src="{{ asset('assets/backend')}}/app-assets/js/scripts/forms/form-repeater.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
{{-- parent --}}
<script>
    @if (count($errors) > 0)
        $('#parentProfileAdd').modal('show');
    @endif
    function printFunction(){
        window.print();
    }

    $(function() {
        $("body").delegate("#datepicker", "focusin", function(){
            $(this).datepicker();
        });
    });

    var i = 0;
    // add line
    $(document).on("click", '.add-line', function(event) {

        if (i==0) {
            $(".t-body").append('<tr style="border-bottom: 1px solid rgb(243, 243, 243)"><td><input type="text" name="emp_name" id="emp_name" style="width: 100%;background:#B4C6E7;height:34px;"></td><td><select name="employee_id" id="employee_id" style="width: 100% !important;background:#B4C6E7; height: 34px" required><option value="">Select ...</option>@foreach ($employees as $employee)<option value="{{$employee->id}}">{{$employee->full_name}}</option>@endforeach</select></td><td><select name="division" id="division" style="width: 100% !important;background:#B4C6E7; height: 34px" required><option value="">Select </option>@foreach ($divisions as $division)<option value="{{$division->id}}">{{$division->name}}</option>@endforeach</select></td><td><input type="text" name="description" id="description" required style="width: 100%;background:#B4C6E7;height:34px;"></td><td><input type="number" name="amount" id="amount" required style="width: 100%;background:#B4C6E7; height:34px"></td><td><input type="text" name="date" class="datepicker" autocomplete="off" placeholder="DD/MM/YY" id="" required style="width: 100%;background:#B4C6E7; height:34px"></td><td colspan="2"><input type="file" name="file" style="width: 100%;background:#B4C6E7; height:34px"></td></tr>');
        }else{
            $("#employee_id").val('');
            $("#amount").val('');
            $("#description").val('');
            $('#datepickers').val('');
            $("#emp_name").val('');
            $("#division").val('');
        }
        $("#emp_name").focus();
        $("#myform").attr('action', "{{route('deduction-entry.store')}}");
        document.querySelector("#shows").style.removeProperty("display");
        $(".datepicker").datepicker({ dateFormat: "dd/mm/yy" });
        i++;

    });
    //remove line
    $(document).on("click", '.remove-row', function(event) {
        // alert('I am there');
        $(this).parents(".start").remove();
    });

     //employee name select
     $(document).on("change", "#employee_id", function(e) {
                if ($(this).val() != '') {
                var emp = $(this).val();
                // alert(544654);
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('employee-name') }}",
                    method: "GET",
                    data: {
                        emp: emp,
                        _token: _token,
                    },
                    success: function(response) {
                            $("#emp_name").val(response.page.emp_id);
                            $("#division").val(response.page.division);
                    }
                })
            }
    });

    //end employee name select

    //employee id select start

    $(document).on("keyup", "#emp_name", function(e) {
                if ($(this).val() != '') {
                var emp = $(this).val();
                // alert(category);
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('employee-name') }}",
                    method: "GET",
                    data: {
                        id: emp,
                        _token: _token,
                    },
                    success: function(response) {
                        console.log(response);
                            $("#employee_id").val(response.page.id).change();
                            $("#division").val(response.page.division);

                    }
                })
            }
    });
    //employee id select end

    //division select start
    $(document).on("change", "#division", function(e) {
            if ($(this).val() != '') {
            var emp = $(this).val();
            // alert(544654);
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('employee-name') }}",
                method: "GET",
                data: {
                    division: emp,
                    _token: _token,
                },
                success: function(response) {
                    var optionHtml= '<option> Select </option>';
                    response.page.forEach(function(element, index) {
                        console.log(element.full_name);
                        optionHtml += "<option value='"+element.id +"'> "+ element.full_name+"</option>";
                    });
                    $('#employee_id').html(optionHtml);
                }
            })
        }
    });
    //division select end


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
@endpush
