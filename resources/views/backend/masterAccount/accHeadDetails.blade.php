@extends('layouts.backend.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />

@endpush
@section('content')
@include('backend.tab-file.style')
<style>
    .accordion .pluseMinuseIcon.collapsed::before{
        content: "\f067";;
        cursor: pointer;
        border: 1px solid rgb(123, 123, 123);
    }
    .accordion .pluseMinuseIcon::before {
        font-family: 'FontAwesome';
        content: "\f068";
        cursor: pointer;
        border: 1px solid rgb(123, 123, 123);
    }
    .rowStyle{
        cursor: pointer;
        border-left: dotted;
        padding: 3px;
        margin-bottom: 2px;
    }
    .findMasterAcc{
        cursor: pointer;
    }
    /* ==========My Code========== */
    .bg-secondary {
        background-color: #34465b !important;
        border-radius: 40px;
        color:white  !important;
        padding: 2px 5px 2px 5px !important;
    }
    a.bg-secondary:hover, a.bg-secondary:focus,
    button.bg-secondary:hover,
    button.bg-secondary:focus {
        background-color: #475f7b30 !important;
        color:black!important;
    }
    tr:nth-child(even) {
        background-color: #c8d6e357;
    }
    a.text-dark:hover, a.text-dark:focus {
        color: #ffffff !important;
    }
    .btn-outline-secondary {
        border-radius: 40px;
        padding: 0.2px 9px 0.2px 9px !important;
    }

</style>
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
                <a href="{{route('account-head1')}}" class="nav-item nav-link  active" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('icon/chart-of-account.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div> Account Head</div>
                </a>
            </div>
            <div class="tab-content bg-white">
                <div class="tab-pane active">

                    <section id="widgets-Statistics"  class="mr-1 ml-1 mb-2 accountHeadStyle HeadStyle">
                        <div class="row">
                            <div class="col-12 mt-2 user-table-body">
                                <h4> Account Head Details </h4>

                                <form action="{{ route('accHeahDetailsPost1') }}" method="POST">
                                    @csrf
                                    <div class="row" style="margin-right: 0px;margin-left:0px;">
                                        <div class="col-md-4 changeColStyle">
                                            <label>Master Account</label>
                                            <select  id="master_id" class="form-control inputFieldHeight common-select2" name="master_id" required>
                                                <option value="">Select ...</option>
                                                @foreach ($master_details as $mas_ac)
                                                    <option value="{{$mas_ac->id}}">{{$mas_ac->mst_ac_head}}</option>
                                                @endforeach
                                            </select>
                                            @error('master_id')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 changeColStyle">
                                            <label>Name</label>
                                            <input type="text" id="fld_ac_head" class="form-control inputFieldHeight" name="fld_ac_head" required>
                                            @error('fld_ac_head')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3 d-flex justify-content-start mt-2">
                                            <button type="submit" class="btn btn-primary mr-1 formButton"  title="Form Save">
                                                <div class="d-flex">
                                                    <div class="formSaveIcon">
                                                        <img  src="{{asset('storage/upload/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                    </div>
                                                    <div><span> Save</span></div>
                                                </div>
                                            </button>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                    <hr>
                    <section class="accountHeadDetails">
                        <div class="container">
                            <div id="accordion" class="accordion">
                                <div class="row mb-2">

                                    <div class="col-8">
                                        <h5>Expense Items</h5>
                                        <table class="w-100 item-table">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th class="text-center" style="width:7%"> sl </th>
                                                    <th class="text-l" style="width:45%"> Name </th>
                                                    <th class="text-center" style="width:45%"> Acction </th>


                                                </tr>
                                            </thead>

                                            <tbody class="user-table-body">
                                                @foreach (App\Models\AccountHead::where('master_account_id',4)->get() as $key => $item)
                                                <tr class="text-center">
                                                        <td> {{$key++}} </td>
                                                        <td class="text-left pl-1 editAccHead" data-target="{{ route('editAccHead', $item) }}">  {{ $item->fld_ac_head }}</td>
                                                        <td><a href="{{ route('deleteAcHead',$item) }}" class="text-danger" onclick="return confirm('Delete Account Head. Confirm?')">
                                                            <img src="{{ asset('storage/upload/icon/delete-icon.png')}}" style=" height: 30px; width: 30px;">
                                                        </a>
                                                     </td>
                                                    </tr>
                                                    @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="modal fade" id="Account_head_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header" style="padding: 5px 15px;background:#364a60;">
                                                <h5 class="modal-title" id="exampleModalLabel" style="font-family:Cambria;font-size: 2rem;color:white;">
                                                    Account Details Edit</h5>
                                                <div class="d-flex align-items-center">
                                                    <button type="button" class="project-btn bg-danger text-white" data-dismiss="modal"
                                                        aria-label="Close" style="padding: 3px 12px;" data-bs-toggle="tooltip" data-bs-placement="right"
                                                        title="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="modal-body" style="padding: 15px 15px;">
                                                <section id="widgets-Statistics" class="mr-1 ml-1 mb-1">
                                                    <div class="row">
                                                        <div class="col-12 party-info-form">
                                                            <form action="" id="account_edit_form" method="POST">
                                                                @csrf
                                                                <div class="row" style="margin-right: 0px;margin-left:0px;">
                                                                    <div class="col-md-6 changeColStyle">
                                                                        <label>Master Account </label>
                                                                        <select  id="master_id" class="form-control inputFieldHeight master_id " name="master_id" required>
                                                                            <option value="">Select ...</option>
                                                                            @foreach ($master_details as $mas_ac)
                                                                                <option value="{{$mas_ac->id}}">{{$mas_ac->mst_ac_head}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('master_id')
                                                                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-md-4 changeColStyle">
                                                                        <label>Name</label>
                                                                        <input type="text" id="fld_ac_head" class="form-control inputFieldHeight fld_ac_head" name="fld_ac_head" required>
                                                                        @error('fld_ac_head')
                                                                            <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-md-2 d-flex justify-content-start mt-2">
                                                                        <button type="submit" class="btn btn-primary mr-1 formButton"  title="Form Save">
                                                                            <div class="d-flex">
                                                                                <div class="formSaveIcon">
                                                                                    <img  src="{{asset('storage/upload/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                                                </div>
                                                                                <div><span> Save</span></div>
                                                                            </div>
                                                                        </button>

                                                                    </div>
                                                                </div>
                                                            </form>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('storage/upload/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            // Trigger the modal

            // Handle click event for editing account head
            $(document).on("click", ".editAccHead", function(e) {
                e.preventDefault();
                $(".Account_head_modal").modal('show');

                var urls = $(this).attr("data-target");
                $.ajax({
                    url: urls,
                    type: 'GET',
                    cache: false,
                    dataType: 'json',
                    success: function(response) {
                        console.log('Response:', response);
                        $('.master_id').val(response.account_head.master_account_id).change();
                        $('.fld_ac_head').val(response.account_head.fld_ac_head);
                        var baseRoute = "{{ route('accHeahEditPost', '') }}/";
                        var dynamicPart = response.account_head.id;
                        var dynamicURL = baseRoute + dynamicPart;
                        console.log('Dynamic URL:', dynamicURL);
                        $('#account_edit_form').attr('action', dynamicURL);
                        // No need to empty the modal content before showing
                        $("#Account_head_modal").modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });
            });

        });
    </script>



@endpush
