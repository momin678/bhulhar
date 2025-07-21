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
            @include('clientReport.service-inentory.header', ['activeMenu' => 'token'])
            <div class="tab-content bg-white">
                @include('backend.token-gen.sub-head',['activeMenu' => 'create'])
                <div class="tab-pane active">
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="cardStyleChange p-1">
                                <section id="widgets-Statistics" class="mb-1">
                                    <div class="d-flex">
                                        <h4 class="flex-grow-1 pl-1">Token List</h4>
                                        <div>
                                            <button type="button" class="btn btn-primary btn_create formButton mr-1" title="Add" data-toggle="modal" data-target="#newRateAddModal">
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
                                        <div class="table-responsive">
                                            <table class="table mb-0 table-sm table-hover">
                                                <thead  class="thead-light">
                                                    <tr style="height: 50px;">
                                                        <th>Token Number</th>
                                                        <th>Truck Number</th>
                                                        <th>Driver Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-sm">
                                                    @foreach ($tokens as $item)
                                                    <tr class="trFontSize">
                                                        <td><a href="#" class="truck_expence_details" id="{{$item->exit_token?$item->exit_token->id:''}}">{{$item->token_no}}</a></td>
                                                        <td>{{$item->truck?$item->truck->vehicle_number:''}}</td>
                                                        <td>{{$item->driver?$item->driver->full_name:''}}</td>
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
    <div class="modal fade" id="newRateAddModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <section class="print-hideen border-bottom">
                <div class="d-flex flex-row-reverse">
                    <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                </div>
            </section>
            <div class="content-body">
                <form class="form form-vertical" action="{{ route('token-gereration.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <section id="basic-vertical-layouts">
                        <div class="row match-height">
                            <div class="col-md-12 col-12">
                                <div class="cardStyleChange">
                                    <div class="card-body">
                                        <div class="form-body">
                                            <h4>Token Generattion</h4>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="">Token Number</label>
                                                    <input type="number" step="any" class="form-control inputFieldHeight" name="token_no" required value="{{$max_token}}" readonly>
                                                </div>
                                                <div class="col-12 commonSelect2Style">
                                                    <label for="">Vehicle Number</label>
                                                    <select name="truck_id" id="truck_id" class="form-control inputFieldHeight common-select2" required>
                                                        <option value="">Select Vehicle</option>
                                                        @foreach ($trucks as $item)
                                                            <option value="{{$item->id}}">{{$item->vehicle_number}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12 commonSelect2Style">
                                                    <label for="">Driver Name</label>
                                                    <select name="driver_id" id="driver_id" class="form-control inputFieldHeight common-select2" required>
                                                        <option value="">Select Name</option>
                                                        @foreach ($drivers as $item)
                                                            <option value="{{$item->id}}">{{$item->full_name}}</option>
                                                        @endforeach
                                                    </select>
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
    <div class="modal fade bd-example-modal-lg" id="truck_expence_detailsModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="truck_expence_detailsShow">

            </div>
          </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).on("click", ".truck_expence_details", function(e) {
            e.preventDefault();
            var id= $(this).attr('id');
            if(id){
                $.ajax({
                    url: "{{URL('vehicle-expense-view-modal')}}",
                    type: "post",
                    cache: false,
                    data:{
                        _token:'{{ csrf_token() }}',
                        id:id,
                    },
                    success: function(response){
                        document.getElementById("truck_expence_detailsShow").innerHTML = response;
                        $('#truck_expence_detailsModal').modal('show')
                    }
                });
            }else{
                toastr.warning('Token not use in maintenance job', 'Warning')
            }
        });
    </script>
@endpush
