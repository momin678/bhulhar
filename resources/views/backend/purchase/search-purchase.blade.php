@foreach ($purchases as $purchase)
    @php
        $sl = 1;
        $purchase_items = $purchase->purchaseItems;
        if($request_data['category_id']){
            $purchase_items = $purchase_items->where('cat_id', $request_data['category_id']);
        }
        if($request_data['brand_id']){
            $purchase_items = $purchase_items->where('brand_id', $request_data['brand_id']);
        }
        if($request_data['vehicle_name_id']){
            $purchase_items = $purchase_items->where('vehicle_name_id', $request_data['vehicle_name_id']);
        }
        if($request_data['vehicle_model_id']){
            $purchase_items = $purchase_items->where('sub_brand_id', $request_data['vehicle_model_id']);
        }
        if($request_data['item_code_id']){
            $purchase_items = $purchase_items->where('item_code_id', $request_data['item_code_id']);
        }
    @endphp
    @foreach ($purchase_items as $key => $item)
        <tr>
            @if ($sl == 1)
                <td rowspan="{{count($purchase_items)}}">{{$purchase->supplier_invoice}}</td>
            @endif
            @if ($sl == 1)
                <td rowspan="{{count($purchase->purchaseItems)}}"><strong>{{convert_date_format($purchase->date)}}</strong></td>
            @endif
            @if ($sl == 1)
                <td rowspan="{{count($purchase_items)}}">{{$purchase->partyInfo($purchase->customer_name)->pi_name}}</td>
            @endif
            <td> {{$item->category->name}} </td>
            <td> {{$item->brand->name}} </td>
            <td> {{$item->vehicle_name->name}} </td>
            <td> {{$item->subBrand->name}} </td>
            <td> {{$item->item_code->name}} </td>
            <td style="font-size: 14px !important;"><strong>{{$item->quantity}}</strong></td>
            <td>{{$item->unit_price}}</td>
            <td>{{$item->price}}</td>
            <td>{{$item->vat}}</td>
            <td>{{$item->total_price}}</td>
            @if ($sl == 1)
                <td rowspan="{{count($purchase->purchaseItems)}}">{{$purchase->paid_price}}</td>
                <td rowspan="{{count($purchase->purchaseItems)}}">{{$purchase->due_price}}</td>
            @endif
        </tr>
        @php
            $sl+=1;
        @endphp
    @endforeach
@endforeach