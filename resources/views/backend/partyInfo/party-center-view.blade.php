
<style>
    .table-bordered {
        border: 1px solid #f4f4f4;
    }
    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
    }
    table {
        background-color: transparent;
    }
    table {
        border-spacing: 0;
        border-collapse: collapse;
    }
    .tarek-container {
        width: 85%;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 88% 12%;
        background-color: #ffff;
    }
    .invoice-label {
        font-size: 10px !important
    }
    @media print{
        html, body {
            height:100%;
            overflow: hidden;
        }
    }
</style>
<section class="print-hideen border-bottom" style="padding: 5px 15px;background:#364a60;">
    <div class="row">
        <div class="col-md-6"><h4 class="" style="font-family:Cambria;font-size: 2rem;color:white;">Party Info</h4></div>
        <div class="col-md-6">
            <div class="d-flex flex-row-reverse">
                <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
                <div class="mIconStyleChange"><a href="{{route('partyInfoEdit', $pInfo->id)}}" class="btn btn-icon btn-success" style="padding-bottom:3px;margin-right: -6px;"><i class="bx bx-edit"></i></a></div>
                {{-- <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-secondary partyCenterPrint" id="{{$pInfo->id}}" data-dismiss="modal"><i class='bx bx-printer'></i></a></div> --}}
                {{-- <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div> --}}
                {{-- <div class="mIconStyleChange"><a href="#" onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
            </div>
        </div>
    </div>   
</section>
<section id="widgets-Statistics">
    <div class="row" style="padding: 0 0.8rem;">
        <div class="col-md-12">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-5">
                                <strong>Party Code</strong>
                            </div>
                            <div class="col-7">
                                <strong>:</strong> {{ $pInfo->pi_code }}
                            </div>

                            <div class="col-5">
                                <strong>Party Name</strong>
                            </div>
                            <div class="col-7">
                                <strong>:</strong> {{ $pInfo->pi_name }}
                            </div>

                            <div class="col-5">
                                <strong>Type</strong>
                            </div>
                            <div class="col-7">
                                <strong>:</strong> {{ $pInfo->pi_type }}
                            </div>

                            <div class="col-5">
                                <strong>@if(!empty($currency->licence_name)){{$currency->licence_name}} @endif Number</strong>
                            </div>
                            <div class="col-7">
                                <strong>:</strong> {{ $pInfo->trn_no }}
                            </div>

                            <div class="col-5">
                                <strong>Contact Person</strong>
                            </div>
                            <div class="col-7">
                                <strong>:</strong> {{ $pInfo->con_person }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-5">
                                <strong>Contact Number</strong>
                            </div>
                            <div class="col-7">
                                <strong>:</strong> {{ $pInfo->con_no }}
                            </div>
                            <div class="col-5">
                                <strong>Phone Number</strong>
                            </div>
                            <div class="col-7">
                                <strong>:</strong> {{ $pInfo->phone_no }}
                            </div>

                            <div class="col-5">
                                <strong>Address</strong>
                            </div>
                            <div class="col-7">
                                <strong>:</strong> {{ $pInfo->address }}
                            </div>

                            <div class="col-5">
                                <strong>Email</strong>
                            </div>
                            <div class="col-7">
                                <strong>:</strong> {{ $pInfo->email }}
                            </div>



                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>
</section>
@include('backend.tab-file.modal-footer-info')
