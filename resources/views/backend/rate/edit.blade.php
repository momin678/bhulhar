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
                                
                                <div class="col-12 mt-1">
                                    <table class="table table-bordered table-sm ">
                                        <thead>
                                            <tr>
                                                <th style="width: 50%;text-align:center;">Toll Name </th>
                                                <th style="width: 30%;text-align:center;">RATE</th>
                                                <th  class="NoPrint"> <button type="button" class="btn btn-sm "style="border: 1px solid black;
                                                    color: black; border-radius: 10px;padding: 5px; margin: 4px;" id="BtnAdd_edit">ADD</button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="TBody_edit">
                                            @foreach ($toll_rates as $key => $rate)
                                                <tr>
                                                    <td>
                                                        <select name="inputs[{{$key}}][toll_id]" style="width: 100%; height: 36px;" >
                                                            <option value=""> ----- Choice Option ----</option>
                                                            @foreach ($tolls as $item)
                                                                <option value="{{ $item->id }}" {{$rate->toll_id == $item->id?'selected':''}}>{{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" name="inputs[{{$key}}][rate]" step="any" value="{{$rate->amount}}">
                                                    </td>
                                                    <td class="NoPrint">
                                                        <button style="border-radius: 10px;padding: 5px; margin: 4px;" type="button" class="btn btn-sm btn-danger BtnAdd_edit">DELETE</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr id="TRow_edit" class="d-none">
                                                <td>
                                                     <select name="inputs[{{count($toll_rates)}}][toll_id]" style="width: 100%; height: 36px;" >
                                                        <option value=""> ----- Choice Option ----</option>
                                                        @foreach ($tolls as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control text-end rate" name="inputs[{{count($toll_rates)}}][rate]" step="any">
                                                </td>
                                                <td class="NoPrint">
                                                    <button style="border-radius: 10px;padding: 5px; margin: 4px;" type="button" class="btn btn-sm btn-danger BtnAdd_edit">DELETE</button>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
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