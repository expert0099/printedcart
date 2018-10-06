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
<script src="{{URL::asset('public/js/crop/html2canvas.min.js')}}"></script>
<style>
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

#page-content_CollegePoster_20x30 .page_item .row.rowHeight {
    height: 40% !important;
}
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
    height: 100% !important;
}
#page-content_Calendar_11x5.content-body .page_item {
    display: flex;
    height: 140vh;
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
</style>

<div style="width:100%;float:left;">
	<a href="{{ url(config('laraadmin.adminRoute') . '/saved_project') }}"><button class="btn btn-success">Back</button></a>
	<a href="{{ url(config('laraadmin.adminRoute') . '/saved_project/view/pdf/'.$project_id.'/'.$order_id) }}" target="_blank"><button class="btn btn-danger">Download PDF</button></a>
	<div id="ready" style="display:none;">PDF is ready for download...</div>
	<div id="loading"><img src="{{URL::asset('public/images/loading_spinner.gif')}}"> Please wait...! PDF processing for download...</div>
</div>
<div id="page-content_{{$identifierClass}}" class="profile2 content-body" style="overflow-x: auto;">
	@if($project['flag']=='Photobook')
		@foreach($savedProj as $k => $page)
			@if($k%2 == 0 || $k == 0)
			<div id="cal_{{$page->id}}" class="page_item">
			@endif
				<div>
				{!! $page->page_content !!}
				</div>
			@if($k%2 == 1)	
			</div>
			@endif
		@endforeach    
	@else
		@foreach($savedProj as $k => $page)
			<div id="cal_{{$page->id}}" class="page_item">
				<div>{!! $page->page_content !!}</div>
			</div>
		@endforeach   
	@endif
	
</div>

<script language="javascript">
$('.imageContent').each(function(){
	var height = $(this).attr('height');
	$(this).css('height',height+'!important');
});

var project_id = "<?php echo $project_id?>";
var order_id = "<?php echo $order_id;?>";
//var loading = "{{URL::asset('public/images/loading_spinner.gif')}}";
var url = "{{ url(config('laraadmin.adminRoute').'/saved_project/dt_ajax') }}";

$('.page_item').each(function(){
	var page_id = $(this).attr('id');
	
	html2canvas([document.getElementById(page_id)], {
		useCORS: true,
		allowTaint: true,
		letterRendering: true,
		onrendered: function(canvas){
			var ctx= canvas.getContext('2d');
			ctx.scale(2, 2);
			ctx.mozImageSmoothingEnabled = false;
			ctx.webkitImageSmoothingEnabled = false;
			ctx.msImageSmoothingEnabled = false;
			ctx.imageSmoothingEnabled = false;
			
			var data = canvas.toDataURL('image/jpeg', 1.0);
			console.log(data);
			
			var file= dataURLtoBlob(data);

			var fd = new FormData();
			fd.append('files', file);
			fd.append('project_id', project_id);
			fd.append('page_id', page_id);
			fd.append('order_id', order_id);
			var base_path = "<?php echo config('app.url');?>";
			setTimeout(function(){
				$('#loading').hide();
				$('#ready').show();
			},2000);
			$.ajaxSetup({ 
				headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} 
			});
			$.ajax({
				url: url,
				type: "POST",
				data: fd,
				processData: false,
				contentType: false,
				//beforeSend: function(){$("#loading" ).html('<img src="'+loading+'"> <br>Please wait...! PDF processing for download...');},
			}).done(function(respond){
				//$('.profile2').css('display','none');
				//$('#loading').hide();
				//$('#ready').show();
				//alert(respond);
				//$(".return-data").html("Uploaded Canvas image link: <a href="+respond+">"+respond+"</a>").hide().fadeIn("fast");
			});
		}
	});
	//$(this).removeClass('x2');
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
	return new Blob([new Uint8Array(array)], {type: 'image/jpeg'});
}

</script>

<script>
function leapYear(year){
	if(year % 4 == 0) // basic rule
    return true // is leap year
    /* else */ // else not needed when statement is "return"
	return false // is not leap year
}

function getDays(month, year){
	var ar = new Array(12);
	ar[0] = 31; // January
	ar[1] = (leapYear(year)) ? 29 : 28; // February
	ar[2] = 31; // March
	ar[3] = 30; // April
	ar[4] = 31; // May
	ar[5] = 30; // June
	ar[6] = 31; // July
	ar[7] = 31; // August
	ar[8] = 30; // September
	ar[9] = 31; // October
	ar[10] = 30; // November
	ar[11] = 31; // December
	return ar[month];
}

