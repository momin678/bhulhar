<table class="table table-sm table-bordered invoice-items">
        <thead>
            <tr>
                <th>SL</th>
                <th>Style ID</th>
                <th>Item Name</th>
                @if(!$invoice->include_vat)
                <th>CTN</th>
                @endif
                <th>QTY</th>
                <th>Unit</th>
                <th>Unit Price</th>
                <th>Vat rate</th>

                <th>Vat Amount</th>
                <th>Discount</th>
                <th>Total Price </th>
                <th>Action </th>
            </tr>
        </thead>
        <tbody class="all-data-area">
            @foreach (App\InvoiceItem::where('invoice_id',$invoice->id)->get() as $item)
            <tr class="data-row">
                <td>{{ ++$i }}</td>
                <td>{{ $item->item->style_name }}</td>
                <td>{{$item->item->item_name }}</td>
                @if(!$invoice->include_vat)
                <td>{{ $item->ctn }}</td>
                @endif

                <td>{{ $item->quantity }}</td>
                <td>{{ $item->unit }}</td>
                <td>{{ $item->unit_price }}</td>
                <td>{{ $item->vat_rate }}</td>

                <td>{{number_format((float)( $item->vat_amount),'2','.','')}}</td>
                <td></td>
                <td>{{number_format((float)( $item->cost_price),'2','.','') }}</td>
                <td> <a class="btn btn-sm btn-warning image-edite" data-style_name="{{$item->item->style_name}}" data-item_name="{{$item->item->item_name}}" data-quantity="{{$item->quantity }}" data-squantity="{{$item->quantity }}" data-vat_rate="{{$item->vat_rate }}" data-unit="{{$item->unit}}" data-unit_price="{{$item->unit_price}}" data-vat_amount="{{number_format((float)( $item->vat_amount),'2','.','')}}" data-cost_price="{{number_format((float)( $item->cost_price),'2','.','') }}" data-barcode="{{$item->item->barcode }}" data-item_id="{{$item->item_id }}">Return</a></td>

            </tr>
            @endforeach

            <script>
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                $(document).on('click', '.image-edite', function() {

                    let style_name = $(this).data('style_name');
                    let item_name = $(this).data('item_name');
                    let quantity = $(this).data('quantity');
                    let squantity = $(this).data('squantity');
                    let vat_rate = $(this).data('vat_rate');

                    let unit = $(this).data('unit');
                    let unit_price = $(this).data('unit_price');
                    let vat_amount = $(this).data('vat_amount');
                    let cost_price = $(this).data('cost_price');
                    let item_id = $(this).data('item_id');
                    let barcode = $(this).data('barcode');


                    $('#style_id').val(style_name);
                    $('#item_name').val(item_name);
                    $('#item_id').val(item_id);
                    $('#sqty').val(squantity);
                    $('#vat').val(vat_amount);

                    $('#qty').val(quantity);
                    $('#unit').val(unit);
                    $('#unit_price').val(unit_price);
                    $('#vat_rate').val(vat_rate);
                    $('#total_price').val(cost_price);
                    $('#barcode').val(barcode);

                    document.getElementById("qty").max = quantity;
                    $('.addonly-btn').removeAttr("disabled")
                });

                $('#item-return-add').click(function(e) {
                    e.preventDefault();
                    // alert(1);
                    var sqty = $('#sqty').val();
                    var qty = $('#qty').val();
                    var item_id = $('#item_id').val();
                    var unit_price = $('#unit_price').val();
                    var vat_rate = $('#vat_rate').val();
                    var style_name = $('#style_id').val();
                    var item_name = $('#item_name').val();
                    var total_price = $('#purchase_rate').val();
                    var vat = $('#vat').val();
                    var invoice_no = $('#invoice_no').val();


                    // alert(purchase_no);
                    $.ajax({
                        url: "{{ route('sales_item_temp') }}",
                        method: "post",
                        data: {
                            sqty: sqty,
                            qty: qty,
                            item_id: item_id,
                            unit_price: unit_price,
                            vat_rate: vat_rate,
                            style_name: style_name,
                            item_name: item_name,
                            total_price: total_price,
                            vat: vat,
                            invoice_no: invoice_no,

                        },
                        success: function(response) {
                            if (response.message) {


                                toastr.success(response.message, response.title);
                            } else {
                                // $("#item_name").val('');
                                $(".return-item").empty().append(response.page);
                                $('.only-save-btn').removeAttr("disabled");
                                $("#total_price").val('');

                                $("#sqty").val('');
                                $("#qty").val('');
                                $("#vat").val('');
                                $("#qty").val('');

                                $("#style_id").val('');
                                $("#item_name").val('');


                            }
                        }
                    })
                });
            </script>
        </tbody>
    </table>