@extends('layouts.backend.app')

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
               
                <!-- Bordered table start -->
                <div class="row" id="table-bordered">
                    <div class="col-12">
                        <div class="card">
                            <form action="" method="GET">
                                <div class="card-header d-flex">
                                    <div class="mr-auto p-2">
                                        <h4 class="card-title">Employee Leave</h4>
                                    </div>
                                    <div class="pr-2">
                                        <input type="text" id="search" name="search" class="form-control" @isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="Search Employee Name">
                                    </div>
                                    <div>
                                        <a href="{{ route('employee-leave-create')}}" class="btn btn-primary">Add Leave</a>
                                    </div>
                                </div>
                            </form>
                            <div class="card-body">
                                <!-- table bordered -->
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-2">
                                        <thead>
                                            <tr>
                                                <th>Employee ID</th>
                                                <th>Employee Name</th>
                                                <th>From date</th>
                                                <th>To date</th>
                                                <th>Days leave</th>
                                                <th>Leave Reason</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employee_leaves as $employee_leave)
                                                <tr>
                                                    <td>{{$employee_leave->employee_id}}</td>
                                                    <td>{{$employee_leave->employee_name}}</td>
                                                    <td>{{$employee_leave->from_date}}</td>
                                                    <td>{{$employee_leave->to_date}}</td>
                                                    <td>{{$employee_leave->days_leave}} days</td>
                                                    <td>{{$employee_leave->leave_reason}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $employee_leaves->links() }}
                                </div>                            
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Bordered table end -->



            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('js')
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}
    <script>
        // $(document).ready(function() {
            // Page Script
            // alert("Alhamdulillah");
        // });
    </script>
@endpush