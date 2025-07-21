@extends('layouts.backend.app')

@section('content')
<div class="app-content content print-hideen">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
				<h1 class="h2 fw-700 mt-5">Something went wrong {{Request::route()->getName()=='excel-import'?'in format ':''}}!</h1>
		    	<p class="fs-16 opacity-60"> Please {{Request::route()->getName()=='excel-import'?'correct format and re-upload':''}} </p>
				<a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
			
			</div>
		</div>
	</div>
@endsection
