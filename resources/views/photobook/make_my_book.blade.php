@extends("layouts.photobook")

@section("main-content")

<div class="continer-fluid">
	@include('photobook.banner_mmb')
</div>

<div class="container">
	<div class="row">
		<div class="col-lg-12 text-center pt-4 ">
			<h2>Here's how it works</h2>
		</div>
	</div>
	<div class="row pt-2 three-images">	
		<div class="col-md-12 col-lg-4 text-center"> 
			<img src="{{URL::asset('public/images/choose_icon.png')}}">
			<h6><strong>Pick your favorite design</strong></h6>
			<p style="text-align:justify;">pick your ideal book size and style. Upload your photos or albums and share your moments in the form of captions.</p>
		</div>
		<div class="col-md-12 col-lg-4 text-center">
		    <img src="{{URL::asset('public/images/album_icon.png')}}">
			<h6><strong>Rest we will take care</strong></h6>
			<p style="text-align:justify;">Printedcart.com professionals will take care of your photo books and create the best customized photo book within 3 working days. We will add it into your account and also send notification to your registered email id when it’s ready.</p>
		</div>
		<div class="col-md-12 col-lg-4 text-center">
		    <img src="{{URL::asset('public/images/order_icon.png')}}">
			<h6><strong>View and order</strong></h6>
			<p style="text-align:justify;">Order your book as is or personalize it with your own finishing touches. The $9.99 service fee is applied only if you order your finished book.</p>
		</div>
	</div>
	<div class="row pb-4">
		<div class="col-lg-12 text-center pt-4  make-tab-bottom">
			<a href="{{URL::asset('photobooks/mmb')}}">Make My Book</a>
		</div>
	</div>
	<div class="row pb-4">
		<div class="col-lg-12 text-center pt-2 accordion-tab">
			<div id="accordion">
				<div class="card">
					<div id="headingOne" class="btn btn-link card-header" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						<h5 class="mb-0">
							<button>Quick tips to get the best book</button>
						</h5>
					</div>
					<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
						<div class="card-body">
							<h6>Choose your design wisely</h6>
							<p style="text-align:justify;">We have styles for every occasion. Consider the story captured in your photos while scrolling through our styles, previewing the ones you like. Then select the style you love best for your book.</p>
							<h6>Choose photos with date/time info</h6>
							<p style="text-align:justify;">Our goal is to design a beautiful photo book that tells your story in chronological order. If too many photos are missing the date/time information, we'll ask you to confirm the order in which you'd like to see these photos in the book.</p>
							<h6>More photos, more pages</h6>
							<p style="text-align:justify;">The more photos you upload, the more pages we'll create. However, the more pages in your book, the more it will cost. Please let us know in the Special Instructions section if you have a page count in mind (a 10-page book usually holds 10-20 photos with a maximum of 50 photos).</p>
							<h6>Provide Special captions</h6>
							<p style="text-align:justify;">We want to know all we can about the photo book you want. So we included a few questions about your design preferences and a Special captions section on the last page of the request. Please tell us about the story captured in your photos, how you'd like to see the photos organized and anything else you think would be helpful.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row pb-4">
		<div class="col-lg-12 text-center pt-4">
			<h2>How to Add Finishing Touches</h2>
		</div>
	</div>
	<div class="row pb-4">
		<div class="col-lg-6 pt-4" id="video" style="text-align:center;">
			@foreach($finishing_touches as $k => $value)
			@if($k==0)
			<iframe width="650" height="325" src="{{$value['video_url']}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
			@endif
			@endforeach
		</div>
		<div class="col-lg-6 pt-4">
			<div class="video-playlist-videos" style="height: 324px;">
				<ol>
					@foreach($finishing_touches as $k => $value)
					<li class="mmb-video-list" id="{{$value['id']}}">{!! $value['finish_touche'] !!}</li>
					@endforeach
				</ol>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	var base_path = "<?php echo config('app.url');?>";
	$('.mmb-video-list').click(function(){
		var loading = "{{URL::asset('public/images/loader.gif')}}";
		var id = $(this).attr('id');
		$.ajax({
            url : base_path+'photobooks/mmb_fitch/'+id,            
            type : 'GET',
			beforeSend: function(){
				$("#video" ).html('<img src="'+loading+'" style="text-align:center;"> <br>loading...');
			},
            success : function(data){
				$('#video').html(data);
            }
        });
	});
});
</script>
@endsection