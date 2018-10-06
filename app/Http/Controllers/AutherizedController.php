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

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use net\authorize\api\constants as constants;

class AutherizedController extends Controller {

	
	public function paywithautherized(Request $request)
    {
		$post_data = $request->all();
		
		/** default currency **/
		$currency = Currency::where('isDefault',1)->first();
		$currency_code = $currency->currencycode;
		/** end default currency **/
		
		/* user info */
		$userInfo = DB::table('user_address_infos')->where('user_id',Auth::user()->id)->first();
		/* end user info */
		$email = Auth::user()->email;
		$customerId =  time().$userInfo->id;
		
		$card_name 		= $post_data['card_name'];
		$cart_type 		= $post_data['cart_type'];
		$card_number 	= $post_data['card_number'];
		$exp_month 		= $post_data['exp_month'];
		$exp_year 		= $post_data['exp_year'];
		$expiration		= $exp_year.'-'.$exp_month;
		$cvv 			= $post_data['cvv'];
		$amount 		= $post_data['amount'];
		$shipping_amt 	= $post_data['shipping'];
		$item_name 		= $post_data['item_name'];
		$project_id 	= $post_data['project_id'];
		$qty 			= $post_data['qty'];
		$address_id		= $post_data['address_id'];
		
		$merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
		$merchantAuthentication->setName(\net\authorize\api\constants\ANetEnvironment::MERCHANT_LOGIN_ID);
		$merchantAuthentication->setTransactionKey(\net\authorize\api\constants\ANetEnvironment::MERCHANT_TRANSACTION_KEY);
    
		// Set the transaction's refId
		$refId = 'ref' . time();
		$invoiceNo = time().$userInfo->id;
		// Create the payment data for a credit card
		$creditCard = new AnetAPI\CreditCardType();
		$creditCard->setCardNumber($card_number);
		$creditCard->setExpirationDate($expiration);
		$creditCard->setCardCode($cvv);

		// Add the payment data to a paymentType object
		$paymentOne = new AnetAPI\PaymentType();
		$paymentOne->setCreditCard($creditCard);

		// Create order information
		$order = new AnetAPI\OrderType();
		$order->setInvoiceNumber($invoiceNo);
		$order->setDescription("Printed Cart Products:- ".$item_name);

		// Set the customer's Bill To address
		$customerAddress = new AnetAPI\CustomerAddressType();
		$customerAddress->setFirstName($userInfo->first_name);
		$customerAddress->setLastName($userInfo->last_name);
		//$customerAddress->setCompany("Expert");
		$customerAddress->setAddress($userInfo->street);
		$customerAddress->setCity($userInfo->city);
		$customerAddress->setState($userInfo->state);
		$customerAddress->setZip($userInfo->zipcode);
		$customerAddress->setCountry($userInfo->country);

		// Set the customer's identifying information
		$customerData = new AnetAPI\CustomerDataType();
		$customerData->setType("individual");
		$customerData->setId($customerId);
		$customerData->setEmail($email);

		// Add values for transaction settings
		$duplicateWindowSetting = new AnetAPI\SettingType();
		$duplicateWindowSetting->setSettingName("duplicateWindow");
		$duplicateWindowSetting->setSettingValue("60");

		// Add some merchant defined fields. These fields won't be stored with the transaction,
		// but will be echoed back in the response.
		$merchantDefinedField1 = new AnetAPI\UserFieldType();
		$merchantDefinedField1->setName("customerLoyaltyNum");
		$merchantDefinedField1->setValue("1128836273");

		$merchantDefinedField2 = new AnetAPI\UserFieldType();
		$merchantDefinedField2->setName("favoriteColor");
		$merchantDefinedField2->setValue("blue");

		// Create a TransactionRequestType object and add the previous objects to it
		$transactionRequestType = new AnetAPI\TransactionRequestType();
		$transactionRequestType->setTransactionType("authCaptureTransaction");
		$transactionRequestType->setAmount($amount);
		$transactionRequestType->setOrder($order);
		$transactionRequestType->setPayment($paymentOne);
		$transactionRequestType->setBillTo($customerAddress);
		$transactionRequestType->setCustomer($customerData);
		$transactionRequestType->addToTransactionSettings($duplicateWindowSetting);
		$transactionRequestType->addToUserFields($merchantDefinedField1);
		$transactionRequestType->addToUserFields($merchantDefinedField2);

		// Assemble the complete transaction request
		$request = new AnetAPI\CreateTransactionRequest();
		$request->setMerchantAuthentication($merchantAuthentication);
		$request->setRefId($refId);
		$request->setTransactionRequest($transactionRequestType);

		// Create the controller and get the response
		$controller = new AnetController\CreateTransactionController($request);
		$response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
		
		if($response != null){
			// Check to see if the API request was successfully received and acted upon
			if($response->getMessages()->getResultCode() == "Ok"){
				// Since the API request was successful, look for a transaction response
				// and parse it to display the results of authorizing the card
				$tresponse = $response->getTransactionResponse();
        
				if($tresponse != null && $tresponse->getMessages() != null){
					$transaction_id = $tresponse->getTransId();
					$response_code = $tresponse->getResponseCode();
					$message_code = $tresponse->getMessages()[0]->getCode();
					$auth_code = $tresponse->getAuthCode();
					$description = $tresponse->getMessages()[0]->getDescription();
					
					/* save data into order table */
					$insArr = array(
						'user_id' => Auth::user()->id,
						'project_id' => $project_id,
						'qty' => $qty,
						'currency_code' => $currency_code,
						'amt' => $amount,
						'shipping_amt' => $shipping_amt,
						'txn_id' => $transaction_id,
						'auth_code' => $auth_code,
						'address_id' => $address_id,
						'status' => 'Success'
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
										
						/* Mail::send('emails.order', ['user'=>$user,'order'=>$order,'project'=>$projectsArr,'qty'=>$quantity,'userInfo'=>$userInfo], function ($m) use ($user,$default_email){
							$m->from($default_email, 'Admin');
							$m->to('expertteam11@gmail.com', $user->name)->subject('Order Proceed : Printed Cart');
						}); */
						/* end mail send to customer */
				
						return redirect('/home')->with('success','Your order is successfully proceed.');
					}else{
						return redirect('payments/cart')->withErrors(['error'=>'Something went wrong.']);
					}
					/* end save data into order table */
					
				}else{
					$error[] = "Transaction Failed";
					if($tresponse->getErrors() != null){
						$error[] = " Error Code  : " . $tresponse->getErrors()[0]->getErrorCode();
						$error[] = " Error Message : " . $tresponse->getErrors()[0]->getErrorText();
					}
					return redirect('payments/cart')->withErrors(['error'=>$error]);
				}
				// Or, print errors if the API request wasn't successful
			}else{
				$error[] = "Transaction Failed ";
				$tresponse = $response->getTransactionResponse();
        
				if($tresponse != null && $tresponse->getErrors() != null){
					$error[] = " Error Code  : " . $tresponse->getErrors()[0]->getErrorCode();
					$error[] = " Error Message : " . $tresponse->getErrors()[0]->getErrorText();
				} else {
					$error[] = " Error Code  : " . $response->getMessages()->getMessage()[0]->getCode();
					$error[] = " Error Message : " . $response->getMessages()->getMessage()[0]->getText();
				}
				return redirect('payments/cart')->withErrors(['error'=>$error]);
			}
		}else{
			return redirect('payments/cart')->withErrors(['error'=>'No response returned.']);
		}
		
	}
	
	
	
}