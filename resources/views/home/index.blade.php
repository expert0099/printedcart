@extends("layouts.home")

@section("main-content")

@include('home.banner')

<!-- Feature Product Section Start -->
<section class="page-feature-product m-100">
	
	<div class="container-fluid w-96">
		@if(Session::has('success'))
			<div class="alert alert-success alert-dismissible" role="alert" style="margin-top:20px;">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				{{Session::get('success')}}
			</div>
		@endif
		<div class="text-center featured-title">
			<h1 class="bg-white d-inline-block pr-5 pl-5">Featured Products</h1>
		</div>
		<div class="container img-card-holder">
			<div class="row">
				@foreach($group as $k => $v)
				<div class="col-md-4 mb-4 mb-md-0">
					<div class="img-card">
						<img class="card-img-top" src="{{URL::asset($v['feature_image'])}}" alt="feature-product">
						<div class="overlay">
							<div class="text text-center">
								<h2 class="text-white">{!! $v['sizegroup'] !!}</h2>
								<p class="mb-0 pb-4">{!! $v['content'] !!}</p>
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
			<!-- Row Close -->
		</div>
		<!-- container img-card-holde close -->
	</div>
	<!-- container-fluid w-96 close -->
</section>
<!-- Feature Product Section End -->

<div class="container">
	<div class="row">
		<div class="col start-markting-btn text-center">
			<span class="btn btn-primary text-uppercase fz-30 rounded-0 border-0" style="cursor:default">START MAKING</span>
		</div>
	</div>
</div>
<section class="who-printedcart-section">
	<div class="container-fluid p-0">
		<div class="wp-bg">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-md-6 mt-4 mt-md-0">
						<img class="" src="{{asset('public/images/book-img.jpg')}}" alt="who-printedcart-img">
					</div>
					<div class="col-md-6 mb-4 mb-md-0">
						<div class="wp-right-text bg-white p-5">
							<h1 class="mb-4">Who is Printedcart?</h1>
							<p class="mb-0">{!! $about_content['page_content'] !!}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="how-work-section m-100">
	<div class="container">
		<h1 class="text-center d-block">How it work</h1>
		<div class="row align-items-center mt-5 how-work-box">
			<div class="work-box col-md-6 col-lg-3 d-flex pt-4 pb-4 justify-content-center justify-content-lg-start mb-md-3 mb-lg-0">
				<img class="img-fluid mr-4" src="{{asset('public/images/work1.png')}}" alt="work-icon">
				<h4>Upload<br>my images</h4>
			</div>
			<div class="work-box col-md-6 col-lg-3 d-flex justify-content-center pt-4 pb-4 mb-md-3 mb-lg-0">
				<img class="img-fluid mr-4" src="{{asset('public/images/work2.png')}}" alt="work-icon">
				<h4>Printedcart<br>designs</h4>
			</div>			
			<div class="work-box col-md-6 col-lg-3 d-flex justify-content-center pt-4 pb-4">
				<img class="img-fluid mr-4" src="{{asset('public/images/work3.png')}}" alt="work-icon">
				<h4>Custom<br>design</h4>
			</div>
			<div class="work-box col-md-6 col-lg-3 d-flex justify-content-center justify-content-lg-end pt-4 pb-4 border-0">
				<img class="img-fluid mr-4" src="{{asset('public/images/work4.png')}}" alt="work-icon">
				<h4>Bulk<br>enquiry</h4>
			</div>			
		</div>
	</div>
