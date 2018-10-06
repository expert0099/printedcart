<?php
/**
 * Controller genrated using 
 */

namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use DB,Auth;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class SitemapController extends Controller
{
	public function __construct(){
        $this->help_group_pages = $this->help_group_pages();
		$this->resource_group_pages = $this->resource_group_pages();
		$this->corporate_group_pages = $this->corporate_group_pages();
	}
	
    public function sitemap(){
		
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		if(Auth::check()){
			$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
			$item_count = count($cartItems);
		}else{
			$item_count = 0;
		}
		
		return view('sitemap.sitemap',compact('help_group_pages','resource_group_pages','corporate_group_pages','item_count'));
	}
	
	
	
}