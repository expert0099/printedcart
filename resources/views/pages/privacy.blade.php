@extends("layouts.home")

@section("main-content")

<div class="container">

	@include('pages.banner')

	<!-- New Easel Calendars section Start -->
	<section class="new-easel-section m-100">
		<h2 class="text-center d-block">Simply put, we provide you with top-quality <br/>printed products at affordable prices.</h2>
		<div class="row position-relative mt-5">
			<div class="col-12 col-lg-9">
				<div class="easel-calendar-price-box">
					<div class="easel-info">
						<p class="fz-24 font-weight-light">Choose from many chic designs.</p>
						<p class="fz-24 font-weight-light">Pick horizontal or vertical layouts. square or rounded corners.</p>
						<p class="fz-24 font-weight-light">Printed on 5x7 matte cardstock.</p>
						<p class="fz-24 font-weight-light">Ready to display on a sleek bamboo stand.</p>
						<p class="fz-24 font-weight-light">Gift box available.</p>
						<p class="fz-24 font-weight-light"><span class="text-blue">From $27.99</span></p>	
						<button type="submit" class="btn btn-primary border-0 rounded-0 fz-24 font-weight-light px-4">Shop easel calendars
						<i class="fa fa-caret-right ml-2" aria-hidden="true"></i></button>
					</div>	
				</div>
			</div>
			<div class="easel-cal-img px-3 px-xl-0 text-center mt-3 mt-xl-0"><img class="img-fluid" src="{{URL::asset('public/images/easel-calender.png')}}" alt="easel-calendar"></div>
		</div>
	</section>
	<!-- New Easel Calendars section end -->

	<!-- Calendar shop section start -->
	<section class="calendar-shop-section">
		<h1 class="text-center d-block">Calendars for every space</h1>
		<span class="text-center d-block font-weight-light">From cubicles to kitchens, keep track of important dates wherever you are</span>
		<div class="row mt-5">
			<div class="col-sm-6 col-lg-3 mb-4 mb-lg-0">
				<div class="card border-0 rounded-0">
					<div class="product-bg-img"><div class="product-bg-child" style="background-image: url({{URL::asset('public/images/product1.jpg')}});"></div></div>
					<div class="card-body pl-0">
						<h4 class="card-title font-weight-normal"><a href="#">Easel Calendars</a></h4>
						<p class="card-text">Dress up your desk with a fresh look each month. </p>
						<span class="text-blue font-weight-bold fz-18 d-block mb-2">$24.99 </span>
						<a href="#" class="btn btn-primary fz-18 font-weight-light border-0 rounded-0 px-3">Shop Now</a>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-lg-3 mb-4 mb-lg-0">
				<div class="card border-0 rounded-0">
					<div class="product-bg-img"><div class="product-bg-child" style="background-image: url({{URL::asset('public/images/product2.jpg')}});"></div></div>
					<div class="card-body pl-0">
						<h4 class="card-title font-weight-normal"><a href="#">Desk Calendars</a></h4>
						<p class="card-text">With built-in easel for display.</p>
						<span class="text-blue font-weight-bold fz-18 d-block mb-2">$19.99 </span>
						<a href="#" class="btn btn-primary fz-18 font-weight-light border-0 rounded-0 px-3">Shop Now</a>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-lg-3 mb-4 mb-lg-0">
				<div class="card border-0 rounded-0">
					<div class="product-bg-img"><div class="product-bg-child" style="background-image: url({{URL::asset('public/images/product3.jpg')}});"></div></div>
					<div class="card-body pl-0">
						<h4 class="card-title font-weight-normal"><a href="#">Calendar Posters</a></h4>
						<p class="card-text">View the year at a glance.</p>
						<span class="text-blue font-weight-bold fz-18 d-block mb-2">$22.99 </span>
						<a href="#" class="btn btn-primary fz-18 font-weight-light border-0 rounded-0 px-3">Shop Now</a>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-lg-3 mb-4 mb-lg-0">
				<div class="card border-0 rounded-0">
					<div class="product-bg-img"><div class="product-bg-child" style="background-image: url({{URL::asset('public/images/product4.jpg')}});"></div></div>
					<div class="card-body pl-0">
						<h4 class="card-title font-weight-normal"><a href="#">More Calendars</a></h4>
						<p class="card-text">Keep important dates close at hand.</p>
						<span class="text-blue font-weight-bold fz-18 d-block mb-2">$12.99 </span>
						<a href="#" class="btn btn-primary fz-18 font-weight-light border-0 rounded-0 px-3">Shop Now</a>
					</div>
				</div>
			</div>						
		</div>
	</section>
	<!-- Calendar shop section end -->

	<!-- Calander Page Info Start -->
	<section class="clander-page-info pt-5 mt-5 mb-3">
		<div class="row">
			<div class="col-12">
				<h5 class="text-blue">Design Your Own Personalized Calendar</h5>
				<p class="fz-14 mb-4">When it comes to thoughtful gift giving, Shutterfly has the best option for you. So whether you are looking for the perfect custom gift this holiday or birthday season, or looking for the cutest way to showcase your favorite photos of the kiddos, we’ve got you covered. This year, instead of a photo in a frame turn your notable images into a one-of-a-kind calendar from Shutterfly and feature your best pictures.</p>
				<h5 class="text-blue">Gathering the Images for Your Custom Calendar</h5>
				<p class="fz-14 mb-4">When designing a calendar with Shutterfly, your options are endless. You can take the pictures you have of the kids from each season, or plan a special photo shoot to capture their shining faces in themed moments for each month. Dress the little ones up in snow gear for January, red and pink loved-themed outfits for February and green sweaters and hats for March. It's easy and fun to brainstorm a fashion show for each month. Get them in on the fun and let them plan their special outfits for their very own month-by-month photo shoot.</p>
				<h5 class="text-blue">Designing Your Unique Calendar</h5>
				<p class="fz-14 mb-4">Once you have the images ready to upload, it's easier than ever to place them into Shutterfly's easy-to-use templates. You can start your calendar in any month. No longer do you have to worry about wasting months (or money) on pages you won't get to enjoy.</p>
				<p class="fz-14 mb-4">With Shutterfly, when you design your calendar you can choose between 8x11 or 12x12 for a calendar size you will truly love. Once you hammer out the finer details, like what month to start in and what size, you can easily upload your photographs into the month-by-month templates. Shutterfly has over 40 different themes to help you create a custom calendar that reflects your unique style.</p>
				<h5 class="text-blue">Great Photo Gifts</h5>
				<p class="fz-14 mb-4">Shutterfly has plenty of other options to create unique photo gifts for those you cherish most. Keep the ones you love warm and snug in a cozy fleece photo blanket. For the coffee lover in your life, warm them from the inside out with a custom photo mug. They can greet every day with a photograph of the one they love most. Shutterfly has the perfect photo gift for every occasion.</p>
				<p class="fz-14 mb-4">This year, take your favorite photographs of the kids and turn those images into a custom calendar. Shutterfly has everything you need to create unique photo gifts, from calendars to blankets. Create a custom calendar and bring your favorite photos to life!</p>
			</div>
		</div>
	</section>
	<!-- Calander Page Info End -->
</div>
@endsection