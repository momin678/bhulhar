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

    /* .unpaid-status{
        background-color: #c2d8c7;
        color: #212529e8;
	}
    .paid-status{
        background-color: #fbbc0099;
        color: #212529e8;
	}
    .partial-paid{
        background-color: #ffc7ce;
        color: #212529e8;
	} */

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
        padding: 0 18px 5px !important;
    }
    .action-padding{
        padding-right: 100px !important;
    }
</style>

<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @include('clientReport.customer-inv._header')

            <div class="tab-content bg-white">
                <div class="tab-pane active">
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="cardStyleChange">
                                <section id="widgets-Statistics" class="pl-1 mt-2">
                                    <form action="">
                                        <div class="row">
                                            <div class="col-md-5 changeColStyle">
                                                <h4 class="pl-1 pt-2">Invoice List</h4>
                                            </div>
                                        </div>
                                    </form>
                                </section>
                                <div class="card-body pt-0 ml-1 mr-1">
                                    <div class="table-responsive" style="min-height: 300px">
                                        <form action="{{route('multiple-draft-invoice')}}" method="POST">
                                            @csrf
                                            <div class="table-responsive">
                                                <table class="table mb-0 table-sm">
                                                    <thead  class="thead-light">
                                                        <tr style="height: 50px;">
                                                            <th>
                                                                <input type="checkbox" id="vehicle1" class="btn-select-all">
                                                                <label for="vehicle1">Select All</label>
                                                            </th>
                                                            <th>Customer</th>
                                                            <th>Invoice No</th>
                                                            <th>Date</th>
                                                            <th>Pay Mode</th>
                                                            <th>Amount </th>
                                                            <th class="text-right action-padding">Action</th>
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
                                                            <td>
                                                                <input type="checkbox" class="checkbox-record" name="records[]" value="{{$invoice->id}}">
                                                            </td>
                                                            {{-- <td></td> --}}
                                                            <td>{{$invoice->customer->pi_name}}</td>
                                                            <td>{{$invoice->invoice_no}}</td>
                                                            <td>{{ date('d/m/Y', strtotime($invoice->date)) }}</td>
                                                            <td>{{$invoice->pay_mode}}</td>
                                                            <td>{{$invoice->items->sum('amount')+$invoice->items->sum('vat_amount')+$invoice->items->sum('toll_fee')-$invoice->items->sum('discount')}}</td>
                                                            <td class="text-right pr-2">
                                                                <a href="{{ route('draft-invoice-submit', $invoice->id)}}" class="btn" title="Submit" onclick="return confirm('Are you sure to Submit this?')" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px; padding-left:5px;">
                                                                    <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" style=" height: 30px; width: 30px;">
                                                                </a>
                                                                <a href="{{ route('draft-invoice-print', $invoice->id)}}" target="_blank" class="btn" title="Print" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px; padding-left:5px;">
                                                                    <img src="{{asset('assets/backend/app-assets/icon/print-icon.png')}}" style=" height: 30px; width: 30px;">
                                                                </a>
                                                                <a href="{{ route('draft-invoice-preview', $invoice->id)}}" class="btn" title="Preview" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px; padding-left:5px;">
                                                                    <img src="{{asset('assets/backend/app-assets/icon/view-icon.png')}}" style=" height: 30px; width: 30px;">
                                                                </a>
                                                                <a href="{{ route('draft-invoice-edit', $invoice->id)}}" class="btn" title="Edit" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px; padding-left:5px;">
                                                                    <img src="{{asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;">
                                                                </a>
                                                                @if ($invoice->status=='Draft' && $invoice->created_by==Auth::id())
                                                                <a href="{{ route('delete-customer-inv', $invoice->id)}}"  class="btn " title="Delete" onclick="return confirm('Are you sure to delete this?')"  style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px; padding-left:5px;">
                                                                    <img src="{{asset('assets/backend/app-assets/icon/delete-icon.png')}}" style=" height: 30px; width: 30px;">
                                                                </a>
                                                                @endif
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
