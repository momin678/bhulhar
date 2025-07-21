<style>
    .commonSelect2Style span{
        width: 100% !important;
    }
    .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b{
        display: none;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b{
        display: none;
    }
</style>
@extends('layouts.backend.app')
@section('content')
@include('backend.tab-file.style')

<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
                <a href="{{route("students-attendance")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/student-icon.png')}}" alt="" srcset="" class="img-fluid" width="55">
                    </div>
                    <div>Students Attendance</div>
                </a>
                <a href="{{route("new-student-leave")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/document-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>&nbsp;&nbsp;&nbsp;&nbsp;Students Leave&nbsp;&nbsp;&nbsp;&nbsp;</div>
                </a>
                <a href="{{route('new-employee-attendance')}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="parentProfileTab">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/employee-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Employees Attendance</div>
                </a>
                <a href="{{route("new-employee-leave")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/leave-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div> Employees Leave </div>
                </a>
                <a href="{{route("student-early-leave.index")}}" class="nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/exam-icon.png')}}" alt="" srcset="" class="img-fluid" width="57">
                    </div>
                    <div>&nbsp;&nbsp;&nbsp;&nbsp;Early Leave&nbsp;&nbsp;&nbsp;&nbsp;</div>
                </a>
            </div>
            <div class="tab-content bg-white">
                <div class="tab-pane active">
                    <div class="content-body">
                        <div class="row" id="table-bordered">
                            <div class="col-12">
                                <div class="cardStyleChange">
                                    <div class="d-flex card-header">
                                        <h4 class="flex-grow-1">Employee Early Leave</h4>
                                        <button type="button" class="btn btn-primary btn_create formButton mr-1" title="Add" data-toggle="modal" data-target="#mNewEmployeeLeaveAdd">
                                            <div class="d-flex">
                                                <div class="formSaveIcon">
                                                    <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" width="25">
                                                </div>
                                                <div><span>Employee Early Leave Add</span></div>
                                            </div>
                                        </button>
                                        <a href="{{route('student-early-leave.index')}}">
                                            <button type="button" class="btn btn-light btn_create formButton" data-toggle="modal">
                                                <div class="d-flex">
                                                    <div><span>Student Early Leave</span></div>
                                                </div>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive" style="min-height: 200px;">
                                            <table class="table mb-0 table-sm table-hover">
                                                <thead  class="thead-light">
                                                    <tr style="height: 50px;">
                                                        <th>ID</th>
                                                        <th>Employee Name</th>
                                                        <th>From Time</th>
                                                        <th>To Time</th>
                                                        <th>Leave Time</th>
                                                        <th>Leave Reason</th>
                                                        <th class="text-center pl-2">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($employee_leaves as $employee_leave)
                                                        <tr class="border-bottom trFontSize">
                                                            <td>{{$employee_leave->employee_id}}</td>
                                                            <td>{{$employee_leave->employee_name}}</td>
                                                            <td>{{date('h:i A', strtotime($employee_leave->from_time))}}</td>
                                                            <td>{{date('h:i A', strtotime($employee_leave->to_time))}}</td>
                                                            <td>{{$employee_leave->days_leave}} days</td>
                                                            <td>{{$employee_leave->leave_reason}}</td>
                                                            <td class="float-right">
                                                                <div class="btn-group">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-top: 2px; padding-bottom: 2px; font-size: 12px; padding-left: 10px;">
                                                                            Actions
                                                                        </button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                            @if ($employee_leave->scan_copy == null)
                                                                            <a href="#" id="{{$employee_leave->id}}" class="dropdown-item employeeLeaveUploadScanCopy">Upload Scan Copy</a>
                                                                            @else
                                                                            {{-- <a href="#" id="{{$employee_leave->id}}" class="dropdown-item employeeLeaveDownloadScanCopy" >Download Scan Copy</a> --}}
                                                                            <a href="{{ asset('storage/upload/employee-early-leave-scan-copy/'.$employee_leave->scan_copy)}}" class="dropdown-item" target="_blank">Download Scan Copy</a>
                                                                            @endif
                                                                            <a href="#" id="{{$employee_leave->id}}" class="dropdown-item employeeLeavePrint">Print</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $employee_leaves->links() }}
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
</div>
<div class="modal fade bd-example-modal-lg" id="mNewEmployeeLeaveAdd" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
        @include('backend.tab-file.modal-header-info')
        @include('backend.employee-leave.new-create-modal')
        @include('backend.tab-file.modal-footer-info')
      </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="employeeLeavePrintModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div id="employeeLeavePrintShow">
          
        </div>
      </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="employeeLeavePrintModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div id="employeeLeavePrintShow">
          
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
    $(document).on("click", ".employeeLeavePrint", function(e) {
        e.preventDefault();
        var id= $(this).attr('id');
        $.ajax({
            url: "{{URL('employee-early-leave-print-modal')}}",
            type: "post",
            cache: false,
            data:{
                _token:'{{ csrf_token() }}',
                id:id,
            },
            success: function(response){
                document.getElementById("employeeLeavePrintShow").innerHTML = response;
                $('#employeeLeavePrintModal').modal('show');
                setTimeout(printFunction, 500);
            }
        });
    });
    $(document).on("click", ".employeeLeaveUploadScanCopy", function(e) { 
        e.preventDefault();
        var id= $(this).attr('id');
        $.ajax({
            url: "{{URL('employee-early-leave-upload-scan-copy-modal')}}",
            type: "post",
            cache: false,
            data:{
                _token:'{{ csrf_token() }}',
                id:id,
            },
            success: function(response){
                document.getElementById("employeeLeavePrintShow").innerHTML = response;
                $('#employeeLeavePrintModal').modal('show')
            }
        });
    });
    $(document).on("click", "#formSubmit", function(e) { 
        e.preventDefault();
        var employee_id = document.getElementById("select_id").value;
        var from_time = document.getElementById("from_time").value;
        var to_time = document.getElementById("to_time").value;
        var days_leave = document.getElementById("days_leave").value;
        var leave_reason = document.getElementById("leave_reason").value;
        $.ajax({
            url: "{{URL('employee-early-leave-store')}}",
            type: "post",
            cache: false,
            data:{
                _token:'{{ csrf_token() }}',
                employee_id:employee_id,
                from_time:from_time,
                to_time:to_time,
                days_leave:days_leave,
                leave_reason:leave_reason,
            },
            success: function(response){
                document.getElementById("employeeLeavePrintShow").innerHTML = response;
                $('#employeeLeavePrintModal').modal('show');
                setTimeout(printFunction, 500);
            }
        });
    });
</script>
<script>
    // employee fetch and set
    function employee(){
        var employee_id = document.getElementById("select_id").value;
        document.getElementById("employee_id").value = employee_id;
    }
</script>
@endpush