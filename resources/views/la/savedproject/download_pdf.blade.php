<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Printed Cart :: Download PDF</title>
		<link rel="stylesheet" type="text/css" href="{{URL::asset('public/css/display_pdf.css')}}" media="all">
	</head>
	<body>
		<div id="page-content_{{$identifierClass}}" class="profile2 content-body" style="overflow-x: auto;">
		@if($pd->flag == 'Photobook')
			@foreach($savedProj as $k => $page)
				@if($k%2 == 0 || $k == 0)
				<div id="cal_{{$page->id}}" class="page_item">
				@endif
					<div class="inner_page">{!! $page->page_content !!}</div>
				@if($k%2 == 1)	
				</div>
				@endif
			@endforeach    
		@else
			@foreach($savedProj as $k => $page)
				<div id="cal_{{$page->id}}" class="page_item">
					<div class="crop-border">{!! $page->page_content !!}</div>
				</div>
			@endforeach   
		@endif
		
		</div>
	</body>
</html>
<?php //exit;?>