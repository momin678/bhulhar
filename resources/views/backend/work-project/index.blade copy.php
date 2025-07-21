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
                            <div class="col-7 d-flex justify-content-between">
                                <div class="d-flex">
                                    <a href="{{ route('lpo-projects.create') }}" class="project-btn sub-btn"> New Project  </a>

                                    <form action="{{ route('lpo-projects.index') }}" method="get" class="ml-1">
                                        <input type="hidden" value="new" name="quotation">
                                        <button type="submit" class="project-btn sub-btn bg-dark {{ $active_btn == 'new' ? 'active' : '' }}">Quotation  </button>
                                    </form>

                                    <form action="{{ route('lpo-projects.index') }}" method="get" class="ml-1">
                                        <input type="hidden" value="old" name="quotation">
                                        <button type="submit" class="project-btn sub-btn bg-dark  {{ $active_btn == 'old' ? 'active' : '' }}"> Quatation <small>(WO)</small>   </button>
                                    </form>
                                </div>

                            </div>
                            <div class="col-5 d-flex justify-content-end" >
                                <form action="{{ route('lpo-projects.index') }}" method="get">
                                    <div class="form-group d-flex">
                                        <input type="text" value="{{ $search}}" name="search" class="form-control search w-100" placeholder="Search Project">
                                        <!-- <button type="submit" class="project-btn action-btn bg-info"> <img src="{{ asset('assets/backend/app-assets/icon/searching-icon.png') }}" width="25"> Search   </button> -->

                                        <button type="submit" class="project-btn action-btn bg-info" title="Search" style="background: #9ba19c;color: white;">
                                            <div class="d-flex">
                                                <div class="formSaveIcon">
                                                    <img src="{{ asset('assets/backend/app-assets/icon/searching-icon.png') }}" width="25">
                                                </div>
                                                <div><span>Search</span></div>
                                            </div>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="data-table table-responsive mt-2">
                            <table class="table table-sm">
                                <thead style="background-color:#34465b !important;">
                                    <tr class="text-center">
                                        <th style="color:#fff;"> Quotation No  </th>
                                        <th style="color:#fff;"> Project </th>
                                        <th style="color:#fff;"> Customer </th>
                                        <th style="50%;color:#fff;"> Description </th>
                                        <th style="width:10%;color:#fff;" class="text-center"> total ({{$currency->symbole}}) </th>
                                        <th style="min-width: 120px;color:#fff;" class="text-center"> Start Date </th>
                                        <th style="min-width: 120px;color:#fff;" class="text-center"> End Date </th>
                                        <th style="width:10%;color:#fff;" class="text-center"> Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projects as $project)
                                        <tr class="text-center">
                                            <td style="min-width: 110px;"> {{ $project->project_code }} </td>
                                            <td style="min-width: 150px"> {{ $project->project_name }} </td>
                                            <td> {{ $project->party->pi_name }} </td>
                                            <td style="40%"> {{ Illuminate\Support\Str::limit($project->project_description,40) }}</td>
                                            <td style="width:10%;" class="text-center"> {{ $project->total_budget}}</td>
                                            <td class="text-center">{{$project->start_date ? date('d/m/Y',strtotime($project->start_date)) : '...' }}</td>
                                            <td class="text-center">{{$project->end_date ? date('d/m/Y',strtotime($project->end_date)) : '...' }}</td>
                                            <td style="width:10%;" class="">
                                                <div class="d-flex justify-content-center">
                                                    <button class="project-btn btn-primary view-project" data-id="{{ $project->id }}" data-url="{{ route('lpo-projects.show',$project->id) }}" title="View"><i class="fa fa-eye"></i></button>
                                                    <a href="{{ route('lpo-projects.edit',$project->id) }}" class="ml-1 project-btn btn-dark-blue edit-project" style="margin-left: 0.2rem !important;" title="Edit"><i class="fa fa-edit"></i></a>
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

<!-- Modal -->
<div class="modal fade" id="project-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header print-hideen" style="padding: 5px 15px;background:#364a60;">
          <h5 class="modal-title" id="exampleModalLabel" style="font-family:Cambria;font-size: 2rem;color:#fff;padding-left: 12px;"> View Quotation </h5>
          <div class="d-flex align-items-center">
                <button type="button" class="print-page project-btn bg-success" title="Print" style="margin-right: 0.2rem !important;">
                    <span aria-hidden="true">  <i class="bx bx-printer text-white" style="padding-top:4px;"></i> </span>
                </button>
                <a href="" class="project-btn bg-info work-station-create"  title="Genarate Work Order" style="margin-right: 0.2rem !important;">
                   <img src="{{asset('icon/generate.png')}}" class="img-fluid" style="height: 25px" alt="">
                </a>
                <button type="button" class="project-btn bg-danger text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
          </div>
        </div>
        <div class="modal-body" style="padding: 5px 15px;">

        </div>
      </div>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).on('click','.view-project',function(e){
    e.preventDefault();
    let project_id = $(this).attr('data-id');
    let url = $(this).attr('data-url');
    let work_station_url = "{{ route('work.station.create',":id") }}";
    work_station_url = work_station_url.replace(':id',project_id);
    $('.work-station-create').attr('href',work_station_url);

    $.get(url,function(res){
        $('.modal-body').html(res);
        $('.modal-title').html('View Quotation');
        $('#project-modal').modal('show');
    })
});

$(document).on('click','.print-page',function(){
    window.print();
})
</script>

@endpush
