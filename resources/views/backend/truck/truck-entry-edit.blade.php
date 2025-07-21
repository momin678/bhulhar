<form class="form form-vertical" action="{{ route('update-record')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="record_id" id="record_id" value="{{$record->id}}">
    <section id="basic-vertical-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="cardStyleChange">
                    <div class="card-body">
                        <div class="form-body">
                            <h4> WEIGH BRIDGE / DELIVERY NOTE - Update</h4>
                            <div class="row">
                                <div class="col-md-3 col-12 commonSelect2Style">
                                    <label for="">Party</label>
                                    <select name="party_id" id="party_id_edit" class="inputFieldHeight form-control ">
                                        <option value="">Select Name</option>
                                        @foreach ($customers as $customer)
                                        <option value="{{$customer->id}}" {{$customer->id==$record->customer_id?'selected':''}}>{{ $customer->pi_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 col-12 ">
                                    <label for="">Date</label>
                                    <input type="text" name="date" id="date_edit"  class="inputFieldHeight datepicker form-control" placeholder="Date" value="{{date('d/m/Y', strtotime($record->date))}}">
                                </div>
                                <div class="col-md-3 col-12 commonSelect2Style">
                                    <label for="">Truck</label>
                                    <select name="truck_id"  class="inputFieldHeight form-control ">
                                        <option value="">Select Name</option>
                                        @foreach ($trucks as $truck)
                                        <option value="{{$truck->id}}" vehicle-no="{{$truck->vehicle_number}}" {{$truck->id==$record->truck_id?'selected':''}}>{{ $truck->vehicle_number}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 col-12 commonSelect2Style">
                                    <label for="">Material</label>
                                    <select name="material"  data-dep="fld_crusher" class="inputFieldHeight form-control ">
                                        <option value="">Select Material</option>
                                        @foreach ($materials as $item)
                                            <option value="{{$item->name}}" {{$item->name==$record->material?'selected':''}}>{{ $item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 col-12 commonSelect2Style">
                                    <label for="">Crusher/Source </label>
                                    <select name="crusher"  class="inputFieldHeight form-control ">
                                        <option value="">Select Name</option>
                                        @foreach ($crusher as $item)
                                            <option value="{{$item->name}}" id="{{$item->id}}" {{$item->name==$record->crusher?'selected':''}}>{{ $item->name}}</option>
                                        @endforeach
                                    </select>
                                    {{-- <input type="text" name="crusher" id="fld_crusher" class="inputFieldHeight form-control focus" placeholder="Crusher/Site"> --}}
                                </div>
                                <div class="col-md-3 col-12 commonSelect2Style">
                                    <label for="">Destination</label>
                                    <select name="dstm"  class="inputFieldHeight form-control ">
                                        <option value="">Select Name</option>
                                        @foreach ($destination as $item)
                                            <option value="{{$item->name}}" id="{{$item->id}}" {{$item->name==$record->destination?'selected':''}}>{{ $item->name}}</option>
                                        @endforeach
                                    </select>
                                    {{-- <input type="text" name="dstm" id="fld_dstn" class="inputFieldHeight form-control focus" placeholder="DSTN"> --}}
                                </div>
                                <div class="col-md-3 col-12 ">
                                    <label for="">WGT</label>
                                    <input type="decimal" name="wgt" id="wgt_edit" class="inputFieldHeight form-control" placeholder="WGT" value="{{$record->weight}}">
                                </div>
                                <div class="col-md-3 col-12 ">
                                    <label for="">Toll Fee</label>
                                    <input type="decimal" name="toll_fee" id="toll_fee_edit" class="inputFieldHeight form-control" placeholder="Toll Fee"  value="{{$record->toll_fee}}">
                                </div>
                                <div class="col-md-3 col-12 ">
                                    <label for="">Commission</label>
                                    <input type="decimal" name="commision" id="commision_edit" class="inputFieldHeight form-control" placeholder="commission" value="{{$record->commision}}">
                                </div>
                                <div class="col-md-3 col-12 ">
                                    <label for="">TKT Number</label>
                                    <input type="text" name="tkt_number" id="tkt_number_edit" class="inputFieldHeight form-control" placeholder="TKT Number" value="{{$record->tkt_number}}">
                                    <small id="exit_tkt_number_edit" class="text-danger"></small>
                                </div>
                                <div class="col-md-3 col-12 ">
                                    <label for="">Rate</label>
                                    <input type="decimal" name="rate" id="rate_eidt" class="inputFieldHeight form-control" placeholder="Rate" value="{{$record->rate}}">
                                </div>
                                <div class="col-md-12 d-flex justify-content-end mt-2 mb-2" >
                                    <button type="submit" class="btn btn-primary formButton" title="Searching">
                                        <div class="d-flex">
                                            <div class="formSaveIcon">
                                                <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset="" width="20">
                                            </div>
                                            <div><span>Update</span></div>
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
