<div class="modal-header" style="height: 50px">
    <div class="row">
        <h5 class="p-1" style="font-family:Cambria;">SALARY EDIT FOR <span style="font-weight:bold">"{{$employee->first_name.' '.$employee->last_name}}"</span> </h5>
    </div>
</div>

<div class="modal-body">
    <div class="card-body" >
        <div class="content-body p-1">
            <!-- table bordered -->
            <form class="form form-vertical" action="{{ route('employee-salary.update',  $employee->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row d-flex justify-content-end">
                    <div class="col-md-3 pl-0">
                        Date
                        <input type="text" class="form-control datepicker" min="2020" name="date" autocomplete="off" placeholder="DD/MM/YYYY" id="" required style="width: 110px;">
                    </div>
                    <input type="hidden" class="form-control" name="employee_id" value="{{ $employee->id }}"  required>

                </div><br>
                <table class="table mb-0 table-sm table-hover" >
                    <thead  class="thead-light">
                        <tr style="height: 50px;">
                            <th> <input type="checkbox" id="vehicle1" class="btn-select-all"  name="vehicle1" value="Bike">
                                <label for="vehicle1" style="color:white;">Check All</label>
                                </th>
                            <th>Head</th>
                            {{-- <th>Type</th> --}}
                            <th class="text-center">Amount</th>
                        </tr>
                    </thead>
                    @php
                        $l_count=0;
                    @endphp
                    <tbody class="table-sm">
                        @php
                            $i=0;

                        @endphp

                        {{-- {{dd($employee)}} --}}
                        @foreach ($components as $component)
                        @php
                            ++$i;
                        @endphp
                        <tr class="trFontSize">
                            <td><input type="checkbox" id="" class="checkbox-record check" name="records[head][{{ $i }}]" {{ $grade->feeCheck($component->id) || $grade->extraCheck($component->id,$employee->id) ? 'checked':"" }} {{ $grade->feeCheck($component->id)? 'disabled':"" }}   value="{{$grade->feeCheck($component->id)? '':$component->id}}"></td>

                            <td>{{$component->name}}</td>
                            <td class="d-none">
                                <select name="records[type][{{ $i }}]" id="" class="form-control check-dep " >
                                    <option value="">Select...</option>
                                    @foreach ($component_types as $component_type)
                                        <option value="{{$component_type->id}}" {{$component_type->id == 2?'selected':''}}>{{$component_type->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            {{-- <td><input type="number" name="records[amount][{{ $i }}]" value="{{ $grade->feeAmount($grade->id,$component->id) ? $grade->feeAmount($grade->id,$component->id):($employee->extraCom($component->id)? ($employee->extraCom($component->id)->value):'') }}" {{ $grade->feeCheck($component->id)? 'readonly':"" }} class="form-control check-dep2" id=""></td> --}}
                            <td><input type="number" name="records[amount][{{ $i }}]" value="{{ $grade->feeAmount($grade->id,$component->id) ? $grade->feeAmount($grade->id,$component->id):$grade->extraAmount($component->id,$employee->id) }}" {{ $grade->feeCheck($component->id)? 'readonly':"" }} class="form-control check-dep2" id=""></td>

                        </tr>
                        @endforeach


                    </tbody>
                </table>
                <p class="text-right"><button class="btn btn-info mt-1" type="submit">Proceed</button></p>
            </form>
        </div>
    </div>
</div>
