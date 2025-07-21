




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
                <div id="studentProfileList" class="tab-pane active p-2" style="max-width: 975px">
                    @include('clientReport.hrPayroll._baisc_info_submenu', ['activeMenu' => 'profile'])

                            <div class="cardStyleChange">
                                <div class="card-body pb-0" >
                                    <!-- table bordered -->


                                    <div class="row">
                                        <div class="col-md-6 col-left-padding">

                                            <form method="get">
                                                <div class="row">
                                                    <div class="col-9">
                                                        <div class="form-group">
                                                            <input type="search" class="form-control inputFieldHeight" style="font-size: 12px" name="search" value="{{ old('search') }}" placeholder="Search by EMP ID / Name / Contact Number">

                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <input type="submit" class="form-control inputFieldHeight btn btn-success" value="Search" style="font-size: 12px; background:#475F7B !important" >

                                                        </div>
                                                    </div>
                                                </div>


                                            </form>
                                        </div>

                                        <div class="col-6 col-right-padding">
                                            <button type="button" class="btn btn-primary btn_create formButton float-right employee_modal_open"
                                            data-modal="#employee-modal" title="Add" data-toggle="modal" data-target="#studentProfileAdd">
                                                <div class="d-flex">
                                                    <div class="formSaveIcon">
                                                        <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" width="25">
                                                    </div>
                                                    <div><span>New Employee Onboard</span></div>
                                                </div>
                                            </button>
                                        </div>

                                    </div>
                                </div>
                                <div style="min-height: 300px">
                                    <table class="table  table-sm table-hover" style="max-width: 975px">
                                        <thead  class="thead-light">
                                            <tr class="text-center" style="height: 40px;">
                                                    <th>EMP NO</th>
                                                    <th>Name</th>
                                                    <th>Contact Number</th>
                                                    <th>Department</th>
                                                    <th>Designation</th>
                                                    <th>Salary type</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($employees as $key => $data)
                                                    <tr class="text-center">
                                                        <td>{{ $data->emp_id }}</td>
                                                        <td style="width: 20%">{{ $data->full_name }}</td>

                                                        <td>+{{$data->code?$data->code->phonecode:''.$data->contact_number}}</td>
                                                        <td>{{$data->div ? $data->div->name:$data->division}}</td>
                                                        <td class="approv employee-status-hisrory" data-temp_id="{{ $data->id }}"  style="width: 15%">{{$data->dpt?$data->dpt->name:''}}</td>
                                                        <td class="text-dark" style="background: {{ $data->status == 1 ? '#a2f189' : ($data->status == 0 ? '#e77cb1' : '#EBEDA3') }}"
                                                            data-approv="{{ $data->status }}">{{ $data->status == 1 ? 'Approved and Implemented' : ($data->status == 0 ? 'Yet to be approved' : 'After update not approved') }}</td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-top: 2px; padding-bottom: 2px; font-size: 12px; padding-left: 10px; padding-right:14px">
                                                                            Actions
                                                                        </button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                            <a class="dropdown-item studentViewProfile  employee-edit"

                                                                            data-id="{{ route('employees.edit',$data->id) }}"id="{{$data->id}}">Edit</a>
                                                                            <a class="dropdown-item studentProfileEditemployee employee"
                                                                            data-modal="#employee-modal"
                                                                            data-id="{{ route('employees.show',$data) }}"id="{{$data->id}}">View</a>
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
            <div id="printArea" class="d-none">

            </div>
        </div>
    </div>
</div>






@include('backend.payroll.employee.modal')



