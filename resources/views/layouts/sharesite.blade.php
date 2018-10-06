<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>PrintedCart: Share site</title>
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/sharesite/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/sharesite/custom.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/custom.css') }}">
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
				responsiveClass:true,
				responsive:{
					0:{
						items:1,
						nav:true
					},
					600:{
						items:2,
						nav:false
					},
					1000:{
						items:3,
						nav:true,
						loop:false
					}
				}
			});
			jQuery(".next").click(function(){ owl.trigger('owl.next'); });
			jQuery(".prev").click(function(){ owl.trigger('owl.prev'); });
			jQuery('.latest-blog-posts .thumbnail.item').matchHeight();
			
		});
		</script>
    </head>
	<!-- model -->
	<div id="signout_idDialog" title="Sign Out" style="display:none;">
		<div class="row">
			<div class="col-sm-12 form-group">
				<h2>You still have products in your shopping cart!</h2>
				<div class="go_cart"><a href="{{ URL::asset('payments/cart') }}"><button class="btn btn-primary">Go to Cart</button></a></div>
				<div class="sign_out"><a href="{{ URL::asset('user/logout') }}"><button class="btn btn-primary">Sign Out</button></a></div>
			</div>
		</div>
	</div>
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
	<script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>
	<script>
	$(function(){
		$("#signout_idDialog").dialog({
			autoOpen: false,
			width: $(window).width() > 500 ? 500 : 'auto',
			height: 'auto',
			fluid: true,
			responsive: true,
			show: {
				duration: 1000
			},
			hide: {
				duration: 1000
			}
		});
		$( "#signout_id" ).on( "click", function() {
			$("#signout_idDialog").dialog( "open" );
		});
	});
	</script>
	<body>
		<header>
			@include('layouts.partials.sharesite_header')
		</header>
		
		@yield('main-content')

		<footer>
		@include('layouts.partials.footer')
		</footer>
	</body>
	
</html>