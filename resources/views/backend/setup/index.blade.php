


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
                                                    <h4 class="card-title">Setups</h4>
                                                    <button type="button" class="btn btn-primary btn_create formButton" title="Add" data-toggle="modal" data-target="#newSettingAdd">
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
                                                                    <th>Setup Name</th>
                                                                    <th>Setup Value</th>
                                                                    {{-- <th style="width:80px;">Actions</th> --}}
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($setups as $setup)

                                                                <tr style="font-size: 12px;">
                                                                    <td>{{ $setup->id }} </td>
                                                                    <td>{{ $setup->name }} </td>
                                                                    <td>{{ $setup->value }} </td>
                                                                    {{-- <td>
                                                                        <a href="#" class="btn setupEdit" title="Edit" id="{{$setup->id}}" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;">
                                                                            <img src="{{asset('assets/backend/app-assets/icon/edit-icon.png')}}" alt="" srcset="" style=" height: 30px; width: 30px;">
                                                                        </a>
                                                                    </td> --}}
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
<div class="modal fade bd-example-modal-lg" id="newSettingAdd" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        @include('backend.setup.create-modal')
      </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="settingEditModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div id="settingEditDetails">
        </div>
      </div>
    </div>
</div>
@endsection
@push('js')

    <script>
        $(document).on("click", ".setupEdit", function(e) {
            e.preventDefault();

            var id= $(this).attr('id');
            //alert(id);
            $.ajax({
                url: "{{URL('setup-edit-modal')}}",
                method: "POST",
                cache: false,
                data:{
                    _token:'{{ csrf_token() }}',
                    id:id,
                },
                success: function(response){
                    document.getElementById("settingEditDetails").innerHTML = response;
                    $('#settingEditModal').modal('show');
                }
            });
        });
        $(document).ready(function() {
            $('.config_type').click(function(){
                var conf_type= $(this).val();
                if(conf_type == 'img'){
                    $('#config-value-img').show();
                    $('#config-value-text').val('').hide();
                }else{
                    $('#config-value-text').show();
                    $('#config-value-img').val('').hide();
                }
            });
        });
        $(document).on("change", ".config_type2", function(e) {
            var conf_type= $(this).val();
            if(conf_type == 'img'){
                $('#config-value-img2').show();
                $('#config-value-text2').val('').hide();
            }else{
                $('#config-value-text2').show();
                $('#config-value-img2').val('').hide();
            }
        });

    </script>
@endpush
