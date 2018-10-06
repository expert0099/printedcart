<div class="container">
	<div class="row">
		<div class="col-sm-6 col-md-4 col-lg-3">
			<div class="footer-help-box">
				<h4 class="mb-4">Help</h4>
				<ul class="nav flex-column">
				
					@foreach($help_group_pages as $k => $value)
					<li class="nav-item">
						<a class="nav-link" href="{{URL::asset('pages/'.$value['page_slug'])}}">{!! $value['page_name'] !!}</a>
					</li>
					@endforeach
					
					<li class="nav-item">
					@if(Auth::check())
						<a class="nav-link" href="{{URL::asset('user/section#order_history')}}">Order Status</a>
					@else
						<a class="nav-link" href="">Order Status</a>
					@endif
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{URL::asset('user/feedback')}}">Feedback </a>
					</li>																				
				</ul>					
			</div>
		</div>
		<div class="col-sm-6 col-md-4 col-lg-3 mt-4 mt-sm-0">
			<div class="footer-resources-box">
				<h4 class="mb-4">Resources</h4>
				<ul class="nav flex-column">
				
					@foreach($resource_group_pages as $k => $value)
					<li class="nav-item">
						<a class="nav-link" href="{{URL::asset('pages/'.$value['page_slug'])}}">{!! $value['page_name'] !!}</a>
					</li>
					@endforeach
					
					<!--<li class="nav-item">
						<a class="nav-link" href="{{URL::asset('pages/blog')}}">Blog</a>
					</li>-->
					<li class="nav-item">
						<a class="nav-link" href="{{URL::asset('sharesite/')}}">Share site</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{URL::asset('user/section')}}">My Printedcart</a>
					</li>																
				</ul>					
			</div>
		</div>
		<div class="col-sm-6 col-md-4 col-lg-2 mt-4 mt-md-0">
			<div class="footer-corporate-box">
				<h4 class="mb-4">Corporate</h4>
				<ul class="nav flex-column">
					@foreach($corporate_group_pages as $k => $value)
					<li class="nav-item">
						<a class="nav-link" href="{{URL::asset('pages/'.$value['page_slug'])}}">{!! $value['page_name'] !!}</a>
					</li>
					@endforeach
					
					<li class="nav-item">
						<a class="nav-link" href="{{URL::asset('pages/contact')}}">Careers</a>
					</li>
					<!--<li class="nav-item">
						<a class="nav-link" href="#">Media</a>
					</li>-->
				</ul>					
			</div>
		</div>	
		<div class="col-sm-6 col-md-12 col-lg-4 mt-4 mt-lg-0">
			<div class="footer-connected-box">
				<h4 class="mb-4">Get Connected</h4>
				<p>Get Printedcart design tips via email</p>
				
				@if (session('status'))
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
				@endif

				
				
				{!! Form::open(['method' => 'POST','url'=>'newsletter', 'class'=>'form-inline']) !!}
					<input type="email" name="email" class="form-control rounded-0 mr-1 col-12 col-md-8 col-lg-12 col-xl-8 mb-2 mb-md-0 mb-lg-2 mb-xl-0" aria-describedby="emailHelp" placeholder="Enter your email address" required='true'>
					@if($errors->has('email'))
						<p class="help-block">
							{{ $errors->first('email') }}
						</p>
					@endif
					<button type="submit" class="btn btn-primary col-md-auto col-lg-12 col-xl-auto text-uppercase rounded-0 border-0">Sign Up</button>
				{!! Form::close() !!}

				<h4 class="mt-4">Payment Methods</h4>
				<div class="payment-iocn mt-4">
					<ul class="d-flex p-0">
						<li><img class="img-fluid" src="{{URL::asset('public/images/card1.png')}}" alt="payment-iocns"></li>
						<li><img class="img-fluid" src="{{URL::asset('public/images/card2.png')}}" alt="payment-iocns"></li>
						<li><img class="img-fluid" src="{{URL::asset('public/images/card3.png')}}" alt="payment-iocns"></li>
						<li><img class="img-fluid" src="{{URL::asset('public/images/card4.png')}}" alt="payment-iocns"></li>
						<li><img class="img-fluid" src="{{URL::asset('public/images/card5.png')}}" alt="payment-iocns"></li>
					</ul>	
				</div>							
			</div>
		</div>						
	</div>
	<div class="row footer-copyright-section pt-4 mt-4 pb-4">
		<div class="col-12 col-lg-auto copyright-text mb-3 mb-lg-0 text-center"> <p class="font-weight-light m-0"> &copy; {!! date('Y') !!} - {!! date('Y')+1 !!}  printedcart.com. All rights reserved.</p></div>
		<div class="col-12 col-lg-auto footer-nav mb-3 mb-lg-0">
			<ul class="nav justify-content-center">
				<li class="nav-item">
					<a class="nav-link pt-0 pb-0 pr-3" href="{{URL::asset('public/sitemap-generator.php')}}">Site map</a>
				</li>
				<li class="nav-item">
					<a class="nav-link pt-0 pb-0 pl-3 pr-3" href="{{URL::asset('pages/terms')}}">Terms of Use</a>
				</li>
				<li class="nav-item">
					<a class="nav-link pt-0 pb-0 pl-3 border-0" href="{{URL::asset('pages/privacy')}}">Privacy Policy</a>
				</li>
			</ul>
		</div>
		<div class="col-12 col-lg-auto ml-lg-auto footer-social text-center">
			<ul class="d-inline p-0">
				<li class="d-inline mr-3"><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
				<li class="d-inline mr-3"><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
				<li class="d-inline mr-3"><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
				<li class="d-inline"><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
			</ul>
		</div>
	</div>
</div>

