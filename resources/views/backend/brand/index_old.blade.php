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
                            <div class="content-title">
                                <h4>Category Information</h4>
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
                            <th colspan="2"> <a href="" class="btn btn-info btn-sm btn-block brandAdd" id="{{$cat->id}}"  title="Preview">Add Brand</a></th>
                        </tr>

                           @foreach ($cat->brands as $brand)
                           <tr  class="data-row">
                               <td rowspan="{{ $brand->subBrands()->count()+1 }}">{{ $brand->name }} <a class="bx bx-edit editBrand" ids="{{ $brand->id }}"></a>  <a class="bx bx-trash" href="{{ route('brand.delete',$brand) }}"></a>  </td>
                               <td><a href="" class="btn btn-info btn-sm btn-block subBrandAdd" id="{{$brand->id}}"  title="Preview">Add Description</a></td>
                               {{-- <td style="white-space: nowrap">
                                   <a href="{{route('brand.edit', $brand->id)}}" class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                   <a href="">
                                       <form action="{{ route('brand.destroy', $brand->id) }}" method="POST">
                                           @csrf
                                           @method('DELETE')
                                           <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Confirm?')" ><i class="bx bx-trash"></i></button>
                                       </form>
                                   </a>
                               </td> --}}
                           </tr>
                          @foreach ($brand->subBrands as $item)
                          <tr>
                           <td>{{ $item->name }}  <a class="bx bx-trash" href="{{ route('subBrand.delete',$item) }}"></a> </td>
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
    });
</script>
@endpush
