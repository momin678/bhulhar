@foreach($others as $others)
    <div class="col-md-2 img" >
        <span class="btn btn-warning invoice-item-delete" id="" data_target="{{ route('fathersDelete',$others) }}"><i class="bx bx-trash"></i></span>
    
            @if ($others->extension == 'pdf')
                <a href="{{ asset('storage/upload/student-parent/'.$others->filename)}}"  target="_blank">
                    
                    <img src="{{ asset('assets/backend/app-assets/icon/pdf-download-icon-2.png')}}" style="height:60px" class="img-fluid" alt="" >
                </a>
            @else
                <a href="{{ asset('storage/upload/student-parent/'.$others->filename)}}" target="_blank">
                    <img src="{{ asset('storage/upload/student-parent/'.$others->filename)}}" style="height:60px" class="img-fluid" alt="" >
                </a>
            @endif     
    </div>
@endforeach