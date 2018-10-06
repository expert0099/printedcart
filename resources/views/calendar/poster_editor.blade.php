@extends("layouts.postereditor")

@section("main-content")

<?php 
//echo $calendar_size; exit;
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
?>

<div class="container-fluid px-0 editor-holder">
	
	<div class="left-sidebar-section">
        <div class="tab-width px-0 left-icon-tab">
            <div class="left-one bhoechie-tab-menu float-left">
				<div class="list-group">
					<a href="#" class="list-group-item active text-center rounded-0"><i class="fa fa-columns fz-30" aria-hidden="true"></i><br/>Photos</a>
					<a href="#" class="list-group-item text-center"><i class="fa fa-columns fz-30" aria-hidden="true"></i><br/>Layout</a>
					<a href="#" class="list-group-item text-center"><i class="fa fa-tint fz-30" aria-hidden="true"></i><br/>Backgrounds</a>
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
								<a href="javascript:void(0)">
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
	<div class="eidtor-right-area">
		@if ($errors->has())
			<div class="alert alert-danger">
			  @foreach ($errors->all() as $error)
				{{ $error }}<br>
			  @endforeach
			</div>
		@endif
		<!-- implement new calendar editor -->
		<div class="container">
			@if(null!==Session::get('CurrentProjectData'))
				<div class="poster_layout poster_{!!$calendar_size!!}">
				{!!Session::get('CurrentProjectData')->page_content!!}
				</div>
			@else

				<div class="poster_layout poster_{!!$calendar_size!!}">
				{!!$demo_content->page_content!!}
				</div>
				<script>
				var year = "<?php echo $year;?>";
				var displayCal = '';
				$(function(){
					for(i=0;i<=11;i++){
						displayCal =  displayCal + setCal(i,year);
					}
					$('.main-calendar').html(displayCal);
				});
				</script>
			@endif
			<input type="hidden" name="project_id" id="project_id" value="{{$project_id}}"/>
		</div>
		<!-- end implement new calendar editor -->
	</div>
	
	<!-- preview dialog -->
	<div id="preview_dialog" title="Printed Cart :: Poster Preview" style="display:none;"></div>
	
	<!-- Modal -->
	<div class="modal fade" id="ModalCarousel" tabindex="-1" role="dialog" aria-labelledby="ModalCarouselLabel">
		<div class="modal-dialog poster_{!!$calendar_size!!}" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="myModalLabel">Poster Preview</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div>
					@if(null!==Session::get('CurrentProjectData'))
						<div>
						{!!Session::get('CurrentProjectData')->page_content!!}
						</div>
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
	
	<!-- project dialog -->
	<div id="project_dialog" title="Printed Cart : Save Project" style="display:none; text-align:center;">
		<form name="proj_form" id="proj_form" method="post">
		<input type="hidden" name="calendar_style_id" id="calendar_style_id" value="{!!$calendar_id!!}"/>
		<input type="hidden" id="calendar_category_id" name="calendar_category_id" value="{{$calendar_category_id}}"/>
		<input type="hidden" name="size_id" id="size_id" value="{!!$size_id!!}"/>
		<input type="hidden" name="price" id="price" value="{!!$price!!}"/>
		<input type="text" name="project_name" id ="project_name" placeholder="Project Name" style="margin-top:5px;" required='true'/>
		<div style="text-align:center;margin-top:15px;">
			<button id="proj" class="btn btn-success">Save</button>
		</div>
		</form>
	</div>
	<!-- end project dialog -->
	
	<!-- includes for crop -->
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script type="text/javascript" src="{{URL::asset('public/js/crop/cropper.min.js')}}"></script>
	<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
	

