
@foreach ($empList as $item)
    <tr style="font-size: 12px;">
        <td>{{$item->name}}</td>
        <td>{{$item->dpt->name}}</td>
        <td>{{$item->designation}}</td>
        <td>
            
            <div class="btn-group float-right">
                <a type="butten" class="btn btn-secondary parentViewProfile" href="#"  id="{{$item->id}}">View</a>
            </div>
        </td>
    </tr>
@endforeach