<div id="loading" style="text-align:center;"></div>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<div class="row">
	@if(count($cal_styles) > 0)
		@foreach($cal_styles as $k => $value)
		<div class="col-6 col-lg-4 col-xl-3 pt-4">
			<div class="cal-product position-relative">
				<div class="cal-product-img">
					<!--{!! $value['photo'] !!}-->
					<img class="img-fluid w-100" src="{{ URL::asset($value['photo']) }}" alt="calendar-img">
				</div>
				<div class="cal-product-middle">
					<div class="cal-product-text">
						<a href="{{ URL::asset('calendars/cal_editor/'.$value['id'].'/'.$calendar_size_id.'/'.$value['calendar_category_id'].'/'.$month.'/'.$year) }}" class="btn btn-primary rounded-0 border-0 fz-16 pl-4 pr-4 font-weight-light">Personalize</a>
						<!--<div class="cal-product-fav bg-blue rounded-circle d-flex align-items-center justify-content-center mt-5 ml-auto mr-auto">
							<i class="fa fa-heart-o" aria-hidden="true"></i>
						</div>-->
					</div>
				</div>
			</div>
			<a href="#"><h6 class="fz-14 d-flex align-items-center justify-content-center text-center py-2">{!! $value['calendar_style'] !!}</h6></a>
		</div>
		@endforeach
		<div class="cal-product-list-pagination w-100 py-5">
			{!! $cal_styles->links() !!}
		</div>
	@else
		<div class="col-12 col-lg-12">
			<p style="text-align:center;color:red;">No records found. !!!</p>
		</div>
		<script>
		$(function(){
			swal("Oops!", "No records found...!", "error");
		});
		</script>
	@endif
</div>