<?php
/**
 * Controller genrated using 
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB,Auth;
use App\Project;
use App\Order;
use App\ShippingPrice;
use App\ShippingCategory;
use App\Currency;
use Redirect;
use Validator;
use Illuminate\Pagination;
use Session;


/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class CustomCartController extends Controller
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

    public function show_cart(){
		$status = 0;
		//$cartData = DB::table('custom_carts')->where('user_id',Auth::user()->id)->get();
		$cartData = DB::table('custom_carts')->whereRaw("status = '".$status."' AND user_id = '". Auth::user()->id ."'")->get();
		
		if(count($cartData)>0){
			$shipping_address = DB::table('user_address_infos')->where('user_id',Auth::user()->id)->first();
			$multi_address = DB::table('user_address_infos')->whereRaw("user_id = '". Auth::user()->id ."' AND address_type != 'Primary'")->get();
			$shipping_price = ShippingPrice::with('ShippingCategory')->get();
			foreach($shipping_price as $k => $v){
				$shipping_category[] = $v['ShippingCategory']['shipping_category'];
				$price[] = $v['price'];
				$inc_price[] = $v['inc_price'];
			}
			$ship_cat = array_unique($shipping_category); 
			/** get default currency **/
			$default_currency = Currency::where('isDefault',1)->first();
			/** end default currency **/
			$help_group_pages = $this->help_group_pages;
			$resource_group_pages = $this->resource_group_pages;
			$corporate_group_pages = $this->corporate_group_pages;
			/** cart items **/
			$cartItems = DB::table('custom_carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
			$item_count = count($cartItems);
			/** end cart items **/
			return view('custom_cart/show_cart',compact('cartData','shipping_address','multi_address','shipping_price','ship_cat','price','inc_price','default_currency','help_group_pages','resource_group_pages','corporate_group_pages','item_count'));
		}else{
			return redirect()->back()->withErrors(['error'=>'Token mis-matched.']);
		}
	}
	
	public function custom_cart_remove(Request $request){
		$post_data = $request->all();
		$deleted = DB::table('custom_carts')->where('id',$post_data['cart_id'])->delete();
		return 'OK';
	}
	
	public function custom_payment_process(Request $request){
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		
		$user_data = DB::table('users')->where('id',Auth::user()->id)->first();
		if($user_data->verify == 0){
			return redirect()->back()->with(['email'=>$user_data->email]);
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
		$data['gtotal'] = $request->get('gtotal');
		$data['currency_symbol'] = $request->get('currency_symbol');
		$data['currency_code'] = $request->get('currency_code');
		$data['address_id'] = $address_id;
		$data['custom_cart_id'] = $request->get('custom_cart_id');
		/** end cart form data **/
		/** cart items **/
		$status = 0;
		$cartItems = DB::table('custom_carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '".$status."'")->get();
		$item_count = count($cartItems);
		/** end cart items **/
		return view('custom_cart.process',compact('help_group_pages','resource_group_pages','corporate_group_pages','data','item_count'));
	}
	
	/** added for mail verification **/
	public function resend_verify_mail($email = null){
		$data = User::where('email','=',$email)->first();
		$data['activate_link'] = url('prints/account_activate/'.base64_encode($data['email']));
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
			return redirect('/custom_cart')->with(['verified'=>'yes']);
		}else{
			return redirect('/custom_cart')->with(['verified'=>'no']);
		}
	}
	/** end mail verification **/
}