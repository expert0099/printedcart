<h1 class="d-block text-center py-5">Choose your photo book size to get started in Simple Path</h1>

<section class="choose-book-size">
	<div class="container">
		<div id="owl-demo" class="owl-carousel owl-theme py-4">  
			@foreach($size['Size'] as $k => $value)
			<div class="item">
				<a href="{{URL::asset('photobooks/editor_simple_path/'.$value['id'])}}">
					<div class="book-size-box">
						<div class="book-size-img d-flex align-items-end position-relative">
							<img class="img-fluid" src="{{URL::asset('public/images/'.$value['Size'].'.png')}}" alt="book-size" rel="{{ $value['Size'] }}" p="{{ $value['id'] }}">
							<img class="img-fluid book-hover" src="{{URL::asset('public/images/'.$value['Size'].'-hover.png')}}" alt="book-size" rel="{{ $value['Size'] }}" p="{{ $value['id'] }}">
						</div>
						<div class="book-size-info mt-3">
							@if($promocode['saving_type']=='Flat')
							<p class="mb-0 fz-14 text-blue"><strike>From {!! $value['Currency']['currencysymbol'] !!}{!! $value['price'] !!}</strike> {!! $value['Currency']['currencysymbol'] !!}{!! $value['price'] - $promocode['amount_limit']!!}</p>
							<p class="mb-0 fz-14 text-blue">Save {!! $value['Currency']['currencysymbol'] !!}{!! $promocode['amount_limit'] !!} flat</p>
							<p class="mb-0 fz-14 text-blue">code: {!! $promocode['Coupon']['coupon'] !!}</p>
							@else
							<p class="mb-0 fz-14 text-blue"><strike>From {!! $value['Currency']['currencysymbol'] !!}{!! $value['price'] !!}</strike> {!! $value['Currency']['currencysymbol'] !!}{!! number_format($value['price'] - ($promocode['amount_limit']/100)*$value['price'],2) !!}</p>
								@if($promocode['Coupon']['coupon'])
									<p class="mb-0 fz-14 text-blue">Save {!! $promocode['amount_limit'] !!}%</p>
									<p class="mb-0 fz-14 text-blue">code: {!! $promocode['Coupon']['coupon'] !!}</p>
								@endif
							@endif
						</div>
					</div>
				</a>
			</div>
			@endforeach
        </div>
	</div>
</section>
		
<div class="see-price-details">
	<div class="col-12 text-center mt-4">
		<a href="{{URL::asset('photobooks/cover_pricing_detail')}}" class="btn btn-primary border-0 rounded-0 px-4 text-white">See cover and pricing details</a>
	</div>
</div>