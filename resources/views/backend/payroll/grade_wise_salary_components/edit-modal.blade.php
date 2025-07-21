<div class="modal-header" style="height: 50px">
    <div class="row">
        <h5 class="p-1" style="font-family:Cambria;">SALARY EDIT FOR GRADE <span style="font-weight:bold">"{{$grade->name}}"</span> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>

<div class="modal-body">
    <div class="card-body" >
        <div class="content-body p-1">
            <!-- table bordered -->
            <form class="form form-vertical" action="{{ route('grade-wise-salary-components.update',  $grade->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row d-flex justify-content-end">
                    <div class="col-md-3 pl-0">
                        Date
                        <input type="text" class="form-control datepicker" min="2020" name="date" autocomplete="off" placeholder="DD/MM/YY" id="" required style="width: 110px;">
                    </div>
                    <input type="hidden" class="form-control" name="grade_id" value="{{ $grade->id }}"  required>
                </div><br>
                @method('PUT')
                <table class="table mb-0 table-sm table-hover" >
                    <thead  class="thead-light">
                        <tr style="height: 50px;">
                            <th> <input type="checkbox" id="vehicle1" class="btn-select-all"  name="vehicle1" value="Bike">
                                <label for="vehicle1" style="color:white;">Check All</label>
                                </th>
                            <th >Head</th>
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
                        @foreach ($components as $component)
                        @php
                            ++$i;
                        @endphp
                        <tr class="trFontSize">
                            <td><input type="checkbox" id="" class="checkbox-record check" name="records[head][{{ $i }}]" {{ $grade->feeCheck($component->id)? 'checked':"" }}   value="{{$component->id}}"></td>

                            <td>{{$component->name}}</td>
                            <td class="d-none">
                                <select name="records[type][{{ $i }}]" id="" class="form-control check-dep " >
                                    <option value="">Select...</option>
                                    @foreach ($component_types as $component_type)
                                        <option value="{{$component_type->id}}" {{$component_type->id == 2?'selected':''}}>{{$component_type->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" name="records[amount][{{ $i }}]" value="{{ $grade->feeAmount($grade->id,$component->id) }}" class="form-control check-dep2" id=""></td>

                        </tr>
                        @endforeach


                    </tbody>
                </table>
                <p class="text-right"><button class="btn btn-info mt-1" type="submit">Proceed</button></p>

            </form>
        </div>
    </div>
</div>