@endsection
    @push('js')

    @include('backend.payroll.employee.ajax')        <!-- summernote css/js -->

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
        var i = 0;
        // add line
        $(document).on("click", '.add-line', function(event) {
            ++i;

            $(".from-body").append('<div class="row mt-1 start"><div class="col-sm-4 changeColStyle"><input type="text" class="form-control inputFieldHeight" name="group_a['+ i +'][post_name]" ></div><div class="col-sm-4 changeColStyle"><input type="file" class="form-control inputFieldHeight" name="group_a['+ i +'][post_quali_image]"></div><div class="col-sm-2 d-flex changeColStyle justify-content-end"><button type="button" class="btn btn-danger formButton mDeleteIcon remove-row" title="Delete"><div class="d-flex align-items-right"><div class="formSaveIcon"><img  src="{{asset('assets/backend/app-assets/icon/delete-icon.png')}}" alt="" srcset=""  width="15"></div><div><span>Delete</span></div></div></button></div></div>');


        });
        //remove line
        $(document).on("click", '.remove-row', function(event) {
            // alert('I am there');
            $(this).parents(".start").remove();
        });

        //Delete others
        $(document).on("click", '.invoice-item-delete', function(event) {
                event.preventDefault();
                // alert(1);
                var that = $(this);
                var urls = that.attr("data_target");
                var _token = $('input[name="_token"]').val();
                // alert(invoice_no);
                $.ajax({
                    url: urls,
                    method: "GET",
                    _token: _token,

                    success: function(response) {
                        // alert("hukka");
                        console.log(response);
                        $(".data").empty().append(response.page);

                    },
                    error: function() {
                        //   alert('no');
                    }
                });
        });

        $(document).on("click", ".parentProfileEdit", function(e) {
            e.preventDefault();
            var url= $(this).attr('href');
            // alert(url);
            $.ajax({
                url: url,
                type: "get",
                data:{
                    _token:'{{ csrf_token() }}',
                },
                success: function(response){
                    document.getElementById("profileEditDetails").innerHTML = response.page;
                    $('#parentEditProfileModal').modal('show');
                    $(".datepicker").datepicker({ dateFormat: "dd/mm/yy" });
                }
            });
        });

        $(document).on("keyup", ".search", function(e) {
            // e.preventDefault();
            var val = $(this).val();
            // if (condition) {

            // }
            $.ajax({
                url: "{{URL('employee-search')}}",
                type: "get",
                data:{
                    _token:'{{ csrf_token() }}',
                    id:val,
                },
                success: function(response){
                    $('.emp_list').empty().append(response.page);
                }
            });
        });


        $(document).on("keyup", "#present_address", function(e) {
                    var value = $(this).val();
                    $("#parmanent_address").val(value);
                });

        $(document).on("keyup", "#em_present_address", function(e) {
                var value = $(this).val();
                $("#em_parmanent_address").val(value);
            });

        $(document).on("keyup", "#r_present_address", function(e) {
                var value = $(this).val();
                $("#r_parmanent_address").val(value);
            });
        $(document).on("keyup", "#name", function(e) {
                var value = $(this).val();
                document.getElementById("name_show").innerHTML= "Name :" +value;
            });
        $(document).on("click", ".parentProfilePrint", function(e) {
            e.preventDefault();
            var id= $(this).attr('id');
            $.ajax({
                url: "{{URL('parent-profile-print')}}",
                type: "post",
                cache: false,
                data:{
                    _token:'{{ csrf_token() }}',
                    id:id,
                },
                success: function(response) {
                    document.getElementById("profilePrintDetails").innerHTML = response;
                    $('#parentPrintProfileModal').modal('show');
                    setTimeout(printFunction, 500);
                },
                error: function() {
                    alert('Problem Found');
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

            <!-- summernote css/js -->
            <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
            <script type="text/javascript">
            $(document).ready(function() {
                $('.summernote').summernote({
                    height: 100
                });

                // $('#summernote2').summernote({
                //     height: 100
                // });
            });
                // $('#summernote').summernote({
                //     height: 200
                // });
            </script>

<script>
    // 8888888888888888888888888888888888 AJAX email-valadition off   888888888888888888888888888888888888888888
$(document).on("change", ".errorr-abcd1fgfg", function(e) {
        e.preventDefault();

        var value = $(this).val();
        var emailInput = $("#email1ffff");
        //alert(value)

        if (value == 3 || value == 4 || value == 5) {
            emailInput.prop("required", false);
            emailInput.removeClass("ajax-error");
            $(".error-disable").prop("disabled", false)
            $(".email_error").text("").css("color", "green").show();

        } else {
            if(emailInput.val()!='')
            {
                emailInput.prop("required", true);
            emailInput.addClass("ajax-error");
            reverse('email1ffff');
            }

        }



    });
// 8888888888888888888888888888888888 AJAX VALIDATION 888888888888888888888888888888888888888888
</script>
    @endpush
