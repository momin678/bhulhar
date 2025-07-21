@php
    use Carbon\CarbonPeriod;
@endphp
@extends('layouts.backend.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@endpush
@section('title', 'employee-salary')
@section('content')
@include('layouts.backend.partial.style')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="tab-content  cardStyleChange">
                <section id="widgets-Statistics" class="mr-1 ml-1">
                    <div class="row">
                        <div class="col-md-6 mt-2 mb-2">
                            <h4>Employee Salary Process</h4>
                        </div>
                    </div>
                        <form class="form form-vertical" action="{{route('salary-process-start')}}" method="get" enctype="multipart/form-data">
                            <div class="cardStyleChange">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4  mt-2">
                                                <button type="submit" class="btn btn-primary btn_create formButton" title="Create Salary Sheet" >
                                                    <div class="d-flex">
                                                        <div class="formSaveIcon">
                                                            <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" width="25">
                                                        </div>
                                                        <div><span>Generate salary of the </span></div>
                                                    </div>
                                                </button>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="class-name">Month</label>
                                                    <select name="month" id="" class="inputFieldHeight form-control" required>
                                                        <option value="">Select month</option> 
                                                        @foreach(CarbonPeriod::create(now()->startOfMonth(), '1 month', now()->addMonths(11)->startOfMonth()) as $date)   
                                                        <option value="{{ $date->format('F') }}" {{$date->format('F') == Date('F')?'selected':''}}>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                </section>
                <section class="m-1">
                    <div class="cardStyleChange table-responsive">
                        <table class="table mb-0 table-sm table-hover">
                            <thead class="thead-light">
                                <tr style="height: 50px;">
                                    <th>Name</th>
                                    <th>Total</th>
                                    <th class="text-right pr-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($employeeSalarys) > 0)
                                    @foreach ($employees as $item)
                                        <tr  class="data-row">
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->total}}</td>
                                            <td style="padding-bottom: 11px; padding-top: 0px" class="text-right pr-2">
                                                <a href="{{route('salary-process.edit', $item->id)}}" class="btn" style="height: 30px; width: 30px;" title="Eidt">
                                                    <img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;">
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                @foreach ($employees as $item)
                                    <tr  class="data-row">
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->total}}</td>
                                        <td style="padding-bottom: 11px; padding-top: 0px" class="text-right pr-2">
                                            <a href="{{route('salary-process.edit', $item->id)}}" class="btn" style="height: 30px; width: 30px;" title="Eidt">
                                                <img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;">
                                            </a>
                                            
                                            {{-- <a href="" class="btn" style="height: 30px; width: 30px;" title="Delete">
                                                <form action="{{ route('employee-salary.destroy', $item->id) }}" method="POST" class="flot-right">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn" onclick="return confirm('Confirm?')" style="padding-top: 0px; padding-left:0px;">
                                                        <img src="{{ asset('assets/backend/app-assets/icon/delete-icon.png')}}" style="height: 32px; width: 32px; margin-left: -12px;">
                                                    </button>
                                                </form>
                                            </a> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
                <div class="row float-right">
                    {{-- <div class="col-md-3  mt-2 float-right">
                        <a href="{{route('salary-process-start')}}">
                        <button type="button" class="btn btn-primary btn_create formButton" title="Create Salary Sheet" >
                            <div class="d-flex">
                                <div class="formSaveIcon">
                                    <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" width="25">
                                </div>
                                <div><span>Start salary Process </span></div>
                            </div>
                        </button>
                        </a>
                    </div> --}}
                    <div class="col-md-3  mt-2 float-right">
                        <a href="{{route('salary-process-confirm')}}">
                        <button type="button" class="btn btn-success btn_create formButton" title="Create Salary Sheet" >
                            <div class="d-flex">
                                <div class="formSaveIcon">
                                    <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" width="25">
                                </div>
                                <div><span>Confirm</span></div>
                            </div>
                        </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('js')
<script>
    // for sum when it load
       
    //finish sum

    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN':'{{ csrf_token() }}'
        }
    });

  sum();

    $(document).on("keyup", ".each-item", function(e) {
        sum();

    });

    $(document).on("keyup", ".sub-item", function(e) {
        sum();

    });
    //employee name select
    $(document).on("keyup", "#employee_id", function(e) {
                if ($(this).val() != '') {
                var emp = $(this).val();
                // alert(category);
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('employee-name') }}",
                    method: "GET",
                    data: {
                        emp: emp,
                        _token: _token,
                    },
                    success: function(response) {
                        console.log(response);
                        $("div.emp-select select").val(response.page.id).change();
                        $("#wages_type").val(response.wages);
                    }
                })
            }
            });
    //end employee name select

    $(document).on("change", "#emp_name", function(e) {
                if ($(this).val() != '') {
                var emp = $(this).val();
                // alert(category);
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('employee-name') }}",
                    method: "GET",
                    data: {
                        emp: emp,
                        _token: _token,
                    },
                    success: function(response) {
                        console.log(response);
                        $("#employee_id").val(response.page.id);
                        $("#wages_type").val(response.wages);
                    }
                })
            }
            });

    $('#basic').keyup(function() {
                if ($(this).val() != '') {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('percentCount') }}",
                        method: "POST",
                        data: {
                            value: value,
                            _token: _token,
                        },
                        success: function(response) {
                            // alart($(this).val());
                            // alert(response.infos.id);
                            for (var i=0; i<response.infos.length; i++) {
                                    var values = (response.value / 100) * response.infos[i]['value'];
                                    // var idd = '#'.response.infos[i]['head'];
                                    // alert(values);
                                    // alert("#"+ response.infos[i]['head']+"");
                                    $("#"+ response.infos[i]['id']+"").val(values);
                                }
                            sum();
                        }
                    })
                }
            });

        function sum(){
                var sum = 0;
                $('.each-item').each(function() {
                // parseInt($(this).attr('max'));
                if(this.value != '')
                {

                    sum += parseFloat(this.value);
                }
                });
                $('.sub-item').each(function() {
                // parseInt($(this).attr('max'));
                if(this.value != '')
                {
                    sum -= parseFloat(this.value);
                }
                });
                // alert(sum);
                $("#total").val(sum);
        }
</script>
@endpush