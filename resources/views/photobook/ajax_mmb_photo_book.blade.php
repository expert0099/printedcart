<!-- Ajax Photo Book -->
<div id="loading" style="text-align:center;display:none;"></div>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<div class="row">
	@if(count($photo_books) > 0)
		@foreach($photo_books as $k => $v)
		<div class="col-6 col-lg-4">
			<a class="custom-book-hover d-block px-1 py-3" rel="{!! $v['id'] !!}" href="javascript:void(0)">
				<div class="book-size-product" id="{!! $v['id'] !!}">
					<div class="custom-book-size-img mb-2">
						<img class="img-fluid w-50" src="{{URL::asset($v['thumb_left_image'])}}" alt="custom-book-size" style="float:left;">
						<img class="img-fluid w-50" src="{{URL::asset($v['thumb_right_image'])}}" alt="custom-book-size" style="float:left;">
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
<!-- Ajax MMB Photo Book End -->

<script type="text/javascript">
$(function(){
	$('.book-size-product').click(function(){
		var loading = "{{URL::asset('public/images/loader.gif')}}";
		$("#loading").html('<img src="'+loading+'"> <br>loading...'); 
		$("#loading").css('display','block');
		var photobook_id = $(this).attr('id');
		var size_id = $('#choosed_size').val();
		setTimeout(function(){
			$("#mmb_dialog").dialog({
				width: 800,
				height: 572,
				modal: true,
				resizable: false,
			});
			$("#loading").css('display','none');
		},2000);
		$("#photobook_id").val(photobook_id);
		$("#size_id").val(size_id);
			
	});
	/***** check how many images choosed *****/
	$('input#input_files').change(function(){
		var files = $(this)[0].files;
		var error = 0;		
		if(files.length < 10){
			//alert("you have selected "+files.length+" photos. please select minimum 10 photos atleast");
			swal("Oops!", "you have selected "+files.length+" photos. please select minimum 10 photos atleast", "error");
		}else{
			//alert("correct, you have selected "+files.length+" photos");
			for(var i = 0; i < $(this).get(0).files.length; ++i){
				var fileName = $(this).get(0).files[i].name;
				var idxDot = fileName.lastIndexOf(".") + 1;
				var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
				if(extFile=="jpg" || extFile=="jpeg" || extFile=="png" || extFile=="gif"){
					
				}else{
					error = error + 1;
				}
			}
			if(error >0 ){
				swal("Oops!", "Only jpg/jpeg, gif and png files are allowed!", "error")
				.then((value) => {
					$("#style_form").trigger("reset");
				});
			}else{
				swal("Correct!", "You have selected "+files.length+" photos", "success");
			}
		}
	});
	/***** end check how many images choosed *****/
	/***** submit form data *****/
	$('#sendToDesignerButton').on('click',function(){
		if($("#mybook_name").val() == ''){
			swal("Oops!", "Book name can not be empty", "error");
		}else if($("#input_files").val() == ''){
			swal("Oops!", "Photos can not be empty", "error");
		}else{
			swal("Please Wait...!", "Sending data to server...!", "warning");
		}
	});
	/***** end submit form data *****/
});