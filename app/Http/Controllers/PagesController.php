<?php
/** * Controller genrated using  */
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;
use App\Staticpage;
use Session;
use Mail;
use Auth,DB;

/** * Class HomeController 
* @package App\Http\Controllers */

class PagesController extends Controller{    
	/**     * Create a new controller instance.     *     
	* @return void     */    
	public function __construct(){        
		$this->help_group_pages = $this->help_group_pages();		
		$this->resource_group_pages = $this->resource_group_pages();		
		$this->corporate_group_pages = $this->corporate_group_pages();    
	}
	
    /**     * Show the application dashboard.     *     
	* @return Response     */
	
	public function pages($page_slug=null){		
		$help_group_pages = $this->help_group_pages;		
		$resource_group_pages = $this->resource_group_pages;		
		$corporate_group_pages = $this->corporate_group_pages;
		
		if(Auth::check()){
			$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
			if(count($cartItems)>0){
				$item_count = count($cartItems);
			}else{
				$item_count = 0;
			} 
		}else{
			$item_count = 0;
		}
		
		if($page_slug == 'about'){			
			$whereRaw = "page_group = 'Other' AND page_slug = 'about_us' OR page_slug = 'aboutus' OR page_slug = 'about-us' OR page_slug = 'about'";			
			$about_content = Staticpage::whereRaw($whereRaw)->first();			
			return view('pages.about',compact('about_content','help_group_pages','resource_group_pages','corporate_group_pages','page_slug','item_count'));		
		}elseif($page_slug == 'sitemap'){			
			$whereRaw = "page_group = 'Other' AND page_slug = 'sitemap' OR page_slug = 'site_map' OR page_slug = 'Sitemap' OR page_slug = 'Site_Map' OR page_slug = 'site-map'";			
			$page_content = Staticpage::whereRaw($whereRaw)->first();			
			return view('pages.page',compact('page_content','help_group_pages','resource_group_pages','corporate_group_pages','page_slug','item_count'));		
		}elseif($page_slug == 'terms'){			
			$whereRaw = "page_group = 'Other' AND page_slug = 'terms' OR page_slug = 'Terms' OR page_slug = 'terms_of_use' OR page_slug = 'terms-of-use'";			
			$page_content = Staticpage::whereRaw($whereRaw)->first();			
			return view('pages.page',compact('page_content','help_group_pages','resource_group_pages','corporate_group_pages','page_slug','item_count'));		
		}elseif($page_slug == 'privacy'){			
			$whereRaw = "page_group = 'Other' AND page_slug = 'privacy' OR page_slug = 'Privacy' OR page_slug = 'privacy_policy' OR page_slug = 'privacy-policy' OR page_slug = 'Privacy_policy'";			
			$page_content = Staticpage::whereRaw($whereRaw)->first();			
			return view('pages.page',compact('page_content','help_group_pages','resource_group_pages','corporate_group_pages','page_slug','item_count'));		
		}elseif($page_slug == 'blog'){			
			$page_content = Staticpage::whereRaw("page_slug LIKE '%".$page_slug."%'")->first();			
			return view('pages.page',compact('page_content','help_group_pages','resource_group_pages','corporate_group_pages','page_slug','item_count'));	
		}elseif($page_slug == 'contact'){
			return view('pages.contact',compact('help_group_pages','resource_group_pages','corporate_group_pages','page_slug','item_count'));
		}else{		
			$page_content = Staticpage::whereRaw("page_slug LIKE '%".$page_slug."%'")->first();			
			return view('pages.page',compact('page_content','help_group_pages','resource_group_pages','corporate_group_pages','page_slug','item_count'));		
		}	
	}
	
	public function contact(Request $request){
		$rules = array(
			'first_name' => 'required',
			'last_name' => 'required',
			'company_name' => 'required',
			'email' => 'required|email',
			'phone' => 'required|regex:/^\d{10}$/',
			'msg' => 'required',
		);
		$validator = Validator::make($request->all(), $rules);
		if($validator->fails()) {
			return redirect()->back()
				->withErrors($validator)
				->withInput();
		}else{
			$post_data = $request->all();
			$data = array(
				'first_name' => $post_data['first_name'],
				'last_name' => $post_data['last_name'],
				'company_name' => $post_data['company_name'],
				'email' => $post_data['email'],
				'phone' => $post_data['phone'],
				'msg' => $post_data['msg']
			);
			Mail::send('emails.contact', $data, function($message)use($data){
				$message->from('alexjoby987@gmail.com','Administrator');
				$message->to('expertteam11@gmail.com');
				$message->subject('Contact : Printed Cart');
			});
			return redirect()->back()->with(['success'=>'Thanks, your mail received, we will revert back soon.']);
		}
	}
}