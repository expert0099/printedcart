@extends("layouts.home")

@section("main-content")

<div class="container">

	
	
	<!-- Calander Page Info Start -->
	<section class="clander-page-info mt-5 mb-3">
		<div class="row">
			<div class="col-12">
				
				
				
				<!-- my photo content -->
				<div class="content-body">
					<div class="grid">
						<h1>You’re signed out of PrintedCart</h1>
						<h2>Thank you for creating with us!</h2>
						<p>Sign in again to review your projects, customize new designs, and order your prints
							<br>
							<a href="{{ url('/user/login') }}"><button class="btn btn-primary">Sign In</button></a>
						</p>
						
						<p>Go back to our homepage to shop for products and get inspired
							<br>
							<a href="{{ url('/home') }}"><button class="btn btn-primary">Back to Homepage</button></a>
						</p>
					</div>
				</div>
				
			
			</div>
		</div>
	</section>
	<!-- Calander Page Info End -->

</div>
@endsection