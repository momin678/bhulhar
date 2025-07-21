@foreach ($suppliers as $party)
<tr class="receivable-view" id="{{ $party->id }}"
    style="text-align:center;">
    <td>{{ $party->pi_code}}</td>
    <td>{{$party->pi_name}}</td>
    <td>{{$party->due_amount}}</td>


</tr>
@endforeach
