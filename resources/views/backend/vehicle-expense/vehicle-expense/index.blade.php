@extends('layouts.backend.app')
@section('content')
@include('layouts.backend.partial.style')
<style>
    .changeColStyle span{
        width: 213px !important;
    }
    .changeColStyle .select2-container--default .select2-selection--single .select2-selection__arrow b{
        display: none;
    }
</style>
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
                <a href="{{route("vehicle-expense.index")}}" class="nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/list-icon.png')}}" alt="" srcset="" class="img-fluid" width="50" height="20">
                    </div>
                    <div>Vehicle Expense</div>
                </a>
                <a href="{{route('vehicle-expense.create')}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Expense Entry</div>
                </a>
                <a href="{{route('item-expense')}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Item Expense</div>
                </a>
            </div>
            <div class="tab-content bg-white">
                <div id="journalList" class="tab-pane active">
                    <section id="widgets-Statistics" >
                        {{-- <label for="" class="mt-2">, , Between Date, Voucher Type.</label> --}}
                        <div class="row d-none p-1">
                            <div class="col-md-3">
                                <form action="{{ route('new-journal') }}" method="GET">
                                   <div class="row">
                                        <div class="col-md-7 changeColStyle">
                                            <label for="">Search Journal</label>
                                            <input type="text" class="form-control inputFieldHeight" name="text"  placeholder="Search by Journal No" id="date" required>
                                        </div>
                                        <div class="col-md-5 changeColStyle mt-2">
                                            <button type="submit" class="btn btn-primary formButton mSearchingBotton" title="Searching">
                                                <div class="d-flex">
                                                    <div class="formSaveIcon" style="margin-left: -10px;">
                                                        <img  src="{{asset('assets/backend/app-assets/icon/searching-icon.png')}}" alt="" srcset=""  width="25">
                                                    </div>
                                                    <div><span> Search</span></div>
                                                </div>
                                            </button>
                                        </div>
                                   </div>
                                </form>
                            </div>
                            <div class="col-md-3">
                                <form action="{{ route('new-journal') }}" method="GET">
                                   <div class="row">
                                    <div class="col-md-7 changeColStyle">
                                        <label for="">Single Date</label>
                                        <input type="text" class="form-control inputFieldHeight" name="date"  placeholder="Search by Date" id="date" required>
                                        <input type="hidden" class="form-control inputFieldHeight" name="mVoucherType" id="mVoucherType" value="">
                                    </div>
                                    <div class="col-md-5 changeColStyle mt-2">
                                        <button type="submit" class="btn btn-primary formButton mSearchingBotton" title="Searching">
                                            <div class="d-flex">
                                                <div class="formSaveIcon" style="margin-left: -10px;">
                                                    <img  src="{{asset('assets/backend/app-assets/icon/searching-icon.png')}}" alt="" srcset=""  width="25">
                                                </div>
                                                <div><span> Search</span></div>
                                            </div>
                                        </button>
                                    </div>
                                   </div>
                                </form>
                            </div>
                            <div class="col-md-6 pl-1">
                                <form action="{{ route('new-journal') }}" method="GET">
                                    {{-- @csrf --}}
                                    <div class="row ">
                                        <div class="col-md-3 changeColStyle">
                                            <label for="">From Date</label>
                                            <input type="text" class="form-control inputFieldHeight" name="from"
                                            placeholder="From"  value="" id="from">
    
                                        </div>
                                        <div class="col-md-3 changeColStyle">
                                            <label for="">To Date</label>
                                            <input type="text" class="form-control inputFieldHeight" name="to"
                                            placeholder="To" value="" id="to">
                                        </div>
                                        <div class="col-md-3 changeColStyle">
                                            <label for="">Type</label>
                                            <select name="voucherType" id="voucherType" class="form-control inputFieldHeight">
                                                <option value="">Type</option>
                                                <option value="DR">DEBIT</option>
                                                <option value="CR">CREDIT</option>
                                                <option value="JOURNAL">JOURNAL</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 changeColStyle text-right pr-1 mt-2">
                                            <button type="submit" class="btn btn-primary formButton mSearchingBotton" title="Searching">
                                                <div class="d-flex">
                                                    <div class="formSaveIcon" style="margin-left: -10px;">
                                                        <img  src="{{asset('assets/backend/app-assets/icon/searching-icon.png')}}" alt="" srcset=""  width="25">
                                                    </div>
                                                    <div><span> Search</span></div>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>  
                    <section class="mr-1 ml-1">
                        <div class="row mb-1 d-none">
                            <div class="col-md-6">
                                <h4></h4>
                            </div>
                            <div class="col-md-6 text-right ">
                                <a href="#" class="btn btn-xs formButton mExcelButton" onclick="exportTableToCSV('journal.csv')"><img  src="{{asset('assets/backend/app-assets/icon/excel-icon.png')}}" alt="" srcset="" class="img-fluid" width="30">Export To Excel</a href="#">
                            </div>
                        </div>
                        <div class="table-responsive pt-1">
                            <table class="table table-sm table-hover">
                                <thead  class="thead-light">
                                    <tr class="mTheadTr">
                                        <th>Date</th>
                                        <th>Vehicle Number</th>
                                        <th>Type</th>
                                        <th>Invoice Number</th>
                                        <th class="text-right">Total Amount</th>
                                        <th class="text-right pr-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="user-table-body">
                                    @foreach ($expences as $item)
                                        <tr>
                                            <td>{{$item->date}}</td>
                                            <td>{{$item->truck->vehicle_number}}</td>
                                            <td>{{$item->type}}</td>
                                            <td>{{$item->invoice_no}}</td>
                                            <td class="text-right">{{$item->amount}}</td>
                                            <td style="padding-bottom: 11px; padding-top: 0px">
                                                <div class="d-flex justify-content-end">
                                                    <a href="#" class="btn mVoucherPreview" v-type="main" style="height: 30px; width: 30px;" title="Preview" id="{{$item->id}}">
                                                        <img src="{{ asset('assets/backend/app-assets/icon/view-icon.png')}}" style=" height: 30px; width: 30px; margin-left: -12px;">
                                                    </a>
                                                </div>
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
    </div>
</div>
{{-- modal --}}
    <!-- END: Content-->
    <div class="modal fade bd-example-modal-lg" id="voucherPreviewModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="voucherPreviewShow">
              
            </div>
          </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="voucherDetailsPrintModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="voucherDetailsPrint">
              
            </div>
          </div>
        </div>
    </div>
@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
<script src="{{ asset('assets/backend')}}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="{{ asset('assets/backend')}}/app-assets/js/scripts/forms/select/form-select2.js"></script>
<script src="{{ asset('assets/backend')}}/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
<script src="{{ asset('assets/backend')}}/app-assets/js/scripts/forms/form-repeater.js"></script>
{{-- js work by mominul start --}}
<script>
    $(document).on("click", ".mVoucherPreview", function(e) {
        e.preventDefault();
        var id= $(this).attr('id');
		$.ajax({
			url: "{{URL('vehicle-expense-view-modal')}}",
			type: "post",
			cache: false,
			data:{
				_token:'{{ csrf_token() }}',
                id:id,
			},
			success: function(response){				
                document.getElementById("voucherPreviewShow").innerHTML = response;
                $('#voucherPreviewModal').modal('show')
			}
		});
	});
</script>


@endpush
