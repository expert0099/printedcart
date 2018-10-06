@extends('layouts.auth')

@section("main-content")

    <section class="page-feature-product m-100">
	
		<div class="container-fluid login-box w-30">
			
			<div class="container">
				@if (count($errors) > 0)
					<div class="alert alert-danger">
						<strong>Whoops!</strong> There were some problems with your input.<br><br>
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
							<li>
								Have you forgot password?<br>
								please click<a href="{{ url('/password/reset') }}" style="text-decoration:none; color:maroon"> <b>here</b></a>
							</li>
						</ul>
						
					</div>
				@endif
				
				@if(Session::has('success'))
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">×</span></button>
						{{Session::get('success')}}
					</div>
				@endif

				<div class="row">
					<div  class="col-lg-4 border-right pr-4">
						<div class="text-center featured-title">
							<h1 class="text-left">Sign Up</h1>
						</div>
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
							<div class="row">
								<div class="col-12">
									<div class="checkbox icheck">
										<label>
											<input type="checkbox"> I agree to the <a href="{{URL::asset('pages/terms')}}" target="_blank">terms</a>
										</label>
									</div>
								</div><!-- /.col -->
								<div class="col-12 mt-3 mb-2">
									<button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
								</div><!-- /.col -->
							</div>
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
						<div>Already have an account? <a href="{{ url('/user/login') }}">Sign in!</a></div>
					</div>
				</div>
				<hr>
				<!--<center><a href="{{ url('/user/login') }}" class="text-center">Login</a></center>-->
        
			</div>
			<!-- container img-card-holde close -->
		</div>
		<!-- container-fluid w-96 close -->
	</section>
	
	<div id="img_loader" style="display:none;"></div>

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
	
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
	<script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>
	
	@if(Session::has('email'))
		<?php 
		$email = Session::get('email');
		?>
		<script>
		$(function(){
			$("#verifyAlert").dialog({
				autoOpen: false,
				width: $(window).width() > 500 ? 500 : 'auto',
				height: 'auto',
				fluid: true,
				responsive: true,
				show: {
					//effect: "blind",
					duration: 1000
				},
				hide: {
					//effect: "explode",
					duration: 1000
				}
			});
			$("#verifyAlert").dialog( "open" );
			$("#resend").on('click',function(){
				var basePath = "<?php echo env('APP_URL');?>";
				var email = "<?php echo $email; ?>";
				$.ajax({
					url : basePath+'user/resend_verify_mail/'+email,            
					type : 'GET',
					beforeSend: function(){
						$('#img_loader').css('display','block');
						$('#img_loader').html("<img src='https://printedcart.com/printedcart/public/images/loader.gif'>");
					},
					success : function(data){
						$('#img_loader').css('display','none');
						if(data=='ok'){
							$("#verifyAlert").dialog( "close" );
							$("#resendVerify").dialog({
								autoOpen: false,
								width: $(window).width() > 500 ? 500 : 'auto',
								height: 'auto',
								fluid: true,
								responsive: true,
								show: {
									//effect: "blind",
									duration: 1000
								},
								hide: {
									//effect: "explode",
									duration: 1000
								}
							});
							$("#resendVerify").dialog( "open" );
						}
					}
				});
			});
		});
		</script>
		<!-- verify alert -->
		<div id="verifyAlert" title="Verify" style="display:none;">
			<div class="row">
				<div class="col-sm-12 form-group" style="text-align:center;">
					Verify your email address
				</div>
				<div class="col-sm-12 form-group" style="text-align:left;">
					PrintedCart needs to verify your email address before you can checkout. An email with a verification link was sent to <b>{{$email}}</b>. Please check your inbox/spam or resend the verification email below.
				</div>
				<div class="col-sm-12 form-group" style="text-align:center;">
					<a href="javascript:void(0);" class="btn btn-primary" style="color:#fff;" id="resend">Resend</a>
				</div>
			</div>
		</div>
		<!-- end verify alert -->
		
		<!-- resend verify -->
		<div id="resendVerify" title="Resend" style="display:none;">
			<div class="row">
				<div class="col-sm-12 form-group" style="text-align:center;"><img src="{{URL::asset('public/images/ok.jpg')}}" style="width:60px; border:1px solid green; border-radius:50px; margin-right:10px;">Verification email sent</div>
			</div>
		</div>
		<!-- end resend verify -->
	@endif
	
	@if(Session::has('verified'))
		@if(Session::get('verified')=='yes')
			<script>
			$(function(){
				var basePath = "<?php echo env('APP_URL');?>";
				var user_id = "<?php echo Session::get('user_id'); ?>";
				$.ajax({
					url : basePath+'user/verify_mail_confirm/'+user_id,            
					type : 'GET',
					beforeSend: function(){
						$("#verified_yes").dialog({
							autoOpen: false,
							width: $(window).width() > 500 ? 500 : 'auto',
							height: 'auto',
							fluid: true,
							responsive: true,
							show: {
								//effect: "blind",
								duration: 1000
							},
							hide: {
								//effect: "explode",
								duration: 1000
							}
						});
						$("#verified_yes").dialog( "open" );
						
						$('#img_loader').css('display','block');
						$('#img_loader').html("<img src='https://printedcart.com/printedcart/public/images/loader.gif'>");						
					},
					success : function(data){
						window.location.href = basePath+'user/section';
						$('#img_loader').css('display','none');
						if(data=='ok'){
							$("#verified_yes").dialog({
								autoOpen: false,
								width: $(window).width() > 500 ? 500 : 'auto',
								height: 'auto',
								fluid: true,
								responsive: true,
								show: {
									//effect: "blind",
									duration: 1000
								},
								hide: {
									//effect: "explode",
									duration: 1000
								}
							});
							$("#verified_yes").dialog( "open" );
						}
					}
				});
			});
			</script>
			<div id="verified_yes" title="Verify" style="display:none;">
				<div class="row">
					<div class="col-sm-12 form-group" style="text-align:center;">Please refresh this page to continue</div>
				</div>
			</div>
		@else
			<script>
			$(function(){
				$("#verified_no").dialog({
					autoOpen: false,
					width: $(window).width() > 500 ? 500 : 'auto',
					height: 'auto',
					fluid: true,
					responsive: true,
					show: {
						//effect: "blind",
						duration: 1000
					},
					hide: {
						//effect: "explode",
						duration: 1000
					}
				});
				$("#verified_no").dialog( "open" );
			});
			</script>
			<div id="verified_no" title="Resend" style="display:none;">
				<div class="row">
					<div class="col-sm-12 form-group" style="text-align:center;">Email not verified.</div>
				</div>
			</div>
		@endif
	@endif
<style>
#img_loader img {
	position: absolute;
	left: 50%;
	top: 50%;
	transform: translateY(-50%) translateX(-50%);
	-moz-transform: translateY(-50%) translateX(-50%);
	-webkit-transform: translateY(-50%) translateX(-50%);
	-ms-transform: translateY(-50%) translateX(-50%);
	-o-transform: translateY(-50%) translateX(-50%);
}
#img_loader {
	position: fixed;
	top: 0;
	height: 100%;
	left: 0;
	width: 100%;
	background-color: rgba(0,0,0,0.1);
	z-index: 99999;
}
</style>
@endsection