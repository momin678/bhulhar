@extends('layouts.backend.app')

@push('css')
    
@endpush

@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            {{-- <div class="content-header-left col-12 mb-2 mt-1">
                <div class="breadcrumbs-top">
                    <h5 class="content-header-title float-left pr-1 mb-0">Leave</h5>
                    <div class="breadcrumb-wrapper d-none d-sm-block">
                        <ol class="breadcrumb p-0 mb-0 pl-1">
                            <li class="breadcrumb-item"><a href="index.html"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Leave</a>
                            </li>
                            <li class="breadcrumb-item active"><a href="#">Student Leave</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="row">
            <div class="col-md-12">
              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
            </div>
          </div>
        <div class="content-body">
            <form class="form form-vertical" 
            action="{{ isset($employee) ? route('employee-documents.update', $employee->id) : route('employee-documents.store')}}" 
            method="POST" 
            enctype="multipart/form-data">
                @csrf 
                @isset($employee)
                    @method('PUT')
                @endisset


                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col-md-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Add Additional Documents</h4>
                                </div>
                                <div class="card-body">
                                    {{-- <form class="form form-vertical"> --}}
                                        <div class="form-body">
                                            <div class="row">
                                                
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="employee_name">Employee Name</label>
                                                        <select id="employee_name" class="form-control @error('employee_name') error @enderror" name="employee_name" required>
                                                            <option value=""> Select Employee</option>
                                                            @foreach ($employees as $each_employee)
                                                            <option value="{{$each_employee->id}}"
                                                                {{isset($employee) && $employee->id == $each_employee->id ? 'selected' : ''}}
                                                                > {{$each_employee->fname.' '.$each_employee->mname.' '.$each_employee->family_name}}</option>
                                                            @endforeach

                                                        </select>
                                                        @error('employee_name')
                                                        <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>



                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="files">Files</label>
                                                        <input type="file" id="files" class="form-control @error('files') error @enderror" name="files[]" multiple required>
                                                        @error('numofdays')
                                                        <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>                                                

                                                

                                            </div>

                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-end">
                                                    
                                                    <button type="submit" class="btn btn-primary mr-1">
                                                        @isset($employee)
                                                            Update
                                                        @else
                                                            Save
                                                        @endisset
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </section>
                <!-- Basic Vertical form layout section end -->

            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            // Page Script
            $('#class_id').change(function(){
                var class_id= $(this).val();
                var csrf_token= '{{ csrf_token()}}';
                $.ajax({
                url:  '{{route("leave-sections")}}',
                dataType: 'json',
                type: 'post',
                data: {class_id: class_id, _token: csrf_token },
                success:function(response){
                    
                    var optionHtml= '<option> Select Section </option>';

                    response.forEach(function(element, index) { 
                        console.log(element);
                        optionHtml += "<option value='"+element.id +"'> "+ element.name+"</option>";
                     });
                     $('#section_id').html(optionHtml);
                     console.log(optionHtml);
                    
                        
                }
                });
            });

            $('#section_id').change(function(){
                var class_id= $('#class_id').val();
                var section_id= $(this).val();
                var csrf_token= '{{ csrf_token()}}';
                $.ajax({
                url:  '{{route("leave-students")}}',
                dataType: 'json',
                type: 'post',
                data: {class_id: class_id,section_id: section_id, _token: csrf_token },
                success:function(response){
                    
                    var optionHtml= '<option> Select Section </option>';

                    response.forEach(function(element, index) { 
                        console.log(element);
                        optionHtml += "<option value='"+element.id +"'> "+ element.fname + " " +element.mname+ " " +element.family_name + "("+element.sis_number+")" +"</option>";
                     });
                     $('#student-name').html(optionHtml);
                     console.log(optionHtml);
                        
                }
                });
            });

        });
    </script>
@endpush