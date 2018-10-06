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
use Redirect;
use Validator;
use Illuminate\Pagination;
use Session;


/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class CartController extends Controller
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

    public function add_to_cart(Request $request){
		$project_id = $request->get('project_id');
		$_token = $request->get('_token'); 
		$flag = $request->get('flag');
		$exist = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND project_id='".$project_id."' AND cart_type = '".$flag."'")->first();
		if(count($exist)>0){
			return redirect()->back()->with('error', 'Already Added!');
		}else{
			$insArr = array(
				'user_id' => Auth::user()->id,
				'project_id' => $request->get('project_id'),
				'session_id' => $request->get('_token'),
				'cart_type' => $flag
			);
			
			DB::table('carts')->insert($insArr);
			return redirect()->back()->with(['success_add_to_cart'=>'added_to_cart']);
		}
	}
	
}