@extends("layouts.photobook")

@section("main-content")

<section class="choose-book-size">
	<div class="container">
		<div class="row pt-2">
		@foreach($size as $k => $value)
			<span style="padding-left:20px;padding-right:20px;">
				<img class="img-fluid" src="{{URL::asset('public/images/'.$value['Size'].'.png')}}" alt="book-size" rel="{{ $value['Size'] }}" p="{{ $value['id'] }}">
			</span>
		@endforeach
		</div>
		<div class="row pt-2 page-top-gapping">
			@foreach($cover_category as $k => $val)
			<div class="pt-0 mt-0" style="width:100%;padding-left:15px;padding-right:15px;">
				<div id="header_bg">{!!$val['cover_category']!!}</div>
				<div id="photobook_price" style="padding-left:10px;">
				
				@foreach($val['sub_category'] as $m => $v)
					<div>{!!$v['cover_sub_category']!!}</div>
					<div>
					@foreach($v['cover_price'] as $n => $g)
					<span style="float:left;width:165px;">{!!$default_currency['currencysymbol']!!}{!!$g['price']!!}</span>
					@endforeach
					</div>
					
				@endforeach
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>
<style>
#header_bg {
	width: 100% !important;
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