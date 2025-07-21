@extends('layouts.backend.app')
@section('content')
@include('layouts.backend.partial.style')
<style>
    .table td{
        border-bottom: none;
    }
    .commonSelect2Style span{
        width: 100% !important;
    }

    .paid-status{
        background-color: #c2d8c7;
        color: #212529e8;
	}
    .partial-paid{
        background-color: #fbbc0099;
        color: #212529e8;
	}
    .unpaid-status{
        background-color: #ffc7ce;
        color: #212529e8;
	}
    .master-icon{
        margin-top: 15px !important;
    }
    .conpany-header{
        display: none;
    }
    @media print{
        .nav.nav-tabs ~ .tab-content {
            border-left: 1px solid #fff;
            border-right: 1px solid #fff;
            border-bottom: 1px solid #fff;
            padding-left: 0;
        }
        .conpany-header{
            display: block !important;
            margin-top: -150px !important;
            /* margin-bottom: -150px !important; */
        }
    }
</style>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @include('clientReport.customer-inv._header')

            <div class="tab-content bg-white">
                <div class="tab-pane active">
                    <div class="row" id="">
                        <div class="col-12">
                            <div class="cardStyleChange">
                                <div class="conpany-header">
                                    @include('layouts.backend.partial.modal-header-info')
                                </div>
                                <section id="widgets-Statistics" class="pl-1 mt-2">
                                    <form action="">
                                        <div class="row print-hideen">
                                            <div class="row col-md-12">

                                                <div class="col-md-3 changeColStyle pl-2">
                                                    <label for="">Select Driver</label>
                                                    <select name="driver_id" id="" class="form-controll common-select2" style="width: 100% !important;">
                                                        <option value="">Driver Name------</option>
                                                        @foreach ($drivers as $driver)
                                                            <option value="{{$driver->id}}" {{$id == $driver->id ? 'selected':''}}>{{$driver->full_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2 changeColStyle pl-2">
                                                    <label for="">From Date</label>
                                                    <input name="from"autocomplete="off" value="{{$from}}" type="text" placeholder="dd/mm/yyyy"class="form-controll datepicker"  style="width: 100% !important;
                                                    border: 1px solid #dfe3e7;
                                                    height: 32px;
                                                    border-radius: 3px;
                                                    color: #444444;">

                                                </div>
                                                <div class="col-md-2 changeColStyle pl-2">
                                                    <label for=""> To Date</label>
                                                    <input name="to" autocomplete="off" value="{{$to}}" type="text" class="form-controll datepicker"  placeholder="dd/mm/yyyy" style="width: 100% !important;
                                                    border: 1px solid #dfe3e7;
                                                    height: 32px;
                                                    border-radius: 3px;
                                                    color: #444444;">

                                                </div>
                                                <div class="col-md-2 changeColStyle text-left pr-1 mt-2">
                                                    <button type="submit" class="btn btn-primary formButton mSearchingBotton" style="height: 32px" title="Searching">
                                                        <div class="d-flex">
                                                            <div class="formSaveIcon" style="margin-left: -10px;">
                                                                <img  src="{{asset('assets/backend/app-assets/icon/searching-icon.png')}}" alt="" srcset=""  width="25">
                                                            </div>
                                                            <div><span> Search</span></div>
                                                        </div>
                                                    </button>
                                                </div>
                                                <div class="col-md-1"></div>
                                                <div class="col-md-2 text-right mt-2">
                                                    <button type="button" class="btn mPrint formButton" title="Print" onclick="window.print()">
                                                        <div class="d-flex">
                                                            <div class="formSaveIcon">
                                                                <img src="{{asset('assets/backend/app-assets/icon/print-icon.png')}}" width="25">
                                                            </div>
                                                            <div><span>Print</span></div>
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </section>
                                <h1 class="conpany-header text-center">Driver Name: {{$driver_info?$driver_info->full_name:''}}</h1>
                                <div class="card-body ">
                                    <div class="table-responsive" style="min-height: 300px">
                                        <table class="table mb-0 table-sm text-center">
                                            <thead class="thead-light">
                                                <tr style="height: 50px;">
                                                    <th>SI NO</th>

                                                    <th>Date</th>
                                                    <th>Truck NO</th>
                                                    <th>Trip NO</th>
                                                    <th>MATERIAL</th>
                                                    <th>CRUSHER/SOURCE</th>
                                                    <th>DESTINATION</th>
                                                    <th>WGT</th>
                                                    <th>RATE</th>
                                                    <th>COMMISSION</th>
                                                    <th>TOLL FEE</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-sm">
                                                @foreach ($services as $key=> $item)
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{date('d/m/Y', strtotime($item->date))}}</td>
                                                        <td>{{$item->truck->vehicle_number}}</td>
                                                        <td>{{$item->serial_no}}</td>
                                                        <td>{{$item->material}}</td>
                                                        <td>{{$item->crusher}}</td>
                                                        <td>{{$item->destination}}</td>
                                                        <td>{{$item->weight}}</td>
                                                        <td>{{$item->rate}}</td>
                                                        <td>{{number_format($item->commision,2)}}</td>
                                                        <td>{{number_format($item->too_fee,2)}}</td>
                                                    </tr>

                                                @endforeach
                                                <tr>

                                                    <td colspan="9" class="text-right">TOTAL COMMISSION</td>
                                                    @if(!empty($services))
                                                        <td>{{ number_format($services->sum('commision'), 2) }}</td>
                                                    @else
                                                        <td>0.00</td>
                                                    @endif
                                                <td></td>
                                                </tr>
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


@endsection
@push('js')

@endpush
