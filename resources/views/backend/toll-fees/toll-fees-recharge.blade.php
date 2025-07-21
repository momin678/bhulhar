@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@endpush
@section('content')
@include('layouts.backend.partial.style')
    <!-- BEGIN: Content-->
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @include('clientReport.business-operation.header',['activeMenu' => 'toll_fees_recharge'])
            <div class="tab-content bg-white">
                <div class="tab-content bg-white">
                    <div>
                        <section id="widgets-Statistics" class="mr-1 ml-1 mb-1">
                            <div class="row">
                                <div class="col-md-6  mt-2 mb-2">
                                    <h4>Toll Fees Recharge</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 profit-center-form">
                                    <form action="{{ route('toll-fees-recharge.store') }}" method="POST">
                                            @csrf
                                        <div class="cardStyleChange">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Project Name</label>
                                                        <select name="project" class="inputFieldHeight form-control common-select2">
                                                            @foreach ($projects as $project)
                                                                <option value="{{$project->id}}">{{ $project->proj_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Cost Center</label>
                                                        <select name="cost_center" class="inputFieldHeight form-control common-select2">
                                                            @foreach ($cost_centers as $cost_center)
                                                                <option value="{{$cost_center->id}}">{{ $cost_center->cc_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Payment Mode</label>
                                                        <select name="pay_mode" id="pay_mode" class="inputFieldHeight form-control common-select2">
                                                            @foreach ($pay_modes as $pay_mode)
                                                                @if ($pay_mode->title != 'Credit')
                                                                    <option value="{{$pay_mode->title}}">{{ $pay_mode->title}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Supplier Name</label>
                                                    <select name="customer_id" class="inputFieldHeight form-control common-select2" id="customer_id" required>
                                                        <option value="">Select Name</option>
                                                        @foreach ($suppliers as $customer)
                                                        <option value="{{$customer->id}}">{{ $customer->pi_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-3 form-group pay-term d-none">
                                                    <label for="">Payment Terms</label>
                                                    <select name="pay_terms" id="pay_terms" class="common-select2" style="width: 100% !important"
                                                        required>
                                                        <option value="">Select...</option>
                                                        @foreach ($terms as $item)
                                                            <option value="{{ $item->value }}" {{ $item->title=="Today"? 'selected':'' }}>{{ $item->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">Toll Name</label>
                                                    <select name="toll_fees_id" id="toll_fees_id" class="form-control inputFieldHeight" required>
                                                        <option value="">Select Toll</option>
                                                        @foreach ($toll_names as $item)
                                                            <option value="{{$item->id}}">{{$item->name}}</option>        
                                                        @endforeach
                                                    </select>
                                                    @error('toll_fees_id')
                                                    <div class="btn btn-sm btn-danger">{{ $message }} </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Date</label>
                                                    <input type="text" id="date" class="form-control inputFieldHeight" name="date" value="{{ old('date') }}" placeholder="dd/mm/yyyyy" required>
                                                    @error('date')
                                                    <div class="btn btn-sm btn-danger">{{ $message }} </div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-3">
                                                    <label>Amount</label>
                                                    <input type="number" id="amount" class="form-control inputFieldHeight" name="amount" value="{{ old('amount') }}" placeholder="Recharge Amount" required>
                                                    @error('amount')
                                                    <div class="btn btn-sm btn-danger">{{ $message }} </div>
                                                    @enderror
                                                </div>
                                                    <div class="col-12 d-flex justify-content-end mt-1">
                                                        <button type="submit" class="btn btn-primary formButton" title="Form Save">
                                                            <div class="d-flex">
                                                                <div class="formSaveIcon">
                                                                    <img  src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                                </div>
                                                                <div><span> Save</span></div>
                                                            </div>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </section>
                        <hr>

                        <section class="mr-1 ml-1">
                            <div class="mt-2">
                                <div class="cardStyleChange">
                                    <table class="table mb-0 table-sm table-hover">
                                        <thead  class="thead-light">
                                            <tr style="height: 50px;">
                                                <th>Toll Name</th>
                                                <th>Recharge Amount</th>
                                                <th class="text-right pr-2">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="user-table-body">
                                            @foreach ($toll_names as $item)
                                            <tr class="trFontSize">
                                                <td>{{ $item->name }}</td>
                                                <td>{{ number_format($item->toll_fees_recharge->sum('amount'),2) }}</td>
                                                <td style="padding-bottom: 11px; padding-top: 0px" class="pr-2">
                                                <div class="d-flex justify-content-end">
                                                    <a href="#" class="btn rechargeView" style="height: 30px; width: 30px;" title="View" id="{{$item->id}}">
                                                        <img src="{{ asset('assets/backend/app-assets/icon/view-icon.png')}}" style=" height: 30px; width: 30px;">
                                                    </a>
                                                </div>
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
    <!-- END: Content-->
    <div class="modal fade bd-example-modal-lg" id="rechargeViewPrintModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="rechargeViewPrint">
              
            </div>
          </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).on("click", ".rechargeView", function(e) {
            e.preventDefault();
            var id= $(this).attr('id');
            $.ajax({
                url: "{{route('toll-fees-view-modal')}}",
                type: "post",
                cache: false,
                data:{
                    _token:'{{ csrf_token() }}',
                    id:id,
                },
                success: function(response){
                    document.getElementById("rechargeViewPrint").innerHTML = response;
                    $('#rechargeViewPrintModal').modal('show')
                }
            });
        });
    </script>
@endpush
