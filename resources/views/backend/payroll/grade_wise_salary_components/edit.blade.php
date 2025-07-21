@extends('layouts.backend.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
<style>
    .card {
        margin-bottom: 0.3rem !important;
        }
    h5 {

        line-height: 0.2 !important;
    }
</style>
@endpush
@section('content')
@include('layouts.backend.partial.style')


<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
                <a href="{{route("grade-wise-salary-components.index")}}" class="nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/gradeeise-icon.png')}}" alt="" srcset="" class="img-fluid" width="55">
                    </div>
                    <div>Gradewise Salary Component</div>
                </a>
                <a href="{{route("salary-structures.index")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/component-icon.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Salary Component</div>
                </a>
                <a href="{{route("grades.index")}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false" id="mJournalAuthorizationSection">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/grade-icon.jpg')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Grades</div>
                </a>
            </div>
            <div class="tab-content bg-white">
                <div id="parentProfileList" class="tab-pane active">
                    <div class="content-body">
                        <div class="row" id="table-bordered">
                            <div class="col-12">
                                <div class="cardStyleChange">
                                    <h4 class="ml-2 mt-2">Grade Wise Salary Component</h4>
                                    <div class="card-body">
                                            <!-- table bordered -->
                                            <form class="form form-vertical" action="{{ route('grade-wise-salary-components.update',  $grade->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row d-flex justify-content-end">
                                                    <div class="col-md-3">
                                                        Year
                                                        <input type="text" class="form-control" min="2020" name="date" placeholder="DD/MM/YY" id="datepicker" required>
                                                    </div>
                                                    <input type="hidden" class="form-control" name="grade_id" value="{{ $grade->id }}"  required>
                                                </div>
                                                @method('PUT')
                                                <table class="table mb-0 table-sm table-hover" >
                                                    <thead  class="thead-light">
                                                        <tr style="height: 50px;">
                                                            <th> <input type="checkbox" id="vehicle1" class="btn-select-all"  name="vehicle1" value="Bike">
                                                                <label for="vehicle1">Check All</label>
                                                                </th>
                                                            <th >Head</th>
                                                            {{-- <th>Type</th> --}}
                                                            <th class="text-center">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    @php
                                                        $l_count=0;
                                                    @endphp
                                                    <tbody class="table-sm">
                                                        @php
                                                            $i=0;

                                                        @endphp
                                                        @foreach ($components as $component)
                                                        @php
                                                            ++$i;
                                                        @endphp
                                                        <tr class="trFontSize">
                                                            <td><input type="checkbox" id="" class="checkbox-record check" name="records[head][{{ $i }}]" {{ $grade->feeCheck($component->id)? 'checked':"" }}   value="{{$component->id}}"></td>

                                                            <td>{{$component->name}}</td>
                                                            <td class="d-none">
                                                                <select name="records[type][{{ $i }}]" id="" class="form-control check-dep " >
                                                                    <option value="">Select...</option>
                                                                    @foreach ($component_types as $component_type)
                                                                        <option value="{{$component_type->id}}" {{$component_type->id == 2?'selected':''}}>{{$component_type->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td><input type="number" name="records[amount][{{ $i }}]" value="{{ $grade->feeAmount($grade->id,$component->id) }}" class="form-control check-dep2" id=""></td>

                                                        </tr>
                                                        @endforeach


                                                    </tbody>
                                                </table>
                                                <p class="text-right"><button class="btn btn-info mt-1" type="submit">Procced</button></p>

                                            </form>
                                        </div>
                                        {{-- <div class="ml-5">{{ $employees->links() }}</div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div id="printArea" class="d-none">
        </div>
    </div>
</div>

@endsection
@push('js')

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
 <script type="text/javascript">
     $(function() {
             $("#datepicker").datepicker({ dateFormat: "dd/mm/yy" }).val()
     });
 </script>
<script>
    $(document).ready(function() {

        $(document).on("click", ".check", function(e) {

        $(this).closest(".check-dep").removeAttr('required');
        $(this).closest(".check-dep2").removeAttr('required');

        });
        // Page Script
        // $('#edit_all').click(function (event) {
            $(document).on("click", "#edit_all", function(e) {

            if (this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function () {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function () {
                    this.checked = false;
                });
            }
        });


        $('.btn-select-all').click(function (event) {
        if (this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function () {
                this.checked = true;
            });
        } else {
            $(':checkbox').each(function () {
                this.checked = false;
            });
        }
    });

    });
</script>
@endpush