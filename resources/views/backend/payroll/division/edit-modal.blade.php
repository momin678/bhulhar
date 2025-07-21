
    <div class="modal-header">
        <h5 class="p-0" style="font-family:Cambria;font-size: 2rem;"><b>Department Edit</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="">
            <form action="{{route('division.update', $info->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row mb-5">
                    <label class="col-sm-4 col-form-label">Department Name</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="name" value="{{$info->name}}" placeholder="Type new Head">
                        {{-- <input type="file"accept=".xlsx" name="file" class="form-control"> --}}
                    </div>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-primary">Submit</button>

                    </div>
                </div>

            </form>
        </div>
    </div>