function getMonthName(month){
	var ar = new Array(12);
	ar[0] = "January";
	ar[1] = "February";
	ar[2] = "March";
	ar[3] = "April";
	ar[4] = "May";
	ar[5] = "June";
	ar[6] = "July";
	ar[7] = "August";
	ar[8] = "September";
	ar[9] = "October";
	ar[10] = "November";
	ar[11] = "December";
	return ar[month];
}

function setCal(yr,mth,id){
	var now = new Date();
	var year = yr;
	var month = mth;
	var monthName = getMonthName(month);
	var date = now.getDate();
	now = null;
	var firstDayInstance = new Date(year, month, 1);
	var firstDay = firstDayInstance.getDay();
	firstDayInstance = null;
	var days = getDays(month, year);
	var calElement = drawCal(firstDay + 1, days, date, monthName, year);
	$('#'+id+' .calendaer').html(calElement);
}

function drawCal(firstDay, lastDate, date, monthName, year) {
  var headerHeight = 25 // height of the table's header cell
  var border = 0 // 3D height of table's border
  var cellspacing = 0 // width of table's border
  var headerColor = "midnightblue" // color of table's header
  var headerSize = "+1" // size of tables header font
  var colWidth = 40 // width of columns in table
  var dayCellHeight = 25 // height of cells containing days of the week
  var dayColor = "darkblue" // color of font representing week days
  var cellHeight = 30 // height of cells representing dates in the calendar
  var todayColor = "red" // color specifying today's date in the calendar
  var timeColor = "purple" // color of font representing current time
  var borderColor = "darkgray";
  var tableWidth = 100;

  // create basic table structure
  var text = "" // initialize accumulative variable to empty string
  text += '<CENTER>'
  text += '<TABLE BORDER=' + border + ' CELLSPACING=' + cellspacing + ' style=border-color:'+ borderColor +' WIDTH='+ tableWidth +'%>' // table settings
  text += '<TH COLSPAN=7 HEIGHT=' + headerHeight + ' style=text-align:center;>' // create table header cell
  text += '<FONT COLOR="' + headerColor + '" SIZE=' + headerSize + '>' // set font for table header
  text += monthName + ' ' + year
  text += '</FONT>' // close table header's font settings
  text += '</TH>' // close header cell

  // variables to hold constant settings
  var openCol = '<TD WIDTH=' + colWidth + ' HEIGHT=' + dayCellHeight + '>'
  openCol += '<FONT COLOR="' + dayColor + '">'
  var closeCol = '</FONT></TD>'

  // create array of abbreviated day names
  var weekDay = new Array(7)
  weekDay[0] = "Sun"
  weekDay[1] = "Mon"
  weekDay[2] = "Tues"
  weekDay[3] = "Wed"
  weekDay[4] = "Thu"
  weekDay[5] = "Fri"
  weekDay[6] = "Sat"

  // create first row of table to set column width and specify week day
  text += '<TR ALIGN="center" VALIGN="center">'
  for (var dayNum = 0; dayNum < 7; ++dayNum) {
    text += openCol + weekDay[dayNum] + closeCol
  }
  text += '</TR>'

  // declaration and initialization of two variables to help with tables
  var digit = 1
  var curCell = 1

  for (var row = 1; row <= Math.ceil((lastDate + firstDay - 1) / 7); ++row) {
    text += '<TR ALIGN="center" VALIGN="center">'
    for (var col = 1; col <= 7; ++col) {
      if (digit > lastDate)
        break
      if (curCell < firstDay) {
        text += '<TD></TD>';
        curCell++
      } else {
        if (digit == date) { // current cell represent today's date
          text += '<TD HEIGHT=' + cellHeight + '>'
          //text += '<FONT COLOR="' + todayColor + '">'
          text += digit
          //text += '</FONT><BR>'
          //text += '<FONT COLOR="' + timeColor + '" SIZE=2>'
          //text += '<CENTER>' + getTime() + '</CENTER>'
          //text += '</FONT>'
          text += '</TD>'
        } else
          text += '<TD HEIGHT=' + cellHeight + '>' + digit + '</TD>'
        digit++
      }
    }
    text += '</TR>'
  }

  // close all basic table tags
  text += '</TABLE>'
  text += '</CENTER>'

  // print accumulative HTML string
  //document.write(text)
  return text;
}
</script>

@endsection
