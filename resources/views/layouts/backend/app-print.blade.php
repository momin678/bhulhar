<style>
  .mIconSryleChange{
      padding: 10px 5px !important;
  }
  .p-footer {
    display: none;
}
  .background{
    background-image: url(http://zinith-audit.com/beps/assets/backend/app-assets/beps-logo.png);
    opacity: 0.5;
  }
  @media print{
    .background{
      background-image: url(http://zinith-audit.com/beps/assets/backend/app-assets/beps-logo.png);
      opacity: 0.5;
    }
    .p-footer{
    display: block;
}
  }

  .logo_hide{
        display: none !important;
    }
@media print {
    /* .printPage{
        margin-top: -250px;
    } */
    .logo_hide{
        display: block !important;
    }

}



</style>
  <body onload="handlePrintClick('printPage')">
    <section class="print-hideen border-bottom">
      <div class="d-flex flex-row-reverse">
        <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
        <div class="mIconSryleChange"><a href="#"  class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
      </div>
    </section>
    <div class="printPage" id="printPage">
    </div>
       <section>
          <!-- BEGIN: Content-->
          @yield('content')
          <!-- END: Content-->
       </section>
       <div class="img logo_hide">
      {{-- <img src="{{ asset('assets/backend/app-assets')}}/beps-logo.png" class="img-fluid"  style="position: fixed; top:650px; left:300px; opacity:.1; height:250px;" alt=""> --}}
    </div>
  </body>
