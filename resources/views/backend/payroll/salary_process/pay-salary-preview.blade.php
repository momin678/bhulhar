

<style>
    td {
        white-space: nowrap;
    }
    @media print{
        html, body{
            height: 100%;
            overflow: hidden;
        }
            ::-webkit-scrollbar {
                display: none;
            }
        .divFooter {
            bottom: 0;
            position: fixed;
        }
    }
</style>
<section class="print-hideen border-bottom" style="padding: 5px 28px;background-color:#34465b">
    <div class="d-flex flex-row-reverse">
        <div class="mIconStyleChange" style="padding: 9px 2px !important;"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
        <div class="mIconStyleChange" style="padding: 7px 2px !important;"><a href="#"  onclick="window.print();" class="btn btn-icon btn-primary"><i class='bx bx-printer'></i></a></div>
    </div>
</section>
@include('layouts.backend.partial.modal-header-info')

@php
    use Carbon\Carbon;
    use App\HolidayRecode;
    $datee=$date;
    $today = Carbon::createFromFormat('Y-m-d', $datee);
    $dates = [];
    $holyArray=null;

    $holydays=HolidayRecode::whereYear('date',date('Y', strtotime($date.'-1')))->whereMonth('date',date('m', strtotime($date.'-1')))->get();
    foreach($holydays as $holy)
    {
        $holyArray=$holyArray.date('d',strtotime($holy->date)).',';
    }
    $weekend=null;

    $array=explode(',', $holyArray);
    for ($i = 1; $i < $today->daysInMonth + 1; ++$i) {
        if (!in_array($i, $array)) {
            $dates[] = \Carbon\Carbon::createFromDate($today->year, $today->month, $i);
        }
    }
    $extra_td = 32 - count($dates);

@endphp
@php
    // $extra_salary = App\Models\Payroll\SalaryProcess::where('employee_id', $employee->id)->whereMonth('date', $month)->whereYear('date', $year)->get();
    $total_salary = App\Models\Payroll\SalaryProcess::where('month', $pay_salary->month)->where('year', $pay_salary->year)->where('employee_id',$employee->id)->get();
    $basic_salary = $total_salary->where('salary_component_id',1);
    $per_month_salary = $total_salary->whereNotIn('salary_component_id',[8]);
    $per_month_over_time = $total_salary->whereIn('salary_component_id',[8]);
    $this_month_days = count($dates);
    $per_hours_salary = ($basic_salary->sum('amount')/$this_month_days)/10;
    $over_time = App\EmployeeOvertime::where('employee_id', $employee->id)->whereMonth('date', Carbon::parse($pay_salary->month)->format('m'))->whereYear('date', $pay_salary->year)->get()->sum('hours');
    $absent_count = App\EmployeeAttendance::where('employee_id', $employee->id)->whereMonth('date', Carbon::parse($pay_salary->month)->format('m'))->whereYear('date', $pay_salary->year)->where('status',0)->get();
    $deduction_processes=App\Models\Payroll\DeductionProcess::where('employee_id', $employee->id)->where('month',$pay_salary->month)->where('year', $pay_salary->year)->get();
