@extends('layouts.auth')

@section("main-content")

    <section class="page-feature-product m-100">
	
		<div class="container-fluid w-30">
			
			<div class="text-center featured-title">
				<h1 class="bg-white d-inline-block pr-5 pl-5">Sign Up</h1>
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

				<form action="{{ url('/register') }}" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-group has-feedback">
						<input type="text" class="form-control" placeholder="Full name" name="name" value="{{ old('name') }}"/>
						<span class="glyphicon glyphicon-user form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}"/>
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input type="password" class="form-control" placeholder="Password" name="password"/>
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input type="password" class="form-control" placeholder="Retype password" name="password_confirmation"/>
						<span class="glyphicon glyphicon-log-in form-control-feedback"></span>
					</div>
					<div class="row" style="margin-left:0px;margin-right:0px;">
						<div class="col-xs-8">
							<div class="checkbox icheck">
								<label>
									<input type="checkbox"> I agree to the terms
								</label>
							</div>
						</div><!-- /.col -->
						<div class="col-xs-4">
							<button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
						</div><!-- /.col -->
					</div>
				</form>

				@include('auth.partials.social_login')
				<hr>
				<!--<center><a href="{{ url('/user/login') }}" class="text-center">Login</a></center>-->
        
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