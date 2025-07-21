<div>
    @php
        use Carbon\CarbonPeriod;
    @endphp
    <style>
        .form input[type=radio], form input[type=radio] {

            width: 6.5rem;
        }
    </style>
    {{-- **************** Employees create modal start************************ --}}
        <div class="modal fade" style="width: 60%;left: 20%; top: -40px" id="payslip-modal" tabindex="-1"
            role="dialog" aria-labelledby="employee-modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="height: 50px">
                        <div class="row">
                            <div class="col-md-10">
                                <h5 class="modal-title">ATTENDANCE</h5>
                            </div>
                            <div class="col-md-12 text-right">

                                <button type="botton" style="margin-top: -34px;" class="btn btn-sm " data-dismiss="modal">
                                    <span aria-hidden="true" class="icon-style">&times;</span></button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <form class="form form-vertical" action="{{route('employee-attendence.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf 
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-1">
                                            <div class="form-group">
                                                <input type="date" id="date" class="form-control @error('date') error @enderror" name="date" value="{{ isset($inputs) ? $inputs['date'] : old('date')}}" required>
                                                @error('date')
                                                <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-6">
                                            <p class="text-right">
                                                <button type="button" class="btn btn-success present-all ">Present All</button>
                                                <button type="button" class="btn btn-success absent-all">Absent All</button>
                                            </p>
                                        </div> --}}
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table mb-0 table-sm table-hover">
                                                    <thead  class="thead-light">
                                                        <tr style="height: 50px;">
                                                            <th>Name</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($employees as $employee)
                                                        <tr class="trFontSize">
                                                            <td>{{ $employee->first_name.' '.$employee->last_name}}</td>
                                                            <td>
                                                                <ul class="list-unstyled mb-0">
                                                                    <li class="d-inline-block">
                                                                        <fieldset>
                                                                            <div class="radio">
                                                                                <input type="radio" class="present-status" name="status[{{$employee->id}}]" id="present-{{$employee->id}}" checked value="1" >
                                                                                <label for="present-{{$employee->id}}">Present</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    <li class="d-inline-block">
                                                                        <fieldset>
                                                                            <div class="radio">
                                                                                <input type="radio" class="absent-status" name="status[{{$employee->id}}]" id="absent-{{$employee->id}}" value="0">
                                                                                <label for="absent-{{$employee->id}}">Absent</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary mt-1 pt-1">Save Attendance</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{-- **************** Employees create modal end ************************ --}}

    {{-- **************** Employees create modal start************************ --}}
    <div class="modal fade" style="width: 60%;left: 20%; top: -40px" id="search-modal" tabindex="-1"
        role="dialog" aria-labelledby="search-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="height: 50px">
                    <div class="row">
                        <div class="col-md-10">
                            <h5 class="modal-title">ATTENDANCE SHEET SEARCH</h5>
                        </div>
                        <div class="col-md-12 text-right">
                            <button type="botton" style="margin-top: -34px;" class="btn btn-sm " data-dismiss="modal">
                                <span aria-hidden="true" class="icon-style">&times;</span></button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form class="form form-vertical" method="get" enctype="multipart/form-data">
                            <section id="basic-vertical-layouts">
                                <div class="row match-height">
                                    <div class="col-md-12 col-12">
                                        <div class="cardStyleChange">
                                            <div class="card-body">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-6 col-12">
                                                            <label for="date">Date</label>
                                                                <input type="month" id="date" class="inputFieldHeight form-control @error('date') error @enderror" name="date" value="{{ isset($inputs) ? $inputs['date'] : old('date')}}" required>
                                                                @error('date')
                                                                <span class="error">{{ $message }}</span>
                                                                @enderror
                                                        </div>
                                                        <div class="col-12 col-md-6 d-flex justify-content-end">
                                                            {{-- <button type="submit" class="btn btn-primary mr-1">Search</button> --}}
                                                            <button type="submit" class="btn btn-primary formButton mSearchingBotton mt-1 mb-1" title="Searching" >
                                                            <div class="d-flex">
                                                                <div class="formSaveIcon">
                                                                    <img src="{{asset('assets/backend/app-assets/icon/searching-icon.png')}}" alt="" srcset="" width="20">
                                                                </div>
                                                                <div><span> Search</span></div>
                                                            </div>
                                                        </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                        
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- **************** Employees create modal end ************************ --}}

    {{-- **************** Employees edit modal ************************ --}}

    <div class="modal fade" style="width: 100%;" id="employee-modal-edit" tabindex="-1"
        role="dialog" aria-labelledby="employee-modal-edit" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mt-5" role="document">
            <div class="modal-content" id="edit-modal">
                
                       
            </div>
        </div>
    </div>
    {{-- **************** Employees  edit  modal end ************************ --}}
</div>
