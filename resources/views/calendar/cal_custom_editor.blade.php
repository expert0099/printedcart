@extends("layouts.calendareditor")
@section("main-content")
<?php 

	//$calendar_size = '5x11';
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
	$cal_part_actual_height = (40/100)*$calendar_frame_height;
	$addClass = 'cal_'.$calendar_size;
	?>

<div class="container-fluid px-0 editor-holder">
	<div class="left-sidebar-section">
		<div class="tab-width px-0 left-icon-tab">
			<div class="left-one bhoechie-tab-menu float-left">
				<div class="list-group">
					<a href="#" class="list-group-item active text-center rounded-0"><i class="fa fa-columns fz-30" aria-hidden="true"></i><br/>Photos</a>
					<a href="#" class="list-group-item text-center"><i class="fa fa-columns fz-30" aria-hidden="true"></i><br/>Layout</a>
					<a href="#" class="list-group-item text-center"><i class="fa fa-tint fz-30" aria-hidden="true"></i><br/>Background</a>
				</div>
			</div>
			<div class="left-second bhoechie-tab float-left">
				<!-- Photo Albums  -->
				<div class="bhoechie-tab-content active">
					<div class="second-tab-sec">
						<h3>Albums</h3>
						@if(count($albums)>0)
						<ul id="albumListsLi" style="list-style: none;">
							@foreach($albums as $album)
							<a href="javascript:void(0);">
								<li label="album_{{$album->id}}" style="background: #eee; padding: 5px; border-radius:5px;  margin-bottom: 3px;"> {{$album->album_name}} </li>
							</a>
							<div id="album_{{$album->id}}" style="display: none;">
								@foreach($photos[$album->id] as $photo)
								<img src="<?=env("APP_URL")?>public/users_upload/{{$photo->user_id}}/{{$photo->name}}" class="thumbimage" id="drag_{{$photo->id}}" draggable="true" ondragstart="drag(event)"/>
								@endforeach
							</div>
							@endforeach
						</ul>
						@else
						<div>Album & Photo's not found! Please add photo</div>
						<!--<div><a class="nav-link" href="#" data-toggle="modal" data-target="#NewAlbum"><i class="fa fa-picture-o" aria-hidden="true"></i> New Album</a></div>-->
						@endif
						<div id="SelectAlbumPics"></div>
					</div>
				</div>
				<!-- Layout -->
				<div class="bhoechie-tab-content">
					<div class="second-tab-sec">
						<h3>Layout</h3>
						@foreach($layout as $k => $layts)
						<img class='img-fluid' id="{{$layts['id']}}" src="{{ URL::asset($layts['layout_image_path']) }}" alt='layout' style='width:23%;'>
						<div id="layout_content_page_hidden_{{$layts['id']}}" style="display:none;">{!! $layts['page_content'] !!} </div>
						@endforeach
					</div>
				</div>
				<!-- Background -->
				<div class="bhoechie-tab-content">
					<div class="second-tab-sec">
						<h3>Background</h3>
						@foreach($background_image as $k => $v)
						<img class='img-fluid' src="{{ URL::asset($v) }}" alt='background' style='width:23%;'>
						@endforeach
						<h3>Colors</h3>
						<div style="width:100%;display:inline-flex;">
							<div class="colorFlex" style="background-color:#000000;" rel="#000000"></div>
							<div class="colorFlex" style="background-color:#41464b;" rel="#41464b"></div>
							<div class="colorFlex" style="background-color:#696969;" rel="#696969"></div>
							<div class="colorFlex" style="background-color:#C3C8CD;" rel="#C3C8CD"></div>
							<div class="colorFlex" style="background-color:#461e0f;" rel="#461e0f"></div>
						</div>
						<div style="width:100%;display:inline-flex;">
							<div class="colorFlex" style="background-color:#730019;" rel="#730019"></div>
							<div class="colorFlex" style="background-color:#AA5F5F;" rel="#AA5F5F"></div>
							<div class="colorFlex" style="background-color:#CF2001;" rel="#CF2001"></div>
							<div class="colorFlex" style="background-color:#FA8C78;" rel="#FA8C78"></div>
							<div class="colorFlex" style="background-color:#EB2341;" rel="#EB2341"></div>
						</div>
						<div style="width:100%;display:inline-flex;">
							<div class="colorFlex" style="background-color:#FDBD52;" rel="#FDBD52"></div>
							<div class="colorFlex" style="background-color:#DCCDBE;" rel="#DCCDBE"></div>
							<div class="colorFlex" style="background-color:#827A70;" rel="#827A70"></div>
							<div class="colorFlex" style="background-color:#AA9678;" rel="#AA9678"></div>
							<div class="colorFlex" style="background-color:#DCCDB4;" rel="#DCCDB4"></div>
						</div>
						<div style="width:100%;display:inline-flex;">
							<div class="colorFlex" style="background-color:#EBD291;" rel="#EBD291"></div>
							<div class="colorFlex" style="background-color:#FFE164;" rel="#FFE164"></div>
							<div class="colorFlex" style="background-color:#F9EE7D;" rel="#F9EE7D"></div>
							<div class="colorFlex" style="background-color:#69BE50;" rel="#69BE50"></div>
							<div class="colorFlex" style="background-color:#00A04B;" rel="#00A04B"></div>
						</div>
						<div style="width:100%;display:inline-flex;">
							<div class="colorFlex" style="background-color:#233C7D;" rel="#233C7D"></div>
							<div class="colorFlex" style="background-color:#69B4EB;" rel="#69B4EB"></div>
							<div class="colorFlex" style="background-color:#AF5F91;" rel="#AF5F91"></div>
							<div class="colorFlex" style="background-color:#FF2F81;" rel="#FF2F81"></div>
							<div class="colorFlex" style="background-color:#FFC5D7;" rel="#FFC5D7"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- right content area -->
	<div class="eidtor-right-area transitioncaroselSec">
		@if ($errors->has())
		<div class="alert alert-danger">
			@foreach ($errors->all() as $error)
			{{ $error }}<br>
			@endforeach
		</div>
		@endif
		<!-- implement new calendar editor -->
		<?php 
		$monthArr = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
		?>
		<div class="container">
			<div class="row">
				<!-- The carousel -->
				<div id="transition-timer-carousel" class="carousel slide transition-timer-carousel {{$addClass}}" data-ride="carousel" data-interval="false">
					<!-- Indicators -->
					<ol class="carousel-pagination">
						<li data-target="#transition-timer-carousel" data-month="0" data-slide-to="0" rel="0">Cover <span></span></li>
						@foreach($monthArr as $k => $val)

						@if($k+1 == $month)
						<li data-target="#transition-timer-carousel" data-month="{{$k}}" data-slide-to="{{$k+1}}" rel="{{$k+1}}" class="active">{{$val}} <span></span></li>
						@else
						<li data-target="#transition-timer-carousel" data-month="{{$k}}" data-slide-to="{{$k+1}}" rel="{{$k+1}}">{{$val}} <span></span></li>
						@endif

						@endforeach
					</ol>
					<div class="left-right">
						<a class="left carousel-control" id="leftprev" href="#transition-timer-carousel" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left"></span>
						</a>
						<a class="right carousel-control" id="rightnext" href="#transition-timer-carousel" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right"></span>
						</a>
					</div>
					<!-- Wrapper for slides -->
					<div class="carousel-inner vertical">
						@if($savedProj && Session::has('CurrentProjectData'))
							@foreach($savedProj as $key => $page)
							<div class="item @if($key == $month) active @endif" id="item_{{$page->id}}">
								{!!$page->page_content!!}
							</div>
							@endforeach
						@else

							@foreach($demo_content as $key => $page)
							<div class="item @if($key == $month) active @endif" id="item_{{$page->id}}" rel="{{$page->id}}">
								{!! $page->page_content !!}
								<!--<script>
									$(function(){
										setCal({{$year}},{{$key-1}},'item_{{$page->id}}');
									});
									</script>-->
							</div>
							@endforeach

						@endif
						<input type="hidden" name="project_id" id="project_id" value="{{$project_id}}"/>
					</div>
					<!-- Controls -->
				</div>
			</div>
			<!-- Calender functionality starts -->
			<!-- debugging-->
			<div id="calDebug"></div>
			<!-- Add event modal form -->
			<div id="display-event-form" title="View Agenda Item"></div>
			<p>&nbsp;</p>
			<!-- Ends -->
			<!-- custom calendar -->
			<div class="response"></div>
			<div id='calendar'></div>
			<!-- ends -->
		</div>
		<!-- Open bootstrap modal to add calendar events -->
		<div id="createEventModal" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div id="modalBody" class="modal-body">
						<button style="padding: 15px;font-size: 30px;" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span class="sr-only">close</span></button>
					<!-- Adding sidebar stripe -->
						<div class="tab">
							<button class="tablinks" onclick="eventTab(event, 'Events')" id="defaultOpen">
								<img style="margin-left: 10px;" src="{{ URL::asset('public/images/Calendar-512.png') }}" /><br />
								<p class="fz-8">Events</p>
							</button>
							<button class="tablinks" onclick="eventTab(event, 'TextStyle')">
								<img style="margin-left: 10px;" src="{{ URL::asset('public/images/RomanText.png') }}" /><br />
								<p class="fz-8">Text Style</p>
							</button>
							<button class="tablinks" onclick="eventTab(event, 'EditPhoto')" disabled>
								<img style="margin-left: 10px;" src="{{ URL::asset('public/images/gallery.png') }}" /><br />
								<p class="fz-8">Edit Photo</p>
							</button>
						</div>

						<div id="Events" class="tabcontent">
							<h4 style="position: absolute;margin-top: 2%;" id="modalTitle" class="modal-title"></h4>
							<div class="mt-20">
								<div class="form-group">
									<input class="form-control" type="text" placeholder="Event Name" name="eventName" id="eventName">
								</div>
							</div>
						</div>

						<div id="TextStyle" class="tabcontent">
							  <h3>Text Style</h3>
							  <p>Anything will come here</p> 
						</div>

						<div id="EditPhoto" class="tabcontent">
							  <h3>Tokyo</h3>
							  <p>Tokyo is the capital of Japan.</p>
						</div>
					<!-- ends -->

					</div>
					<div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
						<button type="submit" class="btn btn-primary" id="submitButton">Save</button>
					</div>
				</div>
			</div>
		</div>
		<!-- modal ends -->
	</div>
	<!-- end implement new calendar editor -->
	<!-- preview dialog -->
	<div id="preview_dialog" title="Printed Cart :: Calendar Preview" style="display:none;"></div>
	<!-- Modal -->
	<div class="modal fade" id="ModalCarousel" tabindex="-1" role="dialog" aria-labelledby="ModalCarouselLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="myModalLabel">Calendar Preview</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<!--The main div for carousel-->
				<div class="carousel slide row {{$addClass}}" data-ride="carousel" data-type="multi" data-interval="false" id="fruitscarousel">
					@if(!null==$savedProj && Session::has('CurrentProjectData'))
					<div class="carousel-inner">
						@foreach($savedProj as $k => $page)
						<div class="item @if($k==$month) active @endif" id="item_{{$page->id}}">
							{!!$page->page_content!!}
						</div>
						@endforeach
					</div>
					<a class="left carousel-control" href="#fruitscarousel" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
					<a class="right carousel-control" href="#fruitscarousel" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>
					@else
					<div class="blank_cal_display">Save project first!</div>
					@endif
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- end preview dialog -->
	<!-- shipping address dialog -->
	<div id="shipping_address" title="Printed Cart :: Shipping Address" style="display:none;">
		{!! Form::open(['method' => 'POST','url'=>'payments/shipping_address','name'=>'style_form']) !!}
		<div class="form-group">{!! Form::text('first_name', null, ['class'=>'form-control', 'placeholder'=>'First Name', 'required'=>'true']) !!}</div>
		<div class="form-group">{!! Form::text('last_name', null, ['class'=>'form-control', 'placeholder'=>'Last Name', 'required'=>'true']) !!}</div>
		<div class="form-group">{!! Form::text('street', null, ['class'=>'form-control', 'placeholder'=>'Address', 'required'=>'true']) !!}</div>
		<div class="form-group">{!! Form::text('city', null, ['class'=>'form-control', 'placeholder'=>'City', 'required'=>'true']) !!}</div>
		<div class="form-group">{!! Form::text('state', null, ['class'=>'form-control', 'placeholder'=>'State', 'required'=>'true']) !!}</div>
		<div class="form-group">{!! Form::text('zipcode', null, ['class'=>'form-control', 'placeholder'=>'Zipcode', 'required'=>'true']) !!}</div>
		<div class="form-group">{!! Form::text('country', null, ['class'=>'form-control', 'placeholder'=>'Country', 'required'=>'true']) !!}</div>
		<div class="form-group" style="text-align:center;cursor:pointer;">{!! Form::submit('submit', null, ['class'=>'btn btn-success']) !!}</div>
		{!! Form::close() !!}
	</div>
	<!-- end shipping address dialog -->
	<!-- nicEdit dialog -->
	<div id="nicEdit_dialog" title="Printed Cart" style="display:none;">
		<textarea id="editorInDialog"></textarea>
		<div style="text-align:center;margin-top:10px;">
			<input type="hidden" name="gettypeid" id="gettypeid"/>
			<button id="nEdit" class="btn btn-success">OK</button>
		</div>
	</div>
	<!-- end nicEdit dialog -->
	<!-- project dialog -->
	<div id="project_dialog" title="Printed Cart : Save Project" style="display:none; text-align:center;">
		<form name="proj_form" id="proj_form" method="post">
			<input type="hidden" name="calendar_style_id" id="calendar_style_id" value="{!!$calendar_id!!}"/>
			<input type="hidden" id="calendar_category_id" name="calendar_category_id" value="{{$calendar_category_id}}"/>
			<input type="hidden" name="size_id" id="size_id" value="{!!$calendar_size_id!!}"/>
			<input type="hidden" name="price" id="price" value="{!!$price!!}"/>
			<input type="text" name="project_name" id ="project_name" placeholder="Project Name" style="margin-top:5px;" required='true'/>
			<div style="text-align:center;margin-top:15px;">
				<button id="proj" class="btn btn-success">Save</button>
			</div>
		</form>
	</div>
	<!-- end project dialog -->
	<form id="cropimg" name="cropimg" method="post">
		<input type="hidden" id="tId" name="tId">
	</form>
	<!-- Modal -->
	<link rel="stylesheet" type="text/css" href="{{URL::asset('public/css/crop/cropper.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('public/css/crop/custom.css')}}">
	<style>
		.modal-dialog{
		max-width: 850px;
		}
	</style>
	<div class="modal fade" id="cropModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Image Crop</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<!-- crop section body part -->
					<div class="row">
						<div class="img-container">
							<img id="image2" src="{{URL::asset('public/images/image2.jpg')}}" alt="Picture">
						</div>
						<div class="col-md-9 docs-buttons" style="text-align:center; max-width:100%; flex:0 0 100%">
							<!-- <h3>Toolbar:</h3> -->
							<div class="btn-group">
								<button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move" title="Move">
								<span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Move">
								<span class="fa fa-arrows"></span>
								</span>
								</button>
								<button type="button" class="btn btn-primary" data-method="setDragMode" data-option="crop" title="Crop">
								<span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Crop">
								<span class="fa fa-crop"></span>
								</span>
								</button>
							</div>
							<div class="btn-group">
								<button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
								<span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Zoom In">
								<span class="fa fa-search-plus"></span>
								</span>
								</button>
								<button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
								<span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Zoom Out">
								<span class="fa fa-search-minus"></span>
								</span>
								</button>
							</div>
							<div class="btn-group">
								<button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
								<span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Move Left">
								<span class="fa fa-arrow-left"></span>
								</span>
								</button>
								<button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
								<span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Move Right">
								<span class="fa fa-arrow-right"></span>
								</span>
								</button>
								<button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
								<span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Move Up">
								<span class="fa fa-arrow-up"></span>
								</span>
								</button>
								<button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
								<span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Move Down">
								<span class="fa fa-arrow-down"></span>
								</span>
								</button>
							</div>
							<div class="btn-group">
								<button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
								<span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Rotate Left">
								<span class="fa fa-rotate-left"></span>
								</span>
								</button>
								<button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
								<span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Rotate Right">
								<span class="fa fa-rotate-right"></span>
								</span>
								</button>
							</div>
							<div class="btn-group">
								<button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
								<span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Flip Horizontal">
								<span class="fa fa-arrows-h"></span>
								</span>
								</button>
								<button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
								<span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Flip Vertical">
								<span class="fa fa-arrows-v"></span>
								</span>
								</button>
							</div>
							<div class="btn-group">
								<button type="button" class="btn btn-primary" data-method="crop" title="Crop">
								<span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Crop">
								<span class="fa fa-check"></span>
								</span>
								</button>
								<button type="button" class="btn btn-primary" data-method="clear" title="Clear">
								<span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Clear">
								<span class="fa fa-remove"></span>
								</span>
								</button>
							</div>
							<div class="modal-footer">
								<div id="loading_cropper" style="display:none;"></div>
								<button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
								<button type="button" id="save_changes" class="btn btn-primary" data-method="getCroppedCanvas">Save changes</button>
							</div>
							<img src="" id="croped_image"/>
						</div>
						<!-- /.docs-buttons -->
						<div class="dropdown dropup docs-options">
						</div>
						<!-- /.dropdown -->
					</div>
					<!-- /.docs-toggles -->
					<!-- end crop section body part -->
				</div>
			</div>
		</div>
	</div>
	<!-- end image crop dialog -->
