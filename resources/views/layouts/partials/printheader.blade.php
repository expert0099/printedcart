<!-- Top nav bar start -->
<nav class="navbar fixed-top navebar-top navbar-expand-lg navbar-light bg-white">
	<div class="container">
		<a class="navbar-brand" href="{{URL::asset('home')}}"><img src="{{URL::asset('public/images/site-logo.png')}}"></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse d-lg-block" id="navbarSupportedContent">
			<ul class="navbar-nav mr-lg-auto float-md-right align-items-md-center">
				@if (Auth::guest())
				<li class="nav-item active">
					<a class="nav-link" href="{{ URL::asset('user/login') }}">Sign in</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ URL::asset('user/register') }}">Sign up</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ URL::asset('user/my_photos') }}">My Photos</a>
				</li>
				@else
				<li class="nav-item">
					<a class="nav-link" href="{{ URL::asset('user/section') }}">Welcome <b>{{ Auth::user()->name }}</b></a>
				</li>
				<li class="nav-item">
					<!--<a class="nav-link" href="{{ URL::asset('user/logout') }}">Sign Out</a>-->
					@if($item_count>0)
						<a class="nav-link" href="javascript:void(0);" id="signout_id">Sign Out</a>
					@else
						<a class="nav-link" href="{{ URL::asset('user/logout') }}">Sign Out</a>
					@endif
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ URL::asset('user/my_photos') }}">My Photos</a>
				</li>
				@endif
				<li class="nav-item">
					<a class="nav-link" href="{{URL::asset('sharesite')}}">Share Sites</a>
				</li>
				
				@if(\Auth::check())
				<li class="nav-item">
					<a class="nav-link" id="basket" href="{{URL::asset('payments/cart')}}">
						<i class="fa fa-shopping-cart" aria-hidden="true"></i>
						<span id="cart_count" class="label label-success">
						 {{ isset($item_count) ?  $item_count : 0}} 
						</span>
					</a>
				</li>
				@endif
			</ul>
		</div>
	</div>
</nav>
<!-- Top nav bar start -->
<!-- Second nav bar start -->
<nav class="navbar fixed-top navebar-second editor-nav-bar d-none d-lg-block navbar-expand-lg navbar-light bg-blue p-0">
	<div class="container">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto align-items-center">
				<li class="nav-item add-to-cart-nav">
					<a class="nav-link btn-warning text-blue" id="add_to_cart" href="javascript:void(0)">Add to cart</a>
				</li>
			</ul>
		</div>
	</div>
</nav>
<!-- Second nav bar start -->
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
			//effect: "blind",
			duration: 1000
		},
		hide: {
			//effect: "explode",
			duration: 1000
		}
	});
	$( "#signout_id" ).on( "click", function() {
		$("#signout_idDialog").dialog( "open" );
	});
});
</script>

