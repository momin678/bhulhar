<div class="apenddata invoice-items">
    <div class="row">
       <div class="card d-flex align-items-center" style="min-height: 180px">
            <div class="card-body">
                <div class="row d-flex align-items-center">
                    <div class="col-sm-3 form-group">
                        <label for="">Branch</label>
                        <select name="branch" class="form-control" id="" readonly disabled>
                            <option value="">Select...</option>
                            @foreach ($projects as $item)
                            <option value="{{ $item->proj_no }}" {{ $invoice->project_id==$item->id? "selected":"" }}>{{ $item->proj_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- <div class="col-sm-3 form-group">
                                                <label for="">GL Code</label>
                                               <input type="text" name="gl_code" id="gl_code" value="{{ $invoice->gl_code }}" class="form-control" disabled>

                                            </div> -->
                    <div class="col-sm-3 form-group">
                        <label for="">Date</label>
                        <input type="date" value="{{ $invoice->date }}" class="form-control" name="date" id="date" readonly>
                    </div>
                    <div class="col-sm-3 form-group">
                        <label for="">Tax Invoice No</label>
                        <input type="text" class="form-control" value="{{ $invoice->invoice_no }}" name="invoice_no" id="invoice_no" readonly>
                    </div>
                    <div class="col-sm-3 form-group">
                        <label for="">Customer Name</label>
                        <select name="customer_name" id="customer_name" class="form-control party-info" data-target="" readonly>
                            <option value="">Select...</option>
                            @foreach ($customers as $customer)
                            <option value=" {{ $customer->pi_name }}" {{ $invoice->customer_name==$customer->pi_code? "selected":"" }}>
                                {{ $customer->pi_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3 form-group">
                        <label for="">TRN</label>
                        <input type="text" class="form-control" value="{{  $invoice->trn_no }}" name="trn_no" id="trn_no" class="form-control" readonly>
                    </div>
                    <div class="col-sm-3 form-group">
                        <label for="">Payment Mode</label>
                        <select name="pay_mode" id="" class="form-control" readonly>
                            <option value="">Select...</option>
                            @foreach ($modes as $item)
                            <option value="{{ $item->title }}" {{ $invoice->pay_mode==$item->title? "selected":"" }}>{{ $item->title }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3 form-group">
                        <label for="">Payment Terms </label>
                        <select name="pay_terms" id="pay_terms" class="form-control" readonly>
                            <option value="">Select...</option>

                            @foreach ($terms as $item)
                            <option value="{{ $item->value }}" {{ $invoice->pay_terms==$item->value? "selected":"" }}>{{ $item->title }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3 form-group">
                        <label for="">Due Date</label>
                        <input type="date" value="{{ $invoice->due_date }}" class="form-control" name="due_date" id="due_date" readonly>
                    </div>

                    <div class="col-sm-3 form-group">
                        <label for="">Contact Number</label>
                        <input type="text" value="{{ $invoice->contact_no }}" class="form-control" name="contact_no" id="contact_no" readonly>
                    </div>

                    <div class="col-sm-3 form-group">
                        <label for="">Shipping Address</label>
                        <input type="text" value="{{ $invoice->address }}" class="form-control" name="address" id="address" readonly>
                    </div>
                    <div class="col-sm-4 form-group hide-entry ">
                        <div class="form-group ">
                            <input type="checkbox" class="checkbox-record" name="vat_include" id="vat_include" value="1" {{ $invoice->include_vat?'checked':'' }} disabled>
                            <label for=""> Include Vat</label>
                        </div>
                    </div>

                    <div class="col-sm-3 form-group">
                        <label for="">Style ID</label>
                        <input type="Style_ID" value="" class="form-control" name="style_id" id="style_id" readonly>
                    </div>

                    <div class="col-sm-3 form-group">
                        <label for="">Item_Name</label>
                        <input type="text" value="" class="form-control" name="item_name" id="item_name" readonly>
                    </div>

                    <div class="col-sm-2 form-group">
                        <label for="">QTY</label>
                        <input type="QTY" value="" class="form-control" max="" name="qty" id="qty">
                        <input type="hidden" value="" class="form-control" name="sqty" id="sqty">

                    </div>
                    <div class="col-sm-2 form-group">
                        <label for="">Unit</label>
                        <input type="Unit" value="" class="form-control" name="unit" id="unit" readonly>
                    </div>
                    <div class="col-sm-2 form-group">
                        <label for="">Vat</label>
                        <input type="text" value="" class="form-control" name="vat" id="vat" readonly>
                        <input type="hidden" value="" class="form-control" name="item_id" id="item_id" readonly>
                        <input type="hidden" value="" class="form-control" name="vat_rate" id="vat_rate" readonly>

                    </div>
                    <div class="col-sm-2 form-group">
                        <label for="">Unit_Price</label>
                        <input type="Unit_Price" value="" class="form-control" name="unit_price" id="unit_price" readonly>
                        <input type="hidden" value="" class="form-control" name="barcode" id="barcode" readonly>

                    </div>

                    <div class="col-sm-2 form-group">
                        <label for="">Total Price</label>
                        <input type="Total_Price" readonly value="" class="form-control" name="total_price" id="total_price">
                    </div>
                    <div class="col-sm-3 d-flex pt-1">
                        <a disabled class="btn btn-success btn-sm p-1 m-0 addonly-btn" id="item-return-add"><i class="bx bx-plus"></i></a>
                        <a class="btn btn-warning btn-sm ml-1 p-1 m-0" id="refresh"><i class="bx bx-refresh"></i></a>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row" style=" margin-top: 29px;">
                            <button type="submit" disabled class="btn btn-sm final-save-btn only-save-btn  btn-primary " style=" margin-right: 10px;" id="final_save"> Save</button>
                            <a class="btn btn-sm btn-warning" onClick="refreshPage()">Refresh</a>
                        </div>
                    </div>
                </div>
                <table class="table table-sm table-bordered return-item">
                </table>
            </div>
        </div>
    </div>
    <div class="table-responsive">

        <hr>
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Style ID</th>
                    <th>Item Name</th>
                    @if(!$invoice->include_vat)
                    <th>CTN</th>
                    @endif
                    <th>QTY</th>
                    <th>Unit</th>
                    <th>Unit Price</th>
                    <th>Vat rate</th>

                    <th>Vat Amount</th>
                    <th>Discount</th>
                    <th>Total Price </th>
                    <th>Action </th>
                </tr>
            </thead>
            <tbody class="all-data-area">
                @foreach (App\InvoiceItem::where('invoice_id',$invoice->id)->get() as $item)
                <tr class="data-row">
                    <td>{{ ++$i }}</td>
                    <td>{{ $item->item->style_name }}</td>
                    <td>{{$item->item->item_name }}</td>
                    @if(!$invoice->include_vat)
                    <td>{{ $item->ctn }}</td>
                    @endif

                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->unit }}</td>
                    <td>{{ $item->unit_price }}</td>
                    <td>{{ $item->vat_rate }}</td>

                    <td>{{number_format((float)( $item->vat_amount),'2','.','')}}</td>
                    <td></td>
                    <td>{{number_format((float)( $item->cost_price),'2','.','') }}</td>
                    <td> <a class="btn btn-sm btn-warning image-edite" data-style_name="{{$item->item->style_name}}" data-item_name="{{$item->item->item_name}}" data-quantity="{{$item->quantity }}" data-squantity="{{$item->quantity }}" data-vat_rate="{{$item->vat_rate }}" data-unit="{{$item->unit}}" data-unit_price="{{$item->unit_price}}" data-vat_amount="{{number_format((float)( $item->vat_amount),'2','.','')}}" data-cost_price="{{number_format((float)( $item->cost_price),'2','.','') }}" data-barcode="{{$item->item->barcode }}" data-item_id="{{$item->item_id }}">Return</a></td>

                </tr>
                @endforeach

               
            </tbody>
        </table>
    </div>
</div>
