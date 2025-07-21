@extends('layouts.backend.app')
@section('content')
@include('backend.tab-file.style')

<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="tab-content bg-white">
                <div id="studentProfileList" class="tab-pane {{$tab_id=="student_profile" ? "active": ""}}">
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="cardStyleChange">
                                <div class="card-header d-flex">
                                    <h4 class="card-title flex-grow-1">Student Profile</h4>F@@include('name')
                                    <div>
                                        <button type="button" class="btn btn-primary btn_create formButton mr-1" title="Add" data-toggle="modal" data-target="#studentProfileAdd">
                                            <div class="d-flex">
                                                <div class="formSaveIcon">
                                                    <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" width="25">
                                                </div>
                                                <div><span>Add</span></div>
                                            </div>
                                        </button>
                                        <a href="{{ route('student-list-print')}}" class="btn btn_create mPrint formButton" title="List Print" target="blank">
                                            <div class="d-flex">
                                                <div class="formSaveIcon">
                                                    <img src="{{asset('assets/backend/app-assets/icon/print-icon.png')}}" width="25">
                                                </div>
                                                <div><span>List Print</span></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!-- table bordered -->
                                    <div class="row">
                                        <div class="col-md-5">
                                            <form method="get">
                                                <div class="form-group">
                                                    <input type="text" class="form-control inputFieldHeight" name="search" value="" placeholder="Search by Student Name, SIS Number or Emirates ID">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-7">
                                            <form action="">
                                                <div class="row">
                                                    <div class="col-md-5 changeColStyle">
                                                        <select name="s_class" id="class_id" class="form-control inputFieldHeight" required>
                                                            <option value="">Select Class</option>
                                                            @foreach ($class as $item)
                                                                <option value="{{$item->id}}" {{$s_class == $item->id ? "selected":""}}>{{$item->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-5 ">
                                                        <select name="section_id" id="section_id" class="form-control inputFieldHeight">
                                                            <option value="">Select Section</option>
                                                            @foreach ($sections as $item)
                                                                <option value="{{$item->id}}" {{$section_id == $item->id ? "selected":""}}>{{$item->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2" style="padding-left: 0px">
                                                        {{-- <button class="btn btn-secondary" style="padding:8px 30px 11px 30px; float: right;"><i class='bx bx-search'></i></button> --}}
                                                        <button type="submit" class="btn btn-primary formButton mSearchingBotton" title="Searching" style="padding-left: 1px;
                                                        padding-right: 1px;">
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
                                    <div class="table-responsive" style="min-height: 300px">
                                        <table class="table mb-0 table-sm table-hover">
                                            <thead  class="thead-light">
                                                <tr style="height: 50px;">
                                                    <th>SL No</th>
                                                    <th>S Number</th>
                                                    <th>Student Name</th>
                                                    <th>Standard</th>
                                                    <th>Emirates ID Number</th>
                                                    <th class="pl-2">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-sm">
                                                @foreach ($students as $key => $each_student)

                                                <tr class="border-bottom" style="font-size: 12px;">
                                                    <td class="text-center">{{ ($key+1) + ($students->currentPage() - 1)*$students->perPage() }}</td>
                                                    <td>{{$each_student->student_number}}</td>
                                                    <td><a href="" style="color: #727E8C;" class="studentViewProfile" id="{{$each_student->id}}">{{ $each_student->fname.' '.$each_student->mname.' '.$each_student->family_name }}</a></td>
                                                    <td class="text-center">{{ $each_student->standard }}</td>
                                                    <td>{{ $each_student->sis_number }}</td>
                                                    <td style="float: right;">
                                                        <div class="btn-group">
                                                            <div class="dropdown">
                                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-top: 2px; padding-bottom: 2px; font-size: 12px; padding-left: 10px;">
                                                                    Actions
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                    <a class="dropdown-item studentProfileEdit" href="{{route('student.edit', $each_student->id)}}" id="{{$each_student->id}}">Edit</a>
                                                                    <a class="dropdown-item studentViewProfile" href="#"  id="{{$each_student->id}}">View</a>
                                                                    <a class="dropdown-item studentProfilePrint" id="{{$each_student->id}}" href="#">Print</a>
                                                                    @php
                                                                        $admission = App\Admission::where('student_id', $each_student->id)->first();
                                                                    @endphp
                                                                    @if ($admission)
                                                                    <a class="dropdown-item studentIdCardPrint" href="#" id="{{$each_student->id}}">ID Print</a>
                                                                    @else
                                                                    <a class="dropdown-item" href="#" onclick="alert('Please, Complete the admission of this student first!')" >ID Print</a>
                                                                    @endif
                                                                    {{-- <a class="dropdown-item" href="{{ route('student-transfer', $each_student->id)}}">Transfer</a> --}}
                                                                    <a class="dropdown-item studentTransfer" href="#" id="{{$each_student->id}}">Transfer</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-1 ml-5">{{ $students->links() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- modal --}}
{{-- student --}}
    <div class="modal fade bd-example-modal-lg" id="studentProfilePrintModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="profileDetails">

            </div>
          </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg modal-for-idCard" id="studentIDCardePrintModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-for-idCard-body" role="document">
          <div class="modal-content">
            <div id="idCardDetails">

            </div>
          </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="studentViewProfileModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="profileViewDetails">

            </div>
          </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="studentEditProfileModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="studentEditProfilShow">

            </div>
          </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="studentProfileAdd" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            @include('backend.student.create-modal')
          </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="studentListPrintModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="studentListPrintShow"></div>
          </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="studentTransferModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="studentTransferModalShow">
            </div>
          </div>
        </div>
    </div>
    {{-- parent --}}
    <div class="modal fade bd-example-modal-lg" id="parentViewProfileModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="profileViewDetails">

            </div>
          </div>
        </div>
    </div>
@endsection
@push('js')
{{-- student --}}
<script>
    let change_class = $('#class_id').change(function(){
        var class_id= $(this).val();
        var csrf_token= '{{ csrf_token()}}';
        $.ajax({
        url:  '{{route("leave-sections")}}',
        dataType: 'json',
        type: 'post',
        data: {class_id: class_id, _token: csrf_token },
        success:function(response){
                var optionHtml= '<option value=""> Select Section </option>';
                response.forEach(function(element, index) {
                console.log(element);
                optionHtml += "<option value='"+element.id +"'> "+ element.name+"</option>";
                });
                $('#section_id').html(optionHtml);
            }
        });
    });
    $(document).on("change", "#class_id_two", function(e){

        var class_id= $(this).val();
        var csrf_token= '{{ csrf_token()}}';
        $.ajax({
        url:  '{{route("leave-sections")}}',
        dataType: 'json',
        type: 'post',
        data: {class_id: class_id, _token: csrf_token },
        success:function(response){
                var optionHtml= '<option value=""> Select Section </option>';
                response.forEach(function(element, index) {
                console.log(element);
                optionHtml += "<option value='"+element.id +"'> "+ element.name+"</option>";
                });
                $('#section_id_two').html(optionHtml);
            }
        });
        $.ajax({
        url:  '{{route("ajax-search-student-list")}}',
        dataType: 'json',
        type: 'post',
        data: {class_id: class_id, _token: csrf_token },
        success:function(response){
                document.getElementById("mStudentListPrint") = response;
            }
        });
    });
    window.onload = change_class;
    $(document).on("click", ".studentProfilePrint", function(e) {
        e.preventDefault();
        var id= $(this).attr('id');
		$.ajax({
			url: "{{URL('profile-print')}}",
			type: "post",
			cache: false,
			data:{
				_token:'{{ csrf_token() }}',
                id:id,
			},
			success: function(response){
                document.getElementById("profileDetails").innerHTML = response;
                $('#studentProfilePrintModal').modal('show')
			}
		});
	});
    $(document).on("click", ".studentIdCardPrint", function(e) {
        e.preventDefault();
        var id= $(this).attr('id');
		$.ajax({
			url: "{{URL('id-print')}}",
			type: "post",
			cache: false,
			data:{
				_token:'{{ csrf_token() }}',
                id:id,
			},
			success: function(response){
                document.getElementById("idCardDetails").innerHTML = response;
                $('#studentIDCardePrintModal').modal('show')
			}
		});
	});
    $(document).on("click", ".studentViewProfile", function(e) {
        e.preventDefault();
        var id= $(this).attr('id');
		$.ajax({
			url: "{{URL('student-view-profile-modal')}}",
			type: "post",
			cache: false,
			data:{
				_token:'{{ csrf_token() }}',
                id:id,
			},
			success: function(response){
                document.getElementById("profileViewDetails").innerHTML = response;
                $('#studentViewProfileModal').modal('show')
			}
		});
	});
    $(document).on("click", ".studentProfileEdit", function(e) {
        e.preventDefault();
        var id= $(this).attr('id');
		$.ajax({
			url: "{{URL('student-edit-profile-modal')}}",
			type: "post",
			cache: false,
			data:{
				_token:'{{ csrf_token() }}',
                id:id,
			},
			success: function(response){
                document.getElementById("studentEditProfilShow").innerHTML = response;
                $('#studentEditProfileModal').modal('show');
                $('.common-select2').select2();
			}
		});
	});
    $(document).on("click", ".studentTransfer", function(e) {
        e.preventDefault();
        var id= $(this).attr('id');
		$.ajax({
			url: "{{URL('student-transfer-modal')}}",
			type: "post",
			cache: false,
			data:{
				_token:'{{ csrf_token() }}',
                id:id,
			},
			success: function(response){
                document.getElementById("studentTransferModalShow").innerHTML = response;
                $('#studentTransferModal').modal('show');
                // $('.common-select2').select2();
			}
		});
	});
    $(document).on("click", "#studentListPrint", function(e) {
        e.preventDefault();
		$.ajax({
			url: "{{URL('student-list-print-modal')}}",
			type: "post",
			cache: false,
			data:{
				_token:'{{ csrf_token() }}',
			},
			success: function(response){
                document.getElementById("studentListPrintShow").innerHTML = response;
                $('#studentListPrintModal').modal('show');
                // $('.common-select2').select2();
			}
		});
	});
</script>
<script src="{{ asset('assets/backend')}}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="{{ asset('assets/backend')}}/app-assets/js/scripts/forms/select/form-select2.js"></script>
    <script>
        $(document).ready(function() {
            // Page Script
            $('#parent-select').select2();
            $('.common-select2').select2();

            $('#school-transport').change(function(){
                var school_transport = $(this).val();
                if(school_transport=='yes'){
                    $('.transport-area-box').show();
                }else{
                    $('.transport-area-box').hide();
                }
            });

            $('#parent-select').change(function(){
                var parent_id= $(this).val();
                var csrf_token= '{{ csrf_token()}}';
                $.ajax({
                url:  '{{route("ajaxparent")}}',
                dataType: 'json',
                type: 'post',
                data: {parent_id: parent_id, _token: csrf_token },
                success:function(response){

                    // $('#g_fname').val(response.f_fname);
                    // $('#g_nationality').val(response.f_nationality);
                    $('[id^=g_]').each(function(){
                        var input_id= $(this).attr('id');
                        var parent_field= input_id.replace('g_', 'f_');
                        console.log(response[parent_field]);
                        $('#'+input_id).val(response[parent_field]);
                    });
                }
                });
            });

            // age calculate
            // document.getElementById('getAge').addEventListener('change', function() {
            $(document).on("change","#getAge", function(e){

                const currentDate = new Date();
                date_1 = new Date(this.value);
                date_2 = new Date(currentDate.getFullYear(), 6, 1);
                 //convert to UTC
                var date2_UTC = new Date(Date.UTC(date_2.getUTCFullYear(), date_2.getUTCMonth(), date_2.getUTCDate()));
                var date1_UTC = new Date(Date.UTC(date_1.getUTCFullYear(), date_1.getUTCMonth(), date_1.getUTCDate()));
                var yAppendix, mAppendix, dAppendix;
                //--------------------------------------------------------------
                var days = date2_UTC.getDate() - date1_UTC.getDate();
                if (days < 0)
                {
                    date2_UTC.setMonth(date2_UTC.getMonth() - 1);
                    days += DaysInMonth(date2_UTC);
                }
                //--------------------------------------------------------------
                var months = date2_UTC.getMonth() - date1_UTC.getMonth();
                if (months < 0)
                {
                    date2_UTC.setFullYear(date2_UTC.getFullYear() - 1);
                    months += 12;
                }
                //--------------------------------------------------------------
                var years = date2_UTC.getFullYear() - date1_UTC.getFullYear();
                if (years > 1) yAppendix = " years";
                else yAppendix = " year";
                if (months > 1) mAppendix = " months";
                else mAppendix = " month";
                document.getElementById('showAge').value = years + yAppendix + ", " + months + mAppendix;
            });

            function DaysInMonth(date2_UTC)
            {
                var monthStart = new Date(date2_UTC.getFullYear(), date2_UTC.getMonth(), 1);
                var monthEnd = new Date(date2_UTC.getFullYear(), date2_UTC.getMonth() + 1, 1);
                var monthLength = (monthEnd - monthStart) / (1000 * 60 * 60 * 24);
                return monthLength;
            }
        });
        function emirateImgPreview() {
            emirate_ImgPreview.src = URL.createObjectURL(event.target.files[0]);
        }
        function profileImgPreview() {
            profile_ImgPreview.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
{{-- parent --}}
<script>
    $(document).on("click", "#parentProfileTab", function(e){
        $.ajax({
        url: "{{URL('parent-profile-tab')}}",
        type: "get",
        cache: false,
        // data:{
        //     _token:'{{ csrf_token() }}',
        // },
        success: function(response){
            document.getElementById("parentProfileList").innerHTML = response;
        }
    });
    })
    $(document).on("click", ".parentViewProfile", function(e) {
    e.preventDefault();
    var id= $(this).attr('id');
    $.ajax({
        url: "{{URL('parent-view-profile-modal')}}",
        type: "post",
        cache: false,
        data:{
            _token:'{{ csrf_token() }}',
            id:id,
        },
        success: function(response){
            document.getElementById("profileViewDetails").innerHTML = response;
            $('#parentViewProfileModal').modal('show')
        }
    });
});
</script>
@endpush
