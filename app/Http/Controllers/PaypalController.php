<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB,Auth;
use Redirect;
use Validator;
use Paypalpayment;
use App\Currency;
use App\Order;
use App\Cart;
use Session;
use Mail;

class PaypalController extends Controller {

	public function paypalReturn(){
		return redirect('/home')->with('success','Your order is successfully proceed.');
	}
	public function paypalCancel(){
		return redirect('payments/cart')->withErrors(['error'=>'Your transaction is cancelled.']);
	}
	public function paypalIPN(Request $request){
		$input = $request->all();
		if($input['txn_type'] == 'web_accept'){
			$txn_id = $input['txn_id'];
			$payer_id = $input['payer_id'];
			$receiver_id = $input['receiver_id'];
			$ipn_track_id = $input['ipn_track_id'];
			$item_name = $input['item_name'];
			$ipn_status = 'Success';
			$exist = Order::where('txn_id','=',$txn_id)->first();
			if(count($exist['txn_id'])>0){
				$arrUp = array(
					'payer_id' => $payer_id,
					'receiver_id' => $receiver_id,
					'ipn_track_id' =>$ipn_track_id,
					'item_name' => $item_name,
					'ipn_status' => $ipn_status
				);
				Order::where('txn_id','=',$txn_id)->update($arrUp);
			}else{
				$currency_code = $input['mc_currency'];
				$amt = $input['payment_gross']-$input['shipping'];
				$shipping_amt = $input['shipping'];
				$status = 'Success';
				$custom = explode(',',$input['custom']);
				$user_id = $custom[1];
				$project_id = $custom[0];
				$insArr = array(
					'user_id' => $user_id,
					'project_id' => $project_id, 
					'currency_code' => $currency_code,
					'amt' => $amt,
					'shipping_amt' => $shipping_amt,
					'txn_id' => $txn_id,
					'status' => $status,
					'payer_id' => $payer_id,
					'receiver_id' => $receiver_id,
					'ipn_track_id' => $ipn_track_id,
					'item_name' => $item_name,
					'ipn_status' => $ipn_status
				);
				$ins = Order::insertGetId($insArr);
			}
		}
	}
	public function paypalIPN2(Request $request){
		$input = $request->all();
		file_put_contents('ipn.txt',print_r($input,true));
		if($input['txn_type'] == 'web_accept'){
			$txn_id = $input['txn_id'];
			$payer_id = $input['payer_id'];
			$receiver_id = $input['receiver_id'];
			$ipn_track_id = $input['ipn_track_id'];
			$item_name = $input['item_name'];
			$ipn_status = 'Success';
			$exist = Order::where('txn_id','=',$txn_id)->first();
			if(count($exist['txn_id'])>0){
				$arrUp = array(
					'payer_id' => $payer_id,
					'receiver_id' => $receiver_id,
					'ipn_track_id' =>$ipn_track_id,
					'item_name' => $item_name,
					'ipn_status' => $ipn_status
				);
				Order::where('txn_id','=',$txn_id)->update($arrUp);
			}else{
				$currency_code = $input['mc_currency'];
				$amt = $input['payment_gross']-$input['shipping'];
				$shipping_amt = $input['shipping'];
				$status = 'Success';
				$custom = explode(',',$input['custom']);
				$user_id = $custom[1];
				$project_id = $custom[0];
				$insArr = array(
					'user_id' => $user_id,
					'project_id' => $project_id, 
					'currency_code' => $currency_code,
					'amt' => $amt,
					'shipping_amt' => $shipping_amt,
					'txn_id' => $txn_id,
					'status' => $status,
					'payer_id' => $payer_id,
					'receiver_id' => $receiver_id,
					'ipn_track_id' => $ipn_track_id,
					'item_name' => $item_name,
					'ipn_status' => $ipn_status
				);
				$ins = Order::insertGetId($insArr);
			}
		}
	}
	
	public function paywithpaypal(Request $request)
    {
		/** default currency **/
		$currency = Currency::where('isDefault',1)->first();
		$currency_code = $currency->currencycode;
		/** end default currency **/
		
		/* paypal credential */
		$sandbox = TRUE;
		$api_version = '85.0';
		$api_endpoint = $sandbox ? 'https://api-3t.sandbox.paypal.com/nvp' : 'https://api-3t.paypal.com/nvp';
		$api_username = $sandbox ? 'hetram-facilitator_api1.redsymboltechnologies.com' : '';
		$api_password = $sandbox ? 'DS938KLUNGAF9C7R' : '';
		$api_signature = $sandbox ? 'Am.0Cs3QzF8hSNRqaRIJaovo.hC9Ajw7jApBR3plCrjwuf-lLHrxAVCN' : '';
		/* end paypal credential */
		
		/* user info */
		$userInfo = DB::table('user_address_infos')->where('user_id',Auth::user()->id)->first();
		/* end user info */
		
		$project_id = $request->get('project_id');
		$qty = $request->get('qty');
				
		$request_params = array(
            'METHOD' => 'DoDirectPayment', 
            'USER' => $api_username, 
            'PWD' => $api_password, 
            'SIGNATURE' => $api_signature, 
            'VERSION' => $api_version, 
            'PAYMENTACTION' => 'Sale',                  
            'IPADDRESS' => $_SERVER['REMOTE_ADDR'],
            'CREDITCARDTYPE' => $request->get('cart_type'), 
			'ACCT' => $request->get('card_number'),                      
			'EXPDATE' => $request->get('exp_month').$request->get('exp_year'),          
			'CVV2' => $request->get('cvv'), 
			'FIRSTNAME' => $userInfo->first_name, 
			'LASTNAME' => $userInfo->last_name, 
			'STREET' => $userInfo->street, 
			'CITY' => $userInfo->city, 
			'STATE' => $userInfo->state,                  
			'COUNTRYCODE' => $userInfo->country, 
			'ZIP' => $userInfo->zipcode, 
			'AMT' => 1,//$request->get('amount')+$request->get('shipping'), 
			'CURRENCYCODE' => $request->get('currency_code'), 
			'DESC' => $request->get('item_name') 
        );
		// Loop through $request_params array to generate the NVP string.
		$nvp_string = '';
		foreach($request_params as $var=>$val){
			$nvp_string .= '&'.$var.'='.urlencode($val);    
		}
		
		// Send NVP string to PayPal and store response
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_URL, $api_endpoint);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);
		$result = curl_exec($curl);
		$NVPString = $result;
		$proArray = array();
		while(strlen($NVPString)){
			// name
			$keypos= strpos($NVPString,'=');
			$keyval = substr($NVPString,0,$keypos);
			// value
			$valuepos = strpos($NVPString,'&') ? strpos($NVPString,'&'): strlen($NVPString);
			$valval = substr($NVPString,$keypos+1,$valuepos-$keypos-1);
			// decoding the respose
			$proArray[$keyval] = urldecode($valval);
			$NVPString = substr($NVPString,$valuepos+1,strlen($NVPString));
		}
		
		if($proArray['ACK']=='Success'){
			$insArr = array(
				'user_id' => Auth::user()->id,
				'project_id' => $project_id,
				'qty' => $qty,
				'currency_code' => $request->get('currency_code'),
				'amt' => $request->get('amount'),
				'shipping_amt' => $request->get('shipping'),
				'txn_id' => $proArray['TRANSACTIONID'],
				'status' => $proArray['ACK']
			);
			$insert = Order::insertGetId($insArr);
			if($insert){
				$up = array('status' => 1);
				$proj = explode(',',$project_id);
				foreach($proj as $k => $v){
					Cart::whereRaw("user_id='". Auth::user()->id ."' AND project_id='".$v."'")->update($up);
				}
				
				/* mail send to customer */
				$configs = DB::table('la_configs')->get();
				$default_email = 'expertteam11@gmail.com';
				foreach($configs as $k => $val){
					if($val->key == 'default_email'){
						$default_email = $val->value;
					}
				}
				$user = Auth::user();
				$order = DB::table('orders')->where('id',$insert)->first();
				$quantity = explode(',',$order->qty);
				$projects = explode(',',$order->project_id);
				foreach($projects as $k => $project){
					$projectsArr[$k] = DB::table('projects')->where('id',$project)->first();
				}
								
				Mail::send('emails.order', ['user'=>$user,'order'=>$order,'project'=>$projectsArr,'qty'=>$quantity,'userInfo'=>$userInfo], function ($m) use ($user,$default_email){
					$m->from($default_email, 'Admin');
					$m->to('expertteam11@gmail.com', $user->name)->subject('Order Proceed : Printed Cart');
				});
				/* end mail send to customer */
				
				return redirect('/home')->with('success','Your order is successfully proceed.');
			}else{
				return redirect('payments/cart/'.$project_id)->withErrors(['error'=>'Something went wrong.']);
			} 
		}else{
			return redirect('payments/cart/'.$project_id)->withErrors(['error'=>'Something went wrong.']);
		} 
	}
	         
}