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
	<div class="row calendars-form-section no-gutters mt-5 py-3 collagePostersSec">
	
		<div class="col-md-12 col-lg-4">
			<div class="calendar-promo-box text-center px-3 pl-6 pr-6 py-3">
				<h4>College Poster</h4>
				<img src="{{URL::asset($college_poster['college_poster_img'])}}" style="width:250px;border-radius:5px;"/>
			</div>
		</div>
		
		{!! Form::open(['method' => 'POST','url'=>'prints/colposter','style'=>'width:66%;display:flex;']) !!}
		<div class="col-md-12 col-lg-4">
			<div class="calendar-promo-box text-center py-3" style="width:290px;">
				<h4 class="font-weight-light mb-3">College Poster</h4>
				<div class='frm-abc'>
				{{$college_poster['content']}}
				</div>
			</div>	
			<input type="hidden" name="poster_category" id="poster_category" value="{{$college_poster['id']}}"/>
			<input type="hidden" name="poster_id" id="poster_id" value="{{$poster_id}}"/>
		</div>
		
		<div class="col-md-12 col-lg-4">
			<div class="calendar-month-form px-3 px-md-5 px-lg-3 pl-6 pr-6 py-3" style="width:425px;">
				<h6 class="font-weight-light mb-4">Start your poster size and year</h6>
				<div class="form-row">
					<?php 
					echo '<pre>';
					print_r($college_poster_sizes);exit;
					?>
					<div class="col-12 col-sm-6 mb-3 mb-sm-0">
						<label class="col-12 mb-1" for="exampleInputEmail1">Size</label>
						<select id="size_id" name='size_id' class="form-control rounded-0">
						<?php
						foreach($college_poster_sizes as $k => $val){
							if($k==0){
							?>
							<option value="<?php echo $val['id'];?>" selected="selected" rel="<?php echo $val['Size'];?>" p="<?php echo $val['price'];?>"><?php echo $val['Size'];?></option>
							<?php 
							}else{
								?>
								<option value="<?php echo $val['id'];?>" rel="<?php echo $val['Size']['Size'];?>" p="<?php echo $val['price'];?>"><?php echo $val['Size']['Size'];?></option>
								<?php
							} 
						}
						?>
						</select>	
					</div>
					<?php /*
					<div class="col-12 col-sm-6 mb-3 mb-sm-0">
						<label class="col-12 mb-1" for="exampleInputEmail1">Year</label>
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
					</div> */?>
					<div class="col-12 mt-4">
						<button type="submit" class="btn btn-primary border-0 rounded-0 px-4">Get Started <i class="fa fa-caret-right ml-2" aria-hidden="true"></i></button>
					</div>					
				</div>
			</div>
			
			<div class="px-3 px-md-5 px-lg-3 pl-6 pr-6 py-3 callegePosterSection" style="width:425px;">
				<h6 class="font-weight-light">College Poster Pricing</h6>
				<div style="width:100%">
					<div style="width:70%;float:left;"><strong>Item</strong><br>College Poster <span id="poster_size">{{$college_poster_sizes[0]['Size']['Size']}}</span></div>
					<div><strong>Price</strong><br>{{$default_currency['currencysymbol']}}<span id="poster_price">{{$college_poster_sizes[0]['Size']['price']}}</span></div>
				</div>
			</div>
			
		</div>
		
		{!! Form::close() !!}
		
	</div>
	<!-- Calendars form End -->
</div>
<script>
$(document).ready(function(){
	$('#size_id').on('change',function(){
		var size = $('option:selected', this).attr('rel');
		var price = $('option:selected', this).attr('p');;
		$('#poster_size').text(size);
		$('#poster_price').text(price);
	});
});
</script>

@endsection