<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip</title>
    <link rel="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" href="">
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
        }
        table {
          border-collapse: collapse;
          width: 80%;
        }
        
        td{
          /* border: 1px solid #dddddd; */
          text-align: left;
          padding: 8px;
        }
        th{
            border: 1px solid #070707; 
            background: rgb(198, 192, 192);
            font-size: 20px; 
        }
        .row {
            display: flex;
            text-align: center;
        }
        .column {
            width: 50%;
            padding: 10px;
        }
        hr{
            width: 40%;
        }
        .center {
            margin-left: auto;
            margin-right: auto;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }
        </style>
</head>
@php
$company_name= \App\Setting::where('config_name', 'company_name')->first();
$company_address= \App\Setting::where('config_name', 'company_address')->first();
$company_tele= \App\Setting::where('config_name', 'company_tele')->first();
$company_email= \App\Setting::where('config_name', 'company_email')->first();
$trn_no= \App\Setting::where('config_name', 'trn_no')->first();
$company_logo= \App\Setting::where('config_name', 'company_logo')->first();
$company_trn= \App\Setting::where('config_name', 'trn_no')->first();
// dd($datas);
@endphp
<body style="margin: 15px" onload="window.print();">
    @foreach($datas as $data)
        @php
            $i = 0;
            $j = 0;
            $earning_sum = 0;
            $deduction_sum = 0;
            $netpay = 0;
        @endphp
        <div style="page-break-after: always;">
            <div style="text-align: center;">
                <h2>Payslip</h2>
                <p>{{$company_name->config_value}} <br> {{$company_address->config_value}}</p>
                {{-- <p>Gateway Avenue</p> --}}
            </div><br>
            <div>
                <table class="center">
                    <tr>
                        <td>Employee name</td>
                        <td>: {{$data->emp->full_name}}</td>
                        <td>Date of Joining</td>
                        <td>: {{$data->emp->joining_date}}</td>
                    </tr>
                    <tr>
                        <td>Department</td>
                        <td>: {{$data->emp->dpt?$data->emp->dpt->name:''}}</td>
                        <td>Pay Period</td>
                        <td>: {{$data->month}} {{$data->year}}</td>
                    </tr>
                </table>
            </div>
            <div>
                <div class="row">
                    <div class="column" style="padding-right:0px">
                        <table class="center w-100" style="border: 1px solid black;">
                            <thead>
                            <tr>
                                <th scope="col">Earnings</th>
                                <th scope="col">Amount</th>
                                
                            </tr>
                            </thead>
                            {{-- <tbody>
                                @if($data->pay->process->basic != 0)
                                    <tr style="height: 35px;">
                                        <td style="border-right: 1px solid black;">Basic</td>
                                        <td style="border-right: 1px solid black;text-align: end;">{{$data->pay->process->basic}}</td>
                                        
                                    </tr>
                                    @php
                                        $earning_sum += $data->pay->process->basic;
                                        $i++;
                                    @endphp
                                @endif
                                @if($data->pay->process->house_rent != 0)
                                    <tr style="height: 35px;">
                                        <td style="border-right: 1px solid black;">House Rent</td>
                                        <td style="border-right: 1px solid black;text-align: end;">{{$data->pay->process->house_rent}}</td>
                                
                                    </tr>
                                    @php
                                        $earning_sum += $data->pay->process->house_rent;
                                        $i++;
                                    @endphp
                                @endif
                                @if($data->pay->process->transportation != 0)
                                    <tr style="height: 35px;">
                                        <td style="border-right: 1px solid black;">Transportation</td>
                                        <td style="border-right: 1px solid black;text-align: end;">{{$data->pay->process->transportation}}</td>
                                    
                                    </tr>
                                    @php
                                        $earning_sum += $data->pay->process->transportation;
                                        $i++;
                                    @endphp
                                @endif
                                @if($data->pay->process->bonus != 0)
                                    <tr style="height: 35px;">
                                        <td style="border-right: 1px solid black;">Bonus</td>
                                        <td style="border-right: 1px solid black;text-align: end;">{{$data->pay->process->bonus}}</td>
                                        
                                    </tr>
                                    @php
                                        $earning_sum += $data->pay->process->bonus;
                                        $i++;
                                    @endphp
                                @endif
                                @if($data->pay->process->telephone_bill != 0)
                                    <tr style="height: 35px;">
                                        <td style="border-right: 1px solid black;">Telephone Bill</td>
                                        <td style="border-right: 1px solid black;text-align: end;">{{$data->pay->process->telephone_bill}}</td>
                                    
                                    </tr>
                                    @php
                                        $earning_sum += $data->pay->process->telephone_bill;
                                        $i++;
                                    @endphp
                                @endif
                                @if($data->pay->process->ta != 0)
                                    <tr style="height: 35px;">
                                        <td style="border-right: 1px solid black;">TA</td>
                                        <td style="border-right: 1px solid black;text-align: end;">{{$data->pay->process->ta}}</td>
                                        
                                    </tr>
                                    @php
                                        $earning_sum += $data->pay->process->ta;
                                        $i++;
                                    @endphp
                                @endif
                                @if($data->pay->process->da != 0)
                                    <tr style="height: 35px;">
                                        <td style="border-right: 1px solid black;">DA</td>
                                        <td style="border-right: 1px solid black;text-align: end;">{{$data->pay->process->da}}</td>
                                        
                                    </tr>
                                    @php
                                        $earning_sum += $data->pay->process->da;
                                        $i++;
                                    @endphp
                                @endif
                                @if($data->pay->process->medical_expenses != 0)
                                    <tr style="height: 35px;">
                                        <td style="border-right: 1px solid black;">Medical Expenses</td>
                                        <td style="border-right: 1px solid black;text-align: end;">{{$data->pay->process->medical_expenses}}</td>
                                        
                                    </tr>
                                    @php
                                        $earning_sum += $data->pay->process->medical_expenses;
                                        $i++;
                                    @endphp
                                @endif
                                @if($data->pay->process->vacation_bonus != 0)
                                    <tr style="height: 35px;">
                                        <td style="border-right: 1px solid black;">Vacation Bonus</td>
                                        <td style="border-right: 1px solid black;text-align: end;">{{$data->pay->process->vacation_bonus}}</td>
                                        
                                    </tr>
                                    @php
                                        $earning_sum += $data->pay->process->vacation_bonus;
                                        $i++;
                                    @endphp
                                @endif 
                                @if($data->pay->process->others != 0)
                                    <tr style="height: 35px;">
                                        <td style="border-right: 1px solid black;">Vacation Bonus</td>
                                        <td style="border-right: 1px solid black;text-align: end;">{{$data->pay->process->others}}</td>
                                        
                                    </tr>
                                    @php
                                        $earning_sum += $data->pay->process->others;
                                        $i++;
                                    @endphp
                                @endif 
                                <tr style="height: 35px;">
                                    <td style="border-right: 1px solid black;">Total Earning</td>
                                    <td style="border-right: 1px solid black;text-align: end;">{{$earning_sum}}</td>
                                    @php
                                        $i++;
                                    @endphp
                                </tr>
                                <tr style="height: 35px;">
                                    <td style="border-right: 1px solid black;"></td>
                                    <td style="border-right: 1px solid black;"></td>
                                    @php
                                        $i++;
                                    @endphp
                                </tr>
                            </tbody> --}}
                            <tbody>
                                <tr style="height: 35px;">
                                    <td style="border-right: 1px solid black;">Total Erning</td>
                                    <td style="border-right: 1px solid black;text-align: end;">{{$data->payable}}</td>
                                </tr>
                                <tr style="height: 35px;">
                                    <td style="border-right: 1px solid black;"></td>
                                    <td style="border-right: 1px solid black;text-align: end;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="column"  style="padding-left:0px">
                        <table class="center w-100" style="">
                            <thead>
                            <tr>
                            
                                <th scope="col" style="border-left: 0px solid black;">Deductions</th>
                                <th scope="col">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                                {{-- @if($data->pay->process->providant_fund != 0)
                                    <tr style="height: 35px;">
                                        <td style="border-right: 1px solid black;">Providant Fund</td>
                                        <td style="border-right: 1px solid black;text-align: end;">{{$data->pay->process->providant_fund}}</td>
                                        
                                    </tr>
                                    @php
                                        $deduction_sum += $data->pay->process->providant_fund;
                                        $j++;
                                    @endphp
                                @endif
                                @if($data->pay->process->deduction != 0)
                                    <tr style="height: 35px;">
                                        <td style="border-right: 1px solid black;">Deduction</td>
                                        <td style="border-right: 1px solid black;text-align: end;">{{$data->pay->process->deduction}}</td>
                                        
                                    </tr>
                                    @php
                                        $deduction_sum += $data->pay->process->deduction;
                                        $j++;
                                    @endphp
                                @endif
                                @if($data->pay->process->tax_reduction != 0)
                                    <tr style="height: 35px;">
                                        <td style="border-right: 1px solid black;">TAX Deduction</td>
                                        <td style="border-right: 1px solid black;text-align: end;">{{$data->pay->process->tax_reduction}}</td>
                                        
                                    </tr>
                                    @php
                                        $deduction_sum += $data->pay->process->tax_reduction;
                                        $j++;
                                    @endphp
                                @endif
                                @if($data->pay->process->gratuity != 0)
                                    <tr style="height: 35px;">
                                        <td style="border-right: 1px solid black;">Gratuity</td>
                                        <td style="border-right: 1px solid black;text-align: end;">{{$data->pay->process->gratuity}}</td>
                                        
                                    </tr>
                                    @php
                                        $deduction_sum += $data->pay->process->gratuity;
                                        $j++;
                                    @endphp
                                @endif --}}
                                {{-- @while ($i>$j)
                                    @if($i-2==$j) --}}
                                        <tr style="height: 35px; border-bottom: 1px solid black;">
                                            <td style="border-right: 1px solid black;"> Total Deduction</td>
                                            <td style="border-right: 1px solid black;text-align:right">{{$deduction_sum}}</td>
                                            
                                        </tr>
                                    {{-- @elseif($i-1==$j) --}}
                                    <tr style="height: 35px; border-bottom: 1px solid black;">
                                        @php
                                            $netpay = $data->payable - $deduction_sum;
                                        @endphp
                                        <td style="border-right: 1px solid black;"> Net Pay</td>
                                        <td style="border-right: 1px solid black;text-align:right">{{$netpay}}</td>
                                        
                                    </tr>
                                    {{-- @else --}}
                                        {{-- <tr style="height: 35px;">
                                            <td style="border-right: 1px solid black;"></td>
                                            <td style="border-right: 1px solid black;"></td>
                                            
                                        </tr> --}}
                                    {{-- @endif --}}
                                    {{-- @php
                                        $i--
                                    @endphp
                                         --}}
                                {{-- @endwhile --}}

                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div style="text-align:center;">
                <p>{{$netpay}}</p>
                {{-- <p>{{ucwords((new NumberFormatter('en_IN', NumberFormatter::SPELLOUT))->format($netpay))}}</p> --}}
            </div>
            <div class="row">
                <div class="column">
                    <br><br><br>
                    <hr>

                    Employer Signature
                </div>
                <div class="column">
                    <br><br><br>
                    <hr>
                    Employee Signature
                    
                </div>
            </div><br><br>
            <div style="text-align: center;">This is System generated payslip</div>
        </div>
    @endforeach
    
</body>
</html>