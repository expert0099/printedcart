<!doctype html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Printed Cart :: Photo-book PDF</title>
		
		{!! HTML::style('public/css/photobook_custom_editor.css') !!}
		<!--<link rel="stylesheet" href="{{URL::asset('public/css/photobook_custom_editor.css')}}"/>-->
		
		{!! HTML::style('public/css/bootstrap.min.css') !!}
		<!--<link rel="stylesheet" href="{{URL::asset('public/css/bootstrap.min.css')}}"/>-->
		
		<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
		<script type="text/javascript" src="{{ URL::asset('public/js/bootstrap.min.js') }}"></script>
	</head>
	
	<body>
		<div class="container-fluid" style="overflow-x: auto;">
			<a href="{{ URL::asset('photobooks/htmltopdfview/'.$project_id.'/pdf') }}" target="_blank">Download PDF</a>
			<table id="view-scale" style="border-collapse: collapse;box-sizing: border-box;width:100%">
				@foreach ($savedProj as $savedProj)
				<tr>
					<td>{!! $savedProj->page_content !!}</td>
				</tr>
				@endforeach
			</table>
		</div>
	</body>
	
	<script>
	$('#view-scale .page_content').each(function(){
		$(this).css('width','595px');
		$(this).css('height','842px');
	}); 
	$("#view-scale .canvas-container").each(function(){
		$(this).remove();
	});
	$('#view-scale .canv_position').each(function(){
		$(this).remove();
	});
	</script>
	
</html>