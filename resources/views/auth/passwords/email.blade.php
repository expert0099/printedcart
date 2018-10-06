@extends('layouts.auth')

@section("main-content")

	<section class="page-feature-product m-100">
	
		<div class="container-fluid login-box w-30" style="max-width:500px;">
			
			<div class="text-center featured-title">
				<h1 class="bg-white d-inline-block pr-5 pl-5">Reset Password</h1>
			</div>
			<div class="container">
				@if (session('status'))
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
				@endif

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

				<form action="{{ url('/password/email') }}" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-group has-feedback">
						<input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}"/>
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div>

					<div class="row">
						<div class="col">
					<button type="submit" class="btn btn-primary btn-block btn-flat mb-3">Send Password Reset Link</button>
						</div><!-- /.col -->
						<div class="col-xs-2"></div><!-- /.col -->
					</div>
				</form>

				<!--<a href="{{ url('/login') }}">Log in</a><br>-->
				<!--<a href="{{ url('/register') }}" class="text-center">Register a new membership</a>-->

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
