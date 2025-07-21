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
        /* display: none; */
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b{
        /* display: none; */
    }
</style>
    <!-- BEGIN: Content-->
    <div class="app-content content print-hideen">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                @include('backend.truck.truck-header')
                <div class="tab-content bg-white">
                    <div class="tab-pane active">
                        <div class="row" id="table-bordered">
                            <div class="col-12">
                                <div class="card cardStyleChange">
                                    <div class="row" id="table-bordered">
                                        <div class="col-12">
                                            <div class="cardStyleChange p-2">
                                                <div class="d-flex">
                                                    <h4 class="flex-grow-1">Weigh Bridge List</h4>
                                                </div>
                                                <section id="widgets-Statistics" class="mt-2 mb-1 pl-1">
                                                    <form action="">
                                                        <div class="row">
                                                            <div class="col-md-5 changeColStyle">
                                                                <label for="">Customer Name</label>
                                                                <select name="customer_id" class="inputFieldHeight form-control common-select2">
                                                                    <option value="">Select Name</option>
                                                                    @foreach ($customers as $customer)
                                                                    <option value="{{$customer->id}}" >{{ $customer->pi_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="row col-md-7">
                                                                <div class="col-md-3 changeColStyle">
                                                                    <label for="">Single Date</label>
                                                                    <input type="text" class="form-control inputFieldHeight" name="date" placeholder="Search by Date" id="date">
                                                                </div>
                                                                <div class="col-md-3 changeColStyle">
                                                                    <label for="">From Date</label>
                                                                    <input type="text" class="form-control inputFieldHeight" name="from" placeholder="From"  id="from">
                                                                </div>
                                                                <div class="col-md-3 changeColStyle">
                                                                    <label for="">To Date</label>
                                                                    <input type="text" class="form-control inputFieldHeight" name="to" placeholder="To" id="to">
                                                                </div>
                                                                <div class="col-md-3 changeColStyle text-right pr-1 mt-2">
                                                                    <button type="submit" class="btn btn-primary formButton mSearchingBotton" title="Searching">
                                                                        <div class="d-flex">
                                                                            <div class="formSaveIcon" style="margin-left: -10px;">
                                                                                <img  src="{{asset('assets/backend/app-assets/icon/searching-icon.png')}}" alt="" srcset=""  width="25">
                                                                            </div>
                                                                            <div><span> Search</span></div>
                                                                        </div>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </section>
                                                <div class="table-responsive" style="min-height: 300px">
                                                    <table class="table mb-0 table-sm table-hover">
                                                        <thead  class="thead-light">
                                                            <tr style="height: 50px;">
                                                                <th>Date</th>
                                                                <th>Truck</th>
                                                                <th>Material</th>
                                                                <th>Crusher/Site</th>
                                                                <th>DSTN</th>
                                                                <th>Serial</th>
                                                                <th>WGT</th>
                                                                <th>Driver Name</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="table-sm">
                                                            @foreach ($sercices as $t_record)
                                                            <tr class="trFontSize">
                                                                <td>{{ date('d/m/Y', strtotime($t_record->date)) }}</td>
                                                                <td>{{$t_record->truck->vehicle_number}}</td>
                                                                <td>{{$t_record->material}}</td>
                                                                <td>{{$t_record->crusher}}</td>
                                                                <td>{{$t_record->destination}}</td>
                                                                <td>{{$t_record->serial_no}}</td>
                                                                <td>{{$t_record->weight}}</td>
                                                                <td>{{$t_record->driver_name}}</td>
                                                                <td class="">
                                                                    @if ($t_record->is_invoiced==0)
                                                                    <a href="#" class="btn truckInfoEdit" record-id="{{$t_record->id}}" title="Edit" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;">
                                                                        <img src="{{asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;">
                                                                    </a>

                                                                    <a href="{{ route('delete-vehicle-service', $t_record->id)}}" class="btn" title="Delete" onclick="return confirm('Are you sure to delete this?')" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;">
                                                                        <img src="{{asset('assets/backend/app-assets/icon/delete-icon.png')}}" style=" height: 30px; width: 30px;">
                                                                    </a>
                                                                    @else
                                                                    Already Invoiced  
                                                                    @endif
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
    </div>
@endsection
@push('js')
<script>
    $(document).on("click", ".truckInfoEdit", function(e){
        e.preventDefault();
        var record_id= $(this).attr('record-id');
        // alert(record_id);
        var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('get-a-record') }}",
                method: "POST",
                data: {
                    record_id:   record_id,
                    _token: _token,
                },
                success: function(response) {
                    console.log(response[0]);
                    $('#record_id').val(record_id);
                    $('#party_id_edit').val(response[0].customer_id);
                    $('#driver_name_edit').val(response[0].driver_name);
                    $('#date_edit').val(response[0].date);
                    $('#truck_id_edit').val(response[0].truck_id);
                    $('#material_edit').val(response[0].material);
                    $('#crusher_edit').val(response[0].crusher);
                    $('#dstm_edit').val(response[0].destination);
                    $('#serial_edit').val(response[0].serial_no);
                    $('#wgt_edit').val(response[0].weight);
                    $('#third_party_id_edit').val(response[0].pi_name);
                    // $('#serial_edit option[value="'+response.owner+'"]').attr("selected", "selected");
                    $('.common-select2').select2();
                    
                }
            });

        $("#truckInfoEditModal").modal('show');
    });

    // var items= @json(session('items'));
    @if(session('items'))
    var items=@json(session('items'));
    @else
    var items=[];
    @endif

    function delete_item(id){
        // alert('Deleted');
        var result= confirm('Are you sure to Delete this?!');
        if(result == true){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('remove-session-item') }}",
                method: "POST",
                data: {
                    data_id:   id,
                    _token: _token,
                },
                success: function(response) {
                    console.log(response);
                    items= response;
                    create_service_table();
                    
                }
            });
        }
    }

    $('.btn_create').click(function(){
        console.log(items);
        create_service_table();
    });


    $('#fld_serial').keyup(function(){
        
        var _token = $('input[name="_token"]').val();
        var serial_no= $(this).val();
            $.ajax({
                url: "{{ route('check-service-serial') }}",
                method: "POST",
                data: {
                    serial_no:   serial_no,
                    _token: _token,
                },
                success: function(response) {
                    if(response==1){
                        $('#serial_err').html('Serial number exist!');
                        $('#serial_valid').val(1);
                    }else{
                        $('#serial_err').html('');
                        $('#serial_valid').val(0); 
                    }
                    
                }
            });
    });

    $('.add_item').click(function(){
        var fld_date        = $('#fld_date').val();
        var fld_truck       = $('#fld_truck').val();
        var vehicle_no      = $('#fld_truck').find(':selected').attr('vehicle-no');
        var fld_material    = $('#fld_material').val();
        var fld_crusher     = $('#fld_crusher').val();
        var fld_dstn        = $('#fld_dstn').val();
        var fld_serial      = $('#fld_serial').val();
        var fld_wight       = $('#fld_wight').val();
        // var fld_truck_owner = $('#fld_truck_owner_name').attr('owner_id');
        var truck_owner_name= $('#fld_truck_owner_name').val();
        var fld_customer    = $('#fld_customer').val();
        var fld_driver_name = $('#driver_name').val();
        var serial_valid    = $('#serial_valid').val();

        // alert(vehicle_no);

        if(fld_date ==''){
            alert('Date is Required');
        }else if(fld_customer ==''){
            alert('Customer field is Required');
        }else if(fld_truck ==''){
            alert('Truck field is Required');
        }else if(fld_material ==''){
            alert('Material field is Required');
        }else if(fld_crusher ==''){
            alert('Crusher field is Required');
        }else if(fld_dstn ==''){
            alert('DSTN Field is Required');
        }else if(fld_serial ==''){
            alert('Serial Field is Required');
        }else if(serial_valid==1){
            alert('Serial Number should be unique!');
        }else if(fld_wight ==''){
            alert('Weight is Required');
        }else if(fld_driver_name ==''){
            alert('Driver Name is Required');
        }else{
            // var value = $(this).val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('add-to-session') }}",
                method: "POST",
                data: {
                    fld_customer:   fld_customer,
                    fld_driver_name:   fld_driver_name,
                    fld_date:       fld_date,
                    fld_truck:      fld_truck,
                    vehicle_no:     vehicle_no,
                    fld_material:   fld_material,
                    fld_crusher:    fld_crusher,
                    fld_dstn:       fld_dstn,
                    fld_serial:     fld_serial,
                    fld_wight:      fld_wight,
                    // fld_truck_owner:fld_truck_owner,
                    truck_owner_name:truck_owner_name,
                    _token: _token,
                },
                success: function(response) {
                    // console.log(response);
                    items= response;
                    create_service_table();
                    
                }
            });
        }
    });

    function create_service_table(){
        var html='';
        console.log(items);
        if(items){
            console.log('if true');
            var img_url= "{{asset('assets/backend/app-assets/icon/delete-icon.png')}}";
            for (var i= 0; i < items.length; i++) {
                var item = items[i];
                
                html+= 
                '<tr class="trFontSize">' +
                    '<td>'+item.date+'</td>' +
                    '<td>'+item.vehicle_no+'</td>' +
                    '<td>'+item.material+'</td>' +
                    '<td>'+item.crusher+'</td>' +
                    '<td>'+item.dstn+'</td>'+
                    '<td>'+item.serial+'</td>'+
                    '<td>'+item.wight+'</td>'+
                    '<td>'+item.truck_owner_name+'</td>'+
                    '<td>'+item.driver_name+'</td>' +
                    '<td class="">'+
                        '<a href="#" class="btn" onclick="delete_item('+i+')" title="Delete" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;">'+
                            '<img src="'+img_url+'" style=" height: 30px; width: 30px;">'+
                        '</a>'+
                    '</td>'+
                '</tr>';

            }
        }else{
            console.log('if else');
            // console.log(html);
            html= '<tr > <td colspan="9" te> <p class="text-center"> No record! </p> </td> </tr>';
        }

        $('#items_cart').html(html);
    }




    $('#record-submit').click(function(){
        // alert('Alhamdulillah');
        if(items.length>0){
            $('#save-form').submit();
        }else{
            alert('No record to submit!');
        }
        
    });

    $('#fld_truck').change(function(){
        var truck_id= $(this).val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('get-truck-details') }}",
            method: "POST",
            data: {
                truck_id: truck_id,
                _token: _token,
            },
            success: function(response) {
                console.log(response);
                $('#fld_truck_owner_name').val(response.pi_name);
                
            }
        });
    });

    $('#truck_id_edit').change(function(){
        var truck_id= $(this).val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('get-truck-details') }}",
            method: "POST",
            data: {
                truck_id: truck_id,
                _token: _token,
            },
            success: function(response) {
                console.log(response);
                $('#third_party_id_edit').val(response.pi_name);
                
            }
        });
    });
        

</script>
@endpush
