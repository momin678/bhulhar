<style>
    .card-body {
        margin-bottom: 16px;
    }
    .card {
        margin-bottom: 1px;
    }
</style>

<div class="modal-body">
    <div class="card-body">
        <form action="{{route('employee-history.update', $history->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="cardStyleChange">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="row px-1">
                                    <div class="row" style="margin-right: -3px; margin-left: 0px;">
                                        <div class="col-md-12">
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-2 col-12 changeColStyle">
                                                    <label for="mode">Employee name <sup class="text-danger">*</sup></label>
                                                    <select name="employee_id" id="employee_id" class="form-control common-select2" style="width: 100% !important" required>
                                                        <option value="">Select ...</option>
                                                        @foreach ($employees as $employee)
                                                            <option value="{{$employee->id}}" {{$employee->id == $history->emp_id?'selected':''}}>{{$employee->first_name.' '.$employee->last_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-2 col-12 changeColStyle">
                                                    <label for="mode">History <sup class="text-danger">*</sup></label>
                                                    <input type="text" class="form-control inputFieldHeight" name="history" value="{{$history->history}}" id="hoistory"
                                                        required >
                                                </div>
                                                <div class="col-sm-1 col-12 changeColStyle">
                                                    <label for="mode">Remark <sup class="text-danger">*</sup></label>
                                                    <input type="text" class="form-control inputFieldHeight" name="remark" value="{{$history->remark}}" id="remark" required >
                                                </div>
                                                <div class="col-sm-2 col-12 changeColStyle">
                                                    <label for="mode">Approved By <sup class="text-danger">*</sup></label>
                                                    <input type="text" class="form-control inputFieldHeight" name="approved_by" value="{{$history->approved_by}}" id="approved_by" required >
                                                </div>
                                                <div class="col-sm-2 col-12 changeColStyle">
                                                    <label for="mode">Employee Image <sup class="text-danger">*</sup></label>
                                                    <input type="file" class="form-control inputFieldHeight" name="file" id="file" value="{{old('m_emirates_id_upload')}}" class="inputFieldHeight form-control @error('m_emirates_id_upload') error @enderror" onchange="motherEmirateImgChange()" required>
                                                </div>
                                                <input type="hidden" class="form-control inputFieldHeight" name="document" value="{{$history->document}}" >
                                                <div class="col-sm-2 col-12 changeColStyle">
                                                    @if ($history->extension == 'pdf')
                                                        <a href="{{ asset('storage/upload/employee_history/'.$history->document)}}"  target="_blank">

                                                            <img src="{{ asset('assets/backend/app-assets/icon/pdf-download-icon-2.png')}}" style="height:60px" class="img-fluid" alt="{{ asset('assets/backend/app-assets/icon/pdf-download-icon-2.png')}}" >
                                                        </a>
                                                    @else
                                                        <a href="{{ asset('storage/upload/employee_history/'.$history->document)}}" target="_blank">
                                                            <img src="{{ asset('storage/upload/employee_history/'.$history->document)}}" style="height:60px" class="img-fluid" alt=" {{asset('storage/upload/employee_history/').$history->document }}" >
                                                        </a>
                                                    @endif
                                                </div>
                                                <div class="col-sm-1 col-12 changeColStyle">
                                                    <button type="submit" class="btn mr-1 btn-primary float-right formButton mt-0"  style="padding: 5px" title="Form Save">
                                                        <div class="d-flex">
                                                            {{-- <div class="formSaveIcon">
                                                                <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="15">
                                                            </div> --}}
                                                            <div><span> UPDATE</span></div>
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
