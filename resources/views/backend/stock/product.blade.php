
<tr>
    <td>{{ $products->category->name }}</td>
    <td>
        <a href="{{route('product-purchase-sale-report',$products->id)}}" target="blank">
            {{ isset($products->brand)? $products->brand->name:"" }}{{ isset($products->subBrand)? ', '.$products->subBrand->name:"" }}
        </a>
    </td>
    <td>{{ $products->barcode }}</td>
    <td>{{ isset($products->stock)? ($products->stock->gallon!=null? $products->stock->gallon:"00"):"00" }}</td>
    <td>{{ isset($products->stock)?($products->stock->liter!=null? $products->stock->liter:"00"):"00"  }}</td>
    <td>{{ isset($products->stock)? ($products->stock->pcs!=null? $products->stock->pcs:"00"):"00"  }}</td>
</tr>

