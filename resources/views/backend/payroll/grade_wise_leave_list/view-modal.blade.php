<div class="modal-header" style="height: 50px">
    <div class="row">
        <div class="col-md-4">
            <h5 class="modal-title" id="">EMPLOYEE HISTORY SHOW</h5>
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
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <h4 class="mt-2">Employee History of {{$employee->name}}</h4>
                        <p>Status : Onrole</p>
                        <br>
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center">Date</th>
                                <th class="text-center">History</th>
                                <th class="text-center">Remark</th>
                                <th class="text-center">Approved By</th>
                                <th class="text-center">Document</th>
                            </tr>
                            @foreach ($histories as $item)
                                <tr>
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
                                </tr>
        
                            @endforeach
        
        
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
