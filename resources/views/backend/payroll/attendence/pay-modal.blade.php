@php
    use Carbon\CarbonPeriod;
@endphp

<div class="modal-header" style="height: 50px">
    <div class="row">
        <div class="col-md-4">
            <h5 class="modal-title" id="">PAYMENT</h5>
        </div>
        <div class="col-md-8 text-right">
            <button type="botton" style="margin-top: -12px;" class="btn btn-sm " data-dismiss="modal">
                <span aria-hidden="true" class="icon-style">&times;</span></button>
        </div>
    </div>
</div>

<div class="modal-body">
    <div class="card-body" >
        <div class="content-body p-1">
            <form class="form form-vertical" action="{{route('pay-salary.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col-md-12 col-12">
                            <div class="cardStyleChange">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="form-check">
                                            <input class="form-check-input" style="margin-left: -15px" type="checkbox" id="checkall">
                                            <label class="form-check-label" for="checkall" style="margin-left: 5px">All Employee</label> 
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-bordered" id="3filter-table">
                                                        <thead  class="thead-light">
                                                            <tr style="height: 50px;">
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
                                                                <tr class="trFontSize border-bottom">
                                                                    <td style="text-align: center">
                                                                        <input class="checkbox"  type="checkbox" value="{{$employee->employee_id}}" name="employee_id[id][{{$index}}]"> 
                                                                    </td>
                                                                    <td>{{$employee->items2->first_name.' '.$employee->items2->last_name}} </td>
                                                                    <td>{{$employee->items2->designation}} </td>
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