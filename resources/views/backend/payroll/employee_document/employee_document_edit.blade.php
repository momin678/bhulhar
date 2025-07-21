@extends('layouts.backend.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
<style>
    .card {
        margin-bottom: 0.3rem !important;
        }
    h5 {

        line-height: 0.2 !important;
    }
</style>
@endpush
@section('content')
@include('layouts.backend.partial.style')


<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
                <a href="{{route("employees.index")}}" class="nav-item nav-link " role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/employee-icon.png')}}" alt="" srcset="" class="img-fluid" width="55">
                    </div>
                    <div>Employee Profile</div>
                </a>
                <a href="{{route("employee-history.index")}}" class="nav-item nav-link " role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/history-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Employee History</div>
                </a>
                <a href="{{route("employee-document.index")}}" class="nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/document-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Employee Document</div>
                </a>
            </div>
            <div class="tab-content bg-white">
                <div id="parentProfileList" class="tab-pane active">
                    <div class="content-body">
                        <div class="row" id="table-bordered">
                            <div class="col-12">
                                <div class="cardStyleChange">
                                    <h4 class="ml-2 mt-2">Professional Document Edit</h4>
                                    <div class="card-body">
                                            <!-- table bordered -->
                                            <form class="form form-vertical" action="{{route('employee-document-update', $documents->id)}}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <table class="table mb-0 table-sm table-hover" >
                                                    <thead  class="thead-light">
                                                        <tr style="height: 50px;">
                                                            <th> Document Name</th>
                                                            {{-- <th>Type</th> --}}
                                                            <th class="text-center">Document</th>
                                                            <th class="text-center">Image</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table-sm">
                                                        <tr class="trFontSize">
                                                            <td>Emirates Id</td>
                                                            <td><input type="file" name="emirates_image" class="form-control check-dep2" id=""></td>
                                                            <td>
                                                                <a href="{{ asset('storage/upload/employee/'.$documents->emirates_image)}}" target="_blank">
                                                                    <img src="{{ asset('storage/upload/employee/'.$documents->emirates_image)}}" title="{{$documents->name}}" style="height:60px" class="img-fluid" alt="" >
                                                                </a>  
                                                            </td>
                                                        </tr>
                                                        <tr class="trFontSize">
                                                            <td>Passport Image</td>
                                                            <td><input type="file" name="passport_image" class="form-control check-dep2" id=""></td>
                                                            <td>
                                                                <a href="{{ asset('storage/upload/employee/'.$documents->passport_image)}}" target="_blank">
                                                                    <img src="{{ asset('storage/upload/employee/'.$documents->passport_image)}}" title="{{$documents->name}}" style="height:60px" class="img-fluid" alt="" >
                                                                </a>  
                                                            </td>
                                                        </tr>

                                                        <tr class="trFontSize">
                                                            <td>Certificate</td>
                                                            <td><input type="file" name="quali_image" class="form-control check-dep2" id=""></td>
                                                            <td>
                                                                <a href="{{ asset('storage/upload/employee/'.$documents->quali_image)}}" target="_blank">
                                                                    <img src="{{ asset('storage/upload/employee/'.$documents->quali_image)}}" title="{{$documents->name}}" style="height:60px" class="img-fluid" alt="" >
                                                                </a>  
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <p class="text-right"><button class="btn btn-info mt-1" type="submit">Procced</button></p>

                                            </form>
                                        </div>
                                        {{-- <div class="ml-5">{{ $employees->links() }}</div> --}}
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

@endsection
@push('js')

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
 <script type="text/javascript">
     $(function() {
             $("#datepicker").datepicker({ dateFormat: "dd/mm/yy" }).val()
     });
 </script>
<script>
    $(document).ready(function() {

        $(document).on("click", ".check", function(e) {

        $(this).closest(".check-dep").removeAttr('required');
        $(this).closest(".check-dep2").removeAttr('required');

        });
        // Page Script
        // $('#edit_all').click(function (event) {
            $(document).on("click", "#edit_all", function(e) {

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


        $('.btn-select-all').click(function (event) {
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