<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Printedcart: Share site</title>
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/sharesite/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/sharesite/custom.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/sharesite/sharesite.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/sharesite/font-awesome.min.css') }}">
		
		<!-- Bootstrap Script -->
		<script type="text/javascript" src="{{ URL::asset('public/js/sharesite/jquery-3.2.1.slim.min.js') }}"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script type="text/javascript" src="{{ URL::asset('public/js/sharesite/owl.carousel.min.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('public/js/sharesite/popper.min.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('public/js/sharesite/bootstrap.min.js') }}"></script>
		
		<script type="text/javascript">
		jQuery(document).ready(function(jQuery){
			var owl = jQuery("#owl-demo-2");
			owl.owlCarousel({
				items : 3, 
				itemsDesktop : [992,3],
				itemsDesktopSmall : [768,2], 
				itemsTablet: [480,2], 
				itemsMobile : [320,1]
			});
			jQuery(".next").click(function(){ owl.trigger('owl.next'); });
			jQuery(".prev").click(function(){ owl.trigger('owl.prev'); });
			jQuery('.latest-blog-posts .thumbnail.item').matchHeight();
			
		});
		</script>
    </head>
	
	<body>
		<header>
			@include('layouts.partials.subdomain_header')
		</header>
		
		@yield('main-content')

	</body>
	
</html>