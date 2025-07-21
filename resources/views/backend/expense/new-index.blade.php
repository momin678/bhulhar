@extends('layouts.backend.app')
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
@endpush
@section('content')
@include('layouts.backend.partial.style')
    <!-- BEGIN: Content-->
    <div class="app-content content print-hidden">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="tab-content bg-white  p-2">
                    <section id="widgets-Statistics">
                        <h4>Expense</h4>
                            <form action="{{ route('expense.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="match-height">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Master Account</label>
                                            <select name="master_acount" class="inputFieldHeight form-control common-select2" style="width: 100% !important" id="master_acount" required>
                                                <option value="">Select...</option>
                                                @foreach ($master_accounts as $item)
                                                    <option value="{{ $item->mst_ac_code }}" {{ $item->mst_ac_code == old('master_acount') ? 'selected' : '' }}>
                                                        {{ $item->mst_ac_head }}</option>
                                                @endforeach
                                            </select>
                                            @error('master_acount')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label>Account Head</label>
                                            <select name="account_head" class="inputFieldHeight form-control common-select2" style="width: 100% !important" id="account_head"
                                                required>
                                                <option value="">Select...</option>
                                            </select>
                                            @error('account_head')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label>Party</label>
                                            <select name="party_name" class="inputFieldHeight form-control common-select2" style="width: 100% !important" required>
                                                <option value="">Select...</option>
                                                @foreach ($parties as $item)
                                                    <option value="{{ $item->id }}" {{ old('party_name') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->pi_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('party_name')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label>Date</label>
                                            <input type="date" id="date" class="inputFieldHeight form-control" name="date" placeholder="date" required value="{{old('date')}}">
                                            @error('date')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label>Voucher Upload</label>
                                            <input type="file" class="inputFieldHeight form-control" name="voucher_copy" required>
                                            @error('bank_name')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label>Taxable Amount</label>
                                            <input type="text" id="signatory" class="inputFieldHeight form-control" name="taxable_amount" value="{{ old("taxable_amount") }}" placeholder="Taxable Account" required>
                                            @error('taxable_amount')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label>Vat Amount</label>
                                            <input type="number" id="vat_amount" class="inputFieldHeight form-control"  name="vat_amount" value="{{ old('vat_amount') }}" placeholder="Vat Amount" required>
                                            @error('vat_amount')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label>Total Amount</label>
                                            <input type="text" class="inputFieldHeight form-control" name="total_amount" placeholder="Total Amount" value="{{old('total_amount')}}">
                                            @error('total_amount')
                                                <div class="btn btn-sm btn-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mt-2 col-md-4">
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn mr-1 btn-primary formButton" title="Form Save">
                                                    <div class="d-flex">
                                                        <div class="formSaveIcon">
                                                            <img src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                        </div>
                                                        <div><span> Save</span></div>
                                                    </div>
                                                </button>
                                                <button type="reset" class="btn btn-light-secondary formButton" title="Form Reset">
                                                    <div class="d-flex">
                                                        <div class="formRefreshIcon">
                                                            <img src="{{asset('assets/backend/app-assets/icon/refresh-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                                        </div>
                                                        <div><span> Reset</span></div>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    </section>
                    <hr>
                    <section id="widgets-Statistics">
                        <div class="mt-2">
                            <div class="row ">
                                <div class="col-md-6">
                                    <form>
                                    <input type="text" name="q" class="form-control input-xs inputFieldHeight ajax-search" placeholder="Search By Code, Name, Account Number" data-url="{{ route('admin.masterAccSearchAjax',$id="bankDetails") }}">
                                    </form>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href=#" class="btn btn-xs mPrint formButton" onclick="window.print()" title="Print"><img  src="{{asset('assets/backend/app-assets/icon/print-icon.png')}}" alt="" srcset="" class="img-fluid" width="30"> Print</a>
                                    <a href="#" class="btn btn-xs mExcelButton formButton" 
                                    onclick="exportTableToCSV('bankdetails.csv')" title="Export to Excel"><img  src="{{asset('assets/backend/app-assets/icon/excel-icon.png')}}" alt="" srcset="" class="img-fluid" width="30">Export To Excel</a href="#">
                                </div>
                            </div>
                        </div>
                    </section>
                    <section>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="thead-light">
                                    <tr style="height: 50px;">
                                        <th>Master Acc</th>
                                        <th>Acc Head</th>
                                        <th>Taxable Amount</th>
                                        <th>Vat Amount</th>
                                        <th>Total</th>
                                        <th class="text-right pr-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="user-table-body">
                                    @foreach ($expenses as $expense)
                                        <tr class="trFontSize">
                                            <td>{{ $expense->master_account->mst_ac_head }} </td>
                                            <td>{{ $expense->account_head->fld_ac_head }}</td>
                                            <td>{{ $expense->taxable_amount }}</td>
                                            <td>{{ $expense->vat_amount }}</td>
                                            <td>{{ $expense->total_amount }}</td>
                                            <td class="text-right pr-1 pt-0 pb-1">
                                                <a href="{{route('expense.edit', $expense->id)}}" class="btn" style="height: 30px; width: 30px;" title="Eidt"><img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" style=" height: 30px; width: 30px;"></a>
                                                <a href="#" onclick="return confirm('about to delete master account. Please, Confirm?')"  class="btn" style="height: 30px; width: 30px;" title="Delete"><img src="{{ asset('assets/backend/app-assets/icon/delete-icon.png')}}" style=" height: 30px; width: 30px; margin-left: -12px;"></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $expenses->links() }}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
