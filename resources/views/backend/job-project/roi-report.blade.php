@extends('layouts.backend.app')
@push('css')
@include('layouts.backend.partial.style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
<style>
    .report-header{
        background: #F5F7F8;
        padding:20px;
        border: 1px solid #ddd;
    }
    .right-side{
        display: flex;
        flex-direction: column;
        text-align: right;
    }
    .right-side .report-title, .left-side .report-title{
        font-weight:500;
        font-size:15px;
        color: #333;
    }
    p.report-title{
        font-weight:500;
        font-size:15px;
        color: #333;
        line-height: 25px;
        margin: 0;
    }

    .report-title small{
        color: #333;
        font-size: 10px;
    }

    .report-details .text-center{
        font-weight:500;
        font-size:15px;
        color: #333;
    }
    .report-details .text-center small{
        color: #333;
        font-size: 10px;
    }

    .report-table .table
    {
        border:1px solid rgb(40, 133, 196);
    }
    .report-table .table th,
    .report-table .table td{
        border-bottom: 1px solid rgb(40, 133, 196);
    }
    .report-table  .table thead{
        background:rgb(40, 133, 196);
    }
    .report-table .table thead th{
        color: #fff;
        text-transform: capitalize !important;
        font-weight: 500 !important;
        font-size: 12px;
        padding: 5px 10px;
    }
    .report-table  .table tbody td{
        color: #333;
        padding: 5px 10px;
        font-size: 12px !important;
        text-transform: capitalize !important;
        font-weight: 400 !important;
    }
    .report-table .table .not-receipt{
        color:rgb(226, 114, 40);
    }
    .report-table .table td.tax_invoice{
        background: rgba(29, 170, 29, 0.377);
        color: rgb(11, 107, 24);
    }

    .table thead th{
        color: #fff;
    }

    .model-report-titles h5{
        font-weight:500;
        font-size:15px;
        color: #333;
    }

    @media print{
        h5{
            color: #000 !important;
        }
        .nav.nav-tabs ~ .tab-content{
            border:none !important;
        }
        .report-table  .table thead th{
            color: #000 !important;
            text-transform: capitalize !important;
            font-weight: 500 !important;
        }
        .report-table  .table tbody td,.report-title{
            color: #000;
            font-weight: 500 !important;
        }
        .report-table .table
        {
            border: 1px solid #000 !important;
        }
        .report-table .table th,
        .report-table .table td{
            border: 1px solid #000 !important;
        }
    }
    .progress-bar {
        width: 100%;
        position: relative;
        height: 25px;
        text-align: center;
        padding: 5px 0;

    }
    .progress {
        position: absolute;
        width: 0%;
        top: 0;
        left: 0;
        z-index: 20;
        height: 100%;
        background-color: #4caf50;
        border-radius: 5px;
        text-align: center;
    }
    .progress-value{
        margin-top: 13px;
        position: absolute;
        z-index: 100;
        left: 10px;
    }
    .roi-box{
        position: relative;
    }
    .roi-formula{
        position: absolute;
        width: 400px;
        left: -300%;
        top: 0;
        border: 1px solid #ddd;
        z-index: 100;
        background: #fff;
        text-align: left;
        font-size: 16px;
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
                <div id="journaCreation" class="tab-pane active p-2">
                    <div class="mb-2 d-flex justify-content-between align-item-center">
                        @include('clientReport.project._report_submenu',['activeMenu' => 'roi'])
                        <form class="form print-hideen mt-1">
                            <div class="form-group d-flex">
                                <select name="project_id" id="project_id" class="form-control">
                                    <option value=""> Select Project </option>
                                    @foreach ($projects as  $item)
                                    <option value="{{$item->id}}" {{isset($project) ? $project->id == $item->id ? 'selected' : ' ' : ' '}}> {{$item->project_name}} </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn-primary btn-sm btn"> Search </button>
                                <button type="button" class="btn-secondary btn-sm btn ml-1" onclick="window.print()"> Print </button>
                            </div>
                        </form>
                    </div>

                    @if ($project)

                    <input type="hidden" value="{{$project->id}}" id="project_id">

                    <div>
                        @include('layouts.backend.partial.modal-header-info')

                        @php
                            $roi = 0;
                            if($project->bill_distribute->sum('amount') > 0){
                                $roi = (($project->total_budget - $project->bill_distribute->sum('amount')) /$project->bill_distribute->sum('amount') ) * 100;
                            }

                        @endphp


                        <div class="report-header d-flex justify-content-between">
                            <div class="left-side">
                                <h5 class="report-title"> Project Name : {{$project->project_name}} </h5>
                                <h5 class="report-title"> Project Contract Amount : {{$project->total_budget}} <small> ({{$currency->symbole}}) </small> </h5>
                                <h5 class="report-title"> Investment & Expense : {{$project->bill_distribute->sum('amount')}} <small> ({{$currency->symbole}}) </small> </h5>
                                <h5 class="report-title"> Receipt : {{$receiveds->sum('total_amount')}} <small> ({{$currency->symbole}}) </small> </h5>
                                <h5 class="report-title"> Payable : {{$project->purchase_expense->sum('due_amount')+$project->temp_paid()}} <small> ({{$currency->symbole}}) </small> </h5>
                                <h5 class="report-title"> Receivable : {{$receivables->sum('due_amount')+$project->temp_receipt()}} <small> ({{$currency->symbole}}) </small> </h5>

                                <h5 class="report-title"> VAT Calculation    </h5>
                                <h5 class="report-title pl-1"> Output VAT:  {{$project->invoicess->where('paid_amount','>',0)->sum('vat')}} <small> ({{$currency->symbole}}) </small> </h5>
                                <h5 class="report-title pl-1"> Input VAT:  {{$project->purchase_expense->where('paid_amount','>',0)->sum('vat')}} <small> ({{$currency->symbole}}) </small> </h5>

                            </div>

                            <div class="right-side">

                                <h5 class="report-title"> Date : {{date('d/m/Y')}} </h5>

                                <div class="roi-box">
                                    <h5 class="report-title roi">
                                        ROI : {{number_format($roi,2)}} % <span> <i class='bx bx-purchase-tag' style="font-size: 13px"></i> </span>
                                   </h5>
                                   <div class="roi-formula p-2 border-1 d-none">
                                        <p class="report-title"> <span style="color: #4caf50"> PCA = {{$project->total_budget}} </span>  </p>
                                        <p class="report-title"> <span style="color:rgb(211, 58, 58)"> IE = {{$project->bill_distribute->sum('amount')}} </span>  </p>
                                        <p class="report-title" style="margin:0; line-height:20px; font-size:16px;"> ROI = (<span style="color: #4caf50"> PCA </span> -  <span style="color: rgb(211, 58, 58)"> IE </span>) / <span style="color: rgb(211, 58, 58)"> IE </span> * 100 </p>
                                        <p class="report-title"> = ({{$project->total_budget}} - {{$project->bill_distribute->sum('amount')}} ) / {{$project->bill_distribute->sum('amount')}} * 100   = {{number_format($roi,2)}}</p>

                                        <p class="report-title"> Where, </p>

                                        <p class="report-title"> PCA = Project Contract Amount </p>
                                        <p class="report-title"> IE = Investment & Expense </p>

                                    </div>
                                </div>

                                <h5 class="report-title">
                                    Working progress
                                </h5>
                                <div class="bg-danger progress-bar text-center">
                                    <p class="progress-value" style="padding:5px 0px;color:#fff;font-size:16px;" data-value="{{number_format($project->tasks->sum('completed')/$project->tasks->count(),2)}}">  </p>
                                    <p class="progress" data-value="{{number_format($project->tasks->sum('completed')/$project->tasks->count(),2)}}">  </p>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-6 report-details" data-title="expense">
                                <h5 class="text-center"> Investment & Expense {{number_format($project->bill_distribute->sum('amount'),2)}} <small> ({{$currency->symbole}}) </small>  </h5>
                                <div class="report-table table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th class="text-center"> Task </th>
                                                <th class="text-center"> Working progress </th>
                                                <th class="text-center"> Expense <small>({{$currency->symbole}}) </small> </th>
                                                <th class="text-center"> Return <small> ({{$currency->symbole}})  </small> </th>
                                                <th class="text-center"> ROI % </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $total_roi = 0;
                                                $avarage_roi = round($total_roi/$project->tasks->count());
                                            @endphp
                                            @foreach($project->tasks as $task)
                                            <tr>
                                                @php
                                                    $task_expenses = $task->task_expenses?$task->task_expenses->sum('amount') : 0;
                                                    if($task_expenses){
                                                        $task_amount = $task->amount;
                                                        $roi = (($task_amount - $task_expenses)/$task_expenses * 100) ;
                                                    }else{
                                                        $roi = 0;
                                                    }
                                                    $total_roi += $roi;
                                                @endphp
                                                <td class="text-center"> {{$task->task_name}} </td>
                                                <td class="text-center"> {{$task->completed}} % </td>
                                                <td class="text-center"> {{$task->task_expenses?$task->task_expenses->sum('amount') : ' '}} </td>
                                                <td class="text-center"> {{$task->amount}} </td>
                                                <td class="text-center"> {{number_format($roi,2)}} % </td>
                                            </tr>
                                            @endforeach
                                            @php
                                                $total_expense = 0;
                                            @endphp
                                            @foreach ($project->purchase_expense as $expense)
                                                @php
                                                $total_expense += $expense->items->sum('total_amount');
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-6 report-details">
                                <h5 class="text-center"> Investment & Expense Vs Return  </h5>
                                <canvas id="roi_chart" class="w-100" style="min-height:280px; max-height:450px;"> </canvas>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-6 col-xl-4 report-details" data-title="payble">
                                <h5 class="text-center"> Payble {{$paybles->sum('due_amount')+$project->temp_paid()}} <small> ({{$currency->symbole}}) </small> </h5>
                                <div class="report-table table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th class="text-center"> date </th>
                                                <th class="text-center"> Amount <small>({{$currency->symbole}}) </small> </th>
                                                <th class="text-center"> Remark </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($paybles as $item)
                                            <tr>
                                                <td class="text-center"> {{date('d/m/Y',strtotime($item->date))}} </td>
                                                <td class="text-center"> {{$item->due_amount+$item->tem_paid_amount()}} </td>
                                                <td class="text-center"> {{\Illuminate\Support\Str::limit($item->narration, 15, $end='...') }} </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-6 col-xl-4 report-details" data-title="receivable">
                                <h5 class="text-center"> Receivable {{$receivables->sum('due_amount')+$project->temp_receipt()}} <small> ({{$currency->symbole}}) </small> </h5>
                                <div class="report-table table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th class="text-center"> date </th>
                                                <th class="text-center"> Amount <small>({{$currency->symbole}}) </small> </th>
                                                <th class="text-center"> Remark </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($receivables as $item)
                                            <tr>
                                                <td class="text-center"> {{date('d/m/Y',strtotime($item->date))}}  </td>
                                                <td class="text-center"> {{$item->due_amount+$item->tem_receipt_amount()}} </td>
                                                <td class="text-center"> From projec </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="col-6 col-xl-4 report-details" data-title="received">
                                <h5 class="text-center"> Received {{$receiveds->sum('total_amount')}} <small> ({{$currency->symbole}}) </small>  </h5>
                                <div class="report-table table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th class="text-center"> date </th>
                                                <th class="text-center"> Amount <small>({{$currency->symbole}}) </small> </th>
                                                <th class="text-center"> Remark </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($receiveds as $item)
                                            <tr>
                                                <td class="text-center"> {{date('d/m/Y',strtotime($item->date))}} </td>
                                                <td class="text-center"> {{$item->total_amount}} </td>
                                                <td class="text-center"> {{\Illuminate\Support\Str::limit($item->narration, 15, $end='...') }} </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="divFooter mb-1 ml-1 invoice-view-wrapper student_profle-print">
                    Business Software Solutions by
                    <span style="color: #0005" class="spanStyle"><img class="img-fluid"
                            src="{{ asset('img/zisprink.png') }}" alt="" width="70"></span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Model  --}}
