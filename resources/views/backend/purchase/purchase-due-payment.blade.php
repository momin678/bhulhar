
@extends('layouts.backend.app')
@push('css')
@include('layouts.backend.partial.style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@endpush
@section('content')
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @include('clientReport.purchase.pruchase_header',['activeMenu'=>'due-payment'])
            <div class="tab-content bg-white">
                <div class="tab-pane active">
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="cardStyleChange">
                                <section id="widgets-Statistics" class="p-2">
                                    <div class="table-responsive pt-1">
                                        <table class="table table-sm table-hover">
                                            <thead  class="thead-light">
                                                <tr class="mTheadTr">
                                                    <th>Date</th>
                                                    <th>Invoice Number</th>
                                                    <th>Supplier Name</th>
                                                    <th class="text-right">Total Amount</th>
                                                    <th class="text-right">Paid Amount</th>
                                                    <th class="text-right">Due Amount</th>
                                                    <th class="text-right pr-2">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="user-table-body filter-table">
                                                @foreach ($due_purchases as $item)
                                                    <tr>
                                                        <td>{{ date('d/m/Y', strtotime($item->date)) }}</td>
                                                        <td>{{$item->purchase_no}}</td>
                                                        <td>{{$item->partyInfo($item->customer_name)->pi_name}}</td>
                                                        <td class="text-right">{{$item->total_price}}</td>
                                                        <td class="text-right">{{$item->paid_price}}</td>
                                                        <td class="text-right">{{$item->due_price}}</td>
                                                        <td style="padding-bottom: 11px; padding-top: 0px">
                                                            <div class="d-flex justify-content-end">
                                                                <a href="{{ route('purchaseView', $item) }}" class="btn mVoucherPreview" style="height: 30px; width: 30px;" title="Preview" >
                                                                    <img src="{{ asset('assets/backend/app-assets/icon/view-icon.png')}}" style=" height: 30px; width: 30px; margin-left: -12px;">
                                                                </a>
                                                                <a href="{{ route('purchase-due-pay', $item) }}" class="btn mVoucherPreview" style="height: 30px; width: 30px;" title="Payment" >
                                                                    <img src="{{ asset('assets/backend/app-assets/icon/expenses-icon.png')}}" style=" height: 30px; width: 30px; margin-left: -12px;">
                                                                </a>
                                                            </div>
                                                         </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