<link rel="stylesheet" href="{{URL::asset('public/css/poster_custom_editor.css')}}"/>
<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/redmond/jquery-ui.min.css" rel="stylesheet">
<script type="text/javascript" src="{{ URL::asset('public/js/bootstrap.min.js') }}"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
	<!-- end include for crop -->
	
	<!-- image crop dialog -->
	<!--<div id="crop_dialog" title="Printed Cart : Crop Image" style="display:none;">
		<link rel="stylesheet" type="text/css" href="{{URL::asset('public/css/crop/styles.css')}}">
		<link rel="stylesheet" type="text/css" href="{{URL::asset('public/css/crop/jquery.Jcrop.css')}}">
		<script type="text/javascript" src="{{URL::asset('public/js/crop/jquery.Jcrop.js')}}"></script>
		
		<div id="wrapper">
			<div class="jc-demo-box">
				<img src="{{URL::asset('public/images/cropimg.jpg')}}" id="target" class="target" alt="Default Image" />
				<div id="form-container">
					<form id="cropimg" name="cropimg" method="post">
						<input type="hidden" id="tId" name="tId">
						<input type="hidden" id="x" name="x">
						<input type="hidden" id="y" name="y">
						<input type="hidden" id="w" name="w">
						<input type="hidden" id="h" name="h">
						<input type="button" id="crop_submit" value="Crop Image!">
					</form>
				</div>
			</div>
		</div>
	</div>-->
	<form id="cropimg" name="cropimg" method="post">
		<input type="hidden" id="tId" name="tId">
	</form>
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
				
				<!--<button type="button" class="btn btn-success" data-method="getCroppedCanvas2" data-option="{ 'maxWidth': 4096, 'maxHeight': 4096 }">
				<span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper('getCroppedCanvas', { maxWidth: 4096, maxHeight: 4096 })">
				  Get Cropped Canvas
				</span>
			  </button>-->
				
				<button type="button" id="save_changes" class="btn btn-primary" data-method="getCroppedCanvas">Save changes</button>
			
				
			  </div>  
			  <img src="" id="croped_image"/>
    
            <!--<div class="btn-group">
              <button type="button" class="btn btn-primary" data-method="disable" title="Disable">
                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;disable&quot;)">
                  <span class="fa fa-lock"></span>
                </span>
              </button>
              <button type="button" class="btn btn-primary" data-method="enable" title="Enable">
                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;enable&quot;)">
                  <span class="fa fa-unlock"></span>
                </span>
              </button>
            </div>
    
            <div class="btn-group">
              <button type="button" class="btn btn-primary" data-method="reset" title="Reset">
                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;reset&quot;)">
                  <span class="fa fa-refresh"></span>
                </span>
              </button>
              <label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
                <input type="file" class="sr-only" id="inputImage" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Import image with Blob URLs">
                  <span class="fa fa-upload"></span>
                </span>
              </label>
              <button type="button" class="btn btn-primary" data-method="destroy" title="Destroy">
                <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;destroy&quot;)">
                  <span class="fa fa-power-off"></span>
                </span>
              </button>
            </div>-->
    

    
           
           <!-- <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="getCroppedCanvasTitle">Cropped</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body"></div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close" data-dismiss="modal">Close</button>
                    <a class="btn btn-primary" id="download" href="javascript:void(0);" download="cropped.jpg">Download</a>
                  </div>
                </div>
              </div>
            </div>-->
    
            
            <!--<textarea type="text" class="form-control" id="putData" rows="1" placeholder="Get data to here or set data with this value"></textarea>-->
          </div><!-- /.docs-buttons -->
    
          
    
           
    
            <div class="dropdown dropup docs-options">
             
            
			  
			
			  
			  
		  
		  
            </div><!-- /.dropdown -->
    
           
    
          </div><!-- /.docs-toggles -->
			<!-- end crop section body part -->
			
		  </div>
		  
		</div>
	  </div>
	</div>
	<!-- end image crop dialog -->
	 
</div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  
<script>
var jcrop_api,boundx,boundy,
$preview = $('#preview-pane'),
$pcnt = $('#preview-pane .preview-container'),
$pimg = $('#preview-pane .preview-container img'),
xsize = $pcnt.width(),
ysize = $pcnt.height();

