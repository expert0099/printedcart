<?php
/**
 * Controller genrated using 
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB,Auth;
use Redirect;
use Validator;
use App\Cart;
use App\Project;
use App\ShippingPrice;
use App\ShippingCategory;
use App\Currency;
use App\Size;
use App\Photobook;
use App\User;
use Mail;

/**
 * Class PaymentController
 * @package App\Http\Controllers
 */
class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
		$this->middleware('auth');
        $this->help_group_pages = $this->help_group_pages();
		$this->resource_group_pages = $this->resource_group_pages();
		$this->corporate_group_pages = $this->corporate_group_pages();
	}
	
	/** added for mail verification **/
	public function resend_verify_mail($email = null){
		$data = User::where('email','=',$email)->first();
		$data['activate_link'] = url('payments/account_activate/'.base64_encode($data['email']));
		Mail::send('emails.email_verify', ['data' => $data], function ($m) use ($data){			
			$m->to($data['email'], $data['name'])				
				->subject('Printed Cart: Email Verification');		
		});
		return 'ok';
	}
	
	public function verify_mail_confirm(){
		return 'ok';
	}
	
	public function account_verify($email = null){
		$email = base64_decode($email);
		$verify = User::where('email','=',$email)->update(array('verify'=>1));
		if($verify){
			return redirect('/payments/cart')->with(['verified'=>'yes']);
		}else{
			return redirect('/payments/cart')->with(['verified'=>'no']);
		}
	}
	/** end mail verification **/
	
	public function remove_cart(Request $request){
		$project_id = $request->get('project_id');
		DB::table('carts')->where('project_id',$project_id)->delete();
		return "ok";
	}

	public function payment_process(Request $request){
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		
		$user_data = DB::table('users')->where('id',Auth::user()->id)->first();
		if($user_data->verify == 0){
			return redirect()->back()->with(['email'=>$user_data->email]);
			//return redirect('/user/register')->with(['email'=>$user_data['email']]);
		}
		$post_data = $request->all();
		
		$exist = DB::table('user_address_infos')->whereRaw("street LIKE '%".$request->get('shipping_address')."%'")->first();
		if(count($exist) == 0){
			$address = DB::table('user_address_infos')->where('user_id',Auth::user()->id)->get();
			$insArr = array(
				'user_id'		=> Auth::user()->id,
				'email'			=> $request->get('shipping_email'),
				'first_name'	=> $request->get('shipping_firstname'),
				'last_name' 	=> $request->get('shipping_lastname'),
				'street'		=> $request->get('shipping_address'),
				'city'			=> $request->get('shipping_city'),
				'state'			=> $request->get('shipping_state'),
				'zipcode'		=> $request->get('shipping_zipcode'),
				'country'		=> $request->get('shipping_country'),
				'address_type'	=> 'Address#'.count($address)
			);
			$address_id = DB::table('user_address_infos')->insertGetId($insArr);
		}else{
			$address_id = $exist->id;
		}
		/** cart form data **/
		$data['shipping_email'] = $request->get('shipping_email');
		$data['shipping_firstname'] = $request->get('shipping_firstname');
		$data['shipping_lastname'] = $request->get('shipping_lastname');
		$data['shipping_address'] = $request->get('shipping_address');
		$data['shipping_city'] = $request->get('shipping_city');
		$data['shipping_state'] = $request->get('shipping_state');
		$data['shipping_zipcode'] = $request->get('shipping_zipcode');
		$data['shipping_country'] = $request->get('shipping_country');
		$data['shipping_price'] = $request->get('shipping_price');
		$data['item'] = $request->get('item');
		$data['price'] = $request->get('price');
		$data['qty'] = $request->get('qty');
		$data['cover_price'] = $request->get('cover_price');
		$data['gtotal'] = $request->get('gtotal');
		$data['currency_symbol'] = $request->get('currency_symbol');
		$data['currency_code'] = $request->get('currency_code');
		$data['project_id'] = $request->get('project_id');
		$data['address_id'] = $address_id;
		/** end cart form data **/
		
		/** cart items **/
		$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
		$item_count = count($cartItems);
		/** end cart items **/
		return view('payments.process',compact('help_group_pages','resource_group_pages','corporate_group_pages','data','item_count'));
	} 
    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function shipping_address(Request $request)
    {
		$email 		= $request->get('email');
		$first_name = $request->get('first_name');
		$last_name = $request->get('last_name');
		$street = $request->get('street');
		$city = $request->get('city');
		$state = $request->get('state');
		$zipcode = $request->get('zipcode');
		$country = $request->get('country');
		$pid = $request->get('pid');
		$addArr = array(
			'user_id' => Auth::user()->id,
			'email'	  => $email,
			'first_name' => $first_name,
			'last_name' => $last_name,
			'street' => $street,
			'city' => $city,
			'state' => $state,
			'zipcode' => $zipcode,
			'country' => $country
		);
		$exist = DB::table('user_address_infos')->whereRaw("user_id='". Auth::user()->id ."'")->first();
		if(count($exist)>0){
			DB::table('user_address_infos')->where("user_id",Auth::user()->id)->update($addArr);
		}else{
			DB::table('user_address_infos')->insert($addArr);
		}
		return redirect('payments/cart/'.$pid);
	}
		
	public function cart(){
				
		$shipping_address = DB::table('user_address_infos')->where('user_id',Auth::user()->id)->first();
		
		if(count($shipping_address)>0){
			$cartItems = Cart::whereRaw("user_id = '". Auth::user()->id ."' AND status = 0")->get();
		}else{
			return redirect()->back()->withErrors(['error'=>'Please add your address first!']);
		}
		
		$multi_address = DB::table('user_address_infos')->whereRaw("user_id = '". Auth::user()->id ."' AND address_type != 'Primary'")->get();
		
		if(count($cartItems)>0){
			$ship_cat = array();
			foreach($cartItems as $k => $value){
				$project_ids[] = $value['project_id'];
				$size_group = DB::table('sizegroups')->where('sizegroup','=',$value['cart_type'])->first();
							
				$ps = Project::where('id',$value['project_id'])->first();
					
				$shipping_price = ShippingPrice::with('ShippingCategory')->whereRaw("size_id='".$ps['size_id']."' AND size_group_id='". $size_group->id ."'")->get();
				
				if(empty($shipping_price[0])){
					$shipping_price = ShippingPrice::with('ShippingCategory')->get();
				}
				foreach($shipping_price as $k => $v){
					$shipping_category[] = $v['ShippingCategory']['shipping_category'];
					$price[] = $v['price'];
					$inc_price[] = $v['inc_price'];
				}
				$ship_cat = array_unique($shipping_category); 
			}
			
			$project = Project::with('Cart','Size','CalendarStyle')->whereRaw("user_id='". Auth::user()->id ."'")->whereIn('id',$project_ids)->get();
		}else{
			$project = '';
			$price = '';
			$inc_price = '';
			$ship_cat = '';
		}		
		/** get default currency **/
		$default_currency = Currency::where('isDefault',1)->first();
		/** end default currency **/
		
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		
		/** cart items **/
		$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
		$item_count = count($cartItems);
		/** end cart items **/
		
		return view('payments.cart',compact('shipping_address','ship_cat','price','inc_price','default_currency','project','help_group_pages','resource_group_pages','corporate_group_pages','item_count','multi_address'));
	}
	
	public function get_shiiping_address(Request $request){
		$address_id = $request->get('address_id');
		$getAddress = DB::table('user_address_infos')->where('id',$address_id)->first();
		$data['email'] = $getAddress->email;
		$data['first_name'] = $getAddress->first_name;
		$data['last_name'] = $getAddress->last_name;
		$data['street'] = $getAddress->street;
		$data['city'] = $getAddress->city;
		$data['state'] = $getAddress->state;
		$data['zipcode'] = $getAddress->zipcode;
		$data['country'] = $getAddress->country;
		return $data;
	}
}