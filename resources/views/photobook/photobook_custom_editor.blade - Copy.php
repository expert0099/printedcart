@extends("layouts.photobookeditor")

@section("main-content")

<div class="container-fluid px-0 editor-holder">
	<div class="left-sidebar-section">
        <div class="tab-width px-0 left-icon-tab">
            <div class="left-one bhoechie-tab-menu float-left">
				<div class="list-group">
					<a href="#" class="list-group-item active text-center rounded-0"><i class="fa fa-columns fz-30" aria-hidden="true"></i><br/>Photos</a>
					<a href="#" class="list-group-item text-center"><i class="fa fa-columns fz-30" aria-hidden="true"></i><br/>Layout</a>
					<a href="#" class="list-group-item text-center"><i class="fa fa-tint fz-30" aria-hidden="true"></i><br/>Backgrounds</a>
					<!--<a href="#" class="list-group-item text-center"><i class="fa fa-crosshairs fz-30" aria-hidden="true"></i><br/>Embellishments</a>
					<a href="#" class="list-group-item text-center"><i class="fa fa-lightbulb-o fz-30" aria-hidden="true"></i><br/>Idea pages</a> -->
				</div>
            </div>
            <div class="left-second bhoechie-tab float-left">
            	<!-- Photo Albums  -->
            	<div class="bhoechie-tab-content active">
                    <div class="second-tab-sec">
						<h3>Albums</h3>
						<ul id="albumListsLi" style="list-style: none;">
							@foreach($albums as $album)
								<a href="#">
									<li label="album_{{$album->id}}" style="background: #eee; padding: 5px; border-radius:5px;  margin-bottom: 3px;"> {{$album->album_name}} </li>
								</a>
								

								<div id="album_{{$album->id}}" style="display: none;">
									@foreach($photos[$album->id] as $photo)
										<img src="<?=env("APP_URL")?>public/users_upload/{{$photo->user_id}}/{{$photo->name}}" class="thumbimage" id="drag_{{$photo->id}}" draggable="true" ondragstart="drag(event)"/>
									@endforeach
								</div>
								
							@endforeach
						</ul>
						<div id="SelectAlbumPics"></div>
                    </div>
                </div>
                <!-- Layout -->
                <div class="bhoechie-tab-content">
                    <div class="second-tab-sec">
						<h3>Layout</h3>
						@foreach($layout as $k => $layts)
							<img class='img-fluid' id="{{$layts['id']}}" src="{{ URL::asset($layts['layout_image_path']) }}" alt='layout' style='width:23%;'>
							<div id="layout_content_page_hidden_{{$layts['id']}}" style="display:none;">{!! $layts['content_page'] !!} </div>
						@endforeach
						<!-- @foreach($layout_image as $k => $layout)
						<img class='img-fluid' src="{{ URL::asset($layout) }}" alt='background-img' style='width:23%;'>
						@endforeach -->
                    </div>
                </div>
                <!-- Backgroundsn -->
                <div class="bhoechie-tab-content">
                    <div class="second-tab-sec">
						<h3>Backgrounds</h3>
						@foreach($background_image as $k => $v)
							<img class='img-fluid' src="{{ URL::asset($v) }}" alt='background' style='width:23%;'>
						@endforeach
						
						<!-- @foreach($background as $k => $bkg)
							<img class='img-fluid' src="{{ URL::asset($bkg['background_image_path']) }}" alt='background' style='width:23%;'>
							<div id="background_content_page_hidden" style="display:none;">{!! $bkg['content_page'] !!} </div>
						@endforeach -->
						
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
						<!--@foreach($background_image as $k => $bkg)
						<img class='img-fluid' src="{{ URL::asset($bkg) }}" alt='background-img' style='width:23%;'>
						@endforeach-->
                    </div>
                </div>
                <!-- Embellishments -->
                <!--<div class="bhoechie-tab-content">
                    <div class="second-tab-sec">
						<h3>Embellishments</h3>
						@foreach($embellishment as $k => $emb)
							<img class='img-fluid' src="{{ URL::asset($emb['embellishment_image_path']) }}" alt='embellishment' style='width:23%;'>
							<div id="embellishment_content_page_hidden" style="display:none;">{!! $emb['content_page'] !!} </div>
						@endforeach
					</div>
                </div>-->
                <!-- Idea pages -->
                <!--<div class="bhoechie-tab-content">
                    <div class="second-tab-sec">
						<h3>Idea pages</h3>
						@foreach($ideapage as $k => $idpage)
							<img class='img-fluid' src="{{ URL::asset($idpage['ideapage_image_path']) }}" alt='ideapage' style='width:23%;'>
							<div id="ideapage_content_page_hidden" style="display:none;">{!! $idpage['content_page'] !!} </div>
						@endforeach
					</div>
                </div> -->
            </div>
        </div>
	</div>
	<!-- right content area -->
	<div class="eidtor-right-area">
		<div class="content">
			<!--<h3>Layout</h3>-->
			
			<!-- content area -->
			<div class="book_pages">
				<ul id="image-gallery" class="gallery list-unstyled cS-hidden">
					@if(Session::has('CurrentProjectData'))
						@foreach(Session::get('CurrentProjectData') as $key => $page)
							<li id="{{$page->id}}" style="position:relative;">{!! $page->page_content !!}</li>
						@endforeach
					@else
						@foreach($demo_content as $key => $page)
							<li id="{{$page->id}}" style="position:relative;"><span>{!! $page->page_name !!}</span><br>{!! $page->page_content !!}</li>
						@endforeach
					@endif
				</ul>
			</div>
			<!-- end content area -->
			<input type="hidden" id="project_id" name="project_id" value="{{$project_id}}"/>
			<button class="btn btn-success" id="save_pages">Save Project</button>
		</div>
	</div>
	
	<!-- preview dialog -->
	<div id="preview_dialog" title="Printed Cart :: Photo-book Preview" style="display:none;"></div>
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
			<input type="hidden" name="pid" id="pid" value="{{$project_id}}"/>
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
	
