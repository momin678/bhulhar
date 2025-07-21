<label for="">Brands</label>
<select name="brand" id="brand" class="form-control" required>
    <option value="">Select...</option>
    @foreach ($cat->brands as $item)
    <option value="{{ $item->id }}">{{ $item->name }}</option>
    @endforeach
</select>
