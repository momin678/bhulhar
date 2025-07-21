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
                            @include('backend.product.bottom-header', ['activeMenu' => 'item-code',])
                        </div>
                        <section id="widgets-Statistics">
                            <div class="row">
                                <div class="col-12">
                                    <div class="">
                                        <div class="card-body cardStyleChange">
                                            <form action="{{  route('item-code.store') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row match-height">
                                                    <div class="col-md-3">
                                                        <label for="">Item Code</label>
                                                        <input type="text" name="name" class="form-control inputFieldHeight" value="{{old('name')}}" required placeholder="Item Code">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">Category</label>
                                                        <select  name="category_id" id="category_id" class="common-select2" style="width: 100% !important" required>
                                                            <option value="">Select......</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">Vehicle Brand</label>
                                                        <select  name="brand_id" id="brand_id" class="common-select2" style="width: 100% !important" required>
                                                            <option value="">Select......</option>
                                                            @foreach ($brands as $brand)
                                                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">Vehicle Name</label>
                                                        <select  name="vehicle_name_id" id="vehicle_name_id" class="common-select2" style="width: 100% !important" required>
                                                            <option value="">Select......</option>
                                                            @foreach ($vehicle_names as $vehicle_name)
                                                                <option value="{{$vehicle_name->id}}">{{$vehicle_name->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">Vehicle Model</label>
                                                        <select  name="vehicle_model_id" id="vehicle_model_id" class="common-select2" style="width: 100% !important" required>
                                                            <option value="">Select......</option>
                                                            @foreach ($vehicle_models as $vehicle_model)
                                                                <option value="{{$vehicle_model->id}}">{{$vehicle_model->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">Sale Price</label>
                                                        <input type="text" name="sale_price" class="form-control inputFieldHeight" value="{{old('sale_pice')}}" placeholder="Sale Price">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">Unit</label>
                                                        <select  name="unit_id" id="unit_id" class="common-select2" style="width: 100% !important" required>
                                                            <option value="">Select......</option>
                                                            @foreach ($units as $unit)
                                                                <option value="{{$unit->id}}" {{old('unit_id')==$unit->id?'selected':''}}>{{$unit->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 d-flex justify-content-end mt-2">
                                                        <button type="submit" class="btn btn-primary btn-sm mr-1">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                            <table class="table table-sm table-bordered mt-1">
                                                <thead class="user-table-body">
                                                <tr>
                                                    <th>Category</th>
                                                    <th>Vehicle Brand</th>
                                                    <th>Vehicle Name</th>
                                                    <th>Vehicle Model</th>
                                                    <th>Item Code</th>
                                                    <th>Unit</th>
                                                    <th>Sale Price</th>
                                                    <th style="width: 100px">Action</th>
                                                </tr>
                                                </thead>
            
                                                <tbody class="user-table-body">
                                                    @foreach ($item_codes as $item_code)
                                                    <tr  class="data-row">
                                                        <td>{{ $item_code->category->name }}</td>
                                                        <td>{{ $item_code->brand->name }}</td>
                                                        <td>{{ $item_code->vehicle_name->name }}</td>
                                                        <td>{{ $item_code->subBrand->name }}</td>
                                                        <td>{{ $item_code->name }}</td>
                                                        <td>{{ $item_code->unit->name }}</td>
                                                        <td>{{ $item_code->sale_price }}</td>
                                                        <td style="white-space: nowrap">
                                                            <a href="{{route('item-code.edit', $item_code->id)}}"><i class="bx bx-edit"></i></a>
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