</div>

<script>
function allowDrop(ev) {
    ev.preventDefault();
}
function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
    ev.preventDefault();
	$(".textinside").hide();
    var data = ev.dataTransfer.getData("text");
	var nodeCopy = document.getElementById(data).cloneNode(true);
	nodeCopy.id = "newId_"+data; 
	if(ev.target.id == "layoutbox"){
		ev.target.appendChild(nodeCopy);
	}else{
		ev.target.parentNode.appendChild(nodeCopy);
		var image_x = document.getElementById(ev.target.id);
		image_x.remove(image_x);
	}
}
</script>
<link rel="stylesheet" href="{{URL::asset('public/css/lightslider.css')}}"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="{{URL::asset('public/js/lightslider.js')}}"></script> 

<!-- cropzoom -->
<script type="text/javascript" src="{{URL::asset('public/js/jquery-drag-n-drop/jquery.cropzoom.js')}}"></script>
<!-- end cropzoom -->
<link rel="stylesheet" href="{{URL::asset('public/css/photobook_custom_editor.css')}}"/>
<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/redmond/jquery-ui.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
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
<script>
$(document).ready(function() {
	/* $("#content-slider").lightSlider({
		loop:true,
		keyPress:true
	}); */
	$('#image-gallery').lightSlider({
		gallery:true,
		item:2,
		thumbItem:10,
		slideMargin: 0,
		speed:500,
		auto:false,
		loop:true,
		onSliderLoad: function() {
			$('#image-gallery').removeClass('cS-hidden');
		}  
	});
	
	/** layout append into photo-book slide **/
	$('.img-fluid').css('cursor','pointer');
	$('.img-fluid').click(function(){
		var id = $(this).attr('id');
		var alt = $(this).attr('alt');
		if(alt == 'layout'){
			var page_content = $("#"+alt+"_content_page_hidden_"+id).html();
			$("#image-gallery li.active .page_content").html(page_content);
			$("#image-gallery li.active .page_content").addClass('custom_layout');
		}else if(alt == 'background'){
			var imgSrc = $(this).attr('src');
			$("#image-gallery li.active .page_content").css("background-image","url('"+imgSrc+"')");
		}
	});
	/** end layout append into photo-book slide **/
	
	/** background append into photo-book slide **/
	$('.colorFlex').click(function(){
		$("#image-gallery li.active .page_content").css('background-image','');
		var bg = $(this).attr('rel');
		$("#image-gallery li.active .page_content").css("background-color",bg);
	});
	/** end background append into photo-book slide **/
	
	/** add more pages into book slider **/
	$('#addmore_page').click(function(){
		$.ajax({
            url : 'addmore_page',            
            type : 'GET',
            success : function(data){
				var page_data = '<li class="lslide" style="width: 476.5px; margin-right: 0px;">'+data+'</li>';
				$("#image-gallery li.active").after(page_data);
				layoutAttrAfterAppend();
            }
        });
		return false;
	});
	/** end add more pages into book slider **/
	
	/** save pages into project **/
	$('#save_pages').click(function(){
		var optionHtml = [];
		$("#image-gallery li").each(function(){ 
			optionHtml.push($(this).html());
		}); 
		var project_id = $('#project_id').val();
		$.ajaxSetup({ 
			headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') } 
		});
		$.ajax({
            url : 'save_photobook',            
            type : 'POST',
			data : {page_content:optionHtml,project_id:project_id,_token:$('meta[name="_token"]').attr('content')},
            success : function(data){
				if(data=='saved'){
					alert('Project Saved!!');
				}
            }
        });
		return false;
	});
	/** end save pages into project **/
	
	/** nicEdit **/
	$('.book_pages').on('click', '.textcontleft', function(){
		var li_id = $(this).closest('li').attr('id');
		$(this).attr('id','input'+li_id);
		var gettypeid = 'input'+li_id;
		$("#nicEdit_dialog input[name=gettypeid]").val(gettypeid);
		<!-- open nicEdit dialog -->
		$("#nicEdit_dialog").dialog({
			width: 400,
			height: 300,
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
			$('#'+nicEId).html(nicHtml);
		});
		$('#nEdit').on('click',function(){
			var nicHtml = $('#nicEdit_dialog .nicEdit-main').html();
			var nicEId = $("#gettypeid").val();
			$('#'+nicEId).html(nicHtml);
			$('.ui-dialog-titlebar-close').trigger('click');
		});
		
		<!-- end open nicEdit dialog -->
		/* toggleArea1(gettypeid);
		setTimeout(function(){
			$('#'+li_id+' .nicEdit-panel').append('<div class="closeTxtleft" id="cinput'+li_id+'" onclick="removeCinput(\'cinput'+li_id+'\')" title="Save And Close">&nbsp;</div>');
		},2000); */
		
		/* var len = 50;    
		$(".nicEdit-main").keydown(function () {
			if($(".nicEdit-main").html().length>len){
				var string = $('.nicEdit-main').html();
				$('.nicEdit-main').html(string.substring(0, len));
				alert('You reached a limit.');
			}
		}); */ 
	});
	/** end nicEdit **/
	
	/** for zooming **/
	$(".areas").click(function(){
		var getclickid = this.id;
		var zoomcontainer="#zooming";
		var st_op=$(zoomcontainer).css('display');
		if(st_op=="none"){
			$(".zooming").hide();	
			$(zoomcontainer).show();
		}else{
			$(".zooming").hide();
		}
	});
	/** end for zooming **/
		
	/** for preview photo-book **/
	$('#preview').click(function(){
		//var loading = "{{URL::asset('public/images/loading_spinner.gif')}}";
		var project_id = $('#project_id').val();
		$.ajax({
			method: 'get',
			url: 'get_photobook_preview/'+project_id,
			//beforeSend: function(){$("#loading" ).html('<img src="'+loading+'"> <br>loading...');},
			success: function(data){
				if(data == 'failed'){
					alert('Please save this project data first.');
				}else{
					$("#preview_dialog").html(data);
					$("#preview_dialog").dialog({
						width: 1350,
						height: 700,
						modal: true,
						resizable: false,
					});
					$('#preview_dialog').parent().addClass('preview-large');
					preview_dialog(); //preview photo-book slide
				}
			},
			error: function(e) {
				var json = JSON.stringify(e);
			}
		});
	});
	function preview_dialog(){
		
		$('#image-gallery2').lightSlider({
			gallery:true,
			item:2,
			thumbItem:10,
			slideMargin: 0,
			speed:500,
			auto:false,
			loop:true,
			onSliderLoad: function() {
				$('#image-gallery2').removeClass('cS-hidden');
			}  
		});
	}
	/** end for preview photo-book **/
	
	/** add to cart **/
	$('.add-to-cart-nav').click(function(){
		var project_id = $('#project_id').val();
		$.ajax({
			method: 'get',
			url: 'get_photobook_status/'+project_id,
			success: function(data){
				if(data == 'failed'){
					alert('Please save this project data first.');
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
            url : 'add_to_cart',            
            type : 'POST',
			data : {project_id:project_id,_token:$('meta[name="_token"]').attr('content')},
            success : function(data){
				if(data.status == 'added'){
					var item_count = data.item_count;
					$('#cart_count').html(item_count);
					alert('Project added into cart!!');
				}else{
					alert('Already Added into cart!!!');
				}
            }
        });
		return false;
	}
	/** end add to cart **/
	/** shipping address dialog **/
	$('#basket').click(function(){
		var basePath = "<?php echo env('APP_URL');?>";
		var project_id = $('#project_id').val();
		$.ajax({
            url : 'shipping_address_status',            
            type : 'GET',
			success : function(data){
				if(data == 'exist'){
					window.location.href = basePath+'payments/cart/'+project_id;
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
});
</script>
@endsection