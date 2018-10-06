@extends("layouts.photobook")

@section("main-content")
 
<link rel="stylesheet" href="{{URL::asset('public/css/photobook_custom_editor.css')}}"/>
<!--<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>-->
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<style>
.page_content {
	width: 100%;
	height: 842px;
}
#Photobook_11x8 .page_content {
	width: 100%;
	height: 450px;
}
.imageContent {
	height: 100% !important;
}
.bg-img-inner {
	z-index: 2;
}
.page_item .imageContent .inputBox {
	height: 10%;

}
.page_item .imageContent .inputBox > div {
	height:100%;
		display: flex;
align-items: center;
justify-content: center;
display: -webkit-flex;
-webkit-align-items: center;
-webkit-justify-content: center;
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
	background-image: url("../../../../public/images/cal-bg.jpg");
}
.content-body {
	width: 595px;
	display: flex;
	flex-direction: column;
}
.content-body .page_item > div {
	width: 100%;
}
.content-body .canv_position {
	position: absolute;
	left: 0;
	right: 0;
	margin: 0 auto;
}



</style>

<div class="container">

	<!-- Calander Page Info Start -->
	<section class="mt-5 mb-3">
		<div class="row">
			<div class="col-12">
				<h2 class="text-blue mb-3">Pdf View</h2>
				<div style="width:100%;float:left;">
						<a href="{{URL::asset('user/section#order_history')}}"><button class="btn btn-success">Back</button></a>
						<a href="{{ URL::asset('user/section/pdfview/'.$project_id.'/'.$order_id) }}" target="_blank"><button class="btn btn-danger">Download PDF</button></a>
					</div>
				<!-- pdf view -->
				<div class="content-body" id="{{$identifierClass}}">
					
					<!--<table id="view-scale" style="border-collapse: collapse;box-sizing: border-box;width:595px;text-align:center;">
						<tr>
							<td>-->
								@foreach($savedProj as $k => $page)
									<div id="cal_{{$page->id}}" class="page_item">
										<div>{!! $page->page_content !!}</div>
									</div>
								@endforeach
							<!--</td>
						</tr>
					</table>-->
									
				</div>
				<!-- end end pdf view -->
			</div>
		</div>
	</section>
		
</div>

<script language="javascript">
var project_id = "<?php echo $project_id?>";
var order_id = "<?php echo $order_id;?>";
$('.page_item').each(function(){
	var page_id = $(this).attr('id');
	
	html2canvas([document.getElementById(page_id)], {
		onrendered: function(canvas){
			//document.getElementById('canvas').appendChild(canvas);
			var data = canvas.toDataURL('image/png');
			console.log(data);
			/* var image = new Image();
			image.src = data;
			document.getElementById('image').appendChild(image); */
			
			var file= dataURLtoBlob(data);
						
			var fd = new FormData();
			fd.append('files', file);
			fd.append('project_id', project_id);
			fd.append('page_id', page_id);
			fd.append('order_id', order_id);
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

@endsection