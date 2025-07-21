<form class="form form-vertical" action="{{route('rate.update', $rate->id)}}" method="POST" enctype="multipart/form-data">

    @csrf
    @method('PATCH')
    <input type="hidden" name="truck_id" id="truck_id">
    <section id="basic-vertical-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="cardStyleChange">
                    <div class="card-body">
                        <div class="form-body">
                            <h4>Rate Information- Update</h4>
                            <div class="row">
                                <div class="col-6 commonSelect2Style">
                                    <label for="">Source Name</label>
                                    <select name="cursher_id" id="cursher_id" class="form-control inputFieldHeight common-select2" required>
                                        <option value="">Select Source</option>
                                        @foreach ($cursers as $item)
                                            <option value="{{$item->id}}" {{$rate->cursher_id == $item->id?'selected':''}}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6 commonSelect2Style">
                                    <label for="">Destination Name</label>
                                    <select name="destination_id" id="destination_id" class="form-control inputFieldHeight common-select2" required>
                                        <option value="">Select Destination</option>
                                        @foreach ($destination as $item)
                                            <option value="{{$item->id}}" {{$rate->destination_id == $item->id?'selected':''}}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="">Customer Rate</label>
                                    <input type="number" step="any" class="form-control inputFieldHeight" name="customer_rate" required value="{{$rate->customer_rate}}">
                                </div>
                                <div class="col-6">
                                    <label for="">Supplier Rate</label>
                                    <input type="number" step="any" class="form-control inputFieldHeight" name="supplier_rate" required value="{{$rate->supplier_rate}}">
                                </div>
                                <div class="col-6">
                                    <label for="">Commission Rate</label>
                                    <input type="number" step="any" class="form-control inputFieldHeight" name="commission_rate" value="{{$rate->commission_rate}}">
                                </div>
                                <div class="col-6">
                                    <label for="">Rak Toll</label>
                                    <input type="number" step="any" class="form-control inputFieldHeight" name="rak_toll" required value="{{$rate->rak_toll}}">
                                </div>
                                <div class="col-6">
                                    <label for="">Sharjah Toll</label>
                                    <input type="number" step="any" class="form-control inputFieldHeight" name="sharjah_toll" required value="{{$rate->sharjah_toll}}">
                                </div>
                                <div class="col-6">
                                    <label for="">FNRC Toll</label>
                                    <input type="number" step="any" class="form-control inputFieldHeight" name="fnrc_toll" value="{{$rate->fnrc_toll}}">
                                </div>
                                <div class="col-md-12 d-flex justify-content-end mt-2 mb-2" >
                                    <button type="submit" class="btn btn-primary formButton" title="Update">
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