
@extends('layouts.backend.app')
@push('css')
<!-- summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@endpush

@section('content')
<style>
.table td {
    vertical-align: middle;
    border-bottom: 1px solid #DFE3E7;
    border-top: none;
    font-size: 12px;
}
.table {
    width: 98%;
    margin-bottom: 1rem;
    color: #727E8C;
    margin: 10px;
}

</style>
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
            @include('clientReport.hrPayroll._basic_info_header', ['activeMenu' => 'employee-profile'])
            <div class="tab-content bg-white">
                <div id="studentProfileList" class="tab-pane active p-2"  style="width: 975px">
                    @include('clientReport.hrPayroll._baisc_info_submenu', ['activeMenu' => 'HISTORY'])
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="cardStyleChange">
                                <div class="card-body pb-0 pr-0" >
                                    <!-- table bordered -->


                                    <div class="row">
                                        <div class="col-md-6">

                                            <form method="get">
                                                <div class="row ">
                                                    <div class="col-9 col-left-padding">
                                                        <div class="form-group">
                                                            <input type="search" class="form-control inputFieldHeight" style="font-size: 12px" name="search" value="{{ old('search') }}" placeholder="Search by EMP ID / Name / Contact Number">

                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group" style="margin-top: 0px">
                                                            <input type="submit" class="form-control inputFieldHeight btn btn-success mt-0"  value="Search" style="font-size: 12px; background:#475F7B !important" >

                                                        </div>
                                                    </div>
                                                </div>


                                            </form>
                                        </div>

                                        <div class="col-6">
                                            <button type="button" style="padding: 4px; margin-top:0px" class="btn btn-primary btn_create formButton float-right  employee_modal_open"
                                            data-modal="#employee-history-modal" title="Add" data-toggle="modal" data-target="#studentProfileAdd">
                                                <div class="d-flex">
                                                    <div class="formSaveIcon">
                                                        <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" width="25">
                                                    </div>
                                                    <div><span>New Employee History</span></div>
                                                </div>
                                            </button>
                                        </div>

                                    </div>
                                </div>
                                <div class="" style="min-height: 300px">
                                    <table class="table  table-sm table-hover" style="width: 975px">
                                        <thead  class="thead-light">
                                            <tr>
                                                <th class="pl-2">EMP Id</th>
                                                <th>Name</th>
                                                <th>Contact Number</th>
                                                <th>Department</th>
                                                <th>Designation</th>
                                                <th class="text-center">ACTION</th>


                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($employees as $key => $data)
                                                    <tr>
                                                        <td class="pl-2">{{ $data->emp_id }}</td>
                                                        <td style="width: 20%">{{ $data->salutation.' '.$data->first_name.' '.$data->middle_name.' '.$data->last_name }}</td>

                                                        <td
                                                            data-id="{{ $data->id }}">+{{$data->code->dial.$data->contact_number}}</td>
                                                        <td
                                                            data-id="{{ $data->id }}">{{$data->div_name->name}}</td>
                                                        <!-- <td class="approv history-status-hisrory"
                                                            data-temp_id="{{ $data->id }}"
                                                            style="width: 15%">{{$data->designation}}</td> -->
                                                            <td >{{$data->dpt?$data->dpt->name:''}}</td>

                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                <div class="dropdown">
                                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-top: 2px; padding-bottom: 2px; font-size: 12px; padding-left: 10px; padding-right:14px; margin:0px">
                                                                        Actions
                                                                    </button>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                        <a class="dropdown-item studentViewProfile history"
                                                                        data-modal="#history-modal"
                                                                        data-id="{{ route('employee-history.show',$data) }}"id="{{$data->id}}">View</a>
                                                                        {{-- <a class="dropdown-item studentProfileEditemployee employee"
                                                                        data-modal="#employee-modal"
                                                                        data-id="{{ route('employees.show',$data) }}"id="{{$data->id}}">View</a> --}}
                                                                        {{-- <a class="dropdown-item studentProfilePrint" id="{{$data->id}}" href="#">Print</a> --}}

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                        @if ($employees)
                                            <div class="mt-1">
                                                {{$employees->links()}}
                                            </div>
                                        @endif
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
@include('backend.payroll.employee_history.modal')



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

            function fatherEmirateImgChange() {
                fatherEmirateImgPreview.src = URL.createObjectURL(event.target.files[0]);
            }
            function passportImgChange() {
                passportImgPreview.src = URL.createObjectURL(event.target.files[0]);
            }
            function qualificationImgChange() {
                qualificationImgPreview.src = URL.createObjectURL(event.target.files[0]);
            }
            function motherEmirateImgChange() {
                motherEmirateImgPreview.src = URL.createObjectURL(event.target.files[0]);
            }
            $(document).on("change", "#edit_fatherEmirateImgChange", function(){
                edit_fatherEmirateImgPreview.src = URL.createObjectURL(event.target.files[0]);
            });
            $(document).on("change", "#edit_motherEmirateImgChange", function(){
                edit_motherEmirateImgPreview.src = URL.createObjectURL(event.target.files[0]);
            });
            $(document).on("change", "#edit_passportImg", function(){
                edit_passportImgPreview.src = URL.createObjectURL(event.target.files[0]);
            });
            $(document).on("change", "#edit_quali_image", function(){
                edit_qualiImgPreview.src = URL.createObjectURL(event.target.files[0]);
            });
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


            @include('backend.payroll.employee_history.ajax')


    @endpush
