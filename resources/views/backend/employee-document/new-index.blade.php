@extends('layouts.backend.app')
@section('content')
@include('backend.tab-file.style')
<style>
    .table td{
        border-bottom: none;
    }
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
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
                <a href="{{ route('new-employee-section') }}" class="nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div> Employee Profile </div>
                </a>
                <a href="{{route('new-employee-attendance')}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="parentProfileTab">
                    <div class="text-dark"> Employees Attendance </div>
                </a>
                <a href="{{route("new-salary-structure")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div> PayRoll </div>
                </a>
                <a href="{{route("new-management-team")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div> ManageMent Team </div>
                </a>
                <a href="{{route("new-eChartOf-account")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div> Expense HEad </div>
                </a>
                <a href="{{route("new-supllier")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div> Supllier </div>
                </a>
                <a href="{{route("new-donar")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div> Donar </div>
                </a>
                <a href="{{route("new-mapping")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div> File </div>
                </a>
            </div>
            <div class="tab-content bg-white px-4 py-2 active">
                <div class="tab-pane active">
                    <div class="d-flex align-items-center justify-content-between" id="nav-tab" role="tablist">
                        <div class="d-flex align-items-center gap-2 " style="border-bottom: 1px solid #ddd">
                            <a href="{{route("new-employee-section")}}" class="text-white text-dark nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false">
                                <div>Employee Profile</div>
                            </a>
                            <a href="{{route("new-employee-document")}}" class="bg-secondary text-white nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                                <div>Employee Document</div>
                            </a>
                        </div>
                        <div class="d-flex align-items-center gap-2 " style="border-bottom: 1px solid #ddd">
                            <button type="button" class="btn btn-primary btn_create formButton mr-1" title="Add" data-toggle="modal" data-target="#employeeDocumentAdd">
                                <div class="d-flex">
                                    <i class="bx bx-plus-circle" style="font-size: 20px;padding-bottom:6px;"></i>
                                </div>
                            </button>
                        </div>
                    </div>
                    <div class="tab-content bg-white">
                        <div class="tab-pane active">
                            <div class="content-body">
                                <section id="basic-vertical-layouts">
                                    <div class="row match-height">
                                        <div class="col-md-12 col-12">
                                                <div class="card-body">
                                                    <form class="form form-vertical">
                                                        <div class="form-body">
                                                            <div class="form-group">
                                                                <label for="employee_id">Employee</label>
                                                                <select id="employee_id" class="inputFieldHeight form-control common-select2 @error('employee_id') error @enderror" name="employee_id" required>
                                                                    <option value=""> Select Employee</option>
                                                                    @foreach ($employees as $each_employee)
                                                                    <option value="{{$each_employee->id}}"
                                                                        {{isset($inputs) && $inputs['employee_id'] == $each_employee->id ? 'selected' : ''}}
                                                                        > {{$each_employee->fname.' '.$each_employee->mname.' '.$each_employee->family_name}}</option>
                                                                    @endforeach

                                                                </select>
                                                                @error('employee_id')
                                                                <span class="error">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <button type="submit" class="btn btn-primary formButton mSearchingBotton" title="Searching">
                                                                <div class="d-flex">
                                                                    <div class="formSaveIcon">
                                                                        <img src="{{asset('assets/backend/app-assets/icon/searching-icon.png')}}" alt="" srcset="" width="20">
                                                                    </div>
                                                                    <div><span> Search</span></div>
                                                                </div>
                                                            </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </section>
                                <!-- Basic Vertical form layout section end -->

                                <!-- Bordered table start -->
                                @isset($documents)
                                    <div class="cardStyleChange">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <h4>Employee Documents</h4>
                                                <table class="table mb-0 table-sm table-hover">
                                                    <thead  class="thead-light">
                                                        <tr style="height: 50px;">
                                                            <th>Name</th>
                                                            <th>Download</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($documents as $document)
                                                        <tr class="trFontSize">
                                                            <td>{{ $document->name }}</td>
                                                            <td><a href="{{ asset('storage/upload/documents/'.$document->filename)}}" target="_blank">{{ $document->filename }}</a></td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- modal --}}
    <div class="modal fade bd-example-modal-lg" id="employeeDocumentAdd" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <section class="print-hideen border-bottom">
                <div class="d-flex flex-row-reverse">
                    <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                    {{-- <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-success"><i class="bx bx-edit"></i></a></div>
                    <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
                    <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
                    <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
                </div>
            </section>
            <div class="content-body">
                <form class="form form-vertical" action="{{ route('employee-documents.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <section id="basic-vertical-layouts">
                        <div class="row match-height">
                            <div class="col-md-12 col-12">
                                <div class="cardStyleChange">
                                    <div class="card-body">
                                        <div class="form-body">
                                            <h4>Add Additional Documents</h4>
                                            <div class="row">
                                                <div class="col-md-6 col-12 commonSelect2Style">
                                                    <label for="employee_name">Employee Name</label>
                                                    <select id="employee_name" class="form-control inputFieldHeight common-select2 @error('employee_name') error @enderror" name="employee_name" required>
                                                        <option value=""> Select Employee</option>
                                                        @foreach ($employees as $each_employee)
                                                        <option value="{{$each_employee->id}}"> {{$each_employee->fname.' '.$each_employee->mname.' '.$each_employee->family_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('employee_name')
                                                    <span class="error">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="files">Files</label>
                                                        <input type="file" id="files" class="form-control inputFieldHeight @error('files') error @enderror" name="files[]" multiple required>
                                                        @error('numofdays')
                                                        <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                    <label>Equivalence Upload</label>
                                                    <input type="file" name="equivalence" class="inputFieldHeight form-control @error('equivalence') error @enderror">
                                                    @error('equivalence')
                                                    <span class="error">{{ $message }}</span>
                                                    @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                    <label>Certificate Upload</label>
                                                    <input type="file" name="certificate" class="inputFieldHeight form-control @error('certificate') error @enderror">
                                                    @error('certificate')
                                                    <span class="error">{{ $message }}</span>
                                                    @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                    <label>MOE Approvals Upload</label>
                                                    <input type="file" name="moe_approval" class="inputFieldHeight form-control @error('moe_approval') error @enderror">
                                                    @error('moe_approval')
                                                    <span class="error">{{ $message }}</span>
                                                    @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-12 d-flex justify-content-end" >
                                                    <button type="submit" class="btn btn-primary formButton mSearchingBotton" title="Searching">
                                                        <div class="d-flex">
                                                            <div class="formSaveIcon">
                                                                <img src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" width="20">
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
            </div>
            @include('backend.tab-file.modal-footer-info')
          </div>
        </div>
    </div>
@endsection
@push('js')
<script>

</script>
@endpush
