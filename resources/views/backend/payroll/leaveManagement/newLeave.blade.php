<div class="col-12">
    <div class="card">
        <div class="row px-1">
            <div class="col-sm-2 col-12 changeColStyle emp-select">
                <label for="mode">Leave Type <sup class="text-danger">*</sup></label>
                <select name="leave_type" id="leave_type" class="form-control common-select2" style="width: 100% !important" required>
                    <option value="">Select type</option>
                    <option value="casual">Casual</option>
                    <option value="sick">Sick</option>
                    <option value="anual">Anual</option>
                    <option value="without_pay">Without pay</option>
                </select>
            </div>
            <div class="col-sm-2 col-12 changeColStyle">
                <label for="mode">From Date </label>
                <input type="date" class="form-control inputFieldHeight sub-item" name="from_date" id="from_date" required>
            </div>
            <div class="col-sm-2 col-12 changeColStyle">
                <label for="mode">To Date </label>
                <input type="date" class="form-control inputFieldHeight sub-item" name="to_date" id="to_date" required>
            </div>
            <div class="col-sm-2 col-12 changeColStyle">
                <label for="mode">Days Leave </label>
                <input type="text" class="form-control inputFieldHeight sub-item" name="days" id="days" required>
            </div>
            <div class="col-sm-4 col-12 changeColStyle">
                <label for="mode">Leave Reason</label>
                <input type="text" class="form-control inputFieldHeight sub-item" name="leave_reason" id="leave_reason" required>
            </div>
            <div class="col-md-3">
                <label>Document</label>
                <input type="file" class="form-control inputFieldHeight" name="files[]" multiple >
                @error('file')
                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

    <div class="col-12">
        <div class="card">
            <div class="row px-1">
                <div class="col-12 col-md-12 d-flex justify-content-end changeColStyle mb-1 mt-1">
                    <button type="submit" class="btn mr-1 btn-primary formButton" title="Form Save">
                        <div class="d-flex">
                            <div class="formSaveIcon">
                                <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                            </div>
                            <div><span> Save</span></div>
                        </div>
                    </button>
                    <button type="reset" class="btn btn-light-secondary formButton" title="Form Reset">
                        <div class="d-flex">
                            <div class="formRefreshIcon">
                                <img  src="{{asset('assets/backend/app-assets/icon/refresh-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                            </div>
                            <div><span> Reset</span></div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
