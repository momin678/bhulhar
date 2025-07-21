@extends('layouts.backend.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />

@endpush
@section('content')
@include('layouts.backend.partial.style')
<style>
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
    .rowStyle{
        cursor: pointer;
        border-left: dotted;
        padding: 3px;
        margin-bottom: 2px;
    }
    .findMasterAcc{
        cursor: pointer;
    }
    .card {
    margin-bottom: 0px !important;
    box-shadow: -8px 12px 18px 0 rgb(25 42 70 / 13%);
    transition: all .3s ease-in-out, background 0s, color 0s, border-color 0s;
}
tr, td{
    text-align: center;
}
@media print {
    html, body {
        height: 99%;
    }
}
</style>
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="nav nav-tabs master-tab-section" id="nav-tab" role="tablist">
                <a href="{{route('quotation.index')}}" class="nav-item nav-link active" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/master-account.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Quotation List</div>
                </a>
                <a href="{{route('quotation.create')}}" class="nav-item nav-link" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <div class="master-icon text-cente">
                        <img src="{{asset('assets/backend/app-assets/icon/account-heads.png')}}" alt="" srcset="" class="img-fluid" width="50">
                    </div>
                    <div>Generate Quotation</div>
                </a>
            </div>
            <div class="tab-content bg-white">
                <div id="masterAccount" class="tab-pane active">
                    <section id="widgets-Statistics" class="mr-1 ml-1 mb-1">
                        <div class="row">
                            <div class="col-md-6  mt-2">
                                <h4>Quotation View</h4>
                            </div>
                            <div class="col-md-6 text-right mt-2">
                                <a href="#" onclick="partyListPrint()" class="btn btn-xs mPrint formButton" title="Print"><img  src="{{asset('assets/backend/app-assets/icon/print-icon.png')}}" alt="" srcset="" class="img-fluid" width="30"> Print</a>
                            </div>
                        </div>
                    </section>
                    <hr style="margin:0px !important">

                    <div class="row d-flex justify-content-center">
                        <div class="col-md-11">
                            <div class="row">
                                <div class="col-12"><strong>{{ $quote->date }}</strong></div>
                                <div class="col-12"><strong>To</strong></div>
                                <div class="col-12"><strong>{{ $quote->to }}</strong></div>
                                <div class="col-12"><strong>{{ $quote->partyName->pi_name }}</strong></div>
                                <div class="col-12"><strong>Sub: {{ $quote->subject }}</strong></div>
                                <div class="col-12"> {!! $quote->body !!}</div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    {{-- <script src="{{ asset('assets/backend/app-assets/vendors/js/jquery/jquery.min.js') }}"></script> --}}


<script>
        function partyListPrint(){
            // document.getElementById("mPrintHidden").style.display = "block";
            window.print();
        }
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
           border-bottom: 1px solid #ddd;
           padding: 8px;
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
   @media print {

html, body {
  height:100vh;
  margin: 0 !important;
  padding: 0 !important;
  overflow: hidden;
}

}
</style>
<section class="print-layout" id="mPrintHidden">

   @include('layouts.backend.partial.modal-header-info')
   <div class="container py-4">
       <div class="row">
           <div class="col-md-12">
           <section id="widgets-Statistics">
            <div class="row d-flex justify-content-center">
                <div class="col-md-11">
                    <div class="row">
                        <div class="col-12"><strong>{{ $quote->date }}</strong></div>
                        <div class="col-12"><strong>To</strong></div>
                        <div class="col-12"><strong>{{ $quote->to }}</strong></div>
                        <div class="col-12"><strong>{{ $quote->partyName->pi_name }}</strong></div>
                        <div class="col-12"><strong>Sub: {{ $quote->subject }}</strong></div>
                        <div class="col-12"> {!! $quote->body !!}</div>
                    </div>
                </div>
            </div>
           </section>
           </div>
       </div>
   </div>



   @include('layouts.backend.partial.modal-footer-info')
</section>
