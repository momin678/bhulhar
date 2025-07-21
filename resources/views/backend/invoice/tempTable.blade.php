<thead>
    <tr>
        <th>No</th>
    <th>Description</th>
    <th>Taxable Amount</th>
    <th>Vat</th>
    <th>Total Amount</th>
    <th>Action</th>
    </tr>

</thead>
<tbody class="">
@foreach ($tempInvoice->items as $item)
<tr class="data-row">
    <td>{{ $i++ }}</td>
    <td>
        <p><strong>{{ $item->description }}</strong></p>
    </td>
    <td>{{ $item->taxable_amount }}</td>
    <td>{{ $item->vat }}</td>
    <td>{{ $item->total_amount }}</td>
	<td class="text-right">
        <span class="btn btn-warning boq-item-delete" id="" data_target="{{ route('tempItemDelete',$item) }}"><i class="bx bx-trash"></i></span>
	</td>
</tr>
@endforeach
<tr>
    <td colspan="3"></td>
    <td colspan="2">Taxable Amount</td>
    <td>{{ number_format($tempInvoice->items->sum('taxable_amount'),2) }}</td>
    {{-- <td><input type="checkbox" class="checkbox-record" name="include_vat" id="include_vat" value="1"> Include Vat</td> --}}
</tr>
<tr>
    <td colspan="3"></td>
    <td colspan="2">Vat</td>
    <td>{{ number_format($tempInvoice->items->sum('vat'),2) }}</td>
</tr>
<tr>
    <td colspan="3"></td>
    <td colspan="2">Total Amount</td>
    <td>{{ number_format($tempInvoice->items->sum('total_amount'),2) }}</td>
</tr>


</tbody>
