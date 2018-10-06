@extends("layouts.home")

@section("main-content")

<div class="container">	
	<?php //echo $page_slug;exit;?>
	@if($page_slug == 'customer_service')		
		@include('pages.banner_customer_service')	
	@elseif($page_slug == 'how_to_upload')		
		@include('pages.banner_how_to_upload')	
	@elseif($page_slug == '100_happiness_guaranteed')		
		@include('pages.banner_100_satisfaction_guarantee')	
	@elseif($page_slug == 'shipping')
		@include('pages.banner_shipping')
	@elseif($page_slug == 'contributing_photographers')
		@include('pages.banner_contributing_photographers')
	@elseif($page_slug == 'idea_inspiration')
		@include('pages.banner_idea_inspiration');
	@elseif($page_slug == 'blog')
		@include('pages.banner_blog')
	@elseif($page_slug == 'printedcart')
		@include('pages.banner_printedcart')
	@elseif($page_slug == 'invester_relations')
		@include('pages.banner_invester_relations')
	@elseif($page_slug == 'business_solutions')
		@include('pages.banner_business_solutions')
	@else		
		@include('pages.banner')	
	@endif
	<!-- Calander Page Info Start -->
	<section class="clander-page-info pt-5 mt-5 mb-3">
		<div class="row">
			<div class="col-12">
				<h5 class="text-blue">{!! $page_content['page_name'] !!}</h5>
				<p class="fz-14 mb-4">{!! $page_content['page_content'] !!}</p>
			</div>
		</div>
	</section>
	<!-- Calander Page Info End -->
	
</div>
@endsection