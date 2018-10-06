<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Printedcart: Shop</title>
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/custom.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/font-awesome.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/owl.carousel.min.css') }}">
		
		<!-- Bootstrap Script -->
		<script type="text/javascript" src="{{ URL::asset('public/js/jquery-3.2.1.slim.min.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('public/js/popper.min.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('public/js/bootstrap.min.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('public/js/jquery-1.12.4.js') }}"></script>
	</head>
	
	<body>
		<header>
			@include('layouts.partials.cart_header')
		</header>
		
		@yield('main-content')

		<footer>
		@include('layouts.partials.cart_footer')
		</footer>
	</body>
	
</html>