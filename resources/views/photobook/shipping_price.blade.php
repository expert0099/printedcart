@extends("layouts.photobook")

@section("main-content")

<section class="choose-book-size tst">
	<div class="container coverPricingSection">
		<p style="padding-top:20px;">Shipping Pricing</p>
		<div class="book-size-list" style="padding-top:0px;padding-left:150px;">
		@foreach($size as $k => $value)
			<img class="img-fluid" src="{{URL::asset('public/images/'.$value['Size'].'.png')}}" alt="book-size" rel="{{ $value['Size'] }}" p="{{ $value['id'] }}" style="margin-right:0px;margin-left:10px;">
		@endforeach
		</div>
		<div class="row pt-2 page-top-gapping" style="margin-right:0px;margin-left:0px;">
			@foreach($shipping_category as $k => $val)
			<div class="pt-0 mt-0 mb-4 w-100" style="border:1px solid #ccc;">
				<div id="header_bg">{!!$val['shipping_category']!!}</div>
				<div class="coverPricingTable">
				<div class="table-style">
				<div id="photobook_price">
				<span>1 photo book</span>
				@foreach($val['price'] as $m => $v)
					@if(isset($v[0]))
						<span class="cl_span">{!!$default_currency['currencysymbol']!!}{!!$v[0]['price']!!}</span>
					@else
						<span class="cl_span">N/A</span>
					@endif
				@endforeach
				</div>
				<div id="photobook_xtra">
				<span>Each additional book</span>
				@foreach($val['price'] as $m => $v)
					@if(isset($v[0]))
						<span class="cl_span">{!!$default_currency['currencysymbol']!!}{!!$v[0]['inc_price']!!}</span>
					@else
						<span class="cl_span">N/A</span>
					@endif
				@endforeach
				</div>
				</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>
<style>
#header_bg {
	width: 100% !important;
	background-color: #969fa2;
	text-align: center;
	color: white;
	font-weight: 600;
	padding: 7px 0 11px;
	font-size: 18px;
}
.cl_span{
	font-size:14px;
	line-height: 1.5rem!important;
	color:#525252;
}
span {
	font-size: 12px;
	line-height: 1.5rem;
	color:#525252;
}
</style>
@endsection