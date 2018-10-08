<?php
/**
 * Controller genrated using 
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Size;
use App\Project;
use App\SizeGroup;
use App\Currency;
use App\Promocode;
use App\Coupon;
use App\CalendarStyleType;
use App\CalendarStyle;
use DB,Auth;
use App\CalendarDefaultSize;
use App\CalendarCategory;
use Session;
use App\CalendarLayout;
use App\CalendarBackground;
use PDF;
use HTML2PDF;
//use Dompdf\Dompdf;;
//use Mpdf;


/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class CalendarsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
		/* $this->middleware('auth'); */
        $this->help_group_pages = $this->help_group_pages();
		$this->resource_group_pages = $this->resource_group_pages();
		$this->corporate_group_pages = $this->corporate_group_pages();
    }
	
    /**
     * Show the application dashboard.
     *
     * @return Response
     */
	 
	/* public function cal_months(){
		return $cal_months = array('1'=>'January','2'=>'February','3'=>'March','4'=>'April','5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December');
	} */
	
    public function index(){
		/**** get size group with size ****/
		Session::forget('CurrentProjectData');
		$cal_def_size = CalendarDefaultSize::with(['Size', 'CalendarCategory' => function($query){
			$query->where('calendar_category', 'Wall Calendars');
		}])->orderBy('size_id','ASC')->get();
		/**** end size group with size ****/
		
		/**** calendar for every space section ****/
		$cal_cat = CalendarCategory::with('CalendarDefaultSize')->skip(1)->take(4)->get();
		foreach($cal_cat as $k => $v){
			$upload = DB::table('uploads')->select('path','hash')->where('id',$v['calendar_image'])->first();
			$upDataArr = explode("uploads",$upload->path);
			$img = 'storage/uploads'.$upDataArr[1];
			$v['calendar_image_path'] = $img;
			$v['Size'] = Size::where('id',$v['CalendarDefaultSize']['size_id'])->first();
		}
		/**** end calendar for every space section ****/
		
		/**** default currency ****/
		$default_currency = Currency::where('isDefault',1)->first();
		/**** end default currency ****/
		
		/**** get promocode ****/
		$promocode = Promocode::with('Coupon')->whereRaw("end_date >= '".date('Y-m-d H:i:s')."' AND coupon_flag = 'Saving'")->orderBy('id','DESC')->first();
		/**** end promocode ****/
		
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
		return view('calendar.index',compact('cal_def_size','promocode','default_currency','cal_cat','help_group_pages','resource_group_pages','corporate_group_pages','item_count'));
	}
	public function wall_calendar(Request $request){
		/*** form post data ***/
		$calendar_size = $request->get('calendar_size');
		$calendar_month = $request->get('calendar_month');
		$calendar_year = $request->get('calendar_year');
		/*** end form post data ***/
		
		/*** calendar styles ***/
		$count = CalendarStyleType::count();
		$calendar_styles = CalendarStyleType::where('isActive',1)->orderBy('id','ASC')->skip(1)->take($count-1)->get();
		/*** end calendar styles ***/
		
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		
		$size = Size::where('id',$calendar_size)->first();
		$calendar_size = $size->Size;
		$calendar_size_id = $size->id;
		
		/** cart items **/
		if(Auth::check()){
			$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
			$item_count = count($cartItems);
		}else{
			$item_count = 0;
		}
		/** end cart items **/
		
		return view('calendar.wall_calendar',compact('calendar_size','calendar_size_id','calendar_month','calendar_year','calendar_styles','help_group_pages','resource_group_pages','corporate_group_pages','item_count'));
	}
	public function get_calendar_styles($style_id=null,$calendar_size_id=null,$month=null,$year=null){
		if(is_numeric($style_id)){
			if($style_id==0){
				$cal_styles = CalendarStyle::where('isActive',1)->where('calendar_style','!=','None')->orderBy('id','ASC')->paginate(8);
			}else{
				$cal_styles = CalendarStyle::where('calendar_style_type_id',$style_id)->where('isActive',1)->orderBy('id','ASC')->paginate(8);
			}
		}else{
			if($style_id=='All'){
				$cal_styles = CalendarStyle::where('isActive',1)->where('calendar_style','!=','None')->orderBy('id','ASC')->paginate(8);
			}elseif($style_id=='Standard'){
				$cal_styles = CalendarStyle::where('isActive',1)->where('calendar_style','!=','None')->where('standard',1)->orderBy('id','ASC')->paginate(8);
			}else{
				$cal_styles = CalendarStyle::where('isActive',1)->where('calendar_style','!=','None')->where('storytelling',1)->orderBy('id','ASC')->paginate(8);
			}
		}
		
		foreach($cal_styles as $k => $value){
			/** for image **/
			$upload = DB::table('uploads')->select('path','hash')->where('id',$value['photo'])->first();
			$upDataArr = explode("uploads",$upload->path);
			$img = 'storage/uploads'.$upDataArr[1];
			$cal_styles[$k]['photo'] = $img;
			/** for image end **/
		}
		return view('calendar.ajax_wall_calendar',compact('cal_styles','calendar_size_id','month','year')); exit;
	}
	
	/******* wall calendar activities *******/
	public function cal_editor($calendar_id = null, $calendar_size_id = null, $calendar_category_id=null,$month=null,$year=null){
		if(Auth::check()){
			$user_id = Auth::user()->id;
			/** check project data **/
			$ep = DB::table('projects')->whereRaw("user_id = '".$user_id."' AND size_id = '".$calendar_size_id."' AND calendar_style_id = '".$calendar_id."' AND calendar_category_id = '".$calendar_category_id."' AND flag = 'Calendar'")->orderBy('id','DESC')->first();
			
			if(!empty($ep->id)){
				$project_id = $ep->id;
				$savedProj = DB::table('user_saved_projects')->whereRaw("project_id='".$project_id."' AND user_id='".$user_id."' AND deleted_at = '0000-00-00 00:00:00'")->get();
			}else{
				$project_id = '';
				$savedProj = '';
			}
			/** end check project data **/
			
			/* Album Lists*/
			$albums = DB::table("albums")->where("user_id",$user_id)->where('deleted_at','=','0000-00-00 00:00:00')->get();
			$album_list = DB::table("albums")->where('user_id',$user_id)->where('deleted_at','=','0000-00-00 00:00:00')->pluck('album_name','id');
			/*album photos*/
			$photos = array();
			foreach($albums as $album){
				$albums_ps = DB::table("user_uploads")->where("album_id",$album->id)->where('deleted_at','=','0000-00-00 00:00:00')->get();
				$photos[$album->id] = $albums_ps;
			}
			/** custom calendar layout **/
			$layout = CalendarLayout::whereRaw("calendar_category_id = '".$calendar_category_id."' AND isActive = 1")->get();
			
			if(count($layout)==0){
				$layout = CalendarLayout::whereRaw("calendar_category_id = 0 AND isActive = 1")->get();
			}
			foreach($layout as $k => $value){
				$upload = DB::table('uploads')->select('path')->where('id',$value['layout_image'])->first();
				$upDataArr = explode("uploads",$upload->path);
				$img = $upDataArr[1];
				$value['layout_image_path'] = 'storage/uploads'.$img;
			}
			/** end calendar layout **/
			
			/** background images **/
			$pbg = CalendarBackground::whereRaw("calendar_category_id = '".$calendar_category_id."' AND calendar_style_id = '".$calendar_id."' AND isActive = 1")->first();
			
			if(count($pbg)==0){
				$pbg = CalendarBackground::whereRaw("calendar_category_id = '".$calendar_category_id."' AND isActive = 1")->first();
			}
			$background_ids = str_replace('[','',str_replace(']','',$pbg['background_image']));
			if(empty($background_ids)){
				return redirect()->back()->withErrors(['error'=>'Calendar Background Missing.']);
			}
			$upload_b = DB::table('uploads')->select('path')->whereRaw("id IN(".$background_ids.")")->get();
			foreach($upload_b as $k => $value){
				$upDataArr = explode("uploads",$value->path);
				$img = $upDataArr[1];
				$background_image[] = 'storage/uploads'.$img;
			}
			/** end background images **/
		
			/** default pages layout **/
			$demo_content = DB::table('calendardefaultpages')->whereRaw("calendar_category_id = '".$calendar_category_id."' AND isActive = 1")->get();
			
			if(count($demo_content)==0){
				$demo_content = DB::table('calendardefaultpages')->whereRaw("calendar_category_id = 0 AND isActive = 1")->get();
			}		
			/** end default pages layout **/
			
			/** calendar size **/
			$size = Size::where('id',$calendar_size_id)->first();
			$calendar_size = $size->Size;
			$price = $size->price;
			/** end calendar size **/
		
		
			/** cart items **/
			$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
			$item_count = count($cartItems);
			/** end cart items **/
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
			Session::put('flag_calendar_url',str_replace('/printedcart/','/',$_SERVER['REDIRECT_URL']));
			return view('calendar.cal_custom_editor',compact('albums','album_list','photos','layout','background_image','demo_content','calendar_size','item_count','project_id','calendar_id','calendar_size_id','price','month','year','calendar_category_id','savedProj'));
		}else{
			return redirect('user/login');
		}
	}
	/******* end wall calendar activities *******/
	
	public function save_project(Request $request){
		$user_id = Auth::user()->id;
		$explode = explode('&',$request->get('form_data'));
		$data = array();
		foreach($explode as $k => $value)
		{
			$value1 = explode('=', $value);
			$data[$value1[0]] = $value1[1];
		}
		$flag = $request->get('flag');
		if($flag == 'College Poster'){
			$month = 0;
			$year = '';
			$calendar_style_id = $data['poster_style_id'];
			$calendar_category_id = 0;
		}else{
			$month = $request->get('cmonth');
			$year = $request->get('cyear');
			$calendar_style_id = $data['calendar_style_id'];
			$calendar_category_id = $data['calendar_category_id'];
		}
		$insProArr = array(
			'user_id' => $user_id,
			'calendar_style_id' => $calendar_style_id,
			'calendar_category_id' => $calendar_category_id,
			'project_name' => $data['project_name'],
			'size_id' => $data['size_id'],
			'price' => $data['price'],
			'flag' => $flag,
			'cmonth' => $month,
			'cyear' => $year
		);
		$project_id = DB::table('projects')->insertGetId($insProArr);
		if(is_numeric($project_id)){
			return $project_id;
		}else{
			return 'error';
		}
	}
	public function save_calendar(Request $request){
		$user_id = Auth::user()->id;
		$project_id = $request->get('project_id');
		$page_contents = $request->get('page_content');
				
		$exist = DB::table('user_saved_projects')->whereRaw("user_id = '".$user_id."' AND project_id = '".$project_id."' AND deleted_at = '0000-00-00 00:00:00'")->get();
		
		if(count($exist)>0){
			DB::table('user_saved_projects')->whereRaw("user_id = '".$user_id."' AND project_id = '".$project_id."'")->delete();
		}
		foreach($page_contents as $page_content){
			$insArr[] = array(
				'user_id' => $user_id,
				'page_content' => $page_content,
				'project_id' => $project_id,
				'_token' => $request->get('_token')
			);
		}
		DB::table('user_saved_projects')->insert($insArr);
		//return 'saved';exit;
		/** current saved project records **/
		$thisUR = DB::table('user_saved_projects')->whereRaw("user_id = '". Auth::user()->id ."' AND project_id = '".$project_id."'")->get();
		$savedProj = DB::table('user_saved_projects')->whereRaw("user_id = '". Auth::user()->id ."' AND project_id = '".$project_id."'")->orderBy('id','DESC')->get();
		Session::put('CurrentProjectData',$savedProj); 
		/** end current saved project records **/
		return 'saved';exit;
	}
	
	function get_calendar_status($project_id=null){
		$thisUR = DB::table('user_saved_projects')->whereRaw("user_id = '". Auth::user()->id ."' AND project_id = '".$project_id."'")->get();
		$cntR = count($thisUR);
		if($cntR>0){
			return 'ok';exit;
		}else{
			return 'failed';exit;
		}
	}
	function add_to_cart(Request $request){
		$project_id = $request->get('project_id');
		$_token = $request->get('_token'); 
		$status = 0;
		$exist = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND project_id='".$project_id."' AND status = '".$status."'")->first();
		
		if(count($exist)>0){
			$data['status'] = 'already_added';
		}else{
			$insArr = array(
				'user_id' => Auth::user()->id,
				'project_id' => $request->get('project_id'),
				'session_id' => $request->get('_token'),
				'cart_type' => 'Calendar'
			);
			DB::table('carts')->insert($insArr);
			$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0' AND cart_type = 'Calendar'")->get();
			$data['item_count'] = count($cartItems);
			$data['status'] = 'added';
		}
		return $data;exit;
	}
	/* public function shipping_address_status(){
		$exist = DB::table('user_address_infos')->where('user_id',Auth::user()->id)->first();
		if(count($exist)>0){
			return 'exist';exit;
		}else{
			return 'not_exist';exit;
		}
	} */
	
	public function easel_calendars(){
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
		
		return view('calendar.easel_calendar',compact('easel_cal','help_group_pages','resource_group_pages','corporate_group_pages','item_count'));
	}
	public function get_easel_calendars(Request $request){
		if($request->get('art_library')){
			$art_library = $request->get('art_library');
			$whereRaw = "art_library = 1";
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
		if($request->get('corners')){
			$corners = explode(',',$request->get('corners'));
			foreach($corners as $k => $v){
				if(!empty($whereRaw)){
					$whereRaw .= " OR ".$v." = 1";
				}else{
					$whereRaw .= "".$v." = 1";
				}
			}
		}else{
			$whereRaw .= "";
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
			$whereRaw = "art_library = 0 AND of_photos = 0 AND reg_corner = 0 AND round_corner = 0 AND float_paperie = 0 AND paper_plains = 0 AND potts_design = 0 AND yours_truly = 0";
		}
		$easel_cal = CalendarStyle::whereHas(
			'CalendarCategory', function ($query){
				$query->where('calendar_category', 'like', '%Easel Calendars%');
			}
		)->whereRaw($whereRaw)->paginate(8);
		foreach($easel_cal as $k => $value){
			/** for image **/
			$upload = DB::table('uploads')->select('path','hash')->where('id',$value['photo'])->first();
			$upDataArr = explode("uploads",$upload->path);
			$img = 'storage/uploads'.$upDataArr[1];
			$easel_cal[$k]['photo'] = $img;
			/** for image end **/
		}
		
		$size = SizeGroup::with('Size')->where('sizegroup','=','Calendar')->first();
		$calendar_size_id = $size['Size'][0]['id'];
		//$calendar_size_id = 19;
		return view('calendar.ajax_easel_calendar',compact('easel_cal','calendar_size_id'));exit;
	}
	public function easel($calendar_style_id=null,$calendar_size_id=null,$calendar_category_id=null){
		if(Auth::check()){		
			$easel = CalendarStyle::with('CalendarCategory')->where('id',$calendar_style_id)->first();
			
			$upload = DB::table('uploads')->select('path','hash')->where('id',$easel['photo'])->first();
			$upDataArr = explode("uploads",$upload->path);
			$img = 'storage/uploads'.$upDataArr[1];
			$easel['img_path'] = $img;
			
			$calendarDefaultSize = CalendarDefaultSize::with('Size')->where('calendar_category_id',$easel['CalendarCategory']['id'])->first();
			
			$help_group_pages = $this->help_group_pages;
			$resource_group_pages = $this->resource_group_pages;
			$corporate_group_pages = $this->corporate_group_pages;
			
			$default_currency = Currency::where('isDefault',1)->first();
			
			/** cart items **/
		
			$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
			$item_count = count($cartItems);
		}else{
			return redirect('user/login');
		}
		/** end cart items **/
		
		return view('calendar.easel_view',compact('easel','calendarDefaultSize','default_currency','help_group_pages','resource_group_pages','corporate_group_pages','calendar_category_id','item_count','calendar_size_id'));
	}
	public function easel_post(Request $request){
		$calendar_month = $request->get('calendar_month');
		$calendar_year = $request->get('calendar_year');
		$size = $request->get('size');
		$size_id = $request->get('size_id');
		$calendar_style_id = $request->get('calendar_style_id');
		$calendar_category_id = $request->get('calendar_category_id');
		return redirect('calendars/cal_editor/'.$calendar_style_id.'/'.$size_id.'/'.$calendar_category_id.'/'.$calendar_month.'/'.$calendar_year);
	}
	
	public function calendar_posters(){
		
		Session::forget('CurrentProjectData');
		/** default size for college poster **/
		$col_pos_size = CalendarDefaultSize::with('Size')->whereHas(
			'CalendarCategory', function ($query) {
				$query->where('calendar_category', 'like', '%Calendar Posters%');
			}
		)->whereNull('deleted_at')
		->orderBy('size_id','ASC')->get();
		
		/** end default size for college poster **/
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
		
		return view('calendar.calendar_posters',compact('col_pos_size','help_group_pages','resource_group_pages','corporate_group_pages','item_count'));
	}
	public function get_calendar_posters(Request $request){
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
			$whereRaw = "art_library = 0 AND reg_corner = 0 AND round_corner = 0 AND float_paperie = 0 AND paper_plains = 0 AND potts_design = 0 AND yours_truly = 0 AND disney = 0 AND printedcart = 0";
		}
		
		$coll_pos_cal = CalendarStyle::whereHas(
			'CalendarCategory', function ($query) {
				$query->where('calendar_category', 'like', '%Calendar Posters%');
			}
		)->whereRaw($whereRaw)->paginate(8);
		
		foreach($coll_pos_cal as $k => $value){
			/** for image **/
			$upload = DB::table('uploads')->select('path','hash')->where('id',$value['photo'])->first();
			$upDataArr = explode("uploads",$upload->path);
			$img = 'storage/uploads'.$upDataArr[1];
			$coll_pos_cal[$k]['photo'] = $img;
			/** for image end **/
			$size_group = SizeGroup::where('sizegroup','like','%Calendar Posters%')->first();
			$size = Size::whereRaw("Size = '".$value['design_size']."' AND sizegroup = '".$size_group['id']."'")->first();
			$coll_pos_cal[$k]['calendar_size_id'] = $size['id'];
		}
		return view('calendar.ajax_calendar_poster',compact('coll_pos_cal'));exit;
	}
	public function colposview($calendar_id=null,$calendar_category_id=null){
		if(Auth::check()){
			$help_group_pages = $this->help_group_pages;
			$resource_group_pages = $this->resource_group_pages;
			$corporate_group_pages = $this->corporate_group_pages;
			
			$college_poster = CalendarCategory::where('id',$calendar_category_id)->first();
			$calendar_image = $college_poster['calendar_image'];
			$upload = DB::table('uploads')->select('path','hash')->where('id',$calendar_image)->first();
			$upDataArr = explode("uploads",$upload->path);
			$college_poster['college_poster_img'] = 'storage/uploads'.$upDataArr[1];
			
			$college_poster_sizes = CalendarDefaultSize::with('Size')
				->where('calendar_category_id',$calendar_category_id)
				->whereNull('deleted_at')
				->get();
						
			$default_currency = Currency::select('id','currencyname','currencysymbol','currencycode','convertratio')->where('isDefault',1)->first();
			
			/** cart items **/
			$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
			$item_count = count($cartItems);
			/** end cart items **/
			
			return view('calendar.colpos_view',compact('help_group_pages','resource_group_pages','corporate_group_pages','calendar_id','college_poster','college_poster_sizes','default_currency','item_count'));
		}else{
			return redirect('user/login');
		}
		
	}
	public function colposter(Request $request){
		$post_data = $request->all();
		return redirect('calendars/poster_editor/'.$post_data['calendar_id'].'/'.$post_data['size_id'].'/'.$post_data['calendar_category'].'/'.$post_data['calendar_year']);
	}
	public function poster_editor($calendar_id=null,$size_id=null,$calendar_category_id=null,$year=null){
		if(isset(Auth::user()->id)){
			$user_id = Auth::user()->id;
		}else{
			return redirect('user/login');
		} 
		/** check project data **/
		$ep = DB::table('projects')->whereRaw("user_id = '".$user_id."' AND size_id = '".$size_id."' AND calendar_style_id = '".$calendar_id."' AND calendar_category_id = '".$calendar_category_id."' AND flag = 'College Poster'")->orderBy('id','DESC')->first();
		if(!empty($ep->id)){
			$project_id = $ep->id;
		}else{
			$project_id = '';
		}
		/** end check project data **/
		
		/* Album Lists*/
		$albums = DB::table("albums")->where("user_id",$user_id)->where('deleted_at','=','0000-00-00 00:00:00')->get();
		$photos = array();
		foreach($albums as $album){
			$albums_ps = DB::table("user_uploads")->where("album_id",$album->id)->where('deleted_at','=','0000-00-00 00:00:00')->get();
			$photos[$album->id] = $albums_ps;
		}
		$album_list = DB::table("albums")->where('user_id',$user_id)->where('deleted_at','=','0000-00-00 00:00:00')->pluck('album_name','id');
		/*album photos*/
		
		/** custom calendar layout **/
		$layout = CalendarLayout::whereRaw("calendar_category_id = '".$calendar_category_id."' AND isActive = 1")->get();
		if(count($layout)==0){
			$layout = CalendarLayout::whereRaw("calendar_category_id = 0 AND isActive = 1")->get();
		}
		foreach($layout as $k => $value){
			$upload = DB::table('uploads')->select('path')->where('id',$value['layout_image'])->first();
			$upDataArr = explode("uploads",$upload->path);
			$img = $upDataArr[1];
			$value['layout_image_path'] = 'storage/uploads'.$img;
		}
		/** end calendar layout **/
		
		/** demo content from calendar default pages **/
		$demo_content = DB::table('calendardefaultpages')->whereRaw("isActive = 1 AND calendar_category_id = '".$calendar_category_id."'")->first();
		if(count($demo_content)==0){
			$demo_content = DB::table('calendardefaultpages')->whereRaw("isActive = 1 AND calendar_category_id = 0")->first();
		}
		/** end demo content **/
		
		/** background images **/
		$pbg = CalendarBackground::whereRaw("calendar_category_id = '".$calendar_category_id."' AND calendar_style_id = '".$calendar_id."' AND isActive = 1")->first();
		if(count($pbg)==0){
			$pbg = CalendarBackground::whereRaw("calendar_category_id = '".$calendar_category_id."' AND isActive = 1")->first();
		}
		$background_ids = str_replace('[','',str_replace(']','',$pbg['background_image']));
		if(empty($background_ids)){
			return redirect()->back()->withErrors(['error'=>'College Poster Background Missing.']);
		}
		$upload_b = DB::table('uploads')->select('path')->whereRaw("id IN(".$background_ids.")")->get();
		foreach($upload_b as $k => $value){
			$upDataArr = explode("uploads",$value->path);
			$img = $upDataArr[1];
			$background_image[] = 'storage/uploads'.$img;
		}
		/** end background images **/
		
		/** calendar size **/
		$size = Size::where('id',$size_id)->first();
		$calendar_size = $size->Size;
		$price = $size->price;
		/** end calendar size **/
		
		if(isset(Auth::user()->email)){
			/** cart items **/
			$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
			$item_count = count($cartItems);
			/** end cart items **/
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
			Session::put('flag_poster_url',str_replace('/printedcart/','/',$_SERVER['REDIRECT_URL']));
			return view('calendar.poster_editor',compact('albums','album_list','photos','layout','background_image','demo_content','calendar_size','item_count','project_id','calendar_id','size_id','price','year','calendar_category_id'));
		}else{
			return redirect('user/login');
		}
	}
	public function save_poster(Request $request){
		$user_id = Auth::user()->id;
		$project_id = $request->get('project_id');
		$page_contents = $request->get('page_content');
		$exist = DB::table('user_saved_projects')->whereRaw("user_id = '".$user_id."' AND project_id = '".$project_id."'")->get();
		if(count($exist)>0){
			DB::table('user_saved_projects')->whereRaw("user_id = '".$user_id."' AND project_id = '".$project_id."'")->delete();
		}
		$insArr = array(
			'user_id' => $user_id,
			'page_content' => $page_contents,
			'project_id' => $project_id,
			'_token' => $request->get('_token')
		);
		DB::table('user_saved_projects')->insert($insArr);
		
		/** current saved project records **/
		$thisUR = DB::table('user_saved_projects')->whereRaw("user_id = '". Auth::user()->id ."' AND project_id = '".$project_id."'")->get();
		$savedProj = DB::table('user_saved_projects')->whereRaw("user_id = '". Auth::user()->id ."' AND project_id = '".$project_id."'")->orderBy('id','DESC')->first();
		Session::put('CurrentProjectData',$savedProj);
		/** end current saved project records **/
		return 'saved';exit;
	}
	public function htmltopdfview($project_id=null,$pdf=null){
		ini_set('max_execution_time', 300);
		$error_level = error_reporting();
		error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); 
		
		$project = Project::with('Size')->where('id',$project_id)->first();
		$calendar_size = $project['Size']['Size'];
		$calendar_category_id = $project['calendar_category_id'];
		
		$savedProj = DB::table('user_saved_projects')->whereRaw("user_id = '". Auth::user()->id ."' AND project_id = '".$project_id."'")->get();
		
        $help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		
		$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
		$item_count = count($cartItems);
		$albums = DB::table("albums")->where("user_id",Auth::user()->id)->get();
		
		if($pdf=='pdf'){
			$pdf = PDF::loadView('calendar.htmltopdfview' ,compact('savedProj','help_group_pages','resource_group_pages','corporate_group_pages','item_count','project_id','albums'));
			$pdf->setPaper('a4', 'portrait');
			return $pdf->stream('htmltopdfview.pdf')->header('Content-Type','application/pdf');  
			
		}	
		return view('calendar.htmltopdfview',compact('savedProj','help_group_pages','resource_group_pages','corporate_group_pages','item_count','project_id','albums','calendar_size','calendar_category_id')); 
	}
	
	public function desk_calendar(){
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		
		$desk_calendar = CalendarCategory::with('CalendarDefaultSize')->where('calendar_category','=','Desk Calendars')->first();
		$calendar_image = $desk_calendar['calendar_image'];
		$upload = DB::table('uploads')->select('path','hash')->where('id',$calendar_image)->first();
		$upDataArr = explode("uploads",$upload->path);
		$desk_calendar['desk_calendar_img'] = 'storage/uploads'.$upDataArr[1];
			
		$size_id = $desk_calendar['CalendarDefaultSize']['size_id'];
		$size = Size::where('id',$size_id)->first();
		
		$default_currency = Currency::select('id','currencyname','currencysymbol','currencycode','convertratio')->where('isDefault',1)->first();
		
		/** cart items **/
		if(Auth::check()){
			$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
			$item_count = count($cartItems);
		}else{
			$item_count = 0;
		}
		/** end cart items **/
		
		return view('calendar.desk_calendar',compact('help_group_pages','resource_group_pages','corporate_group_pages','desk_calendar','size','default_currency','item_count'));
	}
	
	public function get_desk_calendar(Request $request){
		if(Auth::check()){
			$post_data = $request->all();
			$calendar_size_id = $post_data['size_id'];
			$size = $post_data['size'];
			$month = $post_data['calendar_month'];
			$year = $post_data['calendar_year'];
			$calendar_id = 0;
			$calendar_category = $post_data['calendar_category'];
		
			return redirect('calendars/cal_editor/'.$calendar_id.'/'.$calendar_size_id.'/'.$calendar_category.'/'.$month.'/'.$year);
			
			$user_id = Auth::user()->id;
			/** check project data **/
			$ep = DB::table('projects')->whereRaw("user_id = '".$user_id."' AND size_id = '".$post_data['size_id']."' AND flag = 'Calendar'")->first();
			if(!empty($ep->id)){
				$project_id = $ep->id;
			}else{
				$project_id = '';
			}
			/** end check project data **/
			
			/* Album Lists*/
			$albums = DB::table("albums")->where("user_id",$user_id)->get();
			/*album photos*/
			$photos = array();
			foreach($albums as $album){
				$albums_ps = DB::table("user_uploads")->where("album_id",$album->id)->get();
				$photos[$album->id] = $albums_ps;
			}
		
			/** custom calendar layout **/
			$layout = CalendarLayout2::whereRaw("calendar_style_id = 0 AND isActive = 1")->get();
			foreach($layout as $k => $value){
				$upload = DB::table('uploads')->select('path')->where('id',$value['layout_image'])->first();
				$upDataArr = explode("uploads",$upload->path);
				$img = $upDataArr[1];
				$value['layout_image_path'] = 'storage/uploads'.$img;
			}
			/** end calendar layout **/
		
			/** background images **/
			$pbg = Calendarbackground::whereRaw("calendar_style_id = 0")->first();
			$background_ids = str_replace('[','',str_replace(']','',$pbg['background_image']));
			if(empty($background_ids)){
				return redirect()->back();
			}
			$upload_b = DB::table('uploads')->select('path')->whereRaw("id IN(".$background_ids.")")->get();
			foreach($upload_b as $k => $value){
				$upDataArr = explode("uploads",$value->path);
				$img = $upDataArr[1];
				$background_image[] = 'storage/uploads'.$img;
			} 
			/** end background images **/
		
			/** demo content **/
			$demo_content = DB::table('calendardefaultpages')->where('isActive',1)->get();
			/** end demo content **/
			
			/** calendar size **/
			$size = Size::where('id',$post_data['size_id'])->first();
			$calendar_size = $size->Size;
			$price = $size->price;
			/** end calendar size **/
		
		
			/** cart items **/
			$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0' AND cart_type = 'Calendar'")->get();
			$item_count = count($cartItems);
			/** end cart items **/
			$calendar_id = 0;
			return view('calendar.cal_custom_editor',compact('albums','photos','layout','background_image','demo_content','calendar_size','item_count','project_id','calendar_size_id','price','calendar_id','month','year'));
		}else{
			return redirect('user/login');
		}
	}
	
	public function get_calendar_preview($project_id=null){
		$thisUR = DB::table('user_saved_projects')->whereRaw("user_id = '". Auth::user()->id ."' AND project_id = '".$project_id."'")->get();
		$cntR = count($thisUR);
		if($cntR>0){
			$savedProj = DB::table('user_saved_projects')->whereRaw("user_id = '". Auth::user()->id ."' AND project_id = '".$project_id."'")->orderBy('id','DESC')->first();
			if($savedProj){
				return view('calendar.get_calendar_preview',compact('savedProj'));exit;
			}else{
				return 'failed';exit;
			}
		}else{
			return 'failed';exit;
		}
	}
	
	public function crop_image(Request $request){
		$user_id = Auth::user()->id;
		$post_data = $request->all();
		$imgsrc = $post_data['imgsrc'];
		$return = $this->convertBase64ToImage($imgsrc);
		return 'public/users_upload/'.$user_id.'/'.$return;exit;
		
		/* $x = $post_data['x'];
		$y = $post_data['y'];
		$w = $post_data['w'];
		$h = $post_data['h'];
		$tw = $post_data['tw'];
		$th = $post_data['th'];
		
		$targ_w = $w;
		$targ_h = $h;
		$jpeg_quality = 90;
			
		$img_r = imagecreatefromjpeg($imgsrc);
		$dst_r = ImageCreateTrueColor($targ_w, $targ_h);
		
		imagecopyresampled($dst_r,$img_r,0,0,$x,$y,$targ_w,$targ_h,$tw,$th);
		
		$exp = explode('public',$imgsrc);
		$a = explode('.',$exp[1]);
		$newImage = $a[0].time().'.'.$a[1]; 
		
		imagejpeg($dst_r,'public'.$newImage,$jpeg_quality);//$jpeg_quality
		
		return 'public'.$newImage;
		exit; */
		
		
	}
	public function convertBase64ToImage($photo = null) {
		$user_id = Auth::user()->id;
		if (!empty($photo)) {
			$photo = str_replace('data:image/png;base64,', '', $photo);
			$photo = str_replace(' ', '+', $photo);
			$photo = str_replace('data:image/jpeg;base64,', '', $photo);
			$photo = str_replace('data:image/jpg;base64,', '', $photo);
			$photo = str_replace('data:image/gif;base64,', '', $photo);
			$entry = base64_decode($photo);
			$image = imagecreatefromstring($entry);

			$fileName = time() . "crop.jpg";
			$directory = public_path("users_upload/" .$user_id.'/'. $fileName);

			header('Content-type:image/jpeg');

			$saveImage = imagejpeg($image, $directory);
			
			imagedestroy($image);

			if ($saveImage) {
				return $fileName;
			} else {
				return false; // image not saved
			}
		}
	}
}