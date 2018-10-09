@extends('la.layouts.app')

@section("contentheader_title", "Pdf View")

@section('main-content')

<meta name="_token" content="{{ csrf_token() }}" />

<link rel="stylesheet" href="{{URL::asset('public/css/photobook_custom_editor.css')}}"/>
<link rel="stylesheet" href="{{URL::asset('public/css/custom.css')}}"/>
		
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('public/js/bootstrap.min.js')}}"></script>-->

<!--<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/redmond/jquery-ui.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>-->
		
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>-->

<!--<script src="{{URL::asset('public/js/crop/html2canvas.min.js')}}"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.svg.js"></script>
<style>
.textinside{
	display: none;
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
/* .profile2.content-body .page_item .calendar-imgs.imageContent {
	 height: 732px !important;
} */
.content-body {
	flex-direction: column;
	    overflow-x: visible;
}
.content-body .page_item > div {
	width: 100%;
	border-right:3px solid #fff;
}
.content-body .canv_position {
	position: absolute;
	left: 0;
	right: 0;
	margin: 0 auto;
}
.content-body .page_item .row.rowHeight {
	width: 100%!important;
}
#page-content_Calendar_12x12 .page_item .row.rowHeight{
    height: 40vh !important;
}




#page-content_Calendar_5x11.content-body .page_item .row.rowHeight {
    width: 58% !important;
    float: left;
    height: 45%;
}
#page-content_Calendar_5x11.content-body .page_item .main-calendar {
	width: 40% !important;
	float: left;
}
#page-content_Calendar_5x11.content-body .page_item .row.rowCoverHeight{
	height: 45%;
}

#page-content_Calendar_8x11.content-body .page_item .row.rowHeight {
	height: 70vh;
}

/*#page-content_CollegePoster_20x30 .page_item .row.rowHeight {
    height: 40% !important;
}*/
/* #page-content_Calendar_8x11.content-body .page_item .row.rowHeight {
	height: 45%;
} */

#page-content_Photobook .imageContent{
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
}
.page_content{
	position: relative;
	margin:auto;
	width: auto;
}

.page_count{
	text-align: center;
    color: #333;
    background-color: #fff;
	/* height:20px; */
}
#page-content_Photobook.content-body {
    width: 100% !important;
	float:left !important;
}
#page-content_Photobook.content-body .page_item {
    display: flex !important;
    float: left !important;
    width: 100% !important;
	background-color: white !important;
    padding: 15px;
    margin-bottom: 15px;
}


#page-content_Calendar_12x12.content-body .page_item .row.rowCoverHeight{
    height: 100vh !important;
}
#page-content_Calendar_12x12.content-body .page_item {
    display: flex;
    float: left;
	width: 69%;
    height: 100%;
}
#page-content_Calendar_12x12{
	overflow-y:hidden;
}

#page-content_Calendar_8x11.content-body .page_item .row.rowCoverHeight{
    height: 120vh !important;
}
#page-content_Calendar_8x11.content-body .page_item {
    display: flex;
    height: 135vh;
	width:100%;
	float:left;
	
}
#page-content_Calendar_8x11{
	overflow-y:hidden;
}
#page-content_Calendar_8x11 .imageContent{
	float: none;
}


#page-content_Calendar_11x5.content-body .page_item .row.rowCoverHeight{
    height: 30vh !important;
}
#page-content_Calendar_11x5.content-body .page_item {
    display: flex;
    height: 33vh;
	width:100%;
	float:left;
	
}
#page-content_Calendar_11x5{
	overflow-y:hidden;
}
#page-content_Calendar_11x5 .imageContent{
	float: none;
}

#page-content_Calendar_11x5 .row.rowHeight {
	width: 50% !important;
	height: 30vh;
}
#page-content_Calendar_11x5 .main-calendar {
	width: 48%;
	float: left;
}


#page-content_CollegePoster_20x30.content-body .page_item .row.rowCoverHeight{
    height: 100% !important;
}
#page-content_CollegePoster_20x30.content-body .page_item {
    display: flex;
    height: 140vh;
	width:100%;
	float:left;
	
}
#page-content_CollegePoster_20x30{
	overflow-y:hidden;
}
#page-content_CollegePoster_20x30 .imageContent{
	float: none;
}


#page-content_CollegePoster_20x30 .main-calendar {
	width: 100%;
	float: left;
}
#page-content_CollegePoster_20x30 .main-calendar table{
	width:100%;
	margin-bottom:15px;
	height: 150px;
}


