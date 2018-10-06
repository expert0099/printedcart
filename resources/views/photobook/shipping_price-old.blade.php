@extends("layouts.photobook")

@section("main-content")

<section class="choose-book-size">
	<div class="container">
		<span style="padding-left:130px;"></span>
		@foreach($size as $k => $value)
			<img class="img-fluid" src="{{URL::asset('public/images/'.$value['Size'].'.png')}}" alt="book-size" rel="{{ $value['Size'] }}" p="{{ $value['id'] }}">
		@endforeach
		
		<div class="row pt-2 page-top-gapping">
			@foreach($shipping_category as $k => $val)
			<div class="pt-0 mt-0" style="border:1px solid #ccc;">
				<div id="header_bg">{!!$val['shipping_category']!!}</div>
				<div id="photobook_price">
				<span style="width:165px;float:left;">1 photo book</span>
				@foreach($val['price'] as $m => $v)
					@if(isset($v[0]))
						<span class="cl_span">{!!$default_currency['currencysymbol']!!}{!!$v[0]['price']!!}</span>
					@else
						<span class="cl_span">N/A</span>
					@endif
				@endforeach
				</div>
				<div id="photobook_xtra">
				<span style="width:165px;float:left;">Each additional book</span>
				@foreach($val['price'] as $m => $v)
					@if(isset($v[0]))
						<span class="cl_span">{!!$default_currency['currencysymbol']!!}{!!$v[0]['inc_price']!!}</span>
					@else
						<span class="cl_span">N/A</span>
					@endif
				@endforeach
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>
<style>
#header_bg {
	width: 1064px !important;
	background-color: #ccc;
	text-align: center;
	color: white;
	font-weight: 600;
}
.cl_span{
	width:125px;
	display:inline-block;
	font-size:13px;
}
</style>
@endsection