</section>
<section class="testimonial-form-section">
	<div class="container-fluid p-0">
		<div class="row m-0">
			<div class="col-md-12 col-lg-6 customer-review-section pt-5">
				<h3 class="mb-4">Customer review</h3>
				<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
					<ol class="carousel-indicators">
					@foreach($user_feedback as $k => $v)
						@if($k == 0)
							<li data-target="#carouselExampleIndicators" data-slide-to="{{$k}}" class="active"></li>
						@else
							<li data-target="#carouselExampleIndicators" data-slide-to="{{$k}}"></li>
						@endif
					@endforeach
						<!--<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
						<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
						<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>-->
					</ol>
					<div class="carousel-inner">
					@foreach($user_feedback as $k => $v)
						<?php 
						if($k==0){
							$class = "active";
						}else{
							$class = "";
						}
						?>
						<div class="carousel-item {{$class}}">
							<div class="d-block w-100">
								<p>{{$v->msg}}</p>
								<div class="col p-0 d-flex mt-4 align-items-center">
									<!--<img class="img-fluid mr-4 rounded-circle" src="{{asset('public/images/user-img.jpg')}}" alt="work-icon">-->
									<img class="img-fluid mr-4 rounded-circle" src="{{asset('public/images/procserv.jpg')}}" alt="work-icon">
									
									<div class="u-name">
										<p class="m-0">{{$v->name}} - {{$v->country}}</p>
										<div class="u-rating">
											<?php
											if($v->star_rating == 'one'){
												$star_rating = 1;
											}elseif($v->star_rating == 'two'){
												$star_rating = 2;
											}elseif($v->star_rating == 'three'){
												$star_rating = 3;
											}elseif($v->star_rating == 'four'){
												$star_rating = 4;
											}else{
												$star_rating = 5;
											}
											for($i=1;$i<=5;$i++){
												if($i <= $star_rating){
													?>
													<i class="fa fa-star" aria-hidden="true"></i>
													<?php
												}else{
													?>
													<i class="fa fa-star-o" aria-hidden="true"></i>
													<?php
												}
											}
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
					@endforeach
					</div>
				</div>
			</div>
			<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
			<!-- customer-review-section end -->
			<div class="col-md-12 col-lg-6 request-form-section">
				<div class="request-a-quote pt-5" id="request-a-quote">
					<h3 class="mb-4">Request a Quote</h3>
					@if (session('quote'))
						<!--<div class="alert alert-success">
							{{ session('quote') }}
						</div>-->
						<script>
						$(function(){
							swal("Awesome!","{{ session('quote') }}","success");
						});
						</script>
					@endif

					{!! Form::open(['method' => 'POST','url'=>'request_quote','id'=>'quoteForm']) !!}
						<div class="form-row mb-3">
							<div class="col-12 col-sm-6 mb-3">
								<input type="text" name="name" required='true' class="form-control border-0 rounded-0" placeholder="Name">
								@if($errors->has('name'))
									<!--<p class="help-block">
										{{ $errors->first('name') }}
									</p>-->
									<script>
									$(function(){
										swal("Oops!","{{ $errors->first('name') }}","error")
										.then((value) => {
											window.location.href="https://printedcart.com/printedcart/home#request-a-quote";
										});
									});
									</script>
								@endif
							</div>
							<div class="col-12 col-sm-6">
								<input type="email" id="quote_email" name="quote_email" required='true' class="form-control border-0 rounded-0" aria-describedby="emailHelp" placeholder="Email">
								@if($errors->has('quote_email'))
									<!--<p class="help-block">
										{{ $errors->first('quote_email') }}
									</p>-->
									<script>
									$(function(){
										swal("Oops!","{{ $errors->first('quote_email') }}","error")
										.then((value) => {
											window.location.href="https://printedcart.com/printedcart/home#request-a-quote";
										});
									});
									</script>
								@endif
							</div>
						</div>
						<div class="form-row mb-3">
							<div class="col-12 col-sm-6 mb-3">
								<input type="text" name="phone" required='true' class="form-control border-0 rounded-0" placeholder="Phone" maxLength="10" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
								@if($errors->has('phone'))
									<!--<p class="help-block">
										{{ $errors->first('phone') }}
									</p>-->
									<script>
									$(function(){
										swal("Oops!","{{ $errors->first('phone') }}","error")
										.then((value) => {
											window.location.href="https://printedcart.com/printedcart/home#request-a-quote";
										});
									});
									</script>
								@endif
							</div>
							<div class="col-12 col-sm-6">
								<input type="text" name="product" class="form-control border-0 rounded-0" placeholder="Product of interest">
							</div>
						</div>
						<div class="form-group">
							<textarea class="form-control border-0 rounded-0" placeholder="Massage" id="exampleFormControlTextarea1" name="message" required='true' rows="3"></textarea>
							@if($errors->has('message'))
								<!--<p class="help-block">
									{{ $errors->first('message') }}
								</p>-->
								<script>
								$(function(){
									swal("Oops!","{{ $errors->first('message') }}","error")
									.then((value) => {
										window.location.href="https://printedcart.com/printedcart/home#request-a-quote";
									});
								});
								</script>
							@endif
						</div>	
						<button id="quoteBtn" class="btn btn-primary text-uppercase border-0 rounded-0" type="submit">Contact</button>
					{!! Form::close() !!}
				</div>
			</div>
			<!-- request-form-section end -->
		</div>
	</div>
</section>
<!-- testimonial-form-section end -->
<script type = "text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type = "text/javascript">
function ValidateEmail(email) {
	var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	return expr.test(email);
};
var j = $.noConflict();
j("#quoteBtn").live("click", function (){
	if($("#quoteForm input[name=name]").val() == ''){
		swal("Oops!","Name field can not be empty!","error")
		.then((value) => {
			window.location.href="https://printedcart.com/printedcart/home#request-a-quote";
		});
	}else if(!ValidateEmail($("#quote_email").val())){
		//alert("Invalid email address.");
		swal("Oops!","Invalid email address.","error")
		.then((value) => {
			window.location.href="https://printedcart.com/printedcart/home#request-a-quote";
		});
		return false;
	}else if($("#quoteForm input[name=phone]").val() == ''){
		swal("Oops!","Phone field can not be empty!","error")
		.then((value) => {
			window.location.href="https://printedcart.com/printedcart/home#request-a-quote";
		});
	}else if($("#quoteForm textarea[name=message]").val() == ''){
		swal("Oops!","Message field can not be empty!","error")
		.then((value) => {
			window.location.href="https://printedcart.com/printedcart/home#request-a-quote";
		});
	}else{
		swal("Please Wait...!","Data Processing...!","warning")
	}	
});
</script>

<style>
.help-block{color:red;}
</style>
@endsection