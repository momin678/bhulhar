<div>
    <style>
        img {
                margin-top: 10px;
                border: 0;
            }
        .btn  {
            padding: 14px 18px;
            padding: 1rem 1.8rem;
            line-height: 2;
            margin-top: 30px;
        }
        .card {
            margin-bottom: 1px;
        }
    </style>

    {{-- **************** Employees create modal start************************ --}}


            <div class="modal fade bd-example-modal-lg" id="employee-history-modal" style="width: 100%;    width: 85%;
            left: 12%" tabindex="-1" rrole="dialog" aria-labelledby="employee-history-modal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="padding-right: 0px !important">
            <div class="modal-content mt-5">
                <section class="print-hideen border-bottom" style="padding: 10px;">
                    <div class="row">
                        <div class="col-6">
                            <h5 style="font-family:Cambria;font-size: 2.3rem;"><b>Employee History</b> </h5>
                        </div>
                        <div class="col-6">
                            <div class="d-flex flex-row-reverse">

                                <div class="mIconStyleChange"><a href="#" class="close btn-icon  btn-danger mIconStyleChange212 mt-0  rounded" style="padding: 5px" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                                {{-- <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
                                <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
                                <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
                            </div>
                        </div>
                    </div>
                </section>
                <div class="modal-body" style="padding-bottom:15px;">
                    <div class="" >
                        <form action="{{route('employee-history.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="cardStyleChange">
                                    <div class="row">
                                        <div class="col-12" >
                                            <div class="">
                                                <div class="row px-1">
                                                    <div class="row" style="margin-right: -3px; margin-left: 0px;">
                                                        <div class="col-md-12">
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-4 col-12 changeColStyle">
                                                                    <label for="mode">Employee name <sup class="text-danger">*</sup></label>
                                                                    <select name="employee_id" id="employee_id" class="form-control common-select2" style="width: 100% !important" required>
                                                                        <option value="">Select ...</option>
                                                                        @foreach ($employees as $employee)
                                                                            <option value="{{$employee->id}}">{{$employee->first_name.' '.$employee->last_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4 col-12 changeColStyle">
                                                                    <label for="mode">History <sup class="text-danger">*</sup></label>
                                                                    <input type="text" class="form-control inputFieldHeight" name="history" id="hoistory"
                                                                       required >
                                                                </div>
                                                                <div class="col-md-4 col-12 changeColStyle">
                                                                    <label for="mode">Remark <sup class="text-danger">*</sup></label>
                                                                    <input type="text" class="form-control inputFieldHeight" name="remark" id="remark" required >
                                                                </div>
                                                                <div class="col-md-4 col-12 changeColStyle">
                                                                    <label for="mode">Approved By <sup class="text-danger">*</sup></label>
                                                                    <input type="text" class="form-control inputFieldHeight" name="approved_by" id="approved_by" required >
                                                                </div>
                                                                <div class="col-md-4 col-12 changeColStyle">
                                                                    <label for="mode">Employee Image <sup class="text-danger">*</sup></label>
                                                                    <input type="file" class="form-control inputFieldHeight" name="file" id="file" value="{{old('m_emirates_id_upload')}}" class="inputFieldHeight form-control @error('m_emirates_id_upload') error @enderror" onchange="motherEmirateImgChange()" required>
                                                                </div>
                                                                <div class="col-md-4 col-12 d-flex justify-content-end">
                                                                    <button type="submit" class="btn btn-sm btn-primary formButton" style="padding: 5px;" title="Form Save">
                                                                        <div class="d-flex">
                                                                        <div class="formSaveIcon">
                                                                            <img src="{{ asset('assets/backend/app-assets/icon/save-icon.png') }}" alt="" srcset="" width="25">
                                                                        </div>
                                                                        <div><span style="font-size: 12px">SUBMIT</span></div>
                                                                        </div>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- **************** Employees create modal end ************************ --}}

    {{-- **************** Employees edit modal ************************ --}}

            <div class="modal fade bd-example-modal-lg" id="employee-modal-edit" style="width: 100%;    width: 85%;
            left: 12%" tabindex="-1" rrole="dialog" aria-labelledby="employee-modal-edit" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="padding-right: 0px !important">
            <div class="modal-content mt-5">
                <section class="print-hideen border-bottom" style="padding: 10px;">
                    <div class="row">
                        <div class="col-6">
                            <h5 style="font-family:Cambria;font-size: 2.3rem;"><b>History </b> </h5>
                        </div>
                        <div class="col-6">
                            <div class="d-flex flex-row-reverse">

                                <div class="mIconStyleChange"><a href="#" class="close btn-icon  btn-danger mIconStyleChange212 mt-0  rounded" style="padding: 5px" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                                {{-- <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
                                <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
                                <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
                            </div>
                        </div>
                    </div>
                </section>
            <div class="modal-content" id="edit-modal">



            </div>
        </div>
    </div>
    {{-- **************** Employees  edit  modal end ************************ --}}
</div>