#page-content_CollegePoster_8x8.content-body .page_item .row.rowCoverHeight{
    height: 100% !important;
}
#page-content_CollegePoster_8x8.content-body .page_item {
    display: flex;
    height: 140vh;
	width:100%;
	float:left;
}
#page-content_CollegePoster_8x8{
	overflow-y:hidden;
}
#page-content_CollegePoster_8x8 .imageContent{
	float: none;
}


#page-content_CollegePoster_8x8 .main-calendar {
	width: 100%;
	float: left;
}
#page-content_CollegePoster_8x8 .main-calendar table{
	width:100%;
	margin-bottom:15px;
	height: 150px;
}


#page-content_CollegePoster_12x12.content-body .page_item .row.rowCoverHeight{
    height: 100% !important;
}
#page-content_CollegePoster_12x12.content-body .page_item {
    display: flex;
    height: 140vh;
	width:100%;
	float:left;
	
}
#page-content_CollegePoster_12x12{
	overflow-y:hidden;
}
#page-content_CollegePoster_12x12 .imageContent{
	float: none;
}


#page-content_CollegePoster_12x12 .main-calendar {
	width: 100%;
	float: left;
}
#page-content_CollegePoster_12x12 .main-calendar table{
	width:100%;
	margin-bottom:15px;
	height: 150px;
}


#page-content_CollegePoster_16x20.content-body .page_item .row.rowCoverHeight{
    height: 100% !important;
}
#page-content_CollegePoster_16x20.content-body .page_item {
    display: flex;
    height: 140vh;
	width:100%;
	float:left;
	
}
#page-content_CollegePoster_16x20{
	overflow-y:hidden;
}
#page-content_CollegePoster_16x20 .imageContent{
	float: none;
}


#page-content_CollegePoster_16x20 .main-calendar {
	width: 100%;
	float: left;
}
#page-content_CollegePoster_16x20 .main-calendar table{
	width:100%;
	margin-bottom:15px;
	height: 150px;
}


#page-content_CollegePoster_11x14.content-body .page_item .row.rowCoverHeight{
    height: 100% !important;
}
#page-content_CollegePoster_11x14.content-body .page_item {
    display: flex;
    height: 140vh;
	width:100%;
	float:left;
	
}
#page-content_CollegePoster_11x14{
	overflow-y:hidden;
}
#page-content_CollegePoster_11x14 .imageContent{
	float: none;
}


#page-content_CollegePoster_11x14 .main-calendar {
	width: 100%;
	float: left;
}
#page-content_CollegePoster_11x14 .main-calendar table{
	width:100%;
	margin-bottom:15px;
	height: 150px;
}


#page-content_CollegePoster_8x10.content-body .page_item .row.rowCoverHeight{
    height: 100% !important;
}
#page-content_CollegePoster_8x10.content-body .page_item {
    display: flex;
    height: 140vh;
	width:100%;
	float:left;
	
}
#page-content_CollegePoster_8x10{
	overflow-y:hidden;
}
#page-content_CollegePoster_8x10 .imageContent{
	float: none;
}


#page-content_CollegePoster_8x10 .main-calendar {
	width: 100%;
	float: left;
}
#page-content_CollegePoster_8x10 .main-calendar table{
	width:100%;
	margin-bottom:15px;
	height: 150px;
}
.mainDivSecond{
	height:150px;
}
#page-content_CollegePoster_20x30 .page_item .crop-border .imageContent{
	border: 2px dotted red !important;
}
#page-content_CollegePoster_20x30 .page_item .custom_layout .col-sm-8 {
    width: 66.6% !important;
    float: left !important;
}
#page-content_CollegePoster_20x30 .page_item .custom_layout .col-sm-4 {
    width: 33% !important;
    float: left !important;
}
#page-content_CollegePoster_20x30 .page_item .custom_layout .col-sm-8 .bg-img-inner {
    float: left !important;
    width: 100% !important;
 
}

#page-content_Photobook_11x8 .imageContent {
    height: 100% !important;
}

</style>

<div style="width:100%;float:left;">
	<a href="{{ url(config('laraadmin.adminRoute') . '/saved_project') }}"><button class="btn btn-success">Back</button></a>
	<a href="{{ url(config('laraadmin.adminRoute') . '/saved_project/custom_view/pdf/'.$order_id) }}" target="_blank"><button class="btn btn-danger">Download PDF</button></a>
	<div id="ready" style="display:block;">PDF is ready for download...</div>
</div>
<div id="page-content" class="profile2 content-body" style="overflow-x: auto;">
	@foreach($savedProj as $k => $page)
		<div id="cal_{{$page->id}}" class="page_item">
			<div class="crop-border"><img src="{{URL::asset('public/'.$page->image_path)}}" style="width:500px;"></div>
		</div>
	@endforeach   
</div>
@endsection
