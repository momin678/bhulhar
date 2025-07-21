@extends('layouts.backend.app')
@push('css')
@include('layouts.backend.partial.style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
<style>
    .project-btn{
        border: none;
        color: #fff;
        font-size: 15px;
        font-weight: 500px;
        padding:3px 10px;
        border-radius: 5px;
    }
    .btn-sky{
        background-color: #7DE5ED;
    }
    .btn-dark-blue{
        background-color: #5F6F94;
    }
    .btn-light-green,.btn-light-green:hover{
        background-color: #1F8A70;
        text-decoration: none;
        color: #fff;
    }
    .sub-btn{
        border:1px solid #475F7B !important;
        background-color: #fff !important;
        border-radius: 15px !important;
        color: #475F7B !important;
        padding: 3px 6px 3px 6px !important;
    },
    .action-btn{
        background-color: #5F6F94;
        height: 35px;
    }
    .sub-btn:hover,
    .sub-btn.active{
        background-color: #34465b  !important;
        color:white  !important;
    }
    .sub-btn.active:hover{
        background-color: #c8d6e357  !important;
        color:black  !important;
    }
    .form-control,
    .project-btn{
        height: 30px;
    }
    .date_type:focus,
    .date_type:active{
        border: border 1px solid #313131;
    }
    .table .thead-light th {
        color:#F2F4F4 ;
        background-color: #34465b;
        border-color: #DFE3E7;
    }
    tr:nth-child(even) {
        background-color: #c8d6e357;
    }
</style>
@endpush

@section('content')
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @include('clientReport.project._header')
            <div class="tab-content bg-white">
                <div id="journaCreation" class="tab-pane active">
                    <section class="p-1" id="widgets-Statistics">
                        <div class="row">
                            <div class="col-md-6">
                                <form>
                                    <input type="text" name="search" class="form-control input-xs inputFieldHeight" placeholder="Search By Project Name">
                                </form>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="button" class="btn btn-xs btn-primary btn_create formButton" title="Add" data-toggle="modal" data-target="#work_order_create" style="padding-top: 6px;padding-bottom: 6px;">
                                    <div class="d-flex">
                                        <div class="formSaveIcon">
                                            <img src="{{asset('storage/upload/icon/add-icon.png')}}" width="25">
                                        </div>
                                        <div><span>Add</span></div>
                                    </div>
                                </button>
                            </div>
                        </div>
                        <div class="data-table table-responsive mt-2">
                            <table class="table table-sm">
                                <thead style="background-color:#34465b !important;">
                                    <tr class="text-center">
                                        <th style="color:#fff; width: 15px;"> SL </th>
                                        <th style="color:#fff;"> Project Name </th>
                                        <th style="color:#fff;"> Customer </th>
                                        <th style="color:#fff;"> Consultant </th>
                                        <th style="color:#fff;"> Location </th>
                                        <th style="color:#fff;"> Total Amount ({{$currency->symbole}}) </th>
                                        <th style="color:#fff;"> Remark </th>
                                        <th style="color:#fff;"> Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projects as $key => $project)
                                        <tr class="text-center">
                                            <td> {{ $key+1 }} </td>
                                            <td> {{ $project->project_name }} </td>
                                            <td> {{ $project->party->pi_name }} </td>
                                            <td> {{ $project->consultant_name }} </td>
                                            <td> {{ $project->site_delivery }} </td>
                                            <td> {{ $project->total_budget}}</td>
                                            <td> {{ Illuminate\Support\Str::limit($project->project_description,40) }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <a href="#" id="{{$project->id}}" class="ml-1 project-btn btn-dark-blue edit-project" style="margin-left: 0.2rem !important;" title="Edit"><i class="fa fa-edit"></i></a>
                                                    <a href="#"
                                                        class="project-btn document_upload"
                                                        data-id="{{ $project->id }}"
                                                        data-url="{{ $project->project_name }}" title="Document" style="margin-left: 0.2rem !important;background-color:#0ead5e;" title="Document"><i class="fa fa-file-image" style="font-size:16px"></i>
                                                    </a>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {!! $projects->links() !!}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example" id="createModel" tabindex="-1" rrole="dialog"
aria-labelledby="myLargeModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header" style="padding: 5px 15px;background:#364a60;">
            <h5 class="modal-title" style="font-family:Cambria;font-size: 2rem;color:#fff;padding-left: 5px;"> Document Upload </h5>
            <div class="d-flex align-items-center">
                <button type="button" class="project-btn bg-danger text-white" data-dismiss="modal"
                    aria-label="Close" style="margin:0 5px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        </div>
        <div id="modal_content">

        </div>
    </div>
</div>
</div>
<!-- Modal -->

    <!-- Modal -->
    <div class="modal fade" id="project-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header print-hideen" style="padding: 5px 15px;background:#364a60;">
                    <h5 class="modal-title" id="exampleModalLabel" style="font-family:Cambria;font-size: 2rem;color:#fff;padding-left: 12px;"> View Project </h5>
                    <div class="d-flex align-items-center">
                        <a href="" class="project-btn bg-success print-job-project" target="_blank"  title="Print" style="margin-right: 0.2rem !important;">
                            <i class="bx bx-printer text-white" style="padding-top:4px;"></i>
                         </a>
                        <a href="" class="project-btn bg-info invoice-create" title="Genarate Invoice" style="margin-right: 0.2rem !important;">
                            <img src="{{asset('icon/generate.png')}}" class="img-fluid" style="height: 25px" alt="">
                        </a>
                        <button type="button" class="project-btn bg-danger text-white" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body" style="padding: 5px 15px;">

                </div>
            </div>
        </div>
    </div>
<div class="modal fade" id="work_order_create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-header" style="padding: 5px 15px;background:#364a60;">
              <h5 class="modal-title" id="exampleModalLabel" style="font-family:Cambria;font-size: 2rem;color:white;"> Project Details</h5>
              <div class="d-flex align-items-center">  
                  <button type="button" class="project-btn bg-danger text-white" data-dismiss="modal" aria-label="Close" style="padding: 3px 12px;" data-bs-toggle="tooltip" data-bs-placement="right" title="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          </div>
          <div class="modal-body" style="padding: 5px 5px;">
              <section id="widgets-Statistics" class="mr-1 ml-1 mb-1" data-select2-id="widgets-Statistics">
                  <div class="row" data-select2-id="16">
                      <div class="col-12" data-select2-id="15">
                            <form action="{{ route('work-project.store') }}" method="POST" enctype="multipart/form-data">
                              @csrf
                              <div class="cardStyleChange">
                                  <div class="row">
                                    <div class="col-md-3">
                                        <label for="">Project Name</label>
                                        <input type="text" class="form-control inputFieldHeight" name="project_name" required>
                                    </div>
                                    <div class="col-md-3 changeColStyle search-item-pi">
                                        <div class="row align-items-center">
                                            <div class="col-10 customer-select">
                                                <label for="">Owner Name</label>
                                                <select name="party_id" id="party_id"
                                                    class="common-select2 party-info customer"
                                                    style="width: 100% !important" data-target="" required>
                                                    <option value="">Select...</option>
                                                    @foreach ($pInfos as $item)
                                                        <option value="{{ $item->id }}" > {{ $item->pi_name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('party_id')
                                                    <div class="btn btn-sm btn-danger">{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-2 col-left-padding d-flex align-items-center mt-2">
                                                <a href="#" data-toggle="modal"
                                                    data-target="#customerModal"><img
                                                        src="{{ asset('assets/backend/app-assets/icon/add-icon.png') }}"
                                                        alt="" srcset="" class="img-fluid"
                                                        style="height:29px"></a>

                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Consaltant Name</label>
                                        <input type="text" class="form-control inputFieldHeight" name="consultant_name" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Location</label>
                                        <input type="text" class="form-control inputFieldHeight" name="site_delivery">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Remarks</label>
                                        <input type="text" class="form-control inputFieldHeight" name="project_description" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">Toal Amount</label>
                                        <input type="number" step="any" class="form-control inputFieldHeight" name="total_amount" required>
                                    </div>
                                    <div class="col-sm-2 form-group">
                                        <label for="">Voucher Scan/File</label>
                                        <input type="file" class="form-control inputFieldHeight"
                                            name="voucher_scan" accept="image/*">
                                    </div>
                                      <div class="col-md-2" style="margin-top: 36px;">
                                          <div class="d-flex justify-content-end">
                                              <button type="submit" class="btn mr-1 btn-primary formButton" title="Form Save">
                                                  <div class="d-flex">
                                                      <div class="formSaveIcon">
                                                          <img  src="{{asset('storage/upload/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                      </div>
                                                      <div><span> Save</span></div>
                                                  </div>
                                              </button>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                            </form>
                      </div>
                  </div>
              </section>
          </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="work_order_edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content" id="modal_content_eidt">
    </div>
  </div>
</div>
@endsection

@push('js')
<script>

$(document).on('click', '.edit-project', function(e) {
    e.preventDefault();
    let project_id = $(this).attr('id');
    var _token = $('input[name="_token"]').val();
    $.ajax({
        url: "{{ route('work-project-edit') }}",
        method: "POST",
        data: {
            project_id: project_id,
            _token: _token,
        },
        success: function(response) {
            $('#modal_content_eidt').html(response);
            $("#work_order_edit").modal('show');
            $('.common-select2').select2();
        }
    });
});
$(document).on('click', '.document_upload', function(e) {
    e.preventDefault();
    let project_id = $(this).attr('data-id');
    var _token = $('input[name="_token"]').val();
    $.ajax({
        url: "{{ route('document-upload-view') }}",
        method: "POST",
        data: {
            project_id: project_id,
            _token: _token,
        },
        success: function(response) {
            $('#modal_content').html(response);
            $("#createModel").modal('show');
        }
    });
});
$(document).on('click', '.delete_document', function(e) {
    var id = $(this).attr('id');
    var _token = $('input[name="_token"]').val();
    $.ajax({
        method: "post",
        url: "{{ route('delete-job-document') }}",
        data: {
            id: id,
            _token: _token,
        },
        success: function(response) {
            if (response == 1) {
                $('#tr' + id).remove();
                toastr.success("Document deleted", "Success");
            }
        }
    });
})
$(document).on('click','.print-page',function(){
    window.print();
})
</script>

@endpush
