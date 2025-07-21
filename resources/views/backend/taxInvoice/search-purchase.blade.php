@foreach ($tax_invoices as $tax_invoice)
    @php
        $sl = 1;
        $invoice_items = $tax_invoice->invoice_items;
        if($request_data['category_id']){
            $invoice_items = $invoice_items->where('cat_id', $request_data['category_id']);
        }
        if($request_data['brand_id']){
            $invoice_items = $invoice_items->where('brand_id', $request_data['brand_id']);
        }
        if($request_data['vehicle_name_id']){
            $invoice_items = $invoice_items->where('vehicle_name_id', $request_data['vehicle_name_id']);
        }
        if($request_data['vehicle_model_id']){
            $invoice_items = $invoice_items->where('sub_brand_id', $request_data['vehicle_model_id']);
        }
        if($request_data['item_code_id']){
            $invoice_items = $invoice_items->where('item_code_id', $request_data['item_code_id']);
        }
    @endphp
    @foreach ($invoice_items as $key => $item)
        <tr>
            @if ($sl == 1)
                <td rowspan="{{count($invoice_items)}}">{{$tax_invoice->invoice_no}}</td>
            @endif
            @if ($sl == 1)
                <td rowspan="{{count($invoice_items)}}">{{$tax_invoice->date}}</td>
            @endif
            @if ($sl == 1)
                <td rowspan="{{count($invoice_items)}}">{{$tax_invoice->partyInfo($tax_invoice->customer_name)->pi_name}}</td>
            @endif
            <td>{{$item->category->name}}</td>
            <td>{{$item->brand->name}}</td>
            <td>{{$item->vehicle_name->name}}</td>
            <td>{{$item->subBrand->name}}</td>
            <td>{{$item->item_code->name}}</td>
            <td>{{$item->quantity}}</td>
            <td>{{$item->unit_price}}</td>
            <td>{{$item->price}}</td>
            <td>{{$item->vat}}</td>
            <td>{{$item->total_price}}</td>
            @if ($sl == 1)
                @if ($tax_invoice->pay_mode == 'Cash')
                    <td rowspan="{{count($invoice_items)}}">{{$tax_invoice->total_amount}}</td>
                @else
                    <td rowspan="{{count($invoice_items)}}">0</td>
                @endif                                                    
            @endif
            @if ($sl == 1)
                @if ($tax_invoice->pay_mode == 'Credit')
                    <td rowspan="{{count($invoice_items)}}">{{$tax_invoice->total_amount}}</td>
                @else
                    <td rowspan="{{count($invoice_items)}}">0</td>
                @endif
            @endif
        </tr>
        @php
            $sl+=1;
        @endphp
    @endforeach
@endforeach