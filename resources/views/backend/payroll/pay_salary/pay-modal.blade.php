@php
    use Carbon\CarbonPeriod;
@endphp

<div class="modal-header">

    <h5 class="p-0" style="font-family:Cambria;font-size: 2rem;"><b>PAYMENT</b></h5>

    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>

</div>

<div class="modal-body">
    <div class="">
        <div class="content-body pt-1">
            <form class="form form-vertical" action="{{route('pay-salary.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col-md-12 col-12">
                            <div class="cardStyleChange">
                                <div class="">
                                    <div class="form-body">
                                        {{-- <div class="row">
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="class-name">Month</label>
                                                    <select name="month" id="" class="inputFieldHeight form-control" required>
                                                        @foreach(CarbonPeriod::create(now()->startOfMonth(), '1 month', now()->addMonths(11)->startOfMonth()) as $date)
                                                            <option value="{{ $date->format('F') }}">
                                                                {{ $date->format('F') }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('month')
                                                        <span class="error">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="class-name">Year  </label>
                                                        <select name="year" class="inputFieldHeight form-control" id="" required>
                                                            @for($i=date('Y')-2;date('Y')+2>$i;$i++)
                                                                <option value="{{$i}}" {{ $i == date('Y')?'selected':'' }}>{{$i}}</option>
                                                            @endfor

                                                    </select>
                                                    @error('year')
                                                        <span class="error">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>                                         --}}

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-check mt-5">
                                                    <input class="form-check-input" style="margin-left: -15px" type="checkbox" id="checkall">
                                                    <label class="form-check-label" for="checkall" style="margin-left: 5px">All Employee</label>
                                                </div>
                                            </div>
                                            <div class="col-md-8  d-flex align-items-center justify-content-end">
                                                <div class="d-flex">
                                                    <form class="form form-vertical row">
                                                        <div class="col-md-8 col-12">
                                                            <label for="date">Month</label>
                                                                <input type="month" id="date" class="inputFieldHeight form-control get-from-data  @error('date') error @enderror"
                                                                name="date" value="{{ isset($inputs) ? $inputs['date'] : old('date')}}"required>
                                                                @error('date')
                                                                <span class="error">{{ $message }}</span>
                                                                @enderror
                                                        </div>
                                                        <div class="col-12 col-md-3 d-flex ">
                                                            {{-- <button type="submit" class="btn btn-primary mr-1">Search</button> --}}
                                                            <button type="button" class="btn btn-primary formButton mPrint mt-2 mb-1 payment_search" title="Searching" >
                                                                <div class="d-flex">
                                                                    <div class="formSaveIcon">
                                                                        <img src="{{asset('assets/backend/app-assets/icon/view-icon.png')}}" alt="" srcset="" width="20">
                                                                    </div>
                                                                    <div><span> View</span></div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-bordered" id="3filter-table">
                                                        <thead  class="thead-light">
                                                        <tr class="text-center" style="height: 40px;">
                                                                <th>Checked</th>
                                                                <th>Employee Name</th>
                                                                <th>Designation</th>
                                                                <th>Month</th>
                                                                <th>Year</th>
                                                                <th>Salary</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $index=0;
                                                            @endphp
                                                            @foreach ($payroll_lists as $employee)
                                                                <tr class="text-center">
                                                                    <td style="text-align: center">
                                                                        <input class="checkbox"  type="checkbox" value="{{$employee->employee_id}}" name="employee_id[id][{{$index}}]">
                                                                    </td>
                                                                    <td>{{ $employee->items2?$employee->items2->full_name:'' }}</td>
                                                                    <td>{{ $employee->items2?($employee->items2->dpt?$employee->items2->dpt->name:''):'' }}</td>
                                                                    <td>{{$employee->month}} </td>
                                                                    <td>{{$employee->year}} </td>
                                                                    <td>
                                                                        {{$employee->due}}
                                                                    </td>
                                                                    <td class="d-none"><input type="number" id="" name="employee_id[pay_salary][{{$index}}]"  value="{{$employee->due}}" min="0" max="{{$employee->due}}"> </td>
                                                                    <input class=""  type="hidden" name="employee_id[month][{{$index}}]" value="{{$employee->month}}">
                                                                    <input class=""  type="hidden" name="employee_id[year][{{$index++}}]" value="{{$employee->year}}">
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary mt-2 mb-2 formButton" style="padding: 0rem 1.8rem;line-height: 2;" title="Save">
                                                    <div class="d-flex">
                                                        <div class="formSaveIcon">
                                                            <img src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" width="20" height="20">
                                                        </div>
                                                        <div><span>Pay</span></div>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </form>
        </div>
    </div>
</div>
