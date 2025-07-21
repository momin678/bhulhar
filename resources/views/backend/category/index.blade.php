

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
                @include('backend.product.sub-header',['activeMenu' => 'category'])
                <div class="tab-pane active">
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="cardStyleChange p-1">
                                <section id="widgets-Statistics" class="mr-1 ml-1 mb-1">
                                    <div class="row">
                                        <div class="col-md-6 pl-2">
                                            <h4>Category Information</h4>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-left: 10px; padding-right: 10px">
                                        <div class="col-12">
                                            @if($category->name)
                                            <form action="{{route('category.update',$category->id) }}" method="POST" enctype="multipart/form-data">
                                                    @method('PUT')
                                            @else
                                            <form action="{{  route('category.store') }}" method="POST" enctype="multipart/form-data">
                                            @endif
                                                @csrf
                                                <div class="row match-height">

                                                    <div class="col-md-6">
                                                        <label for="">Category Name</label>
                                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$category->name) }}">
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
                                                        <a href="{{ route('category.index') }}" class="btn btn-light-secondary formButton" title="Form Reset">
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
                                                        <th class="pl-1"> Category Name </th>

                                                        <th class="text-right pr-1"> Action </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="user-table-body">
                                                    @foreach ($categories as $cat)
                                                    <tr  class="data-row">
                                                        <td>{{ $cat->name }}</td>

                                                        <td class="text-right pr-2" style="padding-bottom: 11px; padding-top: 0px">
                                                            <a href="{{ route('category.edit', $cat->id) }}" class="btn" style="height: 30px; width: 30px;" title="Eidt"><img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;"></a>
                                                            {{-- <form action="{{ route('category.destroy', $cat->id) }}" method="POST">
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


