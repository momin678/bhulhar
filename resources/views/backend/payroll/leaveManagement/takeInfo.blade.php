<div class="col-12">
    <div class="card">
        <div class="row px-1">
            <div class="col-sm-4 col-12 changeColStyle">
                <label for="mode">Casual Leave Taken</label>
                <input type="text" class="form-control inputFieldHeight each-item text-align-center" name="" value="{{$takeInformation->where('leave_type', 'casual')->sum('days_leave')}}" id="basic" readonly>
            </div>
            <div class="col-sm-4 col-12 changeColStyle">
                <label for="mode">Sick Leave Taken</label>
                <input type="text" class="form-control inputFieldHeight each-item" name="" value="{{$takeInformation->where('leave_type', 'sick')->sum('days_leave')}}" readonly>
            </div>
            <div class="col-sm-4 col-12 changeColStyle">
                <label for="mode"> Anual Leave Taken</label>
                <input type="text" class="form-control inputFieldHeight each-item" name="" value="{{$takeInformation->where('leave_type', 'anual')->sum('days_leave')}}" readonly>
            </div>
        </div>
    </div>
</div>