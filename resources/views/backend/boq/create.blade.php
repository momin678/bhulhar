@extends('layouts.backend.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />

@endpush
@section('content')
@include('layouts.backend.partial.style')
<style>
    .accordion .pluseMinuseIcon.collapsed::before{
        content: "\f067";;
        cursor: pointer;
        border: 1px solid rgb(123, 123, 123);
    }
    .accordion .pluseMinuseIcon::before {
        font-family: 'FontAwesome';
        content: "\f068";
        cursor: pointer;
        border: 1px solid rgb(123, 123, 123);
    }
    .rowStyle{
        cursor: pointer;
        border-left: dotted;
        padding: 3px;
        margin-bottom: 2px;
    }
    .findMasterAcc{
        cursor: pointer;
    }
    .card {
    margin-bottom: 0px !important;
    box-shadow: -8px 12px 18px 0 rgb(25 42 70 / 13%);
    transition: all .3s ease-in-out, background 0s, color 0s, border-color 0s;
}
</style>
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
                <a href="{{route('boq.index')}}" class="nav-item nav-link " role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/list-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>BOQ List</div>
                </a>
                <a href="{{route('boq.create')}}" class="nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Generate BOQ</div>
                </a>
            </div>
            <div class="tab-content bg-white">
                <div id="masterAccount" class="tab-pane active">
                    <section id="widgets-Statistics" class="mr-1 ml-1">
                        <div class="row">
                            <div class="col-md-6 mt-1">
                                <h4>BOQ Generate</h4>
                            </div>
                        </div>
                    </section>
                    <hr style="margin:0px !important">

                    <div class="row">
                        <div class="col-12">
                            <form action="{{ route('boq.store') }}" method="POST" >
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card d-flex align-items-center">
                                            <div class="card-body">
                                                <div class="row d-flex align-items-center">
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Branch</label>
                                                        <select name="branch" class="common-select2" style="width: 100% !important" id="branch" required>
                                                            @foreach ($projects as $item)
                                                                <option value="{{ $item->id }}">{{ $item->proj_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="project-error" style="display: none">
                                                            <div class="btn btn-sm btn-danger">Required*
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3 form-group" id="printarea">
                                                        <label for="">BOQ Date</label>
                                                        <input type="date"
                                                            value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                                            class="form-control" name="date" id="date" required>
                                                    </div>
                                                    <div class="col-sm-3 form-group ">
                                                        <label for="">BOQ No</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $boqTemp->number }}" name="boq_no"
                                                            id="boq_no" readonly>
                                                    </div>
                                                    <input type="hidden" name="boq_id" id="boq_id"  value="{{ $boqTemp->id }}">


                                                    <div class="col-sm-3 form-group customer-select">
                                                        <label for="">Customer Name</label>
                                                        <select name="customer_name" id="customer_name"
                                                             class="common-select2 party-info customer" style="width: 100% !important" data-target="" required>
                                                            <option value="">Select...</option>
                                                            @foreach ($customers as $customer)
                                                                <option value="{{ $customer->id }}" {{ $customer->pi_name == "Walk in Customer" ? 'selected':'' }}>
                                                                    {{ $customer->pi_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>


                                                    <div class="col-sm-3 form-group">
                                                        <label for="">TRN</label>
                                                        <input type="text" class="form-control" name="trn_no" id="trn_no"
                                                            class="form-control" readonly>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Contact Number</label>
                                                        <input type="text" class="form-control" name="contact_no"
                                                            id="contact_no" readonly>
                                                    </div>
                                                    <div class="col-sm-3 form-group">
                                                        <label for="">Address</label>
                                                        <input type="text" class="form-control" name="address"
                                                            id="address" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pb-1">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row d-flex align-items-center">
                                                    <div class="col-md-1">
                                                        <div class="form-group">
                                                            <label for="">Include Vat</label>
                                                            <input type="checkbox" class="checkbox-record" name="include_vat" id="include_vat" value="0" >


                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="">Work Description</label>
                                                            <select name="item" id="item" class="form-control" >
                                                                <option value="">Select...</option>
                                                                @foreach ($items as $item)
                                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="">Volume <small>(m <sup>2</sup>/m <sup>3</sup> )</small></label>
                                                            <input type="number" name="volume" step="any" id="volume" class="form-control volum">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="">Rate</label>
                                                            <input type="number" step="any" name="rate" id="rate" class="form-control rate">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="">Total</label>
                                                            <input type="number" step="any" name="total" id="total" class="form-control total" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1 pt-1 text-right col-left-padding">
                                                        <i class="btn btn-sm btn-info add-btn">Add</i>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <table class="table table-sm w-100 table-bordered all-data-area">
                                            <tr>
                                                <th>No</th>
                                            <th>Work Description</th>
                                            <th>Volume <small>(m <sup>2</sup>/m <sup>3</sup> )</small></th>
                                            <th>Rate</th>
                                            <th>Taxable Amount</th>
                                            <th>Vat</th>
                                            <th>Total Amount</th>
                                            <th>Action</th>
                                            </tr>

                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <button type="submit"
                                                            class="btn btn-sm final-save-btn only-save-btn  btn-primary" id="final_save">
                                                            Save</button>
                                                            <a  class="btn btn-sm btn-warning" onClick="refreshPage()">Refresh</a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
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
        var delay = (function() {
            var timer = 0;
            return function(callback, ms) {
                clearTimeout(timer);
                timer = setTimeout(callback, ms);
            };
        })();
        $('#customer_name').change(function() {
                if ($(this).val() != '') {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('partyInfoInvoice') }}",
                        method: "POST",
                        data: {
                            value: value,
                            _token: _token,
                        },
                        success: function(response) {
                            console.log(response);
                            $("#trn_no").val(response.trn_no);
                            $("#contact_no").val(response.con_no);
                            $("#address").val(response.address);
                        }
                    })
                }
            });


            $('.add-btn').click(function() {
                // alert(1);
                var item = $('#item').val();
                var volume = $('#volume').val();
                var boq_id = $('#boq_id').val();
                var boq_no = $('#boq_no').val();
                var rate = $('#rate').val();
                var total = $('#total').val();
                var include_vat = $('#include_vat').val();

                var _token = $('input[name="_token"]').val();
                // alert(cost_price);
                $.ajax({
                    url: "{{ route('tempBoq') }}",
                    method: "GET",
                    data: {
                        item: item,
                        volume: volume,
                        boq_id: boq_id,
                        _token: _token,
                        boq_no:boq_no,
                        total:total,
                        include_vat:include_vat,
                        rate:rate
                    },
                    success: function(response) {

                        if(response.error)
                        {
                            toastr.error("{{ Session::get('message') }}",(response.error));
                        }
                        else
                        {
                            // alert(response.page);
                        // var vat = response.total_cost_price - response.total_unit_price;
                        $(".all-data-area").empty().append(response.page);
                        }
                    }
                })
            });


            $(document).on("click", '.boq-item-delete', function(event) {
                event.preventDefault();
                var that = $(this);
                var urls = that.attr("data_target");
                var _token = $('input[name="_token"]').val();
                var boq_id = $('#boq_id').val();
                // alert(boq_id);
                $.ajax({
                    url: urls,
                    method: "GET",
                    boq_id: boq_id,
                    _token: _token,

                    success: function(response) {
                        // alert("hukka");
                        console.log(response);
                        $(".all-data-area").empty().append(response.page);


                    },
                    error: function() {
                        //   alert('no');
                    }
                });

            });


            $(document).on("keyup", "#volume", function(e) {
                var key = e.which;
                // alert(1);
                    var value = $(this).val();
                    var c = $('#rate').val();

                    var cost = c * value;
                    $("#total").val(cost);

            });

            $(document).on("keyup", "#rate", function(e) {
                var key = e.which;
                // alert(1);
                    var value = $(this).val();
                    var c = $('#volume').val();

                    var cost = c * value;
                    $("#total").val(cost);

            });
            $(document).on("change", "#include_vat", function(e){

if (this.checked) {
    $(this).val(1);
} else {
    $(this).val(0);
}
});

    });
</script>
@endpush


