@extends("layouts.photobook")

@section("main-content")

<div class="container">

	@include('photobook.banner')

	<!-- Three great ways to make your book start -->
	<section class="three-way-sec-container pb-5">
		<div class="container">
			<div class="row m-0">
				<div class="col-md-12 col-lg-4 mt-5">
					<div class="card text-center rounded-0 border-0">
						<div class="card-header bg-blue rounded-0 text-white text-uppercase fz-24 font-weight-light">We'll make it for you</div>
						<div class="card-body bg-white">
							<h4 class="text-blue font-weight-light mt-2">Make My Book Service </h4>
							<p style="text-align:justify;">Our creative team will manipulate your photos and create a masterpiece for you in the form of photo book.</p>
							<img class="img-fluid my-3" src="{{URL::asset('public/images/book1.png')}}" alt="photo-book">
							<ul class="pl-3 text-blue m-0 text-left">
								<li><p class="fz-14 m-2" style="text-align:justify;">We have the best creative team with an immense potential to deliver awesome photo book specially designed for you! Select your size & template, upload your photos, we will deliver the unique model to you on time.</p></li>
							</ul>
							<a href="{{URL::asset('photobooks/make_my_book')}}">
							<button type="submit" class="btn btn-primary border-0 rounded-0 mt-4 px-4 fz-18">Make My Book Service
								<i class="fa fa-caret-right ml-2" aria-hidden="true"></i>
							</button>
							</a>
						</div>
					</div>				
				</div>
				<div class="col-md-12 col-lg-8 mt-5">
					<div class="card text-center rounded-0 border-0">
						<div class="card-header bg-blue rounded-0 text-white text-uppercase fz-24 font-weight-light">Make it yourself</div>
						<div class="row">
							<div class="col-md-6">
								<div class="card-body bg-white">
									<h4 class="text-blue font-weight-light mt-2">Custom Path</h4>
									<p style="text-align:justify;">Customize your every page with its each aspect.</p>
									<img class="img-fluid my-3" src="{{URL::asset('public/images/custom-book1.jpg')}}" alt="photo-book">
									<ul class="pl-3 text-blue m-0 text-left">
										<li><p class="fz-14 m-2" style="text-align:justify;">Add, move or resize your pictures and text anywhere with the help of our latest customization tool and our wide-ranging collection of backgrounds as well as layouts and add-ons.</p></li>
										<li><p class="fz-14 m-2" style="text-align:justify;">1-30 pictures per page (up to 1000 pictures)</p></li>
										<li><p class="fz-14 m-2" style="text-align:justify;">Six sizes From $15.99.</p></li>	
									</ul>
									<a href="{{URL::asset('photobooks/custom_path')}}"><button type="submit" class="btn btn-primary border-0 rounded-0 mt-4 px-4 fz-18 w-255">Custom Path <i class="fa fa-caret-right ml-2" aria-hidden="true"></i></button></a>
								</div>
							</div>
							<div class="col-md-6">
								<div class="card-body bg-white mt-5 mt-md-0">
									<h4 class="text-blue font-weight-light mt-2">Easy Path</h4>
									<p style="text-align:justify;">Gather your favorite photos and get your design instantly with ease.</p>
									<img class="img-fluid my-3" src="{{URL::asset('public/images/book3.png')}}" alt="photo-book">
									<ul class="pl-3 text-blue m-0 text-left">
										<li><p class="fz-14 m-2" style="text-align:justify;">Our automated system will arrange your photos in best possible way for you and you can also rearrange the photos at your convenience with relevant captions. You can get more than 40 styles with preset layouts and backgrounds.</p></li>
										<li><p class="fz-14 m-2" style="text-align:justify;">1-30 pictures per page (up to 1000 pictures)</p></li>
										<li><p class="fz-14 m-2" style="text-align:justify;">Six sizes From $15.99.</p></li>
									</ul>
									<a href="{{URL::asset('photobooks/simple_path')}}">
									<button type="submit" class="btn btn-primary border-0 rounded-0 mt-4 px-4 fz-18 w-255">Easy Path <i class="fa fa-caret-right ml-2" aria-hidden="true"></i></button></a>
								</div>
							</div>				
						</div>
					</div>					
				</div>
			</div>
		</div>
	</section>
	<!-- Three great ways to make your book end -->

	<!-- make-your-book-section start -->
	<section class="make-your-book-section py-5 my-5">
		<div class="container">
			<div class="row position-relative">
				<div class="make-photo-img px-3 px-xl-0 text-center mt-3 mt-xl-0"><img class="img-fluid" src="{{URL::asset('public/images/make-photo.jpg')}}" alt="make-photo"></div>
				<div class="col-12 col-lg-12 col-xl-8 ml-auto">
					<div class="make-photo-text">
						<h3 class="mb-5" style="text-align:justify;">Customize you photo book at ease</h3>
						<ul class="pl-5">
							<li class="position-relative font-weight-light mb-4"><p style="text-align:justify;">Customize your photos with our artificial – intelligent auto-fill peace.</p></li>
							<li class="position-relative font-weight-light mb-4"><p style="text-align:justify;">Photos are automatically arranged with elegance in right order. Edit your photos with our cool drag & drop feature and also to add new photos, move or resize photos as well as text.</p></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- make-your-book-section end -->

	<!-- your-book-sec-circle start -->
	<!--<section class="your-book-sec-circle container-fluid p-0 bg-blue py-5">
		<div class="container">
			<div class="book-circle-holder text-center">
				<h1 class="text-white">Your book, your way</h1>
				<p class="text-white font-weight-light">Personalize your photo book with a range of styles<br> for every occasion and custom features.</p>
				<div class="row mt-5">
					<div class="col-lg-6 col-xl-4 mb-4 mb-lg-0">
						<div class="your-book-img rounded-circle position-relative m-auto">
							<img class="img-fluid" src="{{URL::asset('public/images/y-book1.jpg')}}" alt="your-book-img">
							<div class="book-box-one">
								<h6>Customize your layout</h6>
								<p class="fz-14 font-weight-light">Move and resize photos and add<br> text anywhere</p>
							</div>
							<div class="book-box-two">
								<h6>Pre-designed Idea Pages</h6>
								<p class="fz-14 font-weight-light">Inspire your storytelling</p>
							</div>												
						</div>
					</div>
					<div class="col-lg-6 col-xl-4 mb-4 mb-lg-0">
						<div class="your-book-img rounded-circle position-relative m-auto">
							<img class="img-fluid" src="{{URL::asset('public/images/y-book2.jpg')}}" alt="your-book-img">
							<div class="book-box-three">
								<h6>New Spanish character<br>customization.</h6>
								<p class="fz-14 font-weight-light">Personalize en español your most<br>cherished moments.</p>
							</div>										
						</div>
					</div>
					<div class="col-lg-12 col-xl-4">
						<div class="your-book-img rounded-circle position-relative m-auto">
							<img class="img-fluid" src="{{URL::asset('public/images/y-book3.jpg')}}" alt="your-book-img">
							<div class="book-box-four">
								<h6>Have fun with<br>stylish embellishments</h6>
							</div>										
						</div>
					</div>				
				</div>
			</div>
		</div>
	</section>-->
	<!-- your-book-sec-circle end -->

	<!-- photobook-big-impect start -->
	<section class="photobook-big-impect my-5">
		<div class="container py-5">
			<h1 class="text-center d-block mb-5">Make a big impact with layflat pages</h1>
			<div class="row impect-border pb-5 pb-lg-4">
				<div class="col-md-12 col-lg-7">
					<div class="impect-img">
						<img class="img-fluid" src="{{URL::asset('public/images/big-impect.jpg')}}" alt="big-impect-img">
					</div>
				</div>
				<div class="col-md-12 col-lg-4">
					<div class="impect-right-text pt-5">
						<h4 class="mb-3">Deluxe layflat pages</h4>
						<ul class="pl-3 text-blue mb-5">
							<li class="mb-1 font-weight-light"><p class="fz-16 m-0" style="text-align:justify;">We use pages lay flat for a supreme & seamless display, double thick & satin-finish paper which are best suited fro family photo-book, wedding, baby-shower or for any special event. 
							</p></li>
						</ul>
						<h4 class="mb-3 pt-3">Standard layflat pages</h4>
						<ul class="pl-3 text-blue m-0">
							<li class="mb-1 font-weight-light"><p class="fz-16 m-0" style="text-align:justify;">at printedcart.com we use pages lay flat with standard matte-finish paper with hinged binding procedure. This could be perfect for family, baby-shower, travel and any type of occasion’s photo books.
							</p></li>
						</ul>											
					</div>
				</div>
			</div>
			<div class="row pt-5">
				<div class="col-md-12 col-lg-6">
					<div class="photobook-coverd-section pr-5">
						<h1>We've got you covered</h1>
						<h4 class="fz-22 font-weight-light mb-5" style="text-align:justify;">Find the perfect cover for your photo book</h4>
						<p class="m-0" style="text-align:justify;"><b>Hard Photo Cover with Glossy Finish</b></p>
						<span class="fz-14 font-weight-light mb-2 d-block" style="text-align:justify;">Get the Resilient glossy laminate for your photos on front and back. Text on cover and spine.</span>
						<p class="m-0" style="text-align:justify;"><b>Hard Photo Cover with Matte Finish</b></p>
						<span class="fz-14 font-weight-light mb-2 d-block" style="text-align:justify;">Scratch-resistant matte laminate for your photo books on front and rare. Text on cover and spine.</span>
						<p class="m-0" style="text-align:justify;"><b>Die-cut Cover with Cloth or Leather</b></p>
						<span class="fz-14 font-weight-light mb-2 d-block" style="text-align:justify;">You will get High-quality fabric or leather with a large die-cut window for your favorite photo. Available in black or brown leather, black or brown cloth, and white linen.</span>	
						<p class="m-0" style="text-align:justify;"><b>Premium Leather Cover</b></p>
						<span class="fz-14 font-weight-light mb-2 d-block" style="text-align:justify;">Genuine high-quality leather with stitched edges.</span>		
						<p class="m-0" style="text-align:justify;"><b>Premium Crushed Silk Cover</b></p>
						<span class="fz-14 font-weight-light mb-2 d-block" style="text-align:justify;">Our crushed silk cover gives a beautiful finishing touch to your photo book — designed especially for wedding albums.</span>
					</div>
				</div>
				<div class="col-md-12 col-lg-6">
					<div class="photobook-coverd-img pt-5">
						<img class="img-fluid" src="{{URL::asset('public/images/photobook-coverd.jpg')}}" alt="big-impect-img">
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- photobook-big-impect end -->

	<!-- finishing touch section start -->
	<section class="finishing-touch-section container-fluid px-0 py-5">
		<div class="container">
			<h1 class="text-center d-block mb-3">Finishing touches</h1>
			<h5 class="text-center d-block font-weight-light">It's all in the details</h5>
			<div class="row py-5">
				<div class="col-md-12 col-lg-6 mb-5 mb-lg-0">
					<div class="finishing-left-box d-inline-block w-100 position-relative">
						<img class="img-fluid float-right" src="{{URL::asset('public/images/finishing-left.jpg')}}" alt="Finishing-touches">
						<div class="finishing-left-content text-center">
							<h6 class="m-0">Add a gift box</h6>
							<p class="fz-14 m-0">We've got many different <br>box designs.</p>
						</div>					
					</div>
				</div>
				<div class="col-md-12 col-lg-6">
					<div class="finishing-right-box d-inline-block w-100 position-relative">
						<img class="img-fluid float-left" src="{{URL::asset('public/images/finishing-right.jpg')}}" alt="Finishing-touches">
						<div class="finishing-right-content text-center">
							<h6 class="m-0">Dust Jackets</h6>
							<p class="fz-14 m-0">Protect your photo books<br>from cover to cover.</p>
						</div>					
					</div>
				</div>			
			</div>
			<div class="row"><div class="col-12 text-center"><p class="fz-14 font-weight-light m-0">Made and printed in the U.S. with the highest quality of paper and printing</p></div></div>
		</div>
	</section>
	<!-- finishing touch section end -->
</div>
@endsection