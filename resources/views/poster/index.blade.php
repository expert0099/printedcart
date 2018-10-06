@extends("layouts.home")

@section("main-content")

<div class="container">

	@include('poster.banner')

	<!-- New Easel Calendars section Start -->
	<section class="new-easel-section m-80">
		<h1 class="text-center d-block">Posters</h1>
		<span class="text-center d-block font-weight-light">Dress up your desk with a fresh look each month.</span>
		<div class="row position-relative mt-5">
			<div class="col-12 col-lg-9">
				<div class="print-poster-price-box">
					<div class="easel-info">
						<p class="fz-24 font-weight-light mb-0"><b>Leave the best Impression</b> </p>
						<p class="fz-16 mb-3" style="text-align:justify;">Create your favorite memories into the lasting impression in the form of photo frame poster prints</p>
						<ul class="pl-3 text-blue mb-4 mt-5">
							<li class="mb-0"><p class="fz-14 mb-2" style="text-align:justify;">Frames are available in 11x14, 16x20 and 20x30 posters.</p></li>
							<li class="mb-0"><p class="fz-14 mb-2" style="text-align:justify;">We user Fuji Crystal Archive professional-grade paper for brighter colors and sharper whites.</p></li>
							<li class="mb-0"><p class="fz-14 mb-2" style="text-align:justify;">You get to choose from matte, glossy or our brand-new pearl finish.</p></li>
							<li class="mb-0"><p class="fz-14 mb-2" style="text-align:justify;">Also rotate your frame, crop it or add classic black/white borders to make it more attractive!.</p></li>
						</ul>									
						<a href="{{URL::asset('calendars/collage_posters')}}"><button type="submit" class="btn btn-primary border-0 rounded-0 fz-24 font-weight-light px-4 mt-4">Get Started <i class="fa fa-caret-right ml-2" aria-hidden="true"></i></button></a>
					</div>	
				</div>
			</div>
			<div class="easel-cal-img px-3 px-xl-0 text-center mt-3 mt-xl-0"><img class="img-fluid" src="{{URL::asset('public/images/print-poster-img2.jpg')}}" alt="easel-calendar" style="width:640px;padding-top:0px;"></div>
		</div>
	</section>
	<!-- New Easel Calendars section end -->

	<!-- Calendar shop section start -->
	<section class="calendar-shop-section">
		<h1 class="text-center d-block">Calendars made for every space</h1>
		<span class="text-center d-block font-weight-light">Keep a record of your important days and dates from any corner of your house or workplace</span>
		<div class="row mt-5">
			@foreach($cal_cat as $k => $v)
			<div class="col-sm-6 col-lg-3 mb-4 mb-lg-0">
				<div class="card border-0 rounded-0">
					<div class="product-bg-img"><div class="product-bg-child" style="background-image: url({!! $v['calendar_image_path'] !!});"></div></div>
					<div class="card-body pl-0">
						<h4 class="card-title font-weight-normal"><a href="#">{!! $v['calendar_category'] !!}</a></h4>
						<p class="card-text">{!! $v['content'] !!}</p>
						<span class="text-blue font-weight-bold fz-18 d-block mb-2">{!! $default_currency['currencysymbol'] !!}{!! $v['Size']['price'] !!} </span>
						@if($v['calendar_category']=='Wall Calendars' || $v['calendar_category']=='Desk Calendars')
							<a href="{{URL::asset('calendars')}}" class="btn btn-primary fz-18 font-weight-light border-0 rounded-0 px-3">Shop Now</a>
						@else
							<a href="{{URL::asset('calendars/'.strtolower(str_replace(' ','_',$v['calendar_category'])))}}" class="btn btn-primary fz-18 font-weight-light border-0 rounded-0 px-3">Shop Now</a>
						@endif
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</section>
	<!-- Calendar shop section end -->

	<!-- Calander Page Info Start -->
	<!--<section class="clander-page-info pt-5 mt-5 mb-3">
		<div class="row">
			<div class="col-12">
				<h5 class="text-blue">Announce your news with personalised posters </h5>
				<p class="fz-14 mb-4">Whether you’re trying to message customers, employees or guests at an event, custom posters are a great way to stand out. Thousands of specialized templates mean that you can create a professional-looking design in seconds. And a huge variety of sizes lets you take advantage of almost any open space.</p>
			</div>
		</div>
	</section>-->
	<!-- Calander Page Info End -->
</div>
@endsection