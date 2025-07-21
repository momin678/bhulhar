@extends('layouts.backend.app')
@push('css')
@endpush
@section('title', 'item-purchase view')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12 col-sm-10 col-md-10 col-lg-12">
                        <form action="{{route('item-purchase.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <h5>Sales Return Details</h5>
                                <div class="card">
                                    <div class="card-body content-padding">
                                        <div class="row">

                                            <div class="col-sm-3 col-12">
                                                <label for="mode">Customer Name</label>
                                                <input type="text" readonly value="{{ $invoice->customer_name}}" class="form-control">
                                            </div>
                                            <div class="col-sm-3 col-12">
                                                <label for="mode">CONTACT NO</label>
                                                <input type="text" readonly value="{{ $invoice->contact_no }} " class="form-control">
                                            </div>
                                            <div class="col-sm-3 col-12">
                                                <label for="contact_no">Sale Return NO:</label>
                                                <input type="text" required class="form-control" name="contact_no" id="contact_no" value="{{ $invoice->sales_return_no }}" readonly>
                                                @error('contact_no')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-sm-3 col-12">
                                                <label for="address">Invoice  NO</label>
                                                <input type="text" name="address" class="form-control" id="address" readonly value="{{ $invoice->invoice_no }}">
                                                @error('address')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-sm-3 col-12">
                                                <label for="trn">TRN</label>
                                                <input type="text" name="trn" class="form-control" id="trn" readonly value="{{ $invoice->trn_no }}">
                                            </div>
                                            <div class="col-sm-3 col-12">
                                                <label for="tax_invoice_no">Address</label>
                                                <input type="text" required class="form-control" name="tax_invoice_no" id="tax_invoice_no" value=" {{ $invoice->address == null? "NA":$invoice->address }}" readonly>
                                                @error('tax_invoice_no')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-sm-3 col-12">
                                                <label for="pay_mode">Payment Mode</label>
                                                <select name="pay_mode" id="pay_mode" class="form-control" required disabled>
                                                    <option value="{{ $invoice->pay_mode }}">{{ $invoice->pay_mode }}</option>

                                                </select>
                                                @error('pay_mode')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-sm-3 col-12">
                                                <label for="pay_date">Date</label>
                                                <input type="text" class="form-control" readonly value="{{ $invoice->date }}">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <table class="table table-sm table-bordered" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>Style ID</th>
                                            <th>PRODUCT NAME</th>
                                            <th>UNIT PRICE</th>
                                            <th>QUANTITY</th>
                                            <th>Vat Rate</th>
                                            <th>Vat Amount</th>
                                            <th>TOTAL AMOUNT</th>
                                        </tr>
                                    </thead>
                                    <tbody class="all-data-area">
                                        @php
                                        $total_vat = 0;
                                        $total_amount = 0;

                                        @endphp
                                        @foreach ($items as $key => $item)
                                        <tr>
                                            <td>{{ $item->style_name }}</td>
                                            <td>{{ $item->item_name }}</td>
                                            <td>{{$item->unit_price}}</td>
                                            <td>{{$item->ruturn_qty}}</td>
                                            <td>{{$item->vat_rate}}</td>
                                            @php
                                            $total = $item->unit_price * $item->ruturn_qty;
                                             $vat_amount = ($total * $item->vat_rate) / 100;
                                             $total_vat = $total_vat + $vat_amount;
                                             $total_amount =$total+ $total_amount

                                            @endphp
                                            <td>{{$vat_amount}}</td>
                                            <td>{{ $item->total }}</td>
                                        </tr>
                                        @endforeach
                                        <tr class="border-top">
                                                    <td colspan="5"  class="text-right">Amount (AED): </td>
                                                    <td colspan="2">
                                                        @php
                                                            $amount = $total_amount;
                                                            $AM = $amount + $total_vat;
                                                        @endphp
                                                            {{ number_format((float)$amount, 2, '.', '')}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="text-right">VAT:</td>
                                                    <td colspan="2">
                                                        {{ number_format((float)$total_vat, 2, '.', '')}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="text-right">Net Amount (AED):</td>
                                                    <td colspan="2">
                                                        {{ number_format((float)$AM, 2, '.', '')}}
                                                    </td>
                                              </tr>

                                    </tbody>



                                </table>

                            </div>
                        </form>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
    <!-- PO filter Modal -->

@endsection
@push('js')

@endpush