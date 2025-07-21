<style>
    @media print{
        
        html, body {
            height:100%; 
            overflow: hidden;
        }
    }
</style>
<section class="print-hideen border-bottom">
    <div class="d-flex flex-row-reverse">
        <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
        {{-- <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-success"><i class="bx bx-edit"></i></a></div> --}}
        <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-secondary employeeLeavePrint" id="{{$leave->id}}"><i class='bx bx-printer'></i></a></div>
        {{-- <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
        <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
    </div>
</section>
@include('backend.tab-file.modal-header-info')
<div class="content-body">
    <form class="form form-vertical"  action="{{route('employee-early-leave.update', $leave->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="cardStyleChange">
                        <div class="card-body">
                            <div class="form-body">
                                <h4>Employee Early Leave</h4>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                        <label>Employee Name</label>
                                       <input type="text" readonly value="{{$leave->employee_name}}" name="employee_name" class="inputFieldHeight form-control">
                                        </div>
                                    </div>
                
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                        <label>Employee ID Number</label>
                                        <input type="text" name="employee_id" value="{{$leave->employee_id}}" class="inputFieldHeight form-control" value="" id="employee_id" readonly>   
                                        </div>
                                    </div>
                
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                        <label>From Time</label>
                                        <input type="time" name="from_time" readonly value="{{$leave->from_time}}" placeholder="dd/mm/yyyy" required class="inputFieldHeight form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                        <label>To Time</label>
                                        <input type="time" name="to_time" value="{{$leave->to_time}}"  placeholder="dd/mm/yyyy" required class="inputFieldHeight form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                        <label>Leave time</label>
                                        <input type="number" name="days_leave" required class="inputFieldHeight form-control" value="{{$leave->days_leave}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                        <label>Leave Reason</label>
                                        <input type="text" name="leave_reason" readonly value="{{$leave->leave_reason}}" placeholder="Leave Reason" required class="inputFieldHeight form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                        <label>Scan Copy</label>
                                        <input type="file" name="scan_copy" placeholder="Leave Reason" required class="inputFieldHeight form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary btn_create formButton mt-2 mb-2" title="Update" >
                                            <div class="d-flex">
                                                <div class="formSaveIcon">
                                                    <img src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" width="25">
                                                </div>
                                                <div><span>Update</span></div>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                            
                </div>
            </div>
        </section>
    </form>
</div>
@include('backend.tab-file.modal-footer-info')