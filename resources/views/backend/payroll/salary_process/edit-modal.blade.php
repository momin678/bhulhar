

<div class="modal-header">
    <h5 class="modal-title" id="">SALARY EDIT FOR <span style="font-weight:bold">"{{$employee->first_name.' '.$employee->last_name}}"</span> </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <div class="card-body" >
        <div class="content-body p-1">
            <!-- table bordered -->
            <form class="form form-vertical" action="{{ route('salary-process.update',  $employee->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row d-flex justify-content-end">
                    {{-- <div class="col-md-3">
                        Year
                        <input type="text" class="form-control" min="2020" name="date" placeholder="DD/MM/YY" id="datepicker" required>
                    </div> --}}
                    {{-- <input type="hidden" class="form-control" min="2020" name="month" placeholder="DD/MM/YY" id="datepicker" required> --}}
                    <input type="hidden" class="form-control" name="employee_id" value="{{ $employee->id }}"  required>

                </div>
                <div class="row">
                    <div class="col-6">
                        <h5 class="text-center">ADDITION </h5><br>
                        <table class="table mb-0 table-sm table-hover" >
                            <thead  class="thead-light">
                                <tr style="height: 50px;">
                                    <th>Check</th>
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
                                // dd($employee->id);
                                    ++$i;
                                @endphp
                                <tr class="trFontSize">
                                    <td><input type="checkbox" id="" class="checkbox-record check" name="records[head][{{ $i }}]" {{ $component->check($employee->id)? 'checked':"" }}  value="{{$component->id}}"></td>
        
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
                                    <td><input type="number" name="records[amount][{{ $i }}]" {{$component->id==2?'readonly':''}} value="{{ $component->check($employee->id)?$component->check($employee->id):'' }}" class="form-control check-dep2" id=""></td>
        
                                </tr>
                                @endforeach
        
        
                            </tbody>
                        </table>
                    </div>
                    <div class="col-6">
                        <h5 class="text-center">DEDUCTION  </h5><br>
                        <table class="table mb-0 table-sm table-hover" >
                            <thead  class="thead-light">
                                <tr style="height: 50px;">
                                    <th>Check</th>
                                    <th>Description</th>
                                    {{-- <th>Type</th> --}}
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Deduct</th>
                                </tr>
                            </thead>
                            @php
                                $l_count=0;
                            @endphp
                            <tbody class="table-sm">
                                @php
                                    $i=0;
        
                                @endphp
        
                                @foreach ($deductions as $component)
                                @php
                                    ++$i;
                                @endphp
                                <tr class="trFontSize">
                                    <td><input type="checkbox" id="" class="checkbox-record check" name="deduct[head][{{ $i }}]" {{ $component->check($employee->id)? 'checked':"" }}  value="{{$component->id}}"></td>
        
                                    <td>{{$component->description}}</td>
                                    <td>{{$component->due}}</td>
                                    <td><input type="number" name="deduct[amount][{{ $i }}]" min="0" max="{{$component->due}}" value="{{ $component->check($employee->id)?$component->check($employee->id):$component->due }}" class="form-control check-dep2" id=""></td>
        
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                

                <p class="text-right"><button class="btn btn-info mt-1" type="submit">Proceed</button></p>

            </form>
        </div>
    </div>
</div>