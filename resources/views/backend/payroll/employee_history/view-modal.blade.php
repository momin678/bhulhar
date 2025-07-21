
<div class="modal-body">
    <div class="card-body" style="padding: 0px" >
        <div class="content-body ">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <p>Status : Onrole</p>
                        <br>
                        <table class="table table-sm table-bordered">
                            <tr style="color:#F2F4F4 ;background-color: #34465b;">
                                <th class="text-center">Date</th>
                                <th class="text-center">History</th>
                                <th class="text-center">Remark</th>
                                <th class="text-center">Approved By</th>
                                <th class="text-center">Document</th>
                                <th class="text-center">Action</th>
                            </tr>
                            @foreach ($histories as $item)
                                <tr class="text-center">
                                    {{-- <td>{{ ++$i }}</td> --}}
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->history }}</td>
                                    <td>{{ $item->remark }}</td>
                                    <td>{{ $item->approved_by }}</td>
                                    <td>
                                            @if ($item->extension == 'pdf')
                                                <a href="{{ asset('storage/upload/employee_history/'.$item->document)}}"  target="_blank">

                                                    <img src="{{ asset('assets/backend/app-assets/icon/pdf-download-icon-2.png')}}" style="height:60px" class="img-fluid" alt="" >
                                                </a>
                                            @else
                                                <a href="{{ asset('storage/upload/employee_history/'.$item->document)}}" target="_blank">
                                                    <img src="{{ asset('storage/upload/employee_history/'.$item->document)}}" style="height:60px" class="img-fluid" alt="" >
                                                </a>
                                            @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a class="btn btn-secondary history-edit mt-0" style="padding: 5px" data-id="{{route('employee-history.edit', $item->id)}}"  id="">Edit</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
