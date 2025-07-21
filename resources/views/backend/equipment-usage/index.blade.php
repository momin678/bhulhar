@extends('layouts.backend.app')
@push('css')
<style>
    .print-title{
        display: none;
    }

    @media print {
        .tab-content{
            border:none !important;
        }
        @page {
             max-width: 10px;
       }
        .print-section-header{
            display: block !important;
        }
        body {
            margin: 0px;
            padding: 0px !important;
        }
        .print-title{
            display: block;
        }
        table .badge{
            color: black!important;
            padding: 0px !important;
            margin-left: 0px;
            border:none;
        }

        table {
            padding-right: 10px;
            padding-left: 10px;
            border-collapse: separate;
            border-right: 1px solid black;
            border-top: 1px solid black;
        }
        table  th,
        table td{
            text-align: left;
            padding:5px 15px;
            border-bottom: 1px solid black !important;
            border-left: 1px solid black !important;
            border-collapse: separate;

        }
        .hide-in-print{
            display: none !important;
        }
        th{
            color: #000 !important;
        }
        th, td{
            text-align: center !important;
        }
    }

</style>
@endpush
@section('content')
@include('backend.tab-file.style')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @include('clientReport.inventory._header',['activeMenu' => 'equipment'])

            <div class="tab-content bg-white">
                <div id="studentProfileList" class="tab-pane active">

                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="cardStyleChange">
                                <div class="card-header d-flex align-items-center">
                                    <button type="button" class="btn btn-primary formButton" title="Add" data-toggle="modal" data-target="#newBookAdd">
                                        <div class="d-flex">
                                            <div class="formSaveIcon">
                                                <img src="{{asset('assets/backend/app-assets/icon/add-icon.png')}}" width="25">
                                            </div>
                                            <div><span>Add</span></div>
                                        </div>
                                    </button>
                                    <div class="mIconStyleChange"><a href="#"  onclick="printDiv('print-table')" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
                                </div>
                                <div class="px-2 mb-2">
                                    @if ($items->count() > 0)

                                    <div class="table-responsive" id="print-table">
                                        @include('layouts.backend.partial.modal-header-info')
                                        <p class="print-title"> Books {{ date('d/m/y') }} </p>
                                        <table class="table table-hover mb-0 table-sm">
                                            <thead  class="thead-light">
                                                <tr style="height: 40px;">
                                                    <th class="pl-1"> Item Name </th>
                                                    <th> Used By </th>
                                                    <th> Name </th>
                                                    <th> Purpose </th>
                                                    <th> Date </th>
                                                    <th class="text-right hide-in-print pr-1">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($usage_items as $usage_item)
                                                    <tr class="trFontSize">
                                                        <td class="pl-1"> {{ $usage_item->item->name }} </td>
                                                        <td> {{ $usage_item->used_by }}</td>
                                                        <td> {{$usage_item->name}}</td>
                                                        <td>{{ $usage_item->purpose }}</td>
                                                        <td>{{ date('m/d/Y',strtotime($usage_item->created_at)) }}</td>

                                                        <td class="text-right pr-2 hide-in-print">
                                                            @if ($usage_item->status == 1)
                                                                <span class="ml-1">
                                                                    <i class="bx bx-check text-success" style="font-size: 25px;padding-left:10px;"></i>
                                                                </span>
                                                            @else
                                                                <a href="#" class="btn edit" title="Edit" data-url="{{route('usage.edit',$usage_item->id)}}" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px;"><img src="{{asset('assets/backend/app-assets/icon/view-icon.png')}}" alt="" srcset="" style=" height: 30px; width: 30px;"></a>
                                                            @endif

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="print-section-header"  style="position: fixed; bottom: 0; display:none;">
                                            @include('layouts.backend.partial.modal-footer-info')
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        {{ $usage_items->links() }}
                                    </div>
                                    @else
                                    <p> Equipment Not Found ! </p>
                                    @endif

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="newBookAdd" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        @include('backend.equipment-usage.create')
      </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="editModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <div id="bookEditDetails">
        </div>
      </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).on("click", ".edit", function(e) {
        e.preventDefault();
        var url= $(this).attr('data-url');
        $.ajax({
            url: url,
            method: "get",

            success: function(response){
                document.getElementById("bookEditDetails").innerHTML = response;
                $('#editModal').modal('show');
            }
        });
    });
    $(document).on('mouseenter', '.items',function(){
        $(this).select2();
    })
    function printDiv(table) {
        var printContents = document.getElementById(table).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
@endpush

