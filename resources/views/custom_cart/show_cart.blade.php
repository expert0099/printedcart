@extends("layouts.print")

@section("main-content")

<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/custom.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/font-awesome.min.css') }}">

<div class="container">

	@if($errors->any())
		<div class="alert alert-danger alert-dismissible" role="alert" style="margin-top:95px;">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			{!! $errors->first() !!}
		</div>
	@endif

	<!-- cart section -->
	@if(count($cartData)>0)
	{!! Form::open(['method' => 'POST','url'=>'payment_process','name'=>'style_form']) !!}
	<section class="cart-info-box" style="margin-top: 10em;">
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-8" style="padding-right:100px;">
					<div class="shipping-info-box">
						<h4 class="font-weight-normal mb-4">Shipping Information</h4>
						@if(count($shipping_address)>0)
							<span><input type="radio" checked name="shipping_address" rel="{{$shipping_address->id}}"/> Primary </span>
							<br>
						@endif
						
						@if(count($multi_address)>0)
							@foreach($multi_address as $k => $val)
								<span><input type="radio" name="shipping_address" rel="{{$val->id}}"/> 
								{{$val->address_type}}</span>
								<br>
							@endforeach
						@endif
						
						<div class="form-row">
							<hr style="width:100%;"/>
							<div class="form-group col-md-6" style="text-align:left;">
								<label for="shipping_firstname">First Name</label>
								<input type="text" class="form-control" name="shipping_firstname" id="shipping_firstname" value="{{$shipping_address->first_name}}"/>
								<label for="shipping_lastname">Last Name</label>
								<input type="text" class="form-control" name="shipping_lastname" id="shipping_lastname" value="{{$shipping_address->last_name}}"/>
							</div>
							<div class="form-group col-md-6" style="text-align:left;">
								<label for="shipping_email">Email</label>
								<input type="text" class="form-control" name="shipping_email" id="shipping_email" value="{{$shipping_address->email}}"/>
								<label for="shipping_address">Address</label>
								<textarea class="form-control" name="shipping_address" id="shipping_address" rows="2">{{$shipping_address->street}}</textarea>
							</div>
							<div class="form-group col-md-6" style="text-align:left;">
								<label for="shipping_city">City</label>
								<input type="text" class="form-control" name="shipping_city" id="shipping_city" value="{{$shipping_address->city}}"/>
								<label for="shipping_state">State</label>
								<input type="text" class="form-control" name="shipping_state" id="shipping_state" value="{{$shipping_address->state}}"/>
							</div>
							<div class="form-group col-md-6" style="text-align:left;">
								<label for="shipping_zipcode">Zip Code</label>
								<input type="text" class="form-control" name="shipping_zipcode" id="shipping_zipcode" value="{{$shipping_address->zipcode}}"/>
								<label for="shipping_country">Country</label>
								<input type="text" class="form-control" name="shipping_country" id="shipping_country" value="{{$shipping_address->country}}"/>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-4" style="border-left: 1px solid #ccc; padding-left: 100px;">
					<div class="delvery-option-box">
						<h4 class="font-weight-normal mb-4">Delevery Option</h4>
						<div class="custom-controls-stacked">
							@foreach($ship_cat as $k => $v)
							<label class="custom-control custom-radio">
								@if($k == 0)
								<input id="radioStacked{{$k}}" checked="checked" name="shipping_price" type="radio" class="custom-control-input" required="true" value="{{$price[$k]}}"/>
								@else
								<input id="radioStacked{{$k}}" name="shipping_price" type="radio" class="custom-control-input" required="true" value="{{$price[$k]}}"/>	
								@endif
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">{{$default_currency['currencysymbol']}}{{$price[$k]}} - {{$v}} shipping</span>
							</label>
							@endforeach
						</div>			
					</div>			
				</div>
			</div>
		</div>
	</section>
	<section class="cart-item-list mt-5">
		<div class="container">
			
			<table id="cart" class="table table-hover table-condensed cartlistitemSec">
				<thead>
					<tr>
						<th style="width:40%"></th>
						<th style="width:10%">Print of set</th>
						<th style="width:20%">Price</th>
						<th style="width:10%">Qty.</th>
						<th style="width:20%" class="text-center">Subtotal</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				$total = 0;
				$sep = '';
				?>
				@foreach($cartData as $k => $cd)
					<tr>
						<td data-th="Product" style="width:350px;">
							<div class="row">
								<div class="col-12 col-md-3"><img src="{{URL::asset('public/'.$cd->image_path)}}" alt="..." class="img-responsive"/></div>
							</div>
						</td>
						<td data-th="print_of_set">
							{{$cd->size}}
						</td>
						<td data-th="Price">		
							{{$default_currency['currencysymbol']}}{{$cd->price}}
							<input type="hidden" name="price[]" id="price_{{$k}}" value="{{$cd->price}}"/>
						</td>
						<td data-th="Quantity">
							<input type="number" name="qty[]" id="qty_{{$k}}" class="form-control text-center qty" value="{{$cd->qty}}" style="width:80px;" rel="{{$k}}">
						</td>
						<td data-th="Subtotal" class="text-center">
							{{$default_currency['currencysymbol']}}<span id="sub_total_{{$k}}" class="sub_total">{{$cd->price}}</span>
							
							<span class="destroy_cart">
								<input type="button" title="Remove" alt="Remove" class="btn btn-danger remove_cart" rel="{{$cd->id}}" style="float:right;" value="X" onclick="return confirm_delete({{$cd->id}},'{{$cd->size}}');">
							</span>
							
						</td>
					</tr>
					<?php 
					$total += $cd->price;
					$sep = ',';
					?>
				@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3" class=""></td>
						<td class="hidden-sm-down text-center"><strong>Total 
							{{$default_currency['currencysymbol']}}<span id="total">{{$total}}</span></strong>
							<input type="hidden" id="gtotal" name="gtotal" value="{{$total}}"/>
							<input type="hidden" id="currenty_symbol" name="currency_symbol" value="{{$default_currency['currencysymbol']}}"/>
							<input type="hidden" id="currency_code" name="currency_code" value="{{$default_currency['currencycode']}}"/>
						</td>
						<td>
						{{ Form::button('Checkout',['class'=>'btn btn-primary fz-18 font-weight-light border-0 rounded-0 px-3']) }}
						</td>
					</tr>
				</tfoot>
			</table>
		</div>	
	</section>
	{!! Form::close() !!}	
	<!-- end cart section -->
	@else
		<section class="cart-item-list mt-5">
			<div class="container">
				<table id="cart" class="table table-hover table-condensed">
					<tbody>
						<tr>
							<td colspan="5" style="color:red;text-align:center;">Your cart is empty!</td>
						</tr>
					</tbody>
				</table>
			</div>
		</section>
	@endif
	
	<div id="deletePhotoDialog" title="Remove Item"></div>
