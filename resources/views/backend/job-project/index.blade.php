@extends('layouts.backend.app')
@push('css')
    @include('layouts.backend.partial.style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
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
            width: 100%;
        }

        .add-customer {
            background: #4A47A3;
            padding: 2px 4px !important;
            margin: 0 !important;
        }

        input.form-control {
            height: 35px !important;
        }

        .project-btn {
            border: none;
            color: #fff;
            font-size: 15px;
            font-weight: 500px;
            padding: 3px 10px;
            border-radius: 5px;
        }

        .project-btn,
        .form-control {
            height: 30px;
        }

        .btn-sky {
            background-color: #7DE5ED;
        }

        .btn-dark-blue {
            background-color: #5F6F94;
        }

        .btn-light-green,
        .btn-light-green:hover {
            background-color: #1F8A70;
            text-decoration: none;
            color: #fff;
        }

        .sub-btn {
            border: 1px solid #475F7B;
            background-color: #fff;
            border-radius: 15px;
            color: #475F7B;
            padding: 3px 6px 3px 6px !important;
        }

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
        .table .thead-light th {
        color:#F2F4F4 ;
        background-color: #34465b;
        border-color: #DFE3E7;
    }
    tr:nth-child(even) {
        background-color: #c8d6e357;
    }
    </style>
