@foreach ($categories as $category)
    @php
        $sl = 0;
        $products = $category->products;
        if($request['brand_id']){
            $products = $products->where('brand_id', $request['brand_id']);
        }
        if($request['vehicle_name_id']){
            $products = $products->where('vehicle_name_id', $request['vehicle_name_id']);
        }
        if($request['vehicle_model_id']){
            $products = $products->where('sub_brand_id', $request['vehicle_model_id']);
        }
        if($request['item_code_id']){
            $products = $products->where('item_code_id', $request['item_code_id']);
        }
    @endphp
    @foreach ($products as $key => $product)
        <tr>
            @if ($sl == 0)
                <td rowspan="{{count($products)}}">{{$category->name}}</td>
            @endif
            <td>{{$product->brand->name}}</td>
            <td>{{$product->vahicle_name->name}}</td>
            <td>{{$product->subBrand->name}}</td>
            <td>{{$product->item_code->name}}</td>
            <td>{{$product->stock?$product->stock->total_purchase_qty:0}}</td>
            <td>{{$product->stock?$product->stock->total_sale_qty:0}}</td>
            <td>{{$product->stock?$product->stock->pcs:0}}</td>
        </tr>
        @php
            $sl = $sl+1;
        @endphp
    @endforeach
@endforeach