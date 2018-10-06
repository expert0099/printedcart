@extends("layouts.subdomain")

@section("main-content")

<link href="{{URL::asset('public/css/fullcalendar/fullcalendar.min.css')}}" rel="stylesheet"/>
<link href="{{URL::asset('public/css/fullcalendar/fullcalendar.print.min.css')}}" rel="stylesheet" media="print" />
<script src="{{URL::asset('public/js/fullcalendar/lib/moment.min.js')}}"></script>
<script src="{{URL::asset('public/js/fullcalendar/lib/jquery.min.js')}}"></script>
<script src="{{URL::asset('public/js/fullcalendar/fullcalendar.min.js')}}"></script>

<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/redmond/jquery-ui.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>

<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->

<script type="text/javascript" src="{{URL::asset('public/js/timepicker/jquery.timepicker.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{URL::asset('public/css/timepicker/jquery.timepicker.css')}}" />

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
$(document).ready(function(){
	$('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay,listWeek'
		},
		defaultDate: "<?php echo date('Y-m-d');?>",
		navLinks: true, // can click day/week names to navigate views
		editable: true,
		eventLimit: true, // allow "more" link when too many events
		events: <?php echo $events;?>/* [
			{
				title: 'All Day Event',
				start: '2018-03-01',
			},
			{
				title: 'Long Event',
				start: '2018-03-07',
				end: '2018-03-10'
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: '2018-03-09T16:00:00'
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: '2018-03-16T16:00:00'
			},
			{
				title: 'Conference',
				start: '2018-03-11',
				end: '2018-03-13'
			},
			{
				title: 'Meeting',
				start: '2018-03-12T10:30:00',
				end: '2018-03-12T12:30:00'
			},
			{
				title: 'Lunch',
				start: '2018-03-12T12:00:00'
			},
			{
				title: 'Meeting',
				start: '2018-03-12T14:30:00'
			},
			{
				title: 'Happy Hour',
				start: '2018-03-12T17:30:00'
			},
			{
				title: 'Dinner',
				start: '2018-03-12T20:00:00'
			},
			{
				title: 'Birthday Party',
				start: '2018-03-13T07:00:00'
			},
			{
				title: 'Click for Google',
				url: 'http://google.com/',
				start: '2018-03-28'
			}
		] */
    });
	
	$("#add_event").on('click', function(){
		$("#add_event_dialog").dialog({
			width: 650,
			height: 500,
			position:'center',
			modal: true,
			resizable: false,
		});
	});
	$("#datepicker").datepicker({
		dateFormat:'yy-mm-dd'
	});
	$("#datepicker2").datepicker({
		dateFormat:'yy-mm-dd'
	});
	$('input.timepicker').timepicker({
        timeFormat: 'H:i:s',
        interval: 30 // 30 minutes
    });
	
	setTimeout(function() {
        $('.alert-success').fadeOut('fast');
    }, 5000); 
	setTimeout(function(){
        $('.alert-danger').fadeOut('fast');
    }, 5000);
	
	$("#addEventButton").on('click',function(){
		if($("input[name=event_title]").val()=='' && $("input[name=event_start_date]").val()=='' && $("input[name=event_start_time]").val()=='' && $("input[name=event_end_date]").val()=='' && $("input[name=event_end_time]").val()=='' && $("input[name=location_name]").val()=='' && $("input[name=street_address]").val()=='' && $("textarea[name=notes]").val()==''){
			swal("Oops!","Field can not be empty...!","error");
		}else{
			swal("Please Wait...!","Data Loading...!","warning");
		}
	});
});
</script>
<style>
#calendar{
	max-width: 950px;
    margin: 10px auto;
	background-color: #e6edf2;
}
.sc-custom{
	display: inline;
	float: right;
	position: static;
	padding: 2px 25px 1px;
	margin-left: 24px;
	margin-right: -24px;
}
.sc-custom .cal-add{
    margin-left: -3px;
}
.sc-custom .cal-action{
    vertical-align: baseline;
    line-height: normal;
	padding-left: 21px;
	font-size: 11px;
	background-color: transparent;
	background-repeat: no-repeat;
}
.section-title{
    text-align: left;
	font-size: 18px;
	vertical-align: middle;
}
.ti-add{
	width: 19px;
	height: 19px;
}
.ti-icon-new{
	background-image: url(public/images/370798199.png);
}
.ui-dialog{
	top:50% !important;
	transform: translate(-50%, -50%);
	left:50% !important;
	z-index:999 !important;
}
</style>

