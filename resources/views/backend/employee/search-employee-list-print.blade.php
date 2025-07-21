@extends('layouts.print_app')
@section('content')
<h2 class="text-center">Employee List @if ($employee_role) Of {{ $employee_role}} @endif</h2>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>SL No</th>
                        <th>Name</th>
                        <th>Nationality</th>
                        <th>Emirates Num</th>
                        <th>Designation</th>
                        <th>Pass Country</th>
                        <th>Local Address</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $key => $employee)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $employee->fname. ' '.$employee->mname. ' '.$employee->family_name  }} </td>
                        <td>{{ $employee->nationality }} </td>
                        <td>{{ $employee->emirates_id_num }} </td>
                        <td>{{ $employee->employee_role }} </td>
                        <td>{{ $employee->passport_country }} </td>
                        <td>{{ $employee->local_address }} </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>                            
    </div>
@endsection
                                    