<script>
    $(document).ready(function() {
        var delay = (function() {
            var timer = 0;
            return function(callback, ms) {
                clearTimeout(timer);
                timer = setTimeout(callback, ms);
            };
        })();
        $(document).on("click", ".bank-form-btn", function(e) {
            e.preventDefault();
            var that = $(this);
            var urls = that.attr("data_target");
            // alert(urls);
            delay(function() {
                $.ajax({
                    url: urls,
                    type: 'GET',
                    cache: false,
                    dataType: 'json',
                    success: function(response) {
                        //   alert('ok');
                        console.log(response);
                        $(".bank-form").empty().append(response.page);
                    },
                    error: function() {
                        //   alert('no');
                    }
                });
            }, 999);
        });
        $('#master_acount').change(function(){
            var ac_code= $(this).val();
            var csrf_token= '{{ csrf_token()}}';
            $.ajax({
            url:  '{{route("expense_get_account_head")}}',
            dataType: 'json',
            type: 'post',
            data: {ac_code: ac_code, _token: csrf_token },
            success:function(response){
                
                var optionHtml= '<option value=""> Select Section </option>';

                response.forEach(function(element, index) { 
                    console.log(element);
                    optionHtml += "<option value='"+element.id +"'> "+ element.fld_ac_head+"</option>";
                    });
                    $('#account_head').html(optionHtml);
                    $('#account_head').select2();
                    console.log(optionHtml);
                
                    
            }
            });
        });
    });
</script>


@endpush

<style>
    <style>
       #customers {
           font-family: Arial, Helvetica, sans-serif;
           border-collapse: collapse;
           width: 100%;
       }
       #customers td, #customers th {
           /* border: 1px solid #ddd;
           padding: 8px; */
       }

       #customers tr:nth-child(even){background-color: #f2f2f2;}

       #customers tr:hover {background-color: #ddd;}
       #customers th {
           padding-top: 12px;
           padding-bottom: 12px;
           text-align: left;
           background-color: #04AA6D;
           color: white;
           text-transform: uppercase;

       }
       .graph-7{background: url(../img/graphs/graph-7.jpg) no-repeat;}
       .graph-image img{display: none;}
       @media screen {
       div.divFooter {
           display: none;
       }
       }
       @media print {
           div.divFooter {
               position: fixed;
               bottom: 0;
           }
       }
       th{
           text-transform: uppercase;
       }
   </style>
<style>
   .print-layout{
       display: none;
   }
   @media print{
       .print-layout{
           display: block;
       }
   }
</style>
<section class="print-layout">
   @include('layouts.backend.partial.modal-header-info')

    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
            <section id="widgets-Statistics">
                <div class="row text-center">
                    <h4>Expense Details</h4>
                </div>
                <div class="row">
                    <table class="table table-sm table-hover">
                        <thead class="thead-light">
                            <tr style="height: 50px;">
                                <th>Date</th>
                                <th>Master Acc</th>
                                <th>Acc Head</th>
                                <th>Taxable Amount</th>
                                <th>Vat Amount</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody class="user-table-body">
                            @foreach ($expensesPDF as $expense)
                                <tr class="trFontSize">
                                    <td>{{$expense->date}}</td>
                                    <td>{{ $expense->master_account->mst_ac_head }} </td>
                                    <td>{{ $expense->account_head->fld_ac_head }}</td>
                                    <td>{{ $expense->taxable_amount }}</td>
                                    <td>{{ $expense->vat_amount }}</td>
                                    <td>{{ $expense->total_amount }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
            </div>
        </div>
    </div>
   @include('layouts.backend.partial.modal-footer-info')
</section>