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
					<a class="nav-link @if(Request::segment(2)=='login') active @endif" href="{{ URL::asset('user/login') }}">Sign in</a>
				</li>
				<li class="nav-item">
					<a class="nav-link @if(Request::segment(2)=='register') active @endif" href="{{ URL::asset('user/register') }}">Sign up</a>
				</li>
				<li class="nav-item">
					<a class="nav-link @if(Request::segment(2)=='my_photos') active @endif" href="{{ URL::asset('user/my_photos') }}">My Photos</a>
				</li>
				@else
				<li class="nav-item">
					<a class="nav-link @if(Request::segment(2)=='section') active @endif" href="{{URL::asset('user/section')}}">Welcome <b>{{ Auth::user()->name }}</b></a>
				</li>
				<li class="nav-item">
					@if($item_count>0)
						<a class="nav-link" href="javascript:void(0);" id="signout_id">Sign Out</a>
					@else
						<a class="nav-link" href="{{ URL::asset('user/logout') }}">Sign Out</a>
					@endif
				</li>
				<li class="nav-item">
					<a class="nav-link @if(Request::segment(2)=='my_photos') active @endif" href="{{ URL::asset('user/my_photos') }}">My Photos</a>
				</li>
				@endif
				<li class="nav-item">
					<a class="nav-link @if(Request::segment(1)=='sharesite') active @endif" href="{{ URL::asset('sharesite') }}">Share Sites</a>
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
<nav class="navbar navebar-second d-none d-lg-block navbar-expand-lg navbar-light bg-blue p-0">
	<div class="container">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto align-items-center">
				<li class="nav-item">
					<a class="nav-link @if(Request::segment(1)=='home') active @endif" href="{{URL::asset('home')}}">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link @if(Request::segment(2)=='about') active @endif" href="{{URL::asset('pages/about')}}">About</a>
				</li>
				<li class="nav-item">
					<a class="nav-link @if(Request::segment(1)=='photobooks') active @endif" href="{{URL::asset('photobooks')}}">Photobooks</a>
				</li>
				<li class="nav-item">
					<a class="nav-link @if(Request::segment(1)=='calendars' && Request::segment(2)=='calendar_posters' || Request::segment(2)=='colposview') active @endif" href="{{URL::asset('calendars')}}">Calendars</a>
				</li>
				<li class="nav-item">
					<a class="nav-link @if(Request::segment(1)=='posters' || Request::segment(2)=='collage_posters') active @endif" href="{{URL::asset('posters')}}">Posters</a>
				</li>
				<!-- added for print -->
				<li class="nav-item">
					<a class="nav-link @if(Request::segment(1)=='prints') active @endif" href="{{URL::asset('prints')}}">Prints</a>
				</li>
				<!-- end added for print -->
				<li class="nav-item">
					<a class="nav-link @if(Request::segment(2)=='contact') active @endif" href="{{URL::asset('pages/contact')}}">Contact</a>
				</li>
			</ul>
			<form class="form-inline my-2 my-lg-0" action="{{ URL::asset('search') }}" method="post">
				<!--<input class="form-control mr-sm-2" type="search" placeholder="Search">-->
				{{csrf_field()}}
				{!! Form::text('search_text', null, array('placeholder' => 'Search Text','class' => 'form-control','id'=>'search_text','autocomplete'=>'off')) !!}
				<button class="btn my-2 my-sm-0" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
			</form>
		</div>
	</div>
</nav>
<!-- Second nav bar start -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>  
<script type="text/javascript">
var url = "{{ route('typeahead.response') }}";
$('#search_text').typeahead({
    source:  function (query, process){
		return $.get(url, { query: query }, function (data){
			return process(data);
        });
    }
});
</script>
<style>
#cart_count {
    background-color: #10cfbd;
    border-radius: 5px;
	color: #fff;
}
</style>
