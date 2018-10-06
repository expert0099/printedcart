<?php
/**
 * Controller genrated using 
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\SizeGroup;
use DB;
use App\Staticpage;
use Validator;
use Auth;
use Mail;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->help_group_pages = $this->help_group_pages();
		$this->resource_group_pages = $this->resource_group_pages();
		$this->corporate_group_pages = $this->corporate_group_pages();
		$this->user_feedback = $this->user_feedback();
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        
		$group = SizeGroup::orderBy('id','DESC')->take(3)->get();
		foreach($group as $k => $v){
			$upload = DB::table('uploads')->select('path','hash')->where('id',$v['photo'])->first();
			//$upDataArr = explode('-',$upload->path);
			//$img = env('APP_URL') ."files/". $upload->hash ."/". end($upDataArr);
			$upDataArr = explode("uploads",$upload->path);
			$img = 'storage/uploads'.$upDataArr[1];
			$v['feature_image'] = $img;
		}
		
		/*** home page about us content ***/
		$whereRaw = "page_group = 'Other' AND page_slug = 'why_choose' OR page_slug = 'whychoose' OR page_slug = 'why-choose'";
		$about_content = Staticpage::whereRaw($whereRaw)->first();
		/*** end about us content ***/
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		$user_feedback = $this->user_feedback;
		
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
		return view('home.index',compact('group','about_content','help_group_pages','resource_group_pages','corporate_group_pages','item_count','user_feedback'));
    }
	
	public function newsletter(Request $request){
		$validator = Validator::make($request->all(), [
            'email' => 'required|unique:newsletters|email|max:255',
        ]);
        if ($validator->fails()) {
            return redirect('/home')->withErrors($validator)->withInput();
        }else{
			$email = $request->get('email');
			$save = DB::table('newsletters')->insert(array('email'=>$email,'flag'=>'Design Tips'));
			if($save){
				return redirect('/home')->with(['status'=>'Subscribed Successfully!!!']);
			}else{
				return redirect('/home')->withErrors(['error'=>'something went wrong!'])->withInput();
			}
		}
	}
	
	public function request_quote(Request $request){
		$validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'quote_email' => 'required|email|max:255',
            'phone' => 'required|numeric|min:10',
            'message' => 'required|max:500',
        ]);
		if($validator->fails()){
            return redirect('/home#request-a-quote')->withErrors($validator)->withInput();
        }else{
			$insArr = array('name'=>$request->get('name'),'email'=>$request->get('quote_email'),'phone'=>$request->get('phone'),'product'=>$request->get('product'),'message'=>$request->get('message'));
			$save = DB::table('quotes')->insert($insArr);
			if($save){
				$configs = DB::table('la_configs')->get();
				$default_email = 'expertteam11@gmail.com';
				foreach($configs as $k => $val){
					if($val->key == 'default_email'){
						$default_email = $val->value;
					}
				}
				$data['email'] = $request->get('quote_email');
				$data['name'] = $request->get('name');
				$data['phone'] = $request->get('phone');
				$data['product'] = $request->get('product');
				$data['message'] = $request->get('message');
				$data['default_email'] = $default_email;
				Mail::send('emails.quote', ['data' => $data], function ($m) use ($data){
					$m->from($data['email'], $data['name']);
					$m->to($data['default_email'], 'Admin')->subject('Request Quote : Printed Cart');
				}); 
				return redirect('/home#request-a-quote')->with(['quote'=>'Request send successfully!!!']);
			}else{
				return redirect('/home#request-a-quote')->with(['quote_error'=>'something went wrong!'])->withInput();
			}
		}
	}
	
	public function logout_verify(){
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		if(Auth::check()){
			/** cart items **/
			$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
			$item_count = count($cartItems);
			/** end cart items **/
		}else{
			$item_count = 0;
		}
		return view('user.logout_verify',compact('help_group_pages','resource_group_pages','corporate_group_pages','item_count'));
	}
	
	
}