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
        {{-- <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-secondary employeeLeavePrint" id="{{$leave->id}}"><i class='bx bx-printer'></i></a></div> --}}
        {{-- <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
        <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
    </div>
</section>
<div class="content-body">
    <form class="form form-vertical"  action="{{route('leave-management.update', $leave->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="cardStyleChange">
                        <div class="card-body">
                            <div class="form-body">
                                <h4>Employee Leave Edit</h4>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                        <label>Employee Name</label>
                                       <input type="text"  value="{{$leave->emp->name}}" name="employee_name" class="inputFieldHeight form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                        <label>Employee ID Number</label>
                                        <input type="text" name="employee_id" value="{{$leave->employee_id}}" class="inputFieldHeight form-control" value="" id="employee_id" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-12 changeColStyle emp-select">
                                        <label for="mode">Leave Type <sup class="text-danger">*</sup></label>
                                        <select name="leave_type" id="leave_type" class="form-control common-select2" style="width: 100% !important" required>
                                            <option value="">Select type</option>
                                            <option value="casual" {{$leave->leave_type == 'casual'? 'selected':''}}>Casual</option>
                                            <option value="sick" {{$leave->leave_type == 'sick'?'selected':''}}>Sick</option>
                                            <option value="anual" {{$leave->leave_type == 'anual'?'selected':''}}>Anual</option>
                                            <option value="without_pay" {{$leave->leave_type == 'without_pay'?'selected':''}}>Without pay</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                        <label>From Date</label>
                                        <input type="date" name="from_date" value="{{$leave->from_date}}" placeholder="dd/mm/yyyy" required class="inputFieldHeight form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                        <label>To Date</label>
                                        <input type="date" name="to_date" value="{{$leave->to_date}}"  placeholder="dd/mm/yyyy" required class="inputFieldHeight form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                        <label>Days leave</label>
                                        <input type="number" name="days"  class="inputFieldHeight form-control" value="{{$leave->days_leave}}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                        <label>Leave Reason</label>
                                        <input type="text" name="leave_reason"  value="{{$leave->leave_reason}}" placeholder="Leave Reason"  class="inputFieldHeight form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Documents</label>
                                        <input type="file" class="form-control inputFieldHeight" name="files[]" multiple >
                                        @error('file')
                                        <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-10">
                                        <div class="row data">
                                                @foreach($others as $others)
                                                    <div class="col-md-1 img" >
                                                        {{-- <a href=""   class="close delete-img"></a> --}}
                                                {{-- <span data_target="{{ route('othersDelete', $others->id) }}" class="close delete-img" >&times;</span> --}}
                                                        <span class="btn btn-warning invoice-item-delete" id="" data_target="{{ route('employeeLeaveDocumentDelete',$others) }}"><i class="bx bx-trash"></i></span>

                                                            @if ($others->extension == 'pdf')
                                                                <a href="{{ asset('storage/upload/employee-leave/'.$others->filename)}}"  target="_blank">

                                                                    <img src="{{ asset('assets/backend/app-assets/icon/pdf-download-icon-2.png')}}" style="height:60px" class="img-fluid" alt="" >
                                                                </a>
                                                            @else
                                                                <a href="{{ asset('storage/upload/employee-leave/'.$others->filename)}}" target="_blank">
                                                                    <img src="{{ asset('storage/upload/employee-leave/'.$others->filename)}}" style="height:60px" class="img-fluid" alt="" >
                                                                </a>
                                                            @endif
                                                    </div>
                                                @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-end">
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
