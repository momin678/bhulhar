<div class="modal-header">
    <h5 class="modal-title"> Create Equipment Usage Item </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="">
        <form action="{{ route('usage.update',$equipment->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="item"> Items </label>
                <select name="item_id" id="" class="form-control items @error('item_id') is-invalid @enderror" required>
                    <option value="" selected disabled> Select items</option>
                    @foreach ($items as $item)
                        <option value="{{ $item->id }}" {{ $equipment->id == $item->id ? "selected" : ' '  }}> {{ $item->name }}</option>
                    @endforeach
                </select>
                @error('item_id')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="used_by"> Used by</label>
                <select name="used_by" class="form-control  @error('used_by') is-invalid @enderror" required>
                    <option value="" selected disabled> Select </option>
                    <option value="Principal" {{ $equipment->used_by == "Principal" ? "selected" : ' '}}> Principal </option>
                    <option value="Teacher" {{ $equipment->used_by == "Teacher" ? "selected" : ' '}}> Teacher </option>
                    <option value="Administrators" {{ $equipment->used_by == "Administrators" ? "selected" : ' '}}> Administrators</option>
                    <option value="Support Staff" {{ $equipment->used_by == "Support Staff" ? "selected" : ' '}}> Support Staff </option>
                    <option value="Librarians" {{ $equipment->used_by == "Librarians" ? "selected" : ' '}}> Librarians </option>
                    <option value="Other" {{ $equipment->used_by == "Other" ? "selected" : ' '}}> Other </option>
                </select>
                @error('used_by')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="used_by"> Name </label>
                <input type="text" name="name" value="{{ $equipment->name }}" class="form-control @error('name') is-invalid @enderror" required>
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="purpose"> Purpose </label>
                <textarea name="purpose" cols="10" rows="3" class="form-control @error('purpose') is-invalid @enderror" required>{{$equipment->purpose}}</textarea>
                @error('purpose')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <button class="btn btn-primary" type="submit"> Update And Confirm </button>
                <button class="btn btn-primary" type="submit"> Confirm </button>
            </div>


        </form>
    </div>
</div>

