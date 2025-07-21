@foreach ($records as $key=>$t_record)
    <tr class="trFontSize t-row">
        {{-- <td >{{ $loop->index+1 }}</td> --}}
        <td>{{++$key}}</td>
        <td>
            {{date('d/m/Y',strtotime($t_record->date))}}
        </td>

        <td>
            <input type="text" class="r-is" readonly  value="{{$t_record->trucks}}">
            <input type="hidden" class="r-is selected_item_id"  name="item_ids[]" readonly value="{{$t_record->id}}">
        </td>
        <td>
            {{$t_record->material}}
        </td>
        <td>
            {{$t_record->crusher}}
        </td>
        <td>
            {{$t_record->destination}}
        </td>
        <td>
            {{$t_record->serial_no}}
        </td>
        <td>
            {{$t_record->tkt_number}}
        </td>
        <td>
            <input type="text" class="r-weight" name="weight[]" placeholder="Toll fees" value="{{$t_record->weight}}" >
        </td>
        {{--
        <td>
            <input type="text" name="" value="{{$t_record->total_weight}}" class="r-weight">
        </td> --}}
        <td>
            <input type="text" class="r-rate" name="rate[]" placeholder="Rate" required value="{{$t_record->rate}}">
        </td>

        <td>
            <input type="text" class="r-amount" name="amount[]" placeholder="Amount" readonly  value="{{$t_record->amount}}">
        </td>
        <td>
            <select name="vat_rate[]" class="inputFieldHeight form-control vat_rate common-select2">
                @foreach ($vats as $vat)
                    <option value="{{$vat->value}}" >{{ $vat->value}}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="text" class="r-discount" name="discount[]" placeholder="discount"  value="">
        </td>
        <td>
            <input type="text" class="r-vat_amount" name="vat_amount[]" placeholder="VAT Amount" readonly  value="">
        </td>

        <td>
            <input type="text" class="total-amount" placeholder="Total Amount" name="total_amount[]" readonly  value="{{$t_record->amount}}">
        </td>
        <td>
            <input type="text" class="toll-amount" name="toll_fee[]" value="{{$t_record->toll_fee}}" placeholder="Toll fees" {{$toll_setup->value=='Automatic'?'readonly':''}}>
        </td>
        <td class="d-none">
            <input type="text" class="total-toll-amount" name="total_toll_fee[]" value="{{$t_record->toll_fee}}" placeholder="Total Toll fees"  readonly>
        </td>
        <td class="text-center">
           <button class="btn btn-sm btn-danger row-delete"> <span>DEL</span></button>
        </td>
    </tr>
@endforeach

