@extends("layouts.photobook")

@section("main-content")
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script>
$(function(){
	setTimeout(function() {
        $('.alert-success').fadeOut('fast');
    }, 5000); 
	setTimeout(function(){
        $('.alert-danger').fadeOut('fast');
    }, 5000);
});
</script>
  
<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/redmond/jquery-ui.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>

<!-- data table includes -->
<!--<style href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">-->
<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap.min.js"></script>
<!-- end data table includes -->
<script>
$(function(){
	$("#tabs").tabs();
	$('#example').DataTable();
});
</script>

<div class="container page-feature-product">

	<!-- Calander Page Info Start -->
	<section class="mt-5 mb-3 container-fluid login-box w-30">
		<div class="row">
			<div class="col-12">
				@foreach($errors->all() as $error)
						<p class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">×</span></button>
						{{ $error }}
						</p>
				@endforeach
				@if(Session::has('success'))
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">×</span></button>
						{{Session::get('success')}}
					</div>
				@endif
				<div class="text-left featured-title">
					<h2 class="bg-white d-inline-block pr-5 pl-5">Feedback</h2>
				</div>
				
				<!-- my feedback content -->
				<div class="content-body">
					<div class="row">
					<div class="col-md-6">				
					{!! Form::open(['method' => 'POST','url'=>'user/feedback']) !!}
						
						<div class="form-group" style="text-align:left;">
							{!! Form::label('name', 'Your Name') !!}
							{!! Form::text('name', null, ['class' => 'form-control', 'required'=>'true']) !!}
						</div>

						<div class="form-group" style="text-align:left;">
							{!! Form::label('country', 'Country') !!}
							{!! Form::text('country', null, ['class' => 'form-control', 'required'=>'true']) !!}
						</div>
						
						<div class="form-group" style="text-align:left;">
							{!! Form::label('star_rating', 'Rating') !!}
							{!! Form::select('star_rating', $star_rating, null, ['class' => 'form-control', 'required'=>'true']) !!}
						</div>

						<div class="form-group" style="text-align:left;">
							{!! Form::textarea('msg', null, ['class' => 'form-control', 'required'=>'true', 'rows'=>'4']) !!}
						</div>

						{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
						<br>
					{!! Form::close() !!}
					</div></div>
				</div>
				<!-- end my feedback content -->
				
			</div>
		</div>
	</section>
	<!-- Calander Page Info End -->
	
</div>

@endsection