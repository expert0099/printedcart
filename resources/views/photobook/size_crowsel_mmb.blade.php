<h1 class="d-block text-center py-5">Choose your photo book size to get started in Simple Path</h1>
<section class="choose-book-size">
	<div class="container">
		<div id="owl-demo" class="owl-carousel owl-theme py-4">
			@foreach($size['Size'] as $k => $value)
			<div class="item">
				<a href="javascript:void(0);">
					<div class="book-size-box">
						<div class="book-size-img d-flex align-items-end position-relative">
							<img class="img-fluid" src="{{URL::asset('public/images/'.$value['Size'].'.png')}}" alt="book-size" rel="{{ $value['Size'] }}" p="{{ $value['id'] }}">
							<img class="img-fluid book-hover" src="{{URL::asset('public/images/'.$value['Size'].'-hover.png')}}" alt="book-size" rel="{{ $value['Size'] }}" p="{{ $value['id'] }}">
						</div>
						<div class="book-size-info mt-3">
							<p class="mb-0 fz-14 text-blue">From {!! $value['Currency']['currencysymbol'] !!}{!! $value['price'] !!}</p>
						</div>
					</div>
				</a>
			</div>
			@endforeach
		</div>
	</div>
</section>