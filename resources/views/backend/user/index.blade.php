

@extends('layouts.backend.app')
@section('content')
@include('layouts.backend.partial.style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />

<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @include('clientReport.user._header')
            <div class="tab-content bg-white">
                <div class="tab-pane active">
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="cardStyleChange p-1">
                                 <!-- Bordered table start -->
                                <div class="row" id="table-bordered">
                                    <div class="col-12">
                                        <div class="card cardStyleChange">
                                            <div class="card-header">
                                                <h4 class="card-title">User's List</h4>
                                                <!-- <a href="{{ route('user.create')}}" class="btn btn-primary">Add New</a> -->
                                                <button type="button" class="btn btn-primary btn_create formButton" title="Add" data-toggle="modal" data-target="#newUserAdd">
                                                    <div class="d-flex">
                                                        <div class="formSaveIcon">
                                                            <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" width="25">
                                                        </div>
                                                        <div><span>Add</span></div>
                                                    </div>
                                                </button>
                                            </div>
                                            <div class="card-body">
                                                <!-- table bordered -->
                                                <div class="table-responsive pr-1 pl-1">
                                                    <table class="table table-hover mb-0 table-sm">
                                                        <thead  class="thead-light">
                                                            <tr style="height: 50px;">
                                                                <th>User Name</th>
                                                                <th>Email</th>
                                                                <th>Role</th>
                                                                <th class="text-right pr-2">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($users as $user)
                                                            <tr class="trFontSize">
                                                                <td>{{ $user->name }}</td>
                                                                <td>{{ $user->email }}</td>
                                                                <td>{{ $user->role?$user->role->name:'' }}</td>
                                                                <td class="text-right pr-2 pb-1">
                                                                    <a href="#" class="btn userEdit" title="Edit" id="{{$user->id}}" style="height: 30px; width: 30px;">
                                                                        <img src="{{asset('assets/backend/app-assets/icon/edit-icon.png')}}" alt="" srcset="" style=" height: 30px; width: 30px;">
                                                                    </a>
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
                                <!-- Bordered table end -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="newUserAdd" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        @include('backend.user.user-create-modal')
      </div>
    </div>
</div>
<div class="modal fade" id="userEditModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div id="userEditDetails">
        </div>
      </div>
    </div>
</div>
@endsection
@push('js')

    <script>
        $(document).on("click", ".userEdit", function(e) {
            e.preventDefault();

            var id= $(this).attr('id');
            //alert(id);
            $.ajax({
                url: "{{URL('user-edit-modal')}}",
                method: "POST",
                cache: false,
                data:{
                    _token:'{{ csrf_token() }}',
                    id:id,
                },
                success: function(response){
                    document.getElementById("userEditDetails").innerHTML = response;
                    $('#userEditModal').modal('show');
                }
            });
        });
    </script>
@endpush
