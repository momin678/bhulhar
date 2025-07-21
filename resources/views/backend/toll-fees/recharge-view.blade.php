<style>
    html, body {
        height:100%;
        overflow: hidden;
    }
</style>
<section class="print-hideen border-bottom">
    <div class="d-flex flex-row-reverse">
        <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
        <div class="mIconStyleChange"><a href="#"  onclick="handlePrintClick('widgets-Statistics1')" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
    </div>
</section>
{{-- @include('layouts.backend.partial.modal-header-info') --}}
<section id="widgets-Statistics1" class="p-2">
    <div class="cardStyleChange">
        <div class="d-flex ml-2 mr-2">
            <h4 class="flex-grow-1 text-center">Recharge View</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-12">
                            <strong>Name: </strong> {{ $toll_name->name}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cardStyleChange">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered border-bottom">
                    <thead class="thead-light">
                        <tr>
                            <th>Date</th>
                            <th>Party Name</th>
                            <th>Pay Mode</th>
                            <th class="text-right pr-2">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="user-table-body">
                        @foreach ($toll_recharges as $item)
                            <tr>
                                <td>{{ date('d/m/Y', strtotime($item->date)) }}</td>
                                <td class="">{{$item->party?$item->party->pi_name:''}}</td>
                                <td class="">{{$item->pay_mode}}</td>
                                <td class="text-right pr-2">{{number_format($item->amount,2)}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2"></td>
                            <td class="text-right pr-2">Total Remaining</td>
                            <td class="text-right pr-2">{{number_format($toll_recharges->sum('amount'),2)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
{{-- <div class="print-none">
    @include('layouts.backend.partial.modal-footer-info')

</div> --}}
