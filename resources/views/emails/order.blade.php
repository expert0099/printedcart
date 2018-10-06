<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body style="font-family:arial">
	<table style="margin: auto; width: 600px; background-color: #f6f6f6; padding: 10px;">
		<tr style="background-color: #0099cc;">
			<td><img src="http://printedcart.com/printedcart/public/images/site-logo.png" style=" padding:12px;"></td>
		</tr>
		<tr>
			<td><h3 style="border-bottom: 1px solid #ccc; padding-bottom: 10px; margin-bottom:8px;">Your Order Confirmation</h3></td>
		</tr>
		<tr>
			<td>Thank you for purchase from <a href="#" style="text-decoration: none; color:#0099cc;">Printed Cart</a></td>
		</tr>
		<tr>
			<td>Order Number: <strong>{{$order->id}}</strong></td>
		</tr>
		<tr>
			<td>Order Date: <strong>{{$order->created_at}}</strong></td>
		</tr>
		<tr>
			<td><h3 style="font-weight: normal; border-bottom: 1px solid #ccc; padding-bottom: 10px; margin-bottom:8px;">Shipping to: <strong>{{$userInfo->first_name}} {{$userInfo->last_name}}</strong></h3></td>
		</tr>
		<tr>
			<td>{{$userInfo->street}}, {{$userInfo->city}}</td>
		</tr>
		<tr>
			<td>{{$userInfo->state}}, {{$userInfo->zipcode}}</td>
		</tr>
		<tr>
			<td>{{$userInfo->country}}</td>
		</tr>
	</table>

	<table style="margin: auto; width: 600px; background-color: #f6f6f6; padding: 10px;">
		<tr style="width: 100%;">
			<td style="width: auto;" colspan="5"><h3 style="border-bottom: 1px solid #ccc; padding-bottom: 10px; margin-bottom:8px;">Order Summary</h3></td>
		</tr>
		<tr style="text-transform: uppercase; font-size: 13px;  font-weight: bold;">
			<td style="width: 136px; padding:10px 0px;">Item</td>
			<td style="width: 20px; padding:10px 0px;">Price</td>
			<td style="width: 136px; padding:10px 0px;">Qty</td>
			<td style="width: 20px; padding:10px 0px;">Cover Price</td>
		</tr>
		<tr style="width: 100%;">
			<td style="width: auto; border-bottom: 1px solid #ccc; " colspan="5" ></td>
		</tr>
		
		@foreach($project as $k => $v)
		
		<tr style="font-size: 13px;">
			<td style="width: 136px; padding:7px 0px;">{{$v->project_name}}</td>
			<td style="width: 20px; padding:7px 0px;">{{$order->currency_code}}{{$v->price}}</td>
			<td style="width: 20px; padding:7px 0px;">{{$qty[$k]}}</td>
			<td style="width: 20px; padding:7px 0px;">{{$order->currency_code}}{{$v->cover_price}}</td>
    	</tr>
		@endforeach
		
		<tr>
			<td style="width: auto; border-bottom: 1px solid #ccc;" colspan="5"></td>
		</tr>
	</table>
	<table  style="margin: auto; width: 600px; background-color: #f6f6f6; padding: 10px;">
		<tr>
			<td style="width: 300px"></td>
			<td style="width: 300px">
				<table style="font-size: 14px;">
					<tr>
						<td style="width:250px; padding-bottom: 10px;">Total Merchandise:</td>
						<td style="width:50px;">{{$order->currency_code}}{{$order->amt}}</td>
					</tr>
					<tr>
						<td style="width:250px; padding-bottom: 10px;">Total Shipping & Handing:</td>
						<td style="width:50px;">{{$order->currency_code}}{{$order->shipping_amt}}</td>
					</tr>
					<tr><td style="width: auto; border-bottom: 1px solid #ccc;" colspan="5"></td></tr>
					<tr style="border-bottom: 1px solid #ccc; font-weight: bold;">
						<td style="width:250px; padding-bottom: 10px; padding-top: 10px;">Order Total:</td>
						<td style="width:50px;">{{$order->currency_code}}{{number_format($order->amt+$order->shipping_amt,2)}}</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>