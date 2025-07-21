@foreach ($receipt_list as $key => $item)
<tr class="receipt_exp_view"  id="{{$item->id}}">
    <td>{{$key+1}}</td>
    <td>{{convert_date_format($item->date)}}</td>
    <td>{{$item->receipt_no}}</td>
    <td>{{$item->party->pi_name}}</td>
    <td>{{$item->narration}}</td>
    <td >{{$item->total_amount}}</td>
    <td>{{$item->pay_mode}}</td>
</tr>

@endforeach
