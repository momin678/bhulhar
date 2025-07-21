<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip</title>
    <link rel="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" href="">
    <style>
        html, body{
            height: 99%;
            /* overflow: hidden; */
        }
        body{
            font-family: Arial, Helvetica, sans-serif;
        }
        table {
          border-collapse: collapse;
          width: 100%;
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
        @media print{
            html, body{
                height: 99%;
            }
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
                        <td>Pay Period</td>
                        <td>: {{$data->month}} {{$data->year}}</td>
                    </tr>
                </table>
            </div>
            <div>
                <div class="row">
                    <div style="padding-right:0px; width: 100% !important;">
                        <table class="center w-100" style="border: 1px solid black;">
                            <thead>
                            <tr>
                                <th scope="col" style="text-align: left; padding-left:10px;">Earnings</th>
                                <th scope="col" style="text-align: right; padding-right:10px;">Amount</th>
                            </tr>
                            </thead>
                            
                            <tbody>
                                @foreach ($salary_conponents as $item)
                                    <tr style="height: 35px;">
                                        <td style="border-right: 1px solid black;">{{$item->salaryComponent?$item->salaryComponent->name:''}}</td>
                                        <td style="border-right: 1px solid black;text-align: end;">{{number_format($item->amount,2)}}</td>
                                    </tr>
                                @endforeach
                                <tr style="height: 35px;">
                                    <td style="border: 1px solid black;">Total Erning</td>
                                    <td style="border: 1px solid black;text-align: end;">{{number_format($data->payable,2)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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
        <div class="divFooter" style="position: fixed; bottom: 0px;">
            Business Software Solutions by
            <span style="color: #0005" class="spanStyle"><img class="img-fluid" src="{{ asset('img/zisprink.png') }}" style="margin-bottom: -20px;" width="70"></span>
        </div>
    @endforeach
</body>
</html>