<div class="modal fade bd-example-modal-lg" id="voucherPreviewModal" tabindex="-1" rrole="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div id="voucherPreviewShow">

        </div>
      </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="childModal">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div id="childModalContent">

        </div>
      </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('js/plugin/chart.js') }}"></script>
<script>

    $(document).ready(function(){
        var project_id = $('#project_id').val();
        var url = "{{route('roi.report.chart',':id')}}",
        url = url.replace(':id',project_id);
        $.ajax({
            type:'get',
            url:url,

            success:function(data){
                barChart(data);
            }
        })

        //working-progress bar

        var value = $('.progress').data('value');
        var counter = 0;

        let process = setInterval(() => {
            $('.progress-value').html(counter + '%');
            $('.progress').css('width',`${counter}%`)
            if(counter >= value){
                clearInterval(process);
            }
            counter++;
        }, 15);

    })

    function barChart(data){
        var labels = [];
        var data_1 = [];
        var data_2 = [];
        $.each(data.labels,function(key,value){
            labels.push(value);
        })

        $.each(data.value.data_1,function(key,val){
            if(val == null){
                val = 0;
            }
            data_1.push(val);
        })

        $.each(data.value.data_2,function(key,val){
            if(val == null){
                val = 0;
            }
            data_2.push(val);
        })
        var myChart = new Chart('roi_chart', {
            type: 'bar',
            data: {
                labels:labels,
                datasets: [{
                    label: data.value.label_1,
                    data: data_1,
                    backgroundColor: '#F24C3D', // Red color with some transparency
                }, {
                    label: data.value.label_2,
                    data: data_2,
                    backgroundColor: '#38E54D', // Green color with some transparency
                }]
            },
        });
    }

    $(document).on('click','.report-details',function(){
        let report_title = $(this).attr('data-title');
        let url = "{{route('roi.report.details')}}";
        $.ajax({
            type:'post',
            url:url,
            data:{
                _token: $('input[name="_token"]').val(),
                title:report_title,
                id: $('#project_id').val(),
            },
            success:function(res){
                $('#voucherPreviewShow').empty().append(res);
                $('#voucherPreviewModal').modal('show');
            }
        })
    })

    $(document).on('click','.item-details',function(){
        let parent_id = $(this).attr('data-id');
        let type = $(this).attr('data-type');

        if(type == 'expense'){
            var url = "{{ URL('purch-exp-modal') }}";
        }else if(type == 'sale'){
            var url = "{{URL('sale-modal')}}";
        }
        console.log(type,parent_id,url);
        $.ajax({
            type: "post",
            url:url,
            data:{
                _token: $('input[name="_token"]').val(),
                id: parent_id,
            },
            success:function(res){
                $('#childModalContent').empty().append(res);
                $('#childModal').modal('show');
            }
        })
    })

    $(document).on('mouseenter','.roi',function(){
        $('.roi-formula').removeClass('d-none');
    })

    $(document).on('mouseleave','.roi',function(){
        $('.roi-formula').addClass('d-none');
    })

</script>

@endpush
