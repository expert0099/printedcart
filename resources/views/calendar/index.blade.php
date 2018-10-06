@extends("layouts.home")

@section("main-content")

<div class="container">

	@include('calendar.banner')
	
	<!-- Calendars form Start -->
	@if(Session::has('success'))
		<div class="alert alert-success alert-dismissible" role="alert" style="margin-top:20px;">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			{{Session::get('success')}}
		</div>
	@endif
	<div class="row calendars-form-section no-gutters mt-5 py-3">
	
		<div class="col-md-12 col-lg-4">
			<div class="calendar-promo-box text-center px-3 pl-6 pr-6 py-3">
				<h4 class="text-blue font-weight-normal">
				<?php $j=0;?>
				@foreach($cal_def_size as $k => $val)
					@if(null!==$val['CalendarCategory'])
						@if($j==0) Free {!! $val['Size']['Size'] !!} @endif @if($j==1) calendar Upgrade to {!! $val['Size'] ['Size'] !!} for {!! $default_currency['currencysymbol'] !!}{!! $val['Size']['price'] !!} @endif
						<?php $j=1;?>
					@endif
				@endforeach
				</h4>
				<p class="fz-18 font-weight-light mb-0">@if(null!==$promocode['Coupon']['coupon'])Promo code: {!! $promocode['Coupon']['coupon'] !!}@endif</p>
				<p class="fz-18 font-weight-light mb-0">@if(null!==$promocode['end_date']) Ends {!! date('D, M d',strtotime($promocode['end_date'])) !!} @endif</p>
				<a href="javascript::void(0);" class="btn btn-warning border-0 font-weight-light rounded-0 pt-1 pb-1 mt-3">See Offer details</a>
			</div>
		</div>
		
		{!! Form::open(['method' => 'POST','url'=>'calendars/wall_calendars','style'=>'width:66%;display:flex;']) !!}
		<div class="col-md-12 col-lg-4 raido-box-custom-size">
			<div class="calandar-size-box text-center pl-6 pr-6 py-3" style="width:290px;">
				<h6 class="font-weight-light mb-3">Choose your size</h6>
				<div class='frm-abc'>
					<div class="row">
						@foreach($cal_def_size as $k => $value)
							@if(null!==$value['CalendarCategory'])
							<div class="col-6 larg-radio">
								<label class="custom-control custom-radio mr-0 mb-0">
									<input id="radio{!!$k+1!!}" name="calendar_size" type="radio" checked class="custom-control-input" value="{!!$value['Size']['id']!!}">
									<span class="custom-control-indicator"></span>				
								</label>
								<img src="{{URL::asset('public/images/calender-'.$value['Size']['Size'].'.png')}}" alt="calendar-image">
								<span class="calendar-ratio font-weight-light fz-16">{!!$value['Size']['Size']!!}</span>
								<span class="calendar-price font-weight-light fz-15">{!!$default_currency['currencysymbol']!!}{!!$value['Size']['price']!!}</span>
							</div>
							@endif
						@endforeach
					</div>
				</div>
			</div>		
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
						<select id="calendar_month" name="calendar_month" class="form-control rounded-0">
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
					</div>
					<div class="col-12 mt-4">
						<button type="submit" class="btn btn-primary border-0 rounded-0 px-4">Make a Wall Calendar
							<i class="fa fa-caret-right ml-2" aria-hidden="true"></i></button>
					</div>					
				</div>
			</div>
		</div>
		{!! Form::close() !!}
		
	</div>
	<!-- Calendars form End -->
	<!-- New Easel Calendars section Start -->
	<section class="new-easel-section m-100">
		<h1 class="text-center d-block">New Easel/Framed Calendars</h1>
		<span class="text-center d-block font-weight-light">Give your desk & wall an eye-catching view each month.</span>
		<div class="row position-relative mt-5">
			<div class="col-12 ol-lg-9">
				<div class="easel-calendar-price-box">
					<div class="easel-info">
						<p class="fz-24 font-weight-light"><b>Choose 2018 calendar printable</b> from variety of calendar templates. Create your own <b>fabulous monthly calendar for 2018.</b> Calendars are printable and comes with <b>holidays and events.</b></p>
						<p class="fz-24 font-weight-light">You can pick up <b>vertical or horizontal</b> as <b>well as square or rounded corners</b> layouts.</p>
						<p class="fz-24 font-weight-light">Calendars printed on 5x7 matte card stock.</p>
						<p class="fz-24 font-weight-light">Printed Calendars can also be availed with <b>Gift Box</b></p>
						<p class="fz-24 font-weight-light">Get your customized {{date('Y')}} calendar now!!</p>
						<p class="fz-24 font-weight-light"><span class="text-blue"><!--From $27.99--></span></p>	
						<a href="{{URL::asset('calendars/easel_calendars')}}"><button type="submit" class="btn btn-primary border-0 rounded-0 fz-24 font-weight-light px-4">Shop easel calendars
						<i class="fa fa-caret-right ml-2" aria-hidden="true"></i></button></a>
					</div>	
				</div>
			</div>
			<div class="easel-cal-img px-3 px-xl-0 text-center mt-3 mt-xl-0"><img class="img-fluid" src="{{URL::asset('public/images/easel-calender.png')}}" alt="easel-calendar"></div>
		</div>
	</section>
	<!-- New Easel Calendars section end -->
	<!-- Calendar shop section start -->
	<section class="calendar-shop-section">
		<h1 class="text-center d-block">Calendars for every space</h1>
		<span class="text-center d-block font-weight-light">Calendar that fits anywhere whether it is your room, kitchen, office desk or wall, keep yourself up to date about important dates and events.</span>
		<div class="row mt-5">
			@foreach($cal_cat as $k => $v)
			<div class="col-sm-6 col-lg-3 mb-4 mb-lg-0">
				<div class="card border-0 rounded-0">
					<div class="product-bg-img"><div class="product-bg-child" style="background-image: url({!! $v['calendar_image_path'] !!});"></div></div>
					<div class="card-body pl-0">
						<h4 class="card-title font-weight-normal"><a href="#">{!! $v['calendar_category'] !!}</a></h4>
						<p class="card-text">{!! $v['content'] !!}</p>
						<span class="text-blue font-weight-bold fz-18 d-block mb-2">{!! $default_currency['currencysymbol'] !!}{!! $v['Size']['price'] !!} </span>
						@if($v['calendar_category']=='Wall Calendars')
							<a href="{{URL::asset('calendars')}}" class="btn btn-primary fz-18 font-weight-light border-0 rounded-0 px-3">Shop Now</a>
						@elseif($v['calendar_category']=='Desk Calendars')
							<a href="{{URL::asset('calendars/desk')}}" class="btn btn-primary fz-18 font-weight-light border-0 rounded-0 px-3">Shop Now</a>
						@else
							<a href="{{URL::asset('calendars/'.strtolower(str_replace(' ','_',$v['calendar_category'])))}}" class="btn btn-primary fz-18 font-weight-light border-0 rounded-0 px-3">Shop Now</a>
						@endif
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</section>
	<!-- Calendar shop section end -->
	<!-- Calander Page Info Start -->
	<section class="clander-page-info pt-5 mt-5 mb-3">
		<div class="row">
			<div class="col-12">
				<h5 class="text-blue">Design Your Own Personalized Calendar</h5>
				<p class="fz-14 mb-4" style="text-align:justify;">This year bring innovation and creativity to your printed calendar with printedcart.com. Customize your calendar whether it is for giving gift on someone’s birthday or occasion, distributing company’s branded calendars to your employees and business associates, we at printecart.com has the best range of collection for your each and every requirement with its unique technology and features. Stage your best designed and printed calendar on your desk, wall or any other area.</p>
				<h5 class="text-blue">Gathering the Images for Your Custom Calendar</h5>
				<p class="fz-14 mb-4" style="text-align:justify;">Printedcart.com has easiest way to get printed of your calendar in moment. You just need to upload your favorite photographs, choose your desired unique template from our collection. That’s it!! We will print it and deliver at your door step as early as possible. We believe in 100% happiness guaranteed tagline. You can have range of collection starting from January to December theme, season wise theme (spring, summer, monsoon, snowfall, etc.), business styles, fashion style and many more. Printedcart.com will provide you whatever you need instantly!! You can have your personalized photoshoot and have it on your desired calendar theme to create ever lasting memories for the year.</p>
				<h5 class="text-blue">Designing Your Unique Calendar</h5>
				<p class="fz-14 mb-4" style="text-align:justify;">Once you have the images ready to upload, it's easier than ever to place them into printed cart easy-to-use templates. You can start your calendar in any month. No longer do you have to worry about wasting months (or money) on pages you won't get to enjoy. With printed cart, when you design your calendar you can choose between 8x11 or 12x12 for a calendar size you will truly love. Once you hammer out the finer details, like what month to start in and what size, you can easily upload your photographs into the month-by-month templates. Printed cart has over 40 different themes to help you create a custom calendar that reflects your unique style.</p>
				<p class="fz-14 mb-4" style="text-align:justify;">We provide various design collection of calendars to suit your need. You can get printed one of the best in class calendar design with printedcart.com. For that, you just need to upload your images into our easy-to-use templates from over 40 different varieties of theme and you can have your calendar ready in minutes. Isn’t that cool? Its cooler when you can choose between 8x11 or 12x12 for a calendar size which will give immense pleasure and satisfaction.</p>
				<h5 class="text-blue">Great Photo Gifts</h5>
				<p class="fz-14 mb-4" style="text-align:justify;">When it comes to gif someone you can rely upon printedcart.com just like your real buddy. We will help you in choosing numerous options to make your calendar gift the best give you ever have given to anybody. We have a wide range of gifting templates which can easily suit your requirement and you can get it done on no time!! We make sure that the photos you upload fits in best manner into our template and give your more option to choose from to finalize the final master piece for your friend, relative, well-wisher, office colleague, siblings, etc. We provide exactly the same thing which you’re looking for!!</p>
			</div>
		</div>
	</section>
	<!-- Calander Page Info End -->
</div>
@endsection