<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        
    <link rel="stylesheet" href="{{ asset('css/print.css') }}">

    <title>Invoice Print</title>
</head>

<style>
    .headerGroup:after {
        content: 'Text';
        background-image: url('img/balraj-header.png');
    }
    .description{
        min-width: 650px !important;
        max-width: 700px !important;
    }
</style>

<body onload="window.print();">

    @php
    $company_name= \App\Setting::where('config_name', 'company_name')->first();
    $company_address= \App\Setting::where('config_name', 'company_address')->first();
    $company_tele= \App\Setting::where('config_name', 'company_tele')->first();
    $company_email= \App\Setting::where('config_name', 'company_email')->first();
    $trn_no= \App\Setting::where('config_name', 'trn_no')->first();
    $company_logo= \App\Setting::where('config_name', 'company_logo')->first();
    $company_trn= \App\Setting::where('config_name', 'trn_no')->first();
    
    @endphp
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper mt-4">
        <div class="row ">
            <div class="col-md-4"></div>
            <div class="col-md-4 text-center" style="margin-top: 130px;">
                <h1>TAX INVOICE</h1>
            </div>
            <div class="col-md-4 text-right pr-4">
                @php
                    if($invoice->due_amount==0){
                        // paid
                        $paid_img='paid-icon.png';
                    }elseif($invoice->paid_amount==0){
                        // Unpaid
                        $paid_img='unpaid-icon.png';
                    }else{
                        // Partial Paid
                        $paid_img='partial-paid-icon.png';
                    }
                @endphp
                {{-- <img src="{{asset('assets/backend/app-assets/payment/')}}/{{$paid_img}}" height="150" alt=""> --}}
            </div>
        </div>
        <div class="row pt-4">
            <div class="col-md-12 text-left mb-1">
                <span><strong style="color: #000">CUSTOMER NAME : {{ $invoice->customer->pi_name }}</strong></span>
            </div>
            <div class="col-md-4">
                <div class="row">

                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <p><strong>INVOICE NO</strong></p>
                            </div>
                            <div class="col-6">
                                <p><strong>{{ $invoice->status=='Draft' ? "Draft Invoice": $invoice->invoice_no }}</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <p> <strong>SHIP ADDRESS</strong> </p>
                            </div>
                            <div class="col-6">
                                <p>{{ $invoice->address == null? "NA":$invoice->address }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <p> <strong>TRN</strong> </p>
                            </div>
                            <div class="col-6">
                                <p>{{ $invoice->customer->trn_no }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <p> <strong>CONTACT NO:</strong> </p>
                            </div>
                            <div class="col-6">
                                <p>{{ $invoice->customer->con_no }}</p>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <div class="col-md-4">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <p> <strong>PAYMODE:</strong> </p>
                            </div>
                            <div class="col-6">
                                <p>{{ $invoice->pay_mode }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <p> <strong>DATE:</strong></p>
                            </div>
                            <div class="col-6">
                                <p> {{ date('d/m/Y',strtotime($invoice->date)) }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <table width="100%">

            <thead>
                <tr>
                    <td class="headerGroup">
                        <div class="header-block"></div>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="page-container" style="font-size: 12px; width: 100% !important;">
                            <div class="page">
                                <table class="table table-stripe"  style="font-size: 12px; width: 100% !important;">
                                    @php
                                    $invoice_total= $invoice->amount+$invoice->vat_amount;
                                @endphp
                                @if ($invoice_total<10000)
                                    <thead>
                                        <tr class="bg-color">
                                            <th class="text-center" >SL No.</th>
                                            <th class="text-center" >Particular Description</th>
                                            <th class="text-center" >Quantity</th>
                                            <th class="text-center" >Rate</th>
                                            <th class="text-center" >Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $taxable_amount=0;
                                        $vat=0;
                                        $total_amount=0;
                                       @endphp
                                       @foreach ($invoice->items as $item)
                                       <tr>
                                           <td>{{$loop->index+1}}</td>
                                           <td class="description">{{$item->description}}</td>
                                           <td>{{$item->qty}}</td>
                                           <td>{{$item->rate}}</td>
                                           <td>{{$item->amount + $item->vat_amount}}</td>
                                       </tr>
                                           @php
                                               $taxable_amount= $taxable_amount+ $item->amount;
                                               $vat = $vat+ $item->vat_amount;
                                               $total_amount = $total_amount+ ($item->amount+ $item->vat_amount);
                                           @endphp
                                       @endforeach

                                   <tr>
                                       <th class="text-center" style="border: none !important" colspan="2" ></th>
                                       <th class="text-center bg-color" colspan="2"  >TAXABLE AMOUNT <small>(AED)</small></th>
                                       <th class="text-center bg-color"   >{{ round($taxable_amount,2) }}</th>
                                   </tr>
                                   <tr>
                                       <th class="text-center" style="border: none !important" colspan="2" ></th>
                                       <th class="text-center bg-color" colspan="2"  >VAT <small>(5%)</small></th>
                                       <th class="text-center bg-color"   > {{ round($vat,2) }}</th>
                                   </tr>
                                   <tr>
                                       <th class="text-center" style="border: none !important" colspan="2" ></th>
                                       <th class="text-center bg-color" colspan="2"  >Total Amount <small>(AED)</small></th>
                                       <th class="text-center bg-color"   > {{ $invoice->vat_amount+$invoice->amount }}</th>
                                   </tr>
                                   <tr>
                                       <th class="text-center" style="border: none !important" colspan="2" ></th>
                                       <th class="text-center bg-color" colspan="2"  >Paid Amount <small>(AED)</small></th>
                                       <th class="text-center bg-color"   > {{$invoice->paid_amount}}</th>
                                   </tr>
                                   <tr>
                                       <th class="text-center" style="border: none !important" colspan="2" ></th>
                                       <th class="text-center bg-color" colspan="2"  >Due Amount <small>(AED)</small></th>
                                       <th class="text-center bg-color"   > {{$invoice->due_amount}}</th>
                                   </tr>


                                    </tbody>
                                    @else
                                    @endif

                                    <thead>
                                        <tr class="bg-color">
                                            <th class="text-center" >SL No.</th>
                                            <th class="text-center" >Description</th>
                                            <th class="text-center" >Rate</th>
                                            <th class="text-center" >Quantity</th>
                                            <th class="text-center" >Gross Amount</th>
                                            <th class="text-center" >Tax Rate</th>
                                            <th class="text-center" >Tax Amount</th>
                                            <th class="text-center" >Net Amount</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                        $taxable_amount=0;
                                        $vat=0;
                                        $total_amount=0;
                                       @endphp
                                       @foreach ($invoice->items as $item)
                                       <tr>
                                           <td>{{$loop->index+1}}</td>
                                           <td class="">{{$item->description}}</td>
                                           <td>{{$item->rate}}</td>
                                           <td>{{$item->qty}}</td>
                                           <td>{{$item->amount}}</td>
                                           <td>{{floatval($item->vat_rate)}}</td>
                                           <td>{{$item->vat_amount}}</td>
                                           <td>{{$item->amount + $item->vat_amount}}</td>
                                       </tr>
                                           @php
                                               $taxable_amount= $taxable_amount+ $item->amount;
                                               $vat = $vat+ $item->vat_amount;
                                               $total_amount = $total_amount+ ($item->amount+ $item->vat_amount);
                                           @endphp
                                       @endforeach

                                   <tr>
                                       <th class="text-center" style="border: none !important" colspan="4"></th>
                                       <th class="text-center bg-color" colspan="2"  >TAXABLE AMOUNT <small>(AED)</small></th>
                                       <th class="text-center bg-color" colspan="2"  >{{round($taxable_amount,2)}}</th>
                                   </tr>
                                   <tr>
                                       <th class="text-center" style="border: none !important" colspan="4"></th>
                                       <th class="text-center bg-color" colspan="2"  >VAT <small>(5%)</small></th>
                                       <th class="text-center bg-color" colspan="2"  > {{round($vat,2)}}</th>
                                   </tr>
                                   <tr>
                                       <th class="text-center" style="border: none !important" colspan="4"></th>
                                       <th class="text-center bg-color" colspan="2"  >Total Amount <small>(AED)</small></th>
                                       <th class="text-center bg-color" colspan="2"  > {{ $invoice->vat_amount+$invoice->amount }}</th>
                                   </tr>
                                   <tr>
                                       <th class="text-center" style="border: none !important" colspan="4" ></th>
                                       <th class="text-center bg-color" colspan="2"  >Paid Amount <small>(AED)</small></th>
                                       <th class="text-center bg-color" colspan="2"  > {{$invoice->paid_amount}}</th>
                                   </tr>
                                   <tr>
                                       <th class="text-center" style="border: none !important" colspan="4" ></th>
                                       <th class="text-center bg-color" colspan="2"  >Due Amount <small>(AED)</small></th>
                                       <th class="text-center bg-color" colspan="2"  > {{$invoice->due_amount}}</th>
                                   </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- ============ srtart absolute header/footer image========== -->
    <div class="header">
        <section id="widgets-Statistics" class="company-head" style="border-bottom: 3px solid black !important">
            <div class="container" style="padding-left: 0px;">
                <img src="{{ asset('img/balraj-header.png') }}" style="width: 700px; transform: rotate(-.2deg);
                height: 100px;" alt="">
            </div>
            <div class="text-center">
                <div style="margin-bottom: 0px; font-size: 12px; color: #fff !important;">
                    <span class="company-info">Tel.: {{$company_tele->config_value}} Email: {{$company_email->config_value}} TRN No: {{$company_trn->config_value}}</span>
                </div>
            </div>
        </section>
    </div>
    <div class="footer">
        <img src="{{ asset('img/balraj-footer.jpeg') }}" alt="Footer image" width="100%" height="50px"
            style="float:left; background-size: cover;">
    </div>
    <!-- ============ end absolute header/footer image========== -->

    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>
