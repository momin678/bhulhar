@extends('layouts.backend.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />

@endpush
@section('title', 'Product')
@section('content')
@include('layouts.backend.partial.style')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">

            <div class="content-body">
                @include('backend.product.top-header', ['activeMenu' => 'daily-summery'])
                <!-- Widgets Statistics start -->
                <div class="tab-content">
                    <div class="tab-pane bg-white active">
                        <section id="widgets-Statistics">
                            <div class="card p-1">
                                @include('layouts.backend.partial.modal-header-info')
                                <h4 class="mt-1">Purchase Summery</h4>                        
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th>Sl</th>
                                                <th>Date</th>
                                                <th>Supplier Name</th>
                                                <th>Invoice</th>
                                                <th>Amount</th>
                                                <th>Vat</th>
                                                <th>Total</th>
                                                <th>Paid</th>
                                                <th>Due</th>
                                            </tr>
                                        </thead>
                                        <tbody class="user-table-body" id="stock_show">
                                            @foreach ($purchases as $key => $purchase)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{convert_date_format($purchase->date)}}</td>
                                                    <td>{{$purchase->partyInfo($purchase->customer_name)->pi_name}}</td>
                                                    <td>{{$purchase->supplier_invoice}}</td>
                                                    <td>{{$purchase->amount}}</td>
                                                    <td>{{$purchase->vat_amount}}</td>
                                                    <td>{{$purchase->total_amount}}</td>                                            
                                                    <td>{{$purchase->paid_price}}</td>
                                                    <td>{{$purchase->due_price}}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="4" class="text-right pr-2">Total</td>
                                                <td>{{$purchases->sum('amount')}}</td>
                                                <td>{{$purchases->sum('vat_amount')}}</td>
                                                <td>{{$purchases->sum('total_amount')}}</td>
                                                <td>{{$purchases->sum('paid_price')}}</td>
                                                <td>{{$purchases->sum('due_price')}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <h4 class="mt-1">Sale Summery</h4>                        
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th>Sl</th>
                                                <th>Date</th>
                                                <th>Customer Name</th>
                                                <th>Invoice</th>
                                                <th>Amount</th>
                                                <th>Vat</th>
                                                <th>Total</th>
                                                <th>Paid</th>
                                                <th>Due</th>
                                            </tr>
                                        </thead>
                                        <tbody class="user-table-body" id="stock_show">
                                            @foreach ($sales as $key => $sale)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{convert_date_format($sale->date)}}</td>
                                                    <td>{{$sale->partyInfo($sale->customer_name)->pi_name}}</td>
                                                    <td>{{$sale->invoice_no}}</td>
                                                    <td>{{$sale->price}}</td>
                                                    <td>{{$sale->vat_amount}}</td>
                                                    <td>{{$sale->total_price}}</td>                                            
                                                    <td>{{$sale->paid_amount}}</td>
                                                    <td>{{$sale->due_amount}}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="4" class="text-right pr-2">Total</td>
                                                <td>{{$sales->sum('price')}}</td>
                                                <td>{{$sales->sum('vat_amount')}}</td>
                                                <td>{{$sales->sum('total_price')}}</td>
                                                <td>{{$sales->sum('paid_amount')}}</td>
                                                <td>{{$sales->sum('due_amount')}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @include('layouts.backend.partial.modal-footer-info')
                            </div>
                        </section>
                        <!-- Widgets Statistics End -->
                    </div>
                </div>



            </div>
        </div>
    </div>
    <!-- END: Content-->

@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    <script>

    </script>
@endpush
