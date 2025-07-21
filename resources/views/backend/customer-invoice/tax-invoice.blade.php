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
        /* display: none; */
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b{
        /* display: none; */
    }
    .master-icon{
        margin-top: 15px !important;
    }
    .nav-link{
        padding: 0 18px 5px !important;
    }
    .action-padding{
        padding-right: 80px !important;
    }
</style>

<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @include('clientReport.business-operation.header',['activeMenu' => 'customer_invoice'])

            <div class="tab-content bg-white">
                @include('backend.customer-invoice.sub-head',['activeMenu' => request()->is('business-operation/invoice-approval-list')?'pending':'declined'])
                <div class="tab-pane active">
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="cardStyleChange">
                                <div class="card-header">
                                    <div class="d-flex">
                                        <h4 class="flex-grow-1">Invoice List</h4>
                                        <div class="mr-1">
                                            <form action="" class="row">
                                                <div>
                                                    <select name="user_id" id="" class="form-controll common-select2">
                                                        <option value="">All Users------</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn_create formButton ml-1 mSearchingBotton" title="Add" data-toggle="modal" data-target="#newTruckAddModal">
                                                    <div class="d-flex">
                                                        <div class="formSaveIcon">
                                                            <img src="{{asset('assets/backend/app-assets/icon/searching-icon.png')}}" width="25">
                                                        </div>
                                                        <div><span>Search</span></div>
                                                    </div>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <form  method="get">
                                                <div class="form-group">
                                                    {{-- <input type="text" class="inputFieldHeight form-control " name="search" placeholder="Search by Truck Number"> --}}
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0 ml-1 mr-1">
                                    <div class="table-responsive" style="min-height: 300px">
                                        @if (Route::current()->getName() == 'invoice-approval-list')
                                            <form action="{{route('multiple-approval-invoice')}}" method="POST">
                                        @else
                                            <form action="{{route('multiple-authorize-invoice')}}" method="POST">
                                        @endif
                                            @csrf
                                            <div class="table-responsive">
                                                <table class="table mb-0 table-sm table-hover">
                                                    <thead  class="thead-light">
                                                        <tr style="height: 50px;">
                                                            <th>
                                                                <input type="checkbox" id="vehicle1" class="btn-select-all">
                                                                <label for="vehicle1">S All</label>
                                                            </th>
                                                            <th>Customer</th>
                                                            <th>Invoice No</th>
                                                            <th>Date</th>
                                                            {{-- <th>Pay Mode</th> --}}
                                                            <th>Amount </th>
                                                            <th>Status</th>
                                                            <th>Created By</th>
                                                            @if (Route::current()->getName() == 'invoice-approval-list')
                                                                <th>Authorized by</th>
                                                            @endif
                                                            <th class="text-right action-padding">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table-sm">
                                                        @foreach ($invoices as $invoice)
                                                        <tr class="trFontSize">
                                                            <td>
                                                                <input type="checkbox" class="checkbox-record" name="records[]" value="{{$invoice->id}}">
                                                            </td>
                                                            <td>{{$invoice->customer->pi_name}}</td>
                                                            <td>{{$invoice->invoice_no}}</td>
                                                            <td>{{ date('d/m/Y', strtotime($invoice->date)) }}</td>
                                                            {{-- <td>{{$invoice->pay_mode}}</td> --}}
                                                            <td>{{$invoice->total_amount}}</td>
                                                            <td>
                                                                @if ($invoice->status=='Decline')
                                                                    <span class="badge badge-danger">Declined</span>
                                                                @elseif($invoice->status=='Authorize' || $invoice->status=='Approve')
                                                                    <span class="badge badge-dark">Pending</span>
                                                                @elseif($invoice->status=='Draft')
                                                                <span class="badge badge-dark">Draft</span>
                                                                @endif
                                                            </td>
                                                            <td>{{$invoice->created_by_user->name}}</td>
                                                            @if (Route::current()->getName() == 'invoice-approval-list')
                                                                <td>{{$invoice->authorized_by_user->name}}</td>
                                                            @endif
                                                            <td class="text-right pr-1">
                                                                <a href="{{ route('authorize-invoice', ['type' => 'customer-invoice', 'id' => $invoice->id])}}" onclick="return confirm('Are you sure to Submit this?')" class="btn" title="Submit" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px; padding-left:5px;">
                                                                    <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" style=" height: 30px; width: 30px;">
                                                                </a>
                                                                <a href="{{ route('temp-invoice-view', $invoice->id)}}" class="btn" title="Authorize" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px; padding-left:5px;">
                                                                    <img src="{{asset('assets/backend/app-assets/icon/view-icon.png')}}" style=" height: 30px; width: 30px;">
                                                                </a>
                                                                <a href="{{ route('temp-invoice-sumview', $invoice->id)}}" class="btn" title="Tax Invoice" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px; padding-left:5px;">
                                                                    <img src="{{asset('assets/backend/app-assets/icon/invoice-icon.png')}}" style=" height: 30px; width: 30px;">
                                                                </a>
                                                                <a href="{{ route('customer-invoice-edit', $invoice->id)}}"  class="btn" title="Edit" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px; padding-left:5px;">
                                                                    <img src="{{asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;">
                                                                </a>

                                                                <a href="{{ route('delete-customer-inv', $invoice->id)}}"  class="btn " title="Delete" onclick="return confirm('Are you sure to delete this?')"  style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px; padding-left:5px;">
                                                                    <img src="{{asset('assets/backend/app-assets/icon/delete-icon.png')}}" style=" height: 30px; width: 30px;">
                                                                </a>


                                                            </td>
                                                        </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                            @if (count($invoices)>0)
                                                <button type="submit" class="btn btn-primary formButton mt-2" title="Submit"  onclick="return confirm('Are you sure to Submit this?')">
                                                    <div class="d-flex">
                                                        <div class="formSaveIcon">
                                                            <img src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" width="20">
                                                        </div>
                                                        <div><span>Submit</span></div>
                                                    </div>
                                                </button>
                                            @endif
                                        </form>
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
    $('.btn-select-all').click(function (event) {
        if (this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function () {
                this.checked = true;
            });
        } else {
            $(':checkbox').each(function () {
                this.checked = false;
            });
        }
    });
</script>
@endpush
