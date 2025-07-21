
@extends('layouts.backend.app')
@section('content')
@include('layouts.backend.partial.style')

<style>
    .table td{
        border-bottom: none;
    }
    .commonSelect2Style span{
        width: 100% !important;
    }
    .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b{
        display: none;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b{
        display: none;
    }
    .font-size{
        font-size: 16px !important;
        font-weight: 600;
    }
    .accordion .pluseMinuseIcon.collapsed::before{
        content: "\f067";;
        cursor: pointer;
        border: 1px solid rgb(123, 123, 123);
    }
    .accordion .pluseMinuseIcon::before {
        font-family: 'FontAwesome';
        content: "\f068";
        cursor: pointer;
        border: 1px solid rgb(123, 123, 123);
    }
    @media print{
        .collapsed{
            display: none;
        }
    }
</style>

<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @include('clientReport.daily-report._header')
            <div class="tab-content bg-white">
                <div class="tab-pane active">
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="cardStyleChange p-1">
                                <div class="row" id="table-bordered">
                                    <div class="col-12">
                                        <div class="card cardStyleChange">
                                            <div class="conpany-header">
                                                @include('layouts.backend.partial.modal-header-info')
                                            </div>
                                            <div class="card-body print-hidden">
                                                <div class="d-flex mt-2">
                                                    <h4 class="card-title flex-grow-1">Vehicle Expense Reports:
                                                        @if ($truck_info)
                                                            {{$truck_info->vehicle_number}}
                                                        @endif
                                                        @if ($from && $to)
                                                        {{date('d/m/Y', strtotime($from))}} to {{date('d/m/Y', strtotime($to))}}
                                                        @endif
                                                    </h4>
                                                    {{-- <div>
                                                        <button type="button" class="btn mExcelButton formButton mr-1" title="Export" onclick="exportTableToCSV('general-ledger-29 Jan 2023.csv')">
                                                            <div class="d-flex">
                                                                <div class="formSaveIcon">
                                                                    <img src="{{asset('assets/backend/app-assets/icon/excel-icon.png')}}" width="25">
                                                                </div>
                                                                <div><span>Export To CSV</span></div>
                                                            </div>
                                                        </button>
                                                        <a href="#" class="btn btn_create mPrint formButton" title="Print" onclick="window.print()">
                                                            <div class="d-flex">
                                                                <div class="formSaveIcon">
                                                                    <img src="{{asset('assets/backend/app-assets/icon/print-icon.png')}}" width="25">
                                                                </div>
                                                                <div><span>Print</span></div>
                                                            </div>
                                                        </a>
                                                    </div> --}}
                                                </div>
                                                <div>
                                                    <form action="" method="GET" class="row">
                                                        <div class="col-2">
                                                            <label for="">From</label>
                                                            <input type="text" class="inputFieldHeight form-control" name="from" placeholder="From" id="from">
                                                        </div>
                                                        <div class="col-2">
                                                            <label for="">To</label>
                                                            <input type="text" class="inputFieldHeight form-control" name="to" placeholder="To" id="to">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="">Vehicle Number</label>
                                                            <select name="truck_id" class="form-control inputFieldHeight common-select2">
                                                                <option value="">Select...</option>
                                                                @foreach ($trucks_list as $item)
                                                                    <option value="{{$item->id}}">{{$item->vehicle_number}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-2 text-right mt-2">
                                                            <button type="submit" class="btn mSearchingBotton formButton" title="Search">
                                                                <div class="d-flex">
                                                                    <div class="formSaveIcon">
                                                                        <img src="{{asset('assets/backend/app-assets/icon/searching-icon.png')}}" width="25">
                                                                    </div>
                                                                    <div><span>Search</span></div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                        <div class="col-md-2 text-right mt-2">
                                                            <button type="button" class="btn mPrint formButton" title="Print" onclick="handlePrintClick('daylireport')">
                                                                <div class="d-flex">
                                                                    <div class="formSaveIcon">
                                                                        <img src="{{asset('assets/backend/app-assets/icon/print-icon.png')}}" width="25">
                                                                    </div>
                                                                    <div><span>Print</span></div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div id="daylireport">
                                                <h4 class=" print-show mt-2 mb-2 text-center" style="display: none">Vehicle Expense Reports:
                                                    @if ($truck_info)
                                                        {{$truck_info->vehicle_number}}
                                                    @endif
                                                    @if ($from && $to)
                                                    {{date('d/m/Y', strtotime($from))}} to {{date('d/m/Y', strtotime($to))}}
                                                    @endif
                                                </h4>

                                                <div class="card-body">

                                                    <div class="table-responsive" style="min-height: 400px;">
                                                        <table class="table mb-0 table-sm accordion">
                                                            <thead class="thead-light">
                                                                <tr style="height: 50px;">
                                                                    <th class="font-size">Date</th>
                                                                    <th class="font-size print-hidden"></th>
                                                                    <th class="font-size">Description</th>
                                                                    <th class="text-right font-size">Debit</th>
                                                                    <th class="text-right font-size">Credit</th>
                                                                </tr>
                                                            </thead>
                                                            @foreach ($trucks as $item)

                                                                <tr>
                                                                    <td class="font-size" colspan="5">VEHICLE NUMBER: {{$item->vehicle_number}}</td>
                                                                </tr>
                                                                    @php
                                                                        $net_debit_amount = 0;
                                                                        $net_credit_amount = 0;
                                                                        $previous_net_debit_amount = 0;
                                                                        $previous_net_credit_amount = 0;
                                                                    @endphp
                                                                    @php
                                                                        if($from && $to){
                                                                            $vehicle_income = App\TaxInvoiceItem::where('truck_id', $item->id)->whereBetween('date', [$from,$to])->orderBy('date', 'asc')->get();
                                                                            $vehicle_expense = App\VehicleExpense::where('vehicle_id', $item->id)->whereBetween('date', [$from,$to])->orderBy('date', 'asc')->get();
                                                                            $bill_expense = App\PurchaseExpense::whereHas('items', function ($query) use ($item) {
                                                                                $query->where('cost_center', $item->id);
                                                                            })->whereBetween('date', [$from,$to])->orderBy('date', 'asc')->distinct()->get();
                                                                            $toll_fee_payment = App\TollFeeInvoiceItem::where('truck_id', $item->id)->whereBetween('date', [$from,$to])->orderBy('date', 'asc')->get();
                                                                            $commission_expanses = App\TruckRecords::where('truck_id', $item->id)->whereBetween('date', [$from,$to])->orderBy('date', 'asc')->where('commision', '>', 0)->get();

                                                                            // $previous_vehicle_income = App\TaxInvoiceItem::where('truck_id', $item->id)->whereBetween('date', [$startOfYear,$subDayStartOfYear])->orderBy('date', 'asc')->get();
                                                                            // $previous_vehicle_expense = App\VehicleExpense::where('vehicle_id', $item->id)->whereBetween('date', [$startOfYear,$subDayStartOfYear])->orderBy('date', 'asc')->get();
                                                                            // $previous_toll_fee_payment = App\TollFeeInvoiceItem::where('truck_id', $item->id)->whereBetween('date', [$startOfYear,$subDayStartOfYear])->orderBy('date', 'asc')->get();
                                                                            // $previous_labour_expanses = App\LabourExpense::where('truck_id', $item->id)->whereBetween('date', [$startOfYear,$subDayStartOfYear])->orderBy('date', 'asc')->get();

                                                                            // $previous_net_debit_amount += ($previous_vehicle_income->sum('amount')+$previous_vehicle_income->sum('vat_amount'));
                                                                            // $previous_net_credit_amount += $previous_vehicle_expense->sum('amount');
                                                                            // $previous_net_credit_amount += $previous_vehicle_expense->sum('others_cost');
                                                                            // $previous_net_credit_amount += $previous_toll_fee_payment->sum('amount');
                                                                            // $previous_net_credit_amount += $previous_labour_expanses->sum('total_amount');
                                                                        }else {
                                                                            $vehicle_income = App\TaxInvoiceItem::where('truck_id', $item->id)->orderBy('date', 'asc')->get();
                                                                            $vehicle_expense = App\VehicleExpense::where('vehicle_id', $item->id)->orderBy('date', 'asc')->get();
                                                                            $bill_expense = App\PurchaseExpense::whereHas('items', function ($query) use ($item) {
                                                                                $query->where('cost_center', $item->id);
                                                                            })->orderBy('date', 'asc')->distinct()->get();
                                                                            $toll_fee_payment = App\TollFeeInvoiceItem::where('truck_id', $item->id)->orderBy('date', 'asc')->get();
                                                                            $commission_expanses = App\TruckRecords::where('truck_id', $item->id)->orderBy('date', 'asc')->where('commision', '>', 0)->get();
                                                                        }
                                                                        $net_debit_amount += ($vehicle_income->sum('amount')+$vehicle_income->sum('vat_amount'));
                                                                        $net_credit_amount += $vehicle_expense->sum('amount');
                                                                        $net_credit_amount += $vehicle_expense->sum('others_cost');
                                                                        $net_credit_amount += $toll_fee_payment->sum('amount');
                                                                        $net_credit_amount += $commission_expanses->sum('commision');

                                                                    @endphp
                                                                    <tr>
                                                                        <td colspan="5" class="font-size">Income Details</td>
                                                                    </tr>
                                                                    @foreach ($vehicle_income as $key => $income)
                                                                        <tr>
                                                                            <td class="pluseMinuseIcon collapsed" data-toggle="collapse" href="#collapse{{$income->id}}" aria-controls="collapse{{$income->id}}" aria-expanded="false"></td>
                                                                            <td>{{date('d/m/Y', strtotime($income->date))}}</td>
                                                                            <td>{{$income->description}}</td>
                                                                            <td class="text-right">{{$income->amount+$income->vat_amount}}</td>
                                                                            <td class="text-right pr-1">0</td>
                                                                        </tr>
                                                                        <tr id="collapse{{$income->id}}" class="collapse" style="background: rgba(24, 23, 23, 0.105);">
                                                                            <td>Weight <br> {{$income->qty}} </td>
                                                                            <td>Rate <br> {{$income->rate}} </td>
                                                                            <td>Amount<br> {{$income->amount}} </td>
                                                                            <td>Vat Amount<br> {{$income->vat_amount}} </td>
                                                                            <td>Total Amount <br> {{$income->amount+$income->vat_amount}}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                    <tr>
                                                                        <td colspan="5" class="font-size">Expense Details</td>
                                                                    </tr>
                                                                    {{-- {{dd($bill_expense)}} --}}
                                                                    @foreach ($bill_expense as $key => $expense)
                                                                        <tr>
                                                                            <td class="pluseMinuseIcon collapsed" data-toggle="collapse" href="#expense{{$expense->id}}" aria-controls="expense{{$expense->id}}" aria-expanded="false"></td>
                                                                            <td>{{date('d/m/Y', strtotime($expense->date))}}</td>
                                                                            <td>{{$expense->narration}}</td>
                                                                            <td class="text-right">0</td>
                                                                            <td class="text-right pr-1">{{$expense->items()->where('cost_center',$item->id)->sum('amount')}}</td>
                                                                        </tr>
                                                                        <tr id="expense{{$expense->id}}" class="collapse" style="background: rgba(24, 23, 23, 0.105);">
                                                                            <td colspan="5">
                                                                                <div class="row">
                                                                                    <div class="col-6">Item Name</div>
                                                                                    <div class="col-2">Quantity</div>
                                                                                    <div class="col-2">Rate</div>
                                                                                    <div class="col-2">Total Amount</div>
                                                                                    @foreach (App\PurchaseExpenseItem::where('cost_center', $item->id)->where('purchase_expense_id', $expense->id)->orderBy('date', 'asc')->get() as $detail)
                                                                                        <div class="col-6">{{$detail->head?$detail->head->fld_ac_head:''}}</div>
                                                                                        <div class="col-2">{{$detail->qty}}</div>
                                                                                        <div class="col-2">{{$detail->rate}}</div>
                                                                                        <div class="col-2">{{$detail->amount}}</div>
                                                                                    @endforeach

                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        @php
                                                                            $net_credit_amount=$net_credit_amount+$expense->items()->where('cost_center',$item->id)->sum('amount');
                                                                        @endphp
                                                                    @endforeach


                                                                    <tr>
                                                                        <td colspan="5" class="font-size">Distributed Expenses</td>
                                                                    </tr>
                                                                    {{-- {{dd($bill_expense)}} --}}
                                                                    @foreach ($item->distributed_expenses as $key => $expense)
                                                                        <tr>
                                                                            <td></td>
                                                                            <td>{{date('d/m/Y', strtotime($expense->distribution->date))}}</td>
                                                                            <td>{{$expense->distribution->note}}</td>
                                                                            <td class="text-right">0</td>
                                                                            <td class="text-right pr-1">{{$expense->amount}}</td>
                                                                        </tr>

                                                                        @php
                                                                            $net_credit_amount=$net_credit_amount+$expense->amount;
                                                                        @endphp
                                                                    @endforeach


                                                                    <tr>
                                                                        <td colspan="5" class="font-size">Vehicle Expence</td>
                                                                    </tr>
                                                                    @foreach ($vehicle_expense as $key => $expense)

                                                                        <tr>
                                                                            <td class="pluseMinuseIcon collapsed" data-toggle="collapse" href="#vehicle{{$expense->id}}" aria-controls="vehicle{{$expense->id}}" aria-expanded="false"></td>
                                                                            <td>{{date('d/m/Y', strtotime($expense->date))}}</td>
                                                                            <td>{{$expense->narration}}</td>
                                                                            <td class="text-right">0</td>
                                                                            <td class="text-right pr-1">{{$expense->amount}}</td>
                                                                        </tr>
                                                                        <tr id="vehicle{{$expense->id}}" class="collapse" style="background: rgba(24, 23, 23, 0.105);">
                                                                            <td colspan="5">
                                                                                <div class="row">
                                                                                    <div class="col-6">Item Name</div>
                                                                                    <div class="col-2">Quantity</div>
                                                                                    <div class="col-2">Rate</div>
                                                                                    <div class="col-2">Total Amount</div>
                                                                                    @foreach ($expense->expense_detail_items($expense->id) as $detail)
                                                                                        <div class="col-6">{{$detail->item?$detail->item->name:''}}</div>
                                                                                        <div class="col-2">{{$detail->quantity}}</div>
                                                                                        <div class="col-2">{{$detail->amount}}</div>
                                                                                        <div class="col-2">{{$detail->total_amount}}</div>
                                                                                    @endforeach

                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                    {{-- @foreach ($toll_fee_payment as $key => $payment)
                                                                        <tr>
                                                                            <td class="print-hidden"></td>
                                                                            <td>{{date('d/m/Y', strtotime($payment->date))}}</td>
                                                                            <td>{{$payment->toll_name?$payment->toll_name->name:''}}</td>
                                                                            <td class="text-right">0</td>
                                                                            <td class="text-right pr-1">{{$payment->amount}}</td>
                                                                        </tr>
                                                                    @endforeach --}}
                                                                    <tr>
                                                                        <td colspan="5" class="font-size">Commission  Expenses</td>
                                                                    </tr>
                                                                    @foreach ($commission_expanses as $item)
                                                                    <tr>
                                                                        <td></td>
                                                                        <td>{{date('d/m/Y', strtotime($item->date))}}</td>
                                                                        <td>Commission Expanse</td>
                                                                        <td class="text-right">0</td>
                                                                        <td class="text-right pr-1">{{$item->commision}}</td>
                                                                    </tr>
                                                                    @endforeach
                                                                    {{-- <tr>
                                                                        <td class="print-hidden"></td>
                                                                        <td></td>
                                                                        <td>LABOUR CHARGE</td>
                                                                        <td class="text-right">0</td>
                                                                        <td class="text-right pr-1">{{$vehicle_expense->sum('others_cost')}}</td>
                                                                    </tr> --}}
                                                                <tr class="mb-3">
                                                                    <td class="print-hidden"></td>
                                                                    <td></td>
                                                                    <td colspan="" class="text-right font-size">Total:</td>
                                                                    <td class="text-right font-size"> {{number_format($net_debit_amount,2)}}</td>
                                                                    <td class="text-right pr-1 font-size"> {{number_format($net_credit_amount,2)}}</td>
                                                                </tr>
                                                                @if ($from && $to)
                                                                    <tr class="mb-3">
                                                                        <td class="print-hidden"></td>
                                                                        <td></td>
                                                                        <td colspan="2" class="text-right font-size">Income {{date('d/m/Y', strtotime($from))}} to {{date('d/m/Y', strtotime($to))}}:</td>
                                                                        <td class="text-right pr-1 font-size">{{number_format($net_debit_amount,2)}}</td>
                                                                    </tr>
                                                                    {{-- <tr class="mb-3">
                                                                        <td class="print-hidden"></td>
                                                                        <td></td>
                                                                        <td colspan="2" class="text-right font-size">Income {{date('d/m/Y', strtotime($startOfYear))}} to one day before {{date('d/m/Y', strtotime($subDayStartOfYear))}}:</td>
                                                                        <td class="text-right pr-1 font-size">{{number_format($previous_net_debit_amount,2)}}</td>
                                                                    </tr> --}}
                                                                    <tr class="mb-3">
                                                                        <td class="print-hidden"></td>
                                                                        <td></td>
                                                                        <td colspan="2" class="text-right font-size">Expanse {{date('d/m/Y', strtotime($from))}} to {{date('d/m/Y', strtotime($to))}}:</td>
                                                                        <td class="text-right pr-1 font-size">{{number_format($net_credit_amount,2)}}</td>
                                                                    </tr>
                                                                    {{-- <tr class="mb-3">
                                                                        <td class="print-hidden"></td>
                                                                        <td></td>
                                                                        <td colspan="2" class="text-right font-size">Expanse {{date('d/m/Y', strtotime($startOfYear))}} to one day before {{date('d/m/Y', strtotime($subDayStartOfYear))}}:</td>
                                                                        <td class="text-right pr-1 font-size">{{number_format($previous_net_credit_amount,2)}}</td>
                                                                    </tr> --}}
                                                                    <tr class="mb-3">
                                                                        <td class="print-hidden"></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td colspan="" class="text-right font-size"><p>Net Amount: </p></td>
                                                                        <td class="text-right pr-1 font-size"> <p>{{number_format(($net_debit_amount+$previous_net_debit_amount)-($net_credit_amount+$previous_net_credit_amount),2)}}</p></td>
                                                                    </tr>
                                                                @else
                                                                    <tr class="mb-3">
                                                                        <td class="print-hidden"></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td colspan="" class="text-right font-size"><p>Net Amount</p></td>
                                                                        <td class="text-right pr-1 font-size"> {{number_format($net_debit_amount-$net_credit_amount,2)}}</td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="conpany-header print-none">
                                                @include('layouts.backend.partial.modal-footer-info')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
    $(function() {
        $('.filter-table').excelTableFilter();
    });
</script>
