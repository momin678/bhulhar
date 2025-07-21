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
        input[type=text], input[type=file]{
            border: 1px solid #a1a1a1;
            height: 40px;
            height: 3.2rem;
        }
    </style>
    {{-- **************** Employees create modal start************************ --}}

    <div class="modal fade" style="width: 80%;left: 10%; top: -40px" id="employee-modal" tabindex="-1"
        role="dialog" aria-labelledby="employee-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="height: 50px">
                    <div class="row">
                        <div class="col-md-10">
                            <h5 class="modal-title">Deduction</h5>
                        </div>
                        <div class="col-md-12 text-right">
                            <button type="botton" style="margin-top: -34px;" class="btn btn-sm " data-dismiss="modal">
                                <span aria-hidden="true" class="icon-style">&times;</span></button>
                        </div>
                    </div>
                </div>
                <div class="modal-body" style="padding-bottom:15px;">
                    <div class="card-body" >
                        <form action="{{route('deduction-entry.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="cardStyleChange">
                                    <div class="row">
                                        <div class="col-12" >
                                            <div class="card">
                                                <div class="row px-1">
                                                    <div class="row" style="margin-right: -3px; margin-left: 0px;">
                                                        <div class="col-md-12">
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-sm-3 col-12 changeColStyle">
                                                                    <label for="mode">Employee name <sup class="text-danger">*</sup></label>
                                                                    <select name="employee_id" id="employee_id" class="form-control common-select2" style="width: 100% !important" required>
                                                                        <option value="">Select ...</option>
                                                                        @foreach ($employees as $employee)
                                                                            <option value="{{$employee->id}}">{{$employee->first_name.' '.$employee->last_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-3 col-12 changeColStyle">
                                                                    <label for="mode">Description <sup class="text-danger">*</sup></label>
                                                                    <input type="text" class="form-control inputFieldHeight" name="description" id="description" 
                                                                       required >
                                                                </div>
                                                                <div class="col-sm-2 col-12 changeColStyle">
                                                                    <label for="mode">Amount <sup class="text-danger">*</sup></label>
                                                                    <input type="number" class="form-control inputFieldHeight" name="amount" id="amount" required >
                                                                </div>
                                                                <div class="col-sm-2 col-12 changeColStyle">
                                                                    <label for="mode">Date <sup class="text-danger">*</sup></label>
                                                                    <input type="text" class="form-control" min="2020" name="date" placeholder="DD/MM/YY" id="datepickers" required>
                                                                </div>
                                                                <div class="col-sm-2 col-12 changeColStyle">
                                                                    <label for="mode">Document</label>
                                                                    <input type="file" class="form-control inputFieldHeight" name="file" id="file" value="{{old('m_emirates_id_upload')}}">
                                                                </div>
                                                                <div class="col-sm-2 col-12 changeColStyle float-right">
                                                                    <button type="submit" class="btn mr-1 btn-primary formButton" title="Form Save">
                                                                        <div class="d-flex">
                                                                            <div><span> SUBMIT</span></div>
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

    <div class="modal fade" style="width: 80%;left: 10%; top: -40px; overflow-y: hidden;" id="employee-modal-edit" tabindex="-1"
        role="dialog" aria-labelledby="employee-modal-edit" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mt-5" role="document">
            <div class="modal-content" id="edit-modal">
                
                       
            </div>
        </div>
    </div>
    {{-- **************** Employees  edit  modal end ************************ --}}
</div>
