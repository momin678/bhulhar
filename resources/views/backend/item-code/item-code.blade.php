{{-- <label for="">Brands</label> --}}
<select name="multi_item_code[]" class="inputFieldHeight2 form-control multi_item_code" style="width: 100%; HEIGHT: 36PX;" required>
    <option value="">Select...</option>
    @foreach ($item_codes as $item)
    <option value="{{ $item->id }}">{{ $item->name }}</option>
    @endforeach
</select>
