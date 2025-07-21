
   <div class="col-md-12">
    @php
    $total_amount=0;
@endphp
<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Invoice No</th>
                <th>Code</th>
                <th>Category/Service</th>
                <th>Brand</th>
                <th>Sub-Category</th>
                <th>Amount</th>
                <th>Unit</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody class="all-data-area">
            @foreach ($invoices as $invoice)
            @foreach ($invoice->total_items as $item)
            <tr class="data-row">
                @if($item->cat_id!=null)
                <th><a href="{{ route('invoiceView', $invoice) }}">{{ $invoice->invoice_no }}</a></th>
                <th>{{ $item->product->barcode }}</th>
                <th>{{ $item->category->name }}</th>
                <th>{{ isset( $item->brand)?$item->brand->name:"" }}</th>
                <th>{{ isset($item->subBrand)?$item->subBrand->name:"" }}</th>
                <th>{{ $item->amount }}</th>
                <th>{{ $item->unitP->name }}</th>
                <th>{{$item->total_price}}</th>
                @else
                <th><a href="{{ route('invoiceView', $invoice) }}">{{ $invoice->invoice_no }}</a></th>

                <th colspan="2">{{ $item->service->name }}</th>
                <th>N/A</th>
                <th>N/A</th>
                <th>N/A</th>
                <th>N/A</th>
                <th>{{$item->total_price}}</th>
                @endif
            </tr>
            <?php
            $i++;

            ?>

            @endforeach
            @php
                 $total_amount=$total_amount+$invoice->TotalAmount();
            @endphp
        @endforeach

        </tbody>



    </table>
</div>

<div class="row d-flex justify-content-end pt-1">
<div class="col-md-5">


</div>

<div class="col-md-3">


</div>

<div class="col-md-4">
    <div class="form-group row">
        <label for="" class="col-7 d-flex align-items-center">Total Amount (AED):</label>
        <input type="number" name="total_gross" placeholder="Final Discount"
        min="0" step="any" class="form-control col-5" value="{{number_format((float)( $total_amount), 2,'.','') }}"
        id="total_gross" disabled>
    </div>

</div>
</div>
   </div>


