@extends('layouts.backend.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
<style>
    .card {
        margin-bottom: 0.3rem !important;
        }
    h5 {

        line-height: 0.2 !important;
    }
</style>
@endpush
@section('content')
@include('layouts.backend.partial.style')


<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
                <a href="{{route("grade-wise-salary-components.index")}}" class="nav-item nav-link " role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/gradeeise-icon.png')}}" alt="" srcset="" class="img-fluid" width="55">
                    </div>
                    <div>Gradewise Salary Component</div>
                </a>
                <a href="{{route("salary-structures.index")}}" class="nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/component-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Salary Component</div>
                </a>
                <a href="{{route("grades.index")}}" class="nav-item nav-link " role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/grade-icon.jpg')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Grades</div>
                </a>
            </div>
            <div class="tab-content bg-white">
                <div id="parentProfileList" class="tab-pane active">
                    <div class="content-body">
                        <div class="row" id="table-bordered">
                            <div class="col-12">
                                <div class="cardStyleChange">
                                    <h4 class="ml-1 mt-2">Salary Component Edit</h4>
                                    <div class="card-body">
                                        <!-- table bordered -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <form action="{{route('salary-structures.update', $componemts_info->id)}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <input type="text" class="form-control inputFieldHeight search" name="head" value="{{$componemts_info->name}}" placeholder="Type new Head">
                                                    </div>
                                                
                                            </div>
                                            <div class="col-md-6 d-flex">
                                                <div class=" flex-grow-1"></div>
                                                <button type="submit" class="btn btn-primary formButton mb-1" title="Save" data-toggle="modal" data-target="#parentProfileAdd">
                                                    <div class="d-flex">
                                                        <div class="formSaveIcon">
                                                            <img src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" width="25">
                                                        </div>
                                                        <div><span>Update</span></div>
                                                    </div>
                                                </button>
                                            </div>
                                            </form>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover">
                                                <thead  class="thead-light">
                                                    <tr style="height: 50px;">
                                                        <th>Head</th>
                                                        <th class="text-right pr-3">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($components as $item)
                                                        <tr  class="data-row">
                                                            <td>{{$item->name}}</td>
                                                            <td style="padding-bottom: 11px; padding-top: 0px" class="text-right pr-2">
                                                                <a href="{{route('salary-structures.edit', $item->id)}}" class="btn" style="height: 30px; width: 30px;" title="Eidt">
                                                                    <img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;">
                                                                </a>
                                                                
                                                                <a href="" class="btn" style="height: 30px; width: 30px;" title="Delete">
                                                                    <form action="{{ route('salary-structures.destroy', $item->id) }}" method="POST" class="flot-right">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn" onclick="return confirm('Confirm?')" style="padding-top: 0px; padding-left:0px;">
                                                                            <img src="{{ asset('assets/backend/app-assets/icon/delete-icon.png')}}" style="height: 32px; width: 32px; margin-left: -12px;">
                                                                        </button>
                                                                    </form>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    {{-- <div class="ml-5">{{ $employees->links() }}</div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div id="printArea" class="d-none">
    </div>
</div>
    <!-- END: Content-->
@endsection

@push('js')
<script>
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN':'{{ csrf_token() }}'
        }
    });

    $(document).on("keyup", ".each-item", function(e) {
        var sum = 0;
        $('.each-item').each(function() {
        // parseInt($(this).attr('max'));
        if(this.value != '')
        {
            sum += parseFloat(this.value);
        }
        });
        // alert(sum);
        $("#total").val(sum);

    });
</script>
@endpush