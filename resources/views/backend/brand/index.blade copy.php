@extends('layouts.backend.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
<style>
    th {
        text-align: center !important;
    }

    td {
        text-align: center !important;
    }
</style>

@endpush
@section('title', 'Brand')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">

            <div class="content-body">
                <!-- Widgets Statistics start -->
                <section id="widgets-Statistics">
                  <div class="row">
                      <div class="col-12">
                          <div class="card">
                            <div class="d-flex justify-content-between align-items-center pr-4 py-2">
                                <h4 class="content-title">Category Information</h4>
                                <button type="button" class="mt-1 btn btn-primary btn-sm" data-toggle="modal" data-target="#addUnitModal"> Create Unit </button>

                                <!-- Add Unit Modal Form -->
                                @include('backend.brand.addUnit')
                            </div>
                              <div class="card-body content-padding">
                                {{-- {{ $category }} --}}
                                @if(isset($category))
                                <form action="{{route('category.update',$category) }}" method="POST" enctype="multipart/form-data">
                                    @method('PATCH')
                                @else
                                <form action="{{  route('category.store') }}" method="POST" enctype="multipart/form-data">
                                @endif
                                    @csrf
                                    <div class="row match-height">

                                        <div class="col-md-6">
                                            <label for="">Category Name</label>
                                            <input type="text" name="name" class="form-control" value="{{ isset($category)?$category->name:"" }}" required>
                                        </div>

                                        <div class="col-6 d-flex justify-content-end mt-1">
                                            <button type="submit" class="btn btn-primary btn-sm mr-1">Submit</button>
                                            <button type="reset" class="btn mr-1 btn-sm" id="reset">Reset</button>
                                        </div>
                                    </div>
                                </form>
                              </div>
                          </div>
                      </div>
                  </div>

                <div class="table-responsive card">
                    <table class="table table-sm table-bordered">
                        <thead class="user-table-body">
                        <tr>
                            <th>Name</th>
                            <th>Description</th>

                        </tr>
                        </thead>

                        <tbody class="user-table-body">

                           @foreach ($categories as $cat)
                                <tr>
                                    <th colspan="2">Category: {{ $cat->name }} <a class="bx bx-edit" href="{{route('category.edit', $cat->id)}}"></a></th>
                                </tr>
                                <tr>
                                    <th> <a href="" class="btn btn-info btn-sm brandAdd" id="{{$cat->id}}"  title="Preview">Add Vehicle Brand</a></th>
                                    <th></th>
                                </tr>

                                @foreach ($cat->brands as $brand)
                                    <tr  class="data-row">
                                        <td rowspan="{{ $brand->vehicle_name()->count()+1 }}">{{ $brand->name }} <a class="bx bx-edit editBrand" ids="{{ $brand->id }}"></a>  <a class="bx bx-trash" href="{{ route('brand.delete',$brand) }}"></a>  </td>
                                        <td style="text-align: left !important;"><a href="" class="btn btn-info btn-sm text-left add_vehicle_name" id="{{$brand->id}}"  title="Preview">Add Vehicle Name</a></td>
                                    </tr>
                                    @foreach ($brand->vehicle_name as $vehicle_name)
                                        <tr>
                                            <td><p style="text-align: left !important;margin-bottom: 0px !important">{{ $vehicle_name->name }}</p>
                                                <a href="#" class="btn btn-info btn-sm text-center subBrandAdd"  style="text-align: center !important;" id="{{$vehicle_name->id}}"  title="Preview">Add Vehicle Model</a><br>
                                                @foreach ($vehicle_name->vehicle_model as $vehicle_model)
                                                    <p class="text-center" style="margin-bottom: 0px !important">
                                                        {{$vehicle_model->name}} <br>
                                                        <p class="pr-2 item_code_add"  style="text-align: right !important;margin-bottom: 0px !important" id="{{$vehicle_model->id}}"  title="Preview"><span style="background: #68678b70; padding: 5px; cursor: pointer;">Add Item Code</span></p>
                                                        @foreach ($vehicle_model->item_code as $item_code)
                                                            <p class="text-right pr-1" style="margin-bottom: 0px !important"><span>{{$item_code->name}}</span></p>
                                                        @endforeach
                                                    </p>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach

                           @endforeach
                        </tbody>


                    </table>

                </div>
                <div class="row">
                    <div class="col-12 text-right">
                        {{-- {{$categories->links()}} --}}
                    </div>
                </div>
                </section>
                <!-- Widgets Statistics End -->



            </div>
        </div>
    </div>
    <!-- END: Content-->

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

        $(document).on("click", ".brandAdd", function(e) {
            e.preventDefault();
            var id= $(this).attr('id');
            $.ajax({
                url: "{{URL('brand-add-modal')}}",
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

        $(document).on("click", ".editBrand", function(e) {
            e.preventDefault();
            var id= $(this).attr('ids');
            $.ajax({
                url: "{{URL('brand-edit-modal')}}",
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
        $(document).on("change", "#sub_brand_name", function(e) {
            e.preventDefault();
            var name= $(this).val();
            $.ajax({
                url: "{{URL('check-exit-sub-brand-name')}}",
                type: "post",
                cache: false,
                data:{
                    _token:'{{ csrf_token() }}',
                    name:name,
                },
                success: function(response){
                    if(response.error){
                        $("#sub_brand_submit").disabled = true;
                        toastr.error(response.error);
                    }else{
                        $("#sub_brand_submit").disabled = true;
                    }
                }
            });
        });
        $(document).on("click", ".add_vehicle_name", function(e) {
            e.preventDefault();
            var brand_id= $(this).attr('id');
            $.ajax({
                url: "{{URL('add-vehicle-name')}}",
                type: "post",
                data:{
                    _token:'{{ csrf_token() }}',
                    brand_id:brand_id,
                },
                success: function(response){
                    console.log(response)
                    document.getElementById("addSubBrand").innerHTML = response;
                    $('#voucherPreviewModal').modal('show')
                }
            });
        });
        $(document).on("click", ".item_code_add", function(e) {
            e.preventDefault();
            var id= $(this).attr('id');
            $.ajax({
                url: "{{URL('item-code-add')}}",
                type: "post",
                data:{
                    _token:'{{ csrf_token() }}',
                    id:id,
                },
                success: function(response){
                    console.log(response)
                    document.getElementById("addSubBrand").innerHTML = response;
                    $('#voucherPreviewModal').modal('show')
                }
            });
        });
    });
</script>
@endpush
