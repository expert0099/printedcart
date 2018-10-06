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
use App\SizeGroup;
use App\Currency;
use App\Models\SizeType;
use App\CollegePoserStyle;
use DB;
use Auth,Session;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class PrintController extends Controller
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
		
		return view('print.index',compact('default_currency','cal_cat','help_group_pages','resource_group_pages','corporate_group_pages','item_count'));
    }
	
	public function large_format_print(){
		/**** default currency ****/
		$default_currency = Currency::where('isDefault',1)->first();
		
		/*** site types ***/
		$sizeTypes = SizeType::pluck('sizetype','id');
		
		/**** get large format print size ***/
		$size_group = SizeGroup::where('sizegroup','Large Format Print')->first();
		$sizes = Size::where('sizegroup',$size_group['id'])->get();
		
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		
		/** cart items **/
		if(Auth::check()){
			$cartItems = DB::table('custom_carts')->whereRaw("user_id='". Auth::user()->id ."'")->get();
			$item_count = count($cartItems);
		}else{
			$item_count = 0;
			return redirect('user/login');
		}
		/** end cart items **/
		
		return view('print.large_format_print',compact('default_currency','sizeTypes','sizes','help_group_pages','resource_group_pages','corporate_group_pages','item_count'));
	}
	
	public function add_photo(Request $request){
		$user_id = Auth::user()->id; 
		$choozed_default_size = $request->get('default_size');
		$default_size = array();
		foreach($choozed_default_size as $k => $v){
			$default_size[] = $k;
		}
		
		$choose_default_size_type = $request->get('default_size_type');
		$allowed_image_extension = array("png","jpg","jpeg","gif");
		$img_upl_cnt = 0;
		$showfilename = array();
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
						'album_id' => 0
					));
					$showfilename[] = $filename;
					$showfilepath = 'users_upload'.'/'.$user_id;
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
			}
			/*** site types ***/
			$sizeTypes = SizeType::pluck('sizetype','id');
			
			/**** get large format print size ***/
			$size_group = SizeGroup::where('sizegroup','Large Format Print')->first();
			$sizes = Size::where('sizegroup',$size_group['id'])->get();
		}
		return view('print.ajax_photo_section',compact('response','sizeTypes','sizes','showfilename','showfilepath', 'choozed_default_size', 'choose_default_size_type', 'default_size'));
	}
	
	public function alter_image(Request $request){
		$rel = $request->get('rel');
		$p = $request->get('p');
		$path = $request->get('path');
		$sizeType = $request->get('sizeType');
		return view('print.ajax_alter_image',compact('rel','p','path','sizeType'));
	}
	
	public function print_form_submit(Request $request){
		$post_data = $request->all();
		$sizegroup = DB::table('sizegroups')->where('sizegroup','=','Large Format Print')->first();
		$size_group_id = $sizegroup->id;
		$form_data = array();
		$i = 0;
		foreach($post_data['image_path'] as $k => $value){
			foreach($post_data['size_qty'][$k] as $l => $val){
				$price = DB::table('sizes')->where('id',$post_data['size_id'][$k][$l])->first();
				if($val == 1){
					$form_data[$i]['user_id'] = Auth::user()->id;
					$form_data[$i]['image_path'] = $value;
					$form_data[$i]['size_id'] = $post_data['size_id'][$k][$l];
					$form_data[$i]['size'] = $l .' Print ('. $post_data['txtsizetype'][$k][$l] .')';
					$form_data[$i]['qty'] = $val;
					$form_data[$i]['price'] = $val*$price->price;
					$form_data[$i]['size_type'] = $post_data['txtsizetype'][$k][$l];
					$form_data[$i]['print_set'] = $k;
					$form_data[$i]['border_color'] = $post_data['border_color'][$k];
					$form_data[$i]['border'] = $post_data['border'][$k];
					$form_data[$i]['print_message'] = $post_data['print_message'][$k];
					$form_data[$i]['session_id'] = $post_data['_token'];
					$i++;
				}
			}
		}
		$insert = DB::table('custom_carts')->insert($form_data);
		return redirect('custom_cart');
	}
	
	public function college_poster(){
		Session::forget('CurrentProjectData');
				
		/**** get large format print size ***/
		$size_group = SizeGroup::where('sizegroup','College Poster')->first();
		$sizes = Size::where('sizegroup',$size_group['id'])->get();
		
		/** end default size for college poster **/
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		
		/** cart items **/
		if(Auth::check()){
			$cartItems = DB::table('custom_carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
			$item_count = count($cartItems);
		}else{
			$item_count = 0;
		}
		/** end cart items **/
		
		return view('print.college_poster',compact('sizes','help_group_pages','resource_group_pages','corporate_group_pages','item_count'));
	}
	public function get_college_poster(Request $request){
		$whereRaw = '';
		if($request->get('design_size')){
			$design_size = explode(',',$request->get('design_size'));
			foreach($design_size as $k => $v){
				if(!empty($whereRaw)){
					$whereRaw .= " OR design_size LIKE '%".$v."%'";
				}else{
					$whereRaw .= "design_size LIKE '%".$v."%'";
				}
			}
		}else{
			$whereRaw = '';
		}
		if($request->get('of_photos')){
			$of_photos = explode(',',$request->get('of_photos'));
			$photo = $sep = '';
			foreach($of_photos as $k => $v){
				$photo = $photo . $sep . "'" . $v . "'";
				$sep = ',';
			}
			if(!empty($whereRaw)){
				$whereRaw .= " OR of_photos IN(".$photo.")";
			}else{
				$whereRaw .= "of_photos IN(".$photo.")";
			}
		}else{
			$whereRaw .= '';
		}
		if($request->get('design_style')){
			$design_style = explode(',',$request->get('design_style'));
			foreach($design_style as $k => $v){
				if(!empty($whereRaw)){
					$whereRaw .= " OR design_style LIKE '%".$v."%'";
				}else{
					$whereRaw .= "design_style LIKE '%".$v."%'";
				}
			}
		}else{
			$whereRaw .= '';
		}
		if($request->get('designer')){
			$designer = explode(',',$request->get('designer'));
			foreach($designer as $k => $v){
				if(!empty($whereRaw)){
					$whereRaw .= " OR ".$v." = 1";
				}else{
					$whereRaw .= "".$v." = 1";
				}
			}
		}else{
			$whereRaw .= '';
		}
		if(empty($whereRaw)){
			$whereRaw = "disney = 0 AND printedcart = 0";
		}
		
		/* $coll_pos_cal = CalendarStyle::whereHas(
			'CalendarCategory', function ($query) {
				$query->where('calendar_category', 'like', '%Calendar Posters%');
			}
		)->whereRaw($whereRaw)->paginate(8); */
		$coll_pos_cal = CollegePoserStyle::whereRaw($whereRaw)->paginate(8);
		
		foreach($coll_pos_cal as $k => $value){
			/** for image **/
			$upload = DB::table('uploads')->select('path','hash')->where('id',$value['photo'])->first();
			$upDataArr = explode("uploads",$upload->path);
			$img = 'storage/uploads'.$upDataArr[1];
			$coll_pos_cal[$k]['photo'] = $img;
			/** for image end **/
			$size_group = SizeGroup::where('sizegroup','like','%College Poster%')->first();
			$size = Size::whereRaw("Size = '".$value['design_size']."' AND sizegroup = '".$size_group['id']."'")->first();
			$coll_pos_cal[$k]['college_poster_size_id'] = $size['id'];
		}
		return view('print.ajax_college_poster',compact('coll_pos_cal'));exit;
	}
	
	public function colposview($poster_id=null){
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		
		$college_poster = SizeGroup::where('sizegroup','=','College Poster')->first();
		$calendar_image = $college_poster['photo'];
		$upload = DB::table('uploads')->select('path','hash')->where('id',$calendar_image)->first();
		$upDataArr = explode("uploads",$upload->path);
		$college_poster['college_poster_img'] = 'storage/uploads'.$upDataArr[1];
		
		$college_poster_sizes = Size::where('sizegroup',$college_poster['id'])->get();
		
		$default_currency = Currency::select('id','currencyname','currencysymbol','currencycode','convertratio')->where('isDefault',1)->first();
		
		/** cart items **/
		$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
		$item_count = count($cartItems);
		/** end cart items **/
		
		return view('print.colpos_view',compact('help_group_pages','resource_group_pages','corporate_group_pages','poster_id','college_poster','college_poster_sizes','default_currency','item_count'));
	}
}