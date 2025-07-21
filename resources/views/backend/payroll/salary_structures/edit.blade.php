@extends('layouts.backend.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@endpush
@section('title', 'salary-structures')
@section('content')
@include('layouts.backend.partial.style')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="tab-content card cardStyleChange">
                <section id="widgets-Statistics" class="mr-1 ml-1">
                    <div class="row">
                        <div class="col-md-6 mt-2 mb-2">
                            <h4>Salary Component </h4>
                        </div>
                    </div>
                    <div class="row" style="padding-left: 10px; padding-right: 10px">
                        <div class="col-12">
                            <form action="{{route('salary-structures.update', $salaryStructures_info->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="cardStyleChange">
                                    <div class="row">
                                        <div class="col-sm-2 col-12 changeColStyle">
                                            <label for="mode">Head</label>
                                            <input type="text" class="form-control inputFieldHeight each-item" name="head" id="head" value="{{$salaryStructures_info->head}}" required>
                                        </div>
                                        <div class="col-sm-2 col-12 changeColStyle">
                                            <label for="mode">Type <sup class="text-danger">*</sup></label>
                                            <select name="type" id="type" class="form-control common-select2" style="width: 100% !important"  required>
                                                <option value=""></option>
                                                <option value="%" {{ ($salaryStructures_info->type == '%')?'selected':'' }}>Percent</option>
                                                <option value="flat" {{ ($salaryStructures_info->type == 'flat')?'selected':'' }}>Flat</option>
                                                <option value="none" {{ ($salaryStructures_info->type == 'none')?'selected':'' }}>none</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2 col-12 changeColStyle">
                                            <label for="mode">Value</label>
                                            <input type="text" class="form-control inputFieldHeight each-item" name="value" id="value" value="{{$salaryStructures_info->value}}">
                                        </div>
                                        <div class="col-12 col-md-12 d-flex justify-content-end changeColStyle mb-1 mt-1">
                                            <button type="submit" class="btn btn-primary formButton" title="Form Save">
                                                <div class="d-flex">
                                                    <div class="formSaveIcon">
                                                        <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                    </div>
                                                    <div><span> Update</span></div>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
                <section class="m-1">
                    <div class="cardStyleChange table-responsive">
                        <table class="table mb-0 table-sm table-hover">
                            <thead class="thead-light">
                                <tr style="height: 50px;">
                                    <th>Head</th>
                                    <th>Type</th>
                                    <th>Value</th>
                                    <th class="text-right pr-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($salaryStructures as $item)
                                    <tr  class="data-row">
                                        <td>{{$item->head}}</td>
                                        <td>{{$item->type}}</td>
                                        <td>{{$item->value}}</td>
                                        <td style="padding-bottom: 11px; padding-top: 0px" class="text-right pr-2">
                                            <a href="{{route('salary-structures.edit', $item->id)}}" class="btn" style="height: 30px; width: 30px;" title="Eidt">
                                                <img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;">
                                            </a>
                                            
                                            {{-- <a href="" class="btn" style="height: 30px; width: 30px;" title="Delete">
                                                <form action="{{ route('salary-structures.destroy', $item->id) }}" method="POST" class="flot-right">
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
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('js')
<script>
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN':'{{ csrf_token() }}'
        }
    });

    //sum of all field
    $(document).on("keyup", ".each-item", function(e) {
        var sum = 0;
        $('.each-item').each(function() {
        // parseInt($(this).attr('max'));
        if(this.value != '')
        {
            sum += parseFloat(this.value);
        }
        });
        // alert(sum);
        $("#total").val(sum);

    });
</script>
@endpush