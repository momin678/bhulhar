
@foreach ($empList as $item)
    <tr style="font-size: 12px;">
        <td class="text-center">{{$item->name}}</td>
        <td class="text-center">{{$item->dpt->name}}</td>
        <td class="text-center">{{$item->designation}}</td>
        <td>
            
            <div class="btn-group float-right">
                <a type="butten" class="btn btn-secondary parentViewProfile" href="#"  id="{{$item->id}}">View</a>
            </div>
        </td>
    </tr>
@endforeach