@extends('layouts.backend.app')
@section('content')
@include('layouts.backend.partial.style')
<style>
    .tabPadding{
        padding: 5px;
    }
</style>
@php
    $grand_total_value=0;
    $grand_total_pcs=0;
@endphp
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
            <div class="content-body">
                @include('backend.accounts-report.part.nav-part')

                <div class="tab-content bg-white">
                    <div class="tab-pane active">
                        <div class="content-body">
                            <div class="card-body">
                                <section id="widgets-Statistics">
                                    <h4>Party Ledger</h4>
                                        
                                        {{-- <section>
                                            <form >
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control inputFieldHeight" name="date"
                                                        placeholder="From"  value="{{ isset($searchDatefrom)? $searchDatefrom:"" }}"  onfocus="(this.type='date')"  id="date" required>
                                                    </div>
                                                    <div class="col-md-6 ">
                                                        <select name="party_date" id="party_date" class="form-control common-select2">
                                                            <option value="">Select Name</option>
                                                            @foreach ($parties as $item)
                                                                <option value="{{ $item->id }}">{{ $item->pi_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 justify-content-end text-right">
                                                        <button type="button" class="btn mSearchingBotton mb-2 formButton" title="Search"  id="clickDate">
                                                            <div class="d-flex">
                                                                <div class="formSaveIcon">
                                                                    <img src="{{asset("assets/backend/app-assets/icon/searching-icon.png")}}" width="25">
                                                                </div>
                                                                <div><span>Search</span></div>
                                                            </div>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </section> --}}
                                        <section>
                                             <form >
                                                 <div class="row">
                                                     <div class="col-md-2">
                                                         <input type="text" class="form-control inputFieldHeight" name="from"
                                                         placeholder="From"  value="{{ isset($searchDatefrom)? $searchDatefrom:"" }}"   id="from" required>
 
                                                     </div>
                                                     <div class="col-md-2">
                                                         <input type="text" class="form-control inputFieldHeight" name="to"
                                                         placeholder="To" value="{{ isset($searchDateto)? $searchDateto:"" }}" id="to" required>
                                                     </div>
                                                     <div class="col-md-6">
                                                         <select name="party" id="party" class="form-control common-select2">
                                                             <option value="">Select Name</option>
                                                             @foreach ($parties as $item)
                                                                 <option value="{{ $item->id }}">{{ $item->pi_name }}</option>
                                                             @endforeach
                                                         </select>
                                                         </div>
                                                         <div class="col-md-2 justify-content-end text-right">
                                                            <button type="button" class="btn mSearchingBotton mb-2 formButton" title="Search"  id="click">
                                                                <div class="d-flex">
                                                                    <div class="formSaveIcon">
                                                                        <img src="{{asset("assets/backend/app-assets/icon/searching-icon.png")}}" width="25">
                                                                    </div>
                                                                    <div><span>Search</span></div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                 </div>
                                             </form>
                                        </section>
                                        <div class="col-md-12">
                                            <input type="hidden" name="hidden_date_from" value="{{ isset($from)? $from:"" }}" id="hidden_date_from">
                                            <input type="hidden" name="hidden_date_to" value="{{ isset($to)? $to:"" }}" id="hidden_date_to">
    
    
                                            <div class="col-md-12 " id="table-body">
    
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
    <!-- END: Content-->

    <div class="modal fade bd-example-modal-lg" id="voucherPreviewModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="voucherPreviewShow">
              
            </div>
          </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            $('#click').click(function() {
                var from = $('#from').val();
                var to = $('#to').val();
                var party = $('#party').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('findPartyLedgers') }}",
                    method: "GET",
                    data: {
                        from: from,
                        to: to,
                        party: party,
                        _token: _token,
                    },
                    success: function(response) {
                        $("#table-body").empty().append(response.page);
                        $.each(response.journals, function(i, item) {
                            // alert(item);
                                $('.journal_no').append($('<option>', {
                                    value: item.id,
                                    text: item.journal_no
                                }));
                            });
                    }
                })
            });



            $('#clickDate').click(function() {
                var date = $('#date').val();
                var party = $('#party_date').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('findPartyLedgersDate') }}",
                    method: "GET",
                    data: {
                        date: date,
                        party: party,
                        _token: _token,
                    },
                    success: function(response) {
                        $("#table-body").empty().append(response.page);
                        $.each(response.journals, function(i, item) {
                            // alert(item);
                                $('.journal_no').append($('<option>', {
                                    value: item.id,
                                    text: item.journal_no
                                }));
                            });
                    }
                })


            });

            $(document).on("click", ".journalDetails", function(e) {

        e.preventDefault();
        var id= $(this).attr('id');
        var v_type= $(this).attr('v-type');
		$.ajax({
			url: "{{URL('voucher-preview-modal')}}",
			type: "post",
			cache: false,
			data:{
				_token:'{{ csrf_token() }}',
                id:id,
                v_type:v_type,
			},
			success: function(response){				
                document.getElementById("voucherPreviewShow").innerHTML = response;
                $('#voucherPreviewModal').modal('show')
			}
		});
});
        });
    </script>


@endpush
