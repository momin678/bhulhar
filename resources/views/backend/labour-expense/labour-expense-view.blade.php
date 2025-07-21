
<style>
    @media print{
        html, body{
            overflow: hidden;
        }
    }
</style>
<section class="print-hideen border-bottom">
    <div class="d-flex flex-row-reverse">
        <div class="py-1 pr-1"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
        <div class="py-1 pr-1"><a href="#" onclick="window.print();" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
        {{-- <div class="py-1 pr-1"><a href="#" onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
    </div>
</section>
@include('layouts.backend.partial.modal-header-info')
<section class="mediaPrint">
    <div class="content-wrapper mt-2 ">
        
    </div>
    <div class="pt-2 m-2">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>
                    <span class="spanStyle"> Labour Expense </span>
                </h2>
            </div>
        </div>
        <div class="row pt-3 mr-2">
            <div class="col-12">
                <table class="table tableStyle table-sm smTableStyle">
                    <tr>
                        <td>Truck Number: {{ $expenses->truck_number}}</td>
                        <td>Date: {{$expenses->date}}</td>
                        <td>Total Amount: {{$expenses->total_amount}}</td>
                    </tr>
                </table>

                <table class="table table-sm mt-1 smTableStyle">
                    <thead  class="thead-light">
                        <tr class="mTheadTr">
                            <th>Employee Name</th>
                            <th>Remark</th>
                            <th class="text-right">Hours</th>
                            <th class="text-right">Rate</th>
                            <th class="text-right pr-1">Total Amount</th>
                        </tr>
                    </thead>
                        @foreach ($expence_list as $item)
                            <tr>
                                <td>{{$item->employee->name}}</td>
                                <td>{{$item->remark}}</td>
                                <td class="text-right">{{$item->hours}}</td>
                                <td class="text-right">{{$item->rate}}</td>
                                <td class="text-right pr-1">{{$item->total_amount}}</td>
                            </tr>
                        @endforeach
                    <tr class="border-bottom">
                        <td colspan="4">Total Amount</td>
                        <td class="text-right pr-1">{{$expence_list->sum('total_amount')}}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row pt-4">
            <div class="col-12 text-center">
                <h3>Supporting Document</h3>
                @if ($expenses->voucher_scan != '')
                <img src="{{asset('storage/upload/labour-expanse')}}/{{$voucher->voucher_scan}}" class="img-fluid" style="height: 490px" alt="">    
                @endif                
            </div>

        </div>
    </div>
    <div class="divFooter ml-1 ml-2">
        Business Software Solutions by
        <span style="color: #0005" class="spanStyle"><img class="img-fluid" src="{{ asset('img/zisprink.png')}}" alt="" width="70"></span>
    </div>
</section>
    


