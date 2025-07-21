@extends('layouts.backend.app')

@push('css')
    
@endpush

@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <form class="form form-vertical"  action="{{route('employee-leave-store')}}" method="POST" enctype="multipart/form-data">
                @csrf 
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col-md-12 col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4 class="card-title">Employee Leave</h4>
                                </div>
                                <div class="card-body">
                                        <div class="form-body">
                                            <div class="row">                            
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>Employee Name</label>
                                                    <select name="employee_name" class="form-control" required onchange="employee()" id="select_id">
                                                        <option value="">Select Name</option>
                                                        @foreach ($employees as $employee)
                                                            <option value="{{$employee->id}}">{{$employee->fname}} {{$employee->mname}}</option>
                                                        @endforeach
                                                    </select>
                                                    </div>
                                                </div>
                            
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>Employee ID Number</label>
                                                    <input type="text" name="employee_id" class="form-control" value="" id="employee_id">   
                                                    </div>
                                                </div>
                            
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>From Date</label>
                                                    <input type="date" name="from_date" placeholder="dd/mm/yyyy" required class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>To Date</label>
                                                    <input type="date" name="to_date" placeholder="dd/mm/yyyy" required class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>Days leave</label>
                                                    <input type="number" name="days_leave" required class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                    <label>Leave Reason</label>
                                                    <input type="text" name="leave_reason" placeholder="Leave Reason" required class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary mr-1">
                                                        Save
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
@endsection

@push('js')
    <script>
        // employee fetch and set
        function employee(){
            var employee_id = document.getElementById("select_id").value;
            document.getElementById("employee_id").value = employee_id;
        }
    </script>
@endpush