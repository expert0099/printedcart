<?php
/**
 * Controller genrated using 
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB,Auth;
use App\Staticpage;
use App\Album;
use App\UserUpload;
use App\Project;
use App\Order;
use Redirect;
use Validator;
use Illuminate\Pagination;
use App\User;
use App\UserAddressInfo;
use Session;
use App\CalendarStyle;
use App\Photobook;
use App\Size;
use PDF;



ini_set('display_errors',1);
error_reporting(E_ALL);

session_start();

require_once('vendor/facebook/php-sdk-v4/src/Facebook/FacebookSession.php');
require_once('vendor/facebook/php-sdk-v4/src/Facebook/FacebookSession.php');
require_once('vendor/facebook/php-sdk-v4/src/Facebook/FacebookRedirectLoginHelper.php');
require_once('vendor/facebook/php-sdk-v4/src/Facebook/FacebookRequest.php');
require_once('vendor/facebook/php-sdk-v4/src/Facebook/FacebookResponse.php');
require_once('vendor/facebook/php-sdk-v4/src/Facebook/FacebookSDKException.php');
require_once('vendor/facebook/php-sdk-v4/src/Facebook/FacebookRequestException.php');
require_once('vendor/facebook/php-sdk-v4/src/Facebook/FacebookAuthorizationException.php');
require_once('vendor/facebook/php-sdk-v4/src/Facebook/GraphObject.php');
require_once('vendor/facebook/php-sdk-v4/src/Facebook/Entities/AccessToken.php');
require_once('vendor/facebook/php-sdk-v4/src/Facebook/HttpClients/FacebookHttpable.php');
require_once('vendor/facebook/php-sdk-v4/src/Facebook/HttpClients/FacebookCurlHttpClient.php');
require_once('vendor/facebook/php-sdk-v4/src/Facebook/HttpClients/FacebookCurl.php'); 

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookHttpable;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookCurl; 
use Facebook\GraphUser;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class UserController extends Controller
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
	//https://printedcart.com/printedcart/user/account_activate/ZXhwZXJ0dGVhbTAwOUBnbWFpbC5jb20=
	public function account_verify($email = null){
		$email = base64_decode($email);
		$verify = User::where('email','=',$email)->update(array('verify'=>1));
		if($verify){
			return redirect('/user/section')->with(['success'=>'Your Account verified successfully!']);
			/* $user = User::where('email','=',$email)->first();
			$user_id = $user->id; */
			//Auth::guard()->login($user);
			//return redirect('/user/register')->with(['verified'=>'yes','user_id'=>$user_id]);
		}else{
			return redirect('/user/login')->withErrors(['error'=>'Something went wrong! Account not verified yet.']);
			//return redirect('/user/register')->with(['verified'=>'no']);
		}
	}
	
    public function my_photos(){
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		
		/** user album **/
		$all_user_album = Album::with('UserUpload')->where('user_id',Auth::user()->id)->where('deleted_at','=','0000-00-00 00:00:00')->get();
		/** end user album **/
		
		/** cart items **/
		$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
		$item_count = count($cartItems);
		/** end cart items **/
		
		$album = Album::where('user_id',Auth::user()->id)->where('deleted_at','=','0000-00-00 00:00:00')->pluck('album_name','id');
		if(isset(Auth::user()->email)){
			if(null!==Session::get('flag_poster_url')){
				Session::forget('flag_poster_url');
			}
			if(null!==Session::get('flag_calendar_url')){
				Session::forget('flag_calendar_url');
			}
			if(null!==Session::get('flag_photobook_simple_url')){
				Session::forget('flag_photobook_simple_url');
			}
			if(null!==Session::get('flag_photobook_custom_url')){
				Session::forget('flag_photobook_custom_url');
			}
			if(null!==Session::get('flag_myphoto_url')){
				Session::forget('flag_myphoto_url');
			}
			if(null!==Session::get('flag_albumphoto_url')){
				Session::forget('flag_albumphoto_url');
			}
			Session::put('flag_myphoto_url',str_replace('/printedcart/','/',$_SERVER['REDIRECT_URL']));
			return view('user.my_photos',compact('help_group_pages','resource_group_pages','corporate_group_pages','album','all_user_album','item_count'));
		}else{
			return redirect('user/login');
		}
    }
	
	public function add_album(Request $request){
		$exist = Album::whereRaw("album_name LIKE '%".$request->get('album_name')."%'")->first();
		if(count($exist)>0){
			return Redirect::back()->with('error_msg', 'Oops! You already have an album with that name. Please try again with a different name.');
		}else{
			$album = Album::insertGetId(array('album_name'=>$request->get('album_name'),'user_id'=>Auth::user()->id));
			return Redirect::to('user/my_photos/album/'.$album)->with('success_msg', 'Album created successfully! Now add photos!');
			//return Redirect::back()->with('success_msg', 'Album create successfully!!!');
		}
	}
	
	public function getExistAlbum(Request $request){
		$exist = Album::whereRaw("album_name LIKE '%".$request->get('album_name')."%'")->first();
		if(count($exist)>0){
			return 'yes';
		}else{
			return 'no';
		}
	}
	
	public function add_photo(Request $request){
		/* $rules = array(
			'images' => 'required',
			'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240|dimensions:min_width=600,min_height=500',
		);
		$messsages = array(
			'images.*.max'=>'Error. Maximum file size: 10MB',
			'images.*.dimensions'=>'Error. Minimum photo dimensions: 600px width x 500px height',
            'images.*.mimes'=>'Error. Accepted file types: JPEG, PNG, JPG, GIF',
		);

		$validator = Validator::make($request->all(), $rules, $messsages);
		
		if($validator->fails()){
			return Redirect::back()
				->withErrors($validator)
				->withInput();
		}else{  */
		/* echo '<pre>';
		print_r($_FILES);exit; */
			$user_id = Auth::user()->id; 
			$allowed_image_extension = array("png","jpg","jpeg","gif");
			$img_upl_cnt = 0;
			foreach($_FILES['images']['name'] as $k => $value){
				$fileinfo = @getimagesize($_FILES['images']['tmp_name'][$k]);
				$width = $fileinfo[0];
				$height = $fileinfo[1];
				
				// Get image file extension
				$file_extension = pathinfo($_FILES['images']['name'][$k], PATHINFO_EXTENSION);
				if(!file_exists($_FILES['images']['tmp_name'][$k])){
					$response['error'][] = $_FILES['images']['name'][$k]." Error. Must be an image";
				}    
				// Validate file input to check if is with valid extension
				else if(!in_array($file_extension, $allowed_image_extension)){
					$response['error'][] = $_FILES['images']['name'][$k]." Error. Accepted file types: JPEG, PNG, JPG, GIF";
				}    
				// Validate image file size
				else if(($_FILES['images']['size'][$k] > 10485760)){
					$response['error'][] = $_FILES['images']['name'][$k]." Error. Maximum file size: 10MB";
				}    
				// Validate image file dimension
				else if($width < '600' || $height < '500'){
					$response['error'][] = $_FILES['images']['name'][$k]." Error. Minimum photo dimensions: 600px width x 500px height";
				} 
				else {
					$destinationPath = public_path('users_upload').'/'.$user_id;
					$filename = "pc_".$k."_".time().'.'.$file_extension;
					if(!file_exists($destinationPath)){
						mkdir($destinationPath, 0777);
					}
					$target = $destinationPath.'/'.$filename;
					if(move_uploaded_file($_FILES['images']['tmp_name'][$k], $target)){
						$img_upl_cnt++;
						DB::table('user_uploads')->insert(array(
							'name' => $filename,
							'path' => 'users_upload'.'/'.$user_id,
							'extension' => $file_extension,
							'user_id' => $user_id,
							'album_id' => $request->get('album_id')
						));
						if($img_upl_cnt>1){
							$uploded_text = "photos";
						}else{
							$uploded_text = "photo";
						}
						$response['success'] = $img_upl_cnt." ".$uploded_text." uploaded successfully";
					} else {
						$response['error'][] = $_FILES['images']['name'][$k]." Error. Problem in uploading image files.";
					} 
				}
			}
			if(!empty($response['error'])){
				$img_err_cnt = count($response['error']);
				if($img_err_cnt>1){
					$err_text = "errors";
					$img_text = "photos";
				}else{
					$err_text = "error";
					$img_text = "photo";
				}
				$response['err_msg'] = $img_err_cnt." ".$img_text." upload ".$err_text;
				return Redirect::back()->with(['message'=>$response])->withInput();
			}else{
				return Redirect::to('user/my_photos/album/'.$request->get('album_id'));
			}
			
			/* $i = 0;
			$images = $request->file('images');
			foreach($images as $k => $image){
				$filename = "pc_".$i."_".time().'.'.$image->getClientOriginalExtension();
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$destinationPath = public_path('users_upload').'/'.$user_id;
				if(!file_exists($destinationPath)){
					mkdir($destinationPath, 0777);
				}
				$image->move($destinationPath, $filename);
				DB::table('user_uploads')->insert(array(
					'name' => $filename,
					'path' => 'users_upload'.'/'.$user_id,
					'extension' => $ext,
					'user_id' => Auth::user()->id,
					'album_id' => $request->get('album_id')
				));
				$i++;
			} */
		//}
		//return Redirect::to('user/my_photos/album/'.$request->get('album_id'));
	}
	
	public function edit_photo(Request $request){
		$user_id = Auth::user()->id; 
		$allowed_image_extension = array("png","jpg","jpeg","gif");
		//foreach($_FILES['images']['name'] as $k => $value){
		$fileinfo = @getimagesize($_FILES['images']['tmp_name']);
		$width = $fileinfo[0];
		$height = $fileinfo[1];
		$img_upl_cnt = 0;		
		// Get image file extension
		$file_extension = pathinfo($_FILES['images']['name'], PATHINFO_EXTENSION);
		if(!file_exists($_FILES['images']['tmp_name'])){
			$response['error'][] = $_FILES['images']['name']." Error. Must be an image";
		}    
		// Validate file input to check if is with valid extension
		else if(!in_array($file_extension, $allowed_image_extension)){
			$response['error'][] = $_FILES['images']['name']." Error. Accepted file types: JPEG, PNG, JPG, GIF";
		}    
		// Validate image file size
		else if(($_FILES['images']['size'] > 10485760)){
			$response['error'][] = $_FILES['images']['name']." Error. Maximum file size: 10MB";
		}    
		// Validate image file dimension
		else if($width < '600' || $height < '500'){
			$response['error'][] = $_FILES['images']['name']." Error. Minimum photo dimensions: 600px width x 500px height";
		} 
		else {
			$destinationPath = public_path('users_upload').'/'.$user_id;
			$filename = "pc_".$width."_".time().'.'.$file_extension;
			if(!file_exists($destinationPath)){
				mkdir($destinationPath, 0777);
			}
			$target = $destinationPath.'/'.$filename;
			if(move_uploaded_file($_FILES['images']['tmp_name'], $target)){
				$img_upl_cnt++;
				DB::table('user_uploads')->where('id',$request->get('photo_id'))->update(array(
					'name' => $filename,
					'path' => 'users_upload'.'/'.$user_id,
					'extension' => $file_extension,
					'user_id' => $user_id,
					'album_id' => $request->get('album_id')
				));
				if($img_upl_cnt>1){
					$uploded_text = "photos";
				}else{
					$uploded_text = "photo";
				}
				$response['success'] = $img_upl_cnt." ".$uploded_text." uploaded successfully";
				//$response['success'][] = $_FILES['images']['name']." Success. Image upload successfully.";
			} else {
				$response['error'][] = $_FILES['images']['name']." Error. Problem in uploading image files.";
			} 
		}
		//}
		if(!empty($response['error'])){
			$img_err_cnt = count($response['error']);
			if($img_err_cnt>1){
				$err_text = "errors";
				$img_text = "photos";
			}else{
				$err_text = "error";
				$img_text = "photo";
			}
			$response['err_msg'] = $img_err_cnt." ".$img_text." upload ".$err_text;
			return Redirect::back()->with(['message'=>$response])->with('photo_id',$request->get('photo_id'))->withInput();
		}else{
			return back()->with('success_msg','Image updated successfully');
		}
		/* $rules = array(
			'images' => 'required',
			'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240|dimensions:min_width=600,min_height=500',
		);
		$messsages = array(
			'images.*.max'=>'Error. Maximum file size: 10MB',
			'images.*.dimensions'=>'Error. Minimum photo dimensions: 600px width x 500px height',
            'images.*.mimes'=>'Error. Accepted file types: JPEG, PNG, JPG, GIF',
		);
		$validator = Validator::make($request->all(), $rules, $messsages);
		if($validator->fails()) {
			return Redirect::back()
				->withErrors($validator)
				->withInput()
				->with('photo_id',$request->get('photo_id'));
		}else{ 
			$user_id = Auth::user()->id; 
			$i = 0;
			$images = $request->file('images');
			foreach($images as $k => $image){
				$filename = "pc_".$i."_".time().'.'.$image->getClientOriginalExtension();
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				//$destinationPath = public_path('/uploads/user_images');
				$destinationPath = public_path('users_upload').'/'.$user_id;
				if(!file_exists($destinationPath)){
					mkdir($destinationPath, 0777);
				}
				$image->move($destinationPath, $filename);
				DB::table('user_uploads')->where('id',$request->get('photo_id'))->update(array(
					'name' => $filename,
					'path' => 'users_upload'.'/'.$user_id,
					'extension' => $ext,
					'user_id' => Auth::user()->id,
					'album_id' => $request->get('album_id')
				));
				$i++;
			}
		}
		return back()->with('success_msg','Image updated successfully'); */
	}
	
	public function get_album_photos($album_id=null){
		$album_photos = Album::with('UserUpload')
			->whereRaw("id = '".$album_id."' AND user_id = '".Auth::user()->id."'")
			->get();
		
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		
		/** cart items **/
		$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
		$item_count = count($cartItems);
		/** end cart items **/
		
		$album = Album::where('user_id',Auth::user()->id)->where('deleted_at','=','0000-00-00 00:00:00')->pluck('album_name','id');
		if(null!==Session::get('flag_poster_url')){
			Session::forget('flag_poster_url');
		}
		if(null!==Session::get('flag_calendar_url')){
			Session::forget('flag_calendar_url');
		}
		if(null!==Session::get('flag_photobook_simple_url')){
			Session::forget('flag_photobook_simple_url');
		}
		if(null!==Session::get('flag_photobook_custom_url')){
			Session::forget('flag_photobook_custom_url');
		}
		if(null!==Session::get('flag_myphoto_url')){
			Session::forget('flag_myphoto_url');
		}
		if(null!==Session::get('flag_albumphoto_url')){
			Session::forget('flag_albumphoto_url');
		}
		Session::put('flag_albumphoto_url',str_replace('/printedcart/','/',$_SERVER['REDIRECT_URL']));
		return view('user.album_photos',compact('help_group_pages','resource_group_pages','corporate_group_pages','album_photos','item_count','album','album_id'));
	}
	
	public function my_projects($slug=null){
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		
		/** user album **/
		if($slug=='cp'){
			$slug = 'College Poster';
		}
		$all_user_project = Project::whereRaw("user_id = '". Auth::user()->id ."' AND delete_flag = '0' AND flag = '".$slug."'")
			//->where('created_at','=','0000-00-00 00:00:00')
			->orderBy('id','DESC')
			->get();
		/** end user album **/
		
		if(isset(Auth::user()->email)){
			return view('user.my_projects',compact('help_group_pages','resource_group_pages','corporate_group_pages','all_user_project','slug'));
		}else{
			return redirect('user/login');
		}
    }
	
	public function delete_project($project_id=null,$slug=null){
		$upArr = array(
			'deleted_At' => date('Y-m-d H:i:s'),
			'delete_flag' => 1
		);
		DB::table('user_saved_projects')->where('project_id',$project_id)->update(array('deleted_At' => date('Y-m-d H:i:s')));
		DB::table('projects')->where('id',$project_id)->update($upArr);
		DB::table('ordered_pdf_images')->where('project_id',$project_id)->update($upArr);
		return redirect()->back()->withErrors(['error'=>'Project deleted successfully']);
	}
	
	public function section(){
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		
		$all_my_project = Project::with('Cart','Order')->whereRaw("user_id = '". Auth::user()->id ."' AND delete_flag = '0'")
			->orderBy('id','DESC')
			->paginate(12);
			
		//$address = User::with('UserAddressInfo')->where('id',Auth::user()->id)->first();
		$address = UserAddressInfo::whereRaw("user_id = '". Auth::user()->id ."' AND address_type = 'Primary'")->first();
		
		$user_info = DB::table('users')->where('id',Auth::user()->id)->first();
		
		$orders = Order::with('Project')->where('user_id',Auth::user()->id)->get();
		
		if(count($orders)>0){
			foreach($orders as $k => $val){
				if($val['Project']['flag'] == 'Calendar'){
					if(!empty($val['Project'])){
						$sizeArr = Size::where('id',$val['Project']['size_id'])->first();
						$val['Project']['size'] = $sizeArr['Size'];
						$calstyle = CalendarStyle::where('id',$val['Project']['calendar_style_id'])->first();
						$val['Project']['order_name'] = $calstyle['calendar_style'];
					}
				}else{
					if(!empty($val['Project'])){
						$sizeArr = Size::where('id',$val['Project']['size_id'])->first();
						$val['Project']['size'] = $sizeArr['Size'];
						$photobook = Photobook::where('id',$val['Project']['photobook_id'])->first();
						$val['Project']['order_name'] = $photobook['photo_book'];
					}
				}
			}
		}else{
			$orders = array();
		}
		
		
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
		$default_currency = DB::table('currencies')->where('isDefault',1)->first();
		
		return view('user/section', compact('help_group_pages', 'resource_group_pages', 'corporate_group_pages', 'all_my_project', 'address', 'user_info', 'orders','item_count','default_currency'));
	}
	
	public function save_info(Request $request){
		$email 		= $request->get('email');
		$first_name = $request->get('first_name');
		$last_name  = $request->get('last_name');
		$street		= $request->get('street');
		$city		= $request->get('city');
		$state		= $request->get('state');
		$zipcode	= $request->get('zipcode');
		$country	= $request->get('country');
		$user_id 	= Auth::user()->id;
		$userinfo = UserAddressInfo::where('user_id',$user_id)->first();
		if(count($userinfo)>0){
			$editArr = array(
				'email'			=>  $email,
				'first_name'	=>	$first_name,
				'last_name'		=>	$last_name,
				'street'		=>	$street,
				'city'			=>	$city,
				'state'			=>	$state,
				'zipcode'		=>	$zipcode,
				'country'		=>	$country,
				'address_type'	=>  'Primary'
			);
			$edit = UserAddressInfo::where('user_id',$user_id)->update($editArr);
		}else{
			$editArr = array(
				'user_id'		=> $user_id,
				'email'			=>  $email,
				'first_name'	=>	$first_name,
				'last_name'		=>	$last_name,
				'street'		=>	$street,
				'city'			=>	$city,
				'state'			=>	$state,
				'zipcode'		=>	$zipcode,
				'country'		=>	$country,
				'address_type'	=>  'Primary'
			);
			$edit = UserAddressInfo::insert($editArr);
		}
		Session::flash('success','Record Updated Successfully!');
		return redirect('user/section#address_book');
	}
	
	public function account_info(Request $request){
		$name = $request->get('name');
		$email = $request->get('email');
		$user_id = Auth::user()->id;
		$editArr = array(
			'name' => $name,
			'email' => $email
		);
		User::where('id',$user_id)->update($editArr);
		Session::flash('success','Account Info Updated Successfully!');
		return redirect('user/section#account_info');
	}
	
	public function pdfview($project_id=null){
		$user_id = Auth::user()->id;
		$project = Project::with('Size')->where('id',$project_id)->first();
		$calendar_size = $project['Size']['Size'];
		$calendar_category_id = $project['calendar_category_id'];
		$identifierClass = str_replace(' ','',$project['flag']).'_'.$calendar_size;
		
		if($project['flag']=='Photobook'){
			$thisUR = DB::table('user_saved_projects')->whereRaw("user_id = '". Auth::user()->id ."' AND project_id = '".$project_id."'")->get();
			$cntR = count($thisUR);
			$savedProj = DB::table('user_saved_projects')->whereRaw("user_id = '". Auth::user()->id ."' AND project_id = '".$project_id."'")->skip(2)->take($cntR-4)->get();
		}else{
			$savedProj = DB::table('user_saved_projects')->whereRaw("user_id = '". Auth::user()->id ."' AND project_id = '".$project_id."'")->get();
		}
		$order = DB::table('orders')->whereRaw("project_id = '".$project_id."' AND user_id = '".$user_id."'")->first();
		$order_id = $order->id;
		
        $help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		
		/** cart items **/
		$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
		$item_count = count($cartItems);
		/** end cart items **/
		
		$proj = DB::table('projects')->where('id',$project_id)->first();
		return view('user.pdfview',compact('savedProj','help_group_pages','resource_group_pages','corporate_group_pages','project_id','calendar_size','calendar_category_id','order_id','item_count','identifierClass')); 
	}
	
	public function uploadFile(Request $request){
		$post_data = $request->all(); 
		/* echo '<pre>';
		print_r($post_data);exit; */
		$user_id = Auth::user()->id;
		$page_id = $post_data['page_id'];
		$filename = $page_id.'.png';
		$project_id = $post_data['project_id'];
		$order_id = $post_data['order_id'];
		
		$exist = DB::table('ordered_pdf_images')->whereRaw("user_id='".$user_id."' AND project_id='".$project_id."' AND page_id='".$page_id."'")->get();
		
		$destinationPath = public_path('canvas_upload').'/'.$user_id;
		if(!file_exists($destinationPath)){
			mkdir($destinationPath, 0777);
		}
		if(count($exist)>0){
			foreach($exist as $k => $value){
				if(file_exists(str_replace('\\','/',$destinationPath).'/'.$value->image_name)){
					unlink(str_replace('\\','/',$destinationPath).'/'.$value->image_name);
				}
			} 
			DB::table('ordered_pdf_images')->whereRaw("user_id='".$user_id."' AND project_id='".$project_id."' AND page_id='".$page_id."'")->delete();
		}
		
		$post_data['files']->move($destinationPath, $filename);
		$insArray = array(
			'user_id' 	=> $user_id,
			'order_id'	=> $order_id,
			'project_id'=> $project_id,
			'page_id'	=> $page_id,
			'image_name'=> $filename
		);
		DB::table('ordered_pdf_images')->insert($insArray);
		return 'public/canvas_upload/'.$user_id.'/'.$filename;
	}
	
	public function download_pdf($project_id=null,$order_id=null){
		ini_set('max_execution_time', 300);
		$error_level = error_reporting();
		error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
		$order_pdf = DB::table('ordered_pdf_images')->whereRaw("project_id = '".$project_id."' AND order_id = '".$order_id."' AND delete_flag = 0")->orderBy('page_id','ASC')->get();
		$user_id = Auth::user()->id;
				
		$pdf = PDF::loadView('user.download_pdf' ,compact('order_pdf','user_id'));
		$pdf->setPaper('a4', 'portrait');
		//$pdf->setPaper(array(0,0,1000,1000));
		return $pdf->stream('pdf_'.$project_id.'_'.$order_id.'_'.time().'.pdf')->header('Content-Type','application/pdf');  
	}
	
	public function del_album($id=null){
		$delArr = array(
			'deleted_At'=>date('Y-m-d H:i:s')
		);
		DB::table('albums')->where('id',$id)->update($delArr);
		DB::table('user_uploads')->where('album_id',$id)->update($delArr);
		//return 'ok';
		return redirect()->back()->withErrors(['error'=>'Album deleted successfully']);
	}
	
	public function del_photo($id=null){
		$delArr = array(
			'deleted_At'=>date('Y-m-d H:i:s')
		);
		DB::table('user_uploads')->where('id',$id)->update($delArr);
		return redirect()->back()->with(['success_msg'=>'Photo deleted successfully']);
	}
	
	public function feedback(){
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		$star_rating = array(
			'one' => 1,
			'two' => 2,
			'three' => 3,
			'four' => 4,
			'five' => 5
		);
		/** cart items **/
		$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
		$item_count = count($cartItems);
		/** end cart items **/
		return view('user.feedback',compact('help_group_pages','resource_group_pages','corporate_group_pages','star_rating','item_count'));
	}
	
	public function feedback_post(Request $request){
		$post_data = $request->all();
		$name = $post_data['name'];
		$country = $post_data['country'];
		$star_rating = $post_data['star_rating'];
		$msg = $post_data['msg'];
		$insArray = array(
			'name' => $name,
			'country' => $country,
			'star_rating' => $star_rating,
			'msg' => $msg
		);
		$insert = DB::table('user_feedbacks')->insert($insArray);
		if($insert){
			return redirect()->back()->with(['success'=>'Your feedback submitted.']);
		}else{
			return redirect()->withErrors(['error'=>'Something went wrong. Please try again...']);
		}
	}
	
	
	/****** instagram actions ******/
	public function instagram_authentication(){
		$auth_url = "https://api.instagram.com/oauth/authorize/?" .
			"client_id=" . env('INSTA_CLIENT_ID') .
			"&redirect_uri=" . env('INSTA_REDIRECT_URI') .
			"&response_type=code";
		header("Refresh:0; url=$auth_url");
		exit();
	}
	
	public function instagram_photo(Request $request){
		$code = $request->get('code');
		if(isset($code) && !empty($code)){
			$post = array("client_id" => env('INSTA_CLIENT_ID'), "client_secret" => env('INSTA_CLIENT_SECRET'), "grant_type" => "authorization_code", "redirect_uri" => env('INSTA_REDIRECT_URI'), "code" => $code);
			$url = "https://api.instagram.com/oauth/access_token";
			$c = curl_init();
			curl_setopt($c, CURLOPT_URL, $url);
			//curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
			//curl_setopt($c, CURLOPT_CUSTOMREQUEST, $method);
			curl_setopt($c, CURLOPT_POST, true);
			curl_setopt($c, CURLOPT_POSTFIELDS, $post);
			curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($c, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 2);
			$result = curl_exec($c);
			$error = curl_error($c);
			$errno = curl_errno($c);
			curl_close($c);
			$response = json_decode($result);
			$stdClassData = $this->cvf_convert_object_to_array($response);
			if(isset($stdClassData['code']) && $stdClassData['code'] != 200){
				if(Session::get('flag_poster_url')){
					return redirect(Session::get('flag_poster_url'))->with(['social_error'=>'Token mismatch.']);
				}elseif(Session::get('flag_calendar_url')){
					return redirect(Session::get('flag_calendar_url'))->with(['social_error'=>'Token mismatch.']);
				}elseif(Session::get('flag_photobook_simple_url')){
					return redirect(Session::get('flag_photobook_simple_url'))->with(['social_error'=>'Token mismatch.']);
				}elseif(Session::get('flag_photobook_custom_url')){
					return redirect(Session::get('flag_photobook_custom_url'))->with(['social_error'=>'Token mismatch.']);
				}else{
					return redirect('/user/my_photos')->withErrors(['error'=>'Token mismatch.']);
				}
			}
			$access_token = $stdClassData['access_token'];
			$user_id = $stdClassData['user']['id'];
			
			$url = "https://api.instagram.com/v1/users/$user_id/media/recent/";
			$url = $url . "?access_token=" . $access_token;
			$url = $url . "&count=50";
	
			$c = curl_init();
			curl_setopt($c, CURLOPT_URL, $url);
			//curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($c, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 2);
			$result = curl_exec($c);
			$error = curl_error($c);
			$errno = curl_errno($c);
			curl_close($c);
	
			$response = json_decode($result);
			$stdClassData = $this->cvf_convert_object_to_array($response);
			
			if(isset($stdClassData['code']) && $stdClassData['code'] != 200){
				if(Session::get('flag_poster_url')){
					return redirect(Session::get('flag_poster_url'))->with(['social_error'=>'Instagram Authentication Error.']);
				}elseif(Session::get('flag_calendar_url')){
					return redirect(Session::get('flag_calendar_url'))->with(['social_error'=>'Instagram Authentication Error.']);
				}elseif(Session::get('flag_photobook_simple_url')){
					return redirect(Session::get('flag_photobook_simple_url'))->with(['social_error'=>'Instagram Authentication Error.']);
				}elseif(Session::get('flag_photobook_custom_url')){
					return redirect(Session::get('flag_photobook_custom_url'))->with(['social_error'=>'Instagram Authentication Error.']);
				}else{
					return redirect('/user/my_photos')->withErrors(['error'=>'Instagram Authentication Error.']);
				}
			}
			
			$help_group_pages = $this->help_group_pages;
			$resource_group_pages = $this->resource_group_pages;
			$corporate_group_pages = $this->corporate_group_pages;
			/** cart items **/
			$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
			$item_count = count($cartItems);
			/** end cart items **/
			$album = Album::where('user_id',Auth::user()->id)->where('deleted_at','=','0000-00-00 00:00:00')->pluck('album_name','id');
			
			if(Session::get('flag_poster_url')){
				return redirect(Session::get('flag_poster_url'))->with(['stdClassData'=>$stdClassData,'album'=>$album]);
			}elseif(Session::get('flag_calendar_url')){
				return redirect(Session::get('flag_calendar_url'))->with(['stdClassData'=>$stdClassData,'album'=>$album]);
			}elseif(Session::get('flag_photobook_simple_url')){
				return redirect(Session::get('flag_photobook_simple_url'))->with(['stdClassData'=>$stdClassData,'album'=>$album]);
			}elseif(Session::get('flag_photobook_custom_url')){
				return redirect(Session::get('flag_photobook_custom_url'))->with(['stdClassData'=>$stdClassData,'album'=>$album]);
			}else{
				return view('user/instagram_photos',compact('stdClassData','help_group_pages','resource_group_pages','corporate_group_pages','item_count','album'));
			}
		}else{
			return redirect('/user/instagram');
		}
	}
	
	public function add_insta_photo(Request $request){
		$post_data = $request->all();
		echo '<pre>';
		print_r($post_data);exit;
		foreach($post_data['insta_photo'] as $k => $image){
			$data = file_get_contents($k);
			$fArr = explode('/',$k);
			$filename = end($fArr);
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			//$new = '/home/printedcart/public_html/insta_uploads/'.$filename;
			$user_id = Auth::user()->id;
			$destinationPath = public_path('users_upload').'/'.$user_id;
			if(!file_exists($destinationPath)){
				mkdir($destinationPath, 0777);
			}
			$new = $destinationPath.'/'.$filename;
			if(!file_exists($new)){
				file_put_contents($new, $data);
			}
			
			DB::table('user_uploads')->insert(array(
				'name' => $filename,
				'path' => 'users_upload'.'/'.$user_id,
				'extension' => $ext,
				'user_id' => Auth::user()->id,
				'album_id' => $post_data['album_id']
			));
		}
		if(Session::get('flag_poster_url')){
			return redirect(Session::get('flag_poster_url'));
		}elseif(Session::get('flag_calendar_url')){
			return redirect(Session::get('flag_calendar_url'));
		}elseif(Session::get('flag_photobook_simple_url')){
			return redirect(Session::get('flag_photobook_simple_url'));
		}elseif(Session::get('flag_photobook_custom_url')){
			return redirect(Session::get('flag_photobook_custom_url'));
		}else{
			return Redirect::to('user/my_photos/album/'.$post_data['album_id']);
		}
	}
	/*** end instagram action ***/
	
	/*** google action ***/
	/* google login */
	public function googleLogin(Request $request) {
		//$google_redirect_url = route('user/glogin');
		$google_redirect_url = 'https://printedcart.com/printedcart/user/glogin';
		$gClient = new \Google_Client();
		
		$gClient->setApplicationName(config('services.google.app_name'));
		$gClient->setClientId(config('services.google.client_id'));
		$gClient->setClientSecret(config('services.google.client_secret'));
		$gClient->setRedirectUri($google_redirect_url);
		$gClient->setDeveloperKey(config('services.google.api_key'));
		$gClient->setScopes(array(
			'https://www.googleapis.com/auth/userinfo.email',
			'https://www.googleapis.com/auth/plus.me',
			'https://www.googleapis.com/auth/plus.business.manage',
			'https://www.googleapis.com/auth/userinfo.email',
			'https://www.googleapis.com/auth/userinfo.profile',
			'https://www.googleapis.com/auth/photoslibrary',
			'https://www.googleapis.com/auth/drive',
		));
		
		$google_oauthV2 = new \Google_Service_Oauth2($gClient);
		
		if ($request->get('code')){
			$gClient->authenticate($request->get('code'));
			$request->session()->put('token', $gClient->getAccessToken());
		}
		if ($request->session()->get('token'))
		{
			$gClient->setAccessToken($request->session()->get('token'));
		}
		
		if ($gClient->getAccessToken())	{
			$accessTo = $gClient->getAccessToken(); 
			$accessToken = $accessTo['access_token'];
			
			/* photo */
			$google_photos = new \Google_Service_PhotosLibrary($gClient);
			$google_drive = new \Google_Service_Drive($gClient);
			
			$albums = $google_photos->albums->listAlbums();
			
			
			
			if(count($albums)>0){
				foreach($albums->albums as $k => $album){
					$list_album['Album'][$k]['id'] = $album->id;
					$list_album['Album'][$k]['coverPhotoBaseUrl'] = $album->coverPhotoBaseUrl;
					$list_album['Album'][$k]['productUrl'] = $album->productUrl;
					$list_album['Album'][$k]['album_name'] = $album->title;
					$list_album['Album'][$k]['totalMediaItems'] = $album->totalMediaItems;
					$list_album['Album'][$k]['mediaItemId'] = $album->coverPhotoMediaItemId;
					
					/* media items */
					$media_items = $google_photos->mediaItems->get($album->coverPhotoMediaItemId);
					$list_album['Album'][$k]['media_items']['id'] = $media_items->id;
					$list_album['Album'][$k]['media_items']['baseUrl'] = $media_items->baseUrl;
					$list_album['Album'][$k]['media_items']['mimeType'] = $media_items->mimeType;
					$list_album['Album'][$k]['media_items']['productUrl'] = $media_items->productUrl;
					$list_album['Album'][$k]['media_items']['filename'] = $media_items->filename;
					$list_album['Album'][$k]['media_items']['height'] = $media_items->height;
					$list_album['Album'][$k]['media_items']['width'] = $media_items->width;
					/* end media items */
				}
			}else{
				$list_album = array();
			}
			
			$help_group_pages = $this->help_group_pages;
			$resource_group_pages = $this->resource_group_pages;
			$corporate_group_pages = $this->corporate_group_pages;
			/** cart items **/
			$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
			$item_count = count($cartItems);
			/** end cart items **/
			$album = Album::where('user_id',Auth::user()->id)->where('deleted_at','=','0000-00-00 00:00:00')->pluck('album_name','id');
			
			if(Session::get('flag_poster_url')){
				return redirect(Session::get('flag_poster_url'))->with(['list_album'=>$list_album,'album'=>$album]);
			}elseif(Session::get('flag_calendar_url')){
				return redirect(Session::get('flag_calendar_url'))->with(['list_album'=>$list_album,'album'=>$album]);
			}elseif(Session::get('flag_photobook_simple_url')){
				return redirect(Session::get('flag_photobook_simple_url'))->with(['list_album'=>$list_album,'album'=>$album]);
			}elseif(Session::get('flag_photobook_custom_url')){
				return redirect(Session::get('flag_photobook_custom_url'))->with(['list_album'=>$list_album,'album'=>$album]);
			}else{
				return view('user/google_photos',compact('help_group_pages','resource_group_pages','corporate_group_pages','item_count','album','list_album'));
			}
			/* end album*/
			/* end photo */
			
		} else {
			//For Guest user, get google login url
			$authUrl = $gClient->createAuthUrl();
			return redirect()->to($authUrl);
		}
	}
	
	public function add_google_photo(Request $request){
		$post_data = $request->all();
		foreach($post_data['google_photo'] as $k => $image){
			$data = file_get_contents($k);
			$filename = rand().'.jpg';
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$user_id = Auth::user()->id;
			$destinationPath = public_path('users_upload').'/'.$user_id;
			if(!file_exists($destinationPath)){
				mkdir($destinationPath, 0777);
			}
			$new = $destinationPath.'/'.$filename;
			if(!file_exists($new)){
				file_put_contents($new, $data);
			}
			
			DB::table('user_uploads')->insert(array(
				'name' => $filename,
				'path' => 'users_upload'.'/'.$user_id,
				'extension' => $ext,
				'user_id' => Auth::user()->id,
				'album_id' => $post_data['album_id']
			));
		}
		if(Session::get('flag_poster_url')){
			return redirect(Session::get('flag_poster_url'));
		}elseif(Session::get('flag_calendar_url')){
			return redirect(Session::get('flag_calendar_url'));
		}elseif(Session::get('flag_photobook_simple_url')){
			return redirect(Session::get('flag_photobook_simple_url'));
		}elseif(Session::get('flag_photobook_custom_url')){
			return redirect(Session::get('flag_photobook_custom_url'));
		}else{
			return Redirect::to('user/my_photos/album/'.$post_data['album_id']);
		}
	}
	/*** end google action ***/
	
	/*** facebook action ***/
	public function facebookLogin(Request $request){               
        FacebookSession::setDefaultApplication(config('services.facebook.APP_ID'),config('services.facebook.APP_SECRET'));
        $redirect_url = route('user.fblogin');
        $helper = new FacebookRedirectLoginHelper($redirect_url);
		
        $fbloginurl = $helper->getLoginUrl(array('scope' => 'email' ));
        $state = md5(rand());
        $request->session()->set('g_state', $state);
		return redirect()->to($fbloginurl);
    }
    public function fbSignUp(Request $request){
		FacebookSession::setDefaultApplication(config('services.facebook.APP_ID'),config('services.facebook.APP_SECRET'));        
        $redirect_url = route('user.fblogin');
		
        $helper = new FacebookRedirectLoginHelper(
            $redirect_url,
            config('services.facebook.APP_ID'),
            config('services.facebook.APP_SECRET')
        );
		
		try{
            $session = $helper->getSessionFromRedirect();       
        } catch (FacebookRequestException $ex){
            $response['error'][] = $ex->getMessage();           
        } catch (\Exception $ex){
            $response['error'][] = $ex->getMessage();
        }
		
		if(isset($session) && $session){ 
			$me = (new FacebookRequest(
				$session, 'GET', '/me'
			))->execute()->getGraphObject(GraphUser::className());
			$response['success']['fb_name'] = $me->getName();
			$response['success']['fb_id'] = $me->getId();
			//https://graph.facebook.com/1518286994983404/photos?fields=height,width,link
			
			try{
				$user_permissions = (new FacebookRequest($session, 'GET', '/me/permissions'))->execute()->getGraphObject(GraphUser::className())->asArray();
				
				$response = (new FacebookRequest( $session, 'GET', '/1518286994983404/photos?fields=height,width,link'))->execute()->getGraphObject();
				
				$response['success']['photos'] = $response;
				
			}catch(FacebookRequestException $e){
				$response['error'][] = 'Facebook (post) request error: '.$e->getMessage();
			}
		}
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		/** cart items **/
		$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
		$item_count = count($cartItems);
		/** end cart items **/
		$album = Album::where('user_id',Auth::user()->id)->where('deleted_at','=','0000-00-00 00:00:00')->pluck('album_name','id');
		
		if(Session::get('flag_poster_url')){
			return redirect(Session::get('flag_poster_url'))->with(['response'=>$response,'album'=>$album]);
		}elseif(Session::get('flag_calendar_url')){
			return redirect(Session::get('flag_calendar_url'))->with(['response'=>$response,'album'=>$album]);
		}elseif(Session::get('flag_photobook_simple_url')){
			return redirect(Session::get('flag_photobook_simple_url'))->with(['response'=>$response,'album'=>$album]);
		}elseif(Session::get('flag_photobook_custom_url')){
			return redirect(Session::get('flag_photobook_custom_url'))->with(['response'=>$response,'album'=>$album]);
		}else{
			return view('user/fb_photos',compact('help_group_pages','resource_group_pages','corporate_group_pages','item_count','album','response'));
		}
    }
	/*** end facebook action ***/
	
	public function cvf_convert_object_to_array($data) {
		if(is_object($data)){
			$data = get_object_vars($data);
		}
		if(is_array($data)){
			return array_map(array($this,'cvf_convert_object_to_array'), $data);
		}
		else{
			return $data;
		}
	}
	
}