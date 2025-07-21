@foreach ($items as $item)
    <tr>
        <td>{{$item['date']}}</td>
        <td>{{$item['vehicle_no']}}</td>
        <td>{{$item['material']}}</td>
        <td>{{$item['crusher']}}</td>
        <td>{{$item['dstn']}}</td>
        <td>{{$item['wight']}}</td>
        <td>{{$item['truck_owner_name']}}</td>
        <td>{{$item['rate']}}</td>
        <td>{{$item['toll_fee']}}</td>
        <td>{{$item['trasporter']}}</td>
    </tr>
@endforeach