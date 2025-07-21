<thead>
    <tr>
        <th>Product Name</th>
        <th>Category</th>
        <th>Brand</th>
        <th>Unit Price</th>
        <th>Quantity</th>
        <th>Unit</th>
        <th>Total Price</th>
        <th>Action</th>
    </tr>
</thead>
<tbody class="">
@foreach (App\PurchaseTempItem::where('purchase_no',$temp->purchase_no)->get() as $item)
<tr class="data-row">

    <td>{{ $item->product->name }}</td>
    <td>{{ $item->category->name }}</td>
	<td>{{ isset( $item->brand)?$item->brand->name:"" }}</td>
    <td>{{ $item->unit_price }}</td>
    <td>{{ number_format($item->amount,0) }}</td>
    <td>{{ $item->unitP->name}}</td>
    <td>{{ $item->price}}</td>

	<td class="text-right">
        <span class="btn btn-warning invoice-item-delete" id="" data_target="{{ route('itemPurchDelete',$item) }}"><i class="bx bx-trash"></i></span>
	</td>
</tr>
<?php $i++; ?>
@endforeach
</tbody>


