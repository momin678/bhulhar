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
    .nav.nav-tabs ~ .tab-content {
        padding-top: 1px;
    }
    /* ================My Code============= */
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

    .table .thead-light th {
        color:#F2F4F4 ;
        background-color: #34465b;
        border-color: #DFE3E7;
    }
</style>
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @include('clientReport.setup._header',['activeMenu' => 'chart-of-account'])
            <div class="tab-content bg-white">
                <div id="masterAccount" class="tab-pane active">
                    <div class="d-flex align-items-center gap-2 p-2 ">
                        <a href="{{route('new-chart-of-account')}}" class="btn btn-outline-secondary bg-secondary text-white nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false" style="margin-right:15px;">

                            <div>Master Account</div>
                        </a>
                        <a href="{{route('new-account-head')}}" class="btn btn-outline-secondary text-dark nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">

                            <div>Account Head</div>
                        </a>
                    </div>

                        <section class="mr-1 ml-1 mt-2">
                            <div class="mt-1">
                                <div class="row">
                                    <div class="col-md-6">
                                        <form>
                                            <input type="text" name="q" class="form-control input-xs inputFieldHeight ajax-search" placeholder="Search By A/C Code, A/C Head, Definition, VAT Type, A/C Type" data-url="{{ route('admin.masterAccSearchAjax',$id="masterAcc") }}">
                                        </form>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button type="button" class="btn btn-xs btn-primary btn_create formButton" title="Add" data-toggle="modal" data-target="#masterAccountCreate" style="padding-top: 6px;padding-bottom: 6px;">
                                            <div class="d-flex">
                                                <div class="formSaveIcon">
                                                    <img src="{{asset('storage/upload/icon/add-icon.png')}}" width="25">
                                                </div>
                                                <div><span>Add</span></div>
                                            </div>
                                        </button>
                                        {{-- <a href="#" class="btn btn-xs mPrint formButton" onclick="window.print()" title="Print"><img  src="{{asset('storage/upload/icon/print-icon.png')}}" class="img-fluid" width="30"> Print</a>
                                        <a href="{{ route("chart-ofaccount-pdf") }}" class="btn btn-xs mPdfPrint formButton" title="PDF Download"><img  src="{{asset('storage/upload/icon/pdf-download-icon.png')}}" class="img-fluid" width="30"> PDF</a> --}}
                                        <a href="#" class="btn btn-xs mExcelButton formButton" onclick="exportTableToCSV('MasterAccountsdetails.csv')" title="Export to Excel"><img  src="{{asset('storage/upload/icon/excel-icon.png')}}" class="img-fluid" width="30">Excel</a>
                                    </div>
                                </div>
                                <div class="cardStyleChange">
                                    <table class="table mb-0 table-sm table-hover">
                                        <thead  class="thead-light">
                                            <tr class="mTheadTr" style="height: 40px;text-align:center;">
                                            <th>Code</th>
                                            <th>Master A/C Head</th>
                                            <th>Definition</th>
                                            <th>A/C Type</th>
                                            <th>@if(!empty($currency->vat_name)){{$currency->vat_name}} @endif Type</th>
                                            <th style="padding-left: 20px;">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="user-table-body">
                                            @foreach ($masterDetails as $masterAcc1)
                                            <tr class="trFontSize"  style="height: 40px;text-align:center;">
                                                <td>{{ $masterAcc1->mst_ac_code }}</td>
                                                <td>{{ $masterAcc1->mst_ac_head }}</td>
                                                <td>{{ $masterAcc1->mst_definition }}</td>
                                                <td>{{ $masterAcc1->mst_ac_type }}</td>
                                                <td>{{ $masterAcc1->vat_type }}</td>

                                                <td>
                                                    <div style="margin-top: -12px;">
                                                    <a href="{{ route('masterEdit',$masterAcc1) }}" class="btn" style="height: 30px; width: 30px;" title="Edit"><img src="{{ asset('storage/upload/icon/edit-icon.png')}}" style=" height: 25px; width: 25px;"></a>
                                                    <a href="{{ route('masterDelete',$masterAcc1) }}" onclick="return confirm('about to delete master account. Please, Confirm?')"  class="btn" style="height: 25px; width: 25px;padding: 0.467rem 0.8rem;" title="Delete"><img src="{{ asset('storage/upload/icon/delete-icon.png')}}" style=" height: 25px; width: 25px; margin-left: -12px;"></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-right">
                                    {{$masterDetails->links()}}
                                </div>
                            </div>
                        </section>

                    </div>
                </div>
            </div>
        </div>
            <!-- Modal -->
        <div class="modal fade" id="masterAccountCreate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="padding: 5px 15px;background:#364a60;">
                    <h5 class="modal-title" id="exampleModalLabel" style="font-family:Cambria;font-size: 2rem;color:white;"> Master Account Details</h5>
                    <div class="d-flex align-items-center">  
                        <button type="button" class="project-btn bg-danger text-white" data-dismiss="modal" aria-label="Close" style="padding: 3px 12px;" data-bs-toggle="tooltip" data-bs-placement="right" title="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body" style="padding: 5px 5px;">
                    <section id="widgets-Statistics" class="mr-1 ml-1 mb-1" data-select2-id="widgets-Statistics">
                        <!-- <div class="row">
                            <div class="col-md-6  mt-2 mb-2">
                                <h4>Master Account Details</h4>
                            </div>
                            <div class="col-md-6  mt-2 mb-2" style="text-align: right;">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
                            </div>
                                {{-- @include('alerts.alerts') --}}
                        </div> -->
                        <div class="row" data-select2-id="16">
                            <div class="col-12" data-select2-id="15">
                                @isset($masterAcc)
                                <form action="{{ route('masterDetailsUpdate', $masterAcc) }}" method="POST">
                                @else
                                <form action="{{ route('masterDetailsPost') }}" method="POST">
                                @endisset
                                    @csrf
                                    <div class="cardStyleChange">
                                        <div class="row">
                                            <div class="col-md-3 mt-1">
                                                <label for="">Master Account Details</label>
                                                    <select name="category" class="common-select2 inputFieldHeight" style="width: 100% !important" id="category" {{ isset($masterAcc)?'disabled readonly':'' }} >
                                                        <option value="">Select Category...</option>
                                                        @foreach ($categories as $item)
                                                        <option value="{{ $item->id }}" >{{ $item->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('category')
                                                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mt-1">
                                                <label>Master A/C Code</label>
                                                <input type="text" id="mst_ac_code" class="form-control inputFieldHeight" name="mst_ac_code" value="{{ isset($masterAcc)?$masterAcc->mst_ac_code:"" }}" placeholder="Master A/C Code" disabled>
                                                @error('mst_ac_code')
                                                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mt-1">
                                                <label>Definition</label>
                                                <select name="mst_definition" class="common-select2 inputFieldHeight" style="width: 100% !important" id="" required>
                                                    <option value="">Select...</option>
                                                    @foreach ($mst_definitions as $item)
                                                    <option value="{{ $item->title }}" {{ isset($masterAcc)?($masterAcc->mst_definition==$item->title?"selected":""):"" }}>{{ $item->title }}</option>

                                                    @endforeach
                                                </select>
                                                @error('mst_definition')
                                                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mt-1">
                                                <label>Master A/C Type</label>
                                                <select name="mst_ac_type" class="common-select2 inputFieldHeight" style="width: 100% !important" id="mst_ac_type" {{ isset($masterAcc)? "disabled readonly":"required"}} >
                                                    <option value="">Select...</option>
                                                    @foreach ($mstAccType as $item)
                                                    <option value="{{ $item->title }}" {{ isset($masterAcc)?($masterAcc->mst_ac_type==$item->title?"selected":""):"" }}>{{ $item->title }}</option>
                                                    @endforeach
                                                </select>
                                                @error('mst_ac_type')
                                                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div @if (@isset($masterAcc))
                                            class="col-md-4 mt-1"
                                            @else
                                            class="col-md-5 mt-1"
                                            @endif>
                                                <label>Master A/C Head</label>
                                                <input type="text" id="mst_ac_head" class="form-control inputFieldHeight" name="mst_ac_head" value="{{ isset($masterAcc)?$masterAcc->mst_ac_head:"" }}" placeholder="Master A/C Head" required>
                                                @error('mst_ac_head')
                                                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mt-1">
                                                <label>@if(!empty($currency->vat_name)){{$currency->vat_name}} @endif Type</label>
                                                <select name="vat_type" id="vat_type" class="common-select2 inputFieldHeight" style="width: 100% !important" required>
                                                    <option value="">Select..</option>
                                                    @foreach ($vat_types as $item)
                                                    <option value="{{ $item->title }}" {{ isset($masterAcc)?($masterAcc->vat_type==$item->title?"selected":""):"" }}>{{ $item->title }}</option>
                                                    @endforeach
                                                </select>
                                                @error('vat_type')
                                                    <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 @isset($masterAcc)col-md-4 pl-0 @endisset" style="margin-top: 36px;">
                                                <div class="d-flex justify-content-end">
                                                    @isset($masterAcc)
                                                    <a href="{{ route('new-chart-of-account') }}" class="btn btn-info mr-1 formButton"><img src="{{ asset('storage/upload/icon/add-icon.png')}}" alt="" srcset="" class="image-fluid" width="25"> New</a>
                                                    @endisset

                                                    <button type="submit" class="btn mr-1 btn-primary formButton" title="Form Save">
                                                        <div class="d-flex">
                                                            <div class="formSaveIcon">
                                                                <img  src="{{asset('storage/upload/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                            </div>
                                                            @isset($masterAcc)
                                                            <div><span>Update</span></div>
                                                            @else
                                                            <div><span> Save</span></div>
                                                            @endisset
                                                        </div>
                                                    </button>
                                                    <button type="reset" class="btn btn-light-secondary formButton" title="Form Reset" @isset($masterAcc)disabled @endisset>
                                                        <div class="d-flex">
                                                            <div class="formRefreshIcon">
                                                                <img  src="{{asset('storage/upload/icon/refresh-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                            </div>
                                                            <div><span> Reset</span></div>
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
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
        @endsection

        @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
            {{-- <script src="{{ asset('storage/upload/vendors/js/jquery/jquery.min.js') }}"></script> --}}
            <script>
                if( $('#mst_ac_head').val()!='')
                {
                    $('#masterAccountCreate').modal('show')

                }

                $(document).ready(function() {
                    $('#category').change(function() {
                        // alert(1);
                        if ($(this).val() != '') {
                            var value = $(this).val();
                            var _token = $('input[name="_token"]').val();

                            $.ajax({
                                url: "{{ route('findMastedCode') }}",
                                method: "POST",
                                data: {
                                    value: value,
                                    _token: _token,
                                },
                                success: function(response) {
                                    $("#mst_ac_code").val(response);
                                }

                            })
                        }
                    });
                });
            </script>

        <script>

            $(document).ready(function() {
                var delay = (function() {
                    var timer = 0;
                    return function(callback, ms) {
                        clearTimeout(timer);
                        timer = setTimeout(callback, ms);
                    };
                })();

                $(document).on("click", ".findMasterAcc", function(e) {
                    e.preventDefault();
                    var that = $(this);

                    var urls = that.attr("data-target");
                    delay(function() {
                        $.ajax({
                            url: urls,
                            type: 'GET',
                            cache: false,
                            dataType: 'json',
                            success: function(response) {
                                //   alert('ok');
                                // console.log(response);
                                $(".pagination").remove();
                                $(".user-table-body").empty().append(response.page);
                            },
                            error: function() {
                                //   alert('no');
                            }
                        });
                    }, 999);
                });
                $(document).on("click", ".editAccHead", function(e) {
                    e.preventDefault();
                    var that = $(this);

                    var urls = that.attr("data-target");
                    delay(function() {
                        $.ajax({
                            url: urls,
                            type: 'GET',
                            cache: false,
                            dataType: 'json',
                            success: function(response) {
                                //   alert('ok');
                                // console.log(response);
                                $(".pagination").remove();
                                $(".user-table-body").empty().append(response.page);
                            },
                            error: function() {
                                //   alert('no');
                            }
                        });
                    }, 999);
                });


            });
        </script>
        @endpush
        @include('layouts.backend.partial.pdf-footer-info')
        <style>
            #customers {
                font-family: Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }
            #customers td, #customers th {
                /* border: 1px solid #ddd; */
                padding: 8px;
            }

            #customers tr:nth-child(even){background-color: #f2f2f2;}

            #customers tr:hover {background-color: #ddd;}
            #customers th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: #04AA6D;
                color: white;
                text-transform: uppercase;

            }
            .graph-7{background: url(../img/graphs/graph-7.jpg) no-repeat;}
            .graph-image img{display: none;}
            @media screen {
            div.divFooter {
                display: none;
            }
            }
            @media print {
                div.divFooter {
                    position: fixed;
                    bottom: 0;
                }
            }
            th{
                text-transform: uppercase;
            }
        </style>
        <style>
           .print-layout{
               display: none;
           }
           @media print{
               .print-layout{
                   display: block;
                   /* overflow: hidden; */
               }
           }
        </style>
        <section class="print-layout">
        @include('layouts.backend.partial.pdf-header-info')

        <div class="container py-4">
            <div class="row">
                <div class="col-md-12">
                 <section id="widgets-Statistics">
                     <div class="row">
                         <div class="col-12 mt-1 mb-2">
                             <h4>Master Account Details</h4>
                             <hr>
                         </div>
                     </div>

                         <div class="row">
                                <table id="customers" class="table-sm">
                                    <tr>
                                        <th>Code</th>
                                        <th>Master A/C Head</th>
                                        <th>Desfinition</th>
                                        <th>A/C Type</th>
                                        <th>VAT Type</th>
                                    </tr>

                                    @foreach ($masterDetailsPDF as $masterAcc)
                                    <tr>
                                        <td>{{ $masterAcc->mst_ac_code }}</td>
                                        <td>{{ $masterAcc->mst_ac_head }}</td>
                                        <td>{{ $masterAcc->mst_definition }}</td>
                                        <td>{{ $masterAcc->mst_ac_type }}</td>
                                        <td>{{ $masterAcc->vat_type }}</td>


                                    </tr>

                                    @endforeach



                                </table>
                         </div>
                 </section>
                </div>
            </div>
        </div>

        @include('layouts.backend.partial.pdf-footer-info')
        <div class="img">
            <img src="{{ asset('assets/backend/app-assets')}}/beps-logo.png" class="img-fluid" style="position: fixed; top:550px; left:270px; opacity:0.1; " alt="">
        </div>
    </section>
</div>
