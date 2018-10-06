@extends("layouts.print")

@section("main-content")

<div class="container">

	<?php /*@include('print.banner') */ ?>

	<!-- Large format print section Start -->
	<section class="new-easel-section m-80">
		<!-- upload photos functionality--->
		<div class="row">
			<div class="col-12">
				<!-- print photo content -->
				<div class="content-body">
					@if($errors->any())
						<div class="alert alert-danger alert-dismissible" role="alert" style="margin-top:95px;">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
							{!! $errors->first() !!}
						</div>
					@endif
					<div class="grid">
						<div class="col-12 col-lg-12">
							<div class="col-12 col-lg-9">
							<form name="sizeForm" id="sizeForm">
								<div class="print-poster-price-box" style="border:none;">
									<div class="row">
										@foreach($sizes as $k => $v)
											<div class="col-lg-3">
												<div><b>{{$v['Size']}}</b></div>
												<div class="input-group" style="width:90px">
													<span class="input-group-btn">
														<button rel="default_size_{!!$v['Size']!!}" class="btn btn-white btn-minuse" type="button">-</button>
													</span>
													<input type="text" id="default_size_{!!$v['Size']!!}" name="default_size" rel="{!!$v['Size']!!}" class="form-control no-padding add-color text-center height-25" maxlength="3" value="0" style="width:30px;margin-left:30px;margin-top: 14px;">
													<span class="input-group-btn">
														<button rel="default_size_{!!$v['Size']!!}" class="btn btn-red btn-pluss" type="button">+</button>
													</span>
												</div>
												
												@foreach($sizeTypes as $j => $val)
													<input type="radio" name="txtsizetype_{!!$v['Size']!!}" @if($j==1) checked="checked" @endif id="txtsizetype_{{$k}}_{{$j}}" rel="{{$v['Size']}}" value="{{$val}}"/>
													<label for="txtsizetype">{{$val}}</label><br/>
												@endforeach
												
											</div>
										@endforeach
									</div>	
								</div>
							</form>
							</div>
							<div class="easel-cal-img px-3 px-xl-0 text-center mt-3 mt-xl-0" style="width:25%; border-left-style: dotted;">
								<div style="width:100%;float:left;">
									<div style="width:50%;float:left;"><b>SIZE</b></div>
									<div style="width:50%;float:right;"><b>PRICE</b></div>
								</div>
								@foreach($sizes as $k => $v)
									<div style="width:100%;float:left;">
										<div style="width:50%;float:left;">{{$v['Size']}}</div>
										<div style="width:50%;float:right;">{{$default_currency['currencysymbol']}}{{$v['price']}}</div>
									</div>
								@endforeach
							</div>
							<hr/>
						</div>
						<div class="col-12 col-lg-12">
							<div class="cap-mid" id="photoSection">
								<div class="u-1">
									<div class="grid-content">
										<p>Upload your photos and adjust the size of the prints accordingly</p>
									</div>
								</div>
								<div class="u-1">
									<div class="grid-content">
										<div id="addAlbumBtn">
											<div class="actions center">
												<div id="btnPopover" class="btn btn-primary main" data-hasqtip="18" aria-describedby="qtip-18">
													<span class="photos-ico"></span>Add Photos
													<div class="sweettooth-tab"></div>
												</div>
											</div>
										</div>        
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
				<!-- end print photo content -->
				
			</div>
		</div>
		
		<!-- model -->
		<div id="addPhotoDialog" title="Add Photo">
			{!! Form::open(['method' => 'POST', 'url'=> 'prints/add_photo', 'id' => 'UploadFormImages', 'enctype'=>'multipart/form-data']) !!}
				<div class="row">
					<div class="col-sm-12 form-group" style="text-align:left;">
						{!! Form::label('photo', 'Image (attach one or more photos)', ['class' => 'control-label']) !!}
						{!! Form::file('images[]', ['class' => 'form-control', 'multiple'=>'true', 'required'=>'true','id'=>'bulk_img']) !!}
					</div>
				</div>
				{!! Form::button('Upload', ['class' => 'btn btn-primary', 'id'=>'photoUploadButton']) !!}
			{!! Form::close() !!}
		</div>
		<!-- end model -->
	</section>
	<!-- Large format print section end -->
</div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
$('.btn-minuse').on('click', function(){
	if($(this).parent().siblings('input').val()>0){
		$(this).parent().siblings('input').val(parseInt($(this).parent().siblings('input').val()) - 1)
	}
})

$('.btn-pluss').on('click', function(){
	if($(this).parent().siblings('input').val()<99){
		$(this).parent().siblings('input').val(parseInt($(this).parent().siblings('input').val()) + 1)
	}
})

$("#addPhotoDialog").dialog({
	autoOpen: false,
	width: $(window).width() > 500 ? 500 : 'auto',
	height: 'auto',
	fluid: true,
	responsive: true,
	show: {
		//effect: "blind",
		duration: 1000
	},
	hide: {
		//effect: "explode",
		duration: 1000
	}
});
$( "#btnPopover" ).on( "click", function(){
	var sizeCount = 0;
	$("input[name=default_size]").each(function(){
		if($(this).val()!=0){
			sizeCount++;
			var defaultsize = "<input type='hidden' name='default_size["+$(this).attr('rel')+"]' value='"+$(this).val()+"'>";
			$("#addPhotoDialog .row").after(defaultsize);
			var sizeTypeValue = $("input[name=txtsizetype_"+$(this).attr('rel')+"]:checked").val();
			//alert(sizeTypeValue);
			var sizeType = "<input type='hidden' name='default_size_type["+$(this).attr('rel')+"]' value='"+sizeTypeValue+"'>";
			$("#addPhotoDialog .row").after(sizeType);
		}
	});
	
	if(sizeCount == 0){
		swal("Oops!","Please choose any one size quantity","error");
	}else{
		$("#addPhotoDialog").dialog( "open" );
	}
});

var $ = jQuery.noConflict();
$("#photoUploadButton").on('click',function(){
	
	var files = $('input#bulk_img')[0].files;
	if(files.length < 1){
		swal("Oops!", "Please browse atleast one image...!", "error");
	}else{
		var form = $('#UploadFormImages');
		var data = new FormData();
		//Form data
		var form_data = form.serializeArray();
		$.each(form_data, function (key, input) {
			data.append(input.name, input.value);
		}); 
		//File data
		var file_data = $('input#bulk_img')[0].files;
		for(var i = 0; i < file_data.length; i++){
			data.append("images[]", file_data[i]);
		}
		
		$.ajaxSetup({ 
			headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') } 
		});
		$.ajax({
			type:"POST",
			url:form.attr("action"),
			processData: false,
			contentType: false,
			data: data,
			beforeSend: function(){
				swal("Please Wait...!", "Loading Data...!", "warning");
			},
			success : function(data){
				$("#photoSection").html(data);
				$(".swal-button").trigger('click');
			}
			
		});
		return false;
	}
});

$("#add_to_cart").on('click',function(){
	if($("#printForm").length){
		$("#printForm").submit();
	}else{
		swal("Oops!","Please add photos first...!","error");
	}
});
</script>

@endsection
	
	
	

