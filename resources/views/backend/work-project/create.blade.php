@extends('layouts.backend.app')
@push('css')
    @include('layouts.backend.partial.style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css">
    <style>
        body {
            counter-reset: Serial;
        }

        .project-btn {
            border: none;
            color: #fff;
            font-size: 15px;
            font-weight: 500px;
            padding: 3px 10px;
            border-radius: 5px;
        }

        .add_items {
            background: #4CB648;
        }

        .delete_items {
            background: #EA5455;
            padding: 3px 3px 2px 3px;
            font-size: 13px;
        }

        .auto-index td:first-child:before {
            counter-increment: Serial;
            /* Increment the Serial counter */
            content: counter(Serial);
            /* Display the counter */
        }

        .auto-index,
        .auto-index th,
        .auto-index td {
            border: 1px solid #ddd;
        }

        .auto-index,
        .auto-index td {
            border: 1px solid #ddd;
            padding: 0 !important;
            margin: 0 !important;
        }

        #input-container .form-control {
            border: none;
            height: 30px !important;
        }

        #input-container .form-control:focus {
            border: 1px solid #4CB648;
        }

        .tasks-title,
        .budget-title {
            font-size: 16px;
            color: #313131;
            font-weight: 500;
            text-transform: capitalize;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            font-size: 16px !important;
        }

        .select2-container--default .select2-selection--single {
            height: 35px !important;
        }

        .add-customer {
            background: #4A47A3;
            padding: 2px 4px !important;
            margin: 0 !important;
        }
        .save-btn {
            background: #406343;
        }

        input.form-control {
            height: 35px !important;
        }
        .sub-btn {
            border: 1px solid #475F7B !important;
            background-color: #fff !important;
            border-radius: 15px !important;
            color: #475F7B !important;
            padding: 3px 6px 3px 6px !important;
        },
        .action-btn {
            background-color: #5F6F94;
            height: 35px;
        }
        .sub-btn:hover,
        .sub-btn.active {
            background-color: #34465b !important;
            color: white !important;
        }
        .sub-btn.active:hover {
            background-color: #c8d6e357 !important;
            color: black !important;
        }
        .form-control,
        .project-btn {
            height: 30px;
        }
        .date_type:focus,
        .date_type:active {
            border: border 1px solid #313131;
        }
        .note-editor p{
            line-height: 23px !important;
            margin: 0;
        }
    </style>
