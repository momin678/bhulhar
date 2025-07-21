@if (count($records)>0)
    @foreach ($records as $key => $t_record)
        <tr class="trFontSize">
            <td><input type="checkbox" class="checkbox-record item_show_ids" name="records[]" value="{{$t_record->id}}"></td>
            <td>{{ ++$key }}</td>
            <td>{{date('d/m/Y', strtotime($t_record->date))}}</td>
            <td>{{$t_record->truck->vehicle_number}}</td>
            <td>{{$t_record->material}}</td>
            <td>{{$t_record->crusher}}</td>
            <td>{{$t_record->destination}}</td>
            <td>{{$t_record->serial_no}}</td>
            <td>{{$t_record->weight}}</td>
            <td>{{$t_record->rate}}</td>
            <td>{{$t_record->supplier->pi_name}}</td>
        </tr>
    @endforeach
@else
        <td class="text-center">Service Not Available</td>
@endif
