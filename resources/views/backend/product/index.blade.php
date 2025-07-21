
@extends('layouts.backend.app')
@section('content')
@include('layouts.backend.partial.style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />

<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @include('clientReport.service-inentory.header', ['activeMenu' => 'spare-parts'])
            <div class="tab-content bg-white">
                @include('backend.product.sub-header',['activeMenu' => 'product'])
                <div class="tab-pane active">
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="cardStyleChange p-1">
                                <section id="widgets-Statistics" class="mr-1 ml-1 mb-1">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4>Products Information</h4>
                                        </div>
                                    </div>
                                    <div class="row" >
                                        <div class="col-12">
                                            @if ($product->name)
                                            <form id="widgets-Statistics"  class="form bg-white" action="{{ route('product.update',$product->id) }}" method="POST">
                                            @method('put')
                                            @else
                                            <form id="widgets-Statistics" class="form bg-white" action="{{ route('product.store') }}" method="POST">
                                            @endif
                                                @csrf
                                                <div class="row match-height">

                                                    <div class="col-12 col-lg-4">
                                                        <div class="form-group">
                                                            <label for="name"> Product Name </label>
                                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name',$product->name) }}"  placeholder="Enter Name" required>
                                                            @error('name')
                                                                <p class="text-danger"> {{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-4">
                                                        <div class="form-group">
                                                            <label for="category_id "> Category </label>
                                                            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                                                <option selected disabled> Select Category </option>
                                                                @foreach ($categories as $category)
                                                                    <option value="{{ $category->id }}" {{ $category->id == old('category_id',$product->category_id) ? 'selected' : ' ' }}> {{ $category->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('category_id')
                                                                <p class="text-danger"> {{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-4">
                                                        <div class="form-group">
                                                            <label for="brand_id "> Brand </label>
                                                            <select name="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                                                                <option selected disabled> Select Brand </option>
                                                                @foreach ($brands as $brand)
                                                                    <option value="{{ $brand->id }}" {{ $brand->id == old('brand_id',$product->brand_id) ? 'selected' : ' ' }}> {{ $brand->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('brand_id')
                                                                <p class="text-danger"> {{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-lg-4">
                                                        <div class="form-group">
                                                            <label for="unit_id"> Unit </label>
                                                            <select name="unit_id" class="form-control @error('unit_id') is-invalid @enderror">
                                                                <option selected disabled> Select Unit </option>
                                                                @foreach ($units as $unit)
                                                                    <option value="{{ $unit->id }}" {{ $unit->id == old('unit_id',$product->unit_id) ? 'selected':' ' }} > {{ $unit->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('unit_id')
                                                                <p class="text-danger"> {{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-lg-4">
                                                        <div class="form-group">
                                                            <label for="sale_price"> Purchase Price </label>
                                                            <input type="text" name="sale_price" value="{{ old('sale_price',$product->sale_price) }}" class="form-control @error('sale_price') is-invalid @enderror" placeholder="Enter Purchase Price">
                                                            @error('sale_price')
                                                                <p class="text-danger"> {{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-4 text-right mt-2">
                                                        <button type="submit" class="btn mr-1 btn-primary formButton" title="Form Save">
                                                            <div class="d-flex">
                                                                <div class="formSaveIcon">
                                                                    <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                                </div>
                                                                <div><span> Save</span></div>
                                                            </div>
                                                        </button>
                                                        <a href="{{ route('product.index') }}" class="btn btn-light-secondary formButton" title="Form Reset">
                                                            <div class="d-flex">
                                                                <div class="formRefreshIcon">
                                                                    <img  src="{{asset('assets/backend/app-assets/icon/refresh-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                                </div>
                                                                <div><span> Reset</span></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </section>

                                <section class="mr-1 ml-1 bg-white">
                                    <div class="mt-2">
                                        <div class="cardStyleChange">
                                            <table class="table mb-0 table-sm table-hover">
                                                <thead  class="thead-light">
                                                    <tr style="height: 50px;">
                                                        <th class="pl-1"> Product </th>
                                                        <th class=""> Category </th>
                                                        <th class=""> Brand </th>
                                                        <th class=""> Unit </th>
                                                        <th class=""> Price </th>
                                                        <th class="text-right pr-1"> Action </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="user-table-body">
                                                    @foreach ($products as $product)
                                                    <tr class="data-row">
                                                        <td class="pl-1">{{ $product->name }}</td>
                                                        <td> {{ $product->category->name }}</td>
                                                        <td> {{ $product->brand?$product->brand->name:'' }} </td>
                                                        <td> {{ $product->unit->name }} </td>
                                                        <td> {{ $product->sale_price }} </td>
                                                        <td class="text-right pr-2" style="padding-bottom: 11px; padding-top: 0px">
                                                            <a href="{{ route('product.edit', $product->id) }}" class="btn" style="height: 30px; width: 30px;" title="Eidt"><img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;"></a>
                                                            {{-- <form action="{{ route('product.destroy', $product->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" onclick="return confirm('about to delete master account. Please, Confirm?')"  class="btn" style="height: 30px; width: 30px;" title="Delete"><img src="{{ asset('assets/backend/app-assets/icon/delete-icon.png')}}" style=" height: 30px; width: 30px; margin-left: -12px;"></button>
                                                            </form> --}}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </section>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="voucherPreviewModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div id="addSubBrand">

        </div>
      </div>
    </div>
</div>
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

        $(document).on("click", ".subBrandAdd", function(e) {
        e.preventDefault();
        var id= $(this).attr('id');
		$.ajax({
			url: "{{URL('sub-brand-add-modal')}}",
			type: "post",
			cache: false,
			data:{
				_token:'{{ csrf_token() }}',
                id:id,
			},
			success: function(response){
                document.getElementById("addSubBrand").innerHTML = response;
                $('#voucherPreviewModal').modal('show')
			}
		});
	});


    $(document).on("change", "#brand", function(e) {
            if ($(this).val() != '') {
                var brand = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('sub_brand.fetch') }}",
                    method: "POST",
                    data: {
                        brand: brand,
                        _token: _token,
                    },
                    success: function(response) {
                        $("#sub_brand").empty().append(response.page);
                    }
                })
            }
            });

            $(document).on("change", "#category", function(e) {
                if ($(this).val() != '') {
                var category = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('brand.fetch') }}",
                    method: "POST",
                    data: {
                        category: category,
                        _token: _token,
                    },
                    success: function(response) {
                        // alert(response);
                        $("#brand2").empty().append(response.page);
                        $("#sub_brand2").empty();
                    }
                })
            }
            });
    });
</script>
@endpush


