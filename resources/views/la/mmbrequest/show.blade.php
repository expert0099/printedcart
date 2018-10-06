@extends('la.layouts.app')

@section("contentheader_title", "MMB Request View")

@section('main-content')

<meta name="_token" content="{{ csrf_token() }}" />

<link rel="stylesheet" href="{{URL::asset('public/css/photobook_custom_editor.css')}}"/>
<link rel="stylesheet" href="{{URL::asset('public/css/custom.css')}}"/>
		
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.svg.js"></script>

<div style="width:100%;float:left;border-bottom:1px solid #ccc;padding-bottom:20px;">
	<a href="{{ url(config('laraadmin.adminRoute') . '/mmbrequest') }}"><button class="btn btn-success">Back</button></a>
</div>

<div class="profile2 content-body" style="overflow-x: auto; padding-top:20px;">
	<div>
		<div><b>Make My Book Name :- </b>{{$mmbrequest->mybook_name}}</div>
		<div><b>Customer Name/Email :- </b>{{$mmbrequest->user_name}} -> {{$mmbrequest->email}}</div>
		<div><b>Photobook :- </b>{{$mmbrequest->photo_book}}</div>
		<div><b>Photobook Style :-</b> {{$mmbrequest->photo_book_style}}</div>
		<div><b>Photobook Size :-</b> {{$mmbrequest->Size}}</div>
		<div><b>Request Received At :-</b> {{$mmbrequest->mmb_created_at}}</div>
		<div><b>Included Photo's :- 
			<div>
			@foreach($mmbrequest->mmb_photos as $k => $val)
				<span><img src="{{asset($val->photos)}}" style="width:130px;"></span>
			@endforeach
			</div>
		</div>
	</div>
</div>

@endsection
