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
		$cartData = DB::table('custom_carts')->where('user_id',Auth::user()->id)->get();
		
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
			$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
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
	
}