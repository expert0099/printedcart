<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Printed Cart :: Download PDF</title>
				
		<!--<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/bootstrap.min.css') }}" media="all">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/font-awesome.min.css') }}" media="all">-->
		<!--<link rel="stylesheet" type="text/css" href="{{URL::asset('public/css/photobook_custom_editor.css')}}" media="all">
		<link rel="stylesheet" type="text/css" href="{{URL::asset('public/css/custom.css')}}" media="all">-->
		<link rel="stylesheet" type="text/css" href="{{URL::asset('public/css/display_pdf.css')}}" media="all">
		
		<script type="text/javascript" src="{{ URL::asset('public/js/jquery-1.12.4.js') }}"></script>
		
		<!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
		<!--<style>
		.textinside {
			display:none;
		}
		</style>-->
	</head>
	<body>
		<!--<p style="text-align:center;color:#fff;">Printed Cart</p>-->
		<div id="page-content_{{$identifierClass}}" class="profile2 content-body" style="overflow-x: auto;">
		<!-- @foreach($savedProj as $k => $page)
		<div style="text-align:center;">
			{!! $page->page_content !!}
		</div>
		@endforeach -->
		
		@if($pd->flag == 'Photobook')
			@foreach($savedProj as $k => $page)
				@if($k%2 == 0 || $k == 0)
				<div id="cal_{{$page->id}}" class="page_item">
				@endif
					<div>{!! $page->page_content !!}</div>
				@if($k%2 == 1)	
				</div>
				@endif
			@endforeach    
		@else
			@foreach($savedProj as $k => $page)
				<div id="cal_{{$page->id}}" class="page_item">
					<div class="crop_border">{!! $page->page_content !!}</div>
				</div>
			@endforeach   
		@endif
		
		</div>
		
		<!--@foreach($order_pdf as $k => $pdf)
		<div style="text-align:center;"><img src="{{URL::asset('public/canvas_upload/'.$user_id.'/'.$pdf->image_name)}}"></div>
		@endforeach -->
		
		<script language="javascript">
		$(document).ready(function(){
			//$('.imageContent').attr('style','width:100%!important;');
		});
		</script>
	</body>
</html>
<?php //exit;?>