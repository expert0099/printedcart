<!DOCTYPE html>
<html>
    <head>
        <title>{{$error}}</title>

        <link href="https://fonts.googleapis.com/css?family=Roboto:200,400" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/custom.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/font-awesome.min.css') }}">
        <style>
		.content {
			text-align: center;
			transform: translate(-50%, -50%);
			position: absolute;
			top: 50%;
			left: 50%;
		}
		footer {
			border-top: none;
		}
		.footer-nav ul li a, .copyright-text {
			border-right: 0px solid #bababa;
		}
		</style>
    </head>
    <body>
		<header style="height:72px;">
			@include('layouts.partials.error_header')
		</header>
	    <div class="container">
            <div class="content">
				<i class="fa fa-search" style="font-size:120px;color:#FF5959;margin-bottom:30px;"></i>
               	<div class="title">{{$error}}</div>
								
				<a href="{{ url('/') }}">Homepage</a> | 
				<a href="javascript:history.back()">Go Back</a>
				
            </div>
        </div>
		<footer style="position: fixed; width: 100%; bottom: 0; left: 0;">
			@include('layouts.partials.error_footer')
		</footer>
    </body>
</html>
