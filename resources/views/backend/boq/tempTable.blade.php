<thead>
    <tr>
        <th>No</th>
    <th>Work Description</th>
    <th>Volume <small>(m <sup>2</sup>/m <sup>3</sup> )</small></th>
    <th>Rate</th>
    <th>Taxable Amount</th>
    <th>Vat</th>
    <th>Total Amount</th>
    <th>Action</th>
    </tr>

</thead>
<tbody class="">
@foreach ($tempBoq->items as $item)
<tr class="data-row">
    <td>{{ $i++ }}</td>
    <td>
        <p><strong>{{ $item->itemName->name }}</strong></p>
    </td>
    <td>{{ $item->quantity }}</td>
    <td>{{ $item->rate }}</td>
    <td>{{ $item->taxable_amount }}</td>
    <td>{{ $item->vat }}</td>
    <td>{{ $item->amount }}</td>
	<td class="text-right">
        <span class="btn btn-warning boq-item-delete" id="" data_target="{{ route('tempItemDelete',$item) }}"><i class="bx bx-trash"></i></span>
	</td>
</tr>
@endforeach
<tr>
    <td colspan="4"></td>
    <td colspan="2">Taxable Amount</td>
    <td>{{ number_format($tempBoq->items->sum('taxable_amount'),2) }}</td>
    {{-- <td><input type="checkbox" class="checkbox-record" name="include_vat" id="include_vat" value="1"> Include Vat</td> --}}
</tr>
<tr>
    <td colspan="4"></td>
    <td colspan="2">Vat</td>
    <td>{{ number_format($tempBoq->items->sum('vat'),2) }}</td>
</tr>
<tr>
    <td colspan="4"></td>
    <td colspan="2">Total Amount</td>
    <td>{{ number_format($tempBoq->items->sum('amount'),2) }}</td>
</tr>


</tbody>
