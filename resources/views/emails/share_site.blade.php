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
			<td><h3 style="border-bottom: 1px solid #ccc; padding-bottom: 10px; margin-bottom:8px;">Welcome Printed Cart</h3></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Dear {{ $email }}</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>{{ $message_body }}</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Follow this link :-:- <a href="{{ url($website_url) }}"> {{$website_url}} </a></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Best Regards</td>
		</tr>
		<tr>
			<td>Team printed-cart</td>
		</tr>
	</table>
	
</body>
</html>