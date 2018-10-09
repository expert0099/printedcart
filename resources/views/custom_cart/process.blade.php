@extends("layouts.print")

@section("main-content")

<div class="container">
	<!-- cart section -->
	<section class="cart-info-box" style="margin-top:10rem!important;">
		
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="shipping-info-box">
						<h4 class="font-weight-normal mb-4">Shipping Information</h4>
						<address>
							<span class="font-weight-bold">SHIP TO:</span><br>
							<b>Name:-</b> {{$data['shipping_firstname']}} {{$data['shipping_lastname']}}
							<br>
							<b>Email:-</b> {{$data['shipping_email']}}
							<br>
							<b>Address:-</b> {{$data['shipping_address']}}
							<br>							{{$data['shipping_city']}},{{$data['shipping_state']}},{{$data['shipping_zipcode']}}
							<br>
							{{$data['shipping_country']}}
							<br>
						</address>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<div class="delvery-option-box cartItemInfoSec">
						<h4 class="font-weight-normal mb-4">Cart Info</h4>
						<?php 
						$items = $quantity = $custom_cart_id = $sep = $sep2 = $sep3 = "";
						foreach($data['qty'] as $j => $qty){
							$quantity = $quantity.$sep2.$qty;
							$sep2=',';
						}
						foreach($data['custom_cart_id'] as $j => $cci){
							$custom_cart_id = $custom_cart_id.$sep3.$cci;
							$sep3=',';
						}
						?>
						<table class="tbl">
							<tr>
								<td style="width:40%"><b>Print of set</b></td>
								<td style="width:8%"><b>Price</b></td>
								<td style="width:15%"><b>Qty.</b></td>
								<td style="width:17%"><b>Sub Total</b></td>
							</tr>
							@foreach($data['item'] as $k => $item)
							<?php 
							$items = $items.$sep.$item;
							$qty = $qty.$sep.
							$sep=',';
							?>
							<tr>
								<td>{{$item}}</td>
								<td>{{$data['currency_symbol']}}{{$data['price'][$k]}}</td>
								<td>{{$data['qty'][$k]}}</td>
								<td>{{$data['currency_symbol']}}{{$data['qty'][$k]*$data['price'][$k]}}</td>
							</tr>
							@endforeach
							
							<tr>
								<td colspan="3">Shipping Price</td>
								<td>{{$data['currency_symbol']}}{{$data['shipping_price']}}</td>
							</tr>
							<tr>
								<td colspan="3"><b>Total</b></td>
								<td><b>{{$data['currency_symbol']}}{{$data['gtotal']+$data['shipping_price']}}</b></td>
							</tr>
						</table>
					</div>			
				</div>
			</div>
			
			<div class="row">
				<div class="col-12 col-md-12"><hr/>
					
				</div>
			</div>
			
			<div class="row">
				<!-- Autherized.Net -->
				<div class="col-12 col-md-12 creditPaySection" style="padding-left: 33%;">
					<form method="POST" name="credit_paypal_form" id="credit_paypal_form" class="form-horizontal" action="paywithautherized" style="width: 55%; background-color: lightskyblue; border-radius: 10px; padding: 10px;">
						<input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <div class="form-group has-feedback ak-field" style="text-align:left;">
                            <label class="col-md-6 control-label" style="text-align:left;">Card Full Name*</label>
                            <div class="col-md-12">
                                <input class="form-control" name="card_name" required="required" type="text">
							</div>
                        </div>
						<div class="form-group has-feedback ak-field" style="text-align:left;">
							<label class="col-md-6 control-label" style="text-align:left;">Card Type</label>
							<div class="col-md-12">
								<select class="" name="cart_type" required="required" style="width:350px;">
									<option value="Visa">Visa</option>
									<option value="Mastercard">Mastercard</option>
									<option value="Discover">Discover</option>
									<option value="Amex">Amex</option>
								</select>
							</div>
						</div>
						<div class="form-group has-feedback ak-field" style="text-align:left;">
							<label class="col-md-6 control-label" style="text-align:left;">Card Number *</label>
							<div class="col-md-12">
								<input class="form-control" name="card_number" required="required" type="text" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" maxlength="16">
								<span id="error" style="color: Red; display: none">* Input digits (0 - 9)</span>
							</div>
						</div>
						<div class="form-group has-feedback ak-field" style="text-align:left;">
							<label class="col-md-6 control-label" style="text-align:left;">Expire Month/Year *</label>
							<div class="col-md-12">
								<select class="" name="exp_month" required="required" style="width:172px;">
									<option value="01">01</option>
									<option value="02">02</option>
									<option value="03">03</option>
									<option value="04">04</option>
									<option value="05">05</option>
									<option value="06">06</option>
									<option value="07">07</option>
									<option value="08">08</option>
									<option value="09">09</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
								</select>
								<select class="" name="exp_year" required="required" style="width:172px;">
									<option value="2018">2018</option>
									<option value="2019">2019</option>
									<option value="2020">2020</option>
									<option value="2021">2021</option>
									<option value="2022">2022</option>
									<option value="2023">2023</option>
									<option value="2024">2024</option>
									<option value="2025">2025</option>
								</select>
							</div>
						</div>
						<div class="form-group has-feedback ak-field" style="text-align:left;">
							<label class="col-md-6 control-label" style="text-align:left;">CVV *</label>
							<div class="col-md-12">
								<input class="form-control" name="cvv" required="required" type="text" onkeypress="return IsNumeric2(event);" ondrop="return false;" onpaste="return false;" maxlength="3">
								<span id="error2" style="color: Red; display: none">* Input digits (0 - 9)</span>
							</div>
						</div>
						
						<input name="amount" type="hidden" value="{{$data['gtotal']}}">
						<input name="currency_code" type="hidden" value="{{$data['currency_code']}}">
						<input name="shipping" type="hidden" value="{{$data['shipping_price']}}">
						<input name="item_name" type="hidden" value="{{$items}}">
						<input name="qty" type="hidden" value="{{$quantity}}"/>
						<input name="address_id" type="hidden" value="{{$data['address_id']}}"/>
						<input name="custom_cart_id" type="hidden" value="{{$custom_cart_id}}"/>

						<div class="form-group has-feedback ak-field">
							<div class="col-md-12 col-md-offset-4">
								<input name="payment_submit" value="Submit &amp; Pay" class="btn btn-primary pop-btn" id="payment_submit" type="submit" style="float:left;">
							</div>
						</div>
                    </form>
				</div>
				<!-- End Autherized.Net -->
			</div>
			
			<div class="row">
				<div class="col-12 col-md-12"></div>
			</div>
			
		</div>
		
	</section>
	<!-- end cart section -->
</div>
<style>
.tbl{
	border:1px solid #ccc;
	font-size:14px;
	line-height:2.0rem;
	width:100%;
}
td{
	border:1px solid #ccc;
}
</style>
<script>
$(document).ready(function(){
	$('.payment_type').on('change',function(){
		var pt = $(this).val();
		if(pt=='Debit/Credit Card'){
			$('#paypal_hidden_form').css('display','none');
			$('#credit_paypal_form').css('display','block');
		}else{
			$('#paypal_hidden_form').css('display','block');
			$('#credit_paypal_form').css('display','none');
		}
	});
});
</script>
@endsection