@extends('layouts.pdf.appInvoice')
@php
$company_name= \App\Setting::where('config_name', 'company_name')->first();
$company_address= \App\Setting::where('config_name', 'company_address')->first();
$company_tele= \App\Setting::where('config_name', 'company_tele')->first();
$company_email= \App\Setting::where('config_name', 'company_email')->first();
@endphp
@push('css')
<style>
    td{
        text-align: center !important;
    }

    th, td {
    border: 1px solid #000 !important;
}

.table {
    width: 100%;
    margin-bottom: 1rem;
    color: #000;
}
.description{
    min-width: 650px;
    max-width: 700px;
}
.description-two{
    min-width: 550px;
    max-width: 700px;
}
p{
    color: black !important;
}

.bg-color{
        background: gray;
    }
    @media print{
        body {
            -webkit-print-color-adjust: exact;
        }
        .bg-color{
            background: #838181 !important;
            /* -webkit-print-color-adjust: exact !important; */
        }
    }

</style>
@endpush
@section('content')
    <div class="container ">
        <div class="row">
            <div class="col-md-12">
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4 text-center pt-3">
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
                                            <p><strong>{{ $invoice->invoice_no }}</strong></p>
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

                    <div class="row pt-2">
                        @php
                            $invoice_total= $invoice->amount+$invoice->vat_amount;
                        @endphp
                        @if ($invoice_total<10000)
                        <table   class="table table-sm ">
                            <tr class="bg-color">
                                <th class="text-center" >SL No.</th>
                                <th class="text-center" >Particular Description</th>
                                <th class="text-center" >Quantity</th>
                                <th class="text-center" >Rate</th>
                                <th class="text-center" >Total Amount</th>
                                <th class="text-center" >Vat Rate</th>
                            </tr>
                                @php
                                 $taxable_amount=0;
                                 $vat=0;
                                 $total_amount=0;   
                                @endphp
                                @foreach ($invoice_items as $item)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td class="description">From {{$item->crusher}} To {{$item->destination}}</td>
                                    <td>{{$item->total_qty}}</td>
                                    <td>{{$item->rate}}</td>
                                    <td>{{$item->rate * $item->total_qty}}</td>
                                    <td>{{$item->vat_rate}}</td>
                                </tr>
                                    @php
                                        $vat_amount= (($item->rate * $item->total_qty) * $item->vat_rate / 100);
                                        $taxable_amount= $taxable_amount+ ($item->rate * $item->total_qty);
                                        $vat = $vat+ $vat_amount ;
                                        $total_amount = $total_amount+ ($item->rate * $item->total_qty) + $vat_amount ;
                                    @endphp
                                @endforeach
                                
                            <tr>
                                <th class="text-center" style="border: none !important" colspan="3" ></th>
                                <th class="text-center bg-color" colspan="3"  >TAXABLE AMOUNT <small>(AED)</small></th>
                                <th class="text-center bg-color"   >{{ round($taxable_amount,2) }}</th>
                            </tr>
                            <tr>
                                <th class="text-center" style="border: none !important" colspan="3" ></th>
                                <th class="text-center bg-color" colspan="3"  >VAT <small>(5%)</small></th>
                                <th class="text-center bg-color"   > {{ round($vat,2) }}</th>
                            </tr>
                            <tr>
                                <th class="text-center" style="border: none !important" colspan="3" ></th>
                                <th class="text-center bg-color" colspan="3"  >Total Amount <small>(AED)</small></th>
                                <th class="text-center bg-color"   > {{ $invoice->vat_amount+$invoice->amount }}</th>
                            </tr>
                            <tr>
                                <th class="text-center" style="border: none !important" colspan="3" ></th>
                                <th class="text-center bg-color" colspan="3"  >Paid Amount <small>(AED)</small></th>
                                <th class="text-center bg-color"   > {{$invoice->paid_amount}}</th>
                            </tr> 
                            <tr>
                                <th class="text-center" style="border: none !important" colspan="3" ></th>
                                <th class="text-center bg-color" colspan="3"  >Due Amount <small>(AED)</small></th>
                                <th class="text-center bg-color"   > {{$invoice->due_amount}}</th>
                            </tr>                                    
                        </table> 
                        @else
                        <table   class="table table-sm ">
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
                                @php
                                 $taxable_amount=0;
                                 $vat=0;
                                 $total_amount=0;   
                                @endphp
                                @foreach ($invoice_items as $item)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td class="description-two">From {{$item->crusher}} To {{$item->destination}}</td>
                                    <td>{{$item->rate}}</td>
                                    <td>{{$item->total_qty}}</td>
                                    <td>{{$item->rate * $item->total_qty}}</td>
                                    <td>{{$item->vat_rate}}</td>
                                    <td>{{$item->total_vat_amount}}</td>
                                    <td>{{($item->rate * $item->total_qty)+$item->total_vat_amount}}</td>
                                </tr>
                                    @php
                                        $vat_amount= (($item->rate * $item->total_qty) * $item->vat_rate / 100);
                                        $taxable_amount= $taxable_amount+ ($item->rate * $item->total_qty);
                                        $vat = $vat+ $vat_amount ;
                                        $total_amount = $total_amount+ ($item->rate * $item->total_qty) + $vat_amount ;
                                    @endphp
                                @endforeach
                                
                            <tr>
                                <th class="text-center" style="border: none !important" colspan="4"></th>
                                <th class="text-center bg-color" colspan="3"  >TAXABLE AMOUNT <small>(AED)</small></th>
                                <th class="text-center bg-color" colspan="2"  >{{ round($taxable_amount,2) }}</th>
                            </tr>
                            <tr>
                                <th class="text-center" style="border: none !important" colspan="4"></th>
                                <th class="text-center bg-color" colspan="3"  >VAT <small>(5%)</small></th>
                                <th class="text-center bg-color" colspan="2"  > {{ round($vat,2) }}</th>
                            </tr>
                            <tr>
                                <th class="text-center" style="border: none !important" colspan="4"></th>
                                <th class="text-center bg-color" colspan="3"  >Total Amount <small>(AED)</small></th>
                                <th class="text-center bg-color" colspan="2"  > {{ $invoice->vat_amount+$invoice->amount }}</th>
                            </tr> 
                            <tr>
                                <th class="text-center" style="border: none !important" colspan="4" ></th>
                                <th class="text-center bg-color" colspan="3"  >Paid Amount <small>(AED)</small></th>
                                <th class="text-center bg-color" colspan="2"  > {{$invoice->paid_amount}}</th>
                            </tr> 
                            <tr>
                                <th class="text-center" style="border: none !important" colspan="4" ></th>
                                <th class="text-center bg-color" colspan="3"  >Due Amount <small>(AED)</small></th>
                                <th class="text-center bg-color" colspan="2"  > {{$invoice->due_amount}}</th>
                            </tr>                                    
                        </table> 
                        @endif
                        

                    </div>

                    <div class="row pt-5 mt-5">

                        <div class="col-6">
                            <div class="row">

                                <div class="col-12 pt-5">
                                    <p>Customer Signature</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="row">

                                <div class="col-12 pt-5 text-right">
                                    <p>Authorised Signature</p>
                                    Created By: {{ $invoice->created_by_user->name }}
                                </div>
                            </div>
                        </div>
                        

                    </div>


                </section>
            </div>
        </div>
    </div>

@endsection
