<!-- Ajax Photo Book -->
<!--<div id="loading" style="text-align:center;"></div>-->
<?php 
/* echo '<pre>';
print_r($data);exit; */
?>
<style>
.left-col {
    padding-right: 10px;
    vertical-align: top;
    font-family: Avenir LT W01\ 65 Medium,Verdana,Arial,sans-serif;
    color: #58595b;
    display: inline-block;
}
.right-col {
    text-align: right;
    font-family: Avenir LT W01\ 55 Roman,Verdana,Arial,sans-serif;
    font-size: 13px;
    color: #369;
    display: inline-block;
}
.description {
    font-size: 13px;
    line-height: 1.6;
    margin-top: 22px;
    height: 143px;
    overflow: hidden;
}
#size-cover-container {
    text-align: right;
    margin-top: 16px;
}
.right-col #size-cover-container .pricingTable-select {
    width: 285px;
    margin-bottom: 5px;
    font-family: Avenir LT W01\ 55 Roman,Verdana,Arial,sans-serif;
    font-size: 13px;
    color: #000;
}
#pricing-table-container{float:right;}
</style>

<div class="content-container row">
	<div class="left-col col-6">
		<div class="heading1 storytelling">{{ $data['photobook']['photo_book'] }}</div>
		<div class="description">{{ $data['photobook']['content'] }}</div>
	</div>
	
	<div class="right-col col-6">
		{!! Form::open(['method' => 'POST','url'=>'photobooks/custom_path','name'=>'style_form']) !!}
		<input type="hidden" name="photobook_id" value="{{ $data['photobook']['id'] }}">
		<div class="clear"></div>
		<div id="size-cover-container">
			Project : <input style="width:170px;" type="text" name="project_name" required placeholder="Project Name">
			<br><br>
			
			Size : <select style="width:170px;" id="pricingTable-size-select" name="photobook_size" class="pricingTable-select">
				@foreach($data['size'] as $k => $value)
					@if($value['id'] == $data['size_id'])
						<option value="{{ $value['id'] }}" selected="selected">{{ $value['Size'] }}</option>
					@else
						<option value="{{ $value['id'] }}">{{ $value['Size'] }}</option>
					@endif
				@endforeach
			</select>
			<br><br>
			Cover : <select style="width:170px;" id="pricingTable-cover-select" name="photobook_cover" class="pricingTable-select">
				@foreach($data['covers'] as $k => $val)
				<option value="{{ $k }}">{{ $val }}</option>
				@endforeach
			</select>
		</div>
		<div id="pricing-table-container">
			<div id="pricing-table">
				<div id="loading" style="text-align:center;"></div>
				<table class="item-pricing">
					<tbody>
						<tr class="">
							<td class="item-description">20 pages included</td>
							<td class=""></td>
							<td class="">{!! $data['default_currency']['currencysymbol'] !!}{!! number_format($data['size'][0]['price'],2) !!}</td>
							<input type="hidden" name="photobook_price" id="photobook_price" value="{!! number_format($data['size'][0]['price'],2) !!}"/>
						</tr>
						<tr class="">
							<td class="item-description">Cover Page</td>
							<td class=""></td>
							<td class="">{!! $data['default_currency']['currencysymbol'] !!}{!! number_format($data['photobook_cover_price']['price'],2) !!}</td>
							<input type="hidden" name="photobook_cover_price" id="photobook_cover_price" value="{!! number_format($data['photobook_cover_price']['price'],2) !!}"/>
						</tr>
						<tr class="">
							<td class="item-description">Each additional page</td>
							<td class=""></td>
							<td class="">{!! $data['default_currency']['currencysymbol'] !!}{!! number_format($data['size'][0]['price']/20,2) !!}</td>
							<input type="hidden" name="extra_page_price" id="extra_page_price" value="{!! number_format($data['size'][0]['price']/20,2) !!}"/>
						</tr>
					</tbody>
				</table>
			</div>
			<button id="sflyBtnContainer" type="submit">
				<span id="chooseStyleBtn" class="btn btn-sm btn-primary">Select this style</span>
			</button>
		</div>
		
		{!! Form::close() !!}
	</div>
	
	<div class="clear">&nbsp;</div>
</div>


<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/redmond/jquery-ui.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
<script type="text/javascript">
$(function(){
	//$( "#tabs" ).tabs();
	var base_path = "<?php echo config('app.url');?>";
	var loading = "{{URL::asset('public/images/loader.gif')}}";
	$('#pricingTable-size-select').change(function(){
		var size_id = $(this).val();
		var cover_id = $('#pricingTable-cover-select').val();
		$.ajax({
			method: 'get',
			url: base_path+'photobooks/get_photobook_price/'+size_id+'/'+cover_id,
			beforeSend: function(){$("#loading" ).html('<img src="'+loading+'"> <br>loading...');},
			success: function(data){
				$("#pricing-table").html(data);
			},
			error: function(e) {
				var json = JSON.stringify(e);
			}
		});
	});
	$('#pricingTable-cover-select').change(function(){
		var cover_id = $(this).val();
		var size_id = $('#pricingTable-size-select').val();
		$.ajax({
			method: 'get',
			url: base_path+'photobooks/get_photobook_price/'+size_id+'/'+cover_id,
			beforeSend: function(){$("#loading" ).html('<img src="'+loading+'"> <br>loading...');},
			success: function(data){
				$("#pricing-table").html(data);
			},
			error: function(e) {
				var json = JSON.stringify(e);
			}
		});
	});
	
});
</script>