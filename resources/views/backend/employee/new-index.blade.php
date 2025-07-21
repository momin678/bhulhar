@extends('layouts.backend.app')
@section('content')
@include('backend.tab-file.style')
<style>
    .table td{
        border-bottom: none;
    }
    .commonSelect2Style span{
        width: 100% !important;
    }
    .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b{
        display: none;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b{
        display: none;
    }
    .list-print{
        display: none;
    }
    @media print{
        .list-print{
            display: block;
            position: absolute;
            left: 0;
            top: 0;
        }
        html, body {
            border: 1px solid white;
            height: 99%;
            page-break-after: avoid !important;
            page-break-before: avoid !important;
        }
    }
</style>
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
                <a href="{{ route('new-employee-section') }}" class="nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div> Employee Profile </div>
                </a>
                <a href="{{route('new-employee-attendance')}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="parentProfileTab">
                    <div class="text-dark"> Employees Attendance </div>
                </a>
                <a href="{{route("new-salary-structure")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div> PayRoll </div>
                </a>
                <a href="{{route("new-management-team")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div> ManageMent Team </div>
                </a>
                <a href="{{route("new-eChartOf-account")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div> Expense HEad </div>
                </a>
                <a href="{{route("new-supllier")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div> Supllier </div>
                </a>
                <a href="{{route("new-donar")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div> Donar </div>
                </a>
                <a href="{{route("new-mapping")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div> File </div>
                </a>
            </div>
            <div class="tab-content bg-white px-4 py-2 active">
                <div class="tab-pane active">
                    <div class="d-flex align-items-center justify-content-between" id="nav-tab" role="tablist">
                        <div class="d-flex align-items-center gap-2 " style="border-bottom: 1px solid #ddd">
                            <a href="{{route("new-employee-section")}}" class="bg-secondary text-white nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false">
                                <div>Employee Profile</div>
                            </a>
                            <a href="{{route("new-employee-document")}}" class="text-dark nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                                <div>Employee Document</div>
                            </a>
                        </div>
                        <div class="d-flex align-items-center gap-2 " style="border-bottom: 1px solid #ddd">
                            <button type="button" class="btn btn-primary btn_create formButton mr-1" title="Add" data-toggle="modal" data-target="#studentProfileAdd">
                                <div class="d-flex">
                                    <div class="d-flex">
                                        <i class="bx bx-plus-circle" style="font-size: 20px;padding-bottom:6px;"></i>
                                    </div>
                                </div>
                            </button>
                            <a href="#" class="btn mPrint formButton" title="List Print" id="employeeProfileList">
                                <div class="d-flex">
                                    <div class="d-flex">
                                        <i class="bx bx-printer" style="font-size: 20px;padding-bottom:6px;"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="tab-content bg-white">
                        <div id="studentProfileList" class="tab-pane active">
                            <div class="row" id="table-bordered">
                                <div class="col-12">
                                    <div class="cardStyleChange p-2">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <form  method="get">
                                                    <div class="form-group">
                                                        <input type="text" class="inputFieldHeight form-control " name="search" placeholder="Search by Employee Name, Emirates Number">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="table-responsive" style="min-height: 300px">
                                            <table class="table mb-0 table-sm table-hover">
                                                <thead  class="thead-light">
                                                    <tr style="height: 50px;">
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Nationality</th>
                                                        <th>Emirates Num</th>
                                                        <th>Designation</th>
                                                        <th class="pl-2">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-sm">
                                                    @foreach ($employees as $employee)
                                                    <tr class="border-bottom" style="font-size: 12px;">
                                                        <td>{{ $employee->id }} </td>
                                                        <td>{{ $employee->fname. ' '.$employee->mname. ' '.$employee->family_name  }} </td>
                                                        <td>{{ $employee->nationality }} </td>
                                                        <td>{{ $employee->emirates_id_num }} </td>
                                                        <td class="text-center">{{ $employee->employee_role }} </td>
                                                        <td style="float: right;">
                                                            <div class="btn-group">
                                                                <div class="dropdown">
                                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-top: 2px; padding-bottom: 2px; font-size: 12px; padding-left: 10px;">
                                                                        Actions
                                                                    </button>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                        <a class="dropdown-item employeeEditProfile" href="#" id="{{$employee->id}}">Edit</a>
                                                                        <a class="dropdown-item employeeViewProfile" href="#"  id="{{$employee->id}}">View</a>
                                                                        <a class="dropdown-item employeeProfilePrint" href="#" id="{{$employee->id}}">Print</a>
                                                                        <a class="dropdown-item employeeIdCardPrint" href="#" id="{{$employee->id}}">ID Print</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="mt-1">
                                                {{ $employees->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            <div>
        </div>
    </div>
</div>
{{-- modal --}}
    <div class="modal fade bd-example-modal-lg" id="employeeProfileViewModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="employeeProfileDetails">

            </div>
          </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg modal-for-idCard" id="employeeProfileEitModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-for-idCard-body" role="document">
          <div class="modal-content">
            <div id="employeeProfileEdit">

            </div>
          </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="employeeProfilePrintModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="employeeProfilePrintShow">

            </div>
          </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="employeeIdCardPrintModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="employeeIdCardPrintShow">

            </div>
          </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="studentProfileAdd" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <section class="print-hideen border-bottom">
                <div class="d-flex flex-row-reverse">
                    <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                    {{-- <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-success"><i class="bx bx-edit"></i></a></div>
                    <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
                    <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
                    <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
                </div>
            </section>
            {{-- @include('backend.tab-file.modal-header-info') --}}
            @include('backend.employee.create-modal')
            @include('backend.tab-file.modal-footer-info')
          </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="employeeProfileListPrintModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="employeeProfilePrintListContent">

            </div>
          </div>
        </div>
    </div>
@endsection
@push('js')
<script>
    function printFunction(){
        window.print();
    }
    $(document).on("click", "#employeeProfileList", function(e){
        e.preventDefault();
        $.ajax({
            url: "{{URL('employee-profile-list-print')}}",
            type: "post",
            cache: false,
            data:{
                _token:'{{ csrf_token() }}',
            },
            success: function(response){
                document.getElementById("employeeProfilePrintListContent").innerHTML = response;
                $('#employeeProfileListPrintModal').modal('show');
                setTimeout(printFunction, 500);
            }
        });
    });
    $(document).on("click", ".employeeViewProfile", function(e) {
        e.preventDefault();
        var id= $(this).attr('id');
        $.ajax({
            url: "{{URL('employee-view-profile-modal')}}",
            type: "post",
            cache: false,
            data:{
                _token:'{{ csrf_token() }}',
                id:id,
            },
            success: function(response){
                document.getElementById("employeeProfileDetails").innerHTML = response;
                $('#employeeProfileViewModal').modal('show');
                $('.common-select2').select2();
            }
        });
    });
    $(document).on("click", ".employeeEditProfile", function(e) {
        e.preventDefault();
        var id= $(this).attr('id');
        $.ajax({
            url: "{{URL('employee-edit-profile-modal')}}",
            type: "post",
            cache: false,
            data:{
                _token:'{{ csrf_token() }}',
                id:id,
            },
            success: function(response){
                document.getElementById("employeeProfileEdit").innerHTML = response;
                $('#employeeProfileEitModal').modal('show');
                $('.common-select2').select2();
            }
        });
    });
    $(document).on("click", ".employeeProfilePrint", function(e) {
        e.preventDefault();
        var id= $(this).attr('id');
        $.ajax({
            url: "{{URL('employee-print-profile-modal')}}",
            type: "post",
            cache: false,
            data:{
                _token:'{{ csrf_token() }}',
                id:id,
            },
            success: function(response){
                document.getElementById("employeeProfilePrintShow").innerHTML = response;
                $('#employeeProfilePrintModal').modal('show');
                $('.common-select2').select2();
                setTimeout(printFunction, 500);
            }
        });
    });
    $(document).on("click", ".employeeIdCardPrint", function(e) {
        e.preventDefault();
        var id= $(this).attr('id');
        $.ajax({
            url: "{{URL('employee-print-idCard-modal')}}",
            type: "post",
            cache: false,
            data:{
                _token:'{{ csrf_token() }}',
                id:id,
            },
            success: function(response){
                document.getElementById("employeeIdCardPrintShow").innerHTML = response;
                $('#employeeIdCardPrintModal').modal('show');
                $('.common-select2').select2();
            }
        });
    });
    $('.img-type').change(function () {
    var ext = this.value.match(/\.(.+)$/)[1];
    switch (ext) {
        case 'jpg':
        case 'jpeg':
        case 'png':
            $('#uploadButton').attr('disabled', false);
            break;
        default:
            alert('This is not an allowed file type.');
            this.value = '';
    }
});
</script>
@endpush
