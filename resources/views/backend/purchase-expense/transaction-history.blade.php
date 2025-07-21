
@extends('layouts.backend.app')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@section('content')
    @include('layouts.backend.partial.style')
    <style>
        .changeColStyle span {
            min-width: 16%;
        }

        .changeColStyle .select2-container--default .select2-selection--single .select2-selection__arrow b {
            display: none;
        }

        .journaCreation {
            background: #1214161c;
        }

        .transaction_type {
            padding-right: 5px;
            padding-left: 5px;
            padding-bottom: 5px;
        }

        @media only screen and (max-width: 1500px) {
            .custome-project span {
                max-width: 140px;
            }
        }

        thead {
            background: #34465b;
            color: #fff !important;
        }

        th {
            color: #fff !important;
            font-size: 11px !important;
            height: 25px !important;
            text-align: center !important;
        }

        td {
            font-size: 12px !important;
            height: 25px !important;
            text-align: center !important;

        }

        .table-sm th,
        .table-sm td {
            padding: 0rem;
        }

        tr:nth-child(even) {
            background-color: #c8d6e357;
        }

        tr {
            cursor: pointer;
        }
    </style>
    <div class="app-content content print-hideen">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                @include('clientReport.project._header', ['activeMenu' => 'transaction-history'])
                <div class="tab-content journaCreation">
                    <div id="journaCreation" class="tab-pane bg-white active">

                        <section id="widgets-Statistics">

                            <div class="row " style="width: 805px">

                                <div class="col-md-12 px-2">

                                    <div class="cardStyleChange" style="width: 100%">
                                        <div class="card-body bg-white">
                                            <div class="row">
                                                <form class="form print-hideen m-1">
                                                    <div class="form-group d-flex">
                        
                                                        <select name="party_search" id="party_search"
                                                        class="common-select2 inputFieldHeight w-100">
                                                        <option value="">Select Project...</option>
                                                        @foreach ($projects as $project)
                                                            <option value="{{ $project->id }}">{{ $project->project_name }} </option>
                                                        @endforeach
                                                    </select>
                                                        <button type="submit" class="btn-primary btn-sm btn"> Search </button>
                                                    </div>
                                                </form>
                                            </div><br>
                                            @foreach ($projects as $project)
                                                <h4>Project Name: {{$project->project_name}}</h4>
                                                <table class="table table-bordered table-sm " style="width: 805px">
                                                    <tbody id="purch-body">
                                                            <thead class="thead">
                                                                <tr>
                                                                    <th style="width: 50%">Customer Name</th>
                                                                    <th style="width: 25%">Date</th>
                                                                    <th>Total Amount</th>
                                                                    <th>Type</th>
                                                                </tr>
                                                            </thead>
                                                            @foreach ($project->project_history($project->id) as $p_expense)
                                                                @if ($p_expense->customer_id || $p_expense->bill_info)
                                                                <tr class="border-top">
                                                                    @if ($p_expense->customer_id)
                                                                        <td>{{$p_expense->party->pi_name}}</td>
                                                                    @else
                                                                        <td>{{$p_expense->bill_info?$p_expense->bill_info->party->pi_name:''}}</td>
                                                                    @endif
                                                                    @if ($p_expense->customer_id && $p_expense->job_project_id)
                                                                        <td>{{date('d/m/Y', strtotime($p_expense->date))}}</td>
                                                                    @else
                                                                        <td>{{date('d/m/Y', strtotime($p_expense->bill_info?$p_expense->bill_info->date:''))}}</td>
                                                                    @endif
                                                                    @if ($p_expense->customer_id && $p_expense->job_project_id)
                                                                        <td>{{number_format($p_expense->total_budget,2)}}</td>
                                                                    @else
                                                                        <td>{{number_format($p_expense->amount,2)}}</td>
                                                                    @endif
                                                                    <td>
                                                                        {{$p_expense->customer_id && $p_expense->job_project_id?'Incomeing':'Outgoing'}}
                                                                    </td>
                                                                </tr>
                                                                @endif
                                                                
                                                            @endforeach
                                                    </tbody>
                                                </table>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>
                    </div>

                    </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
    </div>
    {{-- modal --}}
    <div class="modal fade bd-example-modal-lg" id="voucherPreviewModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div id="payable_modal_content">

            </div>
          </div>
        </div>
    </div>
    <!-- END: Content-->

@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    <script src="{{ asset('assets/backend') }}/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="{{ asset('assets/backend') }}/app-assets/js/scripts/forms/select/form-select2.js"></script>
    <script src="{{ asset('assets/backend') }}/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
    <script src="{{ asset('assets/backend') }}/app-assets/js/scripts/forms/form-repeater.js"></script>
    {{-- js work by mominul start --}}

    <script>
 $(document).on("click", ".payable-view", function(e) {
        e.preventDefault();
        var id= $(this).attr('id');
		$.ajax({
			url: "{{URL('payable-view')}}",
			type: "post",
			cache: false,
			data:{
				_token:'{{ csrf_token() }}',
                id:id,
			},
			success: function(response){
                document.getElementById("payable_modal_content").innerHTML = response;
                $('#voucherPreviewModal').modal('show')
                $(".datepicker").datepicker({
                dateFormat: "dd/mm/yy"
            });
			}
		});
	});

        // $('#party_search').change(function() {
        //     if ($(this).val() != '') {
        //         var party = $(this).val();
        //         var value = $('#search').val();
        //         var date = $('#date_search').val();
        //         var _token = $('input[name="_token"]').val();
        //         $.ajax({
        //             url: "{{ route('search-supplier-due') }}",
        //             method: "POST",
        //             data: {
        //                 value: value,
        //                 party: party,
        //                 date:date,
        //                 _token: _token,
        //             },
        //             success: function(response) {

        //                 $("#purch-body").empty().append(response);
        //             }
        //         })
        //     }
        // });

        $('#date_search').change(function() {
            if ($(this).val() != '') {
                var date = $(this).val();
                var value = $('#search').val();
                var party = $('#party_search').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('search-purchase-expense') }}",
                    method: "POST",
                    data: {
                        value: value,
                        party: party,
                        date:date,
                        _token: _token,
                    },
                    success: function(response) {

                        $("#purch-body").empty().append(response);
                    }
                })
            }
        });
    </script>
@endpush
