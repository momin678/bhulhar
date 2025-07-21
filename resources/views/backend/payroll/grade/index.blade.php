
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
            @include('clientReport.hrPayroll._basic_info_header',['activeMenu' => 'grade-wise-salary-components'])
            <div class="tab-content bg-white">
                <div id="studentProfileList" class="tab-pane active px-2" style="max-width: 876px;">

                    <div class="d-flex justify-content-between align-items-center pt-1">
                        @include('clientReport.hrPayroll._salary_procedures_submenu',['activeMenu' => 'grades'])
                        <button type="button" class="btn btn-primary employee_modal_open btn_create formButton float-right" data-modal="#employee-modal" title="Add" data-toggle="#employee-modal" data-target="#studentProfileAdd">
                            <div class="d-flex align-items-center">
                                <div class="formSaveIcon">
                                    <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" width="24">
                                </div>
                                <div class=""><span> Add new </span></div>
                            </div>
                        </button>
                    </div>

                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="cardStyleChange">
                                <div class="">
                                    <div class="table-responsive mt-2">
                                        <form id="myform" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="table-responsive " style="height:75vh;max-height:75vh; overflow:auto;max-width: 876px;">

                                                <table class="table table-bordered table-sm employee_change">
                                                    <thead  class="thead-light">
                                                        <tr class="text-center" style="height: 40px;">
                                                            <th>GRADES</th>
                                                            <th> Action </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="t-body">
                                                        @foreach ($grades as $key => $data)
                                                        <tr class="text-center" style="border-bottom: 1px solid #dfe3e7">
                                                            <td class="employee"
                                                                data-modal="#employee-modal"
                                                                data-id="{{ route('grades.edit',$data) }}"style="width: 60%">{{ $data->name }}</td>
                                                             <td class="pl-2">
                                                                    <div class="btn-group">
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-top:2px; padding-bottom: 2px; font-size: 12px; padding-left: 10px;">
                                                                                Actions
                                                                            </button>
                                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                                <a class="dropdown-item studentdocument employee" data-modal="#employee-modal"  data-id="{{  route('grades.edit',$data)}}" id=""> Edit </a>
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
        </div>
    </div>
</div>
@include('backend.payroll.grade.modal')
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


    @include('backend.payroll.grade.ajax')


    @endpush
