<section class="print-hideen border-bottom" style="padding: 10px;">
    <div class="row">
        <div class="col-6">
            <h5 style="font-family:Cambria;font-size: 2.3rem;margin-left: 55px;"><b>Documents of {{ $employee->first_name.' '.$employee->last_name }}</b></h5>
        </div>
        <div class="col-6">
            <div class="d-flex flex-row-reverse">

                <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger mIconStyleChange212" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                {{-- <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
                <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
                <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
            </div>
        </div>
    </div>
</section>

<div class="modal-body">
    <div class="card-body" >
        <div class="content-body p-1">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <!-- <h4 class="mt-2">Employee Documents of {{ $employee->first_name.' '.$employee->last_name }}</h4> -->
                        <p>Status : Onrole</p>
                        <br>
                        <table class="table table-sm table-bordered m-0">
                            <tr style="color:#F2F4F4 ;background-color: #34465b;">
                                <th class="text-center">Document Type</th>
                                <th class="text-center">Document</th>
                                <th class="text-center">Action</th>
                            </tr>
                            {{-- <tr class="text-center">

                                <td>Employee Profile</td>
                                <td>
                                    <a href="{{ asset('storage/upload/employee/'.$employee->emirates_image)}}" target="_blank">
                                        <img src="{{ asset('storage/upload/employee/'.$employee->emirates_image)}}" style="height:60px" title="Emirates Image" class="img-fluid" alt="fsdafasdf" >
                                    </a>
                                    <a href="{{ asset('storage/upload/employee/'.$employee->passport_image)}}" target="_blank">
                                        <img src="{{ asset('storage/upload/employee/'.$employee->passport_image)}}" style="height:60px" title="Passport Image" class="img-fluid" alt="" >
                                    </a>
                                    <a href="{{ asset('storage/upload/employee/'.$employee->quali_image)}}" target="_blank">
                                        <img src="{{ asset('storage/upload/employee/'.$employee->quali_image)}}" style="height:60px" title="Certificate Image" class="img-fluid" alt="" >
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-secondary emp-document" data-id="{{route('employee-document-edit', $employee->id)}}"  id="">Edit</a>
                                    </div>
                                </td>
                            </tr> --}}
                            {{-- {{$professional_document}} --}}
                            @if (count($professional_document)>0)
                                <tr>
                                    <td>Profesional Certificate </td>
                                    <td>
                                        @foreach ($professional_document as $item)
                                            <a href="{{ asset('storage/upload/employee/post_quali/'.$item->image)}}" target="_blank">
                                                <img src="{{ asset('storage/upload/employee/post_quali/'.$item->image)}}" style="height:60px" title="{{$item->name}}" class="img-fluid" alt="" >
                                            </a>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="btn-group float-right">
                                            <a class="btn btn-secondary pro-document" data-id="{{route('professional-document-edit', $employee->id)}}"  id="">Edit</a>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            @if (count($histories)>0)
                                <tr>
                                    <td>History </td>
                                    <td>
                                        @foreach ($histories as $item)
                                            <a href="{{ asset('storage/upload/employee_history/'.$item->document)}}" target="_blank">
                                                <img src="{{ asset('storage/upload/employee_history/'.$item->document)}}" style="height:60px" title="{{$item->history}}" class="img-fluid" alt="" >
                                            </a>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="btn-group float-right">
                                            <a class="btn btn-secondary history-document" data-id="{{route('history-document-edit', $employee->id)}}"  id="">Edit</a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
