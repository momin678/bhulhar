
    <div class="modal-header" style="height: 50px">
        <div class="row">
            <div class="col-md-10">
                <h5 class="modal-title">Deduction EDIT </h5>
            </div>
            <div class="col-md-12 text-right">

                <button type="botton" style="margin-top: -34px;" class="btn btn-sm " data-dismiss="modal">
                    <span aria-hidden="true" class="icon-style">&times;</span></button>
            </div>
        </div>
    </div>
    <div class="modal-body">
        <div class="card-body">
            <form action="{{route('deduction-entry.update', $info->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
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
                                                                <option value="{{$employee->id}}" {{$employee->id == $info->id?'selected':''}}>{{$employee->first_name.' '.$employee->last_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 col-12 changeColStyle">
                                                        <label for="mode">Description <sup class="text-danger">*</sup></label>
                                                        <input type="text" class="form-control inputFieldHeight" name="description" value="{{$info->description}}" id="description" 
                                                           required >
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Amount <sup class="text-danger">*</sup></label>
                                                        <input type="number" class="form-control inputFieldHeight" name="amount" value="{{$info->amount}}" id="amount" required >
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Date <sup class="text-danger">*</sup></label>
                                                        <input type="text" class="form-control" min="2020" name="date" value="{{date('d/m/Y', strtotime($info->date))}}" placeholder="DD/MM/YY" id="datepickers" required>
                                                    </div>
                                                    <div class="col-sm-2 col-12 changeColStyle">
                                                        <label for="mode">Document </label>
                                                        <input type="file" class="form-control inputFieldHeight" name="file" id="file" value="{{old('m_emirates_id_upload')}}" class="inputFieldHeight form-control @error('m_emirates_id_upload') error @enderror" onchange="motherEmirateImgChange()">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-2 col-12 changeColStyle ">
                                                        <button type="submit" class="btn mr-1 btn-primary formButton" title="Form Save">
                                                            <div class="d-flex">
                                                                <div><span> SUBMIT</span></div>
                                                            </div>
                                                        </button>
                                                    </div>
                                                    <div class="col-sm-10 col-12 changeColStyle ">
                                                        <a href="{{ asset('storage/upload/deduction-document/'.$info->document)}}" target="_blank">
                                                            <img src="{{ asset('storage/upload/deduction-document/'.$info->document)}}" style="height:60px; margin-right:10px; padding-top:10px" class="img-fluid float-right" alt="" >
                                                        </a>
                                                        <input type="hidden" name="old_image" value="{{$info->document}}">
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
            </form>>
        </div>
    </div>