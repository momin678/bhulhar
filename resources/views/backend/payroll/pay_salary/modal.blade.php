<div>
    @php
        use Carbon\CarbonPeriod;
    @endphp
    {{-- **************** Employees create modal start************************ --}}
    {{-- **************** Employees create modal end ************************ --}}

    {{-- **************** Employees create modal start************************ --}}
    <div class="modal fade"  id="payslip-modal" tabindex="-1"
        role="dialog" aria-labelledby="employee-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="p-0" style="font-family:Cambria;font-size: 2rem;"> <b>PAYSLIP GENERATION</b> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <form action="{{route('generate-payslip')}}" method="get" target="_blank" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-1">
                                <label class="col-sm-2 col-form-label">GRADE</label>
                                <div class="col-sm-4">
                                    <select name="grade" id="" class="inputFieldHeight form-control pl-1">
                                        <option value="">Select grade</option>
                                        @foreach($grades as $date)
                                            <option value="{{ $date->id }}">
                                                {{ $date->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-sm-2 col-form-label">EMPLOYEE</label>
                                <div class="col-sm-4">
                                    <select name="employee" id="" class="inputFieldHeight form-control common-select2 w-100">
                                        <option value="">Select employee</option>
                                        @foreach($employees as $date)
                                        <option value="{{ $date->id }}">
                                                {{ $date->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <label class="col-sm-2 col-form-label">MONTH<sup class="text-danger">*</sup></label>
                                <div class="col-sm-4">
                                    <select name="month" id="" class="inputFieldHeight form-control" required>
                                        <option value="">Select month</option>
                                        @foreach(CarbonPeriod::create(now()->startOfMonth(), '1 month', now()->addMonths(11)->startOfMonth()) as $date)
                                        <option value="{{ $date->format('F') }}" {{$date->format('F') == Date('F')?'selected':''}}>
                                                {{ $date->format('F') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-sm-2 col-form-label">YEAR <sup class="text-danger">*</sup></label>
                                <div class="col-sm-4">
                                    <select name="year" class="inputFieldHeight form-control" id="" required>
                                        @for($i=date('Y')-2;date('Y')+2>$i;$i++)
                                            <option value="{{$i}}" {{ $i == date('Y')?'selected':'' }}>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <button  type="submit" class="btn btn-primary">Submit</button>
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

    <div class="modal fade" style="width: 100%;" id="employee-modal-edit" tabindex="-1"
        role="dialog" aria-labelledby="employee-modal-edit" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" id="edit-modal">


            </div>
        </div>
    </div>
    {{-- **************** Employees  edit  modal end ************************ --}}
</div>
