@extends('layouts.backend.app')
@section('content')
@include('backend.tab-file.style')

<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
                <a href="{{route("profile-section")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/student-icon.png')}}" alt="" srcset="" class="img-fluid" width="55">
                    </div>
                    <div>Student Profile</div>
                </a>
                <a href="{{route('parent-profile-section')}}" class="nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false" id="parentProfileTab">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/parent-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Parent Profile</div>
                </a>
                <a href="{{route("student-document-section")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/document-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Student Document</div>
                </a>
                <a href="{{route("student-selection")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/document-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Student Selection</div>
                </a>
            </div>
            <div class="tab-content bg-white">
                <div id="parentProfileList" class="tab-pane active">
                    <div class="content-body">
                        <div class="row" id="table-bordered">
                            <div class="col-12">
                                <div class="cardStyleChange">
                                    <h4 class="ml-2 mt-2">Parent Profile</h4>
                                    <div class="card-body">
                                        <!-- table bordered -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <form method="get">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control inputFieldHeight" name="search" value="" placeholder="Search by Parent's name or Emirates ID">
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-md-6 d-flex">
                                                <div class=" flex-grow-1"></div>
                                                <button type="button" class="btn btn-primary formButton mb-1" title="Add" data-toggle="modal" data-target="#parentProfileAdd">
                                                    <div class="d-flex">
                                                        <div class="formSaveIcon">
                                                            <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" width="25">
                                                        </div>
                                                        <div><span>Add New</span></div>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table mb-0 table-sm table-hover">
                                                <thead  class="thead-light">
                                                    <tr style="height: 50px;">
                                                        <th>Parent ID</th>
                                                        <th>Father's Name</th>
                                                        <th>Mother's Name</th>
                                                        <th>Father's Emirates ID</th>
                                                        <th>Mother's Emirates ID</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($parent_data as $each_parent)
                                
                                                    <tr style="font-size: 12px;">
                                                        <td>{{ $each_parent->id }}</td>
                                                        <td><a href="" style="color: #727E8C;" class="parentViewProfile" id="{{$each_parent->id}}">{{ $each_parent->f_fname.' '.$each_parent->f_mname.' '.$each_parent->f_family_name }}</a></td>
                                                        <td><a href="" style="color: #727E8C;" class="parentViewProfile" id="{{$each_parent->id}}">{{ $each_parent->m_fname.' '.$each_parent->m_mname.' '.$each_parent->m_family_name }}</a></td>
                                                        <td>{{ $each_parent->f_emirates_id_num }}</td>
                                                        <td>{{ $each_parent->m_emirates_id_num }}</td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <div class="dropdown">
                                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-top: 2px; padding-bottom: 2px; font-size: 12px; padding-left: 10px;">
                                                                        Actions
                                                                    </button>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                        <a class="dropdown-item parentProfileEdit" href="#" id="{{$each_parent->id}}">Edit</a>
                                                                        <a class="dropdown-item parentViewProfile" href="#"  id="{{$each_parent->id}}">View</a>
                                                                        <a class="dropdown-item parentProfilePrint" href="#" id="{{$each_parent->id}}">Print</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="ml-5">{{ $parent_data->links() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="printArea" class="d-none">
                
            </div>
        </div>
    </div>
</div>


{{-- modal --}}
    {{-- parent --}}
    <div class="modal fade bd-example-modal-lg" id="parentProfileAdd" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            @include('backend.parent.create-modal')
          </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="parentViewProfileModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="profileViewDetails">
              
            </div>
          </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="parentEditProfileModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="profileEditDetails">
              
            </div>
          </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="parentPrintProfileModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="profilePrintDetails">
              
            </div>
          </div>
        </div>
    </div>
@endsection
@push('js')
<script src="{{ asset('assets/backend')}}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="{{ asset('assets/backend')}}/app-assets/js/scripts/forms/select/form-select2.js"></script>
{{-- parent --}}
<script>
    @if (count($errors) > 0)
        $('#parentProfileAdd').modal('show');
    @endif
    function printFunction(){ 
        window.print();
    }
    
    function fatherEmirateImgChange() {
        fatherEmirateImgPreview.src = URL.createObjectURL(event.target.files[0]);
    }
    function motherEmirateImgChange() {
        motherEmirateImgPreview.src = URL.createObjectURL(event.target.files[0]);
    }
    $(document).on("change", "#edit_fatherEmirateImgChange", function(){
        edit_fatherEmirateImgPreview.src = URL.createObjectURL(event.target.files[0]);
    });
    $(document).on("change", "#edit_motherEmirateImgChange", function(){
        edit_motherEmirateImgPreview.src = URL.createObjectURL(event.target.files[0]);
    });
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
       //Delete others
       $(document).on("click", '.invoice-item-delete', function(event) {
                event.preventDefault();
                // alert(1);
                var that = $(this);
                var urls = that.attr("data_target");
                var _token = $('input[name="_token"]').val();
                // alert(invoice_no);
                $.ajax({
                    url: urls,
                    method: "GET",
                    _token: _token,

                    success: function(response) {
                        // alert("hukka");
                        console.log(response);
                        $(".data").empty().append(response.page);

                    },
                    error: function() {
                        //   alert('no');
                    }
                });

            });

        //Delete others2
        $(document).on("click", '.invoice-item-delete2', function(event) {
                        event.preventDefault();
                        // alert(1);
                        var that = $(this);
                        var urls = that.attr("data_target");
                        var _token = $('input[name="_token"]').val();
                        // alert(invoice_no);
                        $.ajax({
                            url: urls,
                            method: "GET",
                            _token: _token,

                            success: function(response) {
                                // alert("hukka");
                                console.log(response);
                                $(".data2").empty().append(response.page);

                            },
                            error: function() {
                                //   alert('no');
                            }
                        });

                    });
    $(document).on("click", ".parentProfileEdit", function(e) { 
        e.preventDefault();
        var id= $(this).attr('id');
        $.ajax({
            url: "{{URL('parent-edit-profile-modal')}}",
            type: "post",
            cache: false,
            data:{
                _token:'{{ csrf_token() }}',
                id:id,
            },
            success: function(response){				
                document.getElementById("profileEditDetails").innerHTML = response;
                $('#parentEditProfileModal').modal('show');
                $('.common-select2').select2();
            }
        });
    });
    $(document).on("click", ".parentProfilePrint", function(e) { 
        e.preventDefault();
        var id= $(this).attr('id');
		$.ajax({
			url: "{{URL('parent-profile-print')}}",
			type: "post",
			cache: false,
			data:{
				_token:'{{ csrf_token() }}',
                id:id,
			},
            success: function(response) {
                document.getElementById("profilePrintDetails").innerHTML = response;
                $('#parentPrintProfileModal').modal('show');
                setTimeout(printFunction, 500);
            },
            error: function() {
                alert('Problem Found');
            }
		});
	});
</script>
@endpush
