@extends('layouts.auth')

@section("main-content")
	<section class="page-feature-product m-100">
	
		<div class="container-fluid w-30">
			
			<div class="text-center featured-title">
				<h1 class="bg-white d-inline-block pr-5 pl-5">Sign In</h1>
			</div>
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
				
				<!--<div class="row">-->
					
					<!-- login form -->
					<form action="{{ url('/login') }}" method="post" style="margin-top:30px;">
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
							<div class="col-xs-8">
								<div class="checkbox icheck">
									<label>
										<input type="checkbox" name="remember"> Remember Me
									</label>
								</div>
							</div><!-- /.col -->
							<div class="col-xs-4">
								<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
							</div><!-- /.col -->
						</div>
					</form>
					@include('auth.partials.social_login')
					<div class="form-group">
					<a href="{{ url('/password/reset') }}">I forgot my password</a><br>
					</div>
					<!--<a href="{{ url('/register') }}" class="text-center">Register a new membership</a>-->
					<!-- end login form -->
					
				<!--</div>-->
				<!-- Row Close -->
			</div>
			<!-- container img-card-holde close -->
		</div>
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
