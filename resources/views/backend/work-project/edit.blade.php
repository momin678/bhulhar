<div class="modal-header" style="padding: 5px 15px;background:#364a60;">
    <h5 class="modal-title" id="exampleModalLabel" style="font-family:Cambria;font-size: 2rem;color:white;"> Project Edit </h5>
    <div class="d-flex align-items-center">  
        <button type="button" class="project-btn bg-danger text-white" data-dismiss="modal" aria-label="Close" style="padding: 3px 12px;" data-bs-toggle="tooltip" data-bs-placement="right" title="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
<div class="modal-body" style="padding: 5px 5px;">
    <section id="widgets-Statistics" class="mr-1 ml-1 mb-1" data-select2-id="widgets-Statistics">
        <div class="row" data-select2-id="16">
            <div class="col-12" data-select2-id="15">
                  <form action="{{ route('work-project.update', $project->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="cardStyleChange">
                        <div class="row">
                          <div class="col-md-3">
                              <label for="">Project Name</label>
                              <input type="text" class="form-control inputFieldHeight" name="project_name" required value="{{$project->project_name}}">
                          </div>
                          <div class="col-md-3 changeColStyle search-item-pi">
                              <div class="row align-items-center">
                                  <div class="col-10 customer-select">
                                      <label for="">Owner Name</label>
                                      <select name="party_id" id="party_id"
                                          class="common-select2 party-info customer"
                                          style="width: 100% !important" data-target="" required>
                                          <option value="">Select...</option>
                                          @foreach ($pInfos as $item)
                                              <option value="{{ $item->id }}" {{$project->customer_id==$item->id?'selected':''}}> {{ $item->pi_name }}</option>
                                          @endforeach
                                      </select>
                                      @error('party_id')
                                          <div class="btn btn-sm btn-danger">{{ $message }}
                                          </div>
                                      @enderror
                                  </div>
                                  <div class="col-2 col-left-padding d-flex align-items-center mt-2">
                                      <a href="#" data-toggle="modal"
                                          data-target="#customerModal"><img
                                              src="{{ asset('assets/backend/app-assets/icon/add-icon.png') }}"
                                              alt="" srcset="" class="img-fluid"
                                              style="height:29px"></a>

                                  </div>

                              </div>
                          </div>
                          <div class="col-md-3">
                              <label for="">Consultant Name</label>
                              <input type="text" class="form-control inputFieldHeight" name="consultant_name" required value="{{$project->consultant_name}}">
                          </div>
                          <div class="col-md-3">
                              <label for="">Location</label>
                              <input type="text" class="form-control inputFieldHeight" name="site_delivery" value="{{$project->site_delivery}}">
                          </div>
                          <div class="col-md-6">
                              <label for="">Remarks</label>
                              <input type="text" class="form-control inputFieldHeight" name="project_description" required value="{{$project->project_description}}">
                          </div>
                          <div class="col-md-2">
                              <label for="">Toal Amount</label>
                              <input type="number" step="any" class="form-control inputFieldHeight" name="total_amount" required value="{{$project->total_budget}}">
                          </div>
                          <div class="col-sm-2 form-group">
                              <label for="">Voucher Scan/File</label>
                              <input type="file" class="form-control inputFieldHeight"
                                  name="voucher_scan" accept="image/*">
                          </div>
                            <div class="col-md-2" style="margin-top: 36px;">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn mr-1 btn-primary formButton" title="Form Save">
                                        <div class="d-flex">
                                            <div class="formSaveIcon">
                                                <img  src="{{asset('storage/upload/icon/save-icon.png')}}" alt="" srcset="" class="img-fluid" width="25">
                                            </div>
                                            <div><span> Save</span></div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                  </form>
            </div>
        </div>
    </section>
</div>