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
    .nav-item{
        padding: 0 18px 5px !important;
    }
</style>

<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @include('clientReport.business-operation.header',['activeMenu' => 'customer_invoice'])

            <div class="tab-content bg-white">
                @include('backend.customer-invoice.sub-head',['activeMenu' => 'toll_fee_invoice'])
                <div class="tab-pane active">
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="card cardStyleChange">
                                <div class="row" id="table-bordered">
                                    <div class="col-12">
                                        <div class="cardStyleChange p-2">
                                            <div class="d-flex">
                                                <h4 class="flex-grow-1">Search Invoice</h4>
                                            </div>
                                            <section id="widgets-Statistics" class="mt-2 mb-1 pl-1 d-none">
                                                <form action="">
                                                    <div class="row">
                                                        <div class="col-md-5 changeColStyle">
                                                            <label for="">Search Invoice</label>
                                                            <select name="customer_id" class="inputFieldHeight form-control common-select2">
                                                                <option value="">Select Customer</option>
                                                                @foreach ($customers as $customer)
                                                                <option value="{{$customer->id}}" {{ isset($customer_id)&& $customer_id==$customer->id ? 'selected': ''}} >{{ $customer->pi_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="row col-md-7">
                                                            <div class="col-md-3 changeColStyle">
                                                                <label for="">Single Date</label>
                                                                <input type="text" class="form-control inputFieldHeight" name="date" placeholder="Search by Date" onfocus="(this.type='date')" id="date">
                                                            </div>
                                                            <div class="col-md-3 changeColStyle">
                                                                <label for="">From Date</label>
                                                                <input type="text" class="form-control inputFieldHeight" name="from" placeholder="From" onfocus="(this.type='date')"  id="from">
                                                            </div>
                                                            <div class="col-md-3 changeColStyle">
                                                                <label for="">To Date</label>
                                                                <input type="text" class="form-control inputFieldHeight" name="to" placeholder="To" onfocus="(this.type='date')" id="to">
                                                            </div>
                                                            <div class="col-md-3 changeColStyle text-right mt-2">
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
                                            <div class="table-responsive" style="min-height: 300px">
                                                <div class="table-responsive">
                                                    <table class="table mb-0 table-sm">
                                                        <thead  class="thead-light">
                                                            <tr style="height: 50px;">
                                                                <th>Customer</th>
                                                                <th>Invoice No</th>
                                                                <th>Date</th>
                                                                <th>Stage</th>
                                                                <th class="text-right">Amount </th>
                                                                <th class="text-right pr-2">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="table-sm">
                                                            @foreach ($invoices as $invoice)
                                                            <tr class="trFontSize">
                                                                <td>{{$invoice->customer->pi_name}}</td>
                                                                <td>{{$invoice->invoice_no}}</td>
                                                                <td>{{ date('d/m/Y', strtotime($invoice->date)) }}</td>
                                                                <td><span class="badge badge-success">{{$invoice->status}}</span></td>
                                                                <td class="text-right">{{$invoice->amount}}</td>
                                                                <td class=" text-right pr-1">
                                                                    <a href="{{ route('toll-fee-invoice-sumview', $invoice->id)}}" class="btn" title="Tax Invoice" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;">
                                                                        <img src="{{asset('assets/backend/app-assets/icon/invoice-icon.png')}}" style=" height: 30px; width: 30px;">
                                                                    </a>
                                                                    <a href="{{ route('toll-fee-invoice.show', $invoice->id)}}" class="btn" title="Invoice Details" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;">
                                                                        <img src="{{asset('assets/backend/app-assets/icon/view-icon.png')}}" style=" height: 30px; width: 30px;">
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                            @foreach ($invoices_temp as $invoice)
                                                            <tr class="trFontSize">
                                                                <td>{{$invoice->customer->pi_name}}</td>
                                                                <td>{{$invoice->invoice_no}}</td>
                                                                <td>{{ date('d/m/Y', strtotime($invoice->date)) }}</td>
                                                                <td><span class="badge badge-dark">Pending</span></td>
                                                                <td class="text-right">{{$invoice->amount}}</td>
                                                                <td class=" text-right pr-1">
                                                                    <a href="{{ route('temp-toll-invoice-view.show', $invoice->id)}}" class="btn" title="Temp Invoice Details" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;">
                                                                        <img src="{{asset('assets/backend/app-assets/icon/view-icon.png')}}" style=" height: 30px; width: 30px;">
                                                                    </a>
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
