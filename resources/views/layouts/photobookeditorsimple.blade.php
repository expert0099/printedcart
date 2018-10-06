<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="_token" content="{{ csrf_token() }}" />
		<title>PrintedCart: Shop</title>
		<style type="text/css">
		#wrapper{ width: 80%; text-align: center; margin: 0 auto; }
		.thumbimage {
			float:left;
			width:100px;
			position:relative;
			padding:5px;
		}
		nav.navbar:before, nav.navbar:after, nav.navbar .container:before, nav.navbar .container:after{display:none;}
		html{
			//font-size:inherit !important;
		}
		</style>
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/custom.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/font-awesome.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/common-page.css') }}">
			
		<!-- Bootstrap Script -->
		<script type="text/javascript" src="{{ URL::asset('public/js/jquery-3.2.1.slim.min.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('public/js/popper.min.js') }}"></script>
		
		<!--<script type="text/javascript" src="{{ URL::asset('public/js/bootstrap.min.js') }}"></script>-->
		
		<!--<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script type="text/javascript" src="{{ asset('public/extras/modernizr.2.5.3.min.js') }}"></script>-->
		
		<script type="text/javascript">
		$(document).ready(function() {
			$("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
				e.preventDefault();
				$(this).siblings('a.active').removeClass("active");
				$(this).addClass("active");
				var index = $(this).index();
				$("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
				$("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
			});
		});

		
		</script>
	</head>
	
	<body>
		<header>
			@include('layouts.partials.editorheadersimple')
		</header>
		
		@yield('main-content')
		
		<!-- photo dialog -->
		<div id="addPhotoDialog" title="Add Photo" style="display:none;">
		{!! Form::open(['method' => 'POST', 'url' => ['photobooks/upload_new_images'],'enctype'=>'multipart/form-data']) !!}
			<div class="row">
				<div class="col-sm-12 form-group" style="text-align:left;">
					{!! Form::label('album_name', 'Album Name', ['class' => 'control-label']) !!}
					{!! Form::select('album_id', $album_list, ['class' => 'form-control', 'required'=>'true']) !!}
				</div>
				<div class="col-sm-12 form-group" style="text-align:left;">
					<a id="addalbum_inphotodialog" class="btn btn-primary main" href="javascript:void(0)" style="color:#fff;">Add Album</a>
				</div>
				<div class="col-sm-12 form-group" style="text-align:left;">
					{!! Form::label('photo', 'Image (attach one or more photos)', ['class' => 'control-label']) !!}
					{!! Form::file('images[]', ['class' => 'form-control', 'multiple'=>'true', 'required'=>'true', 'id'=>'input_files']) !!}
				</div>
			</div>
			{!! Form::submit('Upload', ['class' => 'btn btn-primary', 'id'=>'photoUploadButton']) !!}
		{!! Form::close() !!}
		</div>
		<!-- end photo dialog -->
		
		<!-- album dialog -->
		<div id="addAlbumDialog" title="Add Album" style="display:none;">
		{!! Form::open(['method' => 'POST', 'url' => ['photobooks/add_new_album'],'id'=>'album_form']) !!}
			<div class="row">
				<div class="col-sm-12 form-group" style="text-align:left;">
					{!! Form::label('album_name', 'Album Name', ['class' => 'control-label']) !!}
					{!! Form::text('album_name', old('album_name'), ['class' => 'form-control', 'placeholder' => 'Album Name', 'required'=>'true']) !!}
				</div>
			</div>
			{!! Form::button('ADD', ['class' => 'btn btn-primary', 'id'=>'album_button']) !!}
		{!! Form::close() !!}
		</div>
		<!-- end album dialog -->
		
		<div id="addPhotoDirection" title="Upload" style="display:none;">
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
		
		<div id="img_loader" style="display:none;"></div>
		
		@if(null!==Session::get('stdClassData'))
			<?php 
			$stdClassData = Session::get('stdClassData');
			?>
		<div id="instagram_photos" title="Instagram Photos" style="display:none;">
			{!! Form::open(['method' => 'POST', 'url' => ['user/add_insta_photo'],'enctype'=>'multipart/form-data']) !!}
				<div class="row">
					<input type="checkbox" id="checkAll"/> Check All
				</div>
				<div class="row">
					@if(count($stdClassData['data'])>0)
						@foreach($stdClassData['data'] as $k => $o)
							<div class="albumBack col-sm-6 col-md-2" style="padding-top:15px; padding-bottom:15px;">
								<table class="albumtable" style="padding:0px 0px 5px 0px" cellspacing="0" cellpadding="0" border="0">
									<tbody>
										<tr>
											<td class="albumcell">
												<div class="albumlink position-relative">
													<img src="{{$o['images']['low_resolution']['url']}}" style="vertical-align:middle;text-align:center; border-radius: 10px" p="{{$o['id']}}" rel="{{ $o['link'] }}" alt="Instagram Photo" class="fancybox coverImage">
													<span><input type="checkbox" class="cb-element" name="insta_photo[{{$o['images']['low_resolution']['url']}}]"/></span>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						@endforeach
						
						<div>
							{!! Form::label('album_name', 'Album Name', ['class' => 'control-label']) !!}
							{!! Form::select('album_id', Session::get('album'), ['class' => 'form-control', 'required'=>'true']) !!}
							
							{!! Form::submit('Add photo', ['id' => 'insta_add','class' => 'btn btn-primary']) !!}
						</div>
					@else
						<hr style="width:100%;"/>
						<div style="color:red;text-align:center; min-height:300px;width:100%;">Instagram photos not found at this moment.</div>
					@endif
				</div>
			{!! Form::close() !!}
		</div>
		<script>
		$(function(){
			$("#instagram_photos").dialog({
				autoOpen: false,
				width: $(window).width() > 800 ? 800 : 'auto',
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
			$("#instagram_photos").dialog("open");
			
			$("#checkAll").change(function (){
				$("input:checkbox").prop('checked', $(this).prop("checked"));
			});
	
			$("#insta_add").on('click',function(){
				if($('.cb-element:checkbox:checked').length == 0){
					//alert('Check Atleast One Checkbox');
					swal("Oops!", "Check Atleast One Checkbox...!", "error");
					return false;
				}else{
					return true;
				}
			});
		});
		</script>
		@endif
		
		@if(null!==Session::get('list_album'))
			<?php 
			$list_album = Session::get('list_album');
			?>
			<div id="google_photos" title="Google Photos" style="display:none;">
				{!! Form::open(['method' => 'POST', 'url' => ['user/add_google_photo'],'enctype'=>'multipart/form-data']) !!}
					<div class="row">
						<input type="checkbox" id="checkAll"/> Check All
					</div>
					<div class="row">
						@if(count($list_album)>0)
							@foreach($list_album['Album'] as $k => $o)
								<div class="albumBack col-sm-6 col-md-2" style="padding-top:15px; padding-bottom:15px;">
									<table class="albumtable" style="padding:0px 0px 5px 0px" cellspacing="0" cellpadding="0" border="0">
										<tbody>
											<tr>
												<td class="albumcell">
													<div class="albumlink position-relative">
														<img src="{{$o['media_items']['baseUrl']}}" style="vertical-align:middle;text-align:center; border-radius: 10px" p="{{$o['media_items']['id']}}" rel="{{ $o['media_items']['productUrl'] }}" alt="Google Photo" class="fancybox coverImage">
														<span><input type="checkbox" class="cb-element" name="google_photo[{{$o['media_items']['baseUrl']}}]"/></span>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							@endforeach
									
							<div>
								{!! Form::label('album_name', 'Album Name', ['class' => 'control-label']) !!}
								{!! Form::select('album_id', Session::get('album'), ['class' => 'form-control', 'required'=>'true']) !!}
								
								{!! Form::submit('Add photo', ['id' => 'insta_add','class' => 'btn btn-primary']) !!}
							</div>
						@else
							<hr style="width:100%;"/>
							<div style="color:red;text-align:center; min-height:300px;width:100%;">Google photos not found at this moment.</div>
						@endif
					</div>
				{!! Form::close() !!}
			</div>
			<script>
			$(function(){
				$("#google_photos").dialog({
					autoOpen: false,
					width: $(window).width() > 800 ? 800 : 'auto',
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
				$("#google_photos").dialog("open");
				
				$("#checkAll").change(function (){
					$("input:checkbox").prop('checked', $(this).prop("checked"));
				});
		
				$("#insta_add").on('click',function(){
					if($('.cb-element:checkbox:checked').length == 0){
						//alert('Check Atleast One Checkbox');
						swal("Oops!", "Check Atleast One Checkbox...!", "error");
						return false;
					}else{
						return true;
					}
				});
			});
			</script>
		@endif
		
		@if(null!==Session::get('response'))
			<?php 
			$response = Session::get('response');
			?>
			<div id="fb_photos" title="Facebook Photos" style="display:none;">
				@if($response['error'])
					@foreach($response['error'] as $error)
						<p class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">×</span></button>
							{{ $error }}
						</p>
					@endforeach
				@endif
				
				@if($response['success'])
					<p>{{$response['success']['fb_name']}}</p>
					<p>{{$response['success']['fb_id']}}</p>
				@endif
			</div>
			<script>
			$(function(){
				$("#fb_photos").dialog({
					autoOpen: false,
					width: $(window).width() > 800 ? 800 : 'auto',
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
				$("#fb_photos").dialog("open");
				
				$("#checkAll").change(function (){
					$("input:checkbox").prop('checked', $(this).prop("checked"));
				});
		
				$("#insta_add").on('click',function(){
					if($('.cb-element:checkbox:checked').length == 0){
						//alert('Check Atleast One Checkbox');
						swal("Oops!", "Check Atleast One Checkbox...!", "error");
						return false;
					}else{
						return true;
					}
				});
			});
			</script>
		@endif
		
<!-- 		<footer>
<div id="preview-uploaded-image" class="drag-elements droppable multipleChildren hasChild" style="height: 100px;"></div>
		</footer> -->
 <!-- Modal for upload image -->
  <!--<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">Upload Photos</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
          <form id="UploadImgForm" name="UploadImgForm" enctype="multipart/form-data">
          <div class="form-group"> 
            <label for="albums">Select Album:</label>
            <select id="albums" name="albums" class="form-control" required="">
              <option value="">Select Album</option>
              @foreach($albums as $album)
              <option value="{{$album->id}}">{{$album->album_name}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group"> 
            <a class="nav-link btn btn-primary" href="#" data-toggle="modal" data-target="#NewAlbum"><i class="fa fa-picture-o" aria-hidden="true"></i> New Album</a>
          </div>
          <div class="form-group"> 
            <label for="imageupload">Select Image:</label>
            <input id="imageupload" type="file" required="true" name="files[]" multiple  class="form-control"/>
          </div>
          <div class="form-group"> 
              <div id="preview-image" style="height: 100px;display:none;"></div>
          </div>
          <div class="form-group"> 
              <input type="submit" name="Upload" class="btn btn-primary" id="Upload" value="Upload" style="display: block;">
          </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>-->

<!-- Modal for new album -->
<!--<div class="modal fade" id="NewAlbum" role="dialog" style="background: #000">
    <div class="modal-dialog modal-lg">
      <form id="NewAlbumForm" name="NewAlbumForm" enctype="multipart/form-data">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">New Album</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>          
          </div>
          <div class="modal-body"> 
            <div class="form-group">  
                <label for="albumName">Name:</label>      
                <input type="text" name="albumName" id="albumName" class="form-control" required="">
            </div>
          </div>
          <div class="modal-footer">
            <input type="submit"  class="btn btn-primary" name="Upload" id="Upload" value="OK" >
            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </form>
    </div>
  </div>-->

<!--<script type="text/javascript" src="{{ URL::asset('public/js/jquery.min.js') }}"></script>	
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>-->
<style>
#addPhotoDirection .socialSieText{padding:15px 0; background: #f5f5f5; font-size:14px;}
#addPhotoDirection .socialBtn{color:#fff;width:100%;}
#addPhotoDirection .socialBtn.instaBtn{background:#275f8e;}
#addPhotoDirection .socialBtn.googleBtn{background:#dc483c;}
#addPhotoDirection .socialBtn.facebookBtn{background:#3a5897;}
#addPhotoDirection .socialBtn i{margin-right:5px;display:inline-block;}
</style>
<script type="text/javascript">
function show_error(){
	$(".show_error_info").attr("style","display:block");
}
function hide_error(){
	$(".show_error_info").attr("style","display:none");
}
var base_path = "<?php echo config('app.url');?>";
$(function(){
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
		width: $(window).width() > 650 ? 650 : 'auto',
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
		var files = $('input#input_files')[0].files;
		if(files.length < 1){
			swal("Oops!", "Please browse atleast one image...!", "error");
		}else{
			swal("Please Wait...!", "Photo Uploading...!", "warning");
		}
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
	$("#addalbum_inphotodialog").on("click", function(){
		$("#addPhotoDialog").dialog( "close" );
		$("#addAlbumDialog").dialog( "open" );
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
					//$('#img_loader').css('display','block');
					//$('#img_loader').html("<img src='https://printedcart.com/printedcart/public/images/loader.gif'>");
					swal("Please Wait...!", "Loading Data...!", "warning");
				},
				success : function(data){
					//$('#img_loader').css('display','none');
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
	
	setTimeout(function(){
        $('.alert-success').fadeOut('fast');
    }, 10000); 
	setTimeout(function(){
        $('.alert-danger').fadeOut('fast');
    }, 50000);
	
});
/* $("#imageupload").on('change', function () { 
    var countFiles = $(this)[0].files.length; 
     var imgPath = $(this)[0].value;
     var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
     var image_holder = $("#preview-image");
     image_holder.empty();
 
     if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
          if (typeof (FileReader) != "undefined") {
 
            for (var i = 0; i < countFiles; i++) {
 
                 var reader = new FileReader();
                 reader.onload = function (e) {
                     $("<img />", {
                         "src": e.target.result,
                             "class": "thumbimage"
                     }).appendTo(image_holder);
                 }
 
                 image_holder.show();
                 $("#Upload").show();
                 reader.readAsDataURL($(this)[0].files[i]);
             }
 
         } else {
             alert("This browser does not support FileReader.");
         }
     } else {
         alert("Pls select only images");
     }
 });

$("#UploadImgForm").submit(function(){
    var frmData = new FormData($(this)[0]); 
    $.ajaxSetup({ 
		headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') } 
    });
    $.ajax({
		url : base_path+'photobooks/upload_new_images',            
		type : 'POST',
		data : frmData,
		processData: false,
		contentType: false,
		cache:false,
		success : function(data){
		 	$("#preview-image").html("");
			$("#UploadImgForm").trigger("reset");
		   $('.ui-dialog-titlebar-close').trigger('click');
			window.location.reload();
			
		}
	});

    return false;

})
$("#NewAlbumForm").submit(function(){
    var frmData = new FormData($(this)[0]); 
    $.ajaxSetup({ 
		headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') } 
    });
    $.ajax({
            url : base_path+'photobooks/add_new_album',            
            type : 'POST',
            data : frmData,
            processData: false,
            contentType: false,
            cache:false,
            success : function(data){
                $("#albums").append(data); 
                $("#NewAlbumForm").trigger("reset");
				$('#NewAlbumForm .close').trigger('click');
			}
        });

    return false;

}); */

$("#albumListsLi li").click(function(){
    var cid = $(this).attr("label");
    var cln = $("#"+cid).html();
    $("#SelectAlbumPics").html(cln);  
}); 
 </script>
@if(session('album_id'))
	<script>
	$(function(){
		//toastr.success("Album Added Successfully");
		swal("Done", "Album Added Successfully", "success")
		.then((value) => {
			$("#addPhotoDialog").dialog( "open" );
		});
	});
	</script>
@endif
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
		var m_error_msg = '<p class="alert alert-danger"><a href="#" onclick="show_error()" class="show_error" style="color:#721c24;text-decoration:none;">'+m_error+'</a></p>';
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
@if(session('photo_upload') && session('photo_upload')=='ok')
	<script>
	$(function(){
		//toastr.success("Photo Added Successfully");
		swal("Done", "Photo Added Successfully", "success");
	});
	</script>
@endif

<style>
#img_loader img {
	position: absolute;
	left: 50%;
	top: 50%;
	transform: translateY(-50%) translateX(-50%);
	-moz-transform: translateY(-50%) translateX(-50%);
	-webkit-transform: translateY(-50%) translateX(-50%);
	-ms-transform: translateY(-50%) translateX(-50%);
	-o-transform: translateY(-50%) translateX(-50%);
}
#img_loader {
	position: fixed;
	top: 0;
	height: 100%;
	left: 0;
	width: 100%;
	background-color: rgba(0,0,0,0.1);
	z-index: 99999;
}
</style>



	</body>
</html>