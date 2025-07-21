@foreach ($receipt_list as $item)
<tr class="receipt_exp_view"  id="{{$item->id}}">
    <td>{{++$i}}</td>
    <td>{{date('d/m/Y',strtotime($item->date))}}</td>

    <td>{{$item->receipt_no}}</td>
    <td>{{$item->party->pi_name}}</td>
    <td>{{$item->narration}}</td>
    <td >{{$item->total_amount}}</td>
    <td>{{$item->pay_mode}}</td>
</tr>

@endforeach
