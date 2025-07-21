@extends('layouts.backend.app')
@section('content')
<style>
    .table thead th {
    color: #ffffff !important;
    text-align: center;

  }
  .mini-width {
    max-width: 90px !important;
  }
  .mini-width-input {
    max-width: 80px !important;
  }
  .semi-mini-width{
    max-width: 120px !important;
  }
  .semi-mini-width-input{
    max-width: 100px !important;
  }
  .table-sm th, .table-sm td {
    padding: 0.01rem !important;
  }
  input, select {
    height: 25px !important;
  }
  .div_error{
    border: 1px solid red;
  }
  .div_right{
    border: 1px solid black;
  }
</style>
@php
    $toll_setup = App\Setup::where('name', 'Toll Setup')->first();
@endphp
@include('layouts.backend.partial.style')
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <form action="{{route('filal-excel-import')}}" method="POST">
                @csrf
            <div class="table-responsive">
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="">Date</label>
                        <input type="text" class="inputFieldHeight form-control excel_filter" name="date" placeholder="Select Date" id="date">
                    </div>
                    <div class="col-md-2">
                        <label for="">Truck Number</label>
                        <select name="truck_id" class="form-control inputFieldHeight common-select2 excel_filter" id="truck_id">
                            <option value="">Select Truck</option>
                            @foreach ($trucks as $item)
                                <option value="{{$item->vehicle_number}}">{{$item->vehicle_number}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="">Client</label>
                        <select name="client_id" class="form-control inputFieldHeight common-select2 excel_filter" id="client_id">
                            <option value="">Select Name</option>
                            @foreach ($partys as $item)
                                <option value="{{$item->short_code}}">{{$item->pi_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for=""></label>
                        <input type="text" class="form-control inputFieldHeight" placeholder="Search by TKT Number, Material, From, To" onkeyup="excel_filter()" id="input_value">
                    </div>
                </div>
                <table class="table mb-0 table-sm table-hover table-bordered">
                    <thead  class="" style="position:sticky; background: #1a233a;">
                        <tr style="height: 30px;">
                            <th>S.NO</th>
                            <th>Date <span class="text-danger">*</span></th>
                            <th>TKT NO <span class="text-danger">*</span></th>
                            <th>MTL <span class="text-danger">*</span></th>
                            <th>VEH NO. <span class="text-danger">*</span></th>
                            <th>FROM <span class="text-danger">*</span></th>
                            <th>TO <span class="text-danger">*</span></th>
                            <th>WT <span class="text-danger">*</span></th>
                            <th>RATE <span class="text-danger">*</span></th>
                            <th>AMOUNT <span class="text-danger">*</span></th>
                            <th>Toll Fee</th>
                            <th>CLIENT <span class="text-danger">*</span></th>
                            {{-- <th>TRANSPORTER<span class="text-danger">*</span></th> --}}
                            <th>DRIVER NAME</th>
                            <th>COMMISION</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-sm tbody_object" id="tbody_object_value">
                        @foreach ($records as $key => $t_record)
                        <tr class="trFontSize" id="{{'tr'.$t_record->id}}">
                            <input type="hidden" name="temp_truck_id[]" value="{{$t_record->id}}" class="temp_truck_id">
                            <td>
                                <input name="serial_no[]" type="text" value="{{ $max_sl+$key}}" style="max-width: 100px !important;" disabled></td>
                            <td class="semi-mini-width">
                                <input name="date[]" type="text" value="{{$t_record->date?date('d/m/Y', strtotime($t_record->date)):''}}" required class="tr_value_submit semi-mini-width-input {{$t_record->date?'':'error'}}" title="Date is required">
                            </td>
                            <td class="mini-width">
                                <input name="tkt_no[]" type="text" value="{{$t_record->tkt_no}}" style="border: 1px solid;" required class="tr_value_submit check_tkt_number mini-width-input {{$t_record->check_tkt_number($t_record->tkt_no)||!$t_record->tkt_no?'error':''}}"  title="{{$t_record->check_tkt_number($t_record->tkt_no)?"Already Taken":"TKT Number is required"}}">
                            </td>
                            <td class="material-add semi-mini-width">
                                <div class="d-flex">
                                    <input name="material[]" type="text" value="{{$t_record->material}}" required class="semi-mini-width-input tr_value_submit check_error  material_id {{$t_record->material?'':'error'}}" title="Material is required">
                                    @if (!$t_record->material)
                                        <i class="bx bx-plus text-center material_add" data-toggle="modal" data-target="#materialModal"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="truck-new-add semi-mini-width">
                                <div style="display: flex;" title="{{!$t_record->check_truck_number($t_record->truck_id)?'Truck Not Found':''}}">
                                    <select name="truck_id[]" id="" style="max-width: 90px !important;" required class="truck_id {{!$t_record->check_truck_number($t_record->truck_id)?'div_error':''}}">
                                        <option value="">Select Option</option>
                                        @foreach ($trucks as $item)
                                            <option value="{{$item->vehicle_number}}" {{$item->vehicle_number==$t_record->truck_id?'selected':''}}>{{$item->vehicle_number}}</option>
                                        @endforeach
                                    </select>
                                    @if (!$t_record->check_truck_number($t_record->truck_id))
                                    <i class="bx bx-plus text-center truck_add" data-toggle="modal" data-target="#truckModal"></i>
                                   @endif
                                </div>

                            </td>
                            <td style="width: 140px;">
                                <input name="crusher[]" type="text" value="{{$t_record->crusher}}" required style="width: 130px;" class="{{$t_record->crusher?'':'error'}} check_error tr_value_submit" title="Crusher is required">
                            </td>
                            <td>
                                <input name="destination[]" type="text" value="{{$t_record->destination}}" required class="{{$t_record->destination?'':'error'}} check_error tr_value_submit" title="Destination is required">
                            </td>
                            <td style="width: 70px" >
                                <input name="weight[]" type="text" value="{{$t_record->weight}}"  step="any" style="width: 80px"  required class="weight {{$t_record->weight?'':'error'}} check_error tr_value_submit" title="Weight is required">
                            </td>
                            @php
                                $rate = null;
                                $toll = 0;
                                $commision = 0;
                                $transproter = null;
                                $driver = null;
                                
                                // $toll = $t_record->check_toll_rate($t_record->crusher,$t_record->destination, $t_record->weight);
                                // $t_record->toll_fee = $toll;
                                // $t_record->save();
                                // if($t_record->check_truck_number($t_record->truck_id)){
                                //     $transproter = $t_record->check_truck_number($t_record->truck_id)->party->pi_name;
                                //     if($t_record->check_truck_number($t_record->truck_id)->driver){
                                //         $driver = $t_record->check_truck_number($t_record->truck_id)->driver->name;
                                //         $t_record->driver_name = $driver;
                                //         $t_record->save();
                                //     }
                                // }
                            @endphp
                            <td style="width: 100px">
                                <input name="rate[]" type="number" value="{{$t_record->rate}}"  step="any" style="width: 100px" class="tr_value_submit check_error rate {{$t_record->rate?'':'error'}}" title="Rate is required" required>
                            </td>
                            <td>
                                <input name="amount[]" type="number" value="{{$t_record->amount}}" step="any" style="max-width: 100px !important;" class="amount tr_value_submit" readonly>
                            </td>
                            <td>
                                <input name="toll_fee[]" type="number" value="{{$t_record->toll_fee}}" style="max-width: 100px !important; min-width: 95px !important;"  class="tr_value_submit check_error" {{$toll_setup->value=='Automatic'?'readonly':''}}>
                            </td>
                            <td class="custom-new-add">
                                <div style="display: flex;" title="{{!$t_record->check_customer_name($t_record->customer_id)?'Customer Not Match':''}}" class="new-customer-add">
                                    <select name="customer_id[]" id="" style="max-width: 150px !important;" required class="customer_id {{!$t_record->check_customer_name($t_record->customer_id)?'div_error':''}}" id="{{'sl'.$t_record->id}}">
                                        <option value="">Select Option</option>
                                        @foreach ($partys as $item)
                                            <option value="{{$item->pi_name}}" {{$t_record->customer_id && $item->pi_name==$t_record->customer_id?'selected':''}}>{{$item->pi_name}}</option>
                                        @endforeach
                                    </select>
                                    @if (!$t_record->check_customer_name($t_record->customer_id))
                                        <i class="bx bx-user-plus text-center customer_add" data-toggle="modal" data-target="#customerModal"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="d-none">
                                <input name="transproter[]" type="text" value="{{$transproter}}" readonly class="tr_value_submit">
                            </td>
                            <td>
                                <input name="driver_name[]" type="text" value="{{$t_record->driver_name}}" class="tr_value_submit driver_name">
                            </td>
                            <td><input name="commision[]" type="number" value="{{$t_record->commision}}" style="max-width: 90px !important;" class="tr_value_submit"></td>
                            <td>
                                <a href="#" class="btn excel-import-delete" title="Delete" onclick="return confirm('Are you sure to delete this?')" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;" id="{{$t_record->id}}">
                                    <img src="{{asset('assets/backend/app-assets/icon/delete-icon.png')}}" style=" height: 30px; width: 30px;">
                                </a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            {{-- onclick="return confirm('Are your sure to submit !')" --}}
            <div class="row">
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary btn_create formButton mr-1 mt-2" title="Save" id="excel_form_save" onclick="return confirm('Please Confirm ?')">
                        <div class="d-flex">
                            <div class="formSaveIcon">
                                <img src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" width="25">
                            </div>
                            <div><span>Save</span></div>
                        </div>
                    </button>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
<div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Client Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('add-new-customerPost') }}" method="POST" id="customerAddNew" >
                @csrf
                <div class="row match-height">
                    <div class="col-md-6">
                        <label>Party Code</label>
                        <input type="text" id="" class="form-control" name="" value="{{ $cc }}" placeholder="Party Code" disabled readonly>
                    </div>
                    <div class="col-md-6">
                        <label>Party Name</label>
                        <input type="text" id="pi_name" class="form-control" name="pi_name" value="{{ isset($costCenter) ? $costCenter->pi_name : '' }}" placeholder="Party Name" required>
                        <small class="error-pi_name text-danger"> </small>
                    </div>

                    <div class="col-md-6">
                        <label>Party Type</label>
                        <select name="pi_type" class="common-select2" style="width: 100% !important" id="pi_type" required>
                            <option value="">Select...</option>
                            @foreach ($costTypes as $item)
                                <option value="{{ $item->title }}" {{ isset($costCenter) ? ($costCenter->pi_type == $item->title ? 'selected' : '') : '' }}> {{ $item->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>TRN No</label>
                        <input type="text" id="trn_no2" class="form-control" name="trn_no" value="{{ isset($costCenter) ? $costCenter->trn_no : '' }}" placeholder="TRN Number" >
                    </div>
                    <div class="col-md-6">
                        <label>Address</label>
                        <input type="text" id="address2" class="form-control" name="address" value="{{ isset($costCenter) ? $costCenter->address : '' }}" placeholder="Address">
                    </div>
                    <div class="col-md-6">
                        <label>Contact Person</label>
                        <input type="text" id="con_person" class="form-control" name="con_person" value="{{ isset($costCenter) ? $costCenter->con_person : '' }}" placeholder="Contact Person">
                    </div>
                    <div class="col-md-6">
                        <label>Mobile Phone No</label>
                        <input type="number" id="con_no" class="form-control" name="con_no" value="{{ isset($costCenter) ? $costCenter->con_no : '' }}" placeholder="Mobile No">
                    </div>
                    <div class="col-md-6">
                        <label>Phone No</label>
                        <input type="number" id="phone_no" class="form-control" name="phone_no" value="{{ isset($costCenter) ? $costCenter->phone_no : '' }}" placeholder="Phone No">
                    </div>

                    <div class="col-md-6">
                        <label>Email</label>
                        <input type="text" id="email" class="form-control" name="email" value="{{ isset($costCenter) ? $costCenter->email : '' }}" placeholder="Email">
                    </div>
                    <div class="col-md-6">
                        <label>Short Code</label>
                        <input type="text" id="short_code" class="form-control" name="short_code" value="{{ isset($costCenter) ? $costCenter->short_code : '' }}" placeholder="short code" required>
                        <small class="error-short_code text-danger"> </small>
                    </div>
                    <div class="col-12 d-flex justify-content-end mt-1">
                        <button type="submit" class="btn btn-primary mr-1">Submit</button>
                        <button type="reset" class="btn btn-light-secondary">Reset</button>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
<div class="modal fade" id="truckModal" tabindex="-1" role="dialog" aria-labelledby="truckModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Truck Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('add-new-truckPost') }}" method="POST" id="truckAddNew" >
                @csrf
                <div class="row match-height">
                    <div class="col-md-6 col-12 ">
                        <label for="">Vehicle Number</label>
                        <input type="text" name="vehicle_number" id="vehicle_number" class="inputFieldHeight form-control" placeholder="Vehicle Number" required>
                    </div>
                    <div class="col-md-6 col-12 ">
                        <label for="">Brand</label>
                        <input type="text" name="brand" id="brand" class="inputFieldHeight form-control" placeholder="Brand">
                    </div>
                    <div class="col-md-6 col-12 ">
                        <label for="">Model </label>
                        <input type="text" name="model" id="model" class="inputFieldHeight form-control" placeholder="Model">
                    </div>
                    <div class="col-md-6 col-12 commonSelect2Style">
                        <label for="">Origin</label>
                        <select name="origin" id="origin" class="inputFieldHeight form-control common-select2" style="width: 100% !important">
                            <option value="">Select Country</option>
                            @foreach ($countries as $country)
                            <option value="{{$country->name}}">{{$country->name}}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-md-6 col-12 ">
                        <label for="">Engine Capacity</label>
                        <input type="text" name="engine_capacity" id="engine_capacity" class="inputFieldHeight form-control" placeholder="Engine Capacity">
                    </div>
                    <div class="col-md-6 col-12 ">
                        <label for="">Number of Tyres</label>
                        <input type="text" name="number_of_tyres" class="inputFieldHeight form-control" placeholder="Number of Tyres" id="number_of_tyres">
                    </div>
                    <div class="col-md-6 col-12 commonSelect2Style">
                        <label for="">Owner</label>
                        <select name="owner" id="owner" class="inputFieldHeight form-control common-select2" required style="width: 100% !important">
                            <option value="">Select Owner</option>
                            @foreach ($partys as $party)
                            <option value="{{$party->id}}">{{$party->pi_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 d-flex justify-content-end mt-1">
                        <button type="submit" class="btn btn-primary mr-1" id="truck_add" >Submit</button>
                        <button type="reset" class="btn btn-light-secondary">Reset</button>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
<div class="modal fade" id="materialModal" tabindex="-1" role="dialog" aria-labelledby="materialModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Material Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('add-new-materialPost') }}" method="POST" id="materialAddNew" >
                @csrf
                <div class="row match-height">
                    <div class="col-md-12 col-12 ">
                        <label for="">Material Name</label>
                        <input type="text" name="m_name" id="m_name" class="inputFieldHeight form-control" placeholder="Material Name" required>
                    </div>
                    <div class="col-12 d-flex justify-content-end mt-1">
                        <button type="submit" class="btn btn-primary mr-1">Submit</button>
                        <button type="reset" class="btn btn-light-secondary">Reset</button>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
@endsection
@push('js')
    <script>
        $(document).ready(function(){
           check_tkt_number_duplicated()
        });
        function check_tkt_number_duplicated(){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                method: "post",
                url: "{{route('check-tkt-number-duplicated')}}",
                data: {
                    _token: _token,
                },
                success: function (response) {
                    if(response>0){
                        document.getElementById("excel_form_save").disabled = true;
                    }else{
                        document.getElementById("excel_form_save").disabled = false;
                    }
                }
            });
        }
        var tr_value_select_obje = null;
        $(document).on('change', '.tr_value_submit', function(e){
            tr_value_submit_obje = $(this).closest('.trFontSize');
            var temp_truck_id = tr_value_submit_obje.find('.temp_truck_id');
            var id = temp_truck_id.val();
            var field_name = (this).name;
            var field_name = field_name.slice(0, -2);
            var field_value = $(this).val();
            var _token = $('input[name="_token"]').val();
            if(!field_value){
                toastr.warning("Empty value not updated","Warning");
            }else{
                $.ajax({
                    method: "post",
                    url: "{{route('update-temp-excel-upload')}}",
                    data: {
                        field_name:field_name,
                        field_value:field_value,
                        id:id,
                        _token: _token,
                    },
                    success: function (response) {
                        toastr.success("Field value updated", "Success",{ timeOut: 500 });
                    }
                });
            }
            var tbody_object = $(this).closest('.tbody_object');
            var div_error_obj = tbody_object.find('.div_error');
            var error_obj = tbody_object.find('.error');
        });
        $(document).on('click','.excel-import-delete', function(e){
            var id = $(this).attr('id');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                method: "post",
                url: "{{route('delete-excel-truck-entry')}}",
                data: {
                    id:id,
                    _token: _token,
                },
                success: function (response) {
                    if(response ==1){
                        $('#tr'+id).remove();
                        toastr.success("Row deleted", "Success",{ timeOut: 500 });
                        check_tkt_number_duplicated()
                    }
                }
            });
        })
        var customer_add = null;
        $(document).on('click', '.customer_add', function(e){
            customer_add = $(this).closest('.custom-new-add').find('.customer_id');
            tr_value_select_obje = $(this).closest('.trFontSize');
        })
        $("#customerAddNew").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var url = form.attr('action');
            var pi_name = $("#pi_name").val();
            var pi_type = $("#pi_type").val();
            var trn_no = $("#trn_no2").val();
            var address = $("#address2").val();
            var con_person = $("#con_person").val();
            var con_no = $("#con_no").val();
            var phone_no = $("#phone_no").val();
            var email = $("#email").val();
            var short_code = $("#short_code").val();
            var temp_truck_id = tr_value_select_obje.find('.temp_truck_id');
            // alert(mobile);
            $.ajax({
                url: url,
                method: "POST",
                data: {
                    pi_name: pi_name,
                    pi_type: pi_type,
                    trn_no: trn_no,
                    address: address,
                    con_person: con_person,
                    con_no: con_no,
                    phone_no: phone_no,
                    phone_no: phone_no,
                    email: email,
                    short_code: short_code,
                    id:temp_truck_id.val(),
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    optionText = response.newCustomer['pi_name'];
                    optionValue = response.newCustomer['id'];
                    $('.customer_id').append(`<option value="${optionValue}">${optionText}</option>`);
                    $(customer_add).val(optionValue);
                    $("#customerModal").modal('hide');
                    $("#pi_name").val('');
                    $("#short_code").val('');
                    toastr.success("Field value updated", "Success",{ timeOut: 500 })
                    tr_value_select_obje.find('.customer_id').removeClass("div_error");
                }
            })
        });
        var truck_add = null;
        $(document).on('click', '.truck_add', function(e){
            truck_add = $(this).closest('.truck-new-add').find('.truck_id');
            tr_value_select_obje = $(this).closest('.trFontSize');
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
            var temp_truck_id = tr_value_select_obje.find('.temp_truck_id');
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
                    id:temp_truck_id.val(),
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    optionText = response.truck['vehicle_number'];
                    optionValue = response.truck['id'];
                    $('.truck_id').append(`<option value="${optionValue}">${optionText}</option>`);
                    $(truck_add).val(optionValue);
                    $("#truckModal").modal('hide');
                    $("#vehicle_number").val('');
                    tr_value_select_obje.find('.truck_id').removeClass("div_error");
                    toastr.success("Field value updated", "Success",{ timeOut: 500 });
                }
            })
        });
        $(document).on('change', '#vehicle_number', function(e){
            var vehicle_number = $(this).val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('check-vehicle-number') }}",
                method: "POST",
                data: {
                    vehicle_number:vehicle_number,
                    _token: _token,
                },
                success: function(response) {
                    if(response){
                        document.getElementById("truck_add").disabled = true;
                        toastr.warning('This vehicle number already exist', 'Warning',{ timeOut: 500 });
                    }else{
                        document.getElementById("truck_add").disabled = false;
                    }
                }
            });
        })
        var material_add = null;
        $(document).on('click', '.material_add', function(e){
            material_add = $(this).closest('.material-add').find('.material_id');
            tr_value_select_obje = $(this).closest('.trFontSize');
        })
        $("#materialAddNew").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var url = form.attr('action');
            var m_name = $("#m_name").val();
            var temp_truck_id = tr_value_select_obje.find('.temp_truck_id');
            $.ajax({
                url: url,
                method: "POST",
                data: {
                    m_name: m_name,
                    id:temp_truck_id.val(),
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    optionText = response.material['name'];
                    $(material_add).val(optionText);
                    $("#materialModal").modal('hide');
                    $("#m_name").val('');
                    toastr.success("Field value updated", "Success",{ timeOut: 500 })
                }
            })
        });
        $(document).on('keyup', '.rate', function(e){
            var rate = $(this).val();
            var amount_obj= $(this).closest('.trFontSize').find('.amount');
            var weight_obj= $(this).closest('.trFontSize').find('.weight');
            var total_amount = rate*weight_obj.val();
            amount_obj.val(total_amount.toFixed(2));
        });
        $(document).on('keyup', '#pi_name', function(e){
            let pi_name = $('#pi_name').val();
            checkUnique(pi_name,'pi_name')
        });

        $(document).on('keyup', '#short_code', function(e){
            let short_code = $('#short_code').val();
            checkUnique(short_code,'short_code')
        });

        //  short_code and party name unique checking
        function checkUnique(value,name){
            $.ajax({
                type:'GET',
                url: "{{ route('chack.unique.party') }}",
                data:{
                    'name' :name,
                    'value' :value,
                },
                success:function(response){
                    $('.error-'+name).empty()
                    if(response.error){
                        $('.error-'+name).text(response.error);
                    }
                }
            })
        }
        $(document).on('change', '.check_tkt_number', function(e){
            var number = $(this).val();
            tr_value_submit_obje = $(this).closest('.trFontSize');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                method: "post",
                url: "{{route('check-tkt-number')}}",
                context:this,
                data: {
                    number:number,
                    _token: _token,
                },
                success: function (response) {
                    if(response){
                        tr_value_submit_obje.find('check_tkt_number').removeClass("error");
                    }else{
                        tr_value_submit_obje.find('check_tkt_number').addClass("error");
                    }
                    check_tkt_number_duplicated()
                }
            });
        })
        $(document).on("change", ".truck_id", function(){
            $(this).removeClass("div_error");
            tr_value_submit_obje = $(this).closest('.trFontSize');
            var temp_truck_id = tr_value_submit_obje.find('.temp_truck_id');
            var id = temp_truck_id.val();
            var field_name = (this).name;
            var field_name = field_name.slice(0, -2);
            var field_value = $(this).val();
            var _token = $('input[name="_token"]').val();
            if(!field_value){
                toastr.warning("Empty value not updated","Warning");
            }else{
                $.ajax({
                    method: "post",
                    url: "{{route('update-temp-excel-upload')}}",
                    data: {
                        field_name:field_name,
                        field_value:field_value,
                        id:id,
                        _token: _token,
                    },
                    success: function (response) {
                        toastr.success("Field value updated", "Success",{ timeOut: 500 });
                    }
                });
            }
        })
        $(document).on("change", ".customer_id", function(){
            $(this).removeClass("div_error");
            tr_value_submit_obje = $(this).closest('.trFontSize');
            var temp_truck_id = tr_value_submit_obje.find('.temp_truck_id');
            var id = temp_truck_id.val();
            var field_name = (this).name;
            var field_name = field_name.slice(0, -2);
            var field_value = $(this).val();
            var _token = $('input[name="_token"]').val();
            if(!field_value){
                toastr.warning("Empty value not updated","Warning");
            }else{
                $.ajax({
                    method: "post",
                    url: "{{route('update-temp-excel-upload')}}",
                    data: {
                        field_name:field_name,
                        field_value:field_value,
                        id:id,
                        _token: _token,
                    },
                    success: function (response) {
                        toastr.success("Field value updated", "Success",{ timeOut: 500 });
                    }
                });
            }
        })
        $(document).on("change", ".check_error", function(){
            if($(this).val()){
                $(this).removeClass("error");
            }else{
                $(this).addClass("error");
            }
        })
        $(document).on("change", ".driver_name", function(){
            if($(this).val()){
                $(this).removeClass("error");
            }else{
                $(this).addClass("error");
            }
        })
        $(document).on("change", ".excel_filter", function(){
            excel_filter();
        })
        function excel_filter(){
            var date = $("#date").val();
            var truck_id = $("#truck_id").val();
            var client_id = $("#client_id").val();
            var _token = $('input[name="_token"]').val();
            var input_value = $("#input_value").val();
            $.ajax({
                method: "post",
                url: "{{route('excel-filter')}}",
                context:this,
                data: {
                    date:date,
                    truck_id:truck_id,
                    client_id:client_id,
                    input_value:input_value,
                    _token: _token,
                },
                success: function (response) {
                    $("#tbody_object_value").html(response);
                }
            });
        }
    </script>
@endpush
