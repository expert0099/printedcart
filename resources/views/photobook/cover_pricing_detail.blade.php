@extends("layouts.photobook")

@section("main-content")

<section class="choose-book-size">
	<div class="container coverPricingSection">
		<p style="padding-top:20px;">Cover and Pricing Details</p>
		<div class="book-size-list" style="padding-top:0px;">
		@foreach($size as $k => $value)
			<img class="img-fluid" src="{{URL::asset('public/images/'.$value['Size'].'.png')}}" alt="book-size" rel="{{ $value['Size'] }}" p="{{ $value['id'] }}" style="margin-left:10px;margin-right:0px;">
		@endforeach
		</div>
		<div class="row pt-2 page-top-gapping" style="margin-left:0px;margin-right:0px;">
			@foreach($cover_category as $k => $val)
			<div class="pt-0 mt-0 mb-4" style="width:100%;border: 1px solid #eadddd;">
				<div id="header_bg">{!!$val['cover_category']!!}</div>
				<div class="coverPricingTable">
				<div class="table-style">
				<div id="photobook_price">
				
				@foreach($val['sub_category'] as $m => $v)
					<div class="sub">{!!$v['cover_sub_category']!!}</div>
					<div>
					@foreach($v['cover_price'] as $n => $g)
					<span>{!!$default_currency['currencysymbol']!!}{!!number_format($g['price'],2)!!}</span>
					@endforeach
					</div>
					
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
span {
	float: left;
	width: 14.28%;
	font-size: 14px;
	line-height: 2.0rem;
	color:#525252;
	padding-left:10px;
	border: 1px solid #eadddd;
}
.sub{
	color:#525252;
	padding-left:10px;
	font-weight:500;
	line-height: 2.0rem;
}
/*.cl_span{
	width:125px;
	display:inline-block;
	font-size:13px;
}*/
</style>
@endsection