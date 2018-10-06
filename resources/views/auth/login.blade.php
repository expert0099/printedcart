@extends('layouts.auth')

@section("main-content")
	<section class="page-feature-product m-100">
	
		<div class="container-fluid login-box w-40">
			
			<div class="container">
			
				@if (count($errors) > 0)
					<div class="alert alert-danger">
						<strong>Whoops!</strong> There were some problems with your input.<br><br>
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				
				@if (session('success'))
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">×</span></button>
						{{ session('success') }}
					</div>
				@endif
				
				<!--<div class="row">-->
				<div class="row">
				<div  class="col-lg-4 border-right pr-4">
					<div class=" featured-title">
						<h1 class="text-left">Sign in to PrintedCart</h1>
					</div>	
					<!-- login form -->
					<form action="{{ url('/login') }}" method="post">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group has-feedback">
							<input type="email" class="form-control" placeholder="Email" name="email"/>
							<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
						</div>
						<div class="form-group has-feedback">
							<input type="password" class="form-control" placeholder="Password" name="password"/>
							<span class="glyphicon glyphicon-lock form-control-feedback"></span>
						</div>
						<div class="row" style="margin-left:0px;margin-right:0px;">
							<div class="col pl-0">
								<div class="checkbox icheck">
									
								<div id="rememberCheckbox">
									<input id="rememberUserName" class="rememberCheckbox" type="checkbox" name="remember">
									<label for="rememberUserName"><i></i></label>
								</div>

									<label id="remember_email_text" for="rememberUserName">	Remember Me </label>
									
									
								</div>
							</div><!-- /.col -->
							<div class="col ml-auto text-right pr-0">
								<div class="form-group">
									<!--<a href="{{ url('/user/register') }}">New user register here</a><br>-->
									<a href="{{ url('/password/reset') }}">Forgot password?</a>
								</div>								
							</div><!-- /.col -->
						</div>
						<button type="submit" class="btn btn-primary btn-block btn-flat mb-4 mt-2">Sign In</button>						
					</form>
					@include('auth.partials.social_login')
				</div>
				<div class="col-lg-8 pl-4">
					<h1>New to PrintedCart?</h1>
					<div class="today_take"><b>Sign up today to take advantage of these exclusive offers!</b>
						<ul>
							<li>Top quality print-on-demand service</li>
							<li>Your creations delivered straight to your door</li>
							<li>Competitive pricing on every product</li>
						</ul>
					</div>
					<div><a href="{{ url('/user/register') }}"><button class="btn btn-primary">Register Now!</button></a></div>
				</div>
				</div>
					<!--<a href="{{ url('/register') }}" class="text-center">Register a new membership</a>-->
					<!-- end login form -->
					
				<!--</div>-->
				<!-- Row Close -->
			</div>
			<!-- container img-card-holde close -->
		</div>
		<!--<div class="container-fluid login-box w-60">
			<div id="joinArea" class="spa-enabled">
				<h2>New to PrintedCart?</h2>
				<div><b>Sign up today to take advantage of these exclusive offers!</b>
					<ul>
						<li>Top quality print-on-demand service</li>
						<li>Your creations delivered straight to your door</li>
						<li>Competitive pricing on every product</li>
						<li>Benefit 4 (share site information???)</li>
					</ul>
				</div>
				<div><a href="{{ url('/user/register') }}">Register Now!</a></div>
			</div>
		</div>-->
		<!-- container-fluid w-96 close -->
	</section>
    
	@include('layouts.partials.scripts_auth')

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>

@endsection
