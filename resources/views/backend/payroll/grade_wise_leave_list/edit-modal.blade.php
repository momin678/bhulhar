<div class="modal-header">
    <h5 class="p-0" style="font-family:Cambria;font-size: 2rem;"><b>Grade Wise Leave List Edit</b></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <div class="" >
        <div class="content-body p-1">
            <form action="{{route('grade-wise-leave-list.update', $leave_info->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="cardStyleChange">
                    <div class="row px-1">
                        <div class="col-sm-3 col-12 changeColStyle emp-select">
                            <label for="mode">Grade <sup class="text-danger">*</sup></label>
                            <select name="grade_id" id="grade_id" class="form-control" style="" required>
                                <option value="">Select grade</option>
                                @foreach ($grades as $grade)
                                    <option value="{{$grade->id}}" {{ ($leave_info->grade_id == $grade->id)?'selected':'' }}>{{$grade->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3 col-12 changeColStyle">
                            <label for="mode">Casual Leave<sup class="text-danger">*</sup></label>
                            <input type="number" class="form-control inputFieldHeight" name="casual_leave" value="{{ $leave_info->casual_leave }}" id="casual_leave" required>
                        </div>
                        <div class="col-sm-3 col-12 changeColStyle">
                            <label for="mode">Sick Leave<sup class="text-danger">*</sup></label>
                            <input type="number" class="form-control inputFieldHeight" name="sick_leave" value="{{ $leave_info->sick_leave }}" id="sick_leave" required>
                        </div>
                        <div class="col-sm-3 col-12 changeColStyle">
                            <label for="mode">Anual Leave<sup class="text-danger">*</sup></label>
                            <input type="number" class="form-control inputFieldHeight" name="anual_leave" value="{{ $leave_info->anual_leave }}" id="anual_leave" required>
                        </div>
                        <div class="col-12 col-md-12 d-flex justify-content-end changeColStyle mb-1 mt-1">
                            <p class="text-right"><button class="btn btn-info mt-1" type="submit">SUBMIT</button></p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
