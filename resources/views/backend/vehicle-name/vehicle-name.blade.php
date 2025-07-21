{{-- <label for="">Description</label> --}}
<select name="multi_vehicle_name[]" id="multi_vehicle_name" class="form-control multi_vehicle_name" required>
    <option value="">Select...</option>
    @foreach ($vehicle_names as $item)
    <option value="{{ $item->id }}">{{ $item->name }}</option>
    @endforeach
</select>
