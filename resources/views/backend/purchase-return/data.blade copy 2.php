<div lass="show_html">
    <h5>Product Purchase Return </h5>
    <div class="card">
        <div class="card-body content-padding">
            <div class="row">
                <div class="col-sm-3 col-12">
                    <label for="mode">PO No</label>
                    <input type="text" required value="{{$purchase_info->purchase_no}}" readonly class="form-control" name="purchase_no" id="purchase_no">
                </div>
                <!-- <div class="col-sm-3 col-12">
                                                <label for="mode">PR No</label>
                                                <input type="text" required value="" readonly class="form-control" name="pr_id" id="pr_id">
                      </div> -->

                      <input type="hidden" required value="{{$newReturn->purchase_return_no}}" readonly class="form-control" name="purchase_return_no" id="purchase_return_no">

                <div class="col-sm-3 col-12">
                    <label for="project_id">Branch Name</label>
                    <input type="text" readonl name="project_id" value="{{$purchase_info->projectInfo->proj_name}}" class="form-control">
                </div>
                <div class="col-sm-3 col-12">
                    <label for="mode">Supplier Name</label>
                    <input type="text" readonly name="suplyer" value="{{$purchase_info->partInfo->pi_name}}" class="form-control">
                </div>
                <div class="col-sm-3 col-12">
                    <label for="contact_no">Contact No</label>
                    <input type="text" required class="form-control" name="contact_no" id="contact_no" value="{{$purchase_info->partInfo->con_no}}" readonly>
                    @error('contact_no')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-3 col-12">
                    <label for="address">Address</label>
                    <input type="text" name="address" class="form-control" id="address" readonly value="{{$purchase_info->partInfo->address}}">
                    @error('address')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-3 col-12">
                    <label for="trn">TRN</label>
                    <input type="text" name="trn" class="form-control" id="trn" readonly value="{{$purchase_info->partInfo->trn_no}}">
                </div>
                <div class="col-sm-3 col-12 ">
                    <label for="tax_invoice_no">Quotation / Reference No</label>
                    <input type="text" required class="form-control" name="tax_invoice_no" id="tax_invoice_no" value="{{$purchase_info->tax_invoice_no}}" readonly>
                    @error('tax_invoice_no')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-3 col-12">
                    <label for="pay_mode">Payment Mode</label>
                    <select name="pay_mode" id="pay_mode" class="form-control" required readonly>
                        <option value=""></option>
                        @foreach ($payMode as $payMode)
                        <option value="{{$payMode->title}}" {{$purchase_info->pay_mode == $payMode->title ? "selected":""}}>{{$payMode->title}}</option>
                        @endforeach
                    </select>
                    @error('pay_mode')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-3 col-12">
                    <label for="pay_term">Payment Terms</label>
                    <select name="pay_term" id="pay_term" class="form-control" required readonly>
                        <option value=""></option>
                        @foreach ($payTerms as $payTerm)
                        <option value="{{$payTerm->value}}" {{$purchase_info->pay_term == $payTerm->value ? "selected":""}}>{{$payTerm->title}}</option>
                        @endforeach
                    </select>
                    @error('pay_term')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-3 col-12">
                    <label for="pay_date">Payment Date</label>
                    <input type="date" name="pay_date" class="form-control" id="pay_date" readonly value="{{$purchase_info->pay_date}}">
                    @error('pay_date')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-3 col-12">
                    <label for="pay_date">Shippment</label>
                    <input type="text" class="form-control" readonly value="{{$purchase_info->shipping_id}}">
                </div>
                <div class="col-sm-3 col-12">
                    <label for="pay_date">Date</label>
                    <input type="text" class="form-control" readonly value="{{date('d-m-Y', strtotime($purchase_info->date))}}">
                </div>

            </div>
            <div class="card mb-1">
                <div class="card-body content-padding">
                    <div class="row">
                        <div class="col-sm-3 col-12">

                            <label for="mode">Style ID</label>
                            <input type="text" name="style_id" id="style_id" class="form-control " readonly>
                            <input type="hidden" name="item_id" id="item_id" class="form-control ">

                            <span class="text-danger" id="itemListErrorMsg"></span>
                        </div>
                        <div class="col-sm-6 col-12">

                            <label for="mode">Item Name</label>
                            <input name="name" id="item_name" class="form-control" readonly>

                            <span class="text-danger" id="itemListErrorMsg"></span>
                        </div>
                        <div class="col-sm-3 col-12">
                            <label for="quantity">QTY</label>
                            <input type="hidden" class="form-control" max="" name="vat_rate" id="vat_rate">
                            <input type="hidden" class="form-control" max="" name="received_qty" id="qty1">

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
                            <button disabled class="btn btn-success btn-sm p-1 m-0 addonly-btn" id="item-return-add"><i class="bx bx-plus"></i></button>
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
        @foreach($items as $item)
        <tr class="data-row">
            <td>{{$item->itemName->style_name}}</td>
            <td>{{$item->itemName->item_name}}</td>
            <td>{{$item->brandName->name}}</td>
            <td>{{$item->vatRate->name}}</td>
            <td>{{$item->purchase_rate}}</td>
            <td>{{$item->quantity}}</td>
            <td>{{number_format((float)$item->total_amount, 2, '.', '') }}</td>
            <td> <a type="button" class="btn btn-sm btn-warning image-edite" data-style_name="{{$item->itemName->style_name}}" data-item_name="{{$item->itemName->item_name}}" data-quantity="{{$item->quantity}}" data-vat_rate="{{$item->vat_rate}}" data-unit_price="{{$item->purchase_rate}}" data-vat_amount="{{number_format((float)( $item->vatRate->name),'2','.','')}}" data-cost_price="{{number_format((float)( $item->total_amount),'2','.','') }}" data-item_id="{{$item->item_id }}">Return</a></td>
        </tr>
        @endforeach

    </tbody>
    <script>
            $(document).on('click', '#item-return-add', function(e) {

            e.preventDefault();
            // alert(1);
            var style_id = $('#style_id').val();
            var quantity = $('#qty').val();
            var quantity1 = $('#qty1').val();
            var vat_rate = $('#vat_rate').val();
            var item_id = $('#item_id').val();

            var purchase_rate = $('#purchase_rate').val();
            var purchase_no = $('#purchase_no').val();
            var purchase_return_no = $('#purchase_return_no').val();

            // alert(purchase_no);
            $.ajax({
                url: "{{ route('preturn_item_temp') }}",
                method: "post",
                data: {
                    style_id: style_id,
                    quantity: quantity,
                    quantity1: quantity1,
                    item_id: item_id,
                    vat_rate: vat_rate,
                    purchase_rate: purchase_rate,
                    purchase_no: purchase_no,
                    purchase_return_no:purchase_return_no,

                },
                success: function(response) {
                    if (response.message) {


                        toastr.error(response.message, response.title);
                    } else {
                        // $("#item_name").val('');
                        $(".return-item").empty().append(response.page);
                        $('.only-save-btn').removeAttr("disabled");
                        $("#style_id").val('');

                        $("#item_id").val('');
                        $("#qty").val('');
                        $("#purchase_rate").val('');

                        $("#total_amount").val('');
                        $("#item_name").val('');


                    }
                }
            })
        });

        $(document).on('click', '.image-edite', function() {

            let style_id = $(this).data('style_name');
            let item_name = $(this).data('item_name');
            let vat_rate = $(this).data('vat_rate');
            let quantity = $(this).data('quantity');

            let unit_price = $(this).data('unit_price');
            let cost_price = $(this).data('cost_price');
            let item_id = $(this).data('item_id');


            $('#vat_rate').val(vat_rate);

            $('#style_id').val(style_id);
            $('#item_name').val(item_name);
            $('#item_id').val(item_id);
            $('#qty').val(quantity);
            $('#qty1').val(quantity);

            $('#purchase_rate').val(unit_price);
            $('#total_amount').val(cost_price);
            $('.addonly-btn').removeAttr("disabled")

            document.getElementById("qty").max = quantity;
        });
    </script>

</table>