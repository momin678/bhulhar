<style>
    .commonSelect2Style span{
        width: 100% !important;
    }
    .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b{
        display: none;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b{
        display: none;
    }
</style>
<section class="print-hideen border-bottom">
    <div class="d-flex flex-row-reverse">
        <div class="mIconStyleChange"><a href="#" class="close btn-icon btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class='bx bx-x'></i></span></a></div>
        {{-- <div class="mIconStyleChange"><a href="#" class="btn btn-icon btn-success"><i class="bx bx-edit"></i></a></div>
        <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-secondary"><i class='bx bx-printer'></i></a></div>
        <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-primary"><i class='bx bxs-file-pdf'></i></a></div>
        <div class="mIconStyleChange"><a href="#"  onclick="window.print();" class="btn btn-icon btn-light"><i class='bx bxs-virus'></i></a></div> --}}
      </div>
</section>
<section id="basic-vertical-layouts">
    <div class="cardStyleChange">
        <section id="basic-vertical-layouts">
            <form class="form form-vertical"  method="POST" enctype="multipart/form-data">
                @csrf 
                <div class="row match-height">
                    <div class="col-md-12 col-12">
                        <div class="card-body">
                            <div class="form-body m-1">
                                <h4 class="card-title">Create Setup</h4>
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="config-name">Setup Name</label>
                                            <input type="text" id="config-name" class="inputFieldHeight form-control @error('name') error @enderror" name="name" value="{{ isset($edit_setting) ? $edit_setting->name : old('name')}}" placeholder="Setup Name" required>
                                            @error('name')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="config-value">Setup Value</label>
                                            <input type="text" id="config-value-text"  class="form-control @error('value') error @enderror" name="value" value="{{ isset($edit_setting) ? $edit_setting->value : old('value')}}" placeholder="Setup Value" style="display: {{ (isset($edit_setting) && $edit_setting->config_type =='img') ? 'none': 'block' }}">
                                            @error('value')
                                            <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12 d-flex justify-content-end mt-2 mb-2">
                                        <button type="submit" class="btn btn-primary formButton" title="Save" id="SearchButton">
                                            <div class="d-flex">
                                                <div class="formSaveIcon">
                                                    <img src="{{asset('assets/backend/app-assets/icon/save-icon.png')}}" width="20">
                                                </div>
                                                <div><span> Save</span></div>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </form>    
        </section>
    </div>
</section>