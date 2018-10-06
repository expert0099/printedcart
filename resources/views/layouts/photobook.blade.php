<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="_token" content="{{ csrf_token() }}" />
		<title>
		@if(Request::segment(1)=='user')
			My PrintedCart
		@else
			PrintedCart: Shop
		@endif
		</title>
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/custom.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/font-awesome.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/owl.carousel.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/common-page.css') }}">
		
		<!-- Bootstrap Script -->
		<script type="text/javascript" src="{{ URL::asset('public/js/jquery-3.2.1.slim.min.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('public/js/popper.min.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('public/js/bootstrap.min.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('public/js/jquery-1.12.4.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('public/js/owl.carousel.min.js') }}"></script>
		<script type="text/javascript">
	    $(document).ready(function() {
			$("#owl-demo").owlCarousel({
				items : 6, //10 items above 1000px browser width       
				nav : true,
				navText : ["<",">"],
				itemsMobile : false, // itemsMobile disabled - inherit from itemsTablet option
				responsive:{
					0:{
						items:1,
						nav:true
					},
					400:{
						items:2,
						nav:true
					},	        
					768:{
						items:3,
						nav:true
					},
					1000:{
						items:5,
						nav:true,
						loop:false
					},
					1200:{
						items:6,
						nav:true,
						loop:false
					}	        
				}
			});
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
	<body class="photo-book">
		<header>
			@include('layouts.partials.header')
		</header>
		
		@yield('main-content')
		
		<footer>
		@include('layouts.partials.footer')
		</footer>
		
		
		
	</body>
	
</html>