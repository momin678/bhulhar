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
            @include('clientReport.service-inentory.header', ['activeMenu' => 'token'])
            <div class="tab-content bg-white">
                @include('backend.token-gen.sub-head',['activeMenu' => 'vehicle_expense'])
                <div id="journalList" class="tab-pane active">
                    <section class="mr-1 ml-1">
                        <div class="table-responsive pt-1">
                            <table class="table table-sm table-hover">
                                <thead  class="thead-light">
                                    <tr class="mTheadTr">
                                        <th>Date</th>
                                        <th>Vehicle No</th>
                                        <th>Token No</th>
                                        <th>Type</th>
                                        <th>Labour Charge </th>
                                        <th class="text-right">Amount</th>
                                        <th class="text-right">Total Amount</th>
                                        <th class="text-right pr-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="user-table-body filter-table">
                                    @foreach ($expences as $item)
                                        <tr>
                                            <td>{{ date('d/m/Y', strtotime($item->date)) }}</td>
                                            <td>{{$item->truck->vehicle_number}}</td>
                                            <td>{{$item->token_no}}</td>
                                            <td>{{$item->type}}</td>
                                            <td>{{$item->others_cost}}</td>
                                            <td class="text-right">{{$item->amount}}</td>
                                            <td class="text-right">{{$item->amount+$item->others_cost}}</td>
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
    $(function() {
        // Apply the plugin
        $('.filter-table').excelTableFilter();
    });
    $(document).on("click", ".mVoucherPreview", function(e) {
        e.preventDefault();
        var id= $(this).attr('id');
		$.ajax({
			url: "{{route('vehicle-expense-view-modal')}}",
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
