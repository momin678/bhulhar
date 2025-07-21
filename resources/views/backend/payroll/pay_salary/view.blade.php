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
<section class="print-hideen border-bottom" style="padding: 5px 28px;background-color:#34465b">
    <div class="d-flex flex-row-reverse">
        <div class="mIconStyleChange" style="padding: 7px 2px !important;"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
        <div class="mIconStyleChange" style="padding: 7px 2px !important;"><a href="{{route('pay-salary-print', $pay_salary->id)}}" target="_blank" class="btn btn-icon btn-primary"><i class='bx bx-printer'></i></a></div>
    </div>
</section>

    @php
        $i = 0;
        $j = 0;
        $earning_sum = 0;
        $deduction_sum = 0;
        $netpay = 0;
    @endphp
    <div style="margin: 40px">
        <div style="text-align: center;">
            <h2>Payslip</h2>
            <p>{{$company_name->config_value}} <br> {{$company_address->config_value}}</p>
        </div><br>
        <div>
            <table class="center w-100">
                <tr>
                    <td><strong>Employee name: {{$pay_salary->emp->full_name}}</strong></td>
                    <td class="text-right"><strong>Pay Period: {{$pay_salary->month}} {{$pay_salary->year}}</strong></td>
                </tr>
            </table>
        </div>
        <div>
            <div class="row">
                <div style="padding-right:0px; width: 100% !important;">
                    <table class="center w-100" style="border: 1px solid black;">
                        <thead>
                        <tr>
                            <th scope="col" style="text-align: left; padding-left:10px; background: #fff;">Earnings</th>
                            <th scope="col" style="text-align: right; padding-right:10px; background: #fff;">Amount</th>
                        </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($pay_salary->components($pay_salary->employee_id, $pay_salary->month, $pay_salary->year) as $item)
                                <tr style="height: 35px;">
                                    <td style="border-right: 1px solid black;">{{$item->salaryComponent?$item->salaryComponent->name:''}}</td>
                                    <td style="border-right: 1px solid black;text-align: end;">{{number_format($item->amount,2)}}</td>
                                </tr>
                            @endforeach
                            <tr style="height: 35px;">
                                <td style="border-right: 1px solid black;">Total Deduction</td>
                                <td style="border-right: 1px solid black;text-align: end;">{{number_format($deduction->sum('amount'),2)}}</td>
                            </tr>
                            
                            <tr style="height: 35px;">
                                <td style="border: 1px solid black;">Total Earning</td>
                                <td style="border: 1px solid black;text-align: end;">{{number_format($pay_salary->payable,2)}}</td>
                            </tr>
                            <tr style="height: 35px;">
                                <td style="border: 1px solid black;">Paid Amount</td>
                                <td style="border: 1px solid black;text-align: end;">{{number_format($pay_salary->paid,2)}}</td>
                            </tr>
                            <tr style="height: 35px;">
                                <td style="border: 1px solid black;">Due Amount</td>
                                <td style="border: 1px solid black;text-align: end;">{{number_format($pay_salary->due,2)}}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>