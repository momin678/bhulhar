
    <div class="modal-header">
        <h5 class="p-0" style="font-family:Cambria;font-size: 2rem;"><b>Salary Type Edit</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="">
            <form action="{{route('salary-types.update', $salary_info->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">SALARY TYPE</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="salary_type" value="{{$salary_info->salary_type}}" placeholder="Type new Head">
                        {{-- <input type="file"accept=".xlsx" name="file" class="form-control"> --}}
                    </div>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-primary">Submit</button>

                    </div>
                </div>

            </form>
        </div>
    </div>