<section class="yellow-bg">
	<div class="white-bg">
		<div id="header-r2" style="margin-top: 70px;">
			<div id="header-title" tip="iyuimhk">Blue Theme</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<nav class="menus-item">
						<ul>
							<li><a href="{{URL::asset('/?sid='.base64_encode($sharesite_id))}}">Home</a></li>
							<li><a href="{{URL::asset('/?sid='.base64_encode($sharesite_id).'&page=pictures')}}">Pictures &amp; Videos</a></li>
							<li class="active"><a href="{{URL::asset('/?sid='.base64_encode($sharesite_id).'&page=calendar')}}">Calendar</a></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
		<div class="theme-content">
			<div class="container">
				@foreach($errors->all() as $error)
					<p class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">×</span></button>
					{{ $error }}
					</p>
				@endforeach
				@if (session('success_msg'))
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">×</span></button>
						{{ session('success_msg') }}
					</div>
					<script>
					swal("Done","{{ session('success_msg') }}","success");
					</script>
				@endif
				@if(session('error_msg'))
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">×</span></button>
						{{ session('error_msg') }}
					</div>
					<script>
					swal("Oops!","{{ session('error_msg') }}","error");
					</script>
				@endif
				<div class="row">
					<div class="col-sm-12">
						<span class="sc-custom ">
							<a id="add_event" class="cal-action cal-add ti-icon-new ti-add" href="javascript:void(0);">Add&nbsp;event</a>
						</span>
						<a class="section-title">Calendar</a>
					</div>
					<div class="col-sm-12"></div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div id='calendar'></div>
					</div>
				</div>
			</div>
			
			<!-- add event dialog -->
			<div id="add_event_dialog" title="Share site :: Add Event" style="display:none; overflow-x:hidden;">
				{!! Form::open(['method' => 'POST','url'=>'/add_event','name'=>'style_form','class'=>'row']) !!}
				<div class="form-group col-sm-6">
					<input type="hidden" name="sharesite_id" value="{{$sharesite_id}}"/>
					<label for="event_type">Event Type:</label>
					{!! Form::select('event_type', $event_type, null, ['class'=>'form-control', 'required'=>'true']) !!}
				</div>
				<div class="form-group col-sm-6">
					<label for="event_title">Event Title:</label>
					{!! Form::text('event_title', null, ['class'=>'form-control', 'placeholder'=>'Event Title', 'required'=>'true']) !!}
				</div>
				<div class="form-group col-sm-6">
					<label for="event_start_date">Event Start Date:</label>
					{!! Form::text('event_start_date', null, ['id' => 'datepicker', 'class'=>'form-control', 'placeholder'=>'Event Start Date', 'required'=>'true']) !!}
				</div>
				<div class="form-group col-sm-6">
					<label for="event_start_time">Event Start Time:</label>
					{!! Form::text('event_start_time', null, ['id' => 'timepicker','class'=>'form-control timepicker', 'placeholder'=>'Event Start Time', 'required'=>'true']) !!}
				</div>
				<div class="form-group col-sm-6">
					<label for="event_end_date">Event End Date:</label>
					{!! Form::text('event_end_date', null, ['id'=> 'datepicker2','class'=>'form-control', 'placeholder'=>'Event End Date', 'required'=>'true']) !!}
				</div>
				<div class="form-group col-sm-6">
					<label for="event_end_time">Event End Time:</label>
					{!! Form::text('event_end_time', null, ['id' => 'timepicker2', 'class'=>'form-control timepicker', 'placeholder'=>'Event End Time', 'required'=>'true']) !!}
				</div>
				<div class="form-group col-sm-6">
					<label for="location_name">Location Name:</label>
					{!! Form::text('location_name', null, ['class'=>'form-control', 'placeholder'=>'Location Name', 'required'=>'true']) !!}
				</div>
				<div class="form-group col-sm-6">
					<label for="street_address">Street Address:</label>
					{!! Form::text('street_address', null, ['class'=>'form-control', 'placeholder'=>'Street Address', 'required'=>'true']) !!}
				</div>
				<div class="form-group col-sm-6">
					<label for="notes">Notes:</label>
					{!! Form::textarea('notes', null, ['class'=>'form-control', 'placeholder'=>'Notes', 'required'=>'true','rows'=>'2']) !!}
				</div>
				<div class="form-group col-sm-12" style="text-align:center;cursor:pointer;">
					{!! Form::submit('Submit', ['id'=>'addEventButton', 'class' => 'form-control btn btn-primary', 'style'=>'width:100px;']) !!}
				</div>
			
				{!! Form::close() !!}
			</div>
			<!-- end add event dialog --> 
			
		</div>
		<div class="footer-section">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<div class="row page-view">
							<!--<div class="col-sm-3"><a href="#">Report inappropriate content</a></div>
							<div class="col-sm-6 text-center"><span>Page views: 3</span></div>
							<div class="col-sm-3 text-right"><p><a href="#">Atom</a> <a href="#">RSS</a> <a href="#">OPML</a></p></div>-->
						</div>
						<div class="footer-menus">
							<ul>
								<li><a href="{{URL::asset(config('app.url').'pages/about')}}">About Printed Cart</a></li>
								<li><a href="{{URL::asset(config('app.url').'pages/customer_service')}}">Customer Service</a></li>
								<li><a href="{{URL::asset(config('app.url').'pages/terms')}}">Terms</a></li>
								<li><a href="{{URL::asset(config('app.url').'pages/privacy')}}">Privacy</a></li>
								<li>Help us improve Printed Cart Share. </li>
								<li><a href="{{URL::asset(config('app.url').'user/feedback')}}">Send feedback to Printed Cart.</a></li>
							</ul>
							<p class="copyright-footer">Copyright Printed Cart {{date('Y')}}. All rights reserved.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection