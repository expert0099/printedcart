<?php 
$con = mysql_connect('localhost','printedc_printed','printedcarts@123');
mysql_select_db('printedc_printedcarts',$con);

$input = $_REQUEST;
file_put_contents('ipn.txt',print_r($input,true));

/* $input = array(
	'transaction_subject' => '',
	'payment_date' => '23:14:06 Jul 17, 2018 PDT',
	'txn_type' => 'web_accept',
	'last_name' => 'sym',
	'residence_country' => 'US',
	'pending_reason' => 'paymentreview',
	'item_name' => 'test family - 11x8,postercol - 12x12,@2,2',
	'payment_gross' => 43.96,
	'mc_currency' => 'USD',
	'business' => 'hetram-facilitator@redsymboltechnologies.com',
	'payment_type' => 'instant',
	'protection_eligibility' => 'Ineligible',
	'verify_sign' => 'A8VZ08eNIUoTSTGnp-2oXhn5KPzHATDS7xZ0NjYqlGs9LXsqqpg-76Qt',
	'payer_status' => 'verified',
	'test_ipn' => 1,
	'tax' => 0.00,
	'payer_email' => 'hetram_buyer@redsymboltechnologies.com',
	'txn_id' => '3N237921553300121',
	'quantity' => 1,
	'receiver_email' => 'hetram-facilitator@redsymboltechnologies.com',
	'first_name' => 'red',
	'payer_id' => '68GGGFXUW8GNJ',
	'receiver_id' => 'F38M9AS7CQ5E8',
	'item_number' => '',
	'payment_status' => 'Pending',
	'payment_fee' => 1.57,
	'mc_fee' => 1.57,
	'mc_gross' => 43.96,
	'custom' => '45,315,341',
	'charset' => 'windows-1252',
	'notify_version' => 3.9,
	'ipn_track_id' => '1fad52eefa6f'
); */


