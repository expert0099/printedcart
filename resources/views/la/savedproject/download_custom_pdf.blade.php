<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Printed Cart :: Download PDF</title>
		<link rel="stylesheet" type="text/css" href="{{URL::asset('public/css/display_pdf.css')}}" media="all">
	</head>
	<body>
		<div id="page-content" class="profile2 content-body" style="overflow-x: auto;">
		@foreach($savedProj as $k => $v)
			<div id="cal_{{$v->id}}" class="page_item">
				<div class="crop-border"><img src="{{URL::asset('public/'.$v->image_path)}}"></div>
			</div>
		@endforeach	
		
		</div>
	</body>
</html>
<?php //exit;?>