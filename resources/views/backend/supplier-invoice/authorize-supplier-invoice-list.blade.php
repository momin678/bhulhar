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
                @include('backend.supplier-invoice.sub-head',['activeMenu' => request()->is('business-operation/authorize-supplier-invoice*')?'authorize':(request()->is('business-operation/approval-supplier-invoice*')?'approved':(request()->is('business-operation/declined-supplier-invoice*')?'declined':'supplier'))])
                <div class="tab-pane active">
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="cardStyleChange">
                                <div class="card-body pt-0 ml-1 mr-1">
                                    <div class="table-responsive" style="min-height: 300px">
                                        <div class="table-responsive">
                                            <table class="table mb-0 table-sm table-hover">
                                                <thead  class="thead-light">
                                                    <tr style="height: 50px;">
                                                        <th>SL No</th>
                                                        <th>Supplier</th>
                                                        <th>Invoice No</th>
                                                        <th>Date</th>
                                                        <th>Pay Mode</th>
                                                        <th>Amount </th>
                                                        <th>Status </th>
                                                        <th class="pl-3">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-sm">
                                                    @foreach ($invoices as $invoice)
                                                    <tr class="trFontSize">
                                                        <td>{{$loop->index+1}}</td>
                                                        <td>{{$invoice->supplier->pi_name}}</td>
                                                        <td>{{$invoice->invoice_no}}</td>
                                                        <td>{{ date('d/m/Y', strtotime($invoice->date)) }}</td>
                                                        <td>{{$invoice->pay_mode}}</td>
                                                        <td>{{$invoice->amount+$invoice->vat_amount}}</td>
                                                        <td>
                                                            @if ($invoice->status=='Decline')
                                                                <span class="badge badge-danger">Declined</span>
                                                            @elseif($invoice->status=='Authorize')
                                                                <span class="badge badge-dark">Pending</span>    
                                                            @endif
                                                        </td>
                                                        <td class="">
                                                            {{-- <a href="{{ route('supplier-invoice-sumview', $invoice->id)}}" class="btn " title="Edit" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;">
                                                                <img src="{{asset('assets/backend/app-assets/icon/invoice-icon.png')}}" style=" height: 30px; width: 30px;">
                                                            </a> --}}
                                                            <a href="{{ route('pre-supplier-invoice-view', $invoice->id)}}" class="btn " title="View" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;">
                                                                <img src="{{asset('assets/backend/app-assets/icon/view-icon.png')}}" style=" height: 30px; width: 30px;">
                                                            </a>
                                                            @if ($invoice->status=='Authorize' && $invoice->created_by==Auth::id())
                                                            <a href="{{ route('delete-supplier-inv', $invoice->id)}}"  class="btn " title="Delete" onclick="return confirm('Are you sure to delete this?')"  style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;">
                                                                <img src="{{asset('assets/backend/app-assets/icon/delete-icon.png')}}" style=" height: 30px; width: 30px;">
                                                            </a>
                                                            @endif
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


@endsection
@push('js')
<script>
    $(document).on("click", ".truckInfoEdit", function(e){
        e.preventDefault();
        $("#truckInfoEditModal").modal('show');
    });
</script>
@endpush
