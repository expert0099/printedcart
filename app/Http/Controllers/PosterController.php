<?php
/**
 * Controller genrated using 
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\CalendarCategory;
use App\CalendarDefaultSize;
use App\Size;
use App\Currency;
use DB;
use Auth;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class PosterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
		//$this->middleware('auth');
        $this->help_group_pages = $this->help_group_pages();
		$this->resource_group_pages = $this->resource_group_pages();
		$this->corporate_group_pages = $this->corporate_group_pages();
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index(){
		/**** default currency ****/
		$default_currency = Currency::where('isDefault',1)->first();
		
		/**** end default currency ****/
		$cal_cat = CalendarCategory::with('CalendarDefaultSize')->skip(1)->take(4)->get();
		foreach($cal_cat as $k => $v){
			$upload = DB::table('uploads')->select('path','hash')->where('id',$v['calendar_image'])->first();
			$upDataArr = explode("uploads",$upload->path);
			$img = 'storage/uploads'.str_replace('\\','/',$upDataArr[1]);
			$v['calendar_image_path'] = $img;
			$v['Size'] = Size::where('id',$v['CalendarDefaultSize']['size_id'])->first();
		}
		
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		
		/** cart items **/
		if(Auth::check()){
			$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
			$item_count = count($cartItems);
		}else{
			$item_count = 0;
		}
		/** end cart items **/
		
		return view('poster.index',compact('default_currency','cal_cat','help_group_pages','resource_group_pages','corporate_group_pages','item_count'));
    }
}