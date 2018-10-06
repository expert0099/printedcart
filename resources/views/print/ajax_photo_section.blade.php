<script>
var errors_massage = [];
</script>
@if(isset($response['error']) && !empty($response['error']))
	<script>
	var m_error = "<?php echo $response['err_msg'];?>";
	var m_error_msg = '<p class="alert alert-danger"><a href="#" onclick="show_error()" class="show_error" style="color:#721c24;">'+m_error+'</a></p>';
	errors_massage.push(m_error_msg);
	
	var error_info = '<div class="show_error_info alert alert-danger" style="display:none;"><span onclick="hide_error()" style="cursor:pointer;position:absolute;right:5px;top:5px;">X</span>';
	</script>
	@foreach($response['error'] as $k => $error)
		<script>
		var error = "<?php echo $error;?>";
		error_info += '<p class="alert alert-danger">'+error+'</p>';
		</script>
	@endforeach
	<script>
	error_info += "</div>";
	errors_massage.push(error_info);
	$('#addPhotoDialog .row').before(errors_massage);
	$("#addPhotoDialog").dialog( "open" );
	</script>
@else
	<script>
	$("#addPhotoDialog").dialog( "close" );
	</script>
@endif

<script>
function show_error(){
	$(".show_error_info").attr("style","display:block");
}
function hide_error(){
	$(".show_error_info").attr("style","display:none");
}

$('.btn-minuse').on('click', function(){
	if($(this).parent().siblings('input').val()>0){
		$(this).parent().siblings('input').val(parseInt($(this).parent().siblings('input').val()) - 1);
	}
})

$('.btn-pluss').on('click', function(){
	if($(this).parent().siblings('input').val()<99){
		$(this).parent().siblings('input').val(parseInt($(this).parent().siblings('input').val()) + 1);
		var rel = $(this).attr('rel');
		var p = $(this).attr('p');
		var path = $("#photoSection_"+p+" .uploaded_image img").attr('src');
		var sizeType = $("input[name=txtsizetype_"+rel+"_"+p+"]:checked").val();
		var base_path = "<?php echo config('app.url');?>";
		$.ajaxSetup({ 
			headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') } 
		});
		$.ajax({
			type:"POST",
			url:base_path+'prints/alter_image',
			data: {rel:rel,p:p,path:path,sizeType:sizeType},
			beforeSend: function(){
				swal("Please Wait...!", "Loading Data...!", "warning");
			},
			success : function(data){
				$("#photoSection_"+p+" #print_photos").append(data);
				$(".swal-button").trigger('click');
			}
		});
		return false;
	}
})
</script>
<hr style="width:100%;"/>
@if(count($showfilename)>0)
	<?php /*@foreach($choozed_default_size as $s => $val)*/?>
		<form name="printForm" id="printForm" method="post" action="{{URL::asset('prints/print_form_submit')}}">
		{{csrf_field()}}
		@foreach($showfilename as $f => $uploaded_files)
		<div class="col-12 col-lg-12" id="photoSection_{{$f}}">

			<div class="easel-cal-img px-3 px-xl-0 text-center mt-3 mt-xl-0" style="width:25%; border-left-style: dotted; overflow:scroll;height:300px;" id="print_photos">
				@foreach($default_size as $m => $custom)
				<?php 
				$up_wi = explode("x",$custom);
				if($up_wi[0]>$up_wi[1]){
					$ratio = $up_wi[1]/$up_wi[0]*100;
					$width = 100;
					$height = round($ratio);
				}else{
					$ratio = $up_wi[0]/$up_wi[1]*100;
					$width = round($ratio);
					$height = 100;
				}
				?>
				<div class="uploaded_image">
					<img id="uploaded_image_{{$custom}}" src="{{URL::asset('public/'.$showfilepath.'/'.$uploaded_files)}}" style="width:{{$width}}px;height:{{$height}}px;"><br/>
					{{$custom}} {{$choose_default_size_type[$custom]}}
				</div>
				@endforeach
				<input type="hidden" name="image_path[{{$f}}]" value="{{$showfilepath.'/'.$uploaded_files}}">
			</div>
			
			<div class="col-12 col-lg-9">
				<div class="print-poster-price-box" style="border:none;">
				
					<div class="row">
						@foreach($sizes as $k => $v)
						<div class="col-lg-3">
							<div><b>{{$v['Size']}}</b></div>
							<div class="input-group" style="width:90px">
								<span class="input-group-btn">
									<button p="{{$f}}" rel="{{$v['Size']}}" class="btn btn-white btn-minuse" type="button">-</button>
								</span>
								<input type="hidden" name="size_id[{{$f}}][{{$v['Size']}}]" value="{{$v['id']}}">
								@if(array_key_exists($v['Size'],$choozed_default_size))
								<input type="text" id="default_size_{{$v['Size']}}" name="size_qty[{{$f}}][{{$v['Size']}}]" rel="{{$v['Size']}}" class="form-control no-padding add-color text-center height-25" maxlength="3" value="{{$choozed_default_size[$v['Size']]}}" style="width:30px;margin-left:30px;margin-top: 14px;">
								@else
								<input type="text" id="default_size_{{$v['Size']}}" name="size_qty[{{$f}}][{{$v['Size']}}]" rel="{{$v['Size']}}" class="form-control no-padding add-color text-center height-25" maxlength="3" value="0" style="width:30px;margin-left:30px;margin-top: 14px;">	
								@endif
								<span class="input-group-btn">
									<button p="{{$f}}" rel="{{$v['Size']}}" class="btn btn-red btn-pluss" type="button">+</button>
								</span>
							</div>
							@foreach($sizeTypes as $j => $value)
								@if(isset($choose_default_size_type[$v['Size']]) && $choose_default_size_type[$v['Size']]==$value)
									<input type="radio" checked="checked" name="txtsizetype[{{$f}}][{{$v['Size']}}]" id="txtsizetype_{{$k}}_{{$j}}" rel="{{$v['Size']}}" value="{{$value}}"/>
								@else
									<input type="radio" @if($j==1) checked="checked" @endif name="txtsizetype[{{$f}}][{{$v['Size']}}]" id="txtsizetype_{{$k}}_{{$j}}" rel="{{$v['Size']}}" value="{{$value}}"/>
								@endif
								<label for="txtsizetype">{{$value}}</label><br/>
							@endforeach
						</div>
						@endforeach
						
					</div>	
					<hr style="width:100%;"/>
					<div class="row">
						<div class="col-12 col-lg-3">
						<label for="border_color">Border Color</label>
						<span>
							<select name="border_color[{{$f}}]">
								<option value="Black">Black</option>
								<option value="White">White</option>
							</select>
						</span>
						</div>
						<div class="col-12 col-lg-3">
						<label for="border">Border Size</label>
						<span>
							<select name="border[{{$f}}]">
								<option value=".1">.1</option>
								<option value=".2">.2</option>
								<option value=".4">.4</option>
								<option value=".6">.6</option>
								<option value=".8">.8</option>
								<option value="1.2">1.2</option>
								<option value="1.5">1.5</option>
							</select>
						</span>
						</div>
						<div class="col-12 col-lg-6">
						<label for="print_message">Back of print message</label>
						<span>
							<textarea name="print_message[{{$f}}]"></textarea>
						</span>
						</div>
					</div>
				
				</div>
				<hr style="width:100%;"/>
			</div>
			
		</div>
		
	@endforeach
	</form>
@endif