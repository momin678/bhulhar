@extends('layouts.backend.app')
@push('css')
@include('layouts.backend.partial.style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<style>
    body{
		    counter-reset: Serial;
	}
    .project-btn{
        border: none;
        color: #fff;
        font-size: 15px;
        font-weight: 500px;
        padding:3px 10px;
        border-radius: 5px;
    }
    .add_items{
        background: #4CB648;
    }
    .delete_items{
        background: #EA5455;
        padding:3px 3px 2px 3px;
        font-size: 13px;
    }
    .auto-index td:first-child:before{
        counter-increment: Serial;      /* Increment the Serial counter */
        content:  counter(Serial);  /* Display the counter */
    }
    .auto-index,.auto-index th,.auto-index td{
        border: 1px solid #ddd;
    }
    .auto-index,.auto-index td{
        border: 1px solid #ddd;
        padding: 0 !important;
        margin: 0 !important;
    }
    #input-container .form-control{
        border: none;
    }
    #input-container .form-control:focus{
        border: 1px solid #4CB648;
    }
    .tasks-title, .budget-title{
        font-size: 16px;
        color: #313131;
        font-weight: 500;
        text-transform: capitalize;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        font-size: 16px !important;
    }

    .select2-container--default .select2-selection--single {
        height: 35px !important;
    }
    .add-customer{
        background: #4A47A3;
        padding:2px 4px !important;
        margin:0 !important;
    }
    .save-btn{
        background: #406343;
    }
    input.form-control{
        height: 35px !important;
    }
    .form-control{
        color: #444;
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
                        <form class="" action="{{route('traking-store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex">
                                <div class="form-group w-100">
                                    <input type="hidden" name="project_id" value="{{$project->id}}">

                                    <label for=""> Project Name </label>
                                    <input type="text" name="project_name" readonly value="{{ old('project_name',$project->project_name) }}" autocomplete="off"
                                    class="form-control @error('project_name') is_invalid @enderror" placeholder="Project name" style="margin-top:5px;">

                                    @error('project_name')
                                        <p class="text-danger"> {{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group w-100 ml-1">
                                    <div class="d-flex justify-content-between" style="margin-bottom: 3px;">
                                        <label for=""> Customer Name </label>

                                    </div>
                                    <select disabled name="customer_id" class="form-control customer_id @error('customer_id') is-invalid @enderror">
                                        <option  selected disabled> Select Customer </option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ old('customer_id',$project->customer_id) == $customer->id ? 'selected' : ' ' }}> {{ $customer->pi_name }} </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <p class="text-danger"> {{ $message }}</p>
                                    @enderror
                                </div>

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
                                        <th class="text-center"> Completed % </th>


                                    </tr>
                                </thead>
                                <tbody id="input-container">
                                    @foreach ($project->tasks as $item)
                                    <tr>
                                        <td class="text-center"> </td>
                                        <td style="width: 75%">
                                            <input type="hidden" name="task_id[]" value="{{$item->id}}">
                                            <input type="text" name="task_name[]" class="form-control @error('task_name') is-invalid @enderror" required value="{{ $item->task_name }}" autocomplete="off">
                                        </td>

                                        <td style="width: 20%">
                                            <input type="number" name="completed[]" value="{{ $item->completed }}" min="0" max="100" class="form-control" step="any" required>
                                        </td>



                                    </tr>
                                    @endforeach<tr>

                                </tbody>

                            </table>
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

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    <script>
        $(document).ready(function() {
            $('.customer_id').select2();
            $(".add_items").click(function () {
                addInput();
            });

            $('.date').datepicker({dateFormat:'dd/mm/yy'})


        });



     </script>
@endpush
