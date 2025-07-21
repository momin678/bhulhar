<section class="print-hideen border-bottom">
    <div class="d-flex flex-row-reverse">
        <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
        {{-- <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-success"><i class="bx bx-edit"></i></a></div> --}}
        {{-- <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-secondary employeeLeavePrint" id="{{$leave->id}}"><i class='bx bx-printer'></i></a></div> --}}
        {{-- <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
        <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
    </div>
</section>
<div class="content-body p-1">
    <form action="{{route('employee-history.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="cardStyleChange">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="row px-1">
                                <div class="col-sm-12 col-12 changeColStyle pt-1" style="background: #96195F">
                                    <h5 style="color: white">Employee History ADD :</h5>
                                </div>
                                <div class="row" style="margin-right: -3px; margin-left: 0px;">
                                    <div class="col-md-12">
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-3 col-12 changeColStyle">
                                                <label for="mode">Employee name <sup class="text-danger">*</sup></label>
                                                <select name="employee_id" id="employee_id" class="form-control common-select2" style="width: 100% !important" required>
                                                    <option value="">Select ...</option>
                                                    @foreach ($employees as $employee)
                                                        <option value="{{$employee->id}}">{{$employee->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-3 col-12 changeColStyle">
                                                <label for="mode">History <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="history" id="hoistory" 
                                                   required >
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Remark <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="remark" id="remark" required >
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Approved By <sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control inputFieldHeight" name="approved_by" id="approved_by" required >
                                            </div>
                                            <div class="col-sm-2 col-12 changeColStyle">
                                                <label for="mode">Employee Image <sup class="text-danger">*</sup></label>
                                                <input type="file" class="form-control inputFieldHeight" name="file" id="file" value="{{old('m_emirates_id_upload')}}" class="inputFieldHeight form-control @error('m_emirates_id_upload') error @enderror" onchange="motherEmirateImgChange()" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 d-flex justify-content-end changeColStyle mb-1 mt-1">
                    <button type="submit" class="btn mr-1 btn-primary formButton" title="Form Save">
                        <div class="d-flex">
                            <div class="formSaveIcon">
                                <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                            </div>
                            <div><span> Save</span></div>
                        </div>
                    </button>
                    {{-- <button type="reset" class="btn btn-light-secondary formButton" title="Form Reset">
                        <div class="d-flex">
                            <div class="formRefreshIcon">
                                <img  src="{{asset('assets/backend/app-assets/icon/refresh-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                            </div>
                            <div><span> Reset</span></div>
                        </div>
                    </button> --}}
                </div>
            </div>
        </div>
    </form>
</div>

