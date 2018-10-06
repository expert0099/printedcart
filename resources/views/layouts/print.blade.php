<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="_token" content="{{ csrf_token() }}" />
		<title>PrintedCart: Shop</title>
		<style type="text/css">
		#wrapper{ width: 80%; text-align: center; margin: 0 auto; }
		.thumbimage {
			float:left;
			width:100px;
			position:relative;
			padding:5px;
		}
		nav.navbar:before, nav.navbar:after, nav.navbar .container:before, nav.navbar .container:after{display:none;}
		html{
			font-size:inherit !important;
		}
		</style>
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/custom.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/font-awesome.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/common-page.css') }}">
			
		<!-- Bootstrap Script -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<!--<script type="text/javascript" src="{{ URL::asset('public/js/jquery-3.2.1.slim.min.js') }}"></script>-->
		<script type="text/javascript" src="{{ URL::asset('public/js/popper.min.js') }}"></script>
		
		
		<script type="text/javascript">
		$(document).ready(function() {
			$("div.bhoechie-tab-menu>div.list-group>a").click(function(e){
				e.preventDefault();
				$(this).siblings('a.active').removeClass("active");
				$(this).addClass("active");
				var index = $(this).index();
				$("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
				$("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
			});
		});
		</script>
	</head>
	<body>
		<header>
			@include('layouts.partials.printheader')
		</header>
		@yield('main-content')
		
	</body>
</html>