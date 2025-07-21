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
                @include('backend.product.top-header', ['activeMenu' => 'daily-balance'])
                <!-- Widgets Statistics start -->
                <div class="tab-content">
                    <div class="tab-pane bg-white active">
                        <section id="widgets-Statistics">
                            <div class="card p-1">
                                @include('layouts.backend.partial.modal-header-info')
                                <form action="">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="">Date</label>
                                            <input type="text" class="form-control date" name="date" placeholder="Single Date">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">From </label>
                                            <input type="text" class="form-control date" name="from" placeholder="From Date">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">To</label>
                                            <input type="text" class="form-control date" name="to" placeholder="To Date">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Status </label>
                                            <select name="status" class="form-control">
                                                <option value="">Select.........</option>
                                                <option value="Paid">Paid</option>
                                                <option value="Due">Due</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2 mt-2">
                                            <button type="submit" class="btn btn-success">Search</button>
                                        </div>
                                    </div>
                                </form>
                                <h4 class="mt-1">
                                    Purchase Balance
                                    @if ($request_list['date'] || ($request_list['from'] && $request_list['to']) || $request_list['status'])
                                        (
                                            @if ($request_list['date'])
                                                {{$request_list['date']}}
                                            @elseif($request_list['from'] && $request_list['to'])
                                                {{$request_list['from'] .' To '. $request_list['to']}}
                                            @endif
                                            @if ($request_list['status'])
                                                {{$request_list['status']}}
                                            @endif
                                        )
                                    @endif
                                </h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th>Sl</th>
                                                <th>Date</th>
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
                                                    <td>{{$purchase->supplier_invoice}}</td>
                                                    <td>{{$purchase->amount}}</td>
                                                    <td>{{$purchase->vat_amount}}</td>
                                                    <td>{{$purchase->total_amount}}</td>                                            
                                                    <td>{{$purchase->paid_price}}</td>
                                                    <td>{{$purchase->due_price}}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="3" class="text-right pr-2">Total</td>
                                                <td>{{$purchases->sum('amount')}}</td>
                                                <td>{{$purchases->sum('vat_amount')}}</td>
                                                <td>{{$purchases->sum('total_amount')}}</td>
                                                <td>{{$purchases->sum('paid_price')}}</td>
                                                <td>{{$purchases->sum('due_price')}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <h4 class="mt-1">
                                    Sale Balance
                                    @if ($request_list['date'] || ($request_list['from'] && $request_list['to']) || $request_list['status'])
                                        (
                                            @if ($request_list['date'])
                                                {{$request_list['date']}}
                                            @elseif($request_list['from'] && $request_list['to'])
                                                {{$request_list['from'] .' To '. $request_list['to']}}
                                            @endif
                                            @if ($request_list['status'])
                                                {{$request_list['status']}}
                                            @endif
                                        )
                                    @endif
                                </h4>                        
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th>Sl</th>
                                                <th>Date</th>
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
                                                    <td>{{$sale->invoice_no}}</td>
                                                    <td>{{$sale->price}}</td>
                                                    <td>{{$sale->vat_amount}}</td>
                                                    <td>{{$sale->total_price}}</td>                                            
                                                    <td>{{$sale->paid_amount}}</td>
                                                    <td>{{$sale->due_amount}}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="3" class="text-right pr-2">Total</td>
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
