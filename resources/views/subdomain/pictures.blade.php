@extends("layouts.subdomain")

@section("main-content")

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
							<li class="active"><a href="{{URL::asset('/?sid='.base64_encode($sharesite_id).'&page=pictures')}}">Pictures &amp; Videos</a></li>
							<li><a href="{{URL::asset('/?sid='.base64_encode($sharesite_id).'&page=calendar')}}">Calendar</a></li>
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
					
					<div class="col-sm-8">
						<ul>
							<li>
								<a href="#" class="welcome-title">Picures</a>
							</li>
							<li>
								<form name="pictures" method="post" action="{{URL::asset('upload_pictures')}}" enctype="multipart/form-data">
									{{csrf_field()}}
									<input type="hidden" name="sharesite_id" value="{{$sharesite_id}}"/>
									<input class="change_picture" onChange="form.submit(),swal('Please Wait...!','Photo Uploading...!','warning')" type="file" name="pictures[]" id="pictures" multiple="true" style="display:none;"/>
									<img class="pic-empty-img" src="//cdn.staticsfly.com/shr/images/blank/370798195.gif">
									<input align="center" class="btn btn-primary" type="button" value="Click to add picture" onclick="document.getElementById('pictures').click();"/>
								</form>
							</li>
							@if(count($sharesite_photos)>0)
							<li>
								@foreach($sharesite_photos as $k => $v)
									<img src="{{URL::asset('public/' . $v->image_path . '/' . $v->image_name)}}" style="width:198px;padding-bottom:2px;">
								@endforeach
							</li>
							@endif
						</ul>
					</div>
					
					<div class="col-sm-4">
						<ul>
							<li>
								<a href="#" class="welcome-title">Videos</a>
							</li>
							<li>
								<form name="videos" method="post" action="{{URL::asset('upload_videos')}}" enctype="multipart/form-data">
									{{csrf_field()}}
									<input type="hidden" name="sharesite_id" value="{{$sharesite_id}}"/>
									<div><label>Video (YouTube Embed URL)</label>
									<img class="video-empty-img" src="//cdn.staticsfly.com/shr/images/blank/370798195.gif">
									<input class="form-control" type="text" required="true" name="video" id="video"/></div>
									<div><input class="form-control btn btn-primary" type="submit" value="Add New Video" id="videoSubmitButton" style="width:140px;margin-top:10px;"/></div>
								</form>
							</li>
							@if(count($sharesite_videos)>0)
								@foreach($sharesite_videos as $k => $v)
									<li><iframe width="280" height="230" src="{{$v->video}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe></li>
								@endforeach
							@endif
						</ul>
					</div>
				</div>
			</div>
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
							<p class="copyright-footer">Copyright Printed Cart {!!date('Y')!!}. All rights reserved.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<style>
.video-empty-img {
	/* display: block; */
	margin: 0 auto 10px auto;
	width: 63px;
	height: 60px;
	cursor: pointer;
	background: transparent url(//cdn.staticsfly.com/shr/t/base/i/img_videos_empty.gif) no-repeat center center;
}
.pic-empty-img {
	/* display: block; */
	margin: 0 auto 10px auto;
	width: 55px;
	height: 39px;
	cursor: pointer;
	background: transparent url(//cdn.staticsfly.com/shr/t/base/i/img_picturesempty.png) no-repeat center center;
}
</style>
<script>
$(document).ready(function(){
	setTimeout(function() {
        $('.alert-success').fadeOut('fast');
    }, 5000); 
	setTimeout(function(){
        $('.alert-danger').fadeOut('fast');
    }, 5000);
	
	$("#videoSubmitButton").on('click',function(){
		if($("#video").val()==''){
			swal("Oops!","Video url input can not be empty!","error");
		}else{
			swal("Please Wait...!","Data uploading...!","warning");
		}
	});
}); 
</script>
@endsection