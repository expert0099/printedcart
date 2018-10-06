@extends("layouts.photobookeditor")

@section("main-content")

<?php 
//$book_size = '11x14';
$ex = explode('x',$book_size);
if($ex[0]>$ex[1]){
	$ratio = $ex[1]/$ex[0]*100;
	$book_frame_width = 100;
	$book_frame_height = round($ratio);
}else{
	$ratio = $ex[0]/$ex[1]*100;
	$book_frame_width = round($ratio);
	$book_frame_height = 100;
}
if($book_size == '11x8'){
	$class = 'photobook_size_11x8';
} else {
	$class = '';
}
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
								<a href="#">
									<li label="album_{{$album->id}}" style="background: #eee; padding: 5px; border-radius:5px;  margin-bottom: 3px;"> {{$album->album_name}} </li>
								</a>
								

								<div id="album_{{$album->id}}" style="display: none;">
									@foreach($photos[$album->id] as $photo)
										<img src="{{URL::asset('public/users_upload/'.$photo->user_id.'/'.$photo->name)}}" class="thumbimage" id="drag_{{$photo->id}}" draggable="true" ondragstart="drag(event)"/>
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
							<div id="layout_content_page_hidden_{{$layts['id']}}" style="display:none;">{!! $layts['content_page'] !!} </div>
						@endforeach
					</div>
                </div>
                <!-- Backgroundsn -->
                <div class="bhoechie-tab-content">
                    <div class="second-tab-sec">
						<h3>Backgrounds</h3>
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
		@if($errors->has())
			<div class="alert alert-danger">
			  @foreach ($errors->all() as $error)
				{{ $error }}<br>
			  @endforeach
			</div>
		@endif
		<div class="content">
			<!--<h3>Layout</h3>-->
			
			<!-- content area -->
			
			<div class="book_pages photobook_<?php echo $book_size;?>">
				<ul id="image-gallery" class="gallery list-unstyled cS-hidden <?php echo $class;?>">
					@if(Session::has('CurrentProjectData'))
						@foreach(Session::get('CurrentProjectData') as $key => $page)
							<li id="{{$page->id}}" style="position:relative;">
								{!! $page->page_content !!}
							</li>
						@endforeach
					@else
						<?php 
						$keys = array_keys($demo_content);
						$last = end($keys);
						?>
						@foreach($demo_content as $key => $page)
							<li id="{{$page->id}}" style="position:relative;">
								@if($already_saved_page == 'exist')
								@else
									@if($key==0)
									<div class="page_count" style="text-align:center;">Front Cover</div>
									@elseif($key == $last)
									<div class="page_count" style="text-align:center;">Back Cover</div>
									@else
									<div class="page_count" style="text-align:center;">{{$key}}</div>	
									@endif
								@endif
								{!! $page->page_content !!}
							</li>
						@endforeach
					@endif
				</ul>
			</div>
			
			<!-- end content area -->
			<input type="hidden" id="project_id" name="project_id" value="{{$project_id}}"/>
			<!--<button class="btn btn-success" id="save_pages">Save Project</button>-->
					
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
	
	<!-- image crop dialog -->
	<div id="crop_dialog" title="Printed Cart : Crop Image" style="display:none;">
		<link rel="stylesheet" type="text/css" href="{{URL::asset('public/css/crop/styles.css')}}">
		<link rel="stylesheet" type="text/css" href="{{URL::asset('public/css/crop/jquery.Jcrop.css')}}">
		<script type="text/javascript" src="{{URL::asset('public/js/crop/jquery.Jcrop.js')}}"></script>
		<div id="wrapper">
			<div class="jc-demo-box">
				<img src="{{URL::asset('public/images/cropimg.jpg')}}" id="target" class="target" alt="Default Image" />
				<div id="form-container">
					<form id="cropimg" name="cropimg" method="post">
						<input type="hidden" id="tId" name="tId">
						<input type="hidden" id="tIddata" name="tIddata">
						<input type="hidden" id="x" name="x">
						<input type="hidden" id="y" name="y">
						<input type="hidden" id="w" name="w">
						<input type="hidden" id="h" name="h">
						<input type="button" id="crop_submit" value="Crop Image!">
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- end image crop dialog -->
	
</div>
<script src="{{URL::asset('public/js/undo_redo/JSYG.Events.js')}}"></script>
<script src="{{URL::asset('public/js/undo_redo/JSYG.StdConstruct.js')}}"></script>
<script src="{{URL::asset('public/js/undo_redo/JSYG.UndoRedo.js')}}"></script>
<script>
var basePath = "<?php echo env('APP_URL');?>";
<!-- for undo and redu -->
var undoRedo = new UndoRedo('#image-gallery',{});
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
var jcrop_api,boundx,boundy,
$preview = $('#preview-pane'),
$pcnt = $('#preview-pane .preview-container'),
$pimg = $('#preview-pane .preview-container img'),
xsize = $pcnt.width(),
ysize = $pcnt.height();

$(document).ready(function(){
	var bfw = "<?php echo $book_frame_width;?>";
	var bfh = "<?php echo $book_frame_height;?>";
	$('.imageContent').each(function(){ 
		$(this).css('width',bfw+'%');
		$(this).css('height',bfh+'%');
		$(this).css('margin','0 auto');
		$(this).css('border','2px dotted #ccc');
		$(this).css('border-radius','2px');
		//$(this).css('float','left');
		$(this).css('padding','10px');
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
//alert('width'+xsize);
//alert('height'+ysize);
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
	data = ev.dataTransfer.getData("text");
	var src = document.getElementById(data).src;
	var nodeCopy = document.getElementById(data).cloneNode(true);
	nodeCopy.id = "newId_"+data;	
	
	/* image crop */
	if(ev.target.id == ""){
		$('.jcrop-holder img').attr('src', src);
		var tId = ev.target.parentNode.parentNode.id;
		if(tId == ""){
			var tId = ev.target.parentNode.id;
		}
		$('#cropimg #tId').val(tId);
		$('#cropimg #tIddata').val(data);
	}else{
		var tId = ev.target.id;
		$('#cropimg #tId').val(tId);
		$('#cropimg #tIddata').val(data);
	}
	
	$("#crop_dialog").dialog({
		autoOpen  : false,
		width     : 1300,
		height	  : 850,
		modal     : false,
		resizable : true,
		draggable : true,
		close     : function (event, ui) {  $(this).dialog("close");  }
	}).dialog('open');
	
	$(".jc-demo-box .target").attr('src',src);
	$(".jcrop-preview").attr('src',src);
	$(".jcrop-holder img").attr('src',src);
	$('#crop_dialog').parent().addClass('for_crop');
	
	//$.noConflict(true);
	jcrop_api = $.Jcrop('#target', {
		onChange: updatePreview,
		onSelect: updatePreview,
		bgOpacity: 0.5,
		aspectRatio: 1,
		setSelect: [0, 0, 200, 200]
		//boxWidth: 350, 
		//boxHeight: 350 
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
	
	var form = $("#cropimg");
	$("#crop_submit").on('click',function(event){
		event.preventDefault();
		
		var base_path = "<?php echo config('app.url');?>";
		var x = $('#x').val();
		var y = $('#y').val();
		var w = $('#w').val();
		var h = $('#h').val();
		
		if(w < 500 || h < 400){
			toastr.error("Sorry! Crop image low dimention! Please crop more wide area...!");
			return false;
		}else{
			var imgsrc = $('#target').attr('src');
			var tw = $('#target').width();
			var th = $('#target').height();
			
			var ttId = $('#tId').val();
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
					$('#image-gallery #'+ttId+' .bg-img').remove();	
					$('#image-gallery #'+ttId+' .textinside').hide();
					var parentdv = document.createElement("div");
					parentdv.className = "bg-img";
					var subparent = document.createElement("div");
					subparent.className = "bg-img-inner";
					subparent.style.cssText = 'background: url("'+src2+'");background-size:100% 100%;';
					parentdv.append("", subparent);
					$('#image-gallery #'+ttId).append(parentdv);
					$(form).get(0).reset();
					$("#crop_dialog").dialog('close').dialog('destroy');
					undoRedo.saveState();
				}
			});
			return false;
			//background-size:100% 100%;
		}
	});
	$('.for_crop .ui-dialog-titlebar-close').click(function(){
		var ttId = $('#cropimg #tId').val();
		var tIddata = $('#cropimg #tIddata').val();
		var src2 = document.getElementById(tIddata).src;
		$('#image-gallery #'+ttId+' .bg-img').remove();	
		$('#image-gallery #'+ttId+' .textinside').hide();
		var parentdv = document.createElement("div");
		parentdv.className = "bg-img";
		var subparent = document.createElement("div");
		subparent.className = "bg-img-inner";
		subparent.style.cssText = 'background: url("'+src2+'");background-size:100% 100%;';
		parentdv.append("", subparent);
		$('#image-gallery #'+ttId).append(parentdv);
		$(form).get(0).reset();
		undoRedo.saveState();
	});
	/* end image crop */
	
}

function updatePreview(c) {
	if (parseInt(c.w) > 0) {
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
} 
function loadjcrop(){
	//alert('Jcrop');
	jcrop_api = $.Jcrop('#target', {
		onChange: updatePreview,
		onSelect: updatePreview,
		bgOpacity: 0.5,
		aspectRatio: xsize / ysize
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
}

</script>
<link rel="stylesheet" href="{{URL::asset('public/css/lightslider.css')}}"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="{{URL::asset('public/js/lightslider.js')}}"></script> 

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
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
$(document).ready(function() {
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
		$('.img-fluid').each(function(){
			$(this).removeClass('active');
		});
		$(this).addClass('active');
		var id = $(this).attr('id');
		var alt = $(this).attr('alt');
		if(alt == 'layout'){
			var page_content = $("#"+alt+"_content_page_hidden_"+id).html();
			$("#image-gallery li.active .page_content").html(page_content);
			$("#image-gallery li.active .page_content").addClass('custom_layout');
			$("#image-gallery li.active .page_content .dropable").each(function(){
				$(this).attr('id',Math.random().toString(36).substr(2, 9));
			}); 
		}else if(alt == 'background'){
			var imgSrc = $(this).attr('src');
			$("#image-gallery li.active .imageContent").css("background-image","url('"+imgSrc+"')");
		}
	});
	/** end layout append into photo-book slide **/
	
	/** background append into photo-book slide **/
	$('.colorFlex').click(function(){
		$("#image-gallery li.active .imageContent").css('background-image','');
		var bg = $(this).attr('rel');
		$("#image-gallery li.active .imageContent").css("background-color",bg);
	});
	/** end background append into photo-book slide **/
	
	/** add more pages into book slider **/
	$('#addmore_page, #addmore_page2').click(function(){
		var base_path = "<?php echo config('app.url');?>";
		var w = "<?php echo $book_frame_width;?>";
		var h = "<?php echo $book_frame_height;?>";
		$.ajax({
            url : base_path+'photobooks/addmore_page/'+w+'/'+h,            
            type : 'GET',
            success : function(data){
				var page_data = '<li class="lslide" style="width: 480px; margin-right: 0px;">'+data+'</li>';
				$("#image-gallery li.active").after(page_data);
				layoutAttrAfterAppend();
            }
        });
		return false;
	});
	/** end add more pages into book slider **/
	
	/** save pages into project **/
	$('#save_pages').click(function(){
		var base_path = "<?php echo config('app.url');?>";
		var optionHtml = [];
		$("#image-gallery li").each(function(){ 
			optionHtml.push($(this).html());
		}); 
		var project_id = $('#project_id').val();
		var counter = 0;
		$('.bg-img-inner').each(function(){
			if($(this).length > 0){
				counter++;
			}
		});
		if(counter == 0){
			//alert('Please drag image first');
			toastr.error("Sorry! Please drag image first!!");
		}else{
			$.ajaxSetup({ 
				headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') } 
			});
			$.ajax({
				url : base_path+'photobooks/save_photobook',            
				type : 'POST',
				data : {page_content:optionHtml,project_id:project_id,_token:$('meta[name="_token"]').attr('content')},
				success : function(data){
					if(data=='saved'){
						//alert('Project Saved!!');		
						toastr.success("Thanks! Project Saved Successfully!!");
					}
				}
			});
			return false;
		}
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
			height: 350,
			modal: true,
			resizable: false,
			open: function() {
				new nicEditor({
					fullPanel: true,
					iconsPath: 'https://cdn.jsdelivr.net/nicedit/0.9r24/nicEditorIcons.gif'
				}).panelInstance('editorInDialog');
			}
		});
		$("#nicEdit_dialog").parent().addClass('customNicEdit');
		$('#nicEdit_dialog .nicEdit-main').css('width','100%');
		$('div#nicEdit_dialog').on('dialogclose', function(event){
			var nicHtml = $('#nicEdit_dialog .nicEdit-main').html();
			var nicEId = $("#gettypeid").val();
			if(nicHtml=='<br>'){
				//$('#'+nicEId).html('Click Here to add content');
			}else{
				$('#'+nicEId).html(nicHtml);
			}
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
		});
	});
	/** end nicEdit **/
	
	/** for preview photo-book **/
	$('#preview').click(function(){
		//var loading = "{{URL::asset('public/images/loading_spinner.gif')}}";
		var classBook = "<?php echo $class;?>";
		var project_id = $('#project_id').val();
		$.ajax({
			method: 'get',
			url: 'get_photobook_preview/'+project_id,
			//beforeSend: function(){$("#loading" ).html('<img src="'+loading+'"> <br>loading...');},
			success: function(data){
				if(data == 'failed'){
					//alert('Please save this project data first.');
					toastr.error("Sorry! Please save this project data first!!");
				}else{
					$("#preview_dialog").html(data);
					$("#image-gallery2").addClass(classBook);
					$("#preview_dialog").dialog({
						width: 1024,
						height: 550,
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
		var basePath = "<?php echo env('APP_URL');?>";
		var project_id = $('#project_id').val();
		$.ajax({
			method: 'get',
			url: basePath+'photobooks/get_photobook_status/'+project_id,
			success: function(data){
				if(data == 'failed'){
					//alert('Please save this project data first.');
					toastr.error("Sorry! Please save this project data first!!");
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
		var basePath = "<?php echo env('APP_URL');?>";
		var project_id = $('#project_id').val();
		$.ajaxSetup({ 
			headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') } 
		});
		$.ajax({
            url : basePath+'photobooks/add_to_cart',            
            type : 'POST',
			data : {project_id:project_id,_token:$('meta[name="_token"]').attr('content')},
            success : function(data){
				if(data.status == 'added'){
					var item_count = data.item_count;
					$('#cart_count').html(item_count);
					//alert('Project added into cart!!');
					toastr.success("Thanks! Project added successfully into cart!!");
				}else{
					//alert('Already Added into cart!!!');
					toastr.error("Sorry! Already added into cart!!");
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
            url : basePath+'photobooks/shipping_address_status',            
            type : 'GET',
			success : function(data){
				if(data == 'exist'){
					window.location.href = basePath+'payments/cart/pb';
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
	}); */
	/** end shipping address dialog **/
	
	$('.fa-search-plus').on('click',function(){
		var currentScale = parseFloat($(this).attr('data-scale'));
		var scale = currentScale + parseFloat(0.1);
		$(this).attr('data-scale', scale);
		$('.book_pages .lSSlideOuter').css({'-webkit-transform': 'scale('+ scale +')'});
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
					$('.book_pages .lSSlideOuter').width(currentSW+parseInt(10));
					$(this).attr('s', currentSW+parseInt(10));
				}else{
					var CPL = currentPL + parseInt(20);
					$('.book_pages .lSSlideOuter').width(currentSW+parseInt(20));
					$(this).attr('s', currentSW+parseInt(20));
				}
			}else{
				var CPL = currentPL + parseInt(30);
				$('.book_pages .lSSlideOuter').width(currentSW+parseInt(30));
				$(this).attr('s', currentSW+parseInt(30));
			}
		}else{
			var CPL = currentPL + parseInt(40);
			$('.book_pages .lSSlideOuter').width(currentSW+parseInt(40));
			$(this).attr('s', currentSW+parseInt(40));
		}
		$('.book_pages .lSSlideOuter').css({'padding-top':CPT+'px'});
		$('.book_pages .lSSlideOuter').css({'padding-left':CPL+'px'});
		$(this).attr('rel', CPT);
		$(this).attr('p', CPL);
	});
	$('.fa-search-minus').on('click',function(){
		$('.fa-search-plus').attr('data-scale', 1);
		$('.fa-search-plus').attr('rel', 0);
		$('.fa-search-plus').attr('p', 0);
		$('.book_pages .lSSlideOuter').removeAttr('style');
	});
});
</script>

<!-- include js for undo-redo -->
<!--<script src="{{URL::asset('public/js/undo_redo/jquery.js')}}"></script>
<script src="{{URL::asset('public/js/undo_redo/jquery.hotkeys.js')}}"></script>

<script src="{{URL::asset('public/js/undo_redo/JSYG.Events.js')}}"></script>
<script src="{{URL::asset('public/js/undo_redo/JSYG.StdConstruct.js')}}"></script>
<script src="{{URL::asset('public/js/undo_redo/JSYG.UndoRedo.js')}}"></script>-->
<!-- end include js for undo-redo -->
<script>
<!-- for undo and redu -->
/* var undoRedo = new UndoRedo('#image-gallery',{});
$(document).ready(function(){
	$('#undo').on("click",function(){
		undoRedo.undo();
	});
	$('#redo').on("click",function() {
		undoRedo.redo();
	});
}); */ 
</script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>-->
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.6.6/fabric.min.js"></script>
<script>

$(function(){
	
    $('#addText').click(function(){
		var id = $('#image-gallery li.active').attr('id');
		var data_attr = $(this).attr('data-canvas');
		if ((typeof data_attr !== typeof undefined && data_attr !== false) && $(this).attr('data-canvas') == id ) {
		 
		}
		else{
			var html = $('#image-gallery li.active').html();
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
		canvas.observe('object:modified', function(){
			save_history();
		});
		canvas.on('object:moving', function (e){
			save_history();
		}); 
		canvas.add(txt);
        txt.center();
        txt.setCoords();
		canvas.calcOffset();
		canvas.renderAll();
		console.log(canvas.toSVG());
	}); 
  
}); 
</script>-->
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
	z-index:-1;
}
#wrapper {
    width: 100%;
    text-align: center;
    margin: 0 auto;
}
#image-gallery.photobook_size_11x8 {
    height: 350px !important;
}
#image-gallery2.photobook_size_11x8 {
    height: 333px !important;
}
</style>
@endsection