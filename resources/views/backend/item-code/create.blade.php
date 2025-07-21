


<style>
    .profile-img{
            width: 100px;
            height: 100px;
        }
        .profile-img img{
            padding: 1px;
            height: 100%;
            width:100%;
        }
        .student-title{
            padding: 10px 10px 6px 10px;
            background: #787d82d2;
            color: #fff;
        }
    @media print{
        .student_profle-print{
            margin-top: -40px !important;
        }
        .print-hideen{
            visibility: hidden;
        }
        .modal-lg {
            max-width: 100% !important;
        }
        .student-title{
            padding: 10px 10px 6px 10px;
            background: #787d82d2 !important;
            -webkit-print-color-adjust: exact;
        }
        .profile-img{
            border: 1px solid black;
            width: 100px;
            height: 100px;
        }
        .profile-img img{
            padding: 1px;
            width:100%;
            height: 100%;
        }
    }
</style>
<section class="print-hideen border-bottom">
    <div class="d-flex flex-row-reverse">
        <div class="py-1 pr-1"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
    </div>
</section>

<section id="widgets-Statistics">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
            <div class="col-md-12 ml-2 mt-1">
                    <h4> Add Item Code</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="">
                <div class="ml-2 mb-3 mr-2">
                    <div class="row">
                        <div class="col-12">
                            <form action="{{ route('item-code.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="sub_brand_id" value="{{$sub_brand_id}}">
                                <div class="form-group">
                                    <label for=""> Item Code Name </label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for=""> Unit </label>
                                        <select name="unit" id="" required class="form-control">
                                            <option value="">Select Unit</option>
                                            @foreach ($units as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for=""> Purchase Price </label>
                                        <input type="number" class="form-control" name="purchase_price" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for=""> Sale Price </label>
                                        <input type="number" class="form-control" name="sale_price" >
                                    </div>
                                </div>
                
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="divFooter mb-1 ml-1">
        Business Software Solutions by
        <span style="color: #0005" class="spanStyle"><img class="img-fluid" src="{{ asset('storage/upload/zisprink.png')}}" alt="" width="70"></span>
    </div>
</section>