@endphp
<section id="basic-vertical-layouts">
    <div class="row match-height">
        <div class="col-md-12 col-12">
            <div class="cardStyleChange">
                <div class="card-body">
                    <div style="text-align: center;">
                        <h2>LABOUR CARD</h2>
                    </div>
                    <table class="table table-sm table-borderless">

                        <tr>
                            <td >Name: {{$pay_salary->emp->first_name}}</td>
                            <td></td>
                            <td>Profession: {{$pay_salary->emp->dvision->name}}</td>
                        </tr>
                        <tr>
                            <td>Month: {{$pay_salary->month}}</td>
                            <td></td>
                            <td>Year: {{$pay_salary->year}}</td>
                        </tr>
                        <tr>
                            <td>Salary Per Month: {{$per_month_salary->sum('amount')}}</td>
                            <td>Per Day:{{number_format($basic_salary->sum('amount')/$this_month_days,2,'.','')}}</td>
                            <td>Per Hours: {{number_format($per_hours_salary,2,'.','')}}</td>
                        </tr>
                    </table>

                    <div class="daily-attendance-report">
                        <table class="table table-sm table-bordered">
                            <tr style="height: 30px;">
                                <td style="min-width: 150px !important;" class="text-center"></td>
                                @foreach ($dates as $key => $item)
                                    @if ($key < 16)
                                        <td class="separate-color text-center" style="min-width: 50px !important;">{{ date('d', strtotime($item)) }}</td>
                                    @endif
                                @endforeach
                            </tr>
                            <tr>
                                <td>Morning</td>
                                @foreach ($dates as $key => $item)
                                    @if ($key < 16)
                                        @if ($a = App\EmployeeAttendance::where('date', date('Y-m-d', strtotime($item)))->where('employee_id', $employee->id)->first())
                                            @if ($a->morning==1)
                                                <td class="text-center">P</td>
                                            @else
                                                <td class="text-center">A</td>
                                            @endif
                                        @else
                                            <td></td>
                                        @endif
                                    @endif
                                @endforeach
                            </tr>
                            <tr>
                                <td>Afternoon</td>
                                @foreach ($dates as $key => $item)
                                    @if ($key < 16)
                                        @if ($a = App\EmployeeAttendance::where('date', date('Y-m-d', strtotime($item)))->where('employee_id', $employee->id)->first())
                                            @if ($a->afternoon==1)
                                                <td class="text-center">P</td>
                                            @else
                                                <td class="text-center">A</td>
                                            @endif
                                        @else
                                            <td ></td>
                                        @endif
                                    @endif
                                @endforeach
                            </tr>
                            <tr>
                                <td>Overtime</td>
                                @foreach ($dates as $key => $item)
                                    @if ($key < 16)
                                        @if ($a = App\EmployeeOvertime::where('date', date('Y-m-d', strtotime($item)))->where('employee_id', $employee->id)->first())
                                            <td class="text-center">{{$a->hours}}</td>
                                        @else
                                            <td></td>
                                        @endif
                                    @endif
                                @endforeach
                            </tr>
                            <tr>
                                <td>Leave</td>
                                @foreach ($dates as $key => $item)
                                    @if ($key < 16)
                                        @if ($a = App\EmployeeLeave::where('from_date', '<=', date('Y-m-d', strtotime($item)))->where('to_date', '>=', date('Y-m-d', strtotime($item)))->where('employee_id', $employee->id)->first())
                                            <td class="text-center">L</td>
                                        @else
                                            <td></td>
                                        @endif
                                    @endif
                                @endforeach
                            </tr>
                            {{-- 17 to up --}}
                            <tr style="height: 30px;">
                                <td style="min-width: 150px !important;" class="text-center"></td>
                                @foreach ($dates as $key => $item)
                                    @if ($key >= 16)
                                        <td class="separate-color text-center">{{ date('d', strtotime($item)) }}</td>
                                    @endif
                                @endforeach
                                @for ($i = 0; $i < $extra_td; $i++)
                                    <td></td>
                                @endfor
                            </tr>
                            <tr>
                                <td>Morning</td>
                                @foreach ($dates as $key => $item)
                                    @if ($key >= 16)
                                        @if ($a = App\EmployeeAttendance::where('date', date('Y-m-d', strtotime($item)))->where('employee_id', $employee->id)->first())
                                            @if ($a->morning==1)
                                                <td class="text-center">P</td>
                                            @else
                                                <td class="text-center">A</td>
                                            @endif
                                        @else
                                            <td></td>
                                        @endif
                                    @endif
                                @endforeach
                                @for ($i = 0; $i < $extra_td; $i++)
                                <td></td>
                                @endfor
                            </tr>
                            <tr>
                                <td>Afternoon</td>
                                @foreach ($dates as $key => $item)
                                    @if ($key >= 16)
                                        @if ($a = App\EmployeeAttendance::where('date', date('Y-m-d', strtotime($item)))->where('employee_id', $employee->id)->first())
                                            @if ($a->afternoon==1)
                                                <td class="text-center">P</td>
                                            @else
                                                <td class="text-center">A</td>
                                            @endif
                                        @else
                                            <td ></td>
                                        @endif
                                    @endif
                                @endforeach
                                @for ($i = 0; $i < $extra_td; $i++)
                                <td></td>
                                @endfor
                            </tr>
                            <tr>
                                <td>Overtime</td>
                                @foreach ($dates as $key => $item)
                                    @if ($key >= 16)
                                        @if ($a = App\EmployeeOvertime::where('date', date('Y-m-d', strtotime($item)))->where('employee_id', $employee->id)->first())
                                            <td class="text-center">{{$a->hours}}</td>
                                        @else
                                            <td ></td>
                                        @endif
                                    @endif
                                @endforeach
                                @for ($i = 0; $i < $extra_td; $i++)
                                <td></td>
                                @endfor
                            </tr>
                            <tr>
                                <td>Leave</td>
                                @foreach ($dates as $key => $item)
                                    @if ($key >= 16)
                                        @if ($a = App\EmployeeLeave::where('from_date', '<=', date('Y-m-d', strtotime($item)))->where('to_date', '>=', date('Y-m-d', strtotime($item)))->where('employee_id', $employee->id)->first())
                                            <td class="text-center">L</td>
                                        @else
                                            <td></td>
                                        @endif
                                    @endif
                                @endforeach
                                @for ($i = 0; $i < $extra_td; $i++)
                                <td></td>
                                @endfor
                            </tr>
                            <tr>
                                <td rowspan="9" colspan="4" class="text-center">
                                    <br>
                                    <br>
                                    <br>
                                    <hr>
                                    Authorize Signature
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <hr>
                                    Receiver's Signature
                                </td>
                                <td colspan="9">Details</td>
                                <td colspan="4">Amount</td>

                            </tr>
                            <tr>
                                <td colspan="9">Basic Salary</td>
                                <td colspan="4">{{$basic_salary->sum('amount')}}</td>
                            </tr>
                            <tr>
                                <td colspan="9">Overtime</td>
                                <td colspan="4">{{number_format($per_month_over_time->sum('amount'),2,'.','')}}</td>
                            </tr>
                            <tr>
                                {{-- <td rowspan="3" colspan="4">Authorize Signatory</td> --}}
                                <td colspan="9">Total</td>
                                <td colspan="4">{{number_format($per_month_salary->sum('amount')+($per_month_over_time->sum('amount')),2,'.','')}}</td>
                            </tr>
                            <tr>
                                <td colspan="9">Less Absent</td>
                                <td colspan="4">{{number_format($deduction_processes->where('deduction_type', 0)->sum('amount'),2,'.','')}}</td>
                            </tr>
                            <tr>
                                <td colspan="9">Less Advance Paid</td>
                                <td colspan="4">{{number_format($deduction_processes->where('deduction_type', 1)->sum('amount'),2,'.','')}}</td>
                            </tr>
                            <tr>
                                <td colspan="9">Balance Amount Payable</td>
                                <td colspan="4">{{number_format(($per_month_salary->sum('amount')+$per_month_over_time->sum('amount') - $deduction_processes->sum('amount')),2,'.','')}}</td>
                                {{-- <td colspan="4">{{number_format(($total_salary->sum('amount')+($over_time*$per_hours_salary))-($basic_salary->sum('amount')/$this_month_days)*count($absent_count)-$deduction_processes->sum('amount'),2,'.','')}}</td> --}}
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('layouts.backend.partial.modal-footer-info')
