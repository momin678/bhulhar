
@extends('layouts.backend.app')
@section('content')
@include('backend.tab-file.style')

<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
                <a href="{{route("students-attendance")}}" class="nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/student-icon.png')}}" alt="" srcset="" class="img-fluid" width="55">
                    </div>
                    <div>Students Attendance</div>
                </a>
                <a href="{{route("new-student-leave")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/document-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Students Leave&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                </a>
                <!-- <a href="{{route('new-employee-attendance')}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="parentProfileTab">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/employee-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Employees Attendance</div>
                </a>
                <a href="{{route("new-employee-leave")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/leave-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Employees Leave&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                </a> -->
            </div>
            <div class="tab-content bg-white">
                <div id="studentProfileList" class="tab-pane active">
                    <div class="content-body">
                        <form class="form form-vertical" enctype="multipart/form-data">
                            <section id="basic-vertical-layouts">
                                <div class="row match-height">
                                    <div class="col-md-12 col-12">
                                        <div class="cardStyleChange">
                                            <div class="d-flex card-header">
                                                <h4 class="flex-grow-1">Search Students Attendance</h4>
                                                <button type="button" class="btn btn-primary btn_create formButton" title="Add" data-toggle="modal" data-target="#newStudentAttendance">
                                                    <div class="d-flex">
                                                        <div class="formSaveIcon">
                                                            <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" width="25">
                                                        </div>
                                                        <div><span>Take Attendance</span></div>
                                                    </div>
                                                </button>
                                            </div>
                                            <div class="card-body">
                                                    <div class="form-body">
                                                        <div class="row">
            
                                                            <div class="col-md-4 col-12">
                                                                <div class="form-group">
                                                                    <label for="date">Date</label>
                                                                    <input type="date" id="date" class="inputFieldHeight form-control @error('date') error @enderror" name="date" value="{{ isset($inputs) ? $inputs['date'] : old('date')}}" required>
                                                                    @error('date')
                                                                    <span class="error">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
            
                                                            <div class="col-md-4 col-12">
                                                                <div class="form-group">
                                                                    <label for="st-class">Class</label>
                                                                    <select id="st-class" class="inputFieldHeight form-control @error('class_name') error @enderror" name="class_name" required>
                                                                        <option>Select Class</option> 
                                                                        @foreach ($st_classes as $class_item)
                                                                        <option value="{{ $class_item->id}}" {{ isset($inputs) ? ($inputs['class_name'] == $class_item->id ? 'selected': '' ) : '' }}>{{ $class_item->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('class_name')
                                                                    <span class="error">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-12">
                                                                <div class="form-group">
                                                                    <label for="st-section">Section</label>
                                                                    <select id="st-section" class="inputFieldHeight form-control @error('section') error @enderror" name="section" required>
                                                                        
                                                                        @isset($inputs)
                                                                            <option value="{{ $inputs['section']->id}}">{{ $inputs['section']->name}}</option>
                                                                        @else
                                                                            <option>Select Section</option>
                                                                        @endisset
                                                                    </select>
                                                                    @error('section')
                                                                    <span class="error">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-12 d-flex justify-content-end">
                                                                <button type="submit" class="btn btn-primary formButton mSearchingBotton" title="Searching">
                                                            <div class="d-flex">
                                                                <div class="formSaveIcon">
                                                                    <img src="{{asset("assets/backend/app-assets/icon/searching-icon.png")}}" alt="" srcset="" width="20">
                                                                </div>
                                                                <div><span> Search</span></div>
                                                            </div>
                                                        </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>                        
                                </div>
                                @if (isset($attendances) && count($attendances)>0)
                                <div class="row" id="table-bordered">
                                    <div class="col-12">
                                        <div class="cardStyleChange">
                                            <div class="card-header">
                                                <h4 class="card-title">Student List</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table mb-0 table-sm table-hover">
                                                        <thead  class="thead-light">
                                                            <tr style="height: 50px;">
                                                                <th>Name</th>
                                                                <th>Date</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($attendances as $attendance)
                                        
                                                            <tr class="trFontSize">
                                                            <td>{{ $attendance->student->fname.' '.$attendance->student->mname }}</td>
                                                            <td> {{$attendance->date}} </td>
                                                            <td>
                                                                @if ($attendance->status==1)
                                                                <div class="badge badge-success">Present</div>
                                                                @else
                                                                <div class="badge badge-danger">Absent</div>  
                                                                @endif
                                                                
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
                                @else
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="cardStyleChange">
                                                <div class="card-body">
                                                    <h6>No Students Found!</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="newStudentAttendance" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
        @include('backend.tab-file.modal-header-info')
        
                <!-- Basic Vertical form layout section start -->
            <section id="basic-vertical-layouts">
                <div class="row match-height">
                    <div class="col-md-12 col-12">
                        <div class="cardStyleChange">
                            <h4 class="ml-2">Student Attendance</h4>
                            <div class="card-body">
                                <form class="form form-vertical" action="{{route('get_students')}}" method="POST" enctype="multipart/form-data">
                                            @csrf 
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="date">Date</label>
                                                    <input type="date" id="date_name" class="inputFieldHeight form-control @error('date') error @enderror" name="date" value="" required>
                                                    @error('date')
                                                    <span class="error">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="st-class">Class</label>
                                                    <select id="st-class-two" class="inputFieldHeight form-control @error('class_name') error @enderror" name="class_name" required>
                                                        <option>Select Class</option> 
                                                        @foreach ($st_classes as $class_item)
                                                        <option value="{{ $class_item->id}}">{{ $class_item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('class_name')
                                                    <span class="error">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="st-section">Section</label>
                                                    <select id="st-section-two" class="inputFieldHeight form-control @error('section') error @enderror" name="section" required>
                                                        <option>Select Section</option>
                                                    </select>
                                                    @error('section')
                                                    <span class="error">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="tutton" class="btn btn-primary formButton mSearchingBotton" title="Searching" id="SearchButton">
                                                    <div class="d-flex">
                                                        <div class="formSaveIcon">
                                                            <img src="{{asset("assets/backend/app-assets/icon/searching-icon.png")}}" alt="" srcset="" width="20">
                                                        </div>
                                                        <div><span> Search</span></div>
                                                    </div>
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>                        
                </div>
                <div id="searchStudentAttendaceResultShow">
                    
                </div>
            </section>
        @include('backend.tab-file.modal-footer-info')
      </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        $('#st-class').change(function(){
            var class_id= $(this).val();
            var csrf_token= '{{ csrf_token()}}';
            $.ajax({
            url:  '{{route("get_sections")}}',
            dataType: 'json',
            type: 'post',
            data: {class_id: class_id, _token: csrf_token },
            success:function(response){
                var optionHtml= '<option> Select Section </option>';
                response.forEach(function(element, index) {
                    optionHtml += "<option value='"+element.id +"'> "+ element.name+"</option>";
                    });
                    $('#st-section').html(optionHtml);
            }
            });
        });
        $(document).on("change", "#st-class-two", function(e){
            var class_id= $(this).val();
            var csrf_token= '{{ csrf_token()}}';
            $.ajax({
            url:  '{{route("get_sections")}}',
            dataType: 'json',
            type: 'post',
            data: {class_id: class_id, _token: csrf_token },
            success:function(response){
                var optionHtml= '<option> Select Section </option>';
                response.forEach(function(element, index) {
                optionHtml += "<option value='"+element.id +"'> "+ element.name+"</option>";
                });
                $('#st-section-two').html(optionHtml);
            }
            });
        });
        $(document).on("click", ".present-all", function(e){
            $('.present-status').prop('checked', true);
        })
        $(document).on("click", ".absent-all", function(e){
            $('.absent-status').prop('checked', true);
        })
        $(document).on("click", "#SearchButton",function(e){
            e.preventDefault();
            var csrf_token= '{{ csrf_token()}}';
            var c_id = document.getElementById("st-class-two");
            var class_id = c_id.value;
            var s_id = document.getElementById("st-section-two");
            var section_id = s_id.value;
            var date = document.getElementById('date_name').value;
            $.ajax({
            url:  '{{route("search-student-attendace")}}',
            type: 'post',
            data: {
                class_id: class_id,
                section_id: section_id,
                date: date,
                _token: csrf_token 
            },
            success:function(response){
                document.getElementById("searchStudentAttendaceResultShow").innerHTML = response;
            }
            });
        });
    });
</script>
@endpush