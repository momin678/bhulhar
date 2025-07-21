@php
    $i=0;
@endphp
@foreach ($category->products as $item)
    @if ($i==0)
        <tr>
            <td rowspan="{{ $category->products->count() }}">{{ $category->name }}</td>
            <td>
                <a href="{{route('product-purchase-sale-report',$item->id)}}" target="blank">
                    {{ isset($item->brand)? $item->brand->name:"" }}{{ isset($item->subBrand)? ', '.$item->subBrand->name:"" }}
                </a>
            </td>
            <td>{{ $item->barcode }} </td>
            <td>{{ isset($item->stock)? ($item->stock->gallon!=null? $item->stock->gallon:"00"):"00" }}</td>
            <td>{{ isset($item->stock)?($item->stock->liter!=null? $item->stock->liter:"00"):"00"  }}</td>
            <td>{{ isset($item->stock)? ($item->stock->pcs!=null? $item->stock->pcs:"00"):"00"  }}</td>
        </tr>
        @php
            $i=1;
        @endphp
    @else
        <tr>
            <td>
                <a href="{{route('product-purchase-sale-report',$item->id)}}" target="blank">
                    {{ isset($item->brand)? $item->brand->name:"" }}{{ isset($item->subBrand)? ', '.$item->subBrand->name:"" }}
                </a>
            </td>
            <td>{{ $item->barcode }} </td>
            <td>{{ isset($item->stock)? ($item->stock->gallon!=null? $item->stock->gallon:"00"):"00" }}</td>
            <td>{{ isset($item->stock)?($item->stock->liter!=null? $item->stock->liter:"00"):"00"  }}</td>
            <td>{{ isset($item->stock)? ($item->stock->pcs!=null? $item->stock->pcs:"00"):"00"  }}</td>
        </tr>
    @endif
@endforeach
