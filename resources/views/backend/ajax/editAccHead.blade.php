<div class="col-12">
    <h4>Account Head Details</h4>
    <form action="{{ route('accHeahEditPost', $account_head) }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-1 changeColStyle">
                <label>A/C Code</label>
                <input type="text" id="MA_Code" class="form-control inputFieldHeight" name="MA_Code" value="{{ isset($account_head) ? $account_head->fld_ac_code : '' }}"  placeholder="Master A/C Code" readonly disabled>
                @error('ma_code')
                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-3 changeColStyle">
                <label>A/C Head</label>
                <input type="text" id="fld_ac_head" class="form-control inputFieldHeight" name="fld_ac_head" value="{{ isset($account_head) ? $account_head->fld_ac_head : '' }}" placeholder="A/C Head" required readonly>
                @error('fld_ac_head')
                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-2 changeColStyle">
                <label>Master A/C Head</label>
                <input type="text" name="fld_Master_ACHead" class="form-control inputFieldHeight"  value="{{ isset($account_head) ? $account_head->fld_ms_ac_head : '' }}" id="" readonly disabled>
            </div>
            <div class="col-md-2 changeColStyle">
                <label>Definition</label>
                <input type="text" name="fld_Defination" class="form-control inputFieldHeight" value="{{ isset($account_head) ? $account_head->fld_definition : '' }}" id="" readonly disabled>
            </div>
            <div class="col-md-4 d-flex justify-content-end mt-2">
                <button type="button" class="btn btn-primary mr-1 formButton mTestEditBotton" title="Form Save" id="mTestEditBotton">
                    <div class="d-flex">
                        <div class="formSaveIcon">
                            <img  src="{{asset('assets/backend/app-assets/icon/edit-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                        </div>
                        <div><span> Edit</span></div>
                    </div>
                </button>
                <button type="submit" class="btn btn-primary mr-1 formButton" title="Form Save">
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
    </form>
</div>

<script>
    // let mTestEditBotton = document.getElementByClassName("mTestEditBotton");
    let fld_ac_head = document.getElementById("fld_ac_head");
    $(document).on('click', '.mTestEditBotton', function(e){
        // alert(3432);
        e.preventDefault();
        fld_ac_head.removeAttribute("readonly");
    });
</script>
