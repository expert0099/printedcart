@extends("layouts.home")
@section("main-content")
<div class="container">
	@include('pages.banner_contact')	
	<!-- New Easel Calendars section Start -->	
	<section class="new-easel-section m-100">				
		<!--<div class="row">			
			<div class="col-12">				
				@foreach($errors->all() as $error)						
				<p class="alert alert-danger">						
					<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">×</span></button>						
					{{ $error }}						
				</p>				
				@endforeach				
				@if(Session::has('success'))					
				<div class="alert alert-success">						
					<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">×</span></button>						{{Session::get('success')}}					
				</div>				
				@endif				
				<h2 class="text-center d-block">Contact Us</h2>								
					
				<div class="content-body">														
					{!! Form::open(['method' => 'POST','url'=>'pages/contact']) !!}						
					<div class="col-12">							
						<div class="form-group col-6">								
														
							{!! Form::text('name', null, ['class' => 'form-control', 'required'=>'true', 'placeholder'=>'Your Name']) !!}							
						</div>							
						<div class="form-group col-6">								
											
							{!! Form::text('email', null, ['class' => 'form-control', 'required'=>'true', 'placeholder'=>'Your Email']) !!}							
						</div>						
					</div>												
					<div class="col-12">							
						<div class="form-group col-6">								
														
							{!! Form::text('phone', null, ['class' => 'form-control', 'required'=>'true', 'placeholder'=>'Phone', 'maxLength'=>'10', 'onkeyup'=>"this.value=this.value.replace(/[^\d]/,'')"]) !!}							
						</div>							
						<div class="form-group col-6">								
													
							{!! Form::text('subject', null, ['class' => 'form-control', 'required'=>'true', 'placeholder'=>'Subject']) !!}							
						</div>						
					</div>												
					<div class="col-12">							
						<div class="form-group">								
							{!! Form::textarea('msg', null, ['class' => 'form-control', 'required'=>'true', 'placeholder'=>'Message']) !!}							
						</div>						
					</div>						
					{!! Form::submit('Submit', ['class' => 'btn btn-info', 'id'=>'contactSubmit']) !!}					
				{!! Form::close() !!}									
			</div>				
									
		</div>		
	</div>-->	

<!-- Contact form Start -->

	<div class="container">
		<h1 class="text-center d-block mb-5">Simply put, we provide you with top-quality <br/>printed products at affordable prices.</h1>

	<div class="contact-form-holder row">
		<div class="col-md-5 mr-auto pl-4 py-4">
			<div class="form-container">
				<h2 style="fz-22">Send a Message</h2>
				<p>Please fill up the form below and we will get back to you as soon as possible.</p>
				@foreach($errors->all() as $error)						
				<p class="alert alert-danger">						
					<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">×</span></button>						
					{{ $error }}						
				</p>				
				@endforeach				
				@if(Session::has('success'))					
				<div class="alert alert-success">						
					<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">×</span></button>						{{Session::get('success')}}					
				</div>				
				@endif
				{!! Form::open(['method' => 'POST','url'=>'pages/contact']) !!}	
					<div class="row mb-3">
						<div class="col">
							{!! Form::text('first_name', null, ['class' => 'form-control rounded-0', 'required'=>'true', 'placeholder'=>'First name']) !!}
							<!--<input type="text" class="form-control rounded-0" placeholder="First name">-->
						</div>
						<div class="col">
							{!! Form::text('last_name', null, ['class' => 'form-control rounded-0', 'required'=>'true', 'placeholder'=>'Last name']) !!}
							<!--<input type="text" class="form-control rounded-0" placeholder="Last name">-->
						</div>
					</div>
					<div class="row mb-3">
						<div class="col">
							{!! Form::text('company_name', null, ['class' => 'form-control rounded-0', 'required'=>'true', 'placeholder'=>'Company name']) !!}
							<!--<input type="text" class="form-control rounded-0" placeholder="Company name">-->
						</div>
						<div class="col">
							{!! Form::text('phone', null, ['class' => 'form-control rounded-0', 'required'=>'true', 'placeholder'=>'Phone', 'maxLength'=>'10', 'onkeyup'=>"this.value=this.value.replace(/[^\d]/,'')"]) !!}
							<!--<input type="text" class="form-control rounded-0" placeholder="Phone name">-->
						</div>
					</div>
					<div class="row mb-3">
						<div class="col">
							{!! Form::text('email', null, ['class' => 'form-control rounded-0', 'required'=>'true', 'placeholder'=>'Your Email']) !!}	
							<!--<input type="text" class="form-control rounded-0" placeholder="Email">-->
						</div>
					</div>
					<div class="row">
						<div class="col">
							{!! Form::textarea('msg', null, ['class' => 'form-control rounded-0', 'required'=>'true', 'placeholder'=>'Message']) !!}
							<!--<textarea class="form-control rounded-0" placeholder="Your Message Here"></textarea>-->
						</div>
					</div>
					<div class="row">
						<div class="col">
							{!! Form::submit('Submit', ['class' => 'btn btn-primary fz-18 font-weight-light border-0 rounded-0 px-3 w-100 text-uppercase font-weight-bold mt-3', 'id'=>'contactSubmit']) !!}
							<!--<a href="#" class="btn btn-primary fz-18 font-weight-light border-0 rounded-0 px-3 w-100 text-uppercase font-weight-bold mt-3">Submit</a>-->
						</div>
					</div>				  				  

				{!! Form::close() !!}	
			</div>
		</div>
		<div class="col-md-4 p-0">
			<img class="img-fluid" src="http://printedcart.com/printedcart/public/images/contant-right-img.jpg" alt="contact-banner">
		</div>
		<div class="contact-box-info bg-white">
			<div class="info-inner">
				<h3 class="fz-22">Contact Info</h3>
				<div class="info-detail-list">
					<h6>Find Us</h6>
					<p>2 Carlton Street, Suite 1400<br>XXX, Ontario M5B 1J3<br>XXX</p>
				</div>
				<div class="info-detail-list">
					<h6>Call Us</h6>
					<p>(+1) xxx-xxx-xxxx (Canada only) <br>
					Fax: xxx-xxx-xxxx</p>
				</div>
				<div class="info-detail-list">
					<h6>Email</h6>
					<p>info@printedcart.com</p>
				</div>
			</div>
		</div>
	</div>
	<!-- Contact form end -->
</section>	
<!-- New Easel Calendars section end -->
</div>
<!--<script type = "text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script><script type = "text/javascript">function ValidateEmail(email) {	var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;	return expr.test(email);};$("#contactSubmit").live("click", function(){	if(!ValidateEmail($("#email").val())){		//alert("Invalid email address.");		$('#email').css('border:1px solid red');		$('#email').append("<span style='color:red;'>Invalid email address</span>");		return false;	}});</script>-->
@endsection