$(document).ready(function(){
	var bfw = "<?php echo $calendar_frame_width;?>";
	var bfh = "<?php echo $calendar_frame_height;?>";
	$('.imageContent').each(function() { 
		$(this).css('width',bfw+'%');
		//$(this).css('height',bfh+'%');
		$(this).css('margin','0 auto');
		$(this).css('border','2px dotted #ccc');
		$(this).css('border-radius','2px');
		$(this).css('float','left');
		$(this).css('padding','10px');
	});
});
function allowDrop(ev){
    ev.preventDefault();
}
function drag(ev){
	ev.dataTransfer.setData("text", ev.target.id);
	$('.canvas-container').css('height','0px');
	$('.lower-canvas').css('height','0px');
	$('.upper-canvas').css('height','0px');
}
function drop(ev){
    ev.preventDefault();
	data = ev.dataTransfer.getData("text");
	var src = document.getElementById(data).src;
	var nodeCopy = document.getElementById(data).cloneNode(true);
	nodeCopy.id = "newId_"+data;	
	
	$('#image2').attr('src', src);
	/* image crop */
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
									subparent.style.cssText = 'background-image: url("'+src2+'");background-size:100% 100%;';
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
	/* $("#crop_dialog").dialog({
		autoOpen  : false,
		width     : 1000,
		height	  : 650,
		modal     : false,
		resizable : false,
		close     : function (event, ui) { $(this).dialog('destroy'); }
	}).dialog('open');
	
	$(".jc-demo-box .target").attr('src',src);
	$(".jcrop-preview").attr('src',src);
	$(".jcrop-holder img").attr('src',src);
	$('#crop_dialog').parent().addClass('for_crop');
	$('#tId').val(tId);
	
	jcrop_api = $.Jcrop('#target', {
		onChange: updatePreview,
		onSelect: updatePreview,
		bgOpacity: 0.5,
		aspectRatio: xsize / ysize,
		setSelect: [0, 0, 200, 200],
		boxWidth: 350, 
		boxHeight: 350
	},function(){
		var bounds = this.getBounds();
		boundx = bounds[0];
		boundy = bounds[1];
		jcrop_api = this; 
		$preview.appendTo(jcrop_api.ui.holder);
	}); 
	$('.jcrop-holder').each(function(e){
		if(e>0){
			$(this).remove();
		}
	}); 
	
	$("#crop_submit").on('click',function(event){
		event.preventDefault();
		var form = $("#cropimg");
		var base_path = "<?php echo config('app.url');?>";
		var x = $('#x').val();
		var y = $('#y').val();
		var w = $('#w').val();
		var h = $('#h').val();
		
		if(w < 500 || h < 400){
			toastr.error("Sorry! Crop image low dimension! Please crop more wide area...!");
			return false;
		}else{
			var imgsrc = $('#target').attr('src');
			var tw = $('#target').width();
			var th = $('#target').height();
			var tId = $('#tId').val();
			if(x == ''){
				toastr.error("Sorry! Please select a crop area!!");
			}
			$.ajaxSetup({ 
				headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} 
			});
			$.ajax({
				url : base_path + 'calendars/crop_image',            
				type : 'POST',
				data : {imgsrc:imgsrc,x:x,y:y,w:w,h:h,tw:tw,th:th},
				success : function(data){
					src2 = base_path+data;
					$('#'+tId+' .bg-img').remove();	
					var parentdv = document.createElement("div");
					parentdv.className = "bg-img";
					var subparent = document.createElement("div");
					subparent.className = "bg-img-inner";
					subparent.style.cssText = 'background-image: url("'+src2+'");background-size:100% 100%;';
					parentdv.append("", subparent);
					$('#'+tId).append(parentdv);
					$(form).get(0).reset();
					$("#crop_dialog").dialog('close').dialog('destroy');
					jcrop_api.destroy();
				}
			});
			return false;
		}
	});
	$('.for_crop .ui-dialog-titlebar-close').click(function(){
		$('#'+tId+' .bg-img').remove();	
		var parentdv = document.createElement("div");
		parentdv.className = "bg-img";
		var subparent = document.createElement("div");
		subparent.className = "bg-img-inner";
		subparent.onclick = function() { crop(src,tId); };
		subparent.style.cssText = 'background-image: url("'+src+'");background-size:100% 100%;';
		parentdv.append("", subparent);
		$('#'+tId).append(parentdv);
		$(form).get(0).trigger('reset');
		jcrop_api.destroy();
	}); */
	/* end image crop */
	
}
/* function updatePreview(c){
	if (parseInt(c.w) > 0){
		var rx = xsize / c.w;
		var ry = ysize / c.h;
	
		$('#x').val(c.x);
		$('#y').val(c.y);
		$('#w').val(c.w);
		$('#h').val(c.h);

		$pimg.css({
			width: Math.round(rx * boundx) + 'px',
			height: Math.round(ry * boundy) + 'px',
			marginLeft: '-' + Math.round(rx * c.x) + 'px',
			marginTop: '-' + Math.round(ry * c.y) + 'px'
		});
	}
} */
</script>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


