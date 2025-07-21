@extends('layouts.pdf.appInvoice')
@php
$company_name= \App\Setting::where('config_name', 'company_name')->first();
$company_address= \App\Setting::where('config_name', 'company_address')->first();
$company_tele= \App\Setting::where('config_name', 'company_tele')->first();
$company_email= \App\Setting::where('config_name', 'company_email')->first();
@endphp
@push('css')
<style>



</style>
@endpush
@php
    $i=1;
@endphp
@section('content')
    <div class="container ">
        <div class="row">
            <div class="col-md-12">
                <section  id="widgets-Statistics" >
                    <div class="row">
                        <div class="col-12 text-center pt-1">
                            <h1>PURCHASE</h1>
                        </div>
                    </div>
                    <div class="row pt-1">
                        <div class="col-md-12 text-left">
                            <p><strong style="color: #000">SUPPLIER NAME : {{ isset($invoice->partyInfo($invoice->customer_name)->pi_name) ? $invoice->partyInfo($invoice->customer_name)->pi_name : '' }}</strong></p>
                        </div>
                        <div class="row">

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <p><strong>INVOICE NO</strong></p>
                                    </div>
                                    <div class="col-6">
                                        <p><strong>{{ $invoice->purchase_no }}</strong></p>
                                    </div>


                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <p> <strong>ADDRESS</strong> </p>
                                    </div>
                                    <div class="col-6">
                                        <p><strong>{{ $invoice->address == null? "N/A":$invoice->address }}</strong></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <p> <strong>TRN</strong> </p>
                                    </div>
                                    <div class="col-6">
                                        <p><strong>{{ $invoice->trn_no }}</strong></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <p> <strong>CONTACT NO:</strong> </p>
                                    </div>
                                    <div class="col-6">
                                        <p><strong>{{ $invoice->contact_no }}</strong></p>
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
                                            <p><strong>{{ $invoice->pay_mode }}</strong></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p> <strong>DATE:</strong></p>
                                        </div>
                                        <div class="col-6">

                                            <p> <strong>{{ date('d/m/Y',strtotime($invoice->date)) }}</strong></p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <p> <strong>SUPPLIER INVOICE</strong> </p>
                                        </div>
                                        <div class="col-6">
                                            <p><strong>{{ $invoice->supplier_invoice == null? "N/A":$invoice->supplier_invoice }}</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-sm ">
                        <tr>
                            <th style="min-width: 350px;">Product Name</th>
                            <th style="min-width: 350px;">Category/Service</th>
                            <th>Brand</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Price</th>
                        </tr>
                        @foreach (App\PurchaseItem::where('purchase_id',$invoice->id)->get() as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->category->name }}</td>
                                <td>{{ isset( $item->brand)?$item->brand->name:"" }} {{  isset( $item->brand)?$item->brand->name:"" }}</td>
                                <td>{{ $item->unit_price }}</td>

                                <td>{{ number_format($item->amount,0) }}</td>
                                <td>{{ $item->unitP->name }}</td>
                                <td>{{$item->price}}</td>
                            </tr>
                            <?php $i++; ?>
                        @endforeach
                        <tr>
                            {{-- <th class="text-center th-right" style="border: none !important; width:300px; border-right:1px solid black !important;" colspan="6" rowspan="3">  <span><i></i></span></th> --}}
                            <th class="text-center" colspan="5"  >TAXABLE SUPPLIES <small>(AED)</small></th>
                            @if ($invoice->pay_mode == "Cash")
                            <th class="text-center" colspan="1"  >{{number_format((float)(  $invoice->taxableAmount()), 0,'.','')   }}</th>
                            @else
                            <th class="text-center" colspan="1"  >{{number_format((float)(  $invoice->taxableAmount()), 2,'.','')   }}</th>
                            @endif
                        </tr>  
                        <tr>
                            <th class="text-center" colspan="5"  >VAT <small>(5%)</small></th>
                            @if ($invoice->pay_mode == "Cash")
                            <th class="text-center" colspan="1"  > {{number_format((float)(  $invoice->vatAmount()), 0,'.','')   }}</th>
                            @else
                            <th class="text-center" colspan="1"  > {{number_format((float)(  $invoice->vatAmount()), 2,'.','')   }}</th>
                            @endif
                            
                        </tr>
                        <tr>
                            <th class="text-center" colspan="5"  >Total Amount <small>(AED)</small></th>
                            @if ($invoice->pay_mode == "Cash")
                            <th class="text-center" colspan="1"  >  {{number_format((float)(  $invoice->TotalAmount()), 0,'.','')   }} </th>
                            @else
                            <th class="text-center" colspan="1"  >  {{number_format((float)(  $invoice->TotalAmount()), 2,'.','')   }} </th>
                            @endif
                            
                        </tr>
                    </table>

                    <div class="row mt-5 pt-3">

                        <div class="col-3">
                            <div class="row">
                                <div class="col-12 pt-1" style="border-top:1px dotted black;">
                                    <p>Supplier Signature</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6"></div>

                        <div class="col-3">
                            <div class="row">
                                {{-- <div class="col-12 text-right">
                                    <h4>For {{ $company_name->config_value }}</h4>
                                </div> --}}

                                <div class="col-12 text-right pt-1"  style="border-top:1px dotted black;">
                                    <p>Authorised Signature</p>
                                    <span>Name: {{ Auth::user()->name }}</span>
                                        <br>
                                    <span class="text-left">User ID: {{ Auth::id() }}</span>
                                </div>
                            </div>
                        </div>

                    </div>

                </section>
            </div>
        </div>
    </div>

@endsection
