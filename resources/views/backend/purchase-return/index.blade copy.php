@extends('layouts.backend.app')
@push('css')
@endpush
@section('title', 'item-purchase view')
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="row" id="table-bordered">

                <div class="col-12 col-sm-10 col-md-10 col-lg-12">
                    <h5>Product Purchase Return</h5>
                    <div class="col-4 mb-1">
                        <select class="form-control common-select2" placeholder="Serach By purchade No" name="purchase" id="purchase_serch">
                            <option value="">Serach By purchade No</option>
                            @foreach($product_purchases as $data)

                            <option value="{{$data->id}}">{{$data->purchase_no}}</option>

                            @endforeach
                        </select>
                    </div>

                    <form action="{{route('purchase-return.store')}}" class="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="show_html">

                            <div class="card">
                                <div class="card-body content-padding">
                                    <div class="row">
                                        <div class="col-sm-3 col-12">
                                            <label for="mode">PO No</label>
                                            <input type="text" required value="" readonly class="form-control" name="purchase_no" id="purchase_no">
                                        </div>
                                       
                                        <div class="col-sm-3 col-12">
                                            <label for="project_id">Branch Name</label>
                                            <input type="text" readonly value="" class="form-control">
                                        </div>
                                        <div class="col-sm-3 col-12">
                                            <label for="mode">Supplier Name</label>
                                            <input type="text" readonly value="" class="form-control">
                                        </div>
                                        <div class="col-sm-3 col-12">
                                            <label for="contact_no">Contact No</label>
                                            <input type="text" required class="form-control" name="contact_no" id="contact_no" value="" readonly>
                                            @error('contact_no')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-3 col-12">
                                            <label for="address">Address</label>
                                            <input type="text" name="address" class="form-control" id="address" readonly value="">
                                            @error('address')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-3 col-12">
                                            <label for="trn">TRN</label>
                                            <input type="text" name="trn" class="form-control" id="trn" readonly value="">
                                        </div>
                                        <div class="col-sm-3 col-12">
                                            <label for="tax_invoice_no">Quotation / Reference No</label>
                                            <input type="text" required class="form-control" name="tax_invoice_no" id="tax_invoice_no" value="" readonly>
                                            @error('tax_invoice_no')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-3 col-12">
                                            <label for="pay_mode">Payment Mode</label>
                                            <select name="pay_mode" id="pay_mode" class="form-control" required disabled>

                                            </select>
                                            @error('pay_mode')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-3 col-12">
                                            <label for="pay_term">Payment Terms</label>
                                            <select name="pay_term" id="pay_term" class="form-control" required disabled>

                                            </select>
                                            @error('pay_term')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-3 col-12">
                                            <label for="pay_date">Payment Date</label>
                                            <input type="date" name="pay_date" class="form-control" id="pay_date" readonly value="">
                                            @error('pay_date')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-3 col-12">
                                            <label for="pay_date">Shippment</label>
                                            <input type="text" class="form-control" readonly value="">
                                        </div>
                                        <div class="col-sm-3 col-12">
                                            <label for="pay_date">Date</label>
                                            <input type="text" class="form-control" readonly value="">
                                        </div>

                                    </div>
                                    <div class="card mb-1">
                                        <div class="card-body content-padding">
                                            <div class="row">
                                                <div class="col-sm-3 col-12">

                                                    <label for="mode">Style ID</label>
                                                    <input type="text" name="style_id" id="style_id" class="form-control " disabled>

                                                    <span class="text-danger" id="itemListErrorMsg"></span>
                                                </div>
                                                <div class="col-sm-6 col-12">

                                                    <label for="mode">Item Name</label>
                                                    <input name="name" id="item_name" class="form-control" disabled>

                                                    <span class="text-danger" id="itemListErrorMsg"></span>
                                                </div>
                                                <div class="col-sm-3 col-12">
                                                    <label for="quantity">QTY</label>
                                                    <input type="number" class="form-control" max="" name="quantity" id="qty">
                                                    <span class="text-danger" id="quantityErrorMsg"></span>
                                                </div>
                                                <div class="col-sm-3 col-12">
                                                    <label for="purchase_rate">Purchase Rate</label>
                                                    <input type="text" class="form-control" name="purchase_rate" id="purchase_rate" readonly step=".01" oninput="validate(this)">
                                                    <span class="text-danger" id="purchaseRateErrorMsg"></span>
                                                </div>


                                                <div class="col-sm-3 col-12">
                                                    <label for="total_amount">Total Amount</label>
                                                    <input type="number" class="form-control" name="total_amount" id="total_amount" readonly>
                                                </div>
                                                <div class="col-sm-3 d-flex pt-1">
                                                    <button class="btn btn-success btn-sm p-1 m-0 addonly-btn" disabled id="item-return-add"><i class="bx bx-plus"></i></button>
                                                    <button class="btn btn-warning btn-sm ml-1 p-1 m-0" id="refresh"><i class="bx bx-refresh"></i></button>
                                                </div>
                                                <table class="table table-sm table-bordered return-item">
                                                </table>
                                                <div class="col-md-4 ml-2">
                                                    <div class="form-group row" style=" margin-top: 29px;">
                                                        <button type="submit" disabled class="btn btn-sm final-save-btn only-save-btn  btn-primary " style=" margin-right: 10px;" id="final_save"> Save</button>
                                                        <a class="btn btn-sm btn-warning" onClick="refreshPage()">Refresh</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Style ID</th>
                                    <th scope="col">Item Name</th>
                                    <th scope="col">Color</th>
                                    <th scope="col">Vat</th>
                                    <th scope="col">Pur. Rate</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Action

                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tempLists" class="user-table-body">

                            </tbody>

                        </table>
                    </form>

                </div>

            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
    $("#purchase_serch").change(function(e) {
        e.preventDefault();
        var id = $('#purchase_serch option:selected').val();
        // alert(id);
        $.ajax({
            type: "post",
            url: "{{URL::to('purchadse_info_get')}}",
            data: {
                "id": id
            },
            success: function(response) {
                $(".show_html").empty().append(response.page);
            }
        });
    });
        $(document).on("click", ".delete_item_1", function(e) {
            e.preventDefault();
           // alert(1);
            let item_id1 = $(this).data('item_id1');
            var purchase_return_no = $('#purchase_return_no').val();

            var purchase_no1 = $(this).data('purchase_no1');
            // alert(purchase_no1 + item_id1);


            $.ajax({
                url: "{{ route('preturn_item_temp_delete') }}",
                method: "post",
                data: {

                    item_id1: item_id1,
                    purchase_no1: purchase_no1,
                    purchase_return_no:purchase_return_no,


                },
                success: function(response) {

                    // $("#item_name").val('');
                    $(".return-item").empty().append(response.page);

                }
            })

        });
</script>

@endpush