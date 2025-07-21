

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
                @include('backend.product.sub-header',['activeMenu' => 'brand'])
                <div class="tab-pane active">
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="cardStyleChange p-1">
                                <section id="widgets-Statistics" class="mr-1 ml-1 mb-1">
                                    <div class="row">
                                        <div class="col-md-6 pl-2">
                                            <h4> Brand Information </h4>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-left: 10px; padding-right: 10px">
                                        <div class="col-12">
                                            @if($brand->name)
                                            <form action="{{route('brand.update',$brand->id) }}" method="POST">
                                                @method('PUT')
                                            @else
                                            <form action="{{  route('brand.store') }}" method="POST">
                                            @endif
                                                @csrf
                                                <div class="row match-height">
                                                    <div class="col-md-6">
                                                        <label for="">Brand Name</label>
                                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$brand->name) }}">
                                                        @error('name')
                                                        <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="col-6 text-right mt-2">
                                                        <button type="submit" class="btn mr-1 btn-primary formButton" title="Form Save">
                                                            <div class="d-flex">
                                                                <div class="formSaveIcon">
                                                                    <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                                </div>
                                                                <div><span> Save</span></div>
                                                            </div>
                                                        </button>
                                                        <a href="{{ route('brand.index') }}" class="btn btn-light-secondary formButton" title="Form Reset">
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
                                                        <th class="pl-1"> Brand Name </th>

                                                        <th class="text-right pr-1">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="user-table-body">
                                                    @foreach ($brands as $brand)
                                                    <tr class="trFontSize">

                                                        <tr  class="data-row">
                                                            <td class="px-1">{{ $brand->name }}</td>
                                                            <td class="text-right pr-2" style="padding-bottom: 11px; padding-top: 0px">
                                                                <a href="{{ route('brand.edit', $brand->id) }}" class="btn" style="height: 30px; width: 30px;" title="Eidt"><img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;"></a>
                                                                {{-- <form action="{{ route('brand.destroy', $brand->id) }}" method="POST">
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

