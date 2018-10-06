@extends("layouts.home")

@section("main-content")

<div class="container">

	<?php /* @include('pages.myphoto_banner') */?>

	<!-- Calander Page Info Start -->
	<section class="clander-page-info pt-5 mt-5 mb-3 myPhotoSection">
		<div class="row">
			<div class="col-12">
				<h5 class="text-blue">My Photos</h5>
				
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
									
					<script>
					$(function(){
						$('#addPhotoDialog .row').before(errors_massage);
						$("#addPhotoDialog").dialog( "open" );
					});
					</script>
										
				@endif
				
				<!-- my photo content -->
				<div class="content-body">
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
					@endif
					@if(session('error_msg'))
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">×</span></button>
							{{ session('error_msg') }}
						</div>
					@endif
					<div class="grid">
						<div class="cap-mid">
							<div class="u-1">
								<div class="grid-content">
									<p>Upload your photos and organize them into albums. All of your photo albums will be ready to use when you’re customizing your next project.</p>
								</div>
							</div>
							<div class="u-1">
								<div class="grid-content">
									<div id="addAlbumBtn">
										<div class="actions center">
											<a id="addalbum" class="btn btn-primary main" href="javascript:void(0)">Add Album</a>
											<div id="btnPopover" class="btn btn-primary main" data-hasqtip="18" aria-describedby="qtip-18">
												<span class="photos-ico"></span>Add Photos
												<div class="sweettooth-tab"></div>
											</div>
											<!--<a id="sharephotos" class="btn sec" href="">Share Photos</a>-->
										</div>
									</div>        
								</div>
							</div>
							<hr/>
							<div class="row my-photo-list">
								@if(count($all_user_album)>0)
								@foreach($all_user_album as $k => $value)
								
								<div class="albumBack col-md-3" id="{{$value->id}}" style="padding-top:15px; padding-bottom:15px;">
									<a href="my_photos/album/{{$value->id}}">
									<table class="albumtable" style="padding:0px 0px 5px 0px" cellspacing="0" cellpadding="0" border="0">
										<tbody>
											<tr>
												<td class="albumcell">
													@if(count($value['UserUpload'])>0)
													<a href="my_photos/album/{{$value->id}}">
														<div class="albumlink position-relative" style="min-height:150px;">
															<img src="{{ URL::asset('public/'.$value['UserUpload'][0]['path'].'/'.$value['UserUpload'][0]['name']) }}" style="vertical-align:middle;text-align:center;width:100%;" alt="Click to enter album" class="coverImage">
														</div>
													</a>
													@else
													<a href="my_photos/album/{{$value->id}}">
														<div class="albumlink position-relative" style="width:100%; border:4px solid skyblue; min-height:150px;">
															<img src="{{ URL::asset('public/users_upload/no-image.png') }}" style="vertical-align:middle;text-align:center;width:100%;" alt="Click to enter album" class="coverImage">
														</div>
													</a>
													@endif
												</td>
											</tr>
											<tr>
												<td>
												
												<div class="my-photo-info p-3" style="color:#444444;">
													<div>
														<span class="contentInfo" style="padding-left:5px" onclick="return ToggleSelect('albumCheckBox_{{$value->id}}');">
															<span class="contentName" style="font-weight:bold" id="21206835_name">{{$value->album_name}}</span>
														</span>
													</div>
													<div style="font-size:100%">
														<span class="contentInfo" id="albumDetail_{{$value->id}}" title="{{$value->id}}">Created: {{date('m-d-Y',strtotime($value->created_at))}}</span>
													</div>
													<div style="font-size:100%">
														{{ count($value['UserUpload']) }} photos
													</div>
													
													
													<div style="float:right;margin-right:-12px;margin-top:-12px;"><a rel="{{$value->album_name}}" p="{{URL::asset('user/del_album/'.$value->id)}}" class="delAlb" href="javascript:void(0)" title="Delete" alt="Delete"><i class="fa fa-trash" aria-hidden="true" style="color:red;font-size:25px;"></i></a></div>
												</div>
												
												</td>
												
											</tr>
										</tbody>
									</table>
									</a>
								</div>
								
								@endforeach
								@else
								<div class="albumBack col-md-12" style="min-height:300px;">
									<table style="padding:0px 0px 5px 0px; width:100%;" cellspacing="0" cellpadding="0" border="0">
										<tbody>
											<tr>
												<td class="albumcell" style="color:red;text-align:center;">No album's found!</td>
											</tr>
										</tbody>
									</table>
								</div>
								@endif
							</div>
						</div>
					</div>
				</div>
				<!-- end my photo content -->
				
				<div id="dialog-confirm" title="Are you sure you want to delete your photo album" style="display:none;"></div>
 
				
			</div>
		</div>
	</section>
	<!-- Calander Page Info End -->
	
	<!-- model -->
	<div id="addAlbumDialog" title="Add Album">
		{!! Form::open(['method' => 'POST', 'url' => ['user/add_album'],'id'=>'album_form']) !!}
			<div class="row">
				<div class="col-sm-12 form-group" style="text-align:left;">
					{!! Form::label('album_name', 'Album Name', ['class' => 'control-label']) !!}
					{!! Form::text('album_name', old('album_name'), ['class' => 'form-control', 'placeholder' => 'Album Name', 'required'=>'true']) !!}
				</div>
			</div>
			{!! Form::button('ADD', ['class' => 'btn btn-primary', 'id'=>'album_button']) !!}
		{!! Form::close() !!}
	</div>
	
	<div id="addPhotoDialog" title="Add Photo">
		{!! Form::open(['method' => 'POST', 'url' => ['user/add_photo'],'enctype'=>'multipart/form-data']) !!}
			<div class="row">
				<!--<div><b>Accepted file types:</b> JPEG, PNG, JPG, GIF</div>
				<div><b>Maximum file size:</b> 10MB</div>
				<div><b>Minimum photo dimensions:</b> 600px width x 500px height</div>
				<hr style="width:100%;"/>-->
				<div class="col-sm-12 form-group" style="text-align:left;">
					{!! Form::label('album_name', 'Album Name', ['class' => 'control-label']) !!}
					{!! Form::select('album_id', $album, ['class' => 'form-control', 'required'=>'true']) !!}
				</div>
				<div class="col-sm-12 form-group" style="text-align:left;">
					<a id="addalbum_inphotodialog" class="btn btn-primary main" href="javascript:void(0)" style="color:#fff;">Add Album</a>
				</div>
				<div class="col-sm-12 form-group" style="text-align:left;">
					{!! Form::label('photo', 'Image (attach one or more photos)', ['class' => 'control-label']) !!}
					{!! Form::file('images[]', ['class' => 'form-control', 'multiple'=>'true', 'required'=>'true','id'=>'bulk_img']) !!}
				</div>
			</div>
			{!! Form::submit('Upload', ['class' => 'btn btn-primary', 'id'=>'photoUploadButton']) !!}
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
	
	<div id="deleteAlbumDialog" title="Delete Album"></div>
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
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
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
	
		var message = "Are you sure you want to delete your photo album: "+album_name+"? This action cannot be undone."
		$("#deleteAlbumDialog").html(message);
		//$("#deleteAlbumDialog").dialog( "open" );
		$("#deleteAlbumDialog").dialog({
			resizable: false,
			height: "auto",
			width: 400,
			modal: true,
			buttons: {
				"Delete": function(){
					/* var str = album_name;
					var x = confirm("Are you sure you want to delete your photo album: "+str+"? This action cannot be undone.");
					if (x){ */
						$("#deleteAlbumDialog").dialog( "close" );
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

	
	$("#addAlbumDialog").dialog({
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
	});
	$("#addalbum_inphotodialog").on("click", function(){
		$("#addPhotoDialog").dialog( "close" );
		$("#addAlbumDialog").dialog( "open" );
	});
	
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
	/* $( "#btnPopover" ).on( "click", function() {
		$("#addPhotoDialog").dialog( "open" );
	}); */ 
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
	$( "#btnPopover" ).on( "click", function() {
		$("#addPhotoDirection").dialog( "open" );
	}); 
	$("#my_computer").on('click', function(){
		$("#addPhotoDialog").dialog( "open" );
		$("#addPhotoDirection").dialog( "close" );
	});
	$("#photoUploadButton").on('click',function(){
		var files = $('input#bulk_img')[0].files;
		if(files.length < 1){
			swal("Oops!", "Please browse atleast one image...!", "error");
		}else{
			swal("Please Wait...!", "Photo Uploading...!", "warning");
		}
	});
	
	
	$("#album_button").click(function(){
		if($('#album_name').val() == ''){
			$('#album_name').css('border','1px solid red');
			$('#album_name').after("<span style='color:red'>Field can't be empty</span>");
		}else{
			var album_name = $('#album_name').val();
			var base_path = "<?php echo config('app.url');?>";
			$.ajaxSetup({ 
				headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} 
			});
			$.ajax({
				url : base_path + 'user/my_photos/getExistAlbum',            
				type : 'post',
				data : {album_name:album_name},
				beforeSend: function(){
					swal("Please Wait...!", "Loading Data...!", "warning");
				},
				success : function(data){
					if(data=='yes'){
						var error_msg = '<p class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">×</span></button>Oops! You already have an album with that name. Please try again with a different name.</p>';
						$('#album_form .row').before(error_msg);
					}else{
						$('#album_form').submit();
					} 
				}
			});
			
		}
	});
});
/* $(window).resize(function() {
	$("#addAlbumDialog").dialog("option", "position", {my: "center", at: "center", of: window});
	$("#addAlbumDialog").dialog({
		width: $(window).width() > 500 ? 500 : 'auto', //resizes the dialog box as the window is resized
	});
}); */




function ConfirmDelete(album_name){
	var str = album_name;
	var x = confirm("Are you sure you want to delete your photo album: "+str+"? This action cannot be undone.");
	if (x){
		return true;
	}else{
		return false;
	}
}
</script>
<style>
.coverImage {
	height: 150px;
}
.ui-dialog .ui-dialog-buttonpane button {
    background-color: #40b3d9 !important;
    color: #fff;
}
.ui-dialog .ui-dialog-buttonpane button:hover {
    background-color: #0062cc !important;
}
</style>
@endsection