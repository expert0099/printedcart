<!doctype html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Printed Cart :: Photo-book PDF</title>
		<meta name="_token" content="{{ csrf_token() }}" />
		<link rel="stylesheet" href="{{URL::asset('public/css/photobook_custom_editor.css')}}"/>
		
		<link rel="stylesheet" href="{{URL::asset('public/css/bootstrap.min.css')}}"/>
		
		<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
		<script type="text/javascript" src="{{ URL::asset('public/js/bootstrap.min.js')}}"></script>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
		<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->
		
		<style>
		a {
			color: #000066;
			text-decoration: none;
		}
		table {
			border-collapse: collapse;
		}
		thead {
			vertical-align: bottom;
			text-align: center;
			font-weight: bold;
		}
		tfoot {
			text-align: center;
			font-weight: bold;
		}
		th {
			text-align: left;
			padding-left: 0.35em;
			padding-right: 0.35em;
			padding-top: 0.35em;
			padding-bottom: 0.35em;
			vertical-align: top;
		}
		td {
			padding-left: 0.35em;
			padding-right: 0.35em;
			padding-top: 0.35em;
			padding-bottom: 0.35em;
			vertical-align: top;
		}
		img {
			margin: 0.2em;
			vertical-align: middle;
		}
		
		.row.rowCoverHeight{
			width: 100%;
			float: left;
			height: 100%;
			margin-left:0px;
		}
		.row.rowHeight{
			width: 58%;
			float: left;
			height: 100%;
			margin-right: 2%;
		}
		.main-calendar {
			width: 40%;
			float: left;
		}


.cal_12x12 .calendar-imgs.imageContent{
    max-width: 864px !important;
    width: 864px !important;
    height: 864px !important;
}
.cal_12x12 .calendar-imgs.imageContent {
	float: left;
	background-image:url("http://localhost/printedcart/public/images/cal-bg.jpg");
	padding: 20px;
	border: 2px solid #d1c2c2 !important;
}		
.cal_12x12 #drop_event_cover {
    padding: 0px;
}
.cal_12x12 .calendar-imgs.imageContent {
    padding: 44px 44px;
    width: 100%;
}
.cal_12x12 #item_1, .cal_12x12 #item_2, .cal_12x12 #item_3, .cal_12x12 #item_4, .cal_12x12 #item_5, .cal_12x12 #item_6, 
.cal_12x12 #item_7, .cal_12x12 #item_8, .cal_12x12 #item_9, .cal_12x12 #item_10, .cal_12x12 #item_11, .cal_12x12 #item_12        {
    width: 100%;
    float: left;
}
.cal_12x12 #item_1 span, .cal_12x12 #item_2 span, .cal_12x12 #item_3 span, .cal_12x12 #item_4 span, .cal_12x12 #item_5 span, 
.cal_12x12 #item_6 span, .cal_12x12 #item_7 span, .cal_12x12 #item_8 span, .cal_12x12 #item_9 span, .cal_12x12 #item_10 span, .cal_12x12 #item_11 span, .cal_12x12 #item_12 span  {
    display: flex;
    text-align: center;
    height: 30px;
    width: 100%;
    float: left;
}
.cal_12x12 #item_2 .row.rowHeight, .cal_12x12 .row.rowHeight {
    width: 100%;
    float: left;
    height: 54%;
    margin-right: 0;
    margin-left: 0;
    margin-bottom: 32px;
}
.cal_12x12 #item_2 .mb-3, .cal_12x12 .col-sm-12 {
    padding: 0px !important;
    margin: 0px !important;
}
.cal_12x12 #item_2 .main-calendar, .cal_12x12 .main-calendar {
    width: 100%;
    float: left;
}
.cal_12x12 .row.customRow2 {
    float: left;
    width: 100%;
    height: 100%;
}
.cal_12x12 #drop_event_1x2_1{
	border: 0px;
}
.calendar-imgs.imageContent {
	background-image: url("../../../public/images/cal-bg.jpg");
}
.page_item{
	float:left;
}
	</style>
	</head>
	<?php 
	$ex = explode('x',$calendar_size);
	
	if($ex[0]>$ex[1]){
		$ratio = $ex[1]/$ex[0]*100;
		$calendar_frame_width = 100;
		$calendar_frame_height = round($ratio);
	}else{
		$ratio = $ex[0]/$ex[1]*100;
		$calendar_frame_width = round($ratio);
		$calendar_frame_height = 100;
	} 
	?>
	<body>
		<div class="container-fluid {{'cal_'.$calendar_size}}" style="overflow-x: auto;" id="view_port">
			<a href="{{ URL::asset('calendars/htmltopdfview/'.$project_id.'/pdf') }}" target="_blank">Download PDF</a>
			<table id="view-scale" style="border-collapse: collapse;box-sizing: border-box;width:100%;text-align:center;">
				<tr>
					<td>
						@foreach($savedProj as $k => $page)
						<div id="cal_{{$page->id}}" class="page_item">
							<div>{!! $page->page_content !!}</div>
						</div>
						@endforeach
					</td>
				</tr>
			</table>
			
			
			<!--<div id="canvas">
				<p>Canvas:</p>
			</div>
			<div style="width:200px; float:left" id="image">
				<p style="float:left">Image: </p>
			</div>
			<div style="float:left;margin-top: 120px;" class="return-data"></div>-->
			
		</div>
	</body>
	
	
	<script language="javascript">
	var project_id = "<?php echo $project_id?>";
	$('.page_item').each(function(){
	var page_id = $(this).attr('id');

	html2canvas([document.getElementById(page_id)], {
		onrendered: function(canvas){
			//document.getElementById('canvas').appendChild(canvas);
			var data = canvas.toDataURL('image/png');
			/* var image = new Image();
			image.src = data;
			document.getElementById('image').appendChild(image); */
		
			var file= dataURLtoBlob(data);
			var fd = new FormData();
			fd.append('files', file);
			fd.append('project_id', project_id);
			fd.append('page_id', page_id);
			var base_path = "<?php echo config('app.url');?>";
			$.ajaxSetup({ 
				headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} 
			});
			$.ajax({
				url: base_path+"uploadFile",
				type: "POST",
				data: fd,
				processData: false,
				contentType: false,
			}).done(function(respond){
				//alert(respond);
				//$(".return-data").html("Uploaded Canvas image link: <a href="+respond+">"+respond+"</a>").hide().fadeIn("fast");
			});
		}
	});
	});
	function dataURLtoBlob(dataURL) {
		// Decode the dataURL    
		var binary = atob(dataURL.split(',')[1]);
		// Create 8-bit unsigned array
		var array = [];
		for(var i = 0; i < binary.length; i++) {
			array.push(binary.charCodeAt(i));
		}
		// Return our Blob object
		return new Blob([new Uint8Array(array)], {type: 'image/png'});
	}
	
	</script>
</html>