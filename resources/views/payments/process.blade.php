@extends("layouts.photobook")

@section("main-content")

<div class="container">
	<!-- cart section -->
	<section class="cart-info-box mt-5" style="margin-top:4rem!important;">
		
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
						$items = $quantity = $sep = $sep2 = "";
						foreach($data['qty'] as $j => $qty){
							$quantity = $quantity.$sep2.$qty;
							$sep2=',';
						}
						
						?>
						<table class="tbl">
							<tr>
								<td style="width:40%"><b>Items</b></td>
								<td style="width:8%"><b>Qty.</b></td>
								<td style="width:15%"><b>Price</b></td>
								<td style="width:20%"><b>Cover Price</b></td>
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
								<td>{{$data['qty'][$k]}}</td>
								<td>{{$data['currency_symbol']}}{{$data['price'][$k]}}</td>
								<td>{{$data['currency_symbol']}}{{$data['cover_price'][$k]}}</td>
								<td>{{$data['currency_symbol']}}{{$data['qty'][$k]*$data['price'][$k]+$data['cover_price'][$k]}}</td>
							</tr>
							@endforeach
							
							<tr>
								<td colspan="4">Shipping Price</td>
								<td>{{$data['currency_symbol']}}{{$data['shipping_price']}}</td>
							</tr>
							<tr>
								<td colspan="4"><b>Total</b></td>
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
				<!--<div class="col-12 col-md-6">
					<label class="custom-control custom-radio">
						<input id="payment_type" name="payment_type" type="radio" class="custom-control-input payment_type" value="Paypal" checked="checked"/>
						<span class="custom-control-indicator"></span>
						<span class="custom-control-description">Paypal</span>
					</label>
					
					
					<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" id="paypal_hidden_form">
						{{ csrf_field() }}
						<input name="amount" type="hidden" value="{{$data['gtotal']}}">
						<input name="currency_code" type="hidden" value="{{$data['currency_code']}}">
						<input name="shipping" type="hidden" value="{{$data['shipping_price']}}">
						<input name="tax" type="hidden" value="0.00">
						<input name="return" type="hidden" value="{!! env('APP_URL') !!}paypal/return">
						<input name="cancel_return" type="hidden" value="{!! env('APP_URL') !!}paypal/cancel">
						<input name="notify_url" type="hidden" value="{!! env('APP_URL') !!}public/ipn.php">
						<input name="cmd" type="hidden" value="_xclick">
						<input name="business" type="hidden" value="hetram-facilitator@redsymboltechnologies.com">
						<input name="item_name" type="hidden" value="{{$items}},{{'@'.$quantity}}">
						<input name="no_note" type="hidden" value="1">
						<input type="hidden" name="no_shipping" value="1">
						<input name="lc" type="hidden" value="EN">
						<input name="bn" type="hidden" value="PP-BuyNowBF">
						<input name="custom" type="hidden" value="{{Auth::user()->id}},{{$data['project_id']}}">
						<input name="quantity" type="hidden" value="{{$quantity}}">
						<input type="image" src="https://www.paypalobjects.com/en_US/CH/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
					</form>
					
				</div>
				<div class="col-12 col-md-6">
					<label class="custom-control custom-radio">
						<input id="payment_type1" name="payment_type" type="radio" class="custom-control-input payment_type" value="Debit/Credit Card"/>
						<span class="custom-control-indicator"></span>
						<span class="custom-control-description">Debit/Credit Card</span>
					</label>
					
					
					<form method="POST" name="credit_paypal_form" id="credit_paypal_form" class="form-horizontal" action="paywithpaypal" style="display:none;">
						<input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <div class="form-group has-feedback ak-field">
                            <label class="col-md-4 control-label">Card Full Name*</label>
                            <div class="col-md-8">
                                <input class="form-control" name="card_name" required="required" type="text">
							</div>
                        </div>
						<div class="form-group has-feedback ak-field">
							<label class="col-md-4 control-label">Card Type</label>
							<div class="col-md-8">
								<select class="" name="cart_type" required="required">
									<option value="Visa">Visa</option>
									<option value="Mastercard">Mastercard</option>
									<option value="Discover">Discover</option>
									<option value="Amex">Amex</option>
								</select>
							</div>
						</div>
						<div class="form-group has-feedback ak-field">
							<label class="col-md-4 control-label">Card Number *</label>
							<div class="col-md-8">
								<input class="form-control" name="card_number" required="required" type="text" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" maxlength="16">
								<span id="error" style="color: Red; display: none">* Input digits (0 - 9)</span>
							</div>
						</div>
						<div class="form-group has-feedback ak-field">
							<label class="col-md-8 control-label">Expire Month/Year *</label>
							<div class="col-md-8">
								<select class="" name="exp_month" required="required">
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
								<select class="" name="exp_year" required="required">
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
						<div class="form-group has-feedback ak-field">
							<label class="col-md-4 control-label">CVV *</label>
							<div class="col-md-8">
								<input class="form-control" name="cvv" required="required" type="text" onkeypress="return IsNumeric2(event);" ondrop="return false;" onpaste="return false;" maxlength="3">
								<span id="error2" style="color: Red; display: none">* Input digits (0 - 9)</span>
							</div>
						</div>
						
						<input name="amount" type="hidden" value="{{$data['gtotal']}}">
						<input name="currency_code" type="hidden" value="{{$data['currency_code']}}">
						<input name="shipping" type="hidden" value="{{$data['shipping_price']}}">
						<input name="item_name" type="hidden" value="{{$items}}">
						<input name="project_id" type="hidden" value="{{$data['project_id']}}"/>
						<input name="qty" type="hidden" value="{{$quantity}}"/>

						<div class="form-group has-feedback ak-field">
							<div class="col-md-6 col-md-offset-4">
								<input name="payment_submit" value="Submit &amp; Pay" class="btn btn-primary pop-btn" id="payment_submit" type="submit">
							</div>
						</div>
                    </form>
					
					
				</div>-->
				
				
				<!-- Autherized.Net -->
				<div class="col-12 col-md-12 creditPaySection" style="padding-left: 33%;">
					<form method="POST" name="credit_paypal_form" id="credit_paypal_form" class="form-horizontal" action="paywithautherized" style="width: 55%; background-color: lightskyblue; border-radius: 10px; padding: 10px;">
						<input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <div class="form-group has-feedback ak-field" style="text-align:left;">
                            <label class="col-md-6 control-label">Card Full Name*</label>
                            <div class="col-md-12">
                                <input class="form-control" name="card_name" required="required" type="text">
							</div>
                        </div>
						<div class="form-group has-feedback ak-field" style="text-align:left;">
							<label class="col-md-6 control-label">Card Type</label>
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
							<label class="col-md-6 control-label">Card Number *</label>
							<div class="col-md-12">
								<input class="form-control" name="card_number" required="required" type="text" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" maxlength="16">
								<span id="error" style="color: Red; display: none">* Input digits (0 - 9)</span>
							</div>
						</div>
						<div class="form-group has-feedback ak-field" style="text-align:left;">
							<label class="col-md-6 control-label">Expire Month/Year *</label>
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
							<label class="col-md-6 control-label">CVV *</label>
							<div class="col-md-12">
								<input class="form-control" name="cvv" required="required" type="text" onkeypress="return IsNumeric2(event);" ondrop="return false;" onpaste="return false;" maxlength="3">
								<span id="error2" style="color: Red; display: none">* Input digits (0 - 9)</span>
							</div>
						</div>
						
						<input name="amount" type="hidden" value="{{$data['gtotal']}}">
						<input name="currency_code" type="hidden" value="{{$data['currency_code']}}">
						<input name="shipping" type="hidden" value="{{$data['shipping_price']}}">
						<input name="item_name" type="hidden" value="{{$items}}">
						<input name="project_id" type="hidden" value="{{$data['project_id']}}"/>
						<input name="qty" type="hidden" value="{{$quantity}}"/>
						<input name="address_id" type="hidden" value="{{$data['address_id']}}"/>

						<div class="form-group has-feedback ak-field">
							<div class="col-md-12 col-md-offset-4">
								<input name="payment_submit" value="Submit &amp; Pay" class="btn btn-primary pop-btn" id="payment_submit" type="submit">
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