if($input['txn_type'] == 'web_accept'){
	$txn_id = $input['txn_id'];
	$payer_id = $input['payer_id'];
	$receiver_id = $input['receiver_id'];
	$ipn_track_id = $input['ipn_track_id'];
	$item_name = $input['item_name'];
	$item = explode(',@',$item_name);
	$quantity = $item[1];
	$ipn_status = 'Success';
	$sql = mysql_query("SELECT * FROM orders WHERE txn_id = '".$txn_id."' LIMIT 0, 1");
	$row = mysql_fetch_array($sql);
	if(count($row['txn_id'])>0){
		$sql = mysql_query("UPDATE orders SET payer_id = '".$payer_id."', receiver_id = '".$receiver_id."', ipn_track_id = '".$ipn_track_id."', item_name = '".$item[0]."', ipn_status = '".$ipn_status."' WHERE txn_id = '".$txn_id."'");
	}else{
		$currency_code = $input['mc_currency'];
		$amt = $input['payment_gross']-$input['shipping'];
		$shipping_amt = $input['shipping'];
		$status = 'Success';
		$custom = explode(',',$input['custom']);
		$user_id = $custom[0];
		$project_id = $sep = '';
		foreach($custom as $k => $v){
			if($k==0){
				$user_id = $v;
			}else{
				$project_id = $project_id.$sep.$v;
				$sep = ',';
			}
		}
		//$qty = $input['custom2'];
		$sql = mysql_query("INSERT INTO orders (user_id, project_id, qty, currency_code, amt, shipping_amt, txn_id, status, payer_id, receiver_id, ipn_track_id, item_name, ipn_status) VALUES ('".$user_id."', '".$project_id."', '".$quantity."', '".$currency_code."', '".$amt."', '".$shipping_amt."', '".$txn_id."', '".$status."', '".$payer_id."', '".$receiver_id."', '".$ipn_track_id."', '".$item[0]."', '".$ipn_status."')");
		$order_id = mysql_insert_id();
		if($sql){
			foreach($custom as $k => $v){
				if($k!=0){
					$project = $v;
					$status = 1;
					mysql_query("UPDATE carts SET status = '".$status."' WHERE project_id = '".$project."'");
				}
			}
			
			/* send mail to customer */
			$sq = mysql_query("SELECT * FROM users WHERE id = '".$user_id."' LIMIT 0, 1");
			$rw = mysql_fetch_array($sq);
			
			$payer_email = $rw['email'];
			$payer_name = $rw['name'];
			$subject = "Order Proceed : Printed Cart";
			
			$userInfo = mysql_query("SELECT * FROM user_address_infos WHERE user_id = '".$user_id."' LIMIT 0, 1");
			$userInfoRw = mysql_fetch_array($userInfo);
			$default_email = 'expertteam11@gmail.com';
			$config = mysql_query("SELECT * FROM la_configs");
			while($rw_config = mysql_fetch_array($config)){
				if($rw_config['key'] == 'default_email'){
					$default_email = $rw_config['value'];
				}
			}
			
			$quantity = explode(',',$quantity);
			$projects = explode(',',$project_id);
						
			$message = '<!DOCTYPE html>
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
			<td>Order Number: <strong>'.$order_id.'</strong></td>
		</tr>
		<tr>
			<td>Order Date: <strong>'. date('Y-m-d H:i:s') .'</strong></td>
		</tr>
		<tr>
			<td><h3 style="font-weight: normal; border-bottom: 1px solid #ccc; padding-bottom: 10px; margin-bottom:8px;">Shipping to: <strong>'.$userInfoRw['first_name'].' '.$userInfoRw['last_name'].' </strong></h3></td>
		</tr>
		<tr>
			<td>'.$userInfoRw['street'].', '.$userInfoRw['city'].'</td>
		</tr>
		<tr>
			<td>'.$userInfoRw['state'].', '.$userInfoRw['zipcode'].'</td>
		</tr>
		<tr>
			<td>'.$userInfoRw['country'].'</td>
		</tr>
	</table>

	<table style="margin: auto; width: 600px; background-color: #f6f6f6; padding: 10px;">
		<tr style="width: 100%;">
			<td style="width: auto;" colspan="5"><h3 style="border-bottom: 1px solid #ccc; padding-bottom: 10px; margin-bottom:8px;">Order Summary</h3></td>
		</tr>
		<tr style="text-transform: uppercase; font-size: 13px;  font-weight: bold;">
			<td style="width: 100px; padding:10px 0px;">Item</td>
			<td style="width: 30px; padding:10px 0px;">Price</td>
			<td style="width: 30px; padding:10px 0px;">Qty</td>
			<td style="width: 30px; padding:10px 0px;">Item Total</td>
			<td style="width: 50px; padding:10px 0px;">Cover Price</td>
		</tr>
		<tr style="width: 100%;">
			<td style="width: auto; border-bottom: 1px solid #ccc; " colspan="5" ></td>
		</tr>';
		
		foreach($projects as $k => $v){
			$proj = mysql_query("SELECT * FROM projects WHERE id = '".$v."' LIMIT 0, 1");
			$proj_rw = mysql_fetch_array($proj);
			$message .=	'<tr style="font-size: 13px;">
				<td style="width: 100px; padding:7px 0px;">'.$proj_rw['project_name'].'</td>
				<td style="width: 30px; padding:7px 0px;">'.$currency_code.$proj_rw['price'].'</td>
				<td style="width: 30px; padding:7px 0px;">'.$quantity[$k].'</td>
				<td style="width: 30px; padding:7px 0px;">'.$currency_code.$quantity[$k]*$proj_rw['price'].'</td>
				<td style="width: 50px; padding:7px 0px;">'.$currency_code.$proj_rw['price'].'</td>
			</tr>';
		}
		
		$message .= '<tr>
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
						<td style="width:50px;">'.$currency_code.$amt.'</td>
					</tr>
					<tr>
						<td style="width:250px; padding-bottom: 10px;">Total Shipping & Handing:</td>
						<td style="width:50px;">'.$currency_code.$shipping_amt.'</td>
					</tr>
					<tr><td style="width: auto; border-bottom: 1px solid #ccc;" colspan="5"></td></tr>
					<tr style="border-bottom: 1px solid #ccc; font-weight: bold;">
						<td style="width:250px; padding-bottom: 10px; padding-top: 10px;">Order Total:</td>
						<td style="width:50px;">'.$currency_code.number_format($amt+$shipping_amt,2).'</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>';
			
			$from = $default_email;
			$from_name = "Admin";
			$headers .= 'From: ' .$from_name. "\r\n" .'Reply-To: ' .$from . "\r\n";
			$headers  .= 'MIME-Version: 1.0' . "\r\n";
			$headers  .= "Content-Type: text/html; charset=iso-8859-1";
			mail($payer_email, $subject, $message, $headers);
			/* end send mail to customer */
			
		}
	} 
}


/* session_start();
$session = $_SESSION['ipn'] = $_REQUEST;
echo '<pre>';
print_r($session);exit;
if($session){
	header("location:https://printedcart.com/printedcart/paypal/ipn2");
}else{
	echo 'session not working...';
} */
?>