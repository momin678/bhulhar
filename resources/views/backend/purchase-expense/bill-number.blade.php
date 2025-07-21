<option value="">Select Bill</option>
@foreach ($bill_numbers as $item)
    <option value="{{$item->id}}">{{$item->bill_no}}</option>
@endforeach