    <h4>Account Head Details</h4>
    @isset($masterAcc)
    <form action="{{ route('accHeahDetailsPost', $masterAcc) }}" method="POST">
    @else
    <form action="{{ route('accHeahDetailsPost') }}" method="POST">
    @endisset
        @csrf
        <div class="row p-1">
            <div class="col-md-2 changeColStyle">
                <label>A/C Code</label>
                <input type="text" id="MA_Code" class="inputFieldHeight form-control" name="MA_Code" value="{{ isset($masterAcc) ? $masterAcc->mst_ac_code."-".$subCode : '' }}" placeholder="Master A/C Code" readonly disabled>
                @error('MA_Code')
                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-2 changeColStyle">
                <label>A/C Head</label>
                <input type="text" id="fld_ac_head" class="inputFieldHeight form-control" name="fld_ac_head" placeholder="A/C Head" required>
                @error('fld_ac_head')
                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-2 changeColStyle">
                <label>Master A/C Head</label>
                <input type="text" name="fld_Master_ACHead" class="inputFieldHeight form-control" value="{{ isset($masterAcc) ? $masterAcc->mst_ac_head : '' }}" id="" readonly disabled>
            </div>
            <div class="col-md-3 changeColStyle">
                <label>Definition</label>
                <input type="text" name="fld_Defination" class="inputFieldHeight form-control"
                value="{{ isset($masterAcc) ? $masterAcc->mst_definition : '' }}" id=""
                readonly disabled>
            </div>
            <div class="col-md-3 d-flex justify-content-end mt-2">
                <button type="submit" class="btn btn-primary mr-1 formButton mb-1" title="Form Save">
                    <div class="d-flex">
                        <div class="formSaveIcon">
                            <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                        </div>
                        <div><span> Save</span></div>
                    </div>
                </button>
                <button type="reset" class="btn btn-light-secondary formButton mb-1" title="Form Reset">
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
    </form>
