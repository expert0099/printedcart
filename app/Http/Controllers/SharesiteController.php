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
use Illuminate\Pagination;
use Session;
use Mail;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class SharesiteController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
	 
	public function index(){
		
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		/** cart items **/
		$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
		$item_count = count($cartItems);
		/** end cart items **/
		
		$shareSiteCategory = DB::table('sharesitecategories')->whereNull('deleted_at')->get();
		foreach($shareSiteCategory as $k => $value){
			$upload = DB::table('uploads')->select('path','hash')->where('id',$value->photo)->first();
			$upDataArr = explode("uploads",$upload->path);
			$img = 'storage/uploads'.$upDataArr[1];
			$value->img_path = $img;
		}
		
		return view('sharesite.index',compact('help_group_pages','resource_group_pages','corporate_group_pages','item_count','shareSiteCategory'));
    }
	
	public function sharesite(){
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		/** cart items **/
		$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
		$item_count = count($cartItems);
		/** end cart items **/
		
		$created_sites = DB::table('sharesites')->where('user_id',Auth::user()->id)->get();
		
		foreach($created_sites as $k => $v){
			$sstd_id = $v->sharesitetemplatedesign_id;
			$sstd = DB::table('sharesitetemplatedesigns')->where('id',$sstd_id)->first();
			$upload = DB::table('uploads')->select('path','hash')->where('id',$sstd->template_photo)->first();
			$upDataArr = explode("uploads",$upload->path);
			$img = 'storage/uploads'.$upDataArr[1];
			$v->template_photo = $img;
		}
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		
		return view('sharesite.sharesite',compact('help_group_pages','resource_group_pages','corporate_group_pages','item_count','protocol','created_sites'));
	}
	public function delete_site(Request $request){
		$post_data = $request->all();
		$sharesite_id = $post_data['sharesite_id'];
		$delete = DB::table('sharesites')->where('id',$sharesite_id)->delete();
		if($delete){
			return redirect()->back()->with(['success'=>'Share site deleted successfully!']);
		}else{
			return redirect()->back()->withErrors(['error'=>'Something went wrong!']);
		}
	}
	public function share_to_friend(Request $request){
		$post_data = $request->all();
		$sharesite_id = $post_data['sharesite_id'];
		$share_site = DB::table('sharesites')->where('id',$sharesite_id)->first();
		$message = $post_data['message'];
		$email = $post_data['email'];
		$em = explode(',',$email);
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$count = count($em);
		$flag = 0;
		
		/* foreach($em as $k => $v){
			$data = array(
				'email' => $v,
				'message_body' => $message,
				'website_url' => $protocol.$share_site->website_url .'?sid='.base64_encode($sharesite_id)
			);
			Mail::send('emails.share_site', $data, function($message)use($v){
				$message->from('alexjoby987@gmail.com','Administrator');
				$message->to($v);
				$message->subject('Share site: Printed cart');
			});
			$flag++;
		} */
		if($flag == $count){
			return redirect()->back()->with(['success'=>'Thank your for share site to your friend!']);
		}else{
			return redirect()->back()->withErrors(['error'=>'Something went wrong!']);
		}
	}
   
	public function makeasite($id = null){
		$host = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$uri = explode('/',$host);
		$site_url = $uri[0].'/'.$uri[2];
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		/** cart items **/
		$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
		$item_count = count($cartItems);
		/** end cart items **/
		$ssc = DB::table('sharesitecategories')->whereNull('deleted_at')->orderBy('id','ASC')->get();
		
		return view('sharesite.makeasite',compact('help_group_pages','resource_group_pages','corporate_group_pages','item_count','id','ssc','site_url'));
	}
	
	public function makeasite_post(Request $request){
		$host = $_SERVER['HTTP_HOST'].'/'.$_SERVER['REQUEST_URI'];
		$uri = explode('/',$host);
		$site_url = $uri[0].'/'.$uri[2];
		
		$post_data = $request->all();
		
		if(isset($post_data['site_name']) && !empty($post_data['site_name'])){
			$site_name = $post_data['site_name'];
		}else{
			$site_name = '';
		}
		if(isset($post_data['website_url']) && !empty($post_data['website_url'])){
			$website_url = $post_data['website_url'].'.'.$site_url;
		}else{
			$website_url = '';
		}
		if(isset($post_data['sports']) && !empty($post_data['sports'])){
			$sports = $post_data['sports'];
		}else{
			$sports = '';
		}
		if(isset($post_data['gender']) && !empty($post_data['gender'])){
			$gender = $post_data['gender'];
		}else{
			$gender = '';
		}
		if(isset($post_data['age_range']) && !empty($post_data['age_range'])){
			$age_range = $post_data['age_range'];
		}else{
			$age_range = '';
		}
		if(isset($post_data['team_name']) && !empty($post_data['team_name'])){
			$team_name = $post_data['team_name'];
			$site_name = $team_name;
		}else{
			$team_name = '';
		}
		if(isset($post_data['zip_code']) && !empty($post_data['zip_code'])){
			$zip_code = $post_data['zip_code'];
		}else{
			$zip_code = '';
		}
		if(isset($post_data['role']) && !empty($post_data['role'])){
			$role = $post_data['role'];
		}else{
			$role = '';
		}
		if(isset($post_data['grade']) && !empty($post_data['grade'])){
			$grade = $post_data['grade'];
		}else{
			$grade = '';
		}
		if(isset($post_data['event_type']) && !empty($post_data['event_type'])){
			$event_type = $post_data['event_type'];
		}else{
			$event_type = '';
		}
		if(isset($post_data['event_date']) && !empty($post_data['event_date'])){
			$event_date = $post_data['event_date'];
		}else{
			$event_date = '';
		}
		if(isset($post_data['birthday']) && !empty($post_data['birthday'])){
			$birthday = $post_data['birthday'];
		}else{
			$birthday = '';
		}
		if(isset($post_data['wedding_date']) && !empty($post_data['wedding_date'])){
			$wedding_date = $post_data['wedding_date'];
		}else{
			$wedding_date = '';
		}
		$exist = DB::table('sharesites')->where('site_name','=',$site_name)->first();
		if(count($exist)>0){
			return redirect()->back()->withErrors(['error'=>'Site name already exist. Please choose different name']);
		}else{
			$insArr = array(
				'site_category'	=> $post_data['site_category_v'],
				'site_name'		=> $site_name,
				'website_url'	=> $website_url,
				'whocanviewsite'=> '',//$post_data['whocanviewsite'],
				'sports'		=> $sports,
				'gender'		=> $gender,
				'age_range'		=> $age_range,
				'zip_code'		=> $zip_code,
				'team_name'		=> $team_name,
				'role'			=> $role,
				'grade'			=> $grade,
				'event_type'	=> $event_type,
				'event_date'	=> $event_date,
				'birthday'		=> $birthday,
				'wedding_date'	=> $wedding_date,
				'user_id'		=> Auth::user()->id
			);
			
			$sharesite_id = DB::table('sharesites')->insertGetId($insArr);
			if($sharesite_id){
				return redirect('sharesite/choose_design/'.$sharesite_id);
			}else{
				return redirect()->back()->withErrors(['error'=>'Something went wrong.']);
			}
		}
	}
	
	public function choose_design($sharesite_id = null){
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		/** cart items **/
		$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
		$item_count = count($cartItems);
		/** end cart items **/
		
		$template = DB::table('sharesitetemplatedesigns')->where('isActive',1)->get();
		foreach($template as $k => $v){
			$upload = DB::table('uploads')->select('path','hash')->where('id',$v->template_photo)->first();
			$upDataArr = explode("uploads",$upload->path);
			$img = 'storage/uploads'.$upDataArr[1];
			$v->template_photo = $img;
		}
		return view('sharesite.choose_design',compact('help_group_pages','resource_group_pages','corporate_group_pages','item_count','sharesite_id','template'));
	}
	public function choose_design_post(Request $request){
		$post_data = $request->all();
		$upArr = array(
			'sharesitetemplatedesign_id' => $post_data['template_design']
		);
		$update = DB::table('sharesites')->where('id',$post_data['sharesite_id'])->update($upArr);
		if($update){
			$sharesite = DB::table('sharesites')->where('id',$post_data['sharesite_id'])->first();
			$website_url = $sharesite->website_url;
			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
			return redirect($protocol.$website_url.'?sid='.base64_encode($post_data['sharesite_id']));
		}else{
			return redirect()->back()->withErrors(['error'=>'Something went wrong!']);
		}
	}
}