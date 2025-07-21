@foreach ($records as $t_record)
    <tr class="trFontSize t-row">
        <td >{{ $loop->index+1 }}</td>
        <td>
            <input type="text" class="r-material" placeholder="material"readonly   value="{{date('d/m/Y',strtotime($t_record->date))}}">
        </td>

        <td>
            <input type="text" class="r-is" readonly  value="{{$t_record->trucks}}">
            <input type="hidden" class="r-is"  name="item_ids[]" readonly value="{{$t_record->id}}">
        </td>
        <td>
            <input type="text" class="r-material"  placeholder="material" readonly  value="{{$t_record->material}}">
        </td>
        <td>
            <input type="text" class="crusher"  placeholder="Toll fees" readonly value="{{$t_record->crusher}}" >
        </td>
        <td>
            <input type="text" class="r-destination"  placeholder="destination" readonly  value="{{$t_record->destination}}">
        </td>
        <td>
            <input type="text" class="serial_no"  placeholder="Toll fees" value="{{$t_record->serial_no}}" >
        </td>
        <td>
            <input type="text" class="r-trasporter" placeholder="trasporter" readonly  value="{{$t_record->trasporter}}">
        </td>
        <td>
            <input type="text" class="r-weight" name="weight[]" placeholder="Toll fees" value="{{$t_record->total_weight}}" >
        </td>
        {{--
        <td>
            <input type="text" name="" value="{{$t_record->total_weight}}" class="r-weight">
        </td> --}}
        <td>
            <input type="text" class="r-rate" name="rate[]" placeholder="Rate" required value="{{$t_record->rate}}">
        </td>

        <td>
            <input type="text" class="r-amount" name="amount[]" placeholder="Amount" readonly  value="{{$t_record->rate*$t_record->total_weight}}">
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
            <input type="text" class="total-amount" placeholder="Total Amount" name="total_amount[]" readonly  value="{{$t_record->rate*$t_record->total_weight}}">
        </td>
        <td>
            <input type="text" class="toll-amount" name="toll_fee[]" value="{{$t_record->toll_fee}}" placeholder="Toll fees" >
        </td>
        <td>
            <input type="text" class="total-toll-amount" name="total_toll_fee[]" value="{{$t_record->toll_fee*$t_record->rate}}" placeholder="Total Toll fees"  readonly>
        </td>
    </tr>
@endforeach