</div>


<!-- include js for undo-redo -->
<script src="{{URL::asset('public/js/undo_redo/JSYG.Events.js')}}"></script>
<script src="{{URL::asset('public/js/undo_redo/JSYG.StdConstruct.js')}}"></script>
<script src="{{URL::asset('public/js/undo_redo/JSYG.UndoRedo.js')}}"></script>
<!-- end include js for undo-redo -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
var delta =0;
function rotateBy10Deg(ele){
	ele.style.webkitTransform="rotate("+delta+"deg)";
	delta+=10;
}
var basePath = "<?php echo env('APP_URL');?>";
<!-- for undo and redu -->
var undoRedo = new UndoRedo('.carousel-inner',{});
$(document).ready(function(){
	$('#undo').on("click",function(){
		undoRedo.undo();
	});
	$('#redo').on("click",function() {
		undoRedo.redo();
	});
}); 
</script>
<script>
$(document).ready(function(){
	var bfw = "<?php echo $calendar_frame_width;?>";
	var bfh = "<?php echo $calendar_frame_height;?>";
	$('.imageContent').each(function(){ 
		$(this).css('width',bfw+'%');
		//$(this).css('height',bfh+'%');
		$(this).css('margin','0 auto');
		$(this).css('border','2px dotted #ccc');
		$(this).css('border-radius','2px');
		$(this).css('float','left');
		$(this).css('padding','10px');
	});
		
	$('.right.carousel-control').click(function(){
		$('.left.carousel-control').css('display','block');
		$('.carousel-pagination li.active').removeClass('active').next('li').addClass('active');
		var rel = $('.carousel-pagination li.active').attr('rel');
		if(rel==12){
			$('.right.carousel-control').css('display','none');
		}else{
			$('.right.carousel-control').css('display','block');
		}
	});
	$('.left.carousel-control').click(function(){
		$('.carousel-pagination li.active').removeClass('active').prev('li').addClass('active');
		$('.right.carousel-control').css('display','block');
		var rel = $('.carousel-pagination li.active').attr('rel');
		if(rel==0){
			$('.left.carousel-control').css('display','none');
		}else{
			$('.left.carousel-control').css('display','block');
		}
	});
	$('.carousel-pagination li').click(function(){
		$('.carousel-pagination li.active').removeClass('active');
		$(this).addClass('active');
	});	
});
</script>
<script>
var jcrop_api,boundx,boundy,
$preview = $('#preview-pane'),
$pcnt = $('#preview-pane .preview-container'),
$pimg = $('#preview-pane .preview-container img'),
xsize = $pcnt.width(),
ysize = $pcnt.height();
function allowDrop(ev) {
	ev.preventDefault();
	undoRedo.saveState();
}
function drag(ev) {
	ev.dataTransfer.setData("text", ev.target.id);
	$('.canvas-container').css('height','0px');
	$('.lower-canvas').css('height','0px');
	$('.upper-canvas').css('height','0px');
	undoRedo.saveState();
}
function drop(ev){
	ev.preventDefault();
	var data = ev.dataTransfer.getData("text");
	var src = document.getElementById(data).src;
	var nodeCopy = document.getElementById(data).cloneNode(true);
	nodeCopy.id = "newId_"+data;
	$('#image2').attr('src', src);
	if(ev.target.id == ""){
		//$('.jcrop-holder img').attr('src', src);
		$('#image2').attr('src', src);
		var tId = ev.target.parentNode.parentNode.id;
		if(tId == ""){
			var tId = ev.target.parentNode.id;
		}
		$('#cropimg #tId').val(tId);
		//$('#cropimg #tIddata').val(data);
	}else{
		$('#image2').attr('src', src);
		var tId = ev.target.id;
		$('#cropimg #tId').val(tId);
		//$('#cropimg #tIddata').val(data);
	}
	$('#cropModal').modal('show');
	$(function (){
		'use strict';
		var console = window.console || { log: function () {} };
		var URL = window.URL || window.webkitURL;
		var $image = $('#image2');
		var $download = $('#download');
		var $dataX = $('#dataX');
		var $dataY = $('#dataY');
		var $dataHeight = $('#dataHeight');
		var $dataWidth = $('#dataWidth');
		var $dataRotate = $('#dataRotate');
		var $dataScaleX = $('#dataScaleX');
		var $dataScaleY = $('#dataScaleY');
		var options = {
			aspectRatio: '',
			minContainerWidth: 200,
			minContainerHeight: 200,
			preview: '.img-preview',
			strict: true,
			// Re-render the cropper when resize the window
			responsive: true,
			// Restore the cropped area after resize the window
			restore: true,
			// Check if the current image is a cross-origin image
			checkCrossOrigin: true,
			// Check the current image's Exif Orientation information
			checkOrientation: true,
			crop: function (e) {
				$dataX.val(Math.round(e.x));
				$dataY.val(Math.round(e.y));
				$dataHeight.val(Math.round(e.height));
				$dataWidth.val(Math.round(e.width));
				$dataRotate.val(e.rotate);
				$dataScaleX.val(e.scaleX);
				$dataScaleY.val(e.scaleY);
			}
		};
		var originalImageURL = $image.attr('src');
		var uploadedImageName = 'cropped.jpg';
		var uploadedImageType = 'image/jpeg';
		var uploadedImageURL;
		// Tooltip
		$('[data-toggle="tooltip"]').tooltip();
		// Cropper
		setTimeout(function(){
			$image.on({
				ready: function (e) {
					console.log(e.type);
				},
				cropstart: function (e) {
					console.log(e.type, e.detail.action);
				},
				cropmove: function (e) {
					console.log(e.type, e.detail.action);
				},
				cropend: function (e) {
					console.log(e.type, e.detail.action);
				},
				crop: function (e) {
					console.log(e.type);
				},
				zoom: function (e) {
					console.log(e.type, e.detail.ratio);
				}
			}).cropper(options);
		},300);
		// Buttons
		
		// Methods
		$('.docs-buttons').on('click', '[data-method]', function () {
			//alert($(this).attr('id'));
				
			var $this = $(this);
			var data = $this.data();
			var cropper = $image.data('cropper');
			var cropped;
			var $target;
			var result;
			if ($this.prop('disabled') || $this.hasClass('disabled')) {
				return;
			}
			if (cropper && data.method) {
				data = $.extend({}, data); // Clone a new one
				if (typeof data.target !== 'undefined') {
					$target = $(data.target);
					if (typeof data.option === 'undefined') {
						try {
							data.option = JSON.parse($target.val());
						} catch (e) {
							console.log(e.message);
						}
					}
				}
				cropped = cropper.cropped;
				switch (data.method) {
					case 'rotate':
					if (cropped && options.viewMode > 0) {
						$image.cropper('clear');
					}
					break;
					case 'getCroppedCanvas':
					if (uploadedImageType === 'image/jpeg') {
						if (!data.option) {
							data.option = {};
						}
						//data.option.fillColor = '#fff';
					}
					break;
				}
				result = $image.cropper(data.method, data.option, data.secondOption);
					
				switch (data.method) {
					case 'rotate':
					if (cropped && options.viewMode > 0) {
						$image.cropper('crop');
					}
					break;
					case 'scaleX':
					case 'scaleY':
						$(this).data('option', -data.option);
						break;
						
					/* case 'getBlobURL':
		
						if(result){
							console.log("Result " + result);
							// Bootstrap's Modal
							
								$('#croped_image').attr('src', result.toDataURL(uploadedImageType));
								console.log(result.toDataURL(uploadedImageType));
						} */
					case 'getCroppedCanvas':
						if (result) {
			
							// Bootstrap's Modal
							//$('#getCroppedCanvasModal').modal().find('.modal-body').html(result);
							
							/* ajax call for save image */
							var base_path = "<?php echo config('app.url');?>";
							var tId = $('#tId').val();
							var loading = "{{URL::asset('public/images/loader.gif')}}";
							var dots = "{{URL::asset('public/images/dots.gif')}}";
							//alert(ttId);
							$.ajaxSetup({ 
								headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} 
							});
							$.ajax({
								url : base_path + 'calendars/crop_image',            
								type : 'POST',
								data : {imgsrc:result.toDataURL(uploadedImageType)},
								beforeSend: function(){
									//$("#loading_cropper").css('display','block');
									//$("#loading_cropper" ).html('<img src="'+loading+'"> loading...');
									swal("Please Wait...!", "Loading Data...!", "warning");
								},
								success : function(data){
									var src2 = base_path+data;
									$('#'+tId+' .bg-img').remove();				
									var parentdv = document.createElement("div");
									parentdv.className = "bg-img";
									var subparent = document.createElement("div");
									subparent.className = "bg-img-inner";
									subparent.onclick = function() { crop(src,tId); };
									subparent.style.cssText = 'background: url("'+src2+'");background-size:100% 100%;';
									parentdv.append("", subparent);
									$('#'+tId).append(parentdv);
									$("#loading_cropper" ).html('');
									$("#loading_cropper").css('display','none');
									$('#cropModal').modal('hide');
									swal("Done", "Data Loaded!", "success");
								}
							});
							return false;
						}
						break;
					case 'destroy':
					if (uploadedImageURL) {
						URL.revokeObjectURL(uploadedImageURL);
						uploadedImageURL = '';
						$image.attr('src', originalImageURL);
					}
					break;
				}
				if ($.isPlainObject(result) && $target) {
					try {
						$target.val(JSON.stringify(result));
					} catch (e) {
						console.log(e.message);
					}
				}
			}
		});
		$('#cropModal').on('hidden.bs.modal',function(){
			$image.cropper('destroy');
			$('#image2').attr('src', '');
			$('#cropModal').modal('hide');
		});
		// Keyboard
		$(document.body).on('keydown', function (e) {
			if (!$image.data('cropper') || this.scrollTop > 300) {
				return;
			}
			switch (e.which) {
				case 37:
					e.preventDefault();
					$image.cropper('move', -1, 0);
					break;
				case 38:
					e.preventDefault();
					$image.cropper('move', 0, -1);
					break;
				case 39:
					e.preventDefault();
					$image.cropper('move', 1, 0);
					break;
				case 40:
					e.preventDefault();
					$image.cropper('move', 0, 1);
					break;
			}
		});
		// Import image
		var $inputImage = $('#inputImage');
		if (URL) {
			$inputImage.change(function () {
				var files = this.files;
				var file;
				if (!$image.data('cropper')) {
					return;
				}
				if (files && files.length) {
					file = files[0];
					if (/^image\/\w+$/.test(file.type)) {
						uploadedImageName = file.name;
						uploadedImageType = file.type;
						if (uploadedImageURL) {
							URL.revokeObjectURL(uploadedImageURL);
						}
						uploadedImageURL = URL.createObjectURL(file);
						$image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
						$inputImage.val('');
					} else {
						window.alert('Please choose an image file.');
					}
				}
			});
		} else {
			$inputImage.prop('disabled', true).parent().addClass('disabled');
		}
	});
}
</script>
<style>
.ui-dialog.for_crop{
	left: 13% !important;
	top: 12% !important;
}
</style>
<link rel="stylesheet" href="{{URL::asset('public/css/lightslider.css')}}"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('public/js/bootstrap.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.0-rc.2/jquery-ui.js"
	integrity="sha256-6HSLgn6Ao3PKc5ci8rwZfb//5QUu3ge2/Sw9KfLuvr8="
	crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{URL::asset('public/js/crop/cropper.min.js')}}"></script>
