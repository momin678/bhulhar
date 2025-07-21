
@foreach ($empList as $item)
    <tr style="font-size: 12px;">
        <td>{{$item->name}}</td>
        <td>+{{$item->code->phonecode.$item->contact_number}}</td>
        <td>{{$item->dpt->name}}</td>
        <td>{{$item->designation}}</td>
        <td>{{$item->items->salary_type}}</td>
        <td>
            <div class="btn-group float-right">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-top: 2px; padding-bottom: 0px; font-size: 12px; padding-left: 10px;">
                        Actions
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item parentProfileEdit" href="{{route('employees.edit', $item->id)}}" id="{{$item->id}}">Edit</a>
                        <a class="dropdown-item parentViewProfile" href="#"  id="{{$item->id}}">View</a>
                        {{-- <a class="dropdown-item parentProfilePrint" href="#" id="{{$item->id}}">Print</a> --}}
                    </div>
                </div>
            </div>
        </td>
    </tr>
@endforeach