
<section class="print-hideen border-bottom" style="padding: 5px 28px;background-color:#34465b">
    <div class="row">
        <div class="col-md-6">
            <h4 class="card-title"  style="font-family:Cambria;font-size: 2rem;color:#fff;">Add Documents</h4>
        </div>
        <div class="col-md-6">
            <div class="d-flex flex-row-reverse">
                <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
            </div>
        </div>
    </div>    
</section>

<form class="form form-vertical p-2" action="{{ route('pay-salary-document-upload')}}"  method="POST"  enctype="multipart/form-data">
    @csrf 
    <input type="hidden" name="pay_salary_id" value="{{$pay_salary->id}}">
    <section id="basic-vertical-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="cardStyleChange">
                    <div class="card-body">
                        <div class="form-body">

                            <div class="row">
                                <div class="col-md-5 col-12">
                                    <div class="form-group">
                                        <label for="files">Files</label>
                                        <input type="file" id="files" class="inputFieldHeight form-control @error('files') error @enderror" name="files" multiple required>
                                        @error('numofdays')
                                        <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary formButton mt-2 mb-2" title="Form Save">
                                        <div class="d-flex">
                                            <div class="formSaveIcon">
                                                <img src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                            </div>
                                            <div><span> Save</span></div>
                                        </div>
                                    </button>
                                </div>
                            </div>       
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>

<table class="table table-sm">
    <tbody>
        @foreach ($documents as $item)
            <tr id="{{'tr'.$item->id}}">
                <td>{{ $loop->index+1 }}</td>
                <td>{{ $item->name }}</td>
                <td><a href="{{ asset('storage/upload/pay-salary-document')}}/{{$item->fime_name}}" class="mr-1" target="blank">{{ $item->name }}</a> </td>
                <td>
                    <a href="{{ asset('storage/upload/pay-salary-document')}}/{{$item->fime_name}}" class="mr-1" target="blank">
                        @if ($item->extension == 'pdf')
                        <img src="{{asset('assets/backend/app-assets/icon/pdf-download-icon-2.png')}}" alt="" srcset="" class="img-fluid" width="25">
                        @else
                            <img src="{{ asset('storage/upload/pay-salary-document')}}/{{$item->fime_name}}" alt="" srcset="" height="30">
                        @endif
                    </a>
                </td>
                <td>
                    <a href="#" class="delete_document" id="{{$item->id}}" onclick="return confirm('Are you sure to delete this?')"> <i class="bx bx-trash"></i> </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
       
