@extends('layouts.backend.app-print')
@section('content')
<style>
    @media print{
        .list-print{
            display: block;
            position: absolute;
            left: 0;
            top: 0;
        }
        html, body {
            border: 1px solid white;
            height: 99%;
            width: 100%;
            page-break-after: avoid !important;
            page-break-before: avoid !important;
        }
    }
</style>
<table class="table mb-0 table-sm">
    <thead  class="thead-light">
        <tr style="height: 50px;">
            <th>Name</th>
            <th>Email</th>
            <th>Nationality</th>
            <th>Emirates Num</th>
            <th>Designation</th>
            <th>Address</th>
        </tr>
    </thead>
    <tbody class="table-sm">
        @foreach ($employeis as $employee)
        <tr class="border-bottom" style="font-size: 12px;">
            <td>{{ $employee->fname. ' '.$employee->mname. ' '.$employee->family_name  }} </td>
            <td>{{ $employee->email }} </td>
            <td>{{ $employee->nationality }} </td>
            <td>{{ $employee->emirates_id_num }} </td>
            <td>{{ $employee->employee_role }} </td>
            <td>{{ $employee->permanent_address }} </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection