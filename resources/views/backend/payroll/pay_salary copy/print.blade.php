@php
    use Carbon\CarbonPeriod;
@endphp
@extends('layouts.backend.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />

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
                <a href="{{route('pay-salary.index')}}" class="nav-item nav-link " role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/list-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Salary Sheet</div>
                </a>
                {{-- <a href="{{route('pay-salary.create')}}" class="nav-item nav-link " role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/time-track.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Pay salary</div>
                </a> --}}
                <a href="{{route('print-document')}}" class="nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Print Document</div>
                </a>
            </div>
            <div class="tab-content bg-white">
                <div id="masterAccount" class="tab-pane active">
                    {{-- <section id="widgets-Statistics" class="mr-1 ml-1 mb-1">
                        <div class="row">
                            <div class="col-md-9  mt-2">
                                <h4>Salary Sheet</h4>
                            </div>
                            
                        </div>
                    </section> --}}
                    <hr style="margin:0px !important">
                    <br>
                    <br>
                    <div class="card-body">
                        <form action="{{route('generate-payslip')}}" method="GET" target="_blank" enctype="multipart/form-data">
                            @csrf
                            <div class="cardStyleChange">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row px-1">
                                            <h3>Payslip Print</h3>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="row px-1">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label for="class-name">Month</label>
                                                                <select name="month" id="" class="inputFieldHeight form-control" required>
                                                                    <option value="">Select month</option> 
                                                                    @foreach(CarbonPeriod::create(now()->startOfMonth(), '1 month', now()->addMonths(11)->startOfMonth()) as $date)   
                                                                    <option value="{{ $date->format('F') }}">
                                                                            {{ $date->format('F') }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('month')
                                                                    <span class="error">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-12">
                                                            <div class="form-group">
                                                                <label for="class-name">Year  </label>
                                                                    <select name="year" class="inputFieldHeight form-control" id="" required> 
                                                                        @for($i=date('Y')-2;date('Y')+2>$i;$i++)
                                                                            <option value="{{$i}}" {{ $i == date('Y')?'selected':'' }}>{{$i}}</option>
                                                                        @endfor
                                                                    </select>
                                                                @error('year')
                                                                    <span class="error">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 d-flex justify-content-end">
                                                            <button type="submit" class="btn mt-2 mb-2 formButton mSearchingBotton" title="Print Payslip">
                                                                <div class="d-flex">
                                                                    <div class="formSaveIcon">
                                                                        <img src="{{asset('assets/backend/app-assets/icon/print-icon.png')}}" width="25">
                                                                    </div>
                                                                    <div><span>Print Payslip</span></div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        {{-- management report print start --}}
                        <form action="{{route('generate-management-report')}}" method="GET" target="_blank" enctype="multipart/form-data">
                            @csrf
                            <div class="cardStyleChange">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row px-1">
                                            <h3>Management Report Print</h3>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="row px-1">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label for="class-name">Month</label>
                                                                <select name="month" id="" class="inputFieldHeight form-control" required>
                                                                    <option value="">Select month</option> 
                                                                    @foreach(CarbonPeriod::create(now()->startOfMonth(), '1 month', now()->addMonths(11)->startOfMonth()) as $date)   
                                                                    <option value="{{ $date->format('F') }}">
                                                                            {{ $date->format('F') }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('month')
                                                                    <span class="error">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-12">
                                                            <div class="form-group">
                                                                <label for="class-name">Year  </label>
                                                                    <select name="year" class="inputFieldHeight form-control" id="" required> 
                                                                        @for($i=date('Y')-2;date('Y')+2>$i;$i++)
                                                                            <option value="{{$i}}" {{ $i == date('Y')?'selected':'' }}>{{$i}}</option>
                                                                        @endfor
                                                                    </select>
                                                                @error('year')
                                                                    <span class="error">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 d-flex justify-content-end">
                                                            <button type="submit" class="btn mt-2 mb-2 formButton mSearchingBotton" title="Print Payslip">
                                                                <div class="d-flex">
                                                                    <div class="formSaveIcon">
                                                                        <img src="{{asset('assets/backend/app-assets/icon/print-icon.png')}}" width="25">
                                                                    </div>
                                                                    <div><span>Management Report</span></div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <tr>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Month</th>
                                        <th>Year</th>
                                        <th>Salary</th>
                                    </tr>
                                    @foreach ($paySalarys as $item)
                                        <tr>
                                            <td>{{ $item->items2->name }}</td>
                                            <td>{{ $item->items2->designation }}</td>
                                            <td>{{ $item->month }}</td>
                                            <td>{{ $item->year }}</td>
                                            <td>{{ $item->due }}</td>
                                        </tr>

                                    @endforeach


                                </table>
                            </div>
                        </div>
                    </div> --}}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    {{-- <script>
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
    </script> --}}
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