@endpush
@section('content')
    <div class="app-content content print-hideen">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                @include('clientReport.project._header')
                <div class="tab-content bg-white">
                    <div id="journaCreation" class="tab-pane active">
                        <section class="p-1" id="widgets-Statistics">
                            <div class="row">
                                <div class="col-md-8 d-flex">
                                    {{-- <button class="project-btn create-btn sub-btn"> Create Work Order </button> --}}

                                    <form action="{{ route('projects.index') }}" method="get" class="">
                                        <input type="hidden" value="un_invoice" name="invoice_item">
                                        <button type="submit"
                                            class="project-btn sub-btn {{ $active_btn == 'uninvoice-item' ? 'active' : '' }}">
                                            Uninvoice Work Order </button>
                                    </form>

                                    <form action="{{ route('projects.index') }}" method="get" class="ml-1">
                                        <input type="hidden" value="invoice" name="invoice_item">
                                        <button type="submit"
                                            class="project-btn sub-btn {{ $active_btn == 'invoice-item' ? 'active' : ' ' }}">
                                            Invoice Work Order </button>
                                    </form>
                                </div>
                                <div class="col-md-4 justify-content-end">
                                    <form action="{{ route('projects.index') }}" method="get" class="ml-1">
                                        <div class="form-group d-flex ">
                                            <input type="text" name="search" class="form-control search w-75"
                                                placeholder="Search Project">
                                            <!-- <button type="submit" class="project-btn action-btn {{ $active_btn }}">
                                                Search </button> -->
                                            <button type="submit" class="project-btn action-btn bg-info" title="Search" style="background: #9ba19c;color: white;">
                                                <div class="d-flex">
                                                    <div class="formSaveIcon">
                                                        <img src="{{ asset('assets/backend/app-assets/icon/searching-icon.png') }}" width="25">
                                                    </div>
                                                    <div><span>Search</span></div>
                                                </div>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="data-table table-responsive mt-2">
                                <table class="table table-sm">
                                    <thead style="background-color:#34465b !important;">
                                        <tr class="text-center">
                                            <th style="color:#fff;"> Project</th>
                                            <th style="color:#fff;"> Code </th>
                                            <th style="color:#fff;"> Customer </th>
                                            <th style="50%;color:#fff;"> Description </th>
                                            <th style="width:10%;color:#fff;" class="text-center"> amount ({{ $currency->symbole }})
                                            </th>
                                            <th style="min-width: 120px;color:#fff;" class="text-center"> Start Date </th>
                                            <th style="min-width: 120px;color:#fff;" class="text-center"> End Date </th>
                                            <th style="50%;color:#fff;" style="white-space: nowrap" title="Avarage Completed ">A.C
                                            </th>

                                            <th style="width:10%;color:#fff;" class="text-center"> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($projects as $project)
                                            <tr class="text-center">
                                                <td> {{ $project->project_name }} </td>
                                                <td> {{ $project->project_code }} </td>
                                                <td> {{ $project->party->pi_name }} </td>
                                                <td style="50%">
                                                    {{ Illuminate\Support\Str::limit($project->project_description, 40) }}
                                                </td>
                                                <td style="width:10%;" class="text-center"> {{ $project->total_budget }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $project->start_date?date('d/m/Y', strtotime($project->start_date)):'...' }} </td>
                                                <td class="text-center"> {{ $project->end_date?date('d/m/Y', strtotime($project->end_date)) :'...' }}
                                                </td>
                                                <td style="width:10%">
                                                    {{ $project->avarage_complete ? $project->avarage_complete : 0 }} %
                                                </td>


                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center">
                                                        <button class="project-btn btn-primary view-project"
                                                            data-id="{{ $project->id }}"
                                                            data-url="{{ route('projects.show', $project->id) }}"
                                                            data-invoice="{{ $project->is_invoice }}" title="View"><i class="fa fa-eye"></i> </button>

                                                        <a href="{{ route('tracking', [$project->id]) }}"
                                                            class="project-btn edit-project" style="margin-left: 0.2rem !important;background-color:#673ab7;" title="Track"><img src="{{asset('icon/track.png')}}"  style="height: 22px" alt=""></a>

                                                        <a href="#"
                                                            class="project-btn document_upload"
                                                            data-id="{{ $project->id }}"
                                                            data-url="{{ $project->project_name }}" title="Document" style="margin-left: 0.2rem !important;background-color:#0ead5e;" title="Document"><i class="fa fa-file-image" style="font-size:16px"></i>
                                                        </a>
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {!! $projects->links() !!}
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="project-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header print-hideen" style="padding: 5px 15px;background:#364a60;">
                    <h5 class="modal-title" id="exampleModalLabel" style="font-family:Cambria;font-size: 2rem;color:#fff;padding-left: 12px;"> View Project </h5>
                    <div class="d-flex align-items-center">
                        <a href="" class="project-btn bg-success print-job-project" target="_blank"  title="Print" style="margin-right: 0.2rem !important;">
                            <i class="bx bx-printer text-white" style="padding-top:4px;"></i>
                         </a>
                        <a href="" class="project-btn bg-info invoice-create" title="Genarate Invoice" style="margin-right: 0.2rem !important;">
                            <img src="{{asset('icon/generate.png')}}" class="img-fluid" style="height: 25px" alt="">
                        </a>
                        <button type="button" class="project-btn bg-danger text-white" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body" style="padding: 5px 15px;">

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example" id="createModel" tabindex="-1" rrole="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 5px 15px;background:#364a60;">
                    <h5 class="modal-title" style="font-family:Cambria;font-size: 2rem;color:#fff;padding-left: 5px;"> Document Upload </h5>
                    <div class="d-flex align-items-center">
                        <button type="button" class="project-btn bg-danger text-white" data-dismiss="modal"
                            aria-label="Close" style="margin:0 5px;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                </div>
                <div id="modal_content">

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="project-create-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 5px 15px;">
                    <h5 class="modal-title" id="exampleModalLabel"> Create WorkOrder </h5>
                    <div class="d-flex align-items-center">
                        <button type="button" class="project-btn bg-dark text-white" data-dismiss="modal"
                            aria-label="Close" style="margin:0 5px;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                </div>
                <div class="project-modal-body" style="padding: 5px 15px;">

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).on('mouseenter', '.date', function() {
            $('.date').datepicker({
                dateFormat: 'dd/mm/yy'
            });
        })
        $(document).on('click', '.view-project', function(e) {
            e.preventDefault();
            let project_id = $(this).attr('data-id');
            let url = $(this).attr('data-url');
            let lpo_print_url = "{{ route('job-project-print',":id") }}";
            lpo_print_url = lpo_print_url.replace(':id',project_id);
            $('.print-job-project').attr('href',lpo_print_url);

            let invoice = $(this).attr('data-invoice');

            if (invoice == 0) {
                let invoice_create_url = "{{ route('project.invoice.create', ':id') }}"
                invoice_create_url = invoice_create_url.replace(':id', project_id);
                $('.invoice-create').attr('href', invoice_create_url)
            } else {
                $('.invoice-create').hide();
            }


            $.get(url, function(res) {
                $('.modal-body').empty().html(res);
                $('.modal-title').html('Work Order');
                $('#project-modal').modal('show');
            })
        });

        $(document).on('click', '.document_upload', function(e) {
            e.preventDefault();
            let project_id = $(this).attr('data-id');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('document-upload-view') }}",
                method: "POST",
                data: {
                    project_id: project_id,
                    _token: _token,
                },
                success: function(response) {
                    $('#modal_content').html(response);
                    $("#createModel").modal('show');
                }
            });
        });
        $(document).on('click', '.delete_document', function(e) {
            var id = $(this).attr('id');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                method: "post",
                url: "{{ route('delete-job-document') }}",
                data: {
                    id: id,
                    _token: _token,
                },
                success: function(response) {
                    if (response == 1) {
                        $('#tr' + id).remove();
                        toastr.success("Document deleted", "Success");
                    }
                }
            });
        })

        $(document).on('click', '.print-page', function() {
            window.print();
        });
        $(document).on('click', '.create-btn', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('project.ajax.create') }}",
                type: 'get',
                success: function(res) {
                    $('.project-modal-body').empty().html(res);
                    $('#project-create-modal').modal('show');
                    $('.job-project-tasks').hide();
                    $('.select2').select2();
                },
                error: function(error) {
                    toastr.error("Connection error, Can't Create Project", "Warning")
                }
            })
        })
        $(document).on('change', '.project_name', function(e) {
            e.preventDefault();
            let id = $(this).find(':selected').attr('data-id');
            let url = "{{ route('get.lop.project', ':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'get',
                success: function(lpo_project) {
                    $('.customer_id').find('.customer_' + lpo_project.customer_id).prop('selected',
                        true);
                    $('.project_description').val(lpo_project.project_description);

                    let date = new Date(lpo_project.start_date);
                    let start_date = date.getDate() + '/' + (date.getMonth() + 1) + '/' + date
                        .getFullYear()
                    $('.start_date').val(start_date);
                    let enddate = new Date(lpo_project.end_date);
                    let end_date = enddate.getDate() + '/' + (enddate.getMonth() + 1) + '/' + enddate
                        .getFullYear()
                    $('.end_date').val(end_date);

                    $("#input-container").empty()

                    $.each(lpo_project.tasks, function(key, index) {
                        var inputGroup = "<tr>" +
                            "<td class='text-center'></td>" +
                            "<td style='width: 20%'>" +
                            "<input name='task_name[" + key + "]' value=" + index.task_name +
                            " type='text'  class='form-control' required>" +
                            "</td>" +
                            "<td style='width: 30%'>" +
                            "<textarea name='description[" + key +
                            "]'  cols='30' rows='1' class='form-control' required>" + index
                            .description + "</textarea>" +
                            "</td>" +
                            "<td>" +
                            "<input type='text' value=" + index.unit + "  name='unit[" + key +
                            "]' class='form-control unit text-center'>" +
                            "</td>" +
                            "<td>" +
                            "<input type='number' value=" + index.qty + "  name='qty[" + key +
                            "]' class='form-control qty text-center' step='any'>" +
                            "</td>" +
                            "<td>" +
                            "<input type='number' value=" + index.rate + " name='rate[" + key +
                            "]' class='form-control rate text-center' step='any' readonly>" +
                            "</td>" +
                            "<td>" +
                            "<input type='number' value=" + index.discount +
                            " name='discount[" + key +
                            "]' class='form-control discount text-center' step='any' readonly>" +
                            "</td>" +
                            "<td>" +
                            "<input type='number' value=" + index.amount + " name='amount[" +
                            key +
                            "]' class='form-control amount text-center' step='any' readonly>" +
                            "</td>" +
                            "</tr>";
                        $("#input-container").append(inputGroup);
                        $('.value-shoe-total').val(lpo_project.budget);
                        $('.show-discount-value').val(lpo_project.discount);
                        $('.tatal_amount_show').val(lpo_project.total_budget);
                        $('.job-project-tasks').show();
                        $('.select2').select2();
                    })

                    calculateBudget();

                },
                error: function(error) {
                    toastr.error("Connection error, Can't Create Project", "Warning")
                }
            })
        })

        function calculateBudget() {
            let total_budget = 0;
            let budget = 0
            $('.budget').each(function(index, el) {
                budget += parseFloat($(this).val())
            })
            $('.total_budget').each(function(index, el) {
                total_budget += parseFloat($(this).val())
            })
            $('.total-budget').val(parseFloat(total_budget).toFixed(2))
            $('.budget_sum').val(parseFloat(budget).toFixed(2))
            $('.total-vat').val(parseFloat(total_budget - budget).toFixed(2))
        }

        $(document).on("click", ".delete_items", function() {
            $(this).closest("tr").remove();
            calculateBudget();
        });

        $(document).on('click', '.add_items', function() {
            $.ajax({
                url: "{{ route('get.porjects.vat') }}",
                type: 'get',
                success: function(vats) {
                    var inputGroup = "<tr>" +
                        "<td class='text-center'></td>" +
                        "<td style='width: 20%'>" +
                        "<input type='text' name='task_name[]' class='form-control' required>" +
                        "</td>" +
                        "<td style='width: 30%'>" +
                        "<textarea name='description[]'  cols='30' rows='1' class='form-control' required></textarea>" +
                        "</td>" +
                        "<td>" +
                        "<input type='number' name='budget[]' class='form-control budget text-center' step='any'>" +
                        "</td>" +
                        "<td>"
                    inputGroup += "<select name='vat[]' class='vat form-control'>"
                    $.each(vats, function(key, index) {
                        inputGroup += "<option value=" + index.id + " data-value =" + index
                            .value + "> " + index.name + '  ( ' + index.value + ' )' +
                            " </option>"
                    })
                    inputGroup += "</select>" +
                        "</td>" +
                        "<td>" +
                        "<input type='number' name='total_budget[]' class='form-control total_budget text-center' step='any'>" +
                        "</td>" +
                        "<td class='text-center'>" +
                        "<button  type='button' class='delete_items project-btn'>" +
                        "<i class='bx bx-trash'> </i>" +
                        "</button>" +
                        "</td>" +
                        "</tr>";
                    $("#input-container").append(inputGroup);
                },
                error: function(error) {
                    toastr.error("Something rong Can't add column");
                }
            })
        });

        $(document).on('change', '.vat', function(event) {
            let tr = event.target
            calculateVat(tr);
        })

        $(document).on('keyup', '.budget', function(event) {
            let tr = event.target
            calculateVat(tr);
        })

        function calculateVat(node) {
            node = $(node).closest('tr');
            let vat = parseFloat(node.find('.vat').find(':selected').attr('data-value')) / 100;
            let budget = parseFloat(node.find('.budget').val())
            total_budget = budget + budget * vat;
            node.find('.total_budget').val(parseFloat(total_budget).toFixed(2));
            calculateBudget();
        }
    </script>
@endpush
