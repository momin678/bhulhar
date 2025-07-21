@foreach ($records as $key => $t_record)
<tr class="trFontSize" id="{{'tr'.$t_record->id}}">
    <input type="hidden" name="temp_truck_id[]" value="{{$t_record->id}}" class="temp_truck_id">
    <td>
        <input name="serial_no[]" type="text" value="{{ $max_sl+$key}}" style="max-width: 100px !important;" disabled></td>
    <td class="semi-mini-width">
        <input name="date[]" type="text" value="{{$t_record->date?date('d/m/Y', strtotime($t_record->date)):''}}" required class="semi-mini-width-input {{$t_record->date?'':'error'}}" title="Date is required">
    </td>
    <td class="mini-width">
        <input name="tkt_no[]" type="text" value="{{$t_record->tkt_no}}" style="border: 1px solid;" required class="check_tkt_number mini-width-input {{$t_record->check_tkt_number($t_record->tkt_no)||!$t_record->tkt_no?'error':''}}"  title="{{$t_record->check_tkt_number($t_record->tkt_no)?"Already Taken":"TKT Number is required"}}">
    </td>
    <td class="material-add semi-mini-width">
        <div class="d-flex">
            <input name="material[]" type="text" value="{{$t_record->material}}" required class="semi-mini-width-input check_error  material_id {{$t_record->material?'':'error'}}" title="Material is required">
            @if (!$t_record->material)
                <i class="bx bx-plus text-center material_add" data-toggle="modal" data-target="#materialModal"></i>
            @endif
        </div>
    </td>
    <td class="truck-new-add semi-mini-width">
        <div style="display: flex;" title="{{!$t_record->check_truck_number($t_record->truck_id)?'Truck Not Found':''}}">
            <select name="truck_id[]" id="" style="max-width: 90px !important;" required class="truck_id {{!$t_record->check_truck_number($t_record->truck_id)?'div_error':''}}">
                <option value="">Select Option</option>
                @foreach ($trucks as $item)
                    <option value="{{$item->vehicle_number}}" {{$item->vehicle_number==$t_record->truck_id?'selected':''}}>{{$item->vehicle_number}}</option>
                @endforeach
            </select>
            @if (!$t_record->check_truck_number($t_record->truck_id))
            <i class="bx bx-plus text-center truck_add" data-toggle="modal" data-target="#truckModal"></i>
           @endif
        </div>

    </td>
    <td style="width: 140px;">
        <input name="crusher[]" type="text" value="{{$t_record->crusher}}" required style="width: 130px;" class="{{$t_record->crusher?'':'error'}} check_error" title="Crusher is required">
    </td>
    <td>
        <input name="destination[]" type="text" value="{{$t_record->destination}}" required class="{{$t_record->destination?'':'error'}} check_error" title="Destination is required">
    </td>
    <td style="width: 70px" >
        <input name="weight[]" type="text" value="{{$t_record->weight}}"  step="any" style="width: 80px"  required class="weight {{$t_record->weight?'':'error'}} check_error" title="Weight is required">
    </td>
    @php
        $rate = 0;
        $toll = 0;
        $commision = 0;
        $transproter = null;
        $driver = null;
        if($t_record->check_rate($t_record->crusher,$t_record->destination)){
            $rate = $t_record->check_rate($t_record->crusher,$t_record->destination)->customer_rate;
            $commision = $t_record->check_rate($t_record->crusher,$t_record->destination)->commission_rate;
        }
        $toll = $t_record->check_toll_rate($t_record->crusher,$t_record->destination, $t_record->weight);
        if($t_record->check_truck_number($t_record->truck_id)){
            $transproter = $t_record->check_truck_number($t_record->truck_id)->party->pi_name;
            if($t_record->check_truck_number($t_record->truck_id)->driver){
                $driver = $t_record->check_truck_number($t_record->truck_id)->driver->name;
            }
        }
    @endphp
    <td style="width: 100px">
        <input name="rate[]" type="number" value="{{$rate}}"  step="any" style="width: 100px" class="check_error rate {{$t_record->rate?'':'error'}}" title="Rate is required">
    </td>
    <td>
        <input name="amount[]" type="number" value="{{$rate * $t_record->weight}}" step="any" style="max-width: 100px !important;" class="amount" readonly>
    </td>
    <td>
        <input name="toll_fee[]" type="number"  min="{{$toll}}" max="{{$toll}}" value="{{$t_record->toll_fee}}" style="max-width: 100px !important; min-width: 95px !important;" {{$toll==$t_record->toll_fee?'readonly':''}} class="check_error {{$toll==$t_record->toll_fee?'':'error'}}" title="{{$toll==$t_record->toll_fee?'':'Toll must be '. $toll}}" {{$toll?'required':''}}>
    </td>
    <td class="custom-new-add">
        <div style="{{!$t_record->check_customer_name($t_record->customer_id)?'border: 1px solid red;':''}}  display: flex;" title="{{!$t_record->check_customer_name($t_record->customer_id)?'Customer Not Match':''}}" class="new-customer-add">
            <select name="customer_id[]" id="" style="max-width: 150px !important;" required class="customer_id" id="{{'sl'.$t_record->id}}">
                <option value="">Select Option</option>
                @foreach ($partys as $item)
                    <option value="{{$item->id}}" {{$item->short_code==$t_record->customer_id?'selected':''}}>{{$item->pi_name}}</option>
                @endforeach
            </select>
            @if (!$t_record->check_customer_name($t_record->customer_id))
            <i class="bx bx-user-plus text-center customer_add" data-toggle="modal" data-target="#customerModal"></i>
           @endif
        </div>
    </td>
    <td>
        <input name="transproter[]" type="text" value="{{$transproter}}" readonly>
    </td>
    <td>
        <input name="driver_name[]" type="text" value="{{$driver}}" class="driver_name {{$transproter == 'KNOOZ TRANSPORT LLC' && $driver == null?'error':''}}" {{$transproter == 'KNOOZ TRANSPORT LLC'?'required':''}} title="{{$transproter == 'KNOOZ TRANSPORT LLC' && $driver == null?'Driver name need':''}}">
    </td>
    <td><input name="commision[]" type="number" value="{{$commision}}" style="max-width: 90px !important;"></td>
    <td>
        <a href="#" class="btn excel-import-delete" title="Delete" onclick="return confirm('Are you sure to delete this?')" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;" id="{{$t_record->id}}">
            <img src="{{asset('assets/backend/app-assets/icon/delete-icon.png')}}" style=" height: 30px; width: 30px;">
        </a>
    </td>
</tr>
@endforeach