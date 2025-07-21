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
                <a href="{{route("nationality.index")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
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
                <a href="{{route('grade-wise-leave-list.index')}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/leave-list.png')}}" class="img-fluid" width="70">
                    </div>
                    <div>Leave List</div>
                </a>
                {{-- <a href="{{route('department')}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/exam-attendance-icon.png')}}" class="img-fluid" width="70">
                    </div>
                    <div>Department</div>
                </a> --}}
                {{-- <a href="{{route('new-exam-schedule')}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/exam-schedule-icon.png')}}" class="img-fluid" width="70">
                    </div>
                    <div>Exam Schedule</div>
                </a>
                <a href="{{route("new-student-mark")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
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
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
  
</script>
@endpush