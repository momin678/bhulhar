<section class="print-hideen border-bottom" style="padding: 10px;">
    <div class="row">
        <div class="col-6">
        <h5 style="font-family:Cambria;font-size: 2rem;margin-left: 55px;"><b>DOCUMENTS EDIT</b></h5>
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
            <form class="form form-vertical" action="{{route('employee-document-update', $documents->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <table class="table mb-0 table-sm table-hover" >
                    <thead  class="thead-light">
                        <tr style="height: 40px;">
                            <th> Document Name</th>
                            {{-- <th>Type</th> --}}
                            <th class="text-center">Document</th>
                            <th class="text-center">Image</th>
                        </tr>
                    </thead>
                    <tbody class="table-sm">
                        <tr class="trFontSize">
                            <td>Emirates Id</td>
                            <td><input type="file" name="emirates_image" class="form-control check-dep2" id=""></td>
                            <td>
                                <a href="{{ asset('storage/upload/employee/'.$documents->emirates_image)}}" target="_blank">
                                    <img src="{{ asset('storage/upload/employee/'.$documents->emirates_image)}}" title="{{$documents->name}}" style="height:60px" class="img-fluid" alt="" >
                                </a>  
                            </td>
                        </tr>
                        <tr class="trFontSize">
                            <td>Passport Image</td>
                            <td><input type="file" name="passport_image" class="form-control check-dep2" id=""></td>
                            <td>
                                <a href="{{ asset('storage/upload/employee/'.$documents->passport_image)}}" target="_blank">
                                    <img src="{{ asset('storage/upload/employee/'.$documents->passport_image)}}" title="{{$documents->name}}" style="height:60px" class="img-fluid" alt="" >
                                </a>  
                            </td>
                        </tr>

                        <tr class="trFontSize">
                            <td>Certificate</td>
                            <td><input type="file" name="quali_image" class="form-control check-dep2" id=""></td>
                            <td>
                                <a href="{{ asset('storage/upload/employee/'.$documents->quali_image)}}" target="_blank">
                                    <img src="{{ asset('storage/upload/employee/'.$documents->quali_image)}}" title="{{$documents->name}}" style="height:60px" class="img-fluid" alt="" >
                                </a>  
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="text-right"><button class="btn btn-info mt-1" type="submit">Proceed</button></p>

            </form>
        </div>
    </div>
</div>