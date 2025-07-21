@extends('layouts.backend.app')
@section('content')
@include('layouts.backend.partial.style')
<style>
    .table td {
        border-bottom: none;
    }

    .commonSelect2Style span {
        width: 100% !important;
    }

    .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
        display: none;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        display: none;
        margin-left: 105px;
    }

    .table-no-padding {
        padding: 0;
        margin: 0;
    }

    .table-no-padding td,
    .table-no-padding th {
        padding: 0;
        margin: 0;
        vertical-align: middle;
    }

    .inputFieldHeight {
        height: 20px;
    }

    .smallFontSize {
        font-size: 10px;
    }

    .inputFieldHeight {
        height: 25px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        font-size: 10px !important;
        color: #a7b3c0
    }

    .select2-container--default .select2-selection--single {
        height: 25px !important;
        min-height: 25px !important;

    }

    .select2-container {
        display: inline !important;

    }

    th {
        padding-left: 3px !important;
        padding-right: 3px !important;
    }
    .modal-lg {
    max-width: 100% !important;
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
                                            <section id="widgets-Statistics" class="mt-2 mb-1">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <form action="">
                                                            <div class="changeColStyle">
                                                                <label for="">Search Service</label>
                                                                <input type="text" class="form-control inputFieldHeight"
                                                                    name="search"
                                                                    placeholder="Search by driver name, material, serial no, truck no">
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="col-md-7 mt-2">
                                                        <button type="button"
                                                            class="btn btn-primary btn_create formButton mr-1 float-right newTruckAddModal"
                                                            title="Add" data-toggle="modal"
                                                            data-target="#newTruckAddModal">
                                                            <div class="d-flex">
                                                                <div class="formSaveIcon">
                                                                    <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}"
                                                                        width="25">
                                                                </div>
                                                                <div><span>Add New</span></div>
                                                            </div>
                                                        </button>
                                                        <button type="button"
                                                            onclick="newexportTableToCSV('ServiceExport.csv')"
                                                            class="mExcelButton btn btn_create formButton mr-1 float-right"
                                                            title="Export To Excel">
                                                            <div class="d-flex">
                                                                <div class="formSaveIcon">
                                                                    <img src="{{asset('assets/backend/app-assets/icon/excel-icon.png')}}"
                                                                        width="25">
                                                                </div>
                                                                <div><span>Export To Excel</span></div>
                                                            </div>
                                                        </button>
                                                        <button type="button"
                                                            class="btn mPdfPrint btn_create formButton mr-1 float-right"
                                                            title="Excel Import" data-toggle="modal"
                                                            data-target="#excel_import">
                                                            <div class="d-flex">
                                                                <div class="formSaveIcon">
                                                                    <img src="{{asset('assets/backend/app-assets/icon/excel-icon.png')}}"
                                                                        width="25">
                                                                </div>
                                                                <div><span>Excel Import</span></div>
                                                            </div>
                                                        </button>
                                                    </div>
                                                </div>
                                            </section>
                                            <div class="table-responsive" style="min-height: 300px">
                                                <form action="{{route('truck-service-delete')}}" method="post">
                                                    @csrf
                                                    <table class="table mb-0 table-sm table-hover">
                                                        <thead class="thead-light">
                                                            <tr style="height: 50px;">
                                                                <th>
                                                                    <input type="checkbox" id="vehicle1"
                                                                        class="btn-select-all" name="vehicle1"
                                                                        value="Bike">
                                                                    <label for="vehicle1">Check All</label>
                                                                </th>
                                                                <th>Date</th>
                                                                <th>Party Name</th>
                                                                <th>Truck</th>
                                                                <th>Material</th>
                                                                <th>Crusher/Site</th>
                                                                <th>DSTN</th>
                                                                <th>Serial</th>
                                                                <th>WGT</th>
                                                                <th>Driver Name</th>
                                                                <th class="text-center">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="table-sm">
                                                            @foreach ($records as $t_record)
                                                            <tr class="trFontSize">
                                                                <td><input type="checkbox" class="checkbox-record"
                                                                        name="records[]" value="{{$t_record->id}}"></td>
                                                                <td>{{date('d/m/Y', strtotime($t_record->date))}}</td>
                                                                <td>{{$t_record->customer?$t_record->customer->pi_name:''}}
                                                                </td>
                                                                <td>{{$t_record->truck->vehicle_number}}</td>
                                                                <td>{{$t_record->material}}</td>
                                                                <td>{{$t_record->crusher}}</td>
                                                                <td>{{$t_record->destination}}</td>
                                                                <td>{{$t_record->serial_no}}</td>
                                                                <td>{{$t_record->weight}}</td>
                                                                <td>{{$t_record->driver_name_info?$t_record->driver_name_info->full_name:''}}</td>
                                                                <td class="">
                                                                    @if ($t_record->is_invoiced==0)
                                                                    <a href="#" class="btn truckInfoEdit"
                                                                        record-id="{{$t_record->id}}" title="Edit"
                                                                        style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;">
                                                                        <img src="{{asset('assets/backend/app-assets/icon/edit-icon.png')}}"
                                                                            style=" height: 30px; width: 30px;">
                                                                    </a>

                                                                    <a href="{{ route('delete-vehicle-service', $t_record->id)}}"
                                                                        class="btn" title="Delete"
                                                                        onclick="return confirm('Are you sure to delete this?')"
                                                                        style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;">
                                                                        <img src="{{asset('assets/backend/app-assets/icon/delete-icon.png')}}"
                                                                            style=" height: 30px; width: 30px;">
                                                                    </a>
                                                                    @else
                                                                    Already Invoiced
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                    <div class="col-md-12 mt-1 text-right">
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Are you sure to delete ?')">Delete</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="mt-1">{{ $records->links() }}</div>
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
<div class="modal fade bd-example-modal-lg" id="newTruckAddModal" tabindex="-1" rrole="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="width:100%" role="document">
        <div class="modal-content">
            <section class="print-hideen border-bottom">
                <div class="d-flex flex-row-reverse">
                    <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal"
                            aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                    {{-- <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-success"><i
                                class="bx bx-edit"></i></a></div>
                    <div class="mIconStyleChange"><a href="#" onclick="window.print();"
                            class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
                    <div class="mIconStyleChange"><a href="#" onclick="window.print();"
                            class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
                    <div class="mIconStyleChange"><a href="#" onclick="window.print();"
                            class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
                </div>
            </section>
            <div class="content-body">
                <form class="form form-vertical" id="save-form" action="{{ route('save-truck-service')}}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <section id="basic-vertical-layouts" class="p-2">
                        <table class="table table-bordered table-sm table-responsive table-no-padding input-table"
                            style="overflow-y: hidden;min-height:300px">
                            <thead>
                                <tr style="white-space: nowrap;height:25px">
                                    <th class="text-center">Party</th>
                                    <th class="text-center">Driver Name</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Truck</th>
                                    <th class="text-center">Material</th>
                                    <th class="text-center">Crusher/Source</th>
                                    <th class="text-center">Destination</th>
                                    <th class="text-center">WGT</th>
                                    <th class="text-center">Rate</th>
                                    <th class="text-center">Commission</th>
                                    <th class="text-center">TKT Number</th>
                                    {{-- <th class="text-center">Transporter</th>
                                    <th class="text-center">Third Party</th> --}}
                                    <th class="text-center">Toll Fee</th>
                                    <th class="text-center">Toll Name</th>
                                    <th class="NoPrint text-center">Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="TBody">
                                <tr id="TRow" class="d-none p-0 h6">
                                    <td class="p-0">
                                        <select name="inputs[0][crusher]" required
                                            class="form-control inputFieldHeight crusher smallFontSize" disabled>
                                            <option value="">Select Source</option>
                                            @foreach ($crusher as $item)
                                            <option value="{{$item->name}}" data-crusher_id="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="p-0">
                                        <select name="inputs[0][dstm]" required
                                            class="form-control inputFieldHeight dstm smallFontSize" disabled>
                                            <option value="">Select Destination</option>
                                            @foreach ($destination as $item)
                                            <option value="{{$item->name}}" data-dstm_id="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="p-0">
                                        <select name="inputs[0][party_id]" required
                                            class="form-control inputFieldHeight party_id smallFontSize" disabled>
                                            <option value="">Select Customer</option>
                                            @foreach ($customers as $customer)
                                            <option value="{{$customer->id}}">{{$customer->pi_name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="p-0">
                                        <select name="inputs[0][driver_name]" required
                                            class="form-control inputFieldHeight smallFontSize" disabled>
                                            <option value="">Select Driver</option>
                                            @foreach ($dirves as $item)
                                            <option value="{{$item->id}}">{{$item->full_name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="p-0">
                                        <input type="text" name="inputs[0][date]" required autocomplete="off"
                                            class="form-control date- inputFieldHeight smallFontSize "
                                            placeholder="Date" disabled>
                                    </td>
                                    <td class="p-0">
                                        <select name="inputs[0][truck_id]"
                                            class="form-control inputFieldHeight truck_id  smallFontSize" required disabled>
                                            <option value="">Select Truck</option>
                                            @foreach ($trucks as $truck)
                                            <option value="{{$truck->id}}">{{$truck->vehicle_number}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="p-0">
                                        <select name="inputs[0][material]" required
                                            class="form-control inputFieldHeight material smallFontSize" disabled>
                                            <option value="">Select Material</option>
                                            @foreach ($materials as $item)
                                            <option value="{{$item->name}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    
                                    <td class="p-0">
                                        <input type="number" name="inputs[0][wgt]" required
                                            class="form-control inputFieldHeight wgt smallFontSize" placeholder="WGT"
                                            step="any" disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="number" name="inputs[0][rate]" required
                                            class="form-control inputFieldHeight rate smallFontSize" placeholder="Rate"
                                            disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="number" name="inputs[0][commision]" required
                                            class="form-control inputFieldHeight commision smallFontSize" placeholder="Commission"
                                            disabled>
                                    </td>
                                    <td class="p-0">
                                        <input type="number" name="inputs[0][tkt_number]" required
                                            class="form-control inputFieldHeight tkt_number smallFontSize" placeholder="TKT Number"
                                            disabled>
                                        <small  class=" exit_tkt_number text-danger"></small>
                                    </td>
                                    <td class="p-0 d-none">
                                        <input type="text" name="inputs[0][trasporter]"
                                            class="form-control inputFieldHeight  trasporter smallFontSize"
                                            placeholder="Transporter" disabled>
                                    </td>
                                    <td class="p-0 d-none">
                                        <input type="text" name="inputs[0][fld_truck_owner_name]"
                                            class="form-control inputFieldHeight fld_truck_owner_name smallFontSize" placeholder="Owner"
                                            disabled readonly>
                                    </td>
                                    <td class="p-0">
                                        <input type="decimal" name="inputs[0][toll_fee]" required
                                            class="form-control inputFieldHeight toll_fee smallFontSize" placeholder="Toll Fee"
                                            disabled readonly>
                                    </td>
                                    <td class="p-0">
                                        <select name="inputs[0][toll_name]" required
                                            class="form-control last-select inputFieldHeight smallFontSize" disabled>
                                            <option value="">Select Name</option>
                                            @foreach ($tolls as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="text-center" style="min-width: 73px;">
                                        <button type="button" class="btn btn-sm "
                                        style="border: 1px solid #fff;
                                    color: #fff; border-radius: 10px;padding: 1px; margin: 0px; font-size:12px;background: #10853a;" onclick="BtnAdd('#TRow', '#TBody')">ADD</button>
                                        <button style="border-radius: 10px;padding: 3px; margin: 0px; font-size:10px"
                                            type="button" class="btn btn-sm btn-danger"
                                            onclick="if(confirm('Are you sure you want to delete?')) { BtnDel(this); }">DEL</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary formButton mt-1 mb-1" id="record-submit"
                            title="save">
                            <div class="d-flex">
                                <div class="formSaveIcon">
                                    <img src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt=""
                                        srcset="" width="20">
                                </div>
                                <div><span>save</span></div>
                            </div>
                        </button>
                    </section>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="truckInfoEditModal" tabindex="-1" rrole="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <section class="print-hideen border-bottom">
                <div class="d-flex flex-row-reverse">
                    <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal"
                            aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                    {{-- <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-success"><i
                                class="bx bx-edit"></i></a></div>
                    <div class="mIconStyleChange"><a href="#" onclick="window.print();"
                            class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
                    <div class="mIconStyleChange"><a href="#" onclick="window.print();"
                            class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
                    <div class="mIconStyleChange"><a href="#" onclick="window.print();"
                            class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
                </div>
            </section>
            <div class="content-body" id="truck_entry_edit_content">

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="excel_import" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Import MS Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('excel-import')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" class="form-controll" name="excel_file">
                    @php
                    $token = time()+rand(10000,99999);
                    @endphp
                    <input type="hidden" name="token" value="{{$token}}">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')

<script>
        function BtnAdd(trow, tbody) {
            var $trow = $(trow);
            var $tbody = $(tbody);
            var newRow = $trow.clone().removeClass("d-none").removeAttr('id');
            newRow.find("input, select, textarea").prop('disabled', false);
            newRow.find("select").addClass('common-select2');
            newRow.find(".date-").addClass('datepicker');

            var $rows = $tbody.children('tr').not($trow);
            var lastIndex = 0;
            var lastRow = $rows.last();
                var lastInputName = lastRow.find("input[name^='inputs']").attr('name');
                var lastSelectName = lastRow.find("select[name^='inputs']").attr('name');
                var lastTextName = lastRow.find("textarea[name^='inputs']").attr('name');
                var lastName = lastInputName || lastSelectName || lastTextName;
                var match = lastName && lastName.match(/\[(\d+)\]/);
                if (match) {
                    lastIndex = parseInt(match[1], 10);
                }
            var newIndex = lastIndex + 1;

            newRow.find("input, select, textarea").attr('name', function (index, name) {
                return name.replace(/\[\d+\]/, '[' + newIndex + ']');
            });
            newRow.appendTo(tbody);
            // Get values of the last row fields
            var fieldValues = {};
                lastRow.find("input, select, textarea").each(function (index, element) {
                    var fieldName = $(element).attr('name');
                    var fieldValue = $(element).val();
                    fieldName = fieldName.replace(/\[\d+\]/, '[' + newIndex + ']');
                    fieldValues[fieldName] = fieldValue;
                    var updatedFieldName = fieldName.replace(/\[\d+\]/, '[' + newIndex + ']');
                    newRow.find('[name="'+updatedFieldName+'"]').val(fieldValues[updatedFieldName]);

                });

            newRow.find(".wgt").focus().select();
            newRow.find(".common-select2").select2();
            newRow.find(".datepicker").datepicker({ dateFormat: "dd/mm/yy" });
        }

        function BtnDel(v) {
            $(v).parent().parent().remove();
            GetTotal();
        }
        $(document).on('click','.newTruckAddModal',function(e){
            BtnAdd('#TRow', '#TBody');
        })

        // Event handler for arrow key navigation
        $('.input-table').on('keydown', 'input, select', function (e) {

            var $this = $(this);
            var index = $this.closest('td').index();
            var $tr = $this.closest('tr');

            switch (e.which) {
                case 37: // Left arrow key
                    if (index > 0) {
                        e.preventDefault();
                        $tr.find('td:eq(' + (index - 1) + ')').find(':input, select').focus().select2('open');
                    }
                    break;
                case 38: // Up arrow key
                e.preventDefault();
                    var $prevRow = $tr.prev('tr');
                    if ($prevRow.length > 0) {
                        $prevRow.find('td:eq(' + index + ')').find(':input, select').focus().select2('open');
                    }
                    break;
                case 39: // Right arrow key
                e.preventDefault();
                    if (index < $tr.find('td').length - 1) {
                        $tr.find('td:eq(' + (index + 1) + ')').find(':input, select').focus().select2('open');
                    }
                    break;
                case 40: // Down arrow key
                e.preventDefault();
                    var $nextRow = $tr.next('tr');
                    if ($nextRow.length > 0) {
                        $nextRow.find('td:eq(' + index + ')').find(':input, select').focus().select2('open');
                    }
                    break;
            }
        });
        $('.input-table').on('change', 'select', function () {
            var $this = $(this);
            var $nextInput = $this.closest('td').next('td').find(':input, select') ;
                $nextInput.focus().select2('open');

        });

    $(document).on('change', '.last-select', function (e) {
        alert(58)

        if (e.which == 13) {
            alert(58)
            e.preventDefault()
            BtnAdd('#TRow', '#TBody');

        }
    });

</script>
<script>
    function newexportTableToCSV(filename) {
        var csv = [];
        var rows = document.querySelectorAll("#serviceExport tr");

        for (var i = 0; i < rows.length; i++) {
            var row = [],
                cols = rows[i].querySelectorAll("td, th");

            for (var j = 0; j < cols.length; j++)
                row.push("\"" + cols[j].innerText + "\"");

            csv.push(row.join(","));
        }

        // Download CSV file
        downloadCSV(csv.join("\n"), filename);
    }



    $(document).on("click", ".truckInfoEdit", function(e){
        e.preventDefault();
        var record_id= $(this).attr('record-id');
        // alert(record_id);
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('get-a-record') }}",
            method: "POST",
            data: {
                record_id:record_id,
                _token: _token,
            },
            success: function(response) {
                $("#truck_entry_edit_content").html(response);
                $("#truckInfoEditModal").modal('show');
                $('.common-select2').select2();
            }
        });
    });


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
                    // create_service_table();

                }
            });
        }
    }

    $('.btn_create').click(function(){
        // create_service_table();
    });
    var check_tkt_status = false;
    $(document).on('keyup', '.tkt_number', function(e){
        e.preventDefault();
        var tr =  $(this).closest('tr');

        var tkt_number = $(this).val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('check-exit-tkt-number') }}",
            method: "POST",
            data: {
                tkt_number: tkt_number,
                _token: _token,
            },
            success: function(response) {
                if(response){
                    tr.find('.exit_tkt_number').html('This TKT Number Already Exit');
                    check_tkt_status = true;
                }else{
                    tr.find('.exit_tkt_number').html('');
                    check_tkt_status = false;
                }
            }
        });
    })



    $('.truck_id').change(function(){
        var truck_id= $(this).val();
        var tr =  $(this).closest('tr');
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('get-truck-details') }}",
            method: "POST",
            data: {
                truck_id: truck_id,
                _token: _token,
            },
            success: function(response) {
                tr.find('.fld_truck_owner_name').val(response.pi_name);
                tr.find('.trasporter').val(response.pi_name);
                // $("#fld_material").focus();


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
    $('.btn-select-all').click(function (event) {
        if (this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function () {
                this.checked = true;
            });
        } else {
            $(':checkbox').each(function () {
                this.checked = false;
            });
        }
    });
    $(".crusher").change(function(){
        var tr =  $(this).closest('tr');

        rateChack(tr);
        toll_rate_check(tr);
    });
    $(".dstm").change(function(){
        var tr =  $(this).closest('tr');

        rateChack(tr);
        toll_rate_check(tr);
    });
    $(document).on('keyup', '.wgt', function(e){
        var tr =  $(this).closest('tr');

        toll_rate_check(tr);
    });
    function rateChack(tr){
        var fld_crusher = $("crusher").val();
        var fld_dstn = $(".dstm").val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('check-exit-rate') }}",
            method: "POST",
            data: {
                cursher_id:fld_crusher,
                destination_id:fld_dstn,
                _token: _token,
            },
            success: function(response) {
                if(response){
                    tr.find(".rate").val(response.customer_rate);
                    tr.find(".commision").val(response.commission_rate);
                    // $("#toll_fee").val(response.rak_toll+response.sharjah_toll+response.fnrc_toll);
                }else{
                    if(fld_crusher && fld_dstn){
                        alert("Rate Not Inputed")
                    }
                    tr.find(".rate").val();
                    tr.find(".commision").val();
                    // $("#toll_fee").val();
                }
            }
        });
    }
    function toll_rate_check(tr){
        var fld_crusher = tr.find('.crusher option:selected').data('crusher_id');
        var fld_dstn =tr.find(".dstm option:selected").data('dstm_id');
        var fld_wight =tr.find('.wgt').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('check-exit-toll-fee') }}",
            method: "POST",
            data: {
                cursher_id:fld_crusher,
                destination_id:fld_dstn,
                wight:fld_wight,
                _token: _token,
            },
            success: function(response) {
                if(response){
                    tr.find(".toll_fee").val(response);
                }else{
                    if(fld_crusher && fld_dstn && fld_wight){
                        alert("Rate Not Inputed")
                    }
                    tr.find(".toll_fee").val();
                }
            }
        });
    }
</script>
@endpush
