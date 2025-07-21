<div>

    <div class="modal fade" style="width: 60%;left: 20%; top: -40px;" id="employee-history-modal" tabindex="-1"
        role="dialog" aria-labelledby="employee-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content mt-5">
                <div class="modal-header">
                    <h5 class="p-0" style="font-family:Cambria;font-size: 2rem;"><b>Grade Wise Leave List</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <form action="{{route('grade-wise-leave-list.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="cardStyleChange">
                                <div class="row px-1">
                                    <div class="col-sm-3 col-12 changeColStyle emp-select">
                                        <label for="mode">Grade <sup class="text-danger">*</sup></label>
                                        <select name="grade_id" id="grade_id" class="form-control common-select2" style="width: 100% !important" required>
                                            <option value="">Select grade</option>
                                            @foreach ($grades as $grade)
                                                <option value="{{$grade->id}}">{{$grade->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3 col-12 changeColStyle">
                                        <label for="mode">Casual Leave<sup class="text-danger">*</sup></label>
                                        <input type="number" class="form-control inputFieldHeight" name="casual_leave" id="casual_leave" required>
                                    </div>
                                    <div class="col-sm-3 col-12 changeColStyle">
                                        <label for="mode">Sick Leave<sup class="text-danger">*</sup></label>
                                        <input type="number" class="form-control inputFieldHeight" name="sick_leave" id="sick_leave" required>
                                    </div>
                                    <div class="col-sm-3 col-12 changeColStyle">
                                        <label for="mode">Anual Leave<sup class="text-danger">*</sup></label>
                                        <input type="number" class="form-control inputFieldHeight" name="anual_leave" id="anual_leave" required>
                                    </div>
                                    <div class="col-12 col-md-12 d-flex justify-content-end changeColStyle">

                                                <p class="text-right"><button class="btn btn-info mt-1" type="submit">SUBMIT</button></p>

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
                </div>
            </div>
        </div>
    </div>
    {{-- **************** Employees create modal end ************************ --}}

    {{-- **************** Employees edit modal ************************ --}}

    <div class="modal fade" style="width: 60%;left: 20%; top: -40px; overflow-y: hidden;" id="employee-modal-edit" tabindex="-1"
        role="dialog" aria-labelledby="employee-modal-edit" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mt-5 modal-lg" role="document">
            <div class="modal-content" id="edit-modal">


            </div>
        </div>
    </div>
    {{-- **************** Employees  edit  modal end ************************ --}}
</div>
