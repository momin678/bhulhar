<div class="modal-header" style="padding: 5px 15px;background:#364a60;">
    <h5 class="modal-title" id="exampleModalLabel" style="font-family:Cambria;font-size: 2rem;color:white;">Expense Distribution Edit</h5>
    <div class="d-flex align-items-center">
        <button type="button" class="project-btn bg-danger text-white" data-dismiss="modal" aria-label="Close" style="padding: 3px 12px;" data-bs-toggle="tooltip" data-bs-placement="right" title="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{-- @include('alerts.alerts') --}}
    </div>
</div>
<div class="modal-body" style="padding: 5px 5px;">
    <section id="widgets-Statistics" class="mr-1 ml-1 mb-1">
        <div class="row pt-2">
            <div class="col-12 cost-center-form">
                <div class="row">
                    <div class="col-3">
                        <div class="form-body">
                            <div class=" form-group">
                                <label>Form Date</label>
                                <input type="text"  class="form-control inputFieldHeight datepicker" autocomplete="off" name="expense_from" id="expense_from__edit" value="" placeholder="DD/MM/YYYY"  >
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-body">
                            <div class=" form-group">
                                <label>To Date</label>
                                <input type="text" class="form-control inputFieldHeight datepicker" autocomplete="off" name="expense_to" id="expense_to__edit" value="" placeholder="DD/MM/YYYY"  >
                            </div>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-body">
                            <div class=" form-group">
                                <label>Type</label>
                                <select name="expense_type" id="expense_type__edit" class="form-control inputFieldHeight" required>
                                    <option value="Garage">Garage</option>
                                    <option value="Office">Office</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-1">
                        <div class="form-body">
                            <div class=" form-group">
                                <a  class="btn-info btn  mt-2 inputFieldHeight" id="search-expense-ammount_edit">Search</a>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{ route('expense-distribution.update', $distribute->id) }}" method="POST" id="distribution_form_edit">
                    @method('put')
                    @csrf
                    <div class="row match-height">
                        <div class="col-md-2">
                            <div class="form-body">
                                    <div class=" form-group">
                                        <label> Date</label>
                                        <input type="text" id="" class="form-control date inputFieldHeight datepicker" name="date" value="{{  date('d/m/Y', strtotime($distribute->date))}}" placeholder="DD/MM/YYYY" >
                                    </div>
                                </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-body">
                                <div class=" form-group">
                                    <label>Note</label>
                                    <input type="text" id="note" class="form-control note_edit inputFieldHeight" name="note" value="{{$distribute->note}}" placeholder="Note" required>
                                    @error('note')
                                        <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-body">
                                <div class=" form-group">
                                    <label>Form Date</label>
                                    <input type="text"  class="form-control expense_from_edit inputFieldHeight " readonly name="expense_from" id="expense_from_edit" value="{{date('d/m/Y', strtotime($distribute->expense_from)) }}" placeholder="DD/MM/YYYY"  >
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-body">
                                <div class=" form-group">
                                    <label>To Date</label>
                                    <input type="text" class="form-control expense_to_edit inputFieldHeight " readonly name="expense_to" id="expense_to_edit" value="{{ date('d/m/Y', strtotime($distribute->expense_to)) }}" placeholder="DD/MM/YYYY"  >
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-body">
                                <div class=" form-group">
                                    <label>Type</label>
                                    <input type="text" class="form-control expense_type_edit inputFieldHeight " readonly name="expense_type" id="expense_type_edit" value="{{ $distribute->expense_type}}" placeholder="Type"  >
                                </div>
                            </div>
                        </div>
                       <div class="col-md-2">
                            <div class="form-body">
                                <div class=" form-group">
                                    <label>Total</label>
                                    <input type="text" id="total_expense_edit" class="form-control inputFieldHeight" name="total_expense" value="{{$distribute->total_amount}}" placeholder="Total" readonly required>
                                    @error('total')
                                        <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                       </div>
                       <div class="col-md-12">
                        <div class="cardStyleChange table-responsive">
                            <table class="table mb-0 table-sm table-hover">
                                <thead  class="thead-light">
                                    <tr class="text-center" style="height: 20px;">
                                        <th style="padding-left: 18px;width:10%;">SI</th>
                                        <th style="width:20%;">Vehicle</th>
                                        <th style="width:20%;">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="user-table-body">
                                    <input type="hidden" value="{{$distribute->items->count()}}" id="total_vehicle_edit">
                                    @foreach ($distribute->items as $key=>$item)
                                    <tr class="text-center trFontSize" style="height: 20px;">
                                        <td style="padding-left: 18px;">{{ ++$key}}</td>
                                        <td>{{ $item->vehicle->vehicle_number }} <input type="hidden" value="{{$item->vehicle_id}}" name="vehicle_id[{{$item->vehicle_id}}]"></td>
                                        <td><input type="text"  class="form-control inputFieldHeight individual_vehicle_amount_edit" value="{{ $item->amount }}" name="v_amount[{{$item->vehicle_id}}]"  placeholder="Amount" ></td>
                                    </tr>
                                    @endforeach

                                    <tr>
                                        <td colspan="2" class="text-right">Total</td>
                                        <td><input type="number" step="any" value="{{$distribute->total_amount}}" name="individual_total" id="individual_total_edit" class="form-control individual_total_edit inputFieldHeight" required readonly></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                      </div>
                      <div class="col-12 d-flex justify-content-end ">
                        <button type="submit" class="btn btn-primary mr-1">Submit</button>
                        {{-- <button type="reset" class="btn btn-light-secondary">Reset</button> --}}
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