<script>
if (top !== self) {
	$.ui.dialog.prototype._focusTabbable = $.noop;
}
$(document).ready(function() {
	
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
			$(".poster_layout .imageContent .rowHeight").html(page_content);
			$(".poster_layout .imageContent .rowHeight").addClass('custom_layout');
			$(".poster_layout .imageContent .rowHeight .dropable").each(function(){
				$(this).attr('id',Math.random().toString(36).substr(2, 9));
			}); 
			swal("Good job!", "Layout Set Successfully!!", "success");
		}else if(alt == 'background'){
			var imgSrc = $(this).attr('src');
			$(".poster_layout .imageContent").css("background-image","url('"+imgSrc+"')");
			swal("Good job!", "Background Set Successfully!!", "success");
		}
	});
	/** end layout append into photo-book slide **/
	
	/** background color append on display layout **/
	$('.colorFlex').click(function(){
		$(".poster_layout .imageContent .rowHeight").css('background-image','');
		var bg = $(this).attr('rel');
		$(".poster_layout .imageContent").css("background",bg);
		swal("Good job!", "Background Color Set Successfully!!", "success");
	});
	/** end background color append on display layout **/
	
	/** save project if not saved **/
	$('#proj').click(function(){
		var base_path = "<?php echo config('app.url');?>";
		var formData = $('#proj_form').serialize();
		var year = "<?php echo $year;?>";
		var month = 0;
		var projV = $('#proj_form input[name=project_name]').val();
		if(projV){
			$.ajaxSetup({ 
				headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} 
			});
			$.ajax({
				url : base_path + 'calendars/save_project',            
				type : 'POST',
				data : {form_data:formData,flag:'College Poster',cmonth:month,cyear:year},
				beforeSend: function(){
					//toastr.success("Please Wait...! Loading Data...!");
					swal("Please Wait...!", "Loading Data...!", "warning");
				},
				success : function(data){
					if(data=='error'){
						//toastr.error("Sorry! Project not create! Please try again...!");
						swal("Oops!", "Project not create! Please try again...!", "error");
					}else{
						$('#project_id').val(data);
						$('.ui-dialog-titlebar-close').trigger('click');
						//toastr.success("Thanks! Project created successfully! Now save your project!");
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
		var optionHtml = $(".eidtor-right-area .poster_layout").html();
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
				//toastr.error("Sorry! Please drag image first!!");
				swal("Oops!", "Please drag image first...!", "error");
			}else{
				$.ajaxSetup({ 
					headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} 
				});
				$.ajax({
					url : base_path+'calendars/save_poster',            
					type : 'POST',
					data : {page_content:optionHtml,project_id:project_id,_token:$('meta[name="_token"]').attr('content')},
					beforeSend: function(){
						//toastr.success("Please Wait...! Saving Project Data!");
						swal("Please Wait...!", "Saving Project Data...!", "warning");
					},
					success : function(data){
						if(data=='saved'){
							swal("Thanks!", "Project Saved Successfully!!", "success")
							.then((value) => {
								window.location.reload();
							});
							//toastr.success("Thanks! Project Saved Successfully!!");
							/* setTimeout(function(){ 
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
	
	/** for preview photo-book **/
	$('#preview').click(function(e){
		var basePath = "<?php echo env('APP_URL');?>";
		var project_id = $('#project_id').val();
		$.ajax({
			method: 'get',
			url: basePath + 'calendars/get_poster_preview/'+project_id,
			beforeSend: function(){
				//toastr.success("Please Wait...! Loading Project Data!");
				swal("Please Wait...!", "Loading Project Data...!", "warning");
			},
			success: function(data){
				if(data == 'failed'){
					//toastr.error("Sorry! Please save this data first!!");
					swal("Oops!", "Please save this data first...!", "error");
				}else{
					$("#preview_dialog").html(data);
					$("#preview_dialog").dialog({
						width: 1024,
						height: 550,
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
		var project_id = $('#project_id').val();
		var basePath = "<?php echo env('APP_URL');?>";
		$.ajax({
			method: 'get',
			url: basePath+'calendars/get_calendar_status/'+project_id,
			beforeSend: function(){
				//toastr.success("Please Wait...! Saving Data!");
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
		var basePath = "<?php echo env('APP_URL');?>";
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
					//toastr.success("Thanks! Project added Successfully into cart!!");
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
	/* $('#basket').click(function(){
		var basePath = "<?php echo env('APP_URL');?>";
		$.ajax({
            url : basePath+'calendars/shipping_address_status',            
            type : 'GET',
			beforeSend: function(){
				toastr.success("Please Wait...! Loading Page Data!");
			},
			success : function(data){
				if(data == 'exist'){
					window.location.href = basePath+'payments/cart/cp';
				}else{
					$("#shipping_address").dialog({
						width: 1024,
						height: 650,
						modal: true,
						resizable: false,
					});
				}
			}
		});
	}); */
	/** end shipping address dialog **/
});
</script>
<style>
.textcontleft{z-index:10;}
.textEdit{z-index:10;}
.imageContent .main-calendar{
	/* padding-left: 5px;
	padding-right: 5px;
	padding-bottom: 10px; */
}
#drop_event_cpdp {
	padding-right: 0px;
	padding-left: 0px;
}
</style>
<!-- show calendar under calendar layout -->
<script>
/* $('.imageContent .main-calendar').each(function(){
	$(this).css('height','<?php echo $calendar_frame_height-$cal_part_actual_height;?>vh');
}); */

$('.imageContent .rowHeight').each(function(index){
	$(this).css('height','<?php echo $cal_part_actual_height;?>vh');
});

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

function setCal(month,year){
	var now = new Date();
	var year = year;
	var month = month;
	var monthName = getMonthName(month);
	var date = now.getDate();
	now = null;
	var firstDayInstance = new Date(year, month, 1);
	var firstDay = firstDayInstance.getDay();
	firstDayInstance = null;
	var days = getDays(month, year);
	var calElement = drawCal(firstDay + 1, days, date, monthName, year, month);
	return calElement;
}

function setbackground()
{
	var index = Math.round(Math.random() * 12);
	var ColorValue = "FFFFFF"; // default color - white (index = 0)
	if(index == 1)
		ColorValue = "FFCCCC"; //peach
	if(index == 2)
		ColorValue = "CCAFFF"; //violet
	if(index == 3)
		ColorValue = "A6BEFF"; //lt blue
	if(index == 4)
		ColorValue = "99FFFF"; //cyan
	if(index == 5)
		ColorValue = "D5CCBB"; //tan
	if(index == 6)
		ColorValue = "99FF99"; //lt green
	if(index == 7)
		ColorValue = "FFFF99"; //lt yellow
	if(index == 8)
		ColorValue = "FFCC99"; //lt orange
	if(index == 9)
		ColorValue = "CCCCCC"; //lt grey
	if(index == 10)
		ColorValue = "99CCCC";
	if(index == 11)
		ColorValue = "D3AFA7";
	if(index == 12)
		ColorValue = "FFFFD7";
	
	return "#" + ColorValue;
}

function drawCal(firstDay, lastDate, date, monthName, year, month){
	var randomColor = setbackground();
	var headerHeight = 10 // height of the table's header cell
	var border = 0 // 3D height of table's border
	var cellspacing = 0 // width of table's border
	var headerColor = "midnightblue" // color of table's header
	var headerSize = "1" // size of tables header font
	var colWidth = 20 // width of columns in table
	var dayCellHeight = 10 // height of cells containing days of the week
	var dayColor = "darkblue" // color of font representing week days
	var cellHeight = 10 // height of cells representing dates in the calendar
	var todayColor = "red" // color specifying today's date in the calendar
	var timeColor = "purple" // color of font representing current time
	var tableAlign = "center";

	// create basic table structure
	if(month==0 || month==4 || month==8){
		var text = "<div class='mainDivFirst' style='width:100%;float:left;'>";
	}else{
		var text = "" // initialize accumulative variable to empty string
	}
	text += '<div class=mainDivSecond style=width:25%;float:left;background-color:'+randomColor+'>'
	text += '<TABLE ALIGN='+tableAlign+' BORDER=' + border + ' CELLSPACING=' + cellspacing + ' style = background-color:'+ randomColor +'>' // table settings
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
	weekDay[0] = "S"
	weekDay[1] = "M"
	weekDay[2] = "T"
	weekDay[3] = "W"
	weekDay[4] = "T"
	weekDay[5] = "F"
	weekDay[6] = "S"

	// create first row of table to set column width and specify week day
	text += '<TR ALIGN="center" VALIGN="center" style="font-size:8px;">'
	for(var dayNum = 0; dayNum < 7; ++dayNum){
		text += openCol + weekDay[dayNum] + closeCol
	}
	text += '</TR>'
	// declaration and initialization of two variables to help with tables
	var digit = 1
	var curCell = 1
	for(var row = 1; row <= Math.ceil((lastDate + firstDay - 1) / 7); ++row){
	//for(var row = 1; row <= 6; ++row){
		text += '<TR ALIGN="center" VALIGN="center">'
		for(var col = 1; col <= 7; ++col){
			if(digit > lastDate)
			break
			if(curCell < firstDay){
				text += '<TD></TD>';
				curCell++
			}else{
				if(digit == date){ // current cell represent today's date
					text += '<TD HEIGHT=' + cellHeight + '>'
					text += digit
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
	text += '</div>'
	if(month==3 || month==7 || month==11){
		text += '</div>'
	}
	// print accumulative HTML string
	return text;
}
</script>
<style>
table {
	font-family: arial;
}

<!-- new css added for poster calendar -->
.imageContent .rowHeight {
	background-color: darkgray;
	margin-left: 0px;
	margin-right: 0px;
	height: 50vh;
}
.navebar-second {
	margin-top: 63px;
}
.colorFlex {
	width: 50px;
	height: 40px;
	border-radius: 5px;
	cursor: pointer;
}
.mainDivSecond{
	height:130px;
}
<!-- end new css added for poster calendar -->

</style>
<!-- end show calendar under calendar layout -->
@endsection