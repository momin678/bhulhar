<div class="modal-header">
    <h5 class="modal-title"> Create Equipment Usage Item </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="">
        <form action="{{ route('usage.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="item"> Items </label>
                <select name="item_id" id="" class="form-control items @error('item_id') is-invalid @enderror" required>
                    <option value="" selected disabled> Select items</option>
                    @foreach ($items as $item)
                        <option value="{{ $item->id }}" {{ old('item') == $item->id ? "selected" : ' '  }}> {{ $item->name }}</option>
                    @endforeach
                </select>
                @error('item_id')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="used_by"> Used by</label>
                <select name="used_by" class="form-control @error('used_by') is-invalid @enderror" required>
                    <option value="" selected disabled> Select </option>
                    <option value="Principal" {{ old('used_by') == "Principal" ? "selected" : ' '}}> Principal </option>
                    <option value="Teacher" {{ old('used_by') == "Teacher" ? "selected" : ' '}}> Teacher </option>
                    <option value="Administrators" {{ old('used_by') == "Administrators" ? "selected" : ' '}}> Administrators</option>
                    <option value="Support Staff" {{ old('used_by') == "Support Staff" ? "selected" : ' '}}> Support Staff </option>
                    <option value="Librarians" {{ old('used_by') == "Librarians" ? "selected" : ' '}}> Librarians </option>
                    <option value="Other" {{ old('used_by') == "Other" ? "selected" : ' '}}> Other </option>
                </select>
                @error('used_by')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="used_by"> Name </label>
                <input type="text" name="name" value="{{ old('name')}}" class="form-control @error('name') is-invalid @enderror" required>
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="purpose"> Purpose </label>
                <textarea name="purpose" cols="10" rows="3" class="form-control @error('purpose') is-invalid @enderror" required>{{old('purpose')}}</textarea>
                @error('purpose')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <button class="btn btn-primary" type="submit"> Submit </button>

        </form>
    </div>
</div>

