@foreach ($expenses as $item)
<tr class="lpo_bill_view"  id="{{$item->id}}" style="text-align:center;">
    <td>{{date('d/m/Y', strtotime($item->date))}}</td>
    <td>{{$item->lpo_bill_no}}</td>
    <td>{{$item->party->pi_name}}</td>
    <td>{{$item->total_amount}}</td>
</tr>

@endforeach
