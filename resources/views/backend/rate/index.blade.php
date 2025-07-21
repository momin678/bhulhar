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
                                        <h4 class="flex-grow-1 pl-1">Route List</h4>
                                        <div>
                                            <button type="button" class="btn btn-primary btn_create formButton mr-1" title="Add" data-toggle="modal" data-target="#newRateAddModal">
                                                <div class="d-flex">
                                                    <div class="formSaveIcon">
                                                        <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" width="25">
                                                    </div>
                                                    <div><span>Add New</span></div>
                                                </div>
                                            </button>
                                            <button type="button" class="btn btn-primary btn_create1 formButton mr-1" title="Add Toll Name" data-toggle="modal" data-target="#newRateAddModal1">
                                                <div class="d-flex">
                                                    <div class="formSaveIcon">
                                                        <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" width="25">
                                                    </div>
                                                    <div><span>Add New Toll Name</span></div>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </section>
                                <div class="card-body pt-0">
                                    <div class="table-responsive" style="min-height: 300px">
                                        <div class="table-responsive">
                                            <table class="table mb-0 table-sm table-hover">
                                                <thead  class="thead-light">
                                                    <tr style="height: 50px;">
                                                        <th>Sources</th>
                                                        <th>Destination</th>
                                                        <th>Customer Rate</th>
                                                        <th>Supplier Rate</th>
                                                        <th>Driver Commission </th>
                                                        <th>Toll</th>
                                                        <th class="text-right pr-2">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-sm">
                                                    @foreach ($rates as $item)
                                                    <tr class="trFontSize">
                                                        <td>{{$item->source->name}}</td>
                                                        <td>{{$item->destination->name}}</td>
                                                        <td>{{$item->customer_rate}}</td>
                                                        <td>{{$item->supplier_rate}}</td>
                                                        <td>{{$item->commission_rate}}</td>
                                                        <td>{{$item->toll_amount($item->source->id, $item->destination->id)}}</td>
                                                        <td class="text-right pr-2">
                                                            <a href="#" class="btn rateEdit" title="Edit" id="{{$item->id}}" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;">
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
<div class="modal fade" id="newRateAddModal1" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <section class="print-hideen border-bottom">
            <div class="d-flex flex-row-reverse">
                <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                {{-- <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-success"><i class="bx bx-edit"></i></a></div>
                <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
                <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
                <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
            </div>
        </section>
        <div class="content-body">
            <form class="form form-vertical" action="{{ route('toll-name-store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col-md-12 col-12">
                            <div class="cardStyleChange">
                                <div class="card-body">
                                    <div class="form-body">
                                        <h4>Toll Name</h4>
                                        <div class="row">
                                            <div class="col-6 commonSelect2Style">
                                                <label for="">Toll Name</label>
                                                <input type="text" step="any" class="form-control inputFieldHeight" name="toll_name" required value="">

                                            </div>
                                            <div class="col-6 commonSelect2Style">
                                                <label for="">Toll Fee</label>
                                                <input type="text" step="any" class="form-control inputFieldHeight" name="toll_amount"  value="">

                                            </div>
                                            </div>

                                            <div class="col-md-12 d-flex justify-content-end mt-2 mb-2" >
                                                <button type="submit" class="btn btn-primary formButton" title="Add">
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
    <div class="modal fade" id="newRateAddModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <section class="print-hideen border-bottom">
                <div class="d-flex flex-row-reverse">
                    <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                    {{-- <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-success"><i class="bx bx-edit"></i></a></div>
                    <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
                    <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
                    <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
                </div>
            </section>
            <div class="content-body">
                <form class="form form-vertical" action="{{ route('rate.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <section id="basic-vertical-layouts">
                        <div class="row match-height">
                            <div class="col-md-12 col-12">
                                <div class="cardStyleChange">
                                    <div class="card-body">
                                        <div class="form-body">
                                            <h4>Route Information</h4>
                                            <div class="row">
                                                <div class="col-6 commonSelect2Style">
                                                    <label for="">Source Name</label>
                                                    <select name="cursher_id" id="cursher_id" class="form-control inputFieldHeight common-select2" required onchange="chack_exit()">
                                                        <option value="">Select Source</option>
                                                        @foreach ($cursers as $item)
                                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-6 commonSelect2Style">
                                                    <label for="">Destination Name</label>
                                                    <select name="destination_id" id="destination_id" class="form-control inputFieldHeight common-select2" required onchange="chack_exit()">
                                                        <option value="">Select Destination</option>
                                                        @foreach ($destination as $item)
                                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <label for="">Customer Rate</label>
                                                    <input type="number" step="any" class="form-control inputFieldHeight" name="customer_rate" required value="{{old('customer_rate')}}">
                                                </div>
                                                <div class="col-6">
                                                    <label for="">Supplier Rate</label>
                                                    <input type="number" step="any" class="form-control inputFieldHeight" name="supplier_rate" required value="{{old('supplier_rate')}}">
                                                </div>
                                                <div class="col-6">
                                                    <label for="">Commission Rate</label>
                                                    <input type="number" step="any" class="form-control inputFieldHeight" name="commission_rate" value="{{old('commission_rate')}}">
                                                </div>
                                                <div class="col-12 mt-1">
                                                    <table class="table table-bordered table-sm ">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 50%;text-align:center;">Toll Name </th>
                                                                <th style="width: 30%;text-align:center;">RATE</th>
                                                                <th  class="NoPrint"> <button type="button" class="btn btn-sm "style="border: 1px solid black;
                                                                    color: black; border-radius: 10px;padding: 5px; margin: 4px;" onclick="BtnAdd()">ADD</button>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="TBody">
                                                            <tr id="TRow" class="d-none">
                                                                <td>
                                                                     <select name="inputs[0][toll_id]" onchange="option(this);"  class="job_group_id" style="width: 100%;    HEIGHT: 36PX;" >
                                                                        <option value=""> ----- Choice Option ----</option>
                                                                        @foreach ($tolls as $item)
                                                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="number" class="form-control text-end rate" name="inputs[0][rate]" step="any">
                                                                </td>
                                                                <td class="NoPrint">
                                                                    <button style="border-radius: 10px;padding: 5px; margin: 4px;" type="button" class="btn btn-sm btn-danger"onclick="BtnDel(this)">DELETE</button>
                                                                </td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-12 d-flex justify-content-end mt-2 mb-2" >
                                                    <button type="submit" class="btn btn-primary formButton" title="Add">
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
    <div class="modal fade" id="rateEditModal" tabindex="-1" rrole="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <section class="print-hideen border-bottom">
                <div class="d-flex flex-row-reverse">
                    <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                    {{-- <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-success"><i class="bx bx-edit"></i></a></div>
                    <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
                    <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
                    <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
                </div>
            </section>
            <div class="content-body" id="edit_rate_model">

            </div>
          </div>
        </div>
    </div>
@endsection
@push('js')
<script>
    $(document).on("click", ".rateEdit", function(e){
        e.preventDefault();
        var rate_id= $(this).attr('id');
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('rate-edit-model') }}",
            method: "POST",
            data: {
                rate_id:rate_id,
                _token: _token,
            },
            success: function(response) {
                $('#edit_rate_model').html(response);
                $("#rateEditModal").modal('show');
            }
        });
    });
    function chack_exit(){
        var cursher_id = $("#cursher_id").val();
        var destination_id = $("#destination_id").val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ route('check-exit-rate') }}",
            method: "POST",
            data: {
                cursher_id:cursher_id,
                destination_id:destination_id,
                _token: _token,
            },
            success: function(response) {
                if(response){
                    alert('This Source to Destination already exit');
                }
            }
        });
    }
    $(document).on("click", "#BtnAdd_edit", function(e){
        var newRow = $("#TRow_edit").clone();
        newRow.removeClass("d-none");

        newRow.find("input, select").val('').attr('name', function(index, name) {
            return name.replace(/\[\d+\]/, '[' + ($('#TBody_edit tr').length - 1) + ']');
        });

        newRow.find("th").first().html($('#TBody_edit tr').length );
        newRow.appendTo("#TBody_edit");
    })
    $(document).on("click", ".BtnAdd_edit", function(e){
        var v = $(this);
        $(v).parent().parent().remove();

        $("#TBody_edit").find("tr").each(function(index) {
            $(this).find("th").first().html(index);
        });
    })
    function BtnAdd() {
    /* Add Button */
    var newRow = $("#TRow").clone();
    newRow.removeClass("d-none");

    newRow.find("input, select").val('').attr('name', function(index, name) {
        return name.replace(/\[\d+\]/, '[' + ($('#TBody tr').length - 1) + ']');
    });

    newRow.find("th").first().html($('#TBody tr').length );
    newRow.appendTo("#TBody");
 }
 function BtnDel(v) {
    /* Delete Button */
    $(v).parent().parent().remove();

    $("#TBody").find("tr").each(function(index) {
        $(this).find("th").first().html(index);
    });
}
</script>
@endpush
