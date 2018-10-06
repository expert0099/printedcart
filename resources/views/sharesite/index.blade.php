@extends("layouts.sharesite")

@section("main-content")

<div class="container">

	<section style="margin-top: 100px; margin-bottom: 30px;">
		<div class="sharesite-welcome-section">
		
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<div class="row">
							<div class="col-sm-6">
								<div class="private-group-img">
									<img src="{{URL::asset('public/images/imgmarqueetext.png')}}">
								</div>
								<a href="{{URL::asset('sharesite/makeasite/1')}}" class="btn btn-primary">Make a free site</a>
							</div>
							<div class="col-sm-6">
								<div class="imgmarqueesprite"> </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="latest-blog-posts bg-white pt60 pb60 carousel welcome">
			<h2 class="carouselHeading avenir35Light">What kind of Share site do you want to make?</h2>
			<div class="container-fluid">
				<!-- includes for dialog -->
				<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
				<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
				<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>-->
				<!-- end includes for dialog -->
				<div id="owl-demo-2" class="owl-carousel owl-theme">
					@foreach($shareSiteCategory as $k => $value)
					<article class="thumbnail item" itemscope="" itemtype="http://schema.org/CreativeWork">
						<div class="share-site">
							<h5>{{$value->title}}</h5>
							<div class="carousel-img">
								<img src="{{URL::asset($value->img_path)}}">
							</div>
							
							<div class="text-area">
								<p>{{$value->description}}</p>
							</div>
							<a href="{{URL::asset('sharesite/makeasite/'.$value->id)}}" class="btn btn-primary" style="margin-left: 5px;">Make a site</a>
							<div class="share-simple-site">
								<a href="#" id="{{$value->id}}">See Features</a>
								<!-- popup div -->
								<div id="dialog_{{$value->id}}" title="{{$value->title}}" style="display:none;">
									<?php 
									$string = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $value->features);
									?>
									<p>{{$string}}</p>
								</div>
								<script>
								$(function(){
									$('#'+{{$value->id}}).click(function(){
										$("#dialog_{{$value->id}}").dialog({
											width: 500,
											height: 300,
											modal: true,
											resizable: false,
										});
									});
								});
								</script>
								<!-- end popup div -->
							</div>
						</div>
					</article>
					@endforeach
				</div>
			</div>
		</div>
		
		<div class="share-site-video-section">
			<div class="container">
				<div class="row">
					<div class="col-sm-8 video-part">
						<video id="vd1" width="700" controls="controls" preload="none">
							<source src="{{URL::asset('public/videos/add.mp4')}}" type="video/mp4">
						</video>
						<!--<span class="play-icon"></span>-->
					</div>
					<div class="col-sm-4 seal-approval">
						<img src="{{URL::asset('public/images/img-sealofapproval.jpg')}}">
					</div>
				</div>
			</div>
		</div>
		
		<div class="about-share-site">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<hr>
						<strong>About Share Sites</strong>
						<p>With Printed Cart Share sites, you can create a free photo-sharing website in minutes. Use your Share site to privately (or publicly) share photos with friends and family, a sports team, classroom, co-workers, membership, or any group. As with any Printed cart product, you can customize your website with exclusive designs and layouts specific to your tastes. With your new Share site, you are not limited to just sharing photos.</p>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>	

@endsection