</div>
<div id="img_loader" style="display:none;"></div>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
function confirm_delete(cart_id,print_of_set){
	alert(cart_id);
	alert(print_of_set);
	var base_path = "<?php echo config('app.url');?>";
	var project_name = print_of_set;
	var message = "Are you sure want to remove item ("+project_name+") from cart?"
	$("#deletePhotoDialog").html(message);
	$("#deletePhotoDialog").dialog({
		resizable: false,
		height: "auto",
		width: 400,
		modal: true,
		buttons: {
			"Delete": function(){
				$.ajaxSetup({ 
					headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} 
				});
				$.ajax({
					url : base_path + 'custom_cart_remove',            
					type : 'POST',
					data : {cart_id:cart_id},
					success : function(data){
						swal("Deleted!", "Item removed from cart...!", "success")
						.then((value) => {
							window.location.reload();
						});
						$("#deletePhotoDialog").dialog( "close" );
					}
				});
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});
		
	
}

$(document).ready(function(){
	$('.qty').bind('keyup change',function(){
		var qty = $(this).val();
		var rel = $(this).attr('rel');
		var sub_total = 0;
		if(qty>=1){
			var price = $('#price_'+rel).val();
			var subTotal = (price*qty);
			$('#sub_total_'+rel).html(parseFloat(subTotal).toFixed(2));
			$('.sub_total').each(function(){
				sub_total = sub_total+parseFloat($(this).html());
			});
			$('#total').html(parseFloat(sub_total).toFixed(2));
			$('#gtotal').val(parseFloat(sub_total).toFixed(2));
		}else{
			//alert('Sorry! minimum less than 1');
			toastr.success('Sorry! minimum less than 1');
			$(this).val(1);
		}
	});
	
	
	$("input[name=shipping_address]").on('change',function(){
		var address_id = $(this).attr('rel');
		var base_path = "<?php echo config('app.url');?>";
		$.ajaxSetup({ 
			headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') } 
		});
		$.ajax({
			url : base_path+'payments/get_shiiping_address',            
			type : 'POST',
			data : {address_id:address_id,_token:$('meta[name="_token"]').attr('content')},
			success : function(data){
				$('#shipping_email').val(data.email);
				$('#shipping_first_name').val(data.first_name);
				$('#shipping_last_name').val(data.last_name);
				$('#shipping_address').val(data.street);
				$('#shipping_city').val(data.city);
				$('#shipping_state').val(data.state);
				$('#shipping_zipcode').val(data.zipcode);
				$('#shipping_country').val(data.country);
			}
		});
		
	});
});
</script>

@if(Session::has('email'))
	<?php 
	$email = Session::get('email');
	?>
	<script>
	$(function(){
		$("#verifyAlert").dialog({
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
		$("#verifyAlert").dialog( "open" );
		$("#resend").on('click',function(){
			var basePath = "<?php echo env('APP_URL');?>";
			var email = "<?php echo $email; ?>";
			$.ajax({
				url : basePath + 'payments/resend_verify_mail/'+email,            
				type : 'GET',
				beforeSend: function(){
					$('#img_loader').css('display','block');
					$('#img_loader').html("<img src='https://printedcart.com/printedcart/public/images/loader.gif'>");
				},
				success : function(data){
					$('#img_loader').css('display','none');
					if(data=='ok'){
						$("#verifyAlert").dialog( "close" );
						$("#resendVerify").dialog({
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
						$("#resendVerify").dialog( "open" );
					}
				}
			});
		});
	});
	</script>
	<!-- verify alert -->
	<div id="verifyAlert" title="Verify" style="display:none;">
		<div class="row">
			<div class="col-sm-12 form-group" style="text-align:center;">
				Verify your email address
			</div>
			<div class="col-sm-12 form-group" style="text-align:left;">
				PrintedCart needs to verify your email address before you can checkout. An email with a verification link was sent to <b>{{$email}}</b>. Please check your inbox/spam or resend the verification email below.
			</div>
			<div class="col-sm-12 form-group" style="text-align:center;">
				<a href="javascript:void(0);" class="btn btn-primary" style="color:#fff;" id="resend">Resend</a>
			</div>
		</div>
	</div>
	<!-- end verify alert -->
	
	<!-- resend verify -->
	<div id="resendVerify" title="Resend" style="display:none;">
		<div class="row">
			<div class="col-sm-12 form-group" style="text-align:center;"><img src="{{URL::asset('public/images/ok.jpg')}}" style="width:60px; border:1px solid green; border-radius:50px; margin-right:10px;">Verification email sent</div>
		</div>
	</div>
	<!-- end resend verify -->
@endif
	
@if(Session::has('verified'))
	@if(Session::get('verified')=='yes')
		<script>
		$(function(){
			var basePath = "<?php echo env('APP_URL');?>";
			$.ajax({
				url : basePath + 'payments/verify_mail_confirm',            
				type : 'GET',
				beforeSend: function(){
					$("#verified_yes").dialog({
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
					$("#verified_yes").dialog( "open" );
					
					$('#img_loader').css('display','block');
					$('#img_loader').html("<img src='https://printedcart.com/printedcart/public/images/loader.gif'>");						
				},
				success : function(data){
					//window.location.href = basePath+'user/section';
					$('#img_loader').css('display','none');
					if(data=='ok'){
						$("#verified_yes").dialog({
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
						$("#verified_yes").dialog( "open" );
					}
				}
			});
		});
		</script>
		<div id="verified_yes" title="Verify" style="display:none;">
			<div class="row">
				<div class="col-sm-12 form-group" style="text-align:center;">Please refresh this page to continue</div>
			</div>
		</div>
	@else
		<script>
		$(function(){
			$("#verified_no").dialog({
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
			$("#verified_no").dialog( "open" );
		});
		</script>
		<div id="verified_no" title="Resend" style="display:none;">
			<div class="row">
				<div class="col-sm-12 form-group" style="text-align:center;">Email not verified.</div>
			</div>
		</div>
	@endif
@endif
<style>
#img_loader img {
	position: absolute;
	left: 50%;
	top: 50%;
	transform: translateY(-50%) translateX(-50%);
	-moz-transform: translateY(-50%) translateX(-50%);
	-webkit-transform: translateY(-50%) translateX(-50%);
	-ms-transform: translateY(-50%) translateX(-50%);
	-o-transform: translateY(-50%) translateX(-50%);
}
#img_loader {
	position: fixed;
	top: 0;
	height: 100%;
	left: 0;
	width: 100%;
	background-color: rgba(0,0,0,0.1);
	z-index: 99999;
}
</style>
@endsection