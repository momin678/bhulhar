@extends('layouts.backend.app')
@section('content')
<style>
    .table thead th {
    color: #ffffff !important;
    text-align: center;

  }
  .mini-width {
    min-width: 100px !important;
    max-width: 100px !important;
  }
  .mini-width-input {
    min-width: 100px !important;
    max-width: 100px !important;
  }
  .semi-mini-width{
    min-width: 150px !important;
    max-width: 150px !important;
  }
  .semi-mini-width-input{
    min-width: 150px !important;
    max-width: 150px !important;
  }
  .table-sm th, .table-sm td {
    padding: 0.01rem !important;
  }
  input, select {
    height: 25px !important;
  }
  .select2 .select2-container .select2-container--default .select2-container--focus{
    height: 25px !important;
  }
</style>
@php
    $emirates=array('Abu Dhabi','Ajman','Dubai','Fujairah','Ras Al Khaimah','Sharjah','Umm Al Quwain');
    $languages= array('Bangla','English','Urdu','Arabic','Hindi');
@endphp
@include('layouts.backend.partial.style')
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <form class="form form-vertical" action="{{route('excel-product-save')}}" method="POST" enctype="multipart/form-data" >
                @csrf
            <div>
                <table class="table mb-0 table-sm table-hover table-bordered">
                    <thead  class="" style="position:sticky; background: #1a233a;">
                        <tr style="height: 30px;">
                            <th class="semi-mini-width">Category NAME <span class="text-danger">*</span></th>
                            <th class="semi-mini-width">Vehicle Brand <span class="text-danger">*</span></th>
                            <th class="semi-mini-width">Vehicle Name <span class="text-danger">*</span></th>
                            <th class="semi-mini-width">Vehicle Model <span class="text-danger">*</span></th>
                            <th class="semi-mini-width">Item Code <span class="text-danger">*</span></th>
                            <th class="mini-width">Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-sm">
                      @foreach ($products as $product)
                        <tr  id="{{'tr'.$product->id}}" class="parent_tr">
                            <input name="product_id[]" type="hidden" value="{{$product->id}}">
                            <td><input name="category[]" type="text" value="{{$product->category}}" class="{{$product->category?'':'error'}}" required placeholder="Category"></td>
                            <td><input name="vehicle_brand[]" type="text" value="{{$product->vehicle_brand}}" placeholder="Vehicle brand"></td>
                            <td><input name="vehicle_name[]" type="text" value="{{$product->vehicle_name}}" class="{{$product->vehicle_name?'':'error'}}" required placeholder="Vehicle name"></td>
                            <td><input name="vehicle_model[]" type="text" value="{{$product->vehicle_model}}" placeholder="Vehicle model" required class="{{$product->vehicle_model?'':'error'}}"></td>
                            <td><input name="item_code[]" type="text" value="{{$product->item_code}}" placeholder="Item code" required class="{{$product->item_code?'':'error'}}"></td>
                            <td>
                                <a href="#" class="btn excel-import-delete" title="Delete" onclick="return confirm('Are you sure to delete this?')" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;" id="{{$product->id}}">
                                    <img src="{{asset('assets/backend/app-assets/icon/delete-icon.png')}}" style=" height: 30px; width: 30px;">
                                </a>
                            </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
            {{-- onclick="return confirm('Are your sure to submit !')" --}}
            <div class="row">
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary btn_create formButton mr-1 mt-2" title="Add" id="excel_review_submit">
                        <div class="d-flex">
                            <div class="formSaveIcon">
                                <img src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" width="25">
                            </div>
                            <div><span>Save</span></div>
                        </div>
                    </button>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>

@endsection
@push('js')
    <script>
        $(document).on('click','.excel-import-delete', function(e){
          var id = $(this).attr('id');
          var _token = $('input[name="_token"]').val();
          $.ajax({
              method: "post",
              url: "{{route('delete-excel-product-entry')}}",
              data: {
                  id:id,
                  _token: _token,
              },
              success: function (response) {
                  if(response ==1){
                    $('#tr'+id).remove();
                  }
              }
          });
      });
    </script>
@endpush
