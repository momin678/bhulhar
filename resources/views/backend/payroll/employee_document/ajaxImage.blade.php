@foreach($others as $others)
<div class="col-md-2 img" >
    {{-- <a href=""   class="close delete-img"></a> --}}
{{-- <span data_target="{{ route('othersDelete', $others->id) }}" class="close delete-img" >&times;</span> --}}
    <span class="btn btn-warning invoice-item-delete" id="" data_target="{{ route('employeeProDocumentDelete',$others) }}"><i class="bx bx-trash"></i></span>
    <a href="{{ asset('storage/upload/employee/post_quali/'.$others->image)}}" target="_blank">
        <img src="{{ asset('storage/upload/employee/post_quali/'.$others->image)}}" title="{{$others->name}}" style="height:60px" class="img-fluid" alt="" >
    </a>  
</div>
@endforeach