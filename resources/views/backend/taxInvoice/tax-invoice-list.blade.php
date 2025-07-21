@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>
        .table .thead-light th {
            color:#F2F4F4 ;
            background-color: #34465b;
            border-color: #DFE3E7;
            font-size: 12px !important;
        }
        .table tr td{
            font-size: 10px !important;
        }
        .soft-delete{
            background-color: #ff00003f !important;
        }
    </style>
@endpush
@section('content')
@include('layouts.backend.partial.style')

    <div class="app-content content print-hidden">
        <div class="content-overlay"></div>
        <div class="content-wrapper">

            <div class="content-body">
                
                @include('backend.taxInvoice.top-header', ['activeMenu' => 'list'])
                <div class="tab-content">
                    <div class="tab-pane bg-white active">
                        <section id="widgets-Statistics">
                            <form action="#" id="formSubmit" method="post">
                                <div class="row p-1">
                                    <div class="col-md-2">
                                        <label for="">Category</label>
                                        <select name="category_id" class="inputFieldHeight common-select2" onchange="purchase_filter()" style="width: 100% !important">
                                            <option value="">Select...</option>
                                            @foreach ($categories as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div class="col-md-1">
                                        <label for="">V Brand</label>
                                        <select name="brand_id" class="inputFieldHeight" style="max-width: 80px !important;" onchange="purchase_filter()">
                                            <option value="">Select...</option>
                                            @foreach ($brands as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <label for="">V Name</label>
                                        <select name="vehicle_name_id" class="inputFieldHeight" style="max-width: 80px !important;" onchange="purchase_filter()">
                                            <option value="">Select...</option>
                                            @foreach ($vehicle_names as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <label for="">V Mode</label>
                                        <select name="vehicle_model_id" class="inputFieldHeight" style="max-width: 80px !important;" onchange="purchase_filter()">
                                            <option value="">Select...</option>
                                            @foreach ($vehicle_models as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }} </option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div class="col-md-2">
                                        <label for="">Item Code</label>
                                        <select name="item_code_id" class="inputFieldHeight common-select2" onchange="purchase_filter()"  style="width: 100% !important">
                                            <option value="">Select...</option>
                                            @foreach ($item_codes as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1" >
                                        <label for="">Invoice</label>
                                        <input type="text" name="invoice_no" class="inputFieldHeight" placeholder="Invoice No" style="max-width: 80px !important;" onkeyup="purchase_filter()">
                                    </div>
                                    <div class="col-md-1">
                                        <label for="">Date</label>
                                        <input type="text" name="date" class="date inputFieldHeight" placeholder="Date" style="max-width: 80px !important;" onchange="purchase_filter()">
                                    </div>
                                    <div class="col-md-1">
                                        <label for="">From</label>
                                        <input type="text" name="from" class="date inputFieldHeight" placeholder="From Date" style="max-width: 80px !important;" onchange="purchase_filter()">
                                    </div>
                                    <div class="col-md-1">
                                        <label for="">To</label>
                                        <input type="text" name="to" class="date inputFieldHeight" placeholder="To Date" style="max-width: 80px !important;" onchange="purchase_filter()">
                                    </div>
                                    <div class="col-md-3" style="padding-right: 5px !important;">
                                        <label for="">Customer Name</label>
                                        <select name="customer_name" id="customer_name" class="common-select2 party-info customer" style="width: 100% !important" onchange="purchase_filter()">
                                            <option value="">Select...</option>
                                            @foreach ($suppliers as $customer)
                                                <option value="{{ $customer->pi_code }}" >
                                                    {{ $customer->pi_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1" style="padding-left: 0 !important;">
                                        <label for="">P Mode</label>
                                        <select name="status" class="inputFieldHeight" style="max-width: 80px !important;" onchange="purchase_filter()">
                                            <option value="">Select...</option>
                                            <option value="Paid">Paid</option>
                                            <option value="Due">Due</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <table class="table table-bordered table-sm">
                                <thead  class="thead-light">
                                    <tr class="text-center" style="height: 40px;">
                                        <th>Invoice No</th>
                                        <th>Date</th>
                                        {{-- <th>Customer Name</th> --}}
                                        <th>Item</th>
                                        {{-- <th>Vehicle Brand</th>
                                        <th>Vehicle Name</th>
                                        <th>Vehicle Model</th> --}}
                                        <th>Item Code</th>
                                        <th>QTY</th>
                                        <th>Rate</th>
                                        <th>Amount</th>
                                        <th>Vat</th>
                                        <th>Total</th>
                                        <th>Paid</th>
                                        <th>Due</th>
                                    </tr>
                                </thead>
                                <tbody class="t-body" id="invoice_show">
                                    @foreach ($tax_invoices as $tax_invoice)
                                        @foreach ($tax_invoice->invoice_items as $key => $item)
                                            <tr id="{{$tax_invoice->id}}" class="sale-view {{$tax_invoice->deleted_at?'soft-delete':''}}" >
                                                @if ($key == 0)
                                                    <td rowspan="{{count($tax_invoice->invoice_items)}}">{{$tax_invoice->invoice_no}}</td>
                                                @endif
                                                @if ($key == 0)
                                                    <td rowspan="{{count($tax_invoice->invoice_items)}}">{{date('d/m/Y', strtotime($tax_invoice->date))}}</td>
                                                @endif
                                                {{-- @if ($key == 0)
                                                    <td rowspan="{{count($tax_invoice->invoice_items)}}">{{$tax_invoice->partyInfo($tax_invoice->customer_name)?$tax_invoice->partyInfo($tax_invoice->customer_name)->pi_name:''}}</td>
                                                @endif --}}
                                                <td>{{$item->category->name}}</td>
                                                {{-- <td>{{$item->brand->name}}</td>
                                                <td>{{$item->vehicle_name->name}}</td>
                                                <td>{{$item->subBrand->name}}</td> --}}
                                                <td>{{$item->item_code->name}}</td>
                                                <td>{{$item->quantity}}</td>
                                                <td>{{$item->unit_price}}</td>
                                                <td>{{$item->price}}</td>
                                                <td>{{$item->vat}}</td>
                                                <td>{{$item->total_price}}</td>
                                                @if ($key == 0)
                                                    <td rowspan="{{count($tax_invoice->invoice_items)}}">{{$tax_invoice->paid_amount}}</td>
                                                    <td rowspan="{{count($tax_invoice->invoice_items)}}">{{$tax_invoice->due_amount}}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg"  id="purchase_previewModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div id="purchase_preview">
    
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade bd-example-modal-lg"  id="tax_invoice_previewModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div id="tax_invoice_preview">
                
            </div>
          </div>
        </div>
    </div>
    <!-- End Modal -->
@endsection

@push('js')
    <script>
        function purchase_filter(e){
            var form = $('#formSubmit');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('tax-invoice-filter') }}",
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    $('#invoice_show').html(response);
                }
            });
        }
        $(document).on("click", ".sale-view", function(e) {
            var invoice_id = $(this).attr('id');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('tax-invoice-view') }}",
                method: "POST",
                data: {
                    invoice_id: invoice_id,
                    _token: _token,
                },
                success: function(response) {
                    document.getElementById("tax_invoice_preview").innerHTML = response;
                    $('#tax_invoice_previewModal').modal('show');
                }
            })
        });
    </script>
@endpush