<script src="{{URL::asset('public/js/lightslider.js')}}"></script> 
<link rel="stylesheet" href="{{URL::asset('public/css/photobook_custom_editor.css')}}"/>
<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/redmond/jquery-ui.min.css" rel="stylesheet">
<script>
if (top !== self) {
	$.ui.dialog.prototype._focusTabbable = $.noop;
}
</script>
<!-- nicEdit -->
<script type="text/javascript" src="{{URL::asset('public/js/jquery-drag-n-drop/nicEdit-latest.js')}}"></script> 
<script type="text/javascript">
var area1;
function toggleArea1(id){
	if(!area1){
		area1 = new nicEditor({buttonList : ['fontSize','bold','italic','underline','forecolor','bgcolor'],maxHeight:45}).panelInstance(id,{hasPanel : true});
	} else {
		area1.removeInstance(id);
		area1 = null;
	}
}
function removeCinput(removeid){
	var li_id = $("#"+removeid).closest('li').attr('id');
	var gettypeid = 'input'+li_id;
	toggleArea1(gettypeid);
	$('#'+removeid).remove();
}
</script>
<!-- end nicEdit -->
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
$(document).ready(function(){
	/** layout append into photo-book slide **/
	$('.img-fluid').css('cursor','pointer');
	$('.img-fluid').click(function(){
		$('.img-fluid').each(function(){
			$(this).removeClass('active');
		});
		$(this).addClass('active');
		var id = $(this).attr('id');
		var alt = $(this).attr('alt');
		if(alt == 'layout'){
			var page_content = $("#"+alt+"_content_page_hidden_"+id).html();
			$("#transition-timer-carousel .item.active .rowHeight").html(page_content);
			$("#transition-timer-carousel .item.active .rowHeight").addClass('custom_layout');
			$("#transition-timer-carousel .item.active .custom_layout .textinside").each(function(){
				$(this).css('display','block');
			});
			$("#transition-timer-carousel .item.active .custom_layout .dropable").each(function(){
				$(this).attr('id',Math.random().toString(36).substr(2, 9));
			}); 
			swal("Good job!", "Layout Set Successfully!!", "success");
		}else if(alt == 'background'){
			var imgSrc = $(this).attr('src');
			$("#transition-timer-carousel .item.active .imageContent").css("background-image","url('"+imgSrc+"')");
			swal("Good job!", "Background Set Successfully!!", "success");
		}
	});
	/** end layout append into photo-book slide **/
		
	/** background append into photo-book slide **/
	$('.colorFlex').click(function(){
		$("#transition-timer-carousel .item.active .imageContent").css('background-image','');
		var bg = $(this).attr('rel');
		$("#transition-timer-carousel .item.active .imageContent").css("background",bg);
		swal("Good job!", "Background Color Set Successfully!!", "success");
	});
	/** end background append into photo-book slide **/
		
	/** save project if not saved **/
	$('#proj').click(function(){
		var base_path = "<?php echo config('app.url');?>";
		var month = "<?php echo $month;?>";
		var year = "<?php echo $year;?>";
		var formData = $('#proj_form').serialize();
		var projV = $('#proj_form input[name=project_name]').val();
		if(projV){
			$.ajaxSetup({ 
				headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} 
			});
			$.ajax({
				url : base_path + 'calendars/save_project',            
				type : 'POST',
				data : {form_data:formData,flag:'Calendar',cmonth:month,cyear:year},
				beforeSend: function(){
					//toastr.success("Please Wait...! Saving Data");
					swal("Please Wait...!", "Loading Data...!", "warning");
				},
				success : function(data){
					if(data=='error'){
						//toastr.error("Sorry! Project not create! Please try again...!");
						swal("Oops!", "Project not create! Please try again...!", "error");
					}else{
						$('#project_id').val(data);
						$('.ui-dialog-titlebar-close').trigger('click');
						//toastr.success("Thanks! Project Created Successfully! Now save your project!");
						swal("Thanks!", "Project created successfully! Now save your project!", "success");
					}
				}
			});
			return false;
		}
	});
	/** end saved project if not saved **/
		
	/** save pages into project **/
	$('#save_pages').click(function(){
		var base_path = "<?php echo config('app.url');?>";
		var optionHtml = [];
		$("#transition-timer-carousel .carousel-inner .item").each(function(){ 
			optionHtml.push($(this).html());
		}); 
		var project_id = $('#project_id').val();
		if(project_id==''){
			$("#project_dialog").dialog({
				width: 300,
				height: 200,
				modal: true,
				resizable: false,
			});
		}else{
			var counter = 0;
			$('.bg-img-inner').each(function(){
				if($(this).length > 0){
					counter++;
				}
			});
			if(counter == 0){
				//toastr.error("Sorry! Please drag image first!");
				swal("Oops!", "Please drag image first...!", "error");
			}else{
				$.ajaxSetup({ 
					headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} 
				});
				$.ajax({
					url : base_path+'calendars/save_calendar',            
					type : 'POST',
					crossDomain:true,
					data : {page_content:optionHtml,project_id:project_id,_token:$('meta[name="_token"]').attr('content')},
					beforeSend: function(){
						//toastr.success("Please Wait...! Saving Project Data");
						swal("Please Wait...!", "Saving Project Data...!", "warning");
					},
					success : function(data){
						if(data=='saved'){
							swal("Thanks!", "Project Saved Successfully!!", "success")
							.then((value) => {
								window.location.reload();
							});
							/* toastr.success("Thanks! Project Saved Successfully!!");
							setTimeout(function(){ 
								window.location.reload();
							}, 2000); */
						}
					}
				});
				return false;
			}
		}
	});
	/** end save pages into project **/
		
	/** nicEdit **/
	$('#transition-timer-carousel').on('click', '.textcontleft', function(){
		var li_id = $('.item.active').attr('rel');
		$(this).attr('id','input'+li_id);
		var gettypeid = 'input'+li_id;
		$("#nicEdit_dialog input[name=gettypeid]").val(gettypeid);
		<!-- open nicEdit dialog -->
		$("#nicEdit_dialog").dialog({
			width: 400,
			height: 300,
			position: 'center',
			modal: true,
			resizable: false,
			open: function() {
				new nicEditor({
					fullPanel: true,
					iconsPath: 'https://cdn.jsdelivr.net/nicedit/0.9r24/nicEditorIcons.gif'
				}).panelInstance('editorInDialog');
			}
		});
		$('#nicEdit_dialog .nicEdit-main').css('width','100%');
		$('div#nicEdit_dialog').on('dialogclose', function(event){
			var nicHtml = $('#nicEdit_dialog .nicEdit-main').html();
			var nicEId = $("#gettypeid").val();
			if(nicHtml=='<br>'){
				//$('#'+nicEId).html('Click Here to add content');
			}else{
				$('#'+nicEId).html(nicHtml);
			}
			undoRedo.saveState();
		});
		$('#nEdit').on('click',function(){
			var nicHtml = $('#nicEdit_dialog .nicEdit-main').html();
			var nicEId = $("#gettypeid").val();
			if(nicHtml=='<br>'){
				//$('#'+nicEId).html('Click Here to add content');
			}else{
				$('#'+nicEId).html(nicHtml);
			}
			$('.ui-dialog-titlebar-close').trigger('click');
			undoRedo.saveState();
		});
	});
	/** end nicEdit **/
		
	/** for preview photo-book **/
	$('#preview').click(function(e){
		//var loading = "{{URL::asset('public/images/loading_spinner.gif')}}";
		var basePath = "<?php echo env('APP_URL');?>";
		var project_id = $('#project_id').val();
				
		$.ajax({
			method: 'get',
			url: basePath + 'calendars/get_calendar_preview/'+project_id,
			beforeSend: function(){
				//toastr.success("Please Wait...! Loading Preview Data");
				swal("Please Wait...!", "Loading Project Data...!", "warning");
			},
			success: function(data){
				if(data == 'failed'){
					//toastr.error("Sorry! Please save this project data first!!");
					swal("Oops!", "Please save this data first...!", "error");
				}else{
					$("#preview_dialog").html(data);
					$("#preview_dialog").dialog({
						width: 1024,
						height: 400,
						modal: true,
						resizable: false,
					});
					$('#preview_dialog').parent().addClass('preview-large');
				}
			},
			error: function(e){
				var json = JSON.stringify(e);
			}
		}); 
	});
	/** end for preview photo-book **/
		
	/** add to cart **/
	$('.add-to-cart-nav').click(function(){
		var basePath = "<?php echo env('APP_URL');?>";
		var project_id = $('#project_id').val();
		$.ajax({
			method: 'get',
			url: basePath + 'calendars/get_calendar_status/'+project_id,
			beforeSend: function(){
				//toastr.success("Please Wait...! Saving Data");
				swal("Please Wait...!", "Saving Data...!", "warning");
			},
			success: function(data){
				if(data == 'failed'){
					//toastr.error("Sorry! Please save this project data first!!");
					swal("Oops!", "Please save this project data first...!", "error");
				}else{
					add_to_cart();
				}
			},
			error: function(e) {
				var json = JSON.stringify(e);
			}
		});
	});
	function add_to_cart(){
		var project_id = $('#project_id').val();
		$.ajaxSetup({ 
			headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') } 
		});
		$.ajax({
			url : basePath+'calendars/add_to_cart',            
			type : 'POST',
			data : {project_id:project_id,_token:$('meta[name="_token"]').attr('content')},
			success : function(data){
				if(data.status == 'added'){
					var item_count = data.item_count;
					$('#cart_count').html(item_count);
					//toastr.success("Thanks! Project added successfully into cart!!");
					swal("Thanks!", "Project added Successfully into cart!!", "success");
				}else{
					//toastr.error("Sorry! Either already added or something went wrong!!");
					swal("Oops!", "Either already added or something went wrong...!", "error");
				}
			}
		});
		return false;
	}
	/** end add to cart **/
		
	/** shipping address dialog **/
	$('#basket').click(function(){
		var basePath = "<?php echo env('APP_URL');?>";
		$.ajax({
			url : basePath + 'calendars/shipping_address_status',            
			type : 'GET',
			beforeSend: function(){
				//toastr.success("Please Wait...! Loading Page Data");
				swal("Please Wait...!", "Loading Page Data...!", "warning");
			},
			success : function(data){
				if(data == 'exist'){
					window.location.href = basePath+'payments/cart/cal';
				}else{
					$("#shipping_address").dialog({
						width: 800,
						height: 600,
						modal: true,
						resizable: false,
					});
				}
			}
		});
	});
	/** end shipping address dialog **/
		
	$('.fa-search-plus').on('click',function(){
		var currentScale = parseFloat($(this).attr('data-scale'));
		var scale = currentScale + parseFloat(0.1);
		if(scale > 2.1){
			//alert('You have maximum zoomed!');
			//toastr.error("Sorry! You have maximum zoomed!!");
			swal("Oops!", "You have maximum zoomed...!", "error");
		}else{
			$(this).attr('data-scale', scale);
			$('#transition-timer-carousel .carousel-inner').css({'-webkit-transform': 'scale('+ scale +')'});
			var currentPT = parseInt($(this).attr('rel'));
			var currentPL = parseInt($(this).attr('p'));
			var currentSW = parseInt($(this).attr('s'));
			if(currentPT >= 60){
				if(currentPT >= 80){
					if(currentPT >= 140){
						if(currentPT >= 200){
							if(currentPT >= 270){
								var CPT = currentPT;
							}else{
								var CPT = currentPT + parseInt(5);
							}
						}else{
							var CPT = currentPT + parseInt(10);
						}
					}else{
						var CPT = currentPT + parseInt(15);
					}
				}else{
					var CPT = currentPT + parseInt(10);
				}
			}else{
				var CPT = currentPT + parseInt(20);
			}
			if(currentPL >= 80){
				if(currentPL >= 170){
					if(currentPL >= 230){
						var CPL = currentPL + parseInt(10);
						$('#transition-timer-carousel .carousel-inner').width(currentSW+parseInt(10));
						$(this).attr('s', currentSW+parseInt(10));
					}else{
						var CPL = currentPL + parseInt(20);
						$('#transition-timer-carousel .carousel-inner').width(currentSW+parseInt(20));
						$(this).attr('s', currentSW+parseInt(20));
					}
				}else{
					var CPL = currentPL + parseInt(30);
					$('#transition-timer-carousel .carousel-inner').width(currentSW+parseInt(30));
					$(this).attr('s', currentSW+parseInt(30));
				}
			}else{
				var CPL = currentPL + parseInt(40);
				$('#transition-timer-carousel .carousel-inner').width(currentSW+parseInt(40));
				$(this).attr('s', currentSW+parseInt(40));
			}
			$('#transition-timer-carousel .carousel-inner').css({'padding-top':CPT+'px'});
			$(this).attr('rel', CPT);
			$(this).attr('p', CPL);
		}
	});
	$('.fa-search-minus').on('click',function(){
		$('.fa-search-plus').attr('data-scale', 1);
		$('.fa-search-plus').attr('rel', 0);
		$('.fa-search-plus').attr('p', 0);
		$('#transition-timer-carousel .carousel-inner').removeAttr('style');
	});
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.6.6/fabric.min.js"></script>
<script>
$(function(){
	$('#addText').click(function(){
		var id = $('#transition-timer-carousel .item.active').attr('id');
		var data_attr = $(this).attr('data-canvas');
		// For some browsers, `attr` is undefined; for others, `attr` is false. Check for both.
		if ((typeof data_attr !== typeof undefined && data_attr !== false) && $(this).attr('data-canvas') == id ) {
		  // Element has this attribute
		}
		else{
			var html = $('#transition-timer-carousel .item.active').html();
			$(this).attr('data-canvas', id);
			canvas = new fabric.Canvas('canv_'+id);
		}
		var txt = new fabric.Textbox("Add Text Here", {
			fontFamily: 'Arial',
			fontSize: 22,
			textAlign: "center",
			fill: '#000',
			width: 200,
			lineHeight: 1.2,
			fontWeight: "normal",
		});
			
		canvas.backgroundColor = 'rgba(255,255,255,0)';
		canvas.selectionColor = 'rgba(255,255,255,0.3)';
		canvas.selectionBorderColor = 'rgba(0,0,0,0.1)';
		canvas.hoverCursor = 'pointer';
		canvas.setWidth(480);
		canvas.setHeight(350);
		canvas.calcOffset();
		canvas.renderAll();
		//save history on each object's modification
		canvas.observe('object:modified', function(){
			//save_history();
		});
		
		canvas.on('object:moving', function (e){
			
		}); 
		canvas.add(txt);
		txt.center();
		txt.setCoords();
		canvas.calcOffset();
		canvas.renderAll();
		console.log(canvas.toSVG());
	});
}); 
</script>
<style>
.book_pages{
	overflow: auto;
}
.textcontleft{z-index:10;}
.textEdit{z-index:10;}
#undo.disabled,
#redo.disabled{
	color: #ccc;
}
.canvas-container{
	position: absolute!important;
	-moz-user-select: none!important;
	z-index: 9;
	overflow:visible;
}
.upper-canvas{
	position: absolute!important;
	left: 0px!important;
	top: 0px!important;
	-moz-user-select: none!important;
	cursor: default;
}  
.canv_position{
	position:absolute;
}
</style>
<!-- show calendar under calendar layout -->
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
	$('#'+id+' .calendaer ').html(calElement);
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
	var tableAlign = "center";
	// create basic table structure
	var text = "<div class='JFrontierCal' id='mycal' style='width:100%;float:left;'>"; // initialize accumulative variable to empty string
	text += '<CENTER>'
	text += '<TABLE ALIGN='+ tableAlign +' BORDER=' + border + ' CELLSPACING=' + cellspacing + ' style=border-color:'+ borderColor +' WIDTH='+ tableWidth +'%>' // table settings
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
<style>
table{
	font-family: arial;
}
#ModalCarousel .modal-dialog{
	max-width:1000px;
}
#ModalCarousel .modal-content{
	width:1024px;
}
#ModalCarousel .carousel-inner {
	max-width: 650px;
	margin: 10% auto;
}
#ModalCarousel .carousel-inner .row.rowHeight {
	width: 60%;
	float: left;
	height: 292px;
	margin-right: 2%;
}
#fruitscarousel .imageContent .main-calendar{
	width:245px;
	float:left;
}
#fruitscarousel .carousel-inner .imageContent {
	width: 100%;
	height: 77vh;
	margin: 0px auto;
	border: 2px solid;
	border-radius: 2px;
}
.btn.btn-default {
	background-color: #0099cc;
	color: #fff;
}
.btn.btn-default:hover{
	background-color: #007bff;
	color: #fff;
	border: 1px solid #0099cc;
}
#fruitscarousel.cal_11x5 {
	border: 1px solid #ccc;
	margin: 20px 40px;
	box-sizing: border-box;
}
#fruitscarousel.cal_11x5 .carousel-inner {
	max-width: 940px !important;
	width: 940px !important;
}
#fruitscarousel.cal_11x5 .carousel-inner .imageContent {
	height: 100% !important;
}
#fruitscarousel.cal_11x5 .carousel-inner .row.rowHeight {
	width: 60% !important;
	float: left;
	height: 60vh !important;
	/* margin-right: 2%; */
}
#fruitscarousel.cal_11x5 .carousel-inner .row.rowCoverHeight{
	width: 100% !important;
	float: left;
	height: 60vh !important;
	/* margin-right: 2%; */
}
#fruitscarousel.cal_11x5 .imageContent .main-calendar {
	width: 38% !important;
	float: left;
}
#fruitscarousel.cal_11x5 .calendar-imgs.imageContent {
	max-width: 100% !important;
	width: 100% !important;
	float: left;
}
</style>

