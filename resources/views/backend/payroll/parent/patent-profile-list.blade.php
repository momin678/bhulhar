
<style>
    .parentProtileAddButton:hover{
        background: #c6c8ca !important;
    }
</style>
    <div class="content-body">
        
        <!-- Bordered table start -->
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Parent Profile</h4>
                        <div>
                            <a href="{{ route('parent.create')}}" class="btn parentProtileAddButton" style="height: 60px; width: 60px; padding-left: 3px; background: #e6e7e8;" title="Add New Parent Profile"><img src="{{ asset('assets/backend/app-assets/icon/add-icon.png')}}" alt="" srcset="" style="height: 50px; width: 50px;"></a><br>
                            <span>Add New</span>
                            
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- table bordered -->
                        <div class="row">
                            <div class="col-md-6">
                                <form method="get">
                                    {{-- @csrf --}}
                                    <div class="form-group">
                                        <input type="text" class="form-control " name="search" value="" placeholder="Search by Parent's name or Emirates ID">
                                    </div>
                                    {{-- <input type="text" placeholder="Search by Student Name, SIS Number"> --}}
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table mb-0 table-sm table-hover">
                                <thead  class="thead-light">
                                    <tr style="height: 50px;">
                                        <th>Parent ID</th>
                                        <th>Father's Name</th>
                                        <th>Mother's Name</th>
                                        <th>Father's Emirates ID</th>
                                        <th>Mother's Emirates ID</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($parent_data as $each_parent)
                
                                    <tr style="font-size: 12px;">
                                    <td>{{ $each_parent->id }}</td>
                                    <td><a href="" style="color: #727E8C;" class="parentViewProfile" id="{{$each_parent->id}}">{{ $each_parent->f_fname.' '.$each_parent->f_mname.' '.$each_parent->f_family_name }}</a></td>
                                    <td>{{ $each_parent->m_fname.' '.$each_parent->m_mname.' '.$each_parent->m_family_name }}</td>
                                    <td>{{ $each_parent->f_emirates_id_num }}</td>
                                    <td>{{ $each_parent->m_emirates_id_num }}</td>
                                    <td>
                                        <a href="{{route('parent.edit', $each_parent->id)}}" class="btn" title="Edit" style="padding-top: 1px; padding-bottom: 1px; height: 30px; width: 30px; margin-right: 10px"><img src="{{ asset('assets/backend/app-assets/icon/edit-icon.png')}}" alt="" srcset="" style=" height: 30px; width: 30px;"></a>
                                        {{-- <a href="{{route('parent.show', $each_parent->id)}}" class="btn btn-icon btn-success"  style="padding-top: 2px; padding-bottom: 2px;"><i class="bx bx-edit"></i></a> --}}
                                        <a href="#" class="btn btn-icon parentViewProfile" id="{{$each_parent->id}}"  style="padding-top: 2px; padding-bottom: 2px;"><img src="{{ asset('assets/backend/app-assets/icon/view-icon.png')}}" style=" height: 30px; width: 30px;"></a>
                                        
                                        {{-- <a href="#" class="btn partyCenterView" style="height: 30px; width: 30px;" title="Preview"><img src="{{ asset('assets/backend/app-assets/icon/view-icon.png')}}" style=" height: 30px; width: 30px;"></a> --}}
                                    </td>
                                        
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="ml-5">{{ $parent_data->links() }}</div>
                </div>
            </div>
        </div>
    </div>
