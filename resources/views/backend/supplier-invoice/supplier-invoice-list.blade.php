@extends('layouts.backend.app')
@section('content')
@include('layouts.backend.partial.style')
<style>
    .table td{
        border-bottom: none;
    }
    .commonSelect2Style span{
        width: 100% !important;
    }
    .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b{
        display: none;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b{
        display: none;
    }

    .paid-status{
        background-color: #c2d8c7;
        color: #212529e8;
	}
    .partial-paid{
        background-color: #fbbc0099;
        color: #212529e8;
	}
    .unpaid-status{
        background-color: #ffc7ce;
        color: #212529e8;
	}
    .master-icon{
        margin-top: 15px !important;
    }
    .nav-link{
        padding: 0 12px 5px !important;
    }
</style>

<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @include('clientReport.business-operation.header',['activeMenu' => 'supplier_invoice'])
            <div class="tab-content bg-white">
                @include('backend.supplier-invoice.sub-head',['activeMenu' => 'supplier'])
                <div class="tab-pane active">
                    <div class="tab-pane active">
                        <div class="row" id="table-bordered">
                            <div class="col-12">
                                <div class="cardStyleChange">
                                    <section id="widgets-Statistics" class="pl-1">
                                        <form action="">
                                            <div class="row">
                                                <div class="col-md-5 changeColStyle">
                                                    <h4 class="pl-1 pt-2">Invoice List</h4>
                                                </div>
                                                <div class="row col-md-7">
                                                    <div class="col-md-3 changeColStyle">
                                                        <label for="">Single Date</label>
                                                        <input type="text" class="form-control inputFieldHeight" name="date"  placeholder="Search by Date" id="date">
                                                    </div>
                                                    <div class="col-md-3 changeColStyle">
                                                        <label for="">From Date</label>
                                                        <input type="text" class="form-control inputFieldHeight" name="from" placeholder="From"  id="from">
                                                    </div>
                                                    <div class="col-md-3 changeColStyle">
                                                        <label for="">To Date</label>
                                                        <input type="text" class="form-control inputFieldHeight" name="to" placeholder="To" id="to">
                                                    </div>
                                                    <div class="col-md-3 changeColStyle text-right pr-1 mt-2">
                                                        <button type="submit" class="btn btn-primary formButton mSearchingBotton" title="Searching">
                                                            <div class="d-flex">
                                                                <div class="formSaveIcon" style="margin-left: -10px;">
                                                                    <img  src="{{asset('assets/backend/app-assets/icon/searching-icon.png')}}" alt="" srcset=""  width="25">
                                                                </div>
                                                                <div><span> Search</span></div>
                                                            </div>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </section>
                                    <div class="card-body pt-0 ml-1 mr-1">
                                        <div class="table-responsive" style="min-height: 300px">
                                            <div class="table-responsive">
                                                <table class="table mb-0 table-sm">
                                                    <thead  class="thead-light">
                                                        <tr style="height: 50px;">
                                                            <th>SL No</th>
                                                            <th>Supplier</th>
                                                            <th>Invoice No</th>
                                                            <th>Date</th>
                                                            <th>Pay Mode</th>
                                                            <th>Amount </th>
                                                            <th class="text-right pr-3">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table-sm">
                                                        @foreach ($invoices as $invoice)
                                                        @php
                                                            $total_amount= $invoice->amount+$invoice->vat_amount;
                                                            if($invoice->paid_amount==0){
                                                                $status_name='unpaid-status';
                                                            }elseif($invoice->due_amount==0){
                                                                $status_name='paid-status';
                                                            }else{
                                                                $status_name='partial-paid';
                                                            }
                                                        @endphp
                                                        
                                                        <tr class="trFontSize {{$status_name}}">
                                                            <td>{{$loop->index+1}}</td>
                                                            <td>{{$invoice->supplier->pi_name}}</td>
                                                            <td>{{$invoice->invoice_no}}</td>
                                                            <td>{{ date('d/m/Y', strtotime($invoice->date)) }}</td>
                                                            <td>{{$invoice->pay_mode}}</td>
                                                            <td>{{$invoice->amount + $invoice->vat_amount}}</td>
                                                            <td class="text-right pr-1">
                                                                <a href="{{ route('supplier-invoice-sumview', $invoice->id)}}" class="btn" title="Supplier Invoice" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;">
                                                                    <img src="{{asset('assets/backend/app-assets/icon/invoice-icon.png')}}" style=" height: 30px; width: 30px;">
                                                                </a>
                                                                <a href="{{ route('supplier-invoice-view', $invoice->id)}}" class="btn " title="Invoice Details" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;">
                                                                    <img src="{{asset('assets/backend/app-assets/icon/view-icon.png')}}" style=" height: 30px; width: 30px;">
                                                                </a>
                                                                {{-- <a href="{{ route('supplier-invoice-sumview', $invoice->id)}}" class="btn " title="Edit" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;">
                                                                    <img src="{{asset('assets/backend/app-assets/icon/payment-icon.png')}}" style=" height: 30px; width: 30px;">
                                                                </a> --}}
                                                            </td>
                                                        </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@push('js')
<script>
    $(document).on("click", ".truckInfoEdit", function(e){
        e.preventDefault();
        $("#truckInfoEditModal").modal('show');
    });
</script>
@endpush
