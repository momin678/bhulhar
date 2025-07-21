@extends('layouts.backend.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush
@section('content')
@include('layouts.backend.partial.style')
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
    .card {
    margin-bottom: 0px !important;
    box-shadow: -8px 12px 18px 0 rgb(25 42 70 / 13%);
    transition: all .3s ease-in-out, background 0s, color 0s, border-color 0s;
}
tr, td{
    text-align: center;
}
</style>
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
                <a href="{{route('quotation.index')}}" class="nav-item nav-link " role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/master-account.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Quotation List</div>
                </a>
                <a href="{{route('quotation.create')}}" class="nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/account-heads.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Generate Quotation</div>
                </a>
            </div>
            <div class="tab-content bg-white">
                <div id="masterAccount" class="tab-pane active">
                    <section id="widgets-Statistics" class="mr-1 ml-1 mb-1">
                        <div class="row">
                            <div class="col-md-6  mt-2">
                                <h4>Create Quotation</h4>
                            </div>
                        </div>
                    </section>
                    <hr style="margin:0px !important">

                    <div class="row">
                        <div class="col-12">
                            <form action="{{ route('quotation.store') }}" method="POST" onsubmit="return confirm('Confirm Please!')">
                                @csrf
                                <div class="row d-flex justify-content-center mt-2">
                                    <div class="col-md-8 mb-1">
                                        <input type="date" placeholder="Date" class="form-control" value="{{ date('Y-m-d') }}" name="date" id="date" required>
                                    </div>

                                    <div class="col-md-8 mb-1">
                                        <input type="text" placeholder="TO" class="form-control" name="to" id="to" required>
                                    </div>

                                    <div class="col-md-8 mb-1">
                                        <select name="party" id="party" class="common-select2 w-100" required>
                                            <option value="">Select Party...</option>
                                            @foreach ($parties as $party )
                                            <option value="{{ $party->id }}">{{ $party->pi_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-8 mb-1">
                                        <input type="text" placeholder="Subject" class="form-control" name="subject" id="subject" required>
                                    </div>

                                    <div class="col-md-8">
                                        <textarea name="body"  class="form-control Body" rows="10" id="summernote"
                                        placeholder="Body" required><p style="letter-spacing: 0.15px;">Dear sir,</p><p style="letter-spacing: 0.15px;">We are submitting our L.S. price for the Above mentioned project as drawing and specification. Detailes as follow</p><p style="letter-spacing: 0.15px;">1.Main villa Dhs.1,090,000/</p><p style="letter-spacing: 0.15px;">2.Boundary wall Dhs.120,000/</p><p style="letter-spacing: 0.15px;">________________________</p><p style="letter-spacing: 0.15px;">Total Dhs.1,210,000/</p><p style="letter-spacing: 0.15px;">(Dhs. One million Tho hundred ten thousand only.)</p><p style="letter-spacing: 0.15px;">Note : Excluding UAE Vat.</p><p style="letter-spacing: 0.15px;">Thanking you,</p><p style="letter-spacing: 0.15px;">For Deluxe bldg.cont.</p></textarea>
                                    </div>
                                    <div class="col-md-8 text-center">
                                        <button type="submit" class="btn btn-sm btn-info">Create</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>    <script>
        $(document).ready(function() {
            $('#summernote').summernote()
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

<style>
    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }
    #customers td, #customers th {
        border: 1px solid #ddd;
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
       html, body{
        overflow: hidden;
       }
   }
</style>

