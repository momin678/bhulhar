<label for="">Description</label>
<select name="sub_brand" id="sub_brand" class="form-control" required>
    <option value="">Select...</option>
    @foreach ($brand->subBrands as $item)
    <option value="{{ $item->id }}">{{ $item->name }}</option>
    @endforeach
</select>
