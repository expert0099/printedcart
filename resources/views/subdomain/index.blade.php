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
							<li class="active"><a href="{{URL::asset('/?sid='.base64_encode($sharesite_id))}}">Home</a></li>
							<li><a href="{{URL::asset('/?sid='.base64_encode($sharesite_id).'&page=pictures')}}">Pictures &amp; Videos</a></li>
							<li><a href="{{URL::asset('/?sid='.base64_encode($sharesite_id).'&page=calendar')}}">Calendar</a></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
		
		<div class="sample-pictures">
			<form name="edit_picture" method="post" action="{{URL::asset('change_picture')}}" enctype="multipart/form-data">
				{{csrf_field()}}
				<div class="sample-pictures-1">
				
					@if(!empty($image1->image_name1))
						<img src="{{URL::asset('public/' . $image1->image_path . '/' .$image1->image_name1)}}" style="width:478px;height:299px;">
					@else
						<img src="{{URL::asset('public/images/design/family_3.jpg')}}" style="width:478px;height:299px;">
					@endif
					
					<!-- @if($sharesite->user_id == Auth::user()->id) -->
						<input type="hidden" name="sharesite_id" value="{{$sharesite_id}}"/>
						<input class="change_picture" onChange="form.submit(),swal('Please Wait...!','Photo Uploading...!','warning')" type="file" name="change_picture1" id="change_picture" style="display:none;"/>
						<input class="change_picture" type="button" value="Change Picture" onclick="document.getElementById('change_picture').click();" />
					<!-- @endif -->
					<!--<a href="#" class="change_picture">Change Picture</a>-->
					<!--<select>
						<option value="option">Select option</option>
						<option value="option">Select option</option>
						<option value="option">Select option</option>
						<option value="option">Select option</option>
					</select>-->
				</div>
			</form>
			<form name="edit_picture2" method="post" action="{{URL::asset('change_picture')}}" enctype="multipart/form-data">
				{{csrf_field()}}
				<div class="sample-pictures-2">
					
					@if(!empty($image2->image_name2))
						<img src="{{URL::asset('public/' . $image2->image_path . '/' . $image2->image_name2)}}" style="width:184px;height:299px;">
					@else
						<img src="{{URL::asset('public/images/design/family_2.jpg')}}" style="width:184px;height:299px;">
					@endif
					
					<!-- @if($sharesite->user_id == Auth::user()->id) -->
						<input type="hidden" name="sharesite_id" value="{{$sharesite_id}}"/>
						<input class="change_picture" onChange="form.submit(),swal('Please Wait...!','Photo Uploading...!','warning')" type="file" name="change_picture2" id="change_picture2" style="display:none;"/>
						<input class="change_picture" type="button" value="Change Picture" onclick="document.getElementById('change_picture2').click();" />
					<!-- @endif -->
					<!--<a href="#" class="change_picture">Change Picture</a>-->
					<!--<select>
						<option value="option">Select option</option>
						<option value="option">Select option</option>
						<option value="option">Select option</option>
						<option value="option">Select option</option>
					</select>-->
				</div>
			</form>
			<form name="edit_picture3" method="post" action="{{URL::asset('change_picture')}}" enctype="multipart/form-data">
				{{csrf_field()}}
				<div class="sample-pictures-3">
				
					@if(!empty($image3->image_name3))
						<img src="{{URL::asset('public/' . $image3->image_path . '/' . $image3->image_name3)}}" style="width:314px;height:299px;">
					@else
						<img src="{{URL::asset('public/images/design/family_1.jpg')}}" style="width:314px;height:299px;">
					@endif
					
					<!-- @if($sharesite->user_id == Auth::user()->id) -->
						<input type="hidden" name="sharesite_id" value="{{$sharesite_id}}"/>
						<input class="change_picture" onChange="form.submit(),swal('Please Wait...!','Photo Uploading...!','warning')" type="file" name="change_picture3" id="change_picture3" style="display:none;"/>
						<input class="change_picture" type="button" value="Change Picture" onclick="document.getElementById('change_picture3').click();" />
					<!-- @endif -->
					<!--<a href="#" class="change_picture">Change Picture</a>-->
					<!--<select>
						<option value="option">Select option</option>
						<option value="option">Select option</option>
						<option value="option">Select option</option>
						<option value="option">Select option</option>
					</select>-->
				</div>
			</form>
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
								<a href="#" class="welcome-title">Welcome to our family site!</a>
								<select class="pull-right">
									<option value="option">Select option</option>
									<option value="option">Select option</option>
									<option value="option">Select option</option>
									<option value="option">Select option</option>
								</select>
								<p>Here you'll find updated pictures and news about us. Visit us regularly and see what we're up to.</p>
								<a href="#" class="edit-task"><span><img src="{{URL::asset('public/images/design/plus.png')}}"></span>Edit Message</a>
							</li>
							<li>
								<a href="#" class="welcome-title">Recent activity</a>
								<select class="pull-right">
									<option value="option">Select option</option>
									<option value="option">Select option</option>
									<option value="option">Select option</option>
									<option value="option">Select option</option>
								</select>
								<p>This section will auto-populate once you add pictures, videos, journal entries or other content. Comments added to the site will also appear here.</p>
							</li>
							<li>
								<a href="#" class="welcome-title">Family updates</a>
								<select class="pull-right">
									<option value="option">Select option</option>
									<option value="option">Select option</option>
									<option value="option">Select option</option>
									<option value="option">Select option</option>
								</select>
								<p>Post your thoughts or keep others updated with what's going on. Click the 'Add journal entry' link to get started.</p>
								<a href="#" class="edit-task"><span><img src="{{URL::asset('public/images/design/plus.png')}}"></span> Add journal entry</a>
							</li>
							<li class="last-li">
								<a href="#" class="edit-task"><span><img src="{{URL::asset('public/images/design/plus.png')}}"></span>Add other sections to your site such as a calendar, message board, and more</a>
							</li>
						</ul>
					</div>
					
					<div class="col-sm-4">
						<ul>
							<li>
								<a href="#" class="welcome-title">Family &amp; friends</a>
								<select class="pull-right">
									<option value="option">Select option</option>
									<option value="option">Select option</option>
									<option value="option">Select option</option>
									<option value="option">Select option</option>
								</select>
								<p><span>1 member</span><a href="#" class="see-all">see all members</a></p>
								<div class="member-profile">
									<div class="share-profile-avatar">
				                		<a href="#">
				                    		<img class="avatar" src="https://uniim-cp.shutterfly.com/procserv?f=0&amp;g=2.2&amp;cb=16777215&amp;b=1&amp;bw=0.2&amp;sc=0&amp;si=00009287750420090707210226944.JPG&amp;cr=0.0%2c0.0%2c1.0%2c1.0&amp;px=75&amp;py=75&amp;r=0&amp;pa=0.5&amp;sa=0&amp;p=1&amp;po=0&amp;dsbg=221&amp;ph=65535&amp;rx=75&amp;ry=75&amp;ps=23&amp;def=1" alt="redE150770647824249">
				                		</a>
	            					</div>
	            					<span>red e (Owner) <img src="{{URL::asset('public/images/design/mail.png')}}"></span>
            					</div>
								<p>
									<a href="#" class="edit-task"><span><img src="{{URL::asset('public/images/design/plus.png')}}"></span>Add members</a>
									<a href="#" class="edit-task"><span><img src="{{URL::asset('public/images/design/mail.png')}}"></span>email members</a>
								</p>
								
							</li>
							<li>
								<a href="#" class="welcome-title">Favorite sites</a>
								<select class="pull-right">
									<option value="option">Select option</option>
									<option value="option">Select option</option>
									<option value="option">Select option</option>
									<option value="option">Select option</option>
								</select>
								<p>Link to your favorite web sites and other Share sites. Click the 'Add bookmark' link to get started.</p>
								<a href="#" class="edit-task"><span><img src="{{URL::asset('public/images/design/plus.png')}}"></span>Add bookmark</a>
							</li>
							<li>
								<a href="#" class="welcome-title">Guestbook</a>
								<select class="pull-right">
									<option value="option">Select option</option>
									<option value="option">Select option</option>
									<option value="option">Select option</option>
									<option value="option">Select option</option>
								</select>
								<div class="guestbook-area">
									<textarea></textarea>
									<a href="#" class="btn-primary btn-sm pull-right">Add</a>
								</div>
							</li>
							<li class="last-li">
								<a href="#" class="edit-task"><span><img src="{{URL::asset('public/images/design/plus.png')}}"></span>Add other sections to your site such as a calendar, message board, and more</a>
							</li>
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
<script>
$(document).ready(function(){
	setTimeout(function() {
        $('.alert-success').fadeOut('fast');
    }, 5000); 
	setTimeout(function(){
        $('.alert-danger').fadeOut('fast');
    }, 5000);
}); 
</script>
@endsection