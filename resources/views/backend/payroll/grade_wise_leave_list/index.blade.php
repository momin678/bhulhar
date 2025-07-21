
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
            @include('clientReport.hrPayroll._basic_info_header',['activeMenu' => 'base-table'])
            <div class="tab-content bg-white">
                <div id="studentProfileList" class="tab-pane active px-2">
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="cardStyleChange">
                                <div class="">
                                    <div class="d-flex mt-1 justify-content-between align-items-center">
                                        @include('clientReport.hrPayroll._base_table_submenu',['activeMenu' => 'grade-wise-leave-list'])
                                        <button type="button" class="btn btn-primary employee_modal_open btn_create formButton float-right" data-modal="#employee-history-modal" title="Add" data-toggle="#employee-history-modal" data-target="#studentProfileAdd">
                                            <div class="d-flex align-items-center">
                                                <div class="formSaveIcon">
                                                    <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" width="24">
                                                </div>
                                                <div class=""><span> Add new </span></div>
                                            </div>
                                        </button>
                                    </div>

                                    <div class="table-responsive mt-2">
                                        <form id="myform" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="table-responsive " style="height:75vh;max-height:75vh; overflow:auto;">

                                                <table class="table table-bordered table-sm employee_change  " id="2filter-table">
                                                    <thead  class="thead-light">
                                                        <tr class="text-center" style="height: 40px;">
                                                            <th>GRADE</th>
                                                            <th>CASUAL</th>
                                                            <th>SICK</th>
                                                            <th>ANUAL</th>
                                                            <th> Action </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="t-body">
                                                        @foreach ($liveList as $key => $data)
                                                        <tr class="text-center" style="border-bottom: 1px solid #dfe3e7">
                                                            <td class="history"
                                                                data-modal="#history-modal"
                                                                data-id="{{ route('grade-wise-leave-list.edit',$data) }}"style="width: 20%">{{ $data->grades->name }}</td>

                                                            <td class="history"
                                                                data-modal="#history-modal"
                                                                data-id="{{ $data->id }}">{{$data->casual_leave}}</td>
                                                            <td class="history"
                                                                data-modal="#history-modal"
                                                                data-id="{{ $data->id }}">{{$data->sick_leave}}</td>
                                                            <td class="approv history-status-hisrory"
                                                                data-temp_id="{{ $data->id }}"
                                                                style="width: 15%">{{$data->anual_leave}}</td>

                                                                <td>
                                                                    <div class="btn-group">
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-top:2px; padding-bottom: 2px; font-size: 12px; padding-left: 10px;">
                                                                                Actions
                                                                            </button>
                                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                                <a class="dropdown-item studentdocument employee history" data-modal="#history-modal"  data-id="{{ route('grade-wise-leave-list.edit',$data)}}" id=""> Edit </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
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
            <div id="printArea" class="d-none">

            </div>
        </div>
    </div>
</div>

@include('backend.payroll.grade_wise_leave_list.modal')
@endsection



@push('js')

<script src="{{ asset('assets/backend')}}/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
<script src="{{ asset('assets/backend')}}/app-assets/js/scripts/forms/form-repeater.js"></script>
{{-- parent --}}
<script>
    @if (count($errors) > 0)
        $('#parentProfileAdd').modal('show');
    @endif
    function printFunction(){
        window.print();
    }

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


    @include('backend.payroll.grade_wise_leave_list.ajax')


@endpush
