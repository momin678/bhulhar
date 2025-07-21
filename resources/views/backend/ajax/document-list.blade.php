@foreach ($documents as $document)
<div class="col-md-2 text-center py-1 px-4 print-hideen document-file" id="document-{{$document->id}}">
    <button class="remove-document py-1 d-none" data-id='{{$document->id}}' data-url="{{$type == 'document' ? route('document.destroy',$document->id): route('temp.document.destroy',$document->id)}}">
        <i class="bx bx-trash text-danger"></i>
    </button>

    <a href="{{asset($document->file_path)}}" target="blank">
        <img src="{{asset($document->file_path)}}" class="img-fluid" style="min-width:100px; width:100%; max-height:150px;" alt="{{$document->extension}}">
    </a>
</div>
@endforeach
