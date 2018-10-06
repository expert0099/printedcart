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
				<li class="nav-item">
					<a class="nav-link" href="{{ URL::asset(config('app.url').'user/login') }}">Sign in</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ URL::asset(config('app.url').'user/register') }}">Sign up</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ URL::asset(config('app.url').'user/my_photos') }}">My Photos</a>
				</li>
				@else
				<li class="nav-item">
					<a class="nav-link" href="{{URL::asset(config('app.url').'user/section')}}">Welcome <b>{{ Auth::user()->name }}</b></a>
				</li>
				<li class="nav-item">
					<!--<a class="nav-link" href="{{ URL::asset(config('app.url').'user/logout') }}">Sign Out</a>-->
					@if($item_count>0)
						<a class="nav-link" href="javascript:void(0);" id="signout_id">Sign Out</a>
					@else
						<a class="nav-link" href="{{ URL::asset('user/logout') }}">Sign Out</a>
					@endif
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ URL::asset(config('app.url').'user/my_photos') }}">My Photos</a>
				</li>
				@endif
				<li class="nav-item">
					<a class="nav-link @if(Request::segment(1)=='sharesite') active @endif" href="{{ URL::asset(config('app.url').'sharesite') }}">Share Sites</a>
				</li>
			</ul>
		</div>
	</div>
</nav>
<!-- Top nav bar start -->