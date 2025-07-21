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

        .note-editor p {
            line-height: 23px !important;
            margin: 0;
        }
        .form-control{
            margin-bottom: 0px !important
        }
        .form-group {
    margin-bottom: 0rem !important;
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
                    <input type="hidden" name="" class="standard-vat-rate" value="{{ $standard_vat_rate }}"
                        id="">
                    <div id="journaCreation" class="tab-pane active">
                        <section class="p-1" id="widgets-Statistics">
                            <form class="repeater" action="{{ route('projects.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="d-flex">
                                    <div class="form-group w-100">
                                        <label for=""> Lpo Project Name </label>
                                        <input type="text" name="project_name"
                                            value="{{ old('project_name', $lpo_project->project_name) }}"
                                            class="form-control @error('project_name') is_invalid @enderror"
                                            placeholder="Project name" style="margin-top: 5px;" autocomplete="off">
                                        <input type="hidden" name="lpo_projects_id" value="{{ $lpo_project->id }}">
                                        <input type="hidden" name="lpo_projects_budget"
                                            value="{{ $lpo_project->total_budget }}">

                                        @error('project_name')
                                            <p class="text-danger"> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group w-100 ml-1 d-none">

                                        <label for="">Site/Delivery </label>
                                        <input type="text" name="site_delivery"
                                            value="{{$lpo_project->site_delivery }}" autocomplete="off"
                                            class="form-control @error('site_delivery') is_invalid @enderror"
                                            placeholder="site delivery ..." style="margin-top: 5px;" required>

                                        @error('site_delivery')
                                            <p class="text-danger"> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group w-100 ml-1" style="padding-right:6px;">
                                        <div class="d-flex justify-content-between" style="margin-bottom: 3px;">
                                            <label for=""> Customer Name </label>
                                            <button type="button" class="project-btn add-customer" data-toggle="modal"
                                                data-target="#add-customer">
                                                <i class="bx bx-plus"></i>
                                            </button>
                                        </div>
                                        {{-- {{dd($lpo_project)}} --}}
                                        <select name="customer_id"
                                            class="form-control customer_id @error('customer_id') is-invalid @enderror">
                                            <option selected disabled> Select Customer </option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    {{  $lpo_project->customer_id == $customer->id ? 'selected' : ' ' }}>
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
                                            placeholder="site delivery ..." value="{{$lpo_project->attention}}" style="margin-top: 5px;" required>

                                        @error('attention')
                                            <p class="text-danger"> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="ml-1 d-flex w-100 ml-1">
                                        <div class="form-group">
                                            <label for=""> Estimated Starting Date </label>
                                            <input type="text" name="start_date" style="margin-top: 5px;"
                                                class="date form-control @error('start_date') is-invalid @enderror"
                                                value="{{ $lpo_project->start_date ? date('d/m/Y', strtotime($lpo_project->start_date)) : ' ' }}"
                                                autocomplete="off">
                                            @error('start_date')
                                                <p class="text-danger"> {{ $message }}</p>
                                            @enderror
                                        </div>


                                    </div>
                                    <input type="hidden" id="task_count" value="{{ $lpo_project->tasks->count() }}">
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for=""> Estimated End Date </label>
                                        <input type="text" name="end_date" style="margin-top: 5px;"
                                                class="date form-control @error('end_date') is-invalid @enderror"
                                                value="{{ $lpo_project->end_date ? date('d/m/Y', strtotime($lpo_project->end_date)) : ' ' }}"
                                                autocomplete="off">
                                            @error('end_date')
                                                <p class="text-danger"> {{ $message }}</p>
                                            @enderror

                                    </div>
                                    <div class="col-md-3">
                                        <label for="LPO No">LPO No</label>
                                        <input type="text" name="lpo_no" id="lpo_no" class="form-control">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="LPO No">D.O. No</label>
                                        <input type="text" name="do_no" id="do_no" class="form-control">
                                    </div>

                                </div>



                                <div class="d-flex">
                                    <div class="form-group w-100">
                                        <label for=""> Desctiption </label>
                                        <textarea name="project_description" cols="30" rows="2" placeholder="Description max 200 characters"
                                            class="form-control @error('project_description') is-invalid @enderror">{{ old('project_description', $lpo_project->project_description) }}</textarea>
                                        @error('project_description')
                                            <p class="text-danger"> {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group w-100">
                                    <label for=""> Terms & Conditions </label>
                                    <textarea name="project_term" cols="30" rows="6" placeholder="Description max 200 characters"
                                        class="form-control summernote @error('Terms & Conditions') is-invalid @enderror" required>{{ $lpo_project->project_term }}</textarea>
                                    @error('project_term')
                                        <p class="text-danger"> {{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h2 class="tasks-title"> Project Tasks </h2>
                                    {{-- <button type="button" class="add_items project-btn"> Add </button> --}}
                                </div>


                                <table class="auto-index repeater1 table table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-center"> S.NO </th>
                                            <th> Task Name </th>
                                            <th> Description </th>
                                            <th class="text-center"> Unit </th>
                                            <th class="text-center"> Qty </th>
                                            <th class="text-center"> Rate </th>
                                            <th class="text-center"> Discount </th>
                                            <th class="text-center"> Amount ({{ $currency->symbole }}) </th>
                                            {{-- <th class="text-center"> Action </th> --}}
                                        </tr>
                                    </thead>
                                    <tbody id="input-container">
                                        <input type="hidden" class="invoice_type"
                                            value="{{ $lpo_project->invoice_type }}">

                                        @foreach ($lpo_project->tasks as $key => $task)
                                            <tr>
                                                <td class="text-center">
                                                    @if ($lpo_project->invoice_type != 'amount_base')
                                                        <input type="checkbox" class="task_checkbox d-none"
                                                            name="invoice_tasks[{{ $task->id }}]"
                                                            value="{{ $task->id }}">
                                                    @endif
                                                </td>
                                                <td style="width: 20%">
                                                    <input type="hidden" value="{{ $task->id }}"
                                                        name="task_id[{{ $task->id }}]">

                                                    <input type="text" name="task_name[{{ $task->id }}]"
                                                        class="form-control @error('task_name') is-invalid @enderror"
                                                        required autocomplete="off" value="{{ $task->task_name }}">
                                                </td>

                                                <td style="width: 35%">
                                                    <textarea name="description[{{ $task->id }}]" cols="30" rows="1" class="form-control"
                                                        required>{{ $task->description }}</textarea>
                                                </td>

                                                <td>
                                                    <input type="text" name="unit[{{ $task->id }}]"
                                                        class="form-control text-center unit" required
                                                        value="{{ $task->unit }}">
                                                </td>
                                                <td>
                                                    <input type="number" name="qty[{{ $task->id }}]"
                                                        class="form-control text-center qty" required
                                                        value='{{ $task->qty }}'>
                                                </td>
                                                <td>
                                                    <input type="number" name="rate[{{ $task->id }}]"
                                                        class="form-control text-center rate" required
                                                        value='{{ $task->rate }}'>
                                                </td>
                                                <td>
                                                    <input type="number" step="any" name="task_discount[{{ $task->id }}]"
                                                        class="form-control text-center task_discount"
                                                        value='0'>
                                                </td>
                                                <td>
                                                    <input type="number" step="any"
                                                        name="amount[{{ $task->id }}]"
                                                        class="form-control amount text-center" required
                                                        value="{{ $task->amount }}" data-amount="{{$task->amount}}">
                                                </td>

                                                {{-- <td class="text-center">
                                            <button  type="button" class="delete_items project-btn"> <i class="bx bx-trash"></i> </button>
                                        </td> --}}
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tbody>

                                        <tr>
                                            <td class="text-center d-none"> </td>
                                            <td colspan="7" class="text-right"> <span class="mr-1"> Total </span>
                                            </td>
                                            <td colspan="1"> <input type="number" name="total" readonly
                                                    step="0.01" class="form-control text-center total"
                                                    value="{{ $lpo_project->budget }}"> </td>
                                        </tr>


                                        <tr>
                                            <td class="text-center d-none"> </td>
                                            <td colspan="7" class="text-right"> <span class="mr-1"> Discount </span>
                                            </td>
                                            <td colspan="1"> <input type="number" name="discount" step="0.01"
                                                    class="form-control text-center discount"
                                                    value="{{ $lpo_project->discount }}"> </td>
                                        </tr>


                                        <tr>
                                            <td class="text-center d-none"> </td>
                                            <td colspan="7" class="text-right"> <span class="mr-1"> Total Amount
                                                    ({{ $currency->symbole }}) </span> </td>
                                            <td colspan="1"> <input type="number" name="total_amount" step="0.01"
                                                    class="form-control text-center total_amount"
                                                    value="{{ $lpo_project->total_budget }}" readonly> </td>
                                        </tr>


                                        <tr class="d-none">
                                            <td class="text-center d-none"> </td>
                                            <td colspan="7" class="text-right"> <span class="mr-1"> Advance Amount
                                                    ({{ $currency->symbole }}) </span> </td>
                                            <td colspan="1"> <input type="number" name="advance_amount"
                                                    step="0.01" class="form-control text-center advance_amount"
                                                    max="{{ $lpo_project->total_budget }}" value=""
                                                    placeholder="advance amount"> </td>
                                        </tr>
                                        <tr class="d-none">
                                            <td class="text-center d-none"> </td>
                                            <td colspan="7" class="text-right"> <span class="mr-1"> Advance Amount %
                                                    ({{ $currency->symbole }}) </span> </td>
                                            <td colspan="1"> <input type="number" name="advance_amount_persentage"
                                                    step="0.01"
                                                    class="form-control text-center advance_amount_persentage"
                                                    max="100" value="" placeholder="advance amount"> </td>
                                        </tr>
                                        <tr class="d-none">
                                            <td class="text-center d-none"> </td>
                                            <td colspan="7" class="text-right"> <span class="mr-1"> Vat
                                                    ({{ $currency->symbole }}) </span> </td>
                                            <td colspan="1"> <input type="number" name="vat_amount" step="0.01"
                                                    class="form-control text-center vat_amount" min="1"
                                                    value="" readonly placeholder="Vat amount"> </td>
                                        </tr>
                                        <tr class="d-none">
                                            <td class="text-center d-none"> </td>
                                            <td colspan="7" class="text-right"> <span class="mr-1"> Total Amount
                                                    ({{ $currency->symbole }}) </span> </td>
                                            <td colspan="1"> <input type="number" name="total_advance_amount"
                                                    step="0.01" class="form-control text-center total_advance_amount"
                                                    min="1" value="" readonly placeholder="total amount">
                                            </td>
                                        </tr>

                                        <tr class="pay-mode-part" style="display:none">
                                            <td class="text-center d-none"> </td>
                                            <td colspan="7" class="text-right"> <span class="mr-1"> Payment Mode
                                                </span> </td>
                                            <td colspan="1">
                                                <select name="payment_mode" id="payment_mode" class="form-control">
                                                    @foreach ($paymodes as $paymode)
                                                        <option value="{{ $paymode->title }}"
                                                            {{ $paymode->title == 'Card' ? 'selected' : '' }}>
                                                            {{ $paymode->title }} </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr class="cheque-content" style="display: none">
                                            <td class="text-center d-none"> </td>
                                            <td colspan="8">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-5 changeColStyle">
                                                            <div class="row align-items-center">
                                                                <div class="col-3">
                                                                    <label for="">Issuing Bank</label>
                                                                </div>
                                                                <div class="col-9 col-left-padding">
                                                                    <input type="text" autocomplete="off" name="issuing_bank"
                                                                        id="issuing_bank" class="form-control inputFieldHeight"
                                                                        placeholder="Issuing Bank">
                                                                    @error('issuing_bank')
                                                                        <div class="btn btn-sm btn-danger">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 changeColStyle">
                                                            <div class="row align-items-center">
                                                                <div class="col-2">
                                                                    <label for="">Branch</label>
                                                                </div>
                                                                <div class="col-10">
                                                                    <input type="text" autocomplete="off" name="bank_branch"
                                                                        id="bank_branch" class="form-control inputFieldHeight"
                                                                        placeholder="Branch">
                                                                    @error('bank_branch')
                                                                        <div class="btn btn-sm btn-danger">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2 changeColStyle">
                                                            <div class="row align-items-center">
                                                                <div class="col-5 col-right-padding">
                                                                    <label for="">Cheque No</label>
                                                                </div>
                                                                <div class="col-7 col-left-padding">
                                                                    <input type="text" value="" autocomplete="off"
                                                                        class="form-control inputFieldHeight" name="cheque_no"
                                                                        placeholder="Cheque Number" id="cheque_no">
                                                                    @error('cheque_no')
                                                                        <div class="btn btn-sm btn-danger">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2 changeColStyle">
                                                            <div class="row align-items-center">
                                                                <div class="col-6 col-right-padding">
                                                                    <label for="">Deposit Date</label>
                                                                </div>
                                                                <div class="col-6 col-left-padding">
                                                                    <input type="text" value="" autocomplete="off"
                                                                        class="form-control inputFieldHeight datepicker deposit_date"
                                                                        name="deposit_date" placeholder="dd/mm/yyyy">
                                                                    @error('deposit_date')
                                                                        <div class="btn btn-sm btn-danger">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="form-group" style="    width: 300px;margin-top: 27px;">
                                    <label for=""> Voucher File Upload  </label>
                                    <input
                                        class="form-control  @error('voucher_file') is-invalid @enderror" type="file" name="voucher_file" style="height: 45px !important" accept="application/pdf,image/png,image/jpeg,application/msword" >
                                    @error('voucher_file')
                                        <p class="text-danger"> {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-end mt-1">
                                    <button type="submit" class="project-btn save-btn"> Save </button>
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
                                <option> Supplier </option>
                                <option> Employee </option>
                                <option> Government Body </option>
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

            calculateDiscount();
            var i = parseInt($('#task_count').val() - 1);

            // function addInput() {
            //     i=i+1;
            //     var inputGroup = "<tr>"
            //             + "<td class='text-center'>"
            //             +"<input type='checkbox' class='task_checkbox' name='invoice_tasks["+ i +"]' value='1' checked>"
            //             +"</td>"
            //             + "<td style='width: 20%'>"
            //             + "<input type='text' name='task_name["+i+"]' class='form-control' required>"
            //             +"</td>"
            //             + "<td style='width: 30%'>"
            //             +"<textarea name='description["+i+"]'  cols='30' rows='1' class='form-control' required></textarea>"
            //             +"</td>"
            //             +"<td>"
            //             +"<input type='text' name='unit["+i+"]' class='form-control unit text-center'>"
            //             +"</td>"
            //             +"<td>"
            //             +"<input type='number' name='qty["+i+"]' class='form-control qty text-center'>"
            //             +"</td>"
            //             +"<td>"
            //             +"<input type='number' name='rate["+i+"]' class='form-control rate text-center'>"
            //             +"</td>"
            //             +"<td>"
            //             +"<input type='number' name='amount["+i+"]' class='form-control amount text-center'>"
            //             +"</td>"
            //             +"<td class='text-center'>"
            //             +"<button  type='button' class='delete_items project-btn'>"
            //             +"<i class='bx bx-trash'> </i>"
            //             +"</button>"
            //             +"</td>"
            //             +"</tr>";
            //     $("#input-container").append(inputGroup);
            // }
        });

        function calculateDiscount(){
            var total = $('.total').val();
            var discount = $('.discount').val();
            var persentage = (discount * 100) / total;

            $('.amount').each(function(){
                var task_amount = parseFloat($(this).data('amount'));
                var task_discount = (persentage * task_amount) /100;
                $(this).val((task_amount - task_discount).toFixed(2));
                $(this).closest('tr').find('.task_discount').val(task_discount.toFixed(2))
            })

            $('.total_amount').val((total-discount).toFixed(2));
        }

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
            calculateDiscount()
        });

        $(document).on('keyup', '.task_discount',function(){
            var total_discount = 0;
            var total_amount = $('.total').val();
            $('.task_discount').each(function(){
                var amount = parseFloat($(this).closest('tr').find('.amount').data('amount'));
                var discount = $(this).val();
                $(this).closest('tr').find('.amount').val((amount-discount).toFixed(2));
                if(discount > 0){
                    total_discount += parseFloat(discount);
                }
            })

            $('.discount').val(total_discount.toFixed(2));
            $('.total_amount').val((total_amount-total_discount).toFixed(2));
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

        $(document).on('keyup', '.advance_amount', function() {
            if ($(this).val() > 0) {
                $('.pay-mode-part').show()
                $('#payment_mode').attr('required', true);
            } else {
                $('.pay-mode-part').hide()
                $('#payment_mode').removeAttr('required');
            }
        });

        $(document).on('keyup', '.advance_amount_persentage', function() {
            if ($(this).val() > 0) {
                $('.pay-mode-part').show()
                $('#payment_mode').attr('required', true);
            } else {
                $('.pay-mode-part').hide()
                $('#payment_mode').removeAttr('required');
            }
        });

        // ************ advance flat calculation for **********
        $(document).on('keyup', '.advance_amount_persentage', function(event) {
            var advanceAmount_percentage = $(this).val();
            var standard_vat_rate = parseFloat($('.standard-vat-rate').val());
            var sub_total = parseFloat($('.total_amount').val());
            var vat_amount = $('.vat_amount');
            var total_amount = $('.total_advance_amount');

            var advance = (advanceAmount_percentage / 100) * sub_total;
            var vat = (standard_vat_rate / 100) * advance;

            vat_amount.val(vat.toFixed(2)).prop('readonly', true);

            var total = advance + vat;
            total_amount.val(total.toFixed(2));

            advance = advance.toFixed(2);
            //  show advance value if persentage field have any value that gater than zero.
            $('.advance_amount').val(advance).prop('readonly', advanceAmount_percentage > 0);


        });
        // ************ advance persentage calculation  for **********
        $(document).on('keyup', '.advance_amount', function(event) {
            var advanceAmountElement = $(this).val();
            var standard_vat_rate = $('.standard-vat-rate').val();
            var sub_total = $('.total_amount').val();
            var vat_amount = $('.vat_amount');
            var total_amount = $('.total_advance_amount');

            var vat = (standard_vat_rate / 100) * advanceAmountElement;
            var persentage = (advanceAmountElement * 100) / sub_total;
            var total = (advanceAmountElement * 1) + vat;

            vat_amount.val(vat.toFixed(2)).prop('readonly',true);
            total_amount.val(total.toFixed(2));
            $('.advance_amount_persentage').val(persentage.toFixed(2)).prop('readonly', advanceAmountElement > 0);

        });

        $('#payment_mode').change(function() {
            if ($(this).val() == 'Cheque') {
                $(".deposit_date").attr('required',true);
                $("#bank_branch").attr('required',true);;
                $("#issuing_bank").attr('required',true);
                $("#cheque_no").attr('required',true);
                $('.cheque-content').show();

            } else {
                $(".deposit_date").removeAttr('required');
                $("#bank_branch").removeAttr('required');;
                $("#issuing_bank").removeAttr('required');
                $("#cheque_no").removeAttr('required');
                $('.cheque-content').hide();
            }
        });

        $(document).on('change', '.task_checkbox', function(event) {
            var totalAmount = 0;
            var standard_vat_rate = $('.standard-vat-rate').val();
            const advanceAmountElement = document.querySelector('.advance_amount');
            const vat_amount = document.querySelector('.vat_amount');
            let total_amount = document.querySelector('.total_advance_amount');
            const subtotal = document.querySelector('.total').value;
            var sub_total = $('.total_amount').val();

            // Iterate through checked checkboxes
            $('.task_checkbox:checked').each(function() {
                // Find the corresponding amount field based on the checkbox's value
                var taskId = $(this).val();
                var amount = parseFloat($('input[name="amount[' + taskId + ']"]').val());
                // Add the amount to the total
                if (!isNaN(amount)) {
                    totalAmount += amount;
                    $('.pay-mode-part').show()
                    advanceAmountElement.readOnly = true;
                    vat_amount.readOnly = true;


                }
            });

            var vat = (standard_vat_rate / 100) * totalAmount;
            var persentage = (totalAmount * 100) / sub_total;

            advanceAmountElement.value = totalAmount;
            vat_amount.value = vat.toFixed(2);
            var total = (totalAmount * 1) + vat;
            total_amount.value = total.toFixed(2);
            $('.advance_amount_persentage').val(persentage.toFixed(2)).prop('readonly', true);

            // alert(totalAmount);
            if (totalAmount == 0) {
                $('.pay-mode-part').hide()
                advanceAmountElement.readOnly = false;
                advanceAmountElement.max = subtotal;
                advanceAmountElement.value = ' ';
            }

        });
        // ************ check value for **********
        $('.repeater').submit(function(e) {

            var atLeastOneChecked = $('.task_checkbox:checked').length > 0;
            var advanceAmount = $('.advance_amount').val();
            var invoice_type = $('.invoice_type').val();


            var allowSubmission = true;
            if (!atLeastOneChecked && advanceAmount !== '' && invoice_type == 'task_base') {
                toastr.error('Please check at least one checkbox ');
                allowSubmission = false;

            }
            if (!allowSubmission) {
                e.preventDefault(); // Prevents form submission
            }

        });
        // ************ check value for **********
    </script>
@endpush
