<div class="content-body">
    <form class="form form-vertical"  action="{{route('employee-leave.store')}}" method="POST" enctype="multipart/form-data">
        @csrf 
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="cardStyleChange">
                        <div class="card-body">
                            <div class="form-body">
                                <h4 class="card-title">Employee Leave</h4>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                        <label>Employee Name</label>
                                        <select name="employee_name" class="inputFieldHeight form-control" required onchange="employee()" id="select_id">
                                            <option value="">Select Name</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{$employee->id}}">{{$employee->fname}} {{$employee->mname}}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>
                
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                        <label>Employee ID Number</label>
                                        <input type="text" name="employee_id" class="inputFieldHeight form-control" value="" id="employee_id">   
                                        </div>
                                    </div>
                
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                        <label>From Date</label>
                                        <input type="date" name="from_date" placeholder="dd/mm/yyyy" required class="inputFieldHeight form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                        <label>To Date</label>
                                        <input type="date" name="to_date" placeholder="dd/mm/yyyy" required class="inputFieldHeight form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                        <label>Days leave</label>
                                        <input type="text" name="days_leave" required class="inputFieldHeight form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                        <label>Leave Reason</label>
                                        <input type="text" name="leave_reason" placeholder="Leave Reason" required class="inputFieldHeight form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary btn_create formButton mt-2 mb-2" title="Add" data-toggle="modal" data-target="#mNewEmployeeLeaveAdd">
                                            <div class="d-flex">
                                                <div class="formSaveIcon">
                                                    <img src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" width="25">
                                                </div>
                                                <div><span>Save</span></div>
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