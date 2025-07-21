<div class="col-12">
    <div class="card">
        <div class="row px-1">
            <div class="col-sm-4 col-12 changeColStyle">
                <label for="mode">Casual Leave Entitled</label>
                <input type="text" class="form-control inputFieldHeight each-item text-align-center" name="" value="{{$entitled?$entitled->casual_leave:0}}" id="basic" readonly>
            </div>
            <div class="col-sm-4 col-12 changeColStyle">
                <label for="mode">Sick Leave Entitled</label>
                <input type="text" class="form-control inputFieldHeight each-item" name="" value="{{$entitled?$entitled->sick_leave:0}}" readonly>
            </div>
            <div class="col-sm-4 col-12 changeColStyle">
                <label for="mode"> Anual Leave Entitled</label>
                <input type="text" class="form-control inputFieldHeight each-item" name="" value="{{$entitled?$entitled->anual_leave:0}}" readonly>
            </div>
        </div>
    </div>
</div>