@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <style>
        .table-bordered {
            border: 1px solid #f4f4f4;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }

        table {
            background-color: transparent;
        }

        table {
            border-spacing: 0;
            border-collapse: collapse;
        }


        .tarek-container{
    width: 85%;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 88% 12%;
    background-color: #ffff;
}

.invoice-label{
    font-size: 10px !important
}

    </style>
@endpush
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">

            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="row">
                                <h4>Purchase</h4>
                                <hr>
                            </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="card d-flex align-items-center" style="min-height: 180px">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Branch</label>
                                                        <select name="branch" class="form-control" id="" readonly disabled>
                                                            <option value="">Select...</option>
                                                            @foreach ($projects as $item)
                                                                <option value="{{ $item->proj_no }}" {{ $purchase->project_id==$item->id? "selected":"" }}>{{ $item->proj_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-3 form-group">
                                                        <label for="">GL Code</label>
                                                       <input type="text" name="gl_code" id="gl_code" value="{{ $purchase->gl_code }}" class="form-control" disabled>

                                                    </div>

                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Purchase No</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $purchase->purchase_no }}" name="invoice_no"
                                                            id="invoice_no" readonly >
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Supplier Name</label>
                                                        <select name="customer_name" id="customer_name"
                                                            class="form-control party-info" data-target="" readonly disabled>
                                                            <option value="">Select...</option>
                                                            @foreach ($customers as $customer)
                                                                <option value="{{ $customer->cc_code }}" {{ $purchase->customer_name==$customer->pi_code? "selected":"" }}>
                                                                    {{ $customer->pi_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">TRN</label>
                                                        <input type="text" class="form-control" value="{{  $purchase->trn_no }}" name="trn_no" id="trn_no"
                                                            class="form-control" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Payment Mode</label>
                                                        <select name="pay_mode" id="" class="form-control" readonly disabled>
                                                            <option value="">Select...</option>
                                                            @foreach ($modes as $item)
                                                                <option value="{{ $item->title }}" {{ $purchase->pay_mode==$item->title? "selected":"" }}>{{ $item->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Payment Terms </label>
                                                        <select name="pay_terms" id="pay_terms" class="form-control"
                                                            readonly disabled>
                                                            <option value="">Select...</option>

                                                            @foreach ($terms as $item)
                                                                <option value="{{ $item->value }}" {{ $purchase->pay_terms==$item->value? "selected":"" }}>{{ $item->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Due Date</label>
                                                        <input type="text" value="{{ date('d/m/Y', strtotime($purchase->due_date)) }}" class="form-control" name="due_date"
                                                            id="due_date" readonly disabled>
                                                    </div>

                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Contact Number</label>
                                                        <input type="text" value="{{ $purchase->contact_no }}" class="form-control" name="contact_no"
                                                            id="contact_no" readonly disabled>
                                                    </div>

                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Address</label>
                                                        <input type="text" value="{{ $purchase->address }}" class="form-control" name="address"
                                                            id="address" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-3 form-group date-field">
                                                        <label for="">Date</label>
                                                        <input type="text"
                                                            value="{{ date('d/m/Y', strtotime($purchase->date)) }}"
                                                            class="form-control" name="date" id="date" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-3 form-group date-field">
                                                        <label for="">Supplier Invoice</label>
                                                        <input type="text"
                                                            value="{{ $purchase->supplier_invoice }}"
                                                            class="form-control" name="date" id="date" readonly disabled>
                                                    </div>

                                                    {{-- <div class="col-sm-1 d-flex align-items-center date-field">
                                                        <span class="btn btn-sm btn-warning date-field" id="edit_click"><i class="bx bx-edit"></i></span>
                                                    </div>

                                                    <div class="col-sm-3 form-group update-date-field" style="display: none">
                                                        <label for="">Date</label>
                                                        <input type="date"
                                                            value="{{ $purchase->date }}"
                                                            class="form-control" name="update_date" id="update_date" required>
                                                    </div>
                                                    <div class="col-sm-1 d-flex align-items-center  ">
                                                        <span class="btn btn-sm btn-warning update-date-field" style="display: none" id="edit_button"><i class="bx bx-save"></i></span>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row pb-1">
                                    <div class="col-12">

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        <label class="invoice-label" for="">Barcode</label>
                                                        <input type="text" class="form-control item-select-by-term"
                                                            placeholder="Barcode"  name="barcode" id="barcode"readonly disabled>

                                                    </div>

                                                    <div class="col-sm-7 search-item">
                                                        <label class="invoice-label" for="">Item Name</label>
                                                        <select name="item_name" id="item_name" class="form-control"readonly disabled>
                                                            <option value="">Select</option>
                                                            @foreach ($itms as $item)
                                                            <option value="{{ $item->barcode }}">{{ $item->item_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <label class="invoice-label" for="">QTY</label>
                                                        <input type="number" class="form-control" name="quantity"
                                                            id="quantity" readonly disabled>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <label class="invoice-label" for="">Unit Price</label>
                                                        <input type="text" class="form-control" name="unit_price"
                                                            id="unit_price" readonly disabled>
                                                    </div>



                                                    <div class="col-sm-2">
                                                        <label class="invoice-label" for="">Net Amount</label>
                                                        <input type="text" class="form-control" name="net_amount"
                                                            id="net_amount" readonly disabled>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <label class="invoice-label" for="">Cost Price</label>
                                                        <input type="text" class="form-control" name="cost_price"
                                                            id="cost_price" readonly disabled>
                                                    </div>
                                                    <div class="col-sm-2 ">
                                                        <label for=""></label>
                                                        <div class="row">
                                                            <input type="button" name="temp_invoice" class="btn btn-warning" value="Add" id="temp_invoice" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div> --}}

                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Category</th>
                                                <th>Brand</th>
                                                <th>Unit Price</th>
                                                <th>Quantity</th>
                                                <th>Unit</th>
                                                <th>Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody class="all-data-area">
                                            @foreach (App\PurchaseItem::where('purchase_id',$purchase->id)->get() as $item)
                                            <tr class="data-row">
                                                <td>{{ $item->product->name }}</td>
                                                <td>{{ $item->category->name }}</td>
                                                <td>{{ isset( $item->brand)?$item->brand->name:"" }}</td>
                                                <td>{{ $item->unit_price }}</td>
                                                <td>{{ number_format($item->amount,0) }}</td>
                                                <td>{{ $item->unitP->name}}</td>
                                                <td>{{$item->price}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            <div class="row pt-1">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="" class="align-items-center">Total Vat (AED):</label>
                                        @if ($purchase->pay_mode == "Cash")
                                        <input type="number" name="total_gross" placeholder="Final Discount" min="0" step="any" class="form-control" value="{{number_format((float)(  $purchase->vatAmount()), 0,'.','') }}"
                                        id="total_gross" readonly>
                                        @else
                                        <input type="number" name="total_gross" placeholder="Final Discount" min="0" step="any" class="form-control" value="{{number_format((float)(  $purchase->vatAmount()), 2,'.','') }}"
                                        id="total_gross" readonly>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3 d-none">
                                    <div class="form-group">
                                        <label for="" class="align-items-center">Discount (AED):</label>
                                        @if ($purchase->pay_mode == "Cash")
                                        <input type="number" name="discount_price" placeholder="Final Discount" min="0" step="any" class="form-control" value="{{number_format($purchase->discount_price,0)}}"
                                        id="discount_price" readonly>
                                        @else
                                        <input type="number" name="discount_price" placeholder="Final Discount" min="0" step="any" class="form-control" value="{{number_format($purchase->discount_price,2)}}"
                                        id="discount_price" readonly>
                                        @endif
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="" class="align-items-center">Total Amount (AED):</label>
                                        @if ($purchase->pay_mode == "Cash")
                                        <input type="number" name="total_gross" placeholder="Final Discount" wire:min="0" step="any" class="form-control" value="{{number_format((float)(  $purchase->TotalAmount()), 0,'.','') }}"
                                        id="total_gross" readonly>
                                        @else
                                        <input type="number" name="total_gross" placeholder="Final Discount" wire:min="0" step="any" class="form-control" value="{{number_format((float)(  $purchase->TotalAmount()), 2,'.','') }}"
                                        id="total_gross" readonly>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="" class="align-items-center">Paid (AED):</label>
                                        @if ($purchase->pay_mode == "Cash")
                                        <input type="number" name="paid_price" placeholder="Final Discount" min="0" step="any" class="form-control" value="{{number_format($purchase->paid_price,0)}}"
                                        id="paid_price" readonly>
                                        @else
                                        <input type="number" name="paid_price" placeholder="Final Discount" min="0" step="any" class="form-control" value="{{number_format($purchase->paid_price,2)}}"
                                        id="paid_price" readonly>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="" class=" align-items-center">Due (AED):</label>
                                        @if ($purchase->pay_mode == "Cash")
                                        <input type="number" name="due" placeholder="Final Discount" min="0" step="any" class="form-control" value="{{number_format($purchase->due_price-$purchase->discount_price,2)}}" id="due" required readonly>
                                        <input type="hidden" name="purchase_due_id" id="purchase_due_id" value="{{ $purchase->id }}">
                                        @else
                                        <input type="number" name="due" placeholder="Final Discount" min="0" step="any" class="form-control" value="{{number_format($purchase->due_price-$purchase->discount_price,2)}}" id="due" required readonly>
                                        <input type="hidden" name="purchase_due_id" id="purchase_due_id" value="{{ $purchase->id }}">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                 <a  class="btn btn-sm btn-warning" href="{{ route('purchase.index') }}">New</a>
                                 @if($purchase->delivery_note_id==null)
                                   {{-- <a href="{{ route('invoiceEdit',$purchase) }}" class="btn btn-sm btn-primary">Edit</a> --}}
                                   @endif
                                   <a href="{{ route('purchasePrint', $purchase) }}" class="btn btn-sm btn-secondary" id="invoice_print" target="_blank">print</a>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-2">
                            <div class="row">
                                <h5 style="white-space: nowrap;">Purchases </h5>
                                <input type="text" class="form-control w-100" placeholder="Serach Purchase No" name="invoice_no" id="invoice_no_s">
                                <i class="bx bx-refresh btn btn-sm" id="refresh_invoice">Refresh</i>
                                <div class="invoice-items">
                                    <ul>
                                        @foreach ($purchases as $purch)
                                        <li><a href="{{ route('purchaseView', $purch) }}">{{ $purch->purchase_no }}</a></li>

                                        @endforeach
                                    </ul>



                                </div>
                                <hr>
                            </div>

                        </div>
                    </div>

                </section>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>

function refreshPage(){
    window.location.reload();
}
        $(document).ready(function() {

            $('#due_pay').click(function() {
                // return confirm('Are You Sure?');
                var due = $('#due').val();
                var purchase_due_id = $('#purchase_due_id').val();
                var _token = $('input[name="_token"]').val();
                // alert(due);
                $.ajax({
                    url: "{{ route('purchaseDuePay') }}",
                    method: "GET",
                    data: {
                        due: due,
                        purchase_due_id: purchase_due_id,
                        _token: _token,
                    },
                    success: function(response) {
                        if(response.error)
                        {
                            toastr.error("{{ Session::get('message') }}",(response.error));
                        }
                        else
                        {
                            $("#due").val(response.due);
                        $("#paid_price").val(response.paid);
                        $('.common-select2').select2();
                        }

                    }
                })


            });
            $("#invoice_print").focus();
            $(document).on("keyup", "#invoice_no_s", function(e) {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url: "{{ route('searchPurchase') }}",
                        method: "GET",
                        data: {
                            value: value,
                            _token: _token,
                        },
                        success: function(response) {
                            // console.log(response);
                            $(".invoice-items").empty().append(response.page);
                        }
                    })
            });

            $(document).on("click", "#edit_click", function(e) {
                $(".date-field").hide();
                $(".update-date-field").show();
            });



            $('#edit_button').click(function() {
                var invoice_no = $('#invoice_no').val();
                var update_date = $('#update_date').val();
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: "{{ route('updateinvoicedate') }}",

                    method: "GET",
                    data: {

                        invoice_no: invoice_no,
                        update_date: update_date,

                        _token: _token,
                    },

                    success: function(response) {
                        toastr.success("{{ Session::get('message') }}",(response.error));
                        $("#date").val(response.invoice.date);
                        $("#update_date").val(response.invoice.date);
                        $(".date-field").show();
                        $(".update-date-field").hide();

                    }

                })

            });
            var delay = (function() {
                var timer = 0;
                return function(callback, ms) {
                    clearTimeout(timer);
                    timer = setTimeout(callback, ms);
                };
            })();
            $('#refresh_invoice').click(function() {
                // alert(1);
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('refresh_purchase') }}",
                    method: "GET",
                    data: {
                        _token: _token,
                    },
                    success: function(response) {
                        $(".invoice-items").empty().append(response.page);
                    }
                })
            });

            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                }
            });


        });
    </script>
@endpush
