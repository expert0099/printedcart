<!-- Ajax Photo Book -->
<!--<div id="loading" style="text-align:center;"></div>-->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<div class="row">
	<div id="loading" style="width:100%;text-align:center;display:none;"></div>
	@if(count($photo_books) > 0)
		@foreach($photo_books as $k => $v)
		<div class="col-6 col-lg-4">
			<a class="custom-book-hover d-block px-1 py-3" rel="{!! $v['id'] !!}" href="javascript:void(0)">
				<div class="book-size-product">
					<div class="custom-book-size-img mb-2">
						<img class="img-fluid w-50" src="{{URL::asset($v['thumb_left_image'])}}" alt="custom-book-size" style="float:left;">
						<img class="img-fluid w-50" src="{{URL::asset($v['thumb_right_image'])}}" alt="custom-book-size" style="float:left;">
						<!--{!! $v['thumb_left_image'] !!}{!! $v['thumb_right_image'] !!} -->
					</div>
					<div class="book-title text-center">
						<p class="fz-14 m-0">{!! $v['photo_book'] !!}</p>
					</div>
				</div>
			</a>
		</div>	
		@endforeach	
		<div class="cal-product-list-pagination w-100 py-5">
			{!! $photo_books->links() !!}
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
<!-- Ajax Photo Book End -->

<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/redmond/jquery-ui.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
<script>
if (top !== self) {
	$.ui.dialog.prototype._focusTabbable = $.noop;
}
</script>
<div id="dialog" title="Printed Cart" style="display:none;">
	<!--<div id="tabs">
		<ul>
			<li><a href="#backbrounds">Backgrounds</a></li>
			<li><a href="#embellishments">Embellishments</a></li>
			<li><a href="#ideapages">Idea Pages</a></li>
		</ul>
		<div id="backbrounds">
			<p>Backgrounds</p>
		</div>
		<div id="embellishments">
			<p>Embellishments</p>
		</div>
		<div id="ideapages">
			<p>Idea Pages</p>
		</div>
	</div>-->
	
</div>

<script type="text/javascript">
$(function(){
	/****** modal ******/
	var loading = "{{URL::asset('public/images/loader.gif')}}";
	var base_path = "<?php echo config('app.url');?>";
	$('.py-3').click(function(){
		//$('body').addClass('overflow_hide');
		//$( "#tabs" ).tabs();
		var rel = $(this).attr('rel');
		var size_id = $('#choosed_size').val();
		$.ajax({
			method: 'get',
			url: base_path+'photobooks/get_book_styles/'+rel+'/'+size_id,
			beforeSend: function(){
				$("#loading").html('<img src="'+loading+'"> <br>loading...');
				$("#loading").css('display','block');
			},
			success: function(data){
				$("#dialog").html(data);
				$("#dialog").dialog({
					width: 800,
					height: 400,
					modal: true,
					resizable: false,
					position: 'center',
				});
				$("#loading").css('display','none');
			},
			error: function(e) {
				var json = JSON.stringify(e);
			}
		});
		
	});
	/****** end modal ******/
	
	/* $('#sflyBtnContainer').click(function(){
		alert('asdf');
		$('body').removeClass('overflow_hide');
	});
	$('.ui-dialog .ui-dialog-titlebar-close').click(function(){
		alert('asdf');
		$('body').removeClass('overflow_hide');
	}); */
});


</script>