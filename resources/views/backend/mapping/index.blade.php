@extends('layouts.backend.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@endpush
@section('title', 'mapping')
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
                            <h4>Mapping</h4>
                        </div>
                    </div>
                    <div class="row" style="padding-left: 10px; padding-right: 10px">
                        <div class="col-12">
                            <form action="{{route('mapping.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="cardStyleChange">
                                    <div class="row">
                                        <div class="col-sm-3 col-12 changeColStyle">
                                            <label for="txn">TXN TYPE</label>
                                            <select name="fld_txn_type" id="txn" class="form-control common-select2" style="width: 100% !important" required>
                                                <option value=""></option>
                                                <option value="sale">Sale</option>
                                                <option value="purchase">Purchase</option>
                                                <option value="vat">VAT</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3 col-12changeColStyle">
                                            <label for="mode">MODE</label>
                                            <select name="fld_txn_mode" id="mode" class="form-control common-select2" style="width: 100% !important">
                                                <option value=""></option>
                                                <option value="cash" required>Cash</option>
                                                <option value="credit">Credit</option>
                                                <option value="vat">VAT</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2 col-12 changeColStyle">
                                            <label for="mode">A/C CODE</label>
                                            <input type="text" class="form-control inputFieldHeight" name="fld_ac_code" id="fld_ac_code">
                                        </div>
                                        <div class="col-sm-4 col-12 changeColStyle">
                                            <label for="mode">Account Head</label>
                                            <select name="fld_ac_name" id="fld_ac_name" class="form-control common-select2" style="width: 100% !important">
                                                <option value=""></option>
                                                @foreach ($accoutHeads as $accoutHead)
                                                    <option value="{{$accoutHead->id}}">{{$accoutHead->fld_ac_head}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-12 d-flex justify-content-end changeColStyle mb-1 mt-1">
                                            <button type="submit" class="btn mr-1 btn-primary formButton" title="Form Save">
                                                <div class="d-flex">
                                                    <div class="formSaveIcon">
                                                        <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                    </div>
                                                    <div><span> Save</span></div>
                                                </div>
                                            </button>
                                            <button type="reset" class="btn btn-light-secondary formButton" title="Form Reset">
                                                <div class="d-flex">
                                                    <div class="formRefreshIcon">
                                                        <img  src="{{asset('assets/backend/app-assets/icon/refresh-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                    </div>
                                                    <div><span> Reset</span></div>
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
                    <div class="cardStyleChange">
                        <table class="table mb-0 table-sm table-hover">
                            <thead class="thead-light">
                                <tr style="height: 50px;">
                                    <th>TXN Type</th>
                                    <th>MODE</th>
                                    <th>A/C CODE</th>
                                    <th>Account Head</th>
                                    <th class="text-right pr-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mapping as $item)
                                    <tr  class="data-row">
                                        <td>{{$item->fld_txn_type}}</td>
                                        <td>{{$item->fld_txn_mode}}</td>
                                        <td>{{$item->fld_ac_code}}</td>
                                        <td>{{$item->accountHead?$item->accountHead->fld_ac_head:''}}</td>
                                        <td style="padding-bottom: 11px; padding-top: 0px" class="text-right pr-2">
                                            <a href="{{route('mapping.edit', $item->id)}}" class="btn" style="height: 30px; width: 30px;" title="Eidt">
                                                <img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;">
                                            </a>
                                            
                                            <a href="" class="btn" style="height: 30px; width: 30px;" title="Delete">
                                                <form action="{{ route('mapping.destroy', $item->id) }}" method="POST" class="flot-right">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn" onclick="return confirm('Confirm?')" style="padding-top: 0px; padding-left:0px;">
                                                        <img src="{{ asset('assets/backend/app-assets/icon/delete-icon.png')}}" style="height: 32px; width: 32px; margin-left: -12px;">
                                                    </button>
                                                </form>
                                            </a>
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
     // A/C CODE get
    $("#fld_ac_name").change(function (e) { 
        e.preventDefault();
        var account_head_id = $('#fld_ac_name option:selected').val();
        $.ajax({
            type:"post",
            url: "{{URL::to('account-head')}}",
            data:{
                "account_head_id":account_head_id
            },
            success:function(data){
                $('#fld_ac_code').empty();
                document.getElementById("fld_ac_code").value = data;              
            }
        });
    });
    // ACCOUNT HEAD get
    $("#fld_ac_code").change(function (e) { 
        e.preventDefault();
        var fld_ac_code = $('#fld_ac_code').val();
        $.ajax({
            type:"post",
            url: "{{URL::to('account-code')}}",
            data:{
                "fld_ac_code":fld_ac_code
            },
            success:function(data){
                $('#fld_ac_name').empty();
                var optionHtml = '<option value=""> Select Section </option>';
                data.forEach(function(element, index) {
                    var isSelected = '';
                    if(fld_ac_code == element.fld_ac_code){
                        isSelected = 'selected';
                    }
                    optionHtml += "<option value='"+element.id +"' "+isSelected+">"+ element.fld_ac_head+"</option>";
                });
                $('#fld_ac_name').html(optionHtml);
            }
        })
    });
</script>
@endpush