<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Document;
use App\DocumentTemp;
use App\JobProjectInvoice;

class DocumentController extends Controller
{
    public function documentUpload(Request $request,$id){
        if($request->hasFile('files')){
            $this->fileUpload($request->file('files'),$id,$request->relation_column);
        }

        $documents = Document::where($request->relation_column,$id)->get();
        $type = 'docuemnt';
        return view('backend.ajax.document-list',compact('documents','type'));
    }

    private function fileUpload($files,$id,$parent_column){
        foreach($files as $file){
            $extension = $file->getClientOriginalExtension();
            $name = hexdec(uniqid()).time().'.'.$extension;
            $file->storeAs('public/upload/documents',$name);

            $document = new Document();
            $document->extension = $extension;
            $document->file_path = 'storage/upload/documents/'.$name;
            $document->$parent_column = $id;
            $document->save();
        }
    }

    public function tempDocumentUpload(Request $request,$id){
        $relation_column = $request->relation_column;
        if($request->hasFile('files')){
            foreach($request->file('files') as $file){
                $extension = $file->getClientOriginalExtension();
                $name = hexdec(uniqid()).time().'.'.$extension;
                $file->storeAs('public/upload/documents',$name);

                $document = new DocumentTemp();
                $document->extension = $extension;
                $document->file_path = 'storage/upload/documents/'.$name;
                $document->$relation_column = $id;
                $document->save();
            }
        }
        $documents = DocumentTemp::where($relation_column,$id)->get();
        $type = Null;
        return view('backend.ajax.document-list',compact('documents','type'));
    }

    public function tempDocumentDelete(DocumentTemp $document){
        $file_name = substr($document->file_path,strrpos($document->file_path,'/')+1);
        if(file_exists(storage_path('app/public/upload/documents/'.$file_name))){
            unlink(storage_path('app/public/upload/documents/'.$file_name));
        }

        $document->delete();
    }


    public function documentDelete(Document $document){
        $file_name = substr($document->file_path,strrpos($document->file_path,'/')+1);
        if(file_exists(storage_path('app/public/upload/documents/'.$file_name))){
            unlink(storage_path('app/public/upload/documents/'.$file_name));
        }

        $document->delete();
    }
}
