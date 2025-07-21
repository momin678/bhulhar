@foreach ($others as $employee)                        
    <tr class="trFontSize border-bottom">
        {{-- <td>
            <input class="checkbox"  type="checkbox" value="{{$employee->id}}" name="employee_id[id][{{$index}}]"> 
        </td> --}}
        <td>{{$employee->name}} </td>
        <td>{{$employee->designation}} </td>
        <td>
            @if($employee->in())
                <a class="btn btn-warning" href="{{ url('time-entry/ ' . $employee->id . '/out')}}" role="button">OUT</a>
            @else
                <a class="btn btn-primary" href="{{ url('time-entry/ ' . $employee->id . '/in')}}" role="button">IN</a>
            @endif
        </td>
    </tr>
@endforeach   