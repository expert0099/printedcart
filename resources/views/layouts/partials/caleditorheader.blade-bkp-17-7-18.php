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
					<a class="nav-link" href="{{URL::asset('user/section')}}">Welcome <b>{{ Auth::user()->name }}</b></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ URL::asset('user/logout') }}">Sign Out</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ URL::asset('user/my_photos') }}">My Photos</a>
				</li>
				@endif
				<li class="nav-item">
					<a class="nav-link" href="{{URL::asset('sharesite')}}">Share Sites</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="javascript:history.back();">Back</a>
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
			<ul class="navbar-nav align-items-center">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Project</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="{{ URL::asset('user/section') }}">Saved Project</a>
					</div>        
				</li>
				<!--<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Page</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="javascript:void(0)" id="addmore_page2">Add Page</a>
					</div>        
				</li>-->
			</ul>
			<ul class="navbar-nav align-items-center editor-icons">
				<!--<li class="nav-item">
					<a class="nav-link" href="javascript:void(0)" id="addmore_page">
						<i class="fa fa-file-code-o color-white" aria-hidden="true"></i> Add Page
					</a>
				</li>-->
				<li class="nav-item">
					<a class="nav-link" href="#" data-toggle="modal" data-target="#myModal"><i class="fa fa-picture-o" aria-hidden="true"></i> Add photos</a>
				</li>
				<!--<li class="nav-item">
					<a class="nav-link" href="#" id="addText"><i class="fa fa-text-width" aria-hidden="true"></i> Add text box</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#"><i class="fa fa-th" aria-hidden="true"></i> Add photo area</a>
				</li>-->
			</ul>
			<ul class="navbar-nav align-items-center editor-icons">
				<li class="nav-item">
					<a class="nav-link" href="#" id="undo"><i class="fa fa-undo" aria-hidden="true"></i> Undo</a>
				</li>
				<li class="nav-item"><a class="nav-link" href="#" id="redo"><i class="fa fa-repeat" aria-hidden="true"></i> Redo</a></li>
			</ul>
			<ul class="navbar-nav align-items-center editor-icons">
				<li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-search-minus" aria-hidden="true"></i> 100%</a></li>
				<li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-search-plus" aria-hidden="true" rel="0" p="0" s="960" data-scale="1"></i></a></li>
			</ul>   
			<ul class="navbar-nav ml-auto align-items-center">
				<!--<li class="nav-item"><a class="nav-link" id="pdf" href="{{ URL::asset('calendars/htmltopdfview/'.$project_id.'/show') }}" target="_blank">PDF</a></li>-->
				<li class="nav-item"><a class="nav-link" id="save_pages" href="javascript:void(0)">Save</a></li>
				<li class="nav-item"><a class="nav-link" id="preview2" href="javascript:void(0)" data-toggle="modal" data-target="#ModalCarousel">Preview</a></li>
				<li class="nav-item add-to-cart-nav">
					<a class="nav-link btn-warning text-blue" href="#">Add to cart</a>
				</li>
			</ul>
		</div>
	</div>
</nav>
<!-- Second nav bar start -->