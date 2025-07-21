@extends('layouts.backend.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />

@endpush
@section('title', 'Category')
@section('content')
    @include('layouts.backend.partial.style')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">

            <div class="content-body">
                @include('backend.product.top-header', ['activeMenu' => 'product-list'])
                <!-- Widgets Statistics start -->
                <div class="tab-content">
                    <div class="tab-pane bg-white active">
                        <div class="py-1 px-2">
                            @include('backend.product.bottom-header', ['activeMenu' => 'vehicle-name',])
                        </div>
                        <section id="widgets-Statistics">
                            <div class="row">
                                <div class="col-12">
                                    <div class="">
                                        <div class="card-body cardStyleChange">
                                            <form action="{{route('vehicle-name.update',$vehicle_name) }}" method="POST" enctype="multipart/form-data">
                                                @method('PATCH')
                                                @csrf
                                                <div class="row match-height">

                                                    <div class="col-md-6">
                                                        <label for="">Vehicle Name</label>
                                                        <input type="text" name="name" class="form-control inputFieldHeight" value="{{ isset($vehicle_name)?$vehicle_name->name:"" }}" required>
                                                    </div>

                                                    <div class="col-md-5 d-none">
                                                        <label for="">Vehicle Brand</label>
                                                        <select  name="brand_id" id="brand_id" class="common-select2" style="width: 100% !important">
                                                            <option value="">Select......</option>
                                                            @foreach ($brands as $brand)
                                                                <option value="{{$brand->id}}" {{$brand->id==$vehicle_name->brand_id?'selected':''}}>{{$brand->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6 d-flex justify-content-end mt-2">
                                                        <button type="submit" class="btn btn-primary btn-sm mr-1">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                        <table class="table table-sm table-bordered mt-1">
                                            <thead class="user-table-body">
                                                <tr>
                                                    <th>Vehicle Name</th>
                                                    {{-- <th>Vehicle Brand</th> --}}
                                                    <th style="width: 100px">Action</th>
                                                </tr>
                                            </thead>        
                                            <tbody class="user-table-body">
                                                @foreach ($vehicle_names as $vehicle_name)
                                                    <tr  class="data-row">
                                                        <td>{{ $vehicle_name->name }}</td>
                                                        {{-- <td>{{ $vehicle_name->brand->name }}</td> --}}
                                                        <td style="white-space: nowrap">
                                                            <a href="{{route('vehicle-name.edit', $vehicle_name->id)}}"><i class="bx bx-edit"></i></a>
                                                        </td>
                                                    </tr>        
                                                @endforeach
                                            </tbody>
        
        
                                        </table>
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
<!-- END: Content-->
@endsection

@push('js')
<script src="{{ asset('assets/backend')}}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="{{ asset('assets/backend')}}/app-assets/js/scripts/forms/select/form-select2.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>

<script>
    $(document).ready(function() {
        // $('.common-select2').select2();
        // document.getElementById('reset').onclick = function(){
        //     var select = document.getElementById('selectElement');
        //     var value = select.options[select.selectedIndex].value;
        //     console.log(value);
        //     document.getElementById("selectElement").innerHTML = "";
        // }
    });
</script>
@endpush
