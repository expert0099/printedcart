<!-- Top nav bar start -->
<nav class="navbar fixed-top navebar-top navbar-expand-lg navbar-light bg-white">
	<div class="container">
		<a class="navbar-brand" href="{{ URL::asset(config('app.url').'home') }}"><img src="{{URL::asset('public/images/site-logo.png')}}"></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse d-lg-block" id="navbarSupportedContent">
		
			<ul class="navbar-nav mr-lg-auto float-md-right align-items-md-center">
				@if(Auth::guest())
				<li class="nav-item active">
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
					<a class="nav-link" href="{{ URL::asset(config('app.url').'user/logout') }}">Sign Out</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ URL::asset(config('app.url').'user/my_photos') }}">My Photos</a>
				</li>
				@endif
			</ul>
		</div>
	</div>
</nav>
<!-- Top nav bar start -->