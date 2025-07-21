


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
                                <div class="row" id="table-bordered">
                                    <div class="col-12">
                                        <div class="card cardStyleChange">
                                            <div class="card-header">
                                                <h4 class="card-title">Roles</h4>
                                                <button type="button" class="btn btn-primary btn_create formButton" title="Add" data-toggle="modal" data-target="#newRoleAdd">
                                                    <div class="d-flex">
                                                        <div class="formSaveIcon">
                                                            <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" width="25">
                                                        </div>
                                                        <div><span>Add New</span></div>
                                                    </div>
                                                </button>
                                            </div>
                                            <div class="card-body">
                                                <!-- table bordered -->
                                                <div class="table-responsive pr-1 pl-1">
                                                    <table class="table table-hover mb-0 table-sm">
                                                        <thead  class="thead-light">
                                                            <tr style="height: 50px;">
                                                                <th>#</th>
                                                                <th>Name</th>
                                                                <th>Permissions</th>
                                                                <th>Updated at</th>
                                                                <th style="width:80px;">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($roles as $role)

                                                            <tr style="font-size: 12px;">
                                                                <td>{{ $role->id }}</td>
                                                                <td>{{ $role->name }}</td>
                                                                <td>
                                                                    @if ($role->permissions->count() > 0)
                                                                        <span class="badge badge-info">{{ $role->permissions->count() }}</span>
                                                                    @else
                                                                        <span class="badge badge-danger">No permission found :(</span>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $role->updated_at->diffForHumans() }}</td>
                                                                <td>
                                                                    <a href="#" class="btn roleEdit" title="Edit" id="{{$role->id}}" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="newRoleAdd" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        @include('backend.role.role-create-modal')
      </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="roleEditModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div id="roleEditDetails">

        </div>
      </div>
    </div>
</div>
@endsection
@push('js')

    <script>
        $(document).on("click", ".roleEdit", function(e) {
            e.preventDefault();

            var id= $(this).attr('id');
            //alert(id);
            $.ajax({
                url: "{{URL('role-edit-modal')}}",
                method: "POST",
                cache: false,
                data:{
                    _token:'{{ csrf_token() }}',
                    id:id,
                },
                success: function(response){
                    document.getElementById("roleEditDetails").innerHTML = response;
                    $('#roleEditModal').modal('show');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Page Script
            // $('#edit_all').click(function (event) {
                $(document).on("change", "#edit_all", function(e) {

                if (this.checked) {
                    // Iterate each checkbox
                    $(':checkbox').each(function () {
                        this.checked = true;
                    });
                } else {
                    $(':checkbox').each(function () {
                        this.checked = false;
                    });
                }
            });


        });
    </script>
@endpush
