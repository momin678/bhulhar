<style>
    <style>
    .commonSelect2Style span{
        width: 100% !important;
    }
    .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b{
        display: none;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b{
        display: none;
    }
</style>
@extends('layouts.backend.app')
@section('content')
@include('layouts.backend.partial.style')

<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
                <a href="{{route("nationality.index")}}" class="nav-item nav-link " role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/nationality-icon.png')}}" class="img-fluid" width="80">
                    </div>
                    <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nationality &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                </a>
                <a href="{{route('department.index')}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/department-icon.png')}}" class="img-fluid" width="70">
                    </div>
                    <div>Department</div>
                </a>
                <a href="{{route('country-code.index')}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/country-code-icon.png')}}" class="img-fluid" width="70">
                    </div>
                    <div>Country Code</div>
                </a>
                <a href="{{route('branch.index')}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/branch-icon.png')}}" class="img-fluid" width="70">
                    </div>
                    <div>Branch</div>
                </a>
                <a href="{{route('grade-wise-leave-list.index')}}" class="nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/leave-list.png')}}" class="img-fluid" width="70">
                    </div>
                    <div>Leave List</div>
                </a>
                {{-- <a href="{{route("new-student-mark")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/exam-mark-icon.png')}}" class="img-fluid" width="60">
                    </div>
                    <div>&nbsp;&nbsp;&nbsp;&nbsp;Exam Marks&nbsp;&nbsp;&nbsp;&nbsp;</div>
                </a>
                <a href="{{route("new-teacher-exam-list")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/teacher-exam-icon.png')}}" class="img-fluid" width="70">
                    </div>
                    <div>Teacher Exam List</div>
                </a> --}}
            </div>
            <div class="tab-content bg-white">
                <div class="tab-pane active">
                    <div class="content-body">
                        <div class="row" id="table-bordered">
                            <div class="col-12">
                                <div class="cardStyleChange">
                                    <br>
                                    <div class="card-body">
                                        <form action="{{route('grade-wise-leave-list.update', $leave_info->id)}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="cardStyleChange">
                                                <div class="row px-1">
                                                    <div class="col-sm-3 col-12 changeColStyle emp-select">
                                                        <label for="mode">Grade <sup class="text-danger">*</sup></label>
                                                        <select name="grade_id" id="grade_id" class="form-control common-select2" style="width: 100% !important" required>
                                                            <option value="">Select grade</option>
                                                            @foreach ($grades as $grade)
                                                                <option value="{{$grade->id}}" {{ ($leave_info->grade_id == $grade->id)?'selected':'' }}>{{$grade->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 col-12 changeColStyle">
                                                        <label for="mode">Casual Leave<sup class="text-danger">*</sup></label>
                                                        <input type="number" class="form-control inputFieldHeight" name="casual_leave" value="{{ $leave_info->casual_leave }}" id="casual_leave" required>
                                                    </div>
                                                    <div class="col-sm-3 col-12 changeColStyle">
                                                        <label for="mode">Sick Leave<sup class="text-danger">*</sup></label>
                                                        <input type="number" class="form-control inputFieldHeight" name="sick_leave" value="{{ $leave_info->sick_leave }}" id="sick_leave" required>
                                                    </div>
                                                    <div class="col-sm-3 col-12 changeColStyle">
                                                        <label for="mode">Anual Leave<sup class="text-danger">*</sup></label>
                                                        <input type="number" class="form-control inputFieldHeight" name="anual_leave" value="{{ $leave_info->anual_leave }}" id="anual_leave" required>
                                                    </div>
                                                    <div class="col-12 col-md-12 d-flex justify-content-end changeColStyle mb-1 mt-1">
                                                        <button type="submit" class="btn mr-1 btn-primary formButton" title="Form Save">
                                                            <div class="d-flex">
                                                                <div class="formSaveIcon">
                                                                    <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                                </div>
                                                                <div><span> Save</span></div>
                                                            </div>
                                                        </button>
                                                        <button type="reset" class="btn btn-light-secondary formButton" title="Form Reset">
                                                            <div class="d-flex">
                                                                <div class="formRefreshIcon">
                                                                    <img  src="{{asset('assets/backend/app-assets/icon/refresh-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                                </div>
                                                                <div><span> Reset</span></div>
                                                            </div>
                                                        </button>
            
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-body">
                                        <!-- table bordered -->
                                        <div class="table-responsive">
                                            <table class="table mb-0 table-sm table-hover">
                                                <thead  class="thead-light">
                                                    <tr style="height: 50px;">
                                                        <th>#</th>
                                                        <th>Greade</th>
                                                        <th>Casual</th>
                                                        <th>Sick</th>
                                                        <th>Anual</th>
                                                        <th class="text-right pr-1">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($liveList as $item)
                                                    <tr class="trFontSize">
                                                        <td>{{ $item->id }} </td>
                                                        <td>{{ $item->grades->name }} </td>
                                                        <td>{{ $item->casual_leave }} </td>
                                                        <td>{{ $item->sick_leave }} </td>
                                                        <td>{{ $item->anual_leave }} </td>
                                                        <td class="text-right pr-2">
                                                            <a href="{{route('grade-wise-leave-list.edit', $item->id)}}" class="btn editExamModal" title="Edit" id="" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;"><img src="{{asset("assets/backend/app-assets/icon/edit-icon.png")}}" style=" height: 30px; width: 30px;"></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
  
</script>
@endpush