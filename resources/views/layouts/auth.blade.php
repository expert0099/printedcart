<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>PrintedCart: Shop</title>
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/custom.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/font-awesome.min.css') }}">
		<!-- iCheck -->
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/la-assets/plugins/iCheck/square/blue.css') }}"/>
		
		<!-- Bootstrap Script -->
		<!--<script type="text/javascript" src="js/jquery-3.2.1.slim.min.js"></script>-->
		<script type="text/javascript" src="{{ URL::asset('public/js/jquery-3.2.1.slim.min.js') }}"></script>
		<!--<script type="text/javascript" src="js/popper.min.js"></script>-->
		<script type="text/javascript" src="{{ URL::asset('public/js/popper.min.js') }}"></script>
		<!--<script type="text/javascript" src="js/bootstrap.min.js"></script>-->
		<script type="text/javascript" src="{{ URL::asset('public/js/bootstrap.min.js') }}"></script>
		
		<!-- added for dialog -->
		<!--<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">-->
		<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
		<!--<script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>-->
		<!-- end added for dialog -->
		
	</head>
	
	<body>
		<header>
			@include('layouts.partials.header')
		</header>
		
		@yield('main-content')

		<footer>
		@include('layouts.partials.footer')
		</footer>
		
	</body>
</html>