<style>
#calendar {
	width: 700px;
	margin: 0 auto;
}
.response {
	height: 60px;
}
.success {
	background: #cdf3cd;
	padding: 10px 60px;
	border: #c3e6c3 1px solid;
	display: inline-block;
}
</style>
<style>
/* Style the tab */
.tab {
    float: left;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
    width: 10%;
    height: 300px;
}
/* Style the buttons inside the tab */
.tab button {
    display: block;
    background-color: inherit;
    color: black;
    padding: 22px 16px;
    width: 100%;
    border: none;
    outline: none;
    text-align: left;
    cursor: pointer;
    transition: 0.3s;
    font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current "tab button" class */
.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    float: left;
    padding: 0px 12px;
    width: 50%;
    border-left: none;
    height: 300px;
}

.modal-body {padding: 0px;}
.fz-8 {font-size: 8px;margin-left: 10px;}
.mt-20 {margin-top: 20%;}
</style>
<!-- end show calendar under calendar layout -->
<script>
$(document).ready(function () {
	var calendar = $('.calendaer').fullCalendar({
		aspectRatio: 2.2,
		editable: true,
		selectable: true,
		displayEventTime: false,
		selectHelper: true,
		editable: true,
		showNonCurrentDates: false,
		defaultDate: moment('2019-10-01'),
		select: function (start, end, allDay) {
			//do something when space selected
			//Show 'add event' modal
			$('#createEventModal').modal('show');
			
			$('#submitButton').on('click',function(){
				var mockEvent = {title: $('#eventName').val(), start: $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss")};
				$('.calendaer').fullCalendar('renderEvent', mockEvent);
				$('#submitButton').unbind('click');
				$('#createEventModal').modal('hide');
			});
		},
		//When u drop an event in the calendar do the following:
		eventDrop: function (event, delta, revertFunc) {
			//do something when event is dropped at a new location
		},
		//When u resize an event in the calendar do the following:
		eventResize: function (event, delta, revertFunc) {
			//do something when event is resized
		},
		// Render Event
		eventRender: function (event, element, view) {
			$(element).tooltip({title: event.title});
		},
		//Activating modal for 'when an event is clicked'
		dayClick: function (event) {
			$('#modalTitle').text(event.format());
			$('#modalBody').html(event.description);
			$('#createEventModal').modal();
		}
		/* dayClick: function(date, jsEvent, view) {
			$('#modalLoginForm').modal('show');
		} */
	});
});
function displayMessage(message) {
	$(".response").html("<div class='success'>"+message+"</div>");
	setInterval(function() { $(".success").fadeOut(); }, 1000);
}
$('.left-right a#leftprev').click(function() {
	$('.calendaer').fullCalendar('prev');
	var prevmonth = $(this).attr('data-slide');
});
$('.left-right a#rightnext').click(function() {
	$('.calendaer').fullCalendar('next');
	var month = $(this).attr('data-slide');
	var nextmonth = $(this).attr('data-slide');
});
$('.carousel-pagination li').click(function() {
	var month = $(this).attr('data-month');
	var m = moment([moment().year(), month, 1]);
	$('.calendaer').fullCalendar('gotoDate', m );
});

function eventTab(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}
// Get the element with id="defaultOpen" and click on it
//document.getElementById("defaultOpen").click();
</script>

@endsection