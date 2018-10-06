@extends("layouts.home")

@section("main-content")



<div class="container">

	<?php /*@include('pages.myphoto_banner')*/?>
	
	<!-- Calander Page Info Start -->
	<section class="clander-page-info mt-5 mb-3">
		<div class="row">
			<div class="col-12">
			
			<script>
			var errors_massage = [];
			</script>
				@if(session('message'))
					<?php 
					$response = session('message');
					?>
					@if(isset($response['success']) && !empty($response['success']))
						<script>
						var success = "<?php echo $response['success'];?>";
						var success_msg = '<p class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">×</span></button>'+success+'</p>';
						errors_massage.push(success_msg);
						</script>
					@endif
					@if(isset($response['error']) && !empty($response['error']))
						<script>
						var m_error = "<?php echo $response['err_msg'];?>";
						var m_error_msg = '<p class="alert alert-danger"><a href="#" onclick="show_error()" class="show_error" style="color:#721c24;">'+m_error+'</a></p>';
						errors_massage.push(m_error_msg);
						
						var error_info = '<div class="show_error_info alert alert-danger" style="display:none;"><span onclick="hide_error()" style="cursor:pointer;position:absolute;right:5px;top:5px;">X</span>';
						</script>
						@foreach($response['error'] as $k => $error)
							<script>
							var error = "<?php echo $error;?>";
							error_info += '<p class="alert alert-danger">'+error+'</p>';
							</script>
						@endforeach
						<script>
						error_info += "</div>";
						errors_massage.push(error_info);
						</script>
					@endif
									
					@if(session('photo_id'))
						<script>
						$(function(){
							var photo_id = "<?php echo session('photo_id');?>";
							$("#photo_id").val(photo_id);
							$('#editPhotoDialog .row').before(errors_massage);
							$("#editPhotoDialog").dialog( "open" );
						});
						</script>
					@else
						<script>
						$(function(){
							$('#addPhotoDialog .row').before(errors_massage);
							$("#addPhotoDialog").dialog( "open" );
						});
						</script>
					@endif
					
				@endif
				
				@if(session('success_msg'))
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">×</span></button>
						{{ session('success_msg') }}
					</div>
				@endif
				
							
				@foreach($album_photos as $k => $value)
				
				<!-- my photo content -->
				<div class="content-body">
					<h5>{{$value['album_name']}}</h5>
					<div class="grid">
						<div class="cap-mid">
							<div class="u-1">
								<div class="grid-content">
									<div id="addAlbumBtn">
										<div class="actions center">
											<!--<a id="addalbum" class="btn btn-primary main" href="javascript:void(0)">Add Album</a>-->
											<div id="btnPopover" class="btn btn-primary main" data-hasqtip="18" aria-describedby="qtip-18">
												<span class="photos-ico"></span>Add Photos
												<div class="sweettooth-tab"></div>
											</div>
											<!--<a id="sharephotos" class="btn sec" href="">Share Photos</a>-->
										</div>
									</div>        
								</div>
							</div>
							<h6 class="text-blue"><a href="{{URL::asset('user/my_photos')}}" style="text-decoration:underline;">Back to My Photos</a> : {{ count($value['UserUpload']) }} Photos</h6>
							<div class="row">
						
								@if(count($value['UserUpload'])>0)
								@foreach($value['UserUpload'] as $k => $val)
								
								<div class="albumBack col-sm-6 col-md-3" id="{{$value->id}}" style="padding-top:15px; padding-bottom:15px;">
									<table class="albumtable" style="padding:0px 0px 5px 0px" cellspacing="0" cellpadding="0" border="0">
										<tbody>
											<tr>
												<td class="albumcell">
													<div class="albumlink position-relative">
														<!--<div style="margin-right:-120px;margin-top:-28px;">-->
														<div class="update_btns">
														<a rel="{{$value->album_name}}" p="{{URL::asset('user/del_photo/'.$val['id'])}}" class="delAlb" href="javascript:void(0)" style="color: red;font-size: 20px;padding-left: 8px;padding-right: 8px;padding-top: 0px;padding-bottom: 0px;margin-left: 115px;" title="Delete" alt="Delete">X</a><!--<i class="fa fa-trash" aria-hidden="true" style="color:red;font-size:25px;"></i></div>-->
														<a href="javascript:void(0)" title="Edit" alt="Edit"><i class="fa fa-edit editPhoto" aria-hidden="true" style="color:##0069d9;font-size: 30px;margin-bottom:-30px;float:right;margin-right:30px;" rel="{{$val['id']}}"></i></a>
														</div>
														<img src="{{ URL::asset('public/'.$val['path'].'/'.$val['name']) }}" style="vertical-align:middle;text-align:center;border-radius: 10px" alt="Click to enter album" class="fancybox coverImage">
														<!--<a href="{{URL::asset('user/del_photo/'.$val['id'])}}" onclick="return ConfirmDelete()"><div class="img-icon"><i class="fa fa-trash-o" aria-hidden="true"></i></div></a>-->
														
														
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								@endforeach
								@else
									<hr style="width:100%;"/>
									<div style="color:red;text-align:center; min-height:300px;width:100%;">Album is empty. Add photos!</div>
								@endif
							</div>
						</div>
					</div>
				</div>
				<!-- end my photo content -->
				@endforeach
			
			</div>
		</div>
	</section>
	<!-- Calander Page Info End -->

	<!-- model -->
	<!--<div id="addAlbumDialog" title="Add Album">
		{!! Form::open(['method' => 'POST', 'url' => ['user/add_album']]) !!}
			<div class="row">
				<div class="col-sm-12 form-group">
					{!! Form::label('album_name', 'Album Name', ['class' => 'control-label']) !!}
					{!! Form::text('album_name', old('album_name'), ['class' => 'form-control', 'placeholder' => 'Album Name', 'required'=>'true']) !!}
				</div>
			</div>
			{!! Form::submit('ADD', ['class' => 'btn btn-success']) !!}
		{!! Form::close() !!}
	</div>-->
	
	<div id="addPhotoDialog" title="Add Photo" style="display:none;">
		{!! Form::open(['method' => 'POST', 'url' => ['user/add_photo'],'enctype'=>'multipart/form-data']) !!}
			<div class="row">
				<!--<div><b>Accepted file types:</b> JPEG, PNG, JPG, GIF</div>
				<div><b>Maximum file size:</b> 10MB</div>
				<div><b>Minimum photo dimensions:</b> 600px width x 500px height</div>
				<hr style="width:100%;"/>-->
				<!--<div class="col-sm-12 form-group">
					{!! Form::label('album_name', 'Album Name', ['class' => 'control-label']) !!}
					{!! Form::select('album_id', $album, ['class' => 'form-control', 'required'=>'true']) !!}
				</div>-->
				{!! Form::hidden('album_id',$album_id) !!}
				<div class="col-sm-12 form-group" style="text-align:left;">
					{!! Form::label('photo', 'Image (attach one or more photos)', ['class' => 'control-label']) !!}
					{!! Form::file('images[]', ['class' => 'form-control', 'multiple'=>'true', 'required'=>'true','id'=>'bulk_img']) !!}
				</div>
			</div>
			{!! Form::submit('Upload', ['id'=>'addPhotoDialogId','class' => 'btn btn-primary']) !!}
		{!! Form::close() !!}
	</div>
	
	<div id="editPhotoDialog" title="Edit Photo" style="display:none;">
		{!! Form::open(['method' => 'POST', 'url' => ['user/edit_photo'],'enctype'=>'multipart/form-data']) !!}
			<div class="row">
				<!--<div><b>Accepted file types:</b> JPEG, PNG, JPG, GIF</div>
				<div><b>Maximum file size:</b> 10MB</div>
				<div><b>Minimum photo dimensions:</b> 600px width x 500px height</div>
				<hr style="width:100%;"/>-->
				<!--<div class="col-sm-12 form-group">
					{!! Form::label('album_name', 'Album Name', ['class' => 'control-label']) !!}
					{!! Form::select('album_id', $album, ['class' => 'form-control', 'required'=>'true']) !!}
				</div>-->
				<input type="hidden" name="photo_id" id="photo_id">
				{!! Form::hidden('album_id',$album_id) !!}
				<div class="col-sm-12 form-group" style="text-align:left;">
					{!! Form::label('photo', 'Image (attach one or more photos)', ['class' => 'control-label']) !!}
					{!! Form::file('images', ['class' => 'form-control', 'required'=>'true','id'=>'bulk_img2']) !!}
				</div>
			</div>
			{!! Form::submit('Upload', ['id'=>'editPhotoDialogId', 'class' => 'btn btn-primary']) !!}
		{!! Form::close() !!}
	</div>
	
	<div id="addPhotoDirection" title="Upload">
		<div class="row">
			<div class="col-sm-12 form-group" style="text-align:center;">
				<span class="btn btn-primary" id="my_computer">My Computer</span>
			</div>
			<div class="col-sm-12 form-group socialSieText">SOCIAL SITES</div>
			<div class="col-sm-4 form-group" style="text-align:left;">
				<a href="{{URL::asset('/user/instagram')}}" class="btn btn-primary socialBtn instaBtn" id="instagram"><i class="fa fa-instagram"></i>Instagram Photos</a>
			</div>
			<div class="col-sm-4 form-group" style="text-align:left;">
				<a href="{{URL::asset('/user/glogin')}}" class="btn btn-primary socialBtn googleBtn" id="google"><i class="fa fa-google"></i>Google Photos</a>
			</div>
			<div class="col-sm-4 form-group" style="text-align:left;">
				<a href="{{URL::asset('/user/facebook/login')}}" class="btn btn-primary socialBtn facebookBtn" id="facebook"><i class="fa fa-facebook"></i>Facebook Photos</a>
			</div>
		</div>
	</div>
	
	<div id="deletePhotoDialog" title="Delete Photo"></div>
	<!-- end model -->
	
</div>
<style>
#addPhotoDirection .socialSieText{padding:15px 0; background: #f5f5f5; font-size:14px;}
#addPhotoDirection .socialBtn{color:#fff;width:100%;}
#addPhotoDirection .socialBtn.instaBtn{background:#275f8e;}
#addPhotoDirection .socialBtn.googleBtn{background:#dc483c;}
#addPhotoDirection .socialBtn.facebookBtn{background:#3a5897;}
#addPhotoDirection .socialBtn i{margin-right:5px;display:inline-block;}
</style>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
function ConfirmDelete(){
	var x = confirm("Are you sure you want to delete?");
	if (x){
		return true;
	}else{
		return false;
	}
}
function show_error(){
	$(".show_error_info").attr("style","display:block");
}
function hide_error(){
	$(".show_error_info").attr("style","display:none");
}
$(function(){
	$( ".delAlb" ).on( "click", function(){
		var album_name = $(this).attr('rel');
		var href = $(this).attr('p');
		var ref = $(this);
	
		var message = "Are you sure you want to delete your photo?"
		$("#deletePhotoDialog").html(message);
		$("#deletePhotoDialog").dialog({
			resizable: false,
			height: "auto",
			width: 400,
			modal: true,
			buttons: {
				"Delete": function(){
					/* var str = album_name;
					var x = confirm("Are you sure you want to delete your photo?");
					if (x){ */
						$("#deletePhotoDialog").dialog( "close" );
						window.location.href = href;
						return true;
					/* }else{
						return false;
					} */
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
		
	});
	
	/* $("#addAlbumDialog").dialog({
		autoOpen: false,
		width: $(window).width() > 500 ? 500 : 'auto',
		height: 'auto',
		fluid: true,
		responsive: true,
		show: {
			//effect: "blind",
			duration: 1000
		},
		hide: {
			//effect: "explode",
			duration: 1000
		}
	});
	$( "#addalbum" ).on( "click", function() {
		$("#addAlbumDialog").dialog( "open" );
	}); */
	
	setTimeout(function() {
        $('.alert-success').fadeOut('fast');
    }, 10000); 
	setTimeout(function(){
        $('.alert-danger').fadeOut('fast');
    }, 50000); 
	
	
	$("#addPhotoDialog").dialog({
		autoOpen: false,
		width: $(window).width() > 500 ? 500 : 'auto',
		height: 'auto',
		fluid: true,
		responsive: true,
		show: {
			//effect: "blind",
			duration: 1000
		},
		hide: {
			//effect: "explode",
			duration: 1000
		}
	});
	$("#addPhotoDirection").dialog({
		autoOpen: false,
		width: $(window).width() > 600 ? 600 : 'auto',
		height: 'auto',
		fluid: true,
		responsive: true,
		show: {
			//effect: "blind",
			duration: 1000
		},
		hide: {
			//effect: "explode",
			duration: 1000
		}
	});
	/* $( "#btnPopover" ).on( "click", function() {
		$("#addPhotoDialog").dialog( "open" );
	}); */
	$( "#btnPopover" ).on( "click", function() {
		$("#addPhotoDirection").dialog( "open" );
	});
	$("#my_computer").on('click', function(){
		$("#addPhotoDialog").dialog( "open" );
		$("#addPhotoDirection").dialog( "close" );
	});
	
	$("#addPhotoDialogId").on('click',function(){
		var files = $('input#bulk_img')[0].files;
		if(files.length < 1){
			swal("Oops!", "Please browse atleast one image...!", "error");
		}else{
			swal("Please Wait...!", "Photo Uploading...!", "warning");
		}
	});
	$("#editPhotoDialogId").on('click',function(){
		var files = $('input#bulk_img2')[0].files;
		if(files.length < 1){
			swal("Oops!", "Please browse atleast one image...!", "error");
		}else{
			swal("Please Wait...!", "Photo Uploading...!", "warning");
		}
	});
	
	$("#editPhotoDialog").dialog({
		autoOpen: false,
		width: $(window).width() > 500 ? 500 : 'auto',
		height: 'auto',
		fluid: true,
		responsive: true,
		show: {
			//effect: "blind",
			duration: 1000
		},
		hide: {
			//effect: "explode",
			duration: 1000
		}
	});
	$(".editPhoto").on("click", function(){
		var rel = $(this).attr('rel');
		$("#photo_id").val(rel);
		$("#editPhotoDialog").dialog("open");
	});
	
});


</script>
<style>
.coverImage {
	height: 144px;
}
</style>

<!-- start fancybox -->
<link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/1.3.4/jquery.fancybox-1.3.4.css" />
<style type="text/css">
a.fancybox img {
	border: none;
	box-shadow: 0 1px 7px rgba(0,0,0,0.6);
	-o-transform: scale(1,1); -ms-transform: scale(1,1); -moz-transform: scale(1,1); -webkit-transform: scale(1,1); transform: scale(1,1); -o-transition: all 0.2s ease-in-out; -ms-transition: all 0.2s ease-in-out; -moz-transition: all 0.2s ease-in-out; -webkit-transition: all 0.2s ease-in-out; transition: all 0.2s ease-in-out;
} 
a.fancybox:hover img {
	position: relative; z-index: 999; -o-transform: scale(1.03,1.03); -ms-transform: scale(1.03,1.03); -moz-transform: scale(1.03,1.03); -webkit-transform: scale(1.03,1.03); transform: scale(1.03,1.03);
}
.ui-dialog .ui-dialog-buttonpane button {
    background-color: #40b3d9 !important;
    color: #fff;
}
.ui-dialog .ui-dialog-buttonpane button:hover {
    background-color: #0062cc !important;
}
</style>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/1.3.4/jquery.fancybox-1.3.4.pack.min.js"></script>
<script type="text/javascript">
$(function($){
	var addToAll = false;
	var gallery = true;
	var titlePosition = 'inside';
	$(addToAll ? 'img' : 'img.fancybox').each(function(){
		var $this = $(this);
		var title = $this.attr('title');
		var src = $this.attr('data-big') || $this.attr('src');
		var a = $('<a href="#" class="fancybox"></a>').attr('href', src).attr('title', title);
		$this.wrap(a);
	});
	if (gallery)
		$('a.fancybox').attr('rel', 'fancyboxgallery');
	$('a.fancybox').fancybox({
		titlePosition: titlePosition
	});
});
$.noConflict();
</script>
<!-- end fancybox -->
@endsection