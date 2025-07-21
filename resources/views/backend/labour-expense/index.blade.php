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
            @include('backend.vehicle-expense.expense-tab')
            <div class="tab-content bg-white">
                <div id="journalList" class="tab-pane active">
                    <section class="mr-1 ml-1">
                        <div class="table-responsive pt-1">
                            <table class="table table-sm table-hover">
                                <thead  class="thead-light">
                                    <tr class="mTheadTr">
                                        <th>Date</th>
                                        <th>Vehicle Number</th>
                                        <th class="text-right">Total Amount</th>
                                        <th class="text-right pr-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="user-table-body filter-table">
                                    @foreach ($expanses as $item)
                                        <tr>
                                            <td>{{ date('d/m/Y', strtotime($item->date)) }}</td>
                                            <td>{{$item->truck_number}}</td>
                                            <td class="text-right">{{$item->total_amount}}</td>
                                            <td style="padding-bottom: 11px; padding-top: 0px">
                                                <div class="d-flex justify-content-end">
                                                    <a href="#" class="btn labourExpense" v-type="main" style="height: 30px; width: 30px;" title="Preview" id="{{$item->id}}">
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
    $(document).on("click", ".labourExpense", function(e) {
        e.preventDefault();
        var id= $(this).attr('id');
		$.ajax({
			url: "{{URL('labour-expense-view-modal')}}",
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
