@extends("layouts.photobook")

@section("main-content")

<div class="continer-fluid">
	
	<section class="simple_path_header_img">
		<div class="container">
			<div class="header_img">
				<!--<div class="content">
					<div class="content-mid">
						<h3>Save 50%<br>on everything</h3>
						<h4>Code:<strong>HAPPYSPRING</strong>Ends Wed, Mar 28</h4>
						<a href="#">See offer details</a>
					</div>
				</div>-->
				<img src="{{URL::asset('public/images/inner-page-header.jpg')}}">
			</div>
		</div>
	</section>
	
	@include('photobook.size_crowsel_simple_path')
	
</div>

<div class="container">
	<div class="row pt-2 pt-md-5 page-top-gapping">
		<div class="col-lg-12 pt-0 mt-0 simple-path-one">
			<div class="col-md-12 col-lg-5">
				<div class="impect-img">
					<img class="img-fluid" src="{{URL::asset('public/images/simple-path-pic1.jpg')}}">
				</div>
			</div>
            <div class="col-md-12 col-lg-7">
            	<div class="text">
					<h3>Created in moments</h3>
					<ul>
						<li style="text-align:justify;">we create your photobooks in moments to turn it into most memorable moments of your life with our latest technology and customizable tool.</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="row pt-2 pt-md-5 page-top-gapping">
		<div class="col-lg-12 pt-0 mt-0 simple-path-one">
			<div class="col-md-12 col-lg-5">
				<div class="impect-img">
					<img class="img-fluid" src="{{URL::asset('public/images/big-impect.jpg')}}" >
				</div>
			</div>
            <div class="col-md-12 col-lg-7">
				<div class="text">
					<h3>Make a big impact with layflat pages</h3>
					<h4>Deluxe layflat pages</h4>
					<ul>
						<li style="text-align:justify;">We use pages lay flat for a supreme & seamless display, double thick & satin-finish paper which are best suited fro family photo-book, wedding, baby-shower or for any special event. </li>
					</ul>
					<h4>Standard layflat pages</h4>
					<ul>
						<li style="text-align:justify;">at printedcart.com we use pages lay flat with standard matte-finish paper with hinged binding procedure. This could be perfect for family, baby-shower, travel and any type of occasion’s photo books.</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="row pt-5">
		<div class="col-md-12 col-lg-6">
			<div class="photobook-coverd-section pr-5">
				<h1>We've got you covered</h1>
				<h4 class="fz-22 font-weight-light mb-5">Find the perfect cover for your photo book</h4>
				<p class="m-0"><b>Hard Photo Cover with Glossy Finish</b></p>
				<span class="fz-14 font-weight-light mb-2 d-block" style="text-align:justify;">Get the Resilient glossy laminate for your photos on front and back. Text on cover and spine.</span>
				<p class="m-0"><b>Hard Photo Cover with Matte Finish</b></p>
				<span class="fz-14 font-weight-light mb-2 d-block" style="text-align:justify;">Scratch-resistant matte laminate for your photo books on front and rare. Text on cover and spine.</span>
				<p class="m-0"><b>Die-cut Cover with Cloth or Leather</b></p>
				<span class="fz-14 font-weight-light mb-2 d-block" style="text-align:justify;">You will get High-quality fabric or leather with a large die-cut window for your favorite photo. Available in black or brown leather, black or brown cloth, and white linen.</span>	
				<p class="m-0"><b>Premium Leather Cover</b></p>
				<span class="fz-14 font-weight-light mb-2 d-block" style="text-align:justify;">Genuine high-quality leather with stitched edges.</span>		
				<p class="m-0"><b>Premium Crushed Silk Cover</b></p>
				<span class="fz-14 font-weight-light mb-2 d-block" style="text-align:justify;">Our crushed silk cover gives a beautiful finishing touch to your photo book — designed especially for wedding albums.</span>
			</div>
		</div>
		<div class="col-md-12 col-lg-6">
			<div class="photobook-coverd-img pt-5">
				<img class="img-fluid" src="{{URL::asset('public/images/simple-path-pic2.jpg')}}" alt="big-impect-img">
			</div>
		</div>
	</div>
	<div class="see-price-details">
		<div class="col-12 text-center mt-4">
			<a href="{{URL::asset('photobooks/shipping_price')}}" class="btn btn-primary border-0 rounded-0 px-4 text-white">See shipping pricing</a>
		</div>
	</div>
</div>


@endsection