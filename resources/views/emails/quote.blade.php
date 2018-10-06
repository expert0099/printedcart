<?php 
//echo '<pre>';
//print_r($data);exit;
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body style="font-family:arial">
<table style="margin: auto; width: 600px; background-color: #f6f6f6; padding: 10px;">
	<tr style="background-color: #0099cc;"><td><img src="http://printedcart.com/printedcart/public/images/site-logo.png" style=" padding:12px;"></td></tr>
	<tr><td><h3 style="border-bottom: 1px solid #ccc; padding-bottom: 10px; margin-bottom:8px;">Request Quote</h3></td></tr>
	<tr><td>Name: <strong>{!!$data['name']!!}</strong></td></tr>
	<tr><td>Email: <strong>{!!$data['email']!!}</strong></td></tr>
	<tr><td>Phone: <strong>{!!$data['phone']!!}</strong></td></tr>
	<tr><td>Product tag: <strong>{!!$data['product']!!}</strong></td></tr>
	<tr><td>Message: <strong>{!!$data['message']!!}</strong></td></tr>
</table>
<table style="margin: auto; width: 600px; background-color: #f6f6f6; padding: 10px;">
	<tr><td><strong>Best Regards</strong></td></tr>
	<tr><td>Team <strong>Printed Cart</strong></td></tr>
</table>
</body>
</html>
