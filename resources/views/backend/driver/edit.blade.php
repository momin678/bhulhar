<form class="form form-vertical" action="{{route('driver.update', $driver->id)}}" method="POST" enctype="multipart/form-data">

    @csrf
    @method('PATCH')
    <input type="hidden" name="truck_id" id="truck_id">
    <section id="basic-vertical-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="cardStyleChange">
                    <div class="card-body">
                        <div class="form-body">
                            <h4>Driver Information- Update</h4>
                            <div class="row">
                                <div class="col-md-12 col-12 ">
                                    <label for="">Driver Name</label>
                                    <input type="text" name="name" class="inputFieldHeight form-control" placeholder="Driver Name" value="{{$driver->full_name}}" required>
                                </div>
                                <div class="col-12">
                                    <label for="">Salary Grate</label>
                                    <select name="grade" id="" class="inputFieldHeight form-control" required>
                                        <option value="">Select Grate</option>
                                        @foreach ($grads as $item)
                                            <option value="{{$item->id}}" {{$item->id==$driver->grade?'selected':''}}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 d-flex justify-content-end mt-2 mb-2" >
                                    <button type="submit" class="btn btn-primary formButton" title="Searching">
                                        <div class="d-flex">
                                            <div class="formSaveIcon">
                                                <img src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" width="20">
                                            </div>
                                            <div><span> Update</span></div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