@endpush

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                @include('clientReport.project._header')
                <div class="tab-content bg-white">
                    <div id="journaCreation" class="tab-pane active">

                        <section class="p-1" id="widgets-Statistics">
                            <div class="row">
                                <div class="col-7 d-flex justify-content-between">
                                    <div class="d-flex">
                                        <a href="{{ route('lpo-projects.create') }}" class="project-btn sub-btn active"> New
                                            Project </a>

                                        <form action="{{ route('lpo-projects.index') }}" method="get" class="ml-1">
                                            <input type="hidden" value="new" name="quotation">
                                            <button type="submit" class="project-btn sub-btn bg-dark "> Quotation </button>
                                        </form>

                                        <form action="{{ route('lpo-projects.index') }}" method="get" class="ml-1">
                                            <input type="hidden" value="old" name="quotation">
                                            <button type="submit" class="project-btn sub-btn bg-dark "> Quatation
                                                <small>(WO)</small> </button>
                                        </form>
                                    </div>

                                </div>
                                <div class="col-5 d-flex justify-content-end">
                                </div>
                            </div>
                            <form class="repeater mt-1" action="{{ route('lpo-projects.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="d-flex">
                                    <div class="form-group w-100">
                                        <label for="">Quotation Name </label>
                                        <input type="text" name="project_name"
                                            value="{{ old('project_name', $project->project_name) }}" autocomplete="off"
                                            class="form-control @error('project_name') is_invalid @enderror"
                                            placeholder="Project name" style="margin-top: 5px;" required>

                                        @error('project_name')
                                            <p class="text-danger"> {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group w-100 ml-1">
                                        <label for="">Site/Delivery </label>
                                        <input type="text" name="site_delivery"
                                            autocomplete="off"
                                            class="form-control @error('site_delivery') is_invalid @enderror"
                                            placeholder="site delivery ..." style="margin-top: 5px;" required>

                                        @error('site_delivery')
                                            <p class="text-danger"> {{ $message }}</p>
                                        @enderror
                                    </div>


                                    <div class="form-group w-100 ml-1" style="padding-right:6px;">
                                        <div class="d-flex justify-content-between" style="margin-bottom: 0px;">
                                            <label for=""> Customer Name </label>
                                            <button type="button" class="project-btn add-customer" data-toggle="modal"
                                                data-target="#add-customer" required>
                                                <i class="bx bx-plus"></i>
                                            </button>
                                        </div>
                                        <select name="customer_id" required
                                            class="form-control customer_id @error('customer_id') is-invalid @enderror" id="party_info"
                                            required>
                                            <option value=""> Select Customer </option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    {{ old('customer_id') == $customer->id ? 'selected' : ' ' }}>
                                                    {{ $customer->pi_name }} </option>
                                            @endforeach
                                        </select>
                                        @error('customer_id')
                                            <p class="text-danger"> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group w-100 ml-1">
                                        <label for="">Attention </label>
                                        <input type="text" name="attention" id="attention"
                                            autocomplete="off"
                                            class="form-control @error('attention') is_invalid @enderror"
                                            placeholder="site delivery ..." style="margin-top: 5px;" required>

                                        @error('attention')
                                            <p class="text-danger"> {{ $message }}</p>
                                        @enderror
                                    </div>


                                    <div class="ml-1 d-flex w-100">
                                        <div class="form-group">
                                            <label for=""> Estimated Starting Date </label>
                                            <input type="text" name="start_date"
                                                class="date form-control @error('start_date') is-invalid @enderror"
                                                value="" autocomplete="off">
                                            @error('start_date')
                                                <p class="text-danger"> {{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="form-group ml-1">
                                            <label for=""> Estimated End Date </label>
                                            <input type="text" name="end_date"
                                                class="date form-control @error('end_date') is-invalid @enderror"
                                                autocomplete="off">
                                            @error('end_date')
                                                <p class="text-danger"> {{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="d-flex">
                                    <div class="form-group w-100">
                                        <label for=""> Subject </label>
                                        <textarea name="project_description" cols="30" rows="2" placeholder="Description max 200 characters"
                                            class="form-control @error('project_description') is-invalid @enderror" required>{{ old('project_description', $project->project_description) }}</textarea>
                                        @error('project_description')
                                            <p class="text-danger"> {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group w-100">
                                    <label for=""> Terms & Conditions </label>
                                    <textarea name="project_term" cols="30" rows="6" placeholder="Description max 200 characters"
                                        class="form-control summernote @error('Terms & Conditions') is-invalid @enderror" required>{{ old('project_term') }}</textarea>
                                    @error('project_term')
                                        <p class="text-danger"> {{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h2 class="tasks-title"> Project Tasks </h2>
                                    <button type="button" class="add_items project-btn">  <i class="bx bx-plus"></i>  </button>
                                </div>


                                <table class="auto-index repeater1 table table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-center"> S.NO </th>
                                            <th> Task Name </th>
                                            <th> Description </th>
                                            <th class="text-center"> Unit </th>
                                            <th class="text-center"> Qty </th>
                                            <th class="text-center"> Rate ({{ $currency->symbole }}) </th>
                                            <th class="text-center"> Amount ({{ $currency->symbole }})</th>
                                            <th class="text-center"> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody id="input-container">
                                        <tr>
                                            <td class="text-center"> <input type="checkbox" class="task_checkbox d-none"
                                                    name="invoice_tasks[0]" value="1"> </td>
                                            <td style="width: 20%">
                                                <input type="text" name="task_name[0]"
                                                    class="form-control @error('task_name') is-invalid @enderror" required
                                                    autocomplete="off">
                                            </td>

                                            <td style="width: 35%">
                                                <textarea name="description[0]" cols="30" rows="1" class="form-control" required></textarea>
                                            </td>

                                            <td>
                                                <input type="text" name="unit[0]"
                                                    class="form-control text-center unit" required value="">
                                            </td>
                                            <td>
                                                <input type="number" name="qty[0]" class="form-control text-center qty"
                                                    required value="" step="any" value='0.00'>
                                            </td>
                                            <td>
                                                <input type="number" name="rate[0]"
                                                    class="form-control text-center rate" step="any" required value=""
                                                    value='0.00'>
                                            </td>

                                            <td>
                                                <input type="number" step="any" name="amount[0]"
                                                    class="form-control amount text-center" required>
                                            </td>

                                            <td class="text-center">
                                                <button type="button" class="delete_items project-btn"> <i
                                                        class="bx bx-trash"></i> </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody>
                                        <tr>
                                        <tr>
                                            <td class="text-center d-none"> </td>
                                            <td colspan="6" class="text-right"> <span class="mr-1"> Total
                                                    ({{ $currency->symbole }}) </span> </td>
                                            <td colspan="1"> <input type="number" name="total" readonly
                                                    step="0.01" class="form-control text-center total" value="0">
                                            </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                        <tr>
                                            <td class="text-center d-none"> </td>
                                            <td colspan="6" class="text-right"> <span class="mr-1"> Discount
                                                    ({{ $currency->symbole }}) </span> </td>
                                            <td colspan="1"> <input type="number" name="discount" step="0.01"
                                                    class="form-control text-center discount discount-value"
                                                    value="0"> </td>
                                        </tr>
                                        </tr>
                                        <tr>
                                        <tr>
                                            <td class="text-center d-none"> </td>
                                            <td colspan="6" class="text-right"> <span class="mr-1"> Total Amount
                                                    ({{ $currency->symbole }}) </span> </td>
                                            <td colspan="1"> <input type="number" name="total_amount" step="0.01"
                                                    class="form-control text-center total_amount" value="0" readonly>
                                            </td>
                                        </tr>
                                        </tr>
                                    </tbody>
                                </table>
                             <div class="row d-flex align-items-center">
                                <div class="col-7">
                                    <div class="form-group" style="    width: 300px;margin-top: 27px;">
                                        <label for=""> Voucher File Upload  </label>
                                        <input
                                            class="form-control  @error('voucher_file') is-invalid @enderror" type="file" name="voucher_file" style="padding: 0px !important; border:none" accept="application/pdf,image/png,image/jpeg,application/msword" >
                                        @error('voucher_file')
                                            <p class="text-danger"> {{ $message }}</p>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-5">
                                    <div class="d-flex justify-content-end mt-1">
                                        <button type="submit" class="project-btn save-btn"> Save </button>
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

    <!-- Modal -->
    <div class="modal fade" id="add-customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 5px 15px;">
                    <h5 class="modal-title" id="exampleModalLabel"> Create Party </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 5px 15px;">
                    <div class="d-flex">
                        <div class="form-group w-50">
                            <label for=""> Party Name </label>
                            <input type="text" name="pi_name" class="form-control" required>
                            <p class="error-pi_name text-danger"> </p>
                        </div>
                        <div class="form-group w-50 ml-1">
                            <label for=""> Contact Person </label>
                            <input type="text" name="con_person" class="form-control" required>
                            <p class="error-con_person text-danger"></p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="form-group w-50">
                            <label for=""> Party Type </label>
                            <select name="pi_type" class="form-control">
                                <option selected> Customer </option>

                            </select>
                            <p class="error-pi_type text-danger"></p>
                        </div>
                        <div class="form-group w-50 ml-1">
                            <label for=""> Mobile Phone Number </label>
                            <input type="text" name="phone_no" class="form-control" required>
                            <p class="error-phone_no text-danger"></p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="form-group w-50">
                            <label for=""> TRN No </label>
                            <input type="text" name="trn_no" class="form-control" required>
                            <p class="error-trn_no text-danger"></p>
                        </div>
                        <div class="form-group w-50 ml-1">
                            <label for=""> Phone Number </label>
                            <input type="text" name="con_no" class="form-control" required>
                            <p class="error-con_no text-danger"></p>
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="form-group w-50">
                            <label for=""> Address </label>
                            <input type="text" name="address" class="form-control" required>
                            <p class="error-address text-danger"></p>
                        </div>
                        <div class="form-group w-50 ml-1">
                            <label for=""> Email </label>
                            <input type="text" name="email" class="form-control" required>
                            <p class="error-email text-danger"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 5px 15px;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary create-party"> Create </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote();
            $('.date').datepicker({
                dateFormat: 'dd/mm/yy'
            })
            $('.customer_id').select2();
            $(".add_items").click(function() {
                addInput();
            });
            var i = 0;

            function addInput() {
                i = i + 1;
                var inputGroup = "<tr>" +
                    "<td class='text-center'>" +
                    "<input type='checkbox' class='task_checkbox d-none' name='invoice_tasks[" + i + "]' value='1' >" +
                    "</td>" +
                    "<td style='width: 20%'>" +
                    "<input type='text' name='task_name[" + i + "]' class='form-control' required>" +
                    "</td>" +
                    "<td style='width: 30%'>" +
                    "<textarea name='description[" + i +
                    "]'  cols='30' rows='1' class='form-control' required></textarea>" +
                    "</td>" +
                    "<td>" +
                    "<input type='text' name='unit[" + i + "]' class='form-control unit text-center'>" +
                    "</td>" +
                    "<td>" +
                    "<input type='number' name='qty[" + i + "]' step='any' class='form-control qty text-center'>" +
                    "</td>" +
                    "<td>" +
                    "<input type='number' name='rate[" + i + "]' step='any' class='form-control rate text-center'>" +
                    "</td>" +
                    "<td>" +
                    "<input type='number' name='amount[" + i + "]' step='any' class='form-control amount text-center'>" +
                    "</td>" +
                    "<td class='text-center'>" +
                    "<button  type='button' class='delete_items project-btn'>" +
                    "<i class='bx bx-trash'> </i>" +
                    "</button>" +
                    "</td>" +
                    "</tr>";
                $("#input-container").append(inputGroup);
            }
        });

        $(document).on("click", ".delete_items", function() {
            $(this).closest("tr").remove();
            calculateAmount();
        });

        function calculateAmount() {
            let amount = 0
            $('.amount').each(function(index, el) {
                amount += parseFloat($(this).val())
            })



            $('.total').val(parseFloat(amount).toFixed(2))
            let discount = parseFloat($('.discount').val());
            if (discount > 0) {
                $('.total_amount').val(parseFloat(amount - discount).toFixed(2))
                $('.total_amount').attr('min', 1)
                $('.total_amount').attr('max', parseFloat(amount - discount).toFixed(2))
            } else {
                $('.total_amount').val(parseFloat(amount).toFixed(2))
                $('.total_amount').attr('min', 1)
                $('.total_amount').attr('max', parseFloat(amount).toFixed(2))
            }

        }

        $('#party_info').change(function() {
                if ($(this).val() != '') {
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('partyInfoInvoice2') }}",
                        method: "POST",
                        data: {
                            value: value,
                            _token: _token,
                        },
                        success: function(response) {
                            console.log(response);
                            $("#trn_no").val(response.trn_no);
                            $("#pi_code").val(response.pi_code);
                            $("#party_contact").val(response.con_no);
                            $("#party_address").val(response.address);
                            $("#attention").val(response.con_person);

                            $("#invoice_no").focus();
                        }
                    })
                }
            });


        $(document).on("keyup", ".qty", function(event) {
            var qty = $(this).val();
            var rate = $(this).closest("tr").find(".rate").val();
            var amount = qty * rate;
            $(this).closest("tr").find(".amount").val(amount.toFixed(2));
            calculateAmount();
        });

        $(document).on("keyup", ".rate", function(event) {
            var rate = $(this).val();
            var qty = $(this).closest("tr").find(".qty").val();
            var amount = qty * rate;
            $(this).closest("tr").find(".amount").val(amount.toFixed(2));
            calculateAmount();
        });

        $(document).on("keyup", ".amount", function(event) {
            var amount = $(this).val();
            var qty = $(this).closest("tr").find(".qty").val();
            var rate = qty / rate;
            $(this).closest("tr").find(".rate").val(rate.toFixed(2));
            calculateAmount();
        });
        $(document).on("keyup", ".discount", function(event) {
            calculateAmount();
        });

        $(document).on('click', '.create-party', function(event) {
            $.ajax({
                url: "{{ route('jobproject.customer.store') }}",
                method: "POST",
                data: {
                    _token: $('input[name="_token"]').val(),
                    pi_name: $('input[name="pi_name"]').val(),
                    pi_type: $('select[name="pi_type"]').val(),
                    trn_no: $('input[name="trn_no"]').val(),
                    address: $('input[name="address"]').val(),
                    con_person: $('input[name="con_person"]').val(),
                    con_no: $('input[name="con_no"]').val(),
                    phone_no: $('input[name="phone_no"]').val(),
                    email: $('input[name="email"]').val(),
                },
                success: function(data) {
                    $('.customer_id').append("<option value='" + data.id + "' selected>" + data
                        .pi_name + "</option>");

                        $("#attention").val(data.con_person);

                    $('.customer_id').select2();

                    $("#add-customer").modal('hide');
                },
                error: function(error) {
                    $.each(error.responseJSON.errors, function(key, val) {
                        $('p.error' + '-' + key).text(val[0]);
                        $('p.error' + '-' + key).siblings().addClass('is-invalid');
                    })
                }
            })
        })
        $(document).on('change', '.task_checkbox', function(event) {
            var totalAmount = 0;
            const advanceAmountElement = document.querySelector('.discount-value');
            // Iterate through checked checkboxes
            $('.task_checkbox:checked').each(function() {
                // Find the parent row of the checkbox
                var $row = $(this).closest('tr');

                // Find the corresponding amount field within the row
                var amount = parseFloat($row.find('.amount').val());

                // Add the amount to the total
                if (!isNaN(amount)) {
                    totalAmount += amount;
                    // You can display or use the total amount as needed here

                    advanceAmountElement.max = totalAmount;
                    advanceAmountElement.placeholder = totalAmount;
                }
            });
            if(totalAmount == 0){
                const total_amount = document.querySelector('.total');
                const discount_amount_max = total_amount.value;
                advanceAmountElement.max =discount_amount_max ;
                advanceAmountElement.placeholder = discount_amount_max;
            }
            console.log(discount_amount_max,totalAmount);

        });
    </script>
@endpush
