<div class="modal-header" style="height: 50px">
    <div class="row">
        <div class="col-md-4">
            <h5 class="modal-title" id="">EMPLOYEE EDIT</h5>
        </div>
        <div class="col-md-8 text-right">
            <button type="botton" style="margin-top: -12px;" class="btn btn-sm " data-dismiss="modal">
                <span aria-hidden="true" class="icon-style">&times;</span></button>
        </div>
    </div>
</div>

<div class="modal-body">
    <div class="card-body" >
        <div class="content-body p-1">
            <form class="form form-vertical" action="{{route('history-document-update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <table class="table mb-0 table-sm table-hover" >
                    <thead  class="thead-light">
                        <tr style="height: 50px;">
                            <th> <input type="checkbox" id="vehicle1" class="btn-select-all"  name="vehicle1" value="Bike">
                                <label for="vehicle1">Check All</label>
                                </th>
                            <th >Head</th>
                            {{-- <th>Type</th> --}}
                            <th class="text-center">Document</th>
                            <th class="text-center">Image</th>
                        </tr>
                    </thead>
                    @php
                        $l_count=0;
                    @endphp
                    <tbody class="table-sm">
                        @php
                            $i=0;

                        @endphp
                        @foreach ($documents as $component)
                        @php
                            ++$i;
                        @endphp
                        <tr class="trFontSize">
                            <td><input type="checkbox" id="" class="checkbox-record check" name="records[{{ $i }}][head]"  value="{{$component->id}}"></td>

                            <td>{{$component->history}}</td>
                            <td><input type="file" name="records[{{ $i }}][file]" class="form-control check-dep2" id=""></td>
                            <td>
                                <a href="{{ asset('storage/upload/employee_history/'.$component->document)}}" target="_blank">
                                    <img src="{{ asset('storage/upload/employee_history/'.$component->document)}}" title="{{$component->history}}" style="height:60px" class="img-fluid" alt="" >
                                </a>  
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <p class="text-right"><button class="btn btn-info mt-1" type="submit">Proceed</button></p>

            </form>
        </div>
    </div>
</div>