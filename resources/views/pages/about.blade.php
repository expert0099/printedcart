@extends("layouts.home")

@section("main-content")

<div class="container">

	@include('pages.banner_about')

	<!-- Calander Page Info Start -->
	<section class="clander-page-info pt-5 mt-5 mb-3">
		<div class="row">
			<div class="col-12">
				<!--<h5 class="text-blue">About Us</h5>-->
				<!--<p class="fz-14 mb-4"></p>-->
				{!! $about_content['page_content'] !!}
			</div>
		</div>
	</section>
	<!-- Calander Page Info End -->
	
</div>
@endsection