@extends("layouts.home")

@section("main-content")

<div class="container">

	@include('print.banner')

	<!-- Large format print section Start -->
	<section class="new-easel-section m-80">
		<!--<h1 class="text-center d-block">Print</h1>
		<span class="text-center d-block font-weight-light">Print your family adventures.</span>-->
		<div class="row position-relative mt-5">
			<div class="col-12 col-lg-9">
				<div class="print-poster-price-box">
					<div class="easel-info">
						<p class="fz-24 font-weight-light mb-0"><b>Large Format Print</b></p>
						<p class="fz-16 mb-3" style="text-align:justify;">Create your favorite memories into the lasting impression in the form of photo frame poster prints</p>
						<ul class="pl-3 text-blue mb-4 mt-5">
							<li class="mb-0"><p class="fz-14 mb-2" style="text-align:justify;">Frames are available in 11x14, 12x12, 16x20 and 20x30 posters.</p></li>
							<li class="mb-0"><p class="fz-14 mb-2" style="text-align:justify;">Printed on Epson Stylus Professional Media for sharper whites and brighter colors.</p></li>
						</ul>									
						<a href="{{URL::asset('prints/large_format_print')}}"><button type="submit" class="btn btn-primary border-0 rounded-0 fz-24 font-weight-light px-4 mt-4">Get Started <i class="fa fa-caret-right ml-2" aria-hidden="true"></i></button></a>
					</div>	
				</div>
			</div>
			<div class="easel-cal-img px-3 px-xl-0 text-center mt-3 mt-xl-0"><img class="img-fluid" src="{{URL::asset('public/images/print-poster-img2.jpg')}}" alt="easel-calendar" style="width:640px;padding-top:0px;"></div>
		</div>
	</section>
	<!-- Large format print section end -->

	<!-- College poster section Start -->
	<section class="new-easel-section m-80">
		<!--<h1 class="text-center d-block">Print</h1>
		<span class="text-center d-block font-weight-light">Print your family adventures.</span>-->
		<div class="row position-relative mt-5">
			<div class="col-12 col-lg-9">
				<div class="print-poster-price-box">
					<div class="easel-info">
						<p class="fz-24 font-weight-light mb-0"><b>College Poster</b></p>
						<p class="fz-16 mb-3" style="text-align:justify;">Create your favorite memories into the lasting impression in the form of photo frame poster prints</p>
						<ul class="pl-3 text-blue mb-4 mt-5">
							<li class="mb-0"><p class="fz-14 mb-2" style="text-align:justify;">Frames are available in 8x8, 12x12, 8x10, 11x14, 16x20 and 20x30 posters.</p></li>
							<li class="mb-0"><p class="fz-14 mb-2" style="text-align:justify;">Printed on Epson Stylus Professional Media for sharper whites and brighter colors.</p></li>
						</ul>									
						<a href="{{URL::asset('prints/college_poster')}}"><button type="submit" class="btn btn-primary border-0 rounded-0 fz-24 font-weight-light px-4 mt-4">Get Started <i class="fa fa-caret-right ml-2" aria-hidden="true"></i></button></a>
					</div>	
				</div>
			</div>
			<div class="easel-cal-img px-3 px-xl-0 text-center mt-3 mt-xl-0"><img class="img-fluid" src="{{URL::asset('public/images/easel-calender.png')}}" alt="easel-calendar" style="width:525px;padding-top:0px;"></div>
		</div>
	</section>
	<!-- College poster section end -->
	
</div>
@endsection