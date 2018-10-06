@extends("layouts.home")

@section("main-content")

<div class="container">

	@include('calendar.desk_cal_banner')
	
	@if($errors->has())
		<div class="alert alert-danger alert-dismissible" role="alert" style="margin-top:20px;">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			@foreach ($errors->all() as $error)
				<div>{{ $error }}</div>
			@endforeach
		</div>
	@endif
	<!-- Calendars form Start -->
	@if(Session::has('success'))
		<div class="alert alert-success alert-dismissible" role="alert" style="margin-top:20px;">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			{{Session::get('success')}}
		</div>
	@endif
	<div class="row calendars-form-section no-gutters mt-5 py-3 calendarsDiskSec">
	
		<div class="col-md-12 col-lg-4">
			<div class="calendar-promo-box text-center px-3 pl-6 pr-6 py-3">
				<h4>{{$desk_calendar['calendar_category']}}</h4>
				<img src="{{URL::asset($desk_calendar['desk_calendar_img'])}}" style="width:250px;border-radius:5px;"/>
			</div>
		</div>
		
		{!! Form::open(['method' => 'POST','url'=>'calendars/desk','style'=>'width:66%;display:flex;']) !!}
		<div class="col-md-12 col-lg-4">
			<div class="calendar-promo-box text-center py-3" style="width:290px;">
				<h4 class="font-weight-light mb-3">{{$desk_calendar['calendar_category']}}</h4>
				<div class='frm-abc'>
				{{$desk_calendar['content']}}
				</div>
			</div>	
			<input type="hidden" name="calendar_category" id="calendar_category" value="{{$desk_calendar['id']}}"/>
		</div>
		<div class="col-md-12 col-lg-4">
			<div class="calendar-month-form px-3 px-md-5 px-lg-3 pl-6 pr-6 py-3" style="width:425px;">
				<h6 class="font-weight-light mb-4">Start your calendar on any month</h6>
				<div class="form-row">
					<label class="col-12 mb-1" for="exampleInputEmail1">Starting month</label>
					<?php 
					$month = array('January','February','March','April','May','June','July','August','September','October','November','December');
					?>
					<div class="col-12 col-sm-6 mb-3 mb-sm-0">
						<select id="calendar-months" name="calendar_month" class="form-control rounded-0">
							@foreach($month as $k => $val)
								@if($k==0)
								<option value="{{$k+1}}" selected>{{$val}}</option>
								@else
								<option value="{{$k+1}}">{{$val}}</option>	
								@endif
							@endforeach
						</select>
					</div>
					<div class="col-12 col-sm-6 mb-3 mb-sm-0">
						<select id="calendar-years" name='calendar_year' class="form-control rounded-0">
						<?php 
						$cur_year = date('Y');
						for($i=0;$i<=5;$i++){
							if($i==0){
							?>
							<option selected><?php echo date('Y')+$i;?></option>
							<?php 
							}else{
								?>
								<option><?php echo date('Y')+$i;?></option>
								<?php
							}
						}
						?>
						</select>	
						
						<input type="hidden" name="size" value="{{$size['Size']}}"/>
						<input type="hidden" name="size_id" value="{{$size['id']}}"/>
					</div>
					<div class="col-12 mt-4">
						<button type="submit" class="btn btn-primary border-0 rounded-0 px-4">Get Started <i class="fa fa-caret-right ml-2" aria-hidden="true"></i></button>
					</div>					
				</div>
			</div>
			
			<div class="px-3 px-md-5 px-lg-3 pl-6 pr-6 py-3 cal_Price_Section" style="width:425px;">
				<h6 class="font-weight-light">Calendar Pricing</h6>
				<div style="width:100%">
					<div style="width:50%;float:left;"><strong>Item</strong><br>12 Months</div>
					<div><strong>Price</strong><br>{{$default_currency['currencysymbol']}}{{$size['price']}}</div>
				</div>
			</div>
			
		</div>
		
		{!! Form::close() !!}
		
	</div>
	<!-- Calendars form End -->
	
</div>
@endsection