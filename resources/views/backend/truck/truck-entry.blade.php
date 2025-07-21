@extends('layouts.backend.app')
@section('content')
@include('layouts.backend.partial.style')
<style>
    .table td{
        border-bottom: none;
    }
    .commonSelect2Style span{
        width: 100% !important;
    }
    .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b{
        display: none;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b{
        display: none;
    }
</style>

<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @include('backend.truck.truck-header')
            <div class="tab-content bg-white">
                <div class="tab-pane active">
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="cardStyleChange p-1">
                                <section id="widgets-Statistics" class="mb-1">
                                    <div class="d-flex">
                                        <h4 class="flex-grow-1">Vehicle List</h4>
                                        <div>
                                            <button type="button" class="btn btn-primary btn_create formButton mr-1" title="Add" data-toggle="modal" data-target="#newTruckAddModal">
                                                <div class="d-flex">
                                                    <div class="formSaveIcon">
                                                        <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" width="25">
                                                    </div>
                                                    <div><span>Add New</span></div>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </section>
                                <div class="card-body pt-0">
                                    <div class="table-responsive" style="min-height: 300px">
                                        <div class="table-responsive table-div">
                                            <table class="table mb-0 table-sm table-hover table-data">
                                                <thead  class="thead-light">
                                                    <tr style="height: 50px;">
                                                        <th>Vehicle NO</th>
                                                        <th>Brand</th>
                                                        <th>Model</th>
                                                        <th>Origin</th>
                                                        <th>Engine Capacity</th>
                                                        <th>NO of Tyres </th>
                                                        <th>Owner</th>
                                                        <th>Driver Name</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-sm">
                                                    @foreach ($trucks as $truck)
                                                    <tr class="trFontSize">
                                                        <td>{{$truck->vehicle_number}}</td>
                                                        <td>{{$truck->brand}}</td>
                                                        <td>{{$truck->model}}</td>
                                                        <td>{{$truck->origin}}</td>
                                                        <td>{{$truck->engine_capacity}}</td>
                                                        <td>{{$truck->no_of_tyres}}</td>
                                                        <td>{{$truck->party?$truck->party->pi_name:''}}</td>
                                                        <td>{{$truck->driver?$truck->driver->full_name:''}}</td>
                                                        <td class="">
                                                            <a href="#" class="btn truckInfoEdit truck_edit_btn" title="Edit" truck-id="{{$truck->id}}" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;">
                                                                <img src="{{asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;">
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- modal --}}
    <div class="modal fade bd-example" id="newTruckAddModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <section class="print-hideen border-bottom">
                <div class="d-flex">
                    <h4 class="mr-auto m-1">Vehicle Information</h4>
                    <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close" onClick="window.location.reload();"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                </div>
            </section>
            <div class="content-body">
                <form class="form form-vertical" action="{{ route('vehicle.store')}}" method="POST" enctype="multipart/form-data" id="truckAddNew">
                    @csrf
                    <section id="basic-vertical-layouts">
                        <div class="row match-height">
                            <div class="col-md-12 col-12">
                                <div class="cardStyleChange">
                                    <div class="card-body">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-4 col-12 ">
                                                    <label for="">Vehicle Number</label>
                                                    <input type="text" name="vehicle_number" class="inputFieldHeight form-control vehicle_number_add" placeholder="Vehicle Number" required id="vehicle_number">
                                                    <span class="text-danger" id="error_show"></span>
                                                </div>
                                                <div class="col-md-4 col-12 ">
                                                    <label for="">Brand</label>
                                                    <input type="text" name="brand" class="inputFieldHeight form-control" placeholder="Brand" id="brand">
                                                </div>
                                                <div class="col-md-4 col-12 ">
                                                    <label for="">Model </label>
                                                    <input type="text" name="model" class="inputFieldHeight form-control" placeholder="Model" id="model">
                                                </div>
                                                <div class="col-md-4 col-12 commonSelect2Style">
                                                    <label for="">Origin</label>
                                                    <select name="origin" class="inputFieldHeight form-control common-select2" id="origin">
                                                        <option value="">Select Country</option>
                                                        @foreach ($countries as $country)
                                                        <option value="{{$country->name}}">{{$country->name}}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                                <div class="col-md-4 col-12 ">
                                                    <label for="">Engine Capacity</label>
                                                    <input type="text" name="engine_capacity" class="inputFieldHeight form-control" placeholder="Engine Capacity" id="engine_capacity">
                                                </div>
                                                <div class="col-md-4 col-12 ">
                                                    <label for="">Number of Tyres</label>
                                                    <input type="text" name="number_of_tyres" class="inputFieldHeight form-control" placeholder="Number of Tyres" id="number_of_tyres">
                                                </div>
                                                <div class="col-md-4 col-12 commonSelect2Style">
                                                    <label for="">Owner</label>
                                                    <select name="owner" id="owner" class="inputFieldHeight form-control common-select2"  required>
                                                        <option value="">Select Owner</option>
                                                        @foreach ($parties as $party)
                                                        <option value="{{$party->id}}">{{$party->pi_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 col-12 commonSelect2Style">
                                                    <label for="">Driver Name</label>
                                                    <select name="driver_id" id="driver_id_add" class="inputFieldHeight form-control common-select2">
                                                        <option value="">Select Driver</option>
                                                        @foreach ($drivers as $driver)
                                                        <option value="{{$driver->id}}">{{$driver->full_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                {{-- <div class="col-md-4"></div> --}}
                                                <div class="col-md-4 d-flex justify-content-end mt-2 mb-2" >
                                                    <button type="submit" class="btn btn-primary formButton" title="Save" id="truck_add">
                                                        <div class="d-flex">
                                                            <div class="formSaveIcon">
                                                                <img src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" width="20">
                                                            </div>
                                                            <div><span> Save</span></div>
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
            </div>
          </div>
        </div>
    </div>
    <div class="modal fade bd-example" id="truckInfoEditModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <section class="print-hideen border-bottom">
                <div class="d-flex flex-row-reverse">
                    <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                </div>
            </section>
            <div class="content-body">
                <form class="form form-vertical" action="{{route('update-vehicle')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="truck_id" id="truck_id">
                    <section id="basic-vertical-layouts">
                        <div class="row match-height">
                            <div class="col-md-12 col-12">
                                <div class="cardStyleChange">
                                    <div class="card-body">
                                        <div class="form-body">
                                            <h4>Vehicle Information- Update</h4>
                                            <div class="row">
                                                <div class="col-md-4 col-12 ">
                                                    <label for="">Vehicle Number</label>
                                                    <input type="text" name="vehicle_number" id="vehicle_number_edit" class="inputFieldHeight form-control" placeholder="Vehicle Number" required>
                                                </div>
                                                <div class="col-md-4 col-12 ">
                                                    <label for="">Brand</label>
                                                    <input type="text" name="brand" id="brand_edit" class="inputFieldHeight form-control" placeholder="Brand">
                                                </div>
                                                <div class="col-md-4 col-12 ">
                                                    <label for="">Model </label>
                                                    <input type="text" name="model" id="model_edit" class="inputFieldHeight form-control" placeholder="Model">
                                                </div>
                                                <div class="col-md-4 col-12 commonSelect2Style">
                                                    <label for="">Origin</label>
                                                    <select name="origin" id="origin_edit" class="inputFieldHeight form-control common-select2">
                                                        <option value="">Select Country</option>
                                                        @foreach ($countries as $country)
                                                        <option value="{{$country->name}}">{{$country->name}}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                                <div class="col-md-4 col-12 ">
                                                    <label for="">Engine Capacity</label>
                                                    <input type="text" name="engine_capacity" id="engine_capacity_edit" class="inputFieldHeight form-control" placeholder="Engine Capacity">
                                                </div>
                                                <div class="col-md-4 col-12 ">
                                                    <label for="">Number of Tyres</label>
                                                    <input type="text" name="number_of_tyres" id="number_of_tyres_edit" class="inputFieldHeight form-control" placeholder="Number of Tyres">
                                                </div>
                                                <div class="col-md-4 col-12 commonSelect2Style">
                                                    <label for="">Owner</label>
                                                    <select name="owner" id="owner_edit" class="inputFieldHeight form-control common-select2" required>
                                                        <option value="">Select Owner</option>
                                                        @foreach ($parties as $party)
                                                        <option value="{{$party->id}}">{{$party->pi_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 col-12 commonSelect2Style">
                                                    <label for="">Driver Name</label>
                                                    <select name="driver_id" id="driver_id" class="inputFieldHeight form-control common-select2">
                                                        <option value="">Select Driver</option>
                                                        @foreach ($drivers as $driver)
                                                        <option value="{{$driver->id}}">{{$driver->full_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 d-flex justify-content-end mt-2 mb-2" >
                                                    <button type="submit" class="btn btn-primary formButton" title="Searching">
                                                        <div class="d-flex">
                                                            <div class="formSaveIcon">
                                                                <img src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" width="20">
                                                            </div>
                                                            <div><span> Save</span></div>
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
            </div>
          </div>
        </div>
    </div>
@endsection
@push('js')
<script>
    // $(document).on('change', '#owner', function(e){
    //     var owner_id = $(this).val();
    //     if(owner_id==1){
    //         document.getElementById("driver_id_add").required = true;
    //     }else{
    //         document.getElementById("driver_id_add").required = false;
    //     }
    // })
    $(document).on("click", ".truckInfoEdit", function(e){
        e.preventDefault();
        var truck_id= $(this).attr('truck-id');
        // alert(truck_id);
        var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('get-a-vehicle') }}",
                method: "POST",
                data: {
                    truck_id:   truck_id,
                    _token: _token,
                },
                success: function(response) {
                    // console.log(response);
                    $('#truck_id').val(truck_id);
                    $('#vehicle_number_edit').val(response.vehicle_number);
                    $('#brand_edit').val(response.brand);
                    $('#model_edit').val(response.model);
                    $('#origin_edit').val(response.origin);
                    $('#engine_capacity_edit').val(response.engine_capacity);
                    $('#number_of_tyres_edit').val(response.no_of_tyres);
                    $('#owner_edit option[value="'+response.owner+'"]').attr("selected", "selected");
                    $('#driver_id option[value="'+response.driver_id+'"]').attr("selected", "selected");
                    $('.common-select2').select2();

                }
            });

        $("#truckInfoEditModal").modal('show');
    });
    $(document).on('change', '.vehicle_number_add', function(e){
        var vehicle_number = $(this).val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('check-vehicle-number') }}",
            method: "POST",
            data: {
                vehicle_number:   vehicle_number,
                _token: _token,
            },
            success: function(response) {
                if(response){
                    document.getElementById("truck_add").disabled = true;
                    toastr.warning('This vehicle number already exist', 'Warning');
                }else{
                    document.getElementById("truck_add").disabled = false;
                }
            }
        });
    })
    $("#truckAddNew").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var url = form.attr('action');
        var vehicle_number = $("#vehicle_number").val();
        var brand = $("#brand").val();
        var model = $("#model").val();
        var engine_capacity = $("#engine_capacity").val();
        var origin = $("#origin").val();
        var number_of_tyres = $("#number_of_tyres").val();
        var owner = $("#owner").val();
        var driver_id = $("#driver_id_add").val();
        $.ajax({
            url: url,
            method: "POST",
            context:this,
            data: {
                vehicle_number: vehicle_number,
                brand: brand,
                model: model,
                engine_capacity: engine_capacity,
                origin: origin,
                number_of_tyres: number_of_tyres,
                owner: owner,
                driver_id: driver_id,
                '_token': '{{ csrf_token() }}'
            },
            success: function(response) {
                $("#vehicle_number").val('');
                $('#newTruckAddModal').modal('hide');
                $('.table-div').load(location.href + ' .table-data');
                $('#truckAddNew')[0].reset();
                if(response === 'error'){
                    toastr.error("Vehicle number already exit!", "Error");
                } else {
                    toastr.success("Truck added successfully!", "Success");
                }
            }
        })
    });
</script>
@endpush
