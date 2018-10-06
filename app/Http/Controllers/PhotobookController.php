<?php
/**
 * Controller genrated using 
 */

namespace App\Http\Controllers;
use App\Size;
use App\SizeGroup;
use App\Currency;
use App\Promocode;
use App\Coupon;
use App\Photobookstyle;
use App\Photobook;
use App\Photobookbackground;
use App\Photobookembellishment;
use App\Photobookideapage;
use App\Photobooklayout;
use App\ShippingCategory;
use App\ShippingPrice;
use App\Covercategory;
use App\Coversubcategory;
use App\Coverprice;
use App\FinishingTouches;
use App\Http\Requests;
use DB,Auth;
use Illuminate\Http\Request;
use Session;
use PDF;
use Dompdf\Dompdf;
use Redirect;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class PhotobookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	protected $pdf;
	
    public function __construct(Pdf $pdf){
		//$this->middleware('auth');
        $this->help_group_pages = $this->help_group_pages();
		$this->resource_group_pages = $this->resource_group_pages();
		$this->corporate_group_pages = $this->corporate_group_pages();
		$this->pdf = $pdf;
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
		if(Auth::check()){
			$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
			$item_count = count($cartItems);
		}else{
			$item_count = 0;
		}
		/** end cart items **/
		
		return view('photobook.index',compact('help_group_pages','resource_group_pages','corporate_group_pages','item_count'));
    }
	public function custom_path(){
		Session::forget('CurrentProjectData');
		/**** get size group with size ****/
		$size = SizeGroup::with('Size')->where('sizegroup','=','Photobook')->first();
		foreach($size['Size'] as $k => $v){
			$v['Currency']=Currency::where('id',$v['currency'])->first();
		}
		/**** end size group with size ****/
		
		/**** get promocode ****/
		$promocode = Promocode::with('Coupon')->whereRaw("end_date >= '".date('Y-m-d H:i:s')."' AND coupon_flag = 'Saving'")->orderBy('id','DESC')->first();
		/**** end promocode ****/
		
		/**** get photo book styles ****/
		$count = Photobookstyle::count();
		$photobookstyles_top5 = Photobookstyle::where('isActive',1)->orderBy('id','ASC')->take(5)->get();
		$limit = $count - 5; // the limit
		$photobookstyles_skip5 = Photobookstyle::where('isActive',1)->orderBy('id','ASC')->skip(5)->take($limit)->get();
		/***** end photo book styles ****/
		
		/**** default photobook records ****/
		$default_style = Photobookstyle::where('isActive',1)->orderBy('id','ASC')->skip(1)->first();
		/**** end default photobook record ****/
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
		
		return view('photobook.custom_path',compact('size','promocode','photobookstyles_top5','photobookstyles_skip5','default_style','help_group_pages','resource_group_pages','corporate_group_pages','item_count'));
	}
	
	public function simple_path(){
		/**** get size group with size ****/
		Session::forget('CurrentProjectData');
		$size = SizeGroup::with('Size')->where('sizegroup','=','Photobook')->first();
		foreach($size['Size'] as $k => $v){
			$v['Currency']=Currency::where('id',$v['currency'])->first();
		}
		/**** end size group with size ****/
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
		
		return view('photobook.simple_path',compact('size','promocode','help_group_pages','resource_group_pages','corporate_group_pages','item_count'));
	}
	
	public function get_photo_books($style_id=null){
		if(is_numeric($style_id)){
			if($style_id==0){
				$photo_books = Photobook::where('thumb_left','!=',0)->orderBy('id','ASC')->paginate(6);
			}else{
				$photo_books = Photobook::where('photo_book_style_id',$style_id)->orderBy('id','ASC')->paginate(6);
			}
		}else{
			$explode = explode(',',$style_id);
			if((isset($explode[0]) && $explode[0]=='Storytelling') && isset($explode[1]) && $explode[1]=='Standard'){
				$whereRaw = "standard=1 OR storytelling=1";
				$photo_books = Photobook::whereRaw($whereRaw)->orderBy('id','ASC')->paginate(6);
			}elseif(isset($explode[0]) && $explode[0]=='Storytelling'){
				$whereRaw = "storytelling=1 AND thumb_left!=0";
				$photo_books = Photobook::whereRaw($whereRaw)->orderBy('id','ASC')->paginate(6);
			}else{
				$whereRaw = "standard=1 AND thumb_left!=0";
				$photo_books = Photobook::whereRaw($whereRaw)->orderBy('id','ASC')->paginate(6);
			}
		}
		
		foreach($photo_books as $k => $value){
			/** for image thumb left **/
			if($value['thumb_left'] == 0){
				unset($photo_books[$k]);
			}else{
				$upload = DB::table('uploads')->select('path','hash')->where('id',$value['thumb_left'])->first();
				$upDataArr = explode("uploads",$upload->path);
				$img = 'storage/uploads'.$upDataArr[1];
				$photo_books[$k]['thumb_left_image'] = $img;
			}
			/** for image thumb left end **/
			
			/** for image thumb right **/
			if($value['thumb_right'] == 0){
				unset($photo_books[$k]);
			}else{
				$upload2 = DB::table('uploads')->select('path','hash')->where('id',$value['thumb_right'])->first();
				$upDataArr2 = explode("uploads",$upload2->path);
				$img2 = 'storage/uploads'.$upDataArr2[1];
				$photo_books[$k]['thumb_right_image'] = $img2;
			}
			/** for image thumb right end **/
		}
		return view('photobook.ajax_photo_book',compact('photo_books')); exit;
	}
	
	public function get_book_styles($photobook_id=null,$size_id=null){
		/** photobook **/
		$photobook = Photobook::where('id',$photobook_id)->first();
		$data['photobook'] = $photobook;
		/** end photobook **/
		
		/** photobook background **/
		/* $photobookbackground = Photobookbackground::where('photo_book_id',$photobook_id)->first();
		$background_ids = str_replace('[','',str_replace(']','',$photobookbackground['background_image']));
		$upload = DB::table('uploads')->select('path')->whereRaw("id IN(".$background_ids.")")->get();
		foreach($upload as $k => $value){
			$upDataArr = explode("uploads",$value->path);
			$img = $upDataArr[1];
			$value->background_image = $img;
		}
		$data['photobookbackground'] = $upload;  */
		/** end photobook background **/
		
		/** photobook embellishment **/
		/* $photobookembellishment = Photobookembellishment::where('photo_book_id',$photobook_id)->first();
		$embellishment_ids = str_replace('[','',str_replace(']','',$photobookembellishment['embellishments']));
		$upload2 = DB::table('uploads')->select('path')->whereRaw("id IN(".$embellishment_ids.")")->get();
		foreach($upload2 as $k2 => $value2){
			$upDataArr2 = explode("uploads",$value2->path);
			$img2 = $upDataArr2[1];
			$value2->embellishment_image = $img2;
		}
		$data['photobookembellishment'] = $upload2;  */
		/** end photobook embellishment **/
		
		/** photobook ideapages **/
		/* $photobookideapage = Photobookideapage::where('photo_book_id',$photobook_id)->first();
		$ideapage_ids = str_replace('[','',str_replace(']','',$photobookideapage['idea_pages']));
		$upload3 = DB::table('uploads')->select('path')->whereRaw("id IN(".$ideapage_ids.")")->get();
		foreach($upload3 as $k3 => $value3){
			$upDataArr3 = explode("uploads",$value3->path);
			$img3 = $upDataArr3[1];
			$value3->idea_pages_image = $img3;
		}
		$data['photobookideapages'] = $upload3; */
		/** end photobook ideapages **/
		
		/** photobook covers **/
		$covers = Covercategory::where('isActive',1)->pluck('cover_category','id');
		$data['covers'] = $covers;
		/** end photobook covers **/
				
		/** photobook size **/
		$size = SizeGroup::with('Size')->where('sizegroup','=','Photobook')->first();
		$data['size'] = $size['Size'];
		/** end photobook size **/
		
		/** for get default photobook prize **/
		$default_size_id = $default_cover_id = '';
		foreach($size['Size'] as $k => $v){
			if($k==0){
				$default_size_id = $v['id'];
				$dc = Covercategory::with('Coversubcategory')->where('isActive',1)->first();
				$default_cover_subcategory_id = $dc['Coversubcategory']['id'];
			}
		}
		$photobook_cover_price = Coverprice::whereRaw("size_id = '".$default_size_id."' AND cover_sub_category_id = '".$default_cover_subcategory_id."'")->first();
		$data['photobook_cover_price'] = $photobook_cover_price;
		/** end for default photobook prize **/
		
		/** get default currency **/
		$default_currency = Currency::where('isDefault',1)->first();
		$data['default_currency'] = $default_currency;
		$data['size_id'] = $size_id;
		/** end default currency **/
		return view('photobook.get_book_styles',compact('data')); exit;
	}
	
	public function get_photobook_price($size_id=null,$cover_id=null){
		$csc = DB::table('coversubcategories')->where('cover_category_id',$cover_id)->first();
		$photobook_cover_price = Coverprice::whereRaw("size_id = '".$size_id."' AND cover_sub_category_id = '". $csc->id ."'")->first();
		$data['photobook_cover_price'] = $photobook_cover_price;
		
		/** get default currency **/
		$default_currency = Currency::where('isDefault',1)->first();
		$data['default_currency'] = $default_currency;
		/** end default currency **/
		
		/** photobook size **/
		$size = SizeGroup::with('Size')->where('sizegroup','=','Photobook')->first();
		$data['size'] = $size['Size'];
		/** end photobook size **/
		/* echo '<pre>';
		print_r($data);exit; */
		return view('photobook.get_photobook_price',compact('data')); exit;
	}
	
	public function post_editor_custom_path(Request $request){
		if(Auth::check()){
			$photobook_id = $request->get('photobook_id');
			$project_name = $request->get('project_name');
			$photobook_size = $request->get('photobook_size');
			$cover_category_id = $request->get('photobook_cover');
			$photobook_price = $request->get('photobook_price');
			$photobook_cover_price = $request->get('photobook_cover_price');
			$extra_page_price = $request->get('extra_page_price');
			$user_id = Auth::user()->id;
			
			/** insert project data into project table **/
			$exist = DB::table('projects')->whereRaw("user_id='".$user_id."' AND photobook_id='".$photobook_id."' AND project_name='".$project_name."' AND size_id='".$photobook_size."' AND cover_category_id='".$cover_category_id."'")->first();
		
			if(!empty($exist->id)){
				$updProArr = array(
					'user_id' => $user_id,
					'photobook_id' => $photobook_id,
					'project_name' => $project_name,
					'size_id' => $photobook_size,
					'cover_category_id' => $cover_category_id,
					'price' => $photobook_price,
					'cover_price' => $photobook_cover_price,
					'extra_page_price' => $extra_page_price
				);
				DB::table('projects')->where('id',$exist->id)->update($updProArr);
				$project_id = $exist->id;
			}else{
				$insProArr = array(
					'user_id' => $user_id,
					'photobook_id' => $photobook_id,
					'project_name' => $project_name,
					'size_id' => $photobook_size,
					'cover_category_id' => $cover_category_id,
					'price' => $photobook_price,
					'cover_price' => $photobook_cover_price,
					'extra_page_price' => $extra_page_price,
					'flag' => 'Photobook'
				);
				$project_id = DB::table('projects')->insertGetId($insProArr);
			}
			return redirect('photobooks/editor_custom_path/'.$photobook_id.'/'.$photobook_size.'/'.$project_id);
		}else{
			return redirect('user/login');
		}
	}

	public function editor_custom_path($photobook_id,$photobook_size,$project_id){
		if(Auth::check()){
			$user_id = Auth::user()->id;
			/* $photobook_id = $request->get('photobook_id');
			$project_name = $request->get('project_name');
			$photobook_size = $request->get('photobook_size');
			$cover_category_id = $request->get('photobook_cover');
			$photobook_price = $request->get('photobook_price');
			$photobook_cover_price = $request->get('photobook_cover_price');
			$extra_page_price = $request->get('extra_page_price');
			$user_id = Auth::user()->id;
			
			$exist = DB::table('projects')->whereRaw("user_id='".$user_id."' AND photobook_id='".$photobook_id."' AND project_name='".$project_name."' AND size_id='".$photobook_size."' AND cover_category_id='".$cover_category_id."'")->first();
		
			if(!empty($exist->id)){
				$updProArr = array(
					'user_id' => $user_id,
					'photobook_id' => $photobook_id,
					'project_name' => $project_name,
					'size_id' => $photobook_size,
					'cover_category_id' => $cover_category_id,
					'price' => $photobook_price,
					'cover_price' => $photobook_cover_price,
					'extra_page_price' => $extra_page_price
				);
				DB::table('projects')->where('id',$exist->id)->update($updProArr);
				$project_id = $exist->id;
			}else{
				$insProArr = array(
					'user_id' => $user_id,
					'photobook_id' => $photobook_id,
					'project_name' => $project_name,
					'size_id' => $photobook_size,
					'cover_category_id' => $cover_category_id,
					'price' => $photobook_price,
					'cover_price' => $photobook_cover_price,
					'extra_page_price' => $extra_page_price,
					'flag' => 'Photobook'
				);
				$project_id = DB::table('projects')->insertGetId($insProArr);
			} */
			/** end insert project data into project table **/
			
			/** custom photo layout **/
			$layout = Photobooklayout::where('isActive',1)->get();
			foreach($layout as $k => $value){
				$upload = DB::table('uploads')->select('path')->where('id',$value['layout_image'])->first();
				$upDataArr = explode("uploads",$upload->path);
				$img = $upDataArr[1];
				$value['layout_image_path'] = 'storage/uploads'.$img;
			}
			/** end layouts **/
			/** custom photo background **/
			/* $background = Photobookbackground::where('photo_book_id',$photobook_id)->get();
			echo '<pre>';
			print_r($background);exit;
			foreach($background as $k => $value){
				$upload = DB::table('uploads')->select('path')->where('id',$value['background_image'])->first();
				$upDataArr = explode("uploads",$upload->path);
				$img = $upDataArr[1];
				$value['background_image_path'] = 'storage/uploads'.$img;
			} */
		
			$pbg = PhotobookBackground::whereRaw("photo_book_id = '".$photobook_id."' AND isActive = 1")
				->whereNull("deleted_at")->first();
			if(count($pbg)>0){
				$background_ids = str_replace('[','',str_replace(']','',$pbg['background_image']));
				if(empty($background_ids)){
					return redirect()->back()->withErrors(['error'=>'Photobook Background Missing.']);
				}
				$upload_b = DB::table('uploads')->select('path')->whereRaw("id IN(".$background_ids.")")->get();
				foreach($upload_b as $k => $value){
					$upDataArr = explode("uploads",$value->path);
					$img = $upDataArr[1];
					$background_image[] = 'storage/uploads'.$img;
				}
			}else{
				$background_image = array();
			}
			/** end background **/
			/** custom photo embellishment **/
			$emb = Photobookembellishment::where('photo_book_id',$photobook_id)->first();
			$emb_ids = str_replace('[','',str_replace(']','',$emb['embellishments']));
			if(empty($emb_ids)){
				return redirect()->back()->withErrors(['error'=>'Photobook Embellishments Missing.']);
			}
			$upload_e = DB::table('uploads')->select('path')->whereRaw("id IN(".$emb_ids.")")->get();
			foreach($upload_e as $k => $value){
				$upDataArr = explode("uploads",$value->path);
				$img = $upDataArr[1];
				$embellishment_image[] = 'storage/uploads'.$img;
			}
			/** end embellishment **/
			/** custom photo ideapage **/
			$idpg = Photobookideapage::where('photo_book_id',$photobook_id)->first();
			$idpg_ids = str_replace('[','',str_replace(']','',$idpg['idea_pages']));
			if(empty($idpg_ids)){
				return redirect()->back()->withErrors(['error'=>'Photobook Idea pages Missing.']);
			}
			$upload_i = DB::table('uploads')->select('path')->whereRaw("id IN(".$idpg_ids.")")->get();
			foreach($upload_i as $k => $value){
				$upDataArr = explode("uploads",$value->path);
				$img = $upDataArr[1];
				$ideapage_image[] = 'storage/uploads'.$img;
			}
			/** end ideapage **/
			$demo_content = DB::table('photobookdefaultpages')->where('isActive',1)->get();
			/* Album Lists*/
			$albums = DB::table("albums")->where("user_id",$user_id)->where('deleted_at','=','0000-00-00 00:00:00')->get();
			$album_list = DB::table("albums")->where('user_id',$user_id)->where('deleted_at','=','0000-00-00 00:00:00')->pluck('album_name','id');
			/*album photos*/
			$photos = array();
			foreach($albums as $album){
				$albums_ps = DB::table("user_uploads")->where("album_id",$album->id)->where('deleted_at','=','0000-00-00 00:00:00')->get();
				$photos[$album->id] = $albums_ps;
			}

			/**** get size from table behalf of received size id ****/
			$size = Size::where('id',$photobook_size)->first();
			$book_size = $size->Size;
			/**** end size from table behalf of received size id ****/
			$already_saved_page = "";
		
			$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
			$item_count = count($cartItems);
			
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
			Session::put('flag_photobook_custom_url',str_replace('/printedcart/','/',$_SERVER['REDIRECT_URL']));
			
			return view('photobook.photobook_custom_editor', compact('layout','background_image','embellishment_image','ideapage_image','demo_content', 'albums', 'album_list', 'photos','project_id','item_count','book_size','already_saved_page'));
		}else{
			return redirect('user/login');
		}
	}
	
	public function editor_custom_path_cp($project_id=null){
		$project = DB::table('projects')->where('id',$project_id)->first();
		$photobook_id = $project->photobook_id;
		$photobook_size = $project->size_id;
		/** layouts **/
		$layout = Photobooklayout::where('isActive',1)->get();
		foreach($layout as $k => $value){
			$upload = DB::table('uploads')->select('path')->where('id',$value['layout_image'])->first();
			$upDataArr = explode("uploads",$upload->path);
			$img = $upDataArr[1];
			$value['layout_image_path'] = 'storage/uploads'.$img;
		}
		/** end layout **/
		/** background images **/
		//$pbg = Photobookbackground::where('isActive',1)->get();
		$pbg = PhotobookBackground::where("isActive",1)
			->whereNull("deleted_at")
			->get();
		if(count($pbg)>0){
			$background_ids = $sep = "";
			foreach($pbg as $k => $v){
				$background_ids = $background_ids.$sep.str_replace('[','',str_replace(']','',$v['background_image']));
				$sep = ",";
			}
			$upload_b = DB::table('uploads')->select('path')->whereRaw("id IN(".$background_ids.")")->get();
			foreach($upload_b as $k => $value){
				$upDataArr = explode("uploads",$value->path);
				$img = $upDataArr[1];
				$background_image[] = 'storage/uploads'.$img;
			}
		}else{
			$background_image = array();
		}
		/** end background images **/
						
		/** current saved project records **/
		$thisUR = DB::table('user_saved_projects')->whereRaw("user_id = '". Auth::user()->id ."' AND project_id = '".$project_id."'")->get();
		if(!empty($thisUR)){
			$cntR = count($thisUR);
			$demo_content = DB::table('user_saved_projects')->whereRaw("user_id = '". Auth::user()->id ."' AND project_id = '".$project_id."'")->skip(2)->take($cntR-4)->get();
		}else{
			$demo_content = DB::table('photobookdefaultpages')->where('isActive',1)->get();
		}
		/** end current saved project records **/
		
		/* Album Lists*/
		$albums = DB::table("albums")->where("user_id",Auth::user()->id)->where('deleted_at','=','0000-00-00 00:00:00')->get();
		$album_list = DB::table("albums")->where('user_id',Auth::user()->id)->where('deleted_at','=','0000-00-00 00:00:00')->pluck('album_name','id');
		/*album photos*/
		$photos = array();
		foreach($albums as $album){
			$albums_ps = DB::table("user_uploads")->where("album_id",$album->id)->where('deleted_at','=','0000-00-00 00:00:00')->get();
			$photos[$album->id] = $albums_ps;
		}
		/**** get size from table behalf of received size id ****/
		$size = Size::where('id',$photobook_size)->first();
		$book_size = $size->Size;
		/**** end size from table behalf of received size id ****/
		$already_saved_page = "exist";
		if(isset(Auth::user()->email)){
			$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
			$item_count = count($cartItems);
			return view('photobook.photobook_custom_editor', compact('background_image','layout','demo_content', 'albums','album_list','photos','project_id','item_count','book_size','already_saved_page'));
		}else{
			return redirect('user/login');
		}
	}
	
	public function editor_simple_path($size_id=null){
		if(Auth::check()){
			$user_id = Auth::user()->id;
			/** layout **/
			$layout = Photobooklayout::where('isActive',1)->get();
			foreach($layout as $k => $value){
				$upload = DB::table('uploads')->select('path')->where('id',$value['layout_image'])->first();
				$upDataArr = explode("uploads",$upload->path);
				$img = $upDataArr[1];
				$value['layout_image_path'] = 'storage/uploads'.$img;
			}
			/** end layouts **/
			/** background images **/
			/* $pbg = Photobookbackground::where('isActive',1)
				->where('deleted_at','!=','NULL')
				->get(); */
			//$pbg = PhotobookBackground::whereRaw("isActive = 1 AND deleted_at != NULL")->get();
			$pbg = PhotobookBackground::where("isActive",1)
				->whereNull("deleted_at")
				->get();
			
			if(count($pbg)>0){
				$background_ids = $sep = "";
				foreach($pbg as $k => $v){
					$background_ids = $background_ids.$sep.str_replace('[','',str_replace(']','',$v['background_image']));
					$sep = ",";
				}
				$upload_b = DB::table('uploads')->select('path')->whereRaw("id IN(".$background_ids.")")->get();
				foreach($upload_b as $k => $value){
					$upDataArr = explode("uploads",$value->path);
					$img = $upDataArr[1];
					$background_image[] = 'storage/uploads'.$img;
				}
			}else{
				$background_image = array();
			}
			/** end background images **/
			
			$demo_content = DB::table('photobookdefaultpages')->where('isActive',1)->get();
			/* Album Lists*/
			$albums = DB::table("albums")->where("user_id",$user_id)->where('deleted_at','=','0000-00-00 00:00:00')->get();
			$album_list = DB::table("albums")->where('user_id',$user_id)->where('deleted_at','=','0000-00-00 00:00:00')->pluck('album_name','id');
			/*album photos*/
			$photos = array();
			foreach($albums as $album){
				$albums_ps = DB::table("user_uploads")->where("album_id",$album->id)->where('deleted_at','=','0000-00-00 00:00:00')->get();
				$photos[$album->id] = $albums_ps;
			}
			/**** get size from table behalf of received size id ****/
			$size = Size::where('id',$size_id)->first();
			$book_size = $size->Size;
			/**** end size from table behalf of received size id ****/
				
			$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
			$item_count = count($cartItems);
			
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
			Session::put('flag_photobook_simple_url',str_replace('/printedcart/','/',$_SERVER['REDIRECT_URL']));
			return view('photobook.photobook_simple_editor', compact('background_image','layout','demo_content', 'albums','album_list','photos','item_count','book_size','size_id'));
		}else{
			return redirect('user/login');
			//return redirect()->back()->with('guest_user','yes');
		}
	}
	public function save_project(Request $request){
		$project_name = $request->get('project_name');
		$size_id = $request->get('size_id');
		$size = Size::where('id',$size_id)->first();
		$user_id = Auth::user()->id;
		$exist = DB::table('projects')->whereRaw("project_name='".$project_name."' AND size_id='".$size_id."' AND user_id='".$user_id."'")->first();
		if(count($exist)>0){
			$project_id = $exist->id;
			if($project_id){
				$page_contents = $request->get('page_content');
				$exist = DB::table('user_saved_projects')->whereRaw("user_id = '".$user_id."' AND project_id = '".$project_id."'")->get();
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
				/** current saved project records **/
				$thisUR = DB::table('user_saved_projects')->whereRaw("user_id = '". Auth::user()->id ."' AND project_id = '".$project_id."'")->get();
				$cntR = count($thisUR);
				$savedProj = DB::table('user_saved_projects')->whereRaw("user_id = '". Auth::user()->id ."' AND project_id = '".$project_id."'")->skip(2)->take($cntR-4)->get();
				Session::put('CurrentProjectData',$savedProj);
				return 'saved';
			}else{
				return 'error';
			}
		}else{
			$insProArr = array(
				'user_id' => $user_id,
				'project_name' => $project_name,
				'size_id' => $size_id,
				'price' => $size['price'],
				'flag' => 'Photobook'
			);
			$project_id = DB::table('projects')->insertGetId($insProArr);
			if($project_id){
				$page_contents = $request->get('page_content');
				$exist = DB::table('user_saved_projects')->whereRaw("user_id = '".$user_id."' AND project_id = '".$project_id."'")->get();
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
				/** current saved project records **/
				$thisUR = DB::table('user_saved_projects')->whereRaw("user_id = '". Auth::user()->id ."' AND project_id = '".$project_id."'")->get();
				$cntR = count($thisUR);
				$savedProj = DB::table('user_saved_projects')->whereRaw("user_id = '". Auth::user()->id ."' AND project_id = '".$project_id."'")->skip(2)->take($cntR-4)->get();
				Session::put('CurrentProjectData',$savedProj);
				return 'saved';
			}else{
				return 'error';
			}
		}
	}

	public function upload_new_images(Request $request){
		$user_id = Auth::user()->id; 
		$allowed_image_extension = array("png","jpg","jpeg","gif");
		/* echo '<pre>';
		print_r($_FILES);exit; */
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
					//$response['success'][] = $_FILES['images']['name'][$k]." Success. Image upload successfully.";
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
			return Redirect::back()->with('photo_upload','ok');
		}
		/* $user_id = Auth::user()->id; 
		$albumId = $request->get('albums');
		$images = $request->file('files');
		$i = 0;
		$img = '';
		foreach($images as $image){
			$ext = $image->getClientOriginalExtension();
			$newName =	$input['imagename'] = "pc_".$i."_".time().'.'.$ext;
		    $destinationPath = public_path('users_upload').'/'.$user_id;
		    if(!file_exists($destinationPath)){
		    	mkdir($destinationPath, 0777);
		    }	
		    $image->move($destinationPath, $input['imagename']);      
			$img .= '<img src="'.env("APP_URL").'public/users_upload/'.$user_id.'/'.$newName.'" class="thumbimage dragElement" id="drag_'.$i.'" >';
		  	$values = array(
		 		"user_id"		=> $user_id,
		 		"album_id" 		=> $albumId,
		 		"name"			=> $newName,
		 		"path"			=> 'users_upload'.'/'.$user_id,
		 		"extension"		=> $ext,
	 		);
		    DB::table("user_uploads")->insert($values);
		    $i++;
		}
		echo $img; */
	}
	
	public function upload_new_images_ajax(Request $request){
		$user_id = Auth::user()->id; 
		$allowed_image_extension = array("png","jpg","jpeg","gif");
		$img = '';
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
					$img .= '<img src="'.env("APP_URL").'public/users_upload/'.$user_id.'/'.$filename.'" class="thumbimage dragElement" id="drag_'.$k.'" >';
					if($img_upl_cnt>1){
						$uploded_text = "photos";
					}else{
						$uploded_text = "photo";
					}
					$response['success'] = $img_upl_cnt." ".$uploded_text." uploaded successfully";
					//$response['success'][] = $_FILES['images']['name'][$k]." Success. Image upload successfully.";
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
			return $response;
			//return Redirect::back()->with(['message'=>$response])->withInput();
		}else{
			return 'ok';
			//return Redirect::back()->with('photo_upload','ok');
		}
		/* $user_id = Auth::user()->id; 
		$albumId = $request->get('albums');
		$images = $request->file('files');
		$i = 0;
		$img = '';
		foreach($images as $image){
			$ext = $image->getClientOriginalExtension();
			$newName =	$input['imagename'] = "pc_".$i."_".time().'.'.$ext;
		    $destinationPath = public_path('users_upload').'/'.$user_id;
		    if(!file_exists($destinationPath)){
		    	mkdir($destinationPath, 0777);
		    }	
		    $image->move($destinationPath, $input['imagename']);      
			$img .= '<img src="'.env("APP_URL").'public/users_upload/'.$user_id.'/'.$newName.'" class="thumbimage dragElement" id="drag_'.$i.'" >';
		  	$values = array(
		 		"user_id"		=> $user_id,
		 		"album_id" 		=> $albumId,
		 		"name"			=> $newName,
		 		"path"			=> 'users_upload'.'/'.$user_id,
		 		"extension"		=> $ext,
	 		);
		    DB::table("user_uploads")->insert($values);
		    $i++;
		}
		echo $img; */
	}

	public function add_new_album(Request $req){
		$user_id = Auth::user()->id; 
		$albumName = $req->get('album_name');
		$values = array(
			"album_name" => $albumName,
			"user_id"	 => $user_id
		);
		$id = DB::table("albums")->insertGetId($values);
		return redirect()->back()->with('album_id',$id);
		//echo "<option value='".$id."' selected='selected'>".$albumName."</option>";
	}
	
	public function add_new_album_ajax(Request $request){
		$user_id = Auth::user()->id; 
		$albumName = $request->get('album_name');
		$values = array(
			"album_name" => $albumName,
			"user_id"	 => $user_id
		);
		$id = DB::table("albums")->insertGetId($values);
		echo "<option value='".$id."' selected='selected'>".$albumName."</option>";
		exit;
	}

	public function addmore_page($w=null,$h=null){
		return view('photobook.addmore_page',compact('w','h'));exit;
	}
	
	public function get_photobook_preview($project_id=null){
		$thisUR = DB::table('user_saved_projects')->whereRaw("user_id = '". Auth::user()->id ."' AND project_id = '".$project_id."'")->get();
		$cntR = count($thisUR);
		if($cntR>0){
			$savedProj = DB::table('user_saved_projects')->whereRaw("user_id = '". Auth::user()->id ."' AND project_id = '".$project_id."'")->skip(2)->take($cntR-4)->get();
			if($savedProj){
				return view('photobook.get_photobook_preview',compact('savedProj'));exit;
			}else{
				return 'failed';exit;
			}
		}else{
			return 'failed';exit;
		}
	}
	
	public function save_photobook(Request $request){
		$user_id = Auth::user()->id;
		$project_id = $request->get('project_id');
		$page_contents = $request->get('page_content');
		$exist = DB::table('user_saved_projects')->whereRaw("user_id = '".$user_id."' AND project_id = '".$project_id."'")->get();
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
		
		/** current saved project records **/
		$thisUR = DB::table('user_saved_projects')->whereRaw("user_id = '". Auth::user()->id ."' AND project_id = '".$project_id."'")->get();
		$cntR = count($thisUR);
		$savedProj = DB::table('user_saved_projects')->whereRaw("user_id = '". Auth::user()->id ."' AND project_id = '".$project_id."'")->skip(2)->take($cntR-4)->get();
		Session::put('CurrentProjectData',$savedProj);
		/** end current saved project records **/
		return 'saved';exit;
	}
	
	function get_photobook_status($project_id=null){
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
		$exist = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND project_id='".$project_id."' AND cart_type = 'Photobook' AND status = '".$status."'")->first();
		if(count($exist)>0){
			$data['status'] = 'already_added';
		}else{
			$insArr = array(
				'user_id' => Auth::user()->id,
				'project_id' => $request->get('project_id'),
				'session_id' => $request->get('_token'),
				'cart_type' => 'Photobook'
			);
			DB::table('carts')->insert($insArr);
			$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
			$data['item_count'] = count($cartItems);
			$data['status'] = 'added';
		}
		return $data;exit;
	}
	
	public function shipping_address_status(){
		$exist = DB::table('user_address_infos')->where('user_id',Auth::user()->id)->first();
		if(count($exist)>0){
			return 'exist';exit;
		}else{
			return 'not_exist';exit;
		}
	}
	
	/******* make my service *******/
	public function make_my_book(){
		$finishing_touches = FinishingTouches::whereNull('deleted_at')->get();
		
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
		
		return view('photobook.make_my_book',compact('help_group_pages','resource_group_pages','corporate_group_pages','finishing_touches','item_count'));
	}
	public function mmb_fitch($id=null){
		$fitch = FinishingTouches::where('id',$id)->first();
		$video_url = $fitch['video_url'];
		return view('photobook.mmb_fitch',compact('video_url'));exit;
	}
	public function mmb(){
		/**** get size group with size ****/
		$size = SizeGroup::with('Size')->where('sizegroup','=','Photobook')->first();
		foreach($size['Size'] as $k => $v){
			$v['Currency']=Currency::where('id',$v['currency'])->first();
		}
		/**** end size group with size ****/
		/**** get photo book styles ****/
		$count = Photobookstyle::count();
		$photobookstyles_top5 = Photobookstyle::where('isActive',1)->orderBy('id','ASC')->take(5)->get();
		$limit = $count - 5; // the limit
		$photobookstyles_skip5 = Photobookstyle::where('isActive',1)->orderBy('id','ASC')->skip(5)->take($limit)->get();
		/***** end photo book styles ****/
		
		/** photobook style for select box **/
		$photobook_style = Photobookstyle::where('isActive',1)->skip(10)->take($limit)->pluck('photo_book_style','id');
		/** end photobook style for select box **/
		
		/**** default photobook records ****/
		$default_style = Photobookstyle::where('isActive',1)->orderBy('id','ASC')->skip(1)->first();
		/**** end default photobook record ****/
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
		
		return view('photobook.mmb_listing',compact('size','photobookstyles_top5','photobookstyles_skip5','default_style','photobook_style','help_group_pages','resource_group_pages','corporate_group_pages','item_count'));
	}
	public function get_mmb_photo_books($style_id=null){
		if(is_numeric($style_id)){
			if($style_id==0){
				$photo_books = Photobook::where('thumb_left','!=',0)->orderBy('id','ASC')->paginate(6);
			}else{
				$photo_books = Photobook::where('photo_book_style_id',$style_id)->orderBy('id','ASC')->paginate(6);
			}
		}else{
			$explode = explode(',',$style_id);
			if((isset($explode[0]) && $explode[0]=='Storytelling') && isset($explode[1]) && $explode[1]=='Standard'){
				$whereRaw = "standard=1 OR storytelling=1";
				$photo_books = Photobook::whereRaw($whereRaw)->orderBy('id','ASC')->paginate(6);
			}elseif(isset($explode[0]) && $explode[0]=='Storytelling'){
				$whereRaw = "storytelling=1 AND thumb_left!=0";
				$photo_books = Photobook::whereRaw($whereRaw)->orderBy('id','ASC')->paginate(6);
			}else{
				$whereRaw = "standard=1 AND thumb_left!=0";
				$photo_books = Photobook::whereRaw($whereRaw)->orderBy('id','ASC')->paginate(6);
			}
		}
		foreach($photo_books as $k => $value){
			/** for image thumb left **/
			if($value['thumb_left'] == 0){
				unset($photo_books[$k]);
			}else{
				$upload = DB::table('uploads')->select('path','hash')->where('id',$value['thumb_left'])->first();
				$upDataArr = explode("uploads",$upload->path);
				$img = 'storage/uploads'.$upDataArr[1];
				$photo_books[$k]['thumb_left_image'] = $img;
			}
			/** for image thumb left end **/
			/** for image thumb right **/
			if($value['thumb_right'] == 0){
				unset($photo_books[$k]);
			}else{
				$upload2 = DB::table('uploads')->select('path','hash')->where('id',$value['thumb_right'])->first();
				$upDataArr2 = explode("uploads",$upload2->path);
				$img2 = 'storage/uploads'.$upDataArr2[1];
				$photo_books[$k]['thumb_right_image'] = $img2;
			}
			/** for image thumb right end **/
		}
		return view('photobook.ajax_mmb_photo_book',compact('photo_books')); exit;
	}
	public function mmb_store(Request $request){
		if(Auth::check()){
			$user_id = Auth::user()->id; 
			$photobook_style_id = $request->get('photobook_style_id');
			$mybook_name = $request->get('mybook_name');
			$special_instructions = $request->get('special_instructions');
			$photobook_id = $request->get('photobook_id');
			$size_id	=	$request->get('size_id');
			$insArr = array(
				'user_id'				=>	$user_id,
				'photobook_style_id'	=>	$photobook_style_id,
				'photobook_id'			=>	$photobook_id,
				'size_id'				=>	$size_id,
				'mybook_name'			=>	$mybook_name,
				'special_instructions'	=>	$special_instructions
			);
			$mmb_id = DB::table('mmb')->insertGetId($insArr);
			$images = $request->file('photos');
			$photo = count($images);
			foreach($images as $k => $image){
				$ext = $image->getClientOriginalExtension();
				$newName =	"mmb_".$k."_".time().'.'.$ext;
				$destinationPath = public_path('user_mmb_upload').'/'.$user_id;
				if(!file_exists($destinationPath)){
					mkdir($destinationPath, 0777);
				}	
				$image->move($destinationPath, $newName);      
				$values = array(
					"user_id"=> $user_id,
					"mmb_id" => $mmb_id,
					"photos" => 'public/user_mmb_upload/'.$user_id.'/'.$newName,
				);
				DB::table("mmb_photos")->insert($values);
			}
			return redirect('photobooks/mmb_complete/'.$mmb_id);
		}else{
			return redirect('user/login');
		}
	}
	public function mmb_complete($mmb_id = null){
		$mmb = DB::table('mmb')->where('id',$mmb_id)->first();
				
		$photobook 	= Photobook::where('id',$mmb->photobook_id)->first();
		
		$photobook_name = $photobook['photo_book'];
		
		$size = Size::where('id',$mmb->size_id)->first();
		$book_size = $size['Size'];
		
		$mybook_name = $mmb->mybook_name;
		
		$mmb_photo = DB::table('mmb_photos')->where('mmb_id',$mmb_id)->get();
		$photo = count($mmb_photo);
		
		$photostyle = Photobookstyle::where('id',$mmb->photobook_style_id)->first();
		$style_name = $photostyle['photo_book_style'];
		
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		
		/** cart items **/
		$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
		$item_count = count($cartItems);
		/** end cart items **/
		
		return view('photobook.mmb_complete',compact('style_name','photobook_name','book_size','mybook_name','photo','help_group_pages','resource_group_pages','corporate_group_pages','item_count'));
	}
	/******* end make my service *******/
	
	public function shipping_price(){
		$size_group = SizeGroup::where('sizegroup','=','Photobook')->first();
		$size_group_id = $size_group['id'];
		$size = Size::where('sizegroup',$size_group_id)->get();
		$shipping_category = ShippingCategory::whereNull('deleted_at')->get();
		foreach($shipping_category as $m => $sc){
			foreach($size as $k => $val){
				$price[$val['id']] = ShippingPrice::whereNull('deleted_at')->where('shipping_category_id',$sc['id'])->where('size_id',$val['id'])->get();
			}
			$sc['price'] = $price;
		}
		$default_currency = Currency::where('isDefault',1)->first();
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		/** cart items **/
		$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
		$item_count = count($cartItems);
		/** end cart items **/
		return view('photobook.shipping_price',compact('shipping_category','size','help_group_pages','resource_group_pages','corporate_group_pages','default_currency','item_count'));
	}
	
	public function cover_pricing_detail(){
		$size_group = SizeGroup::where('sizegroup','=','Photobook')->first();
		$size_group_id = $size_group['id'];
		$size = Size::where('sizegroup',$size_group_id)->get();
		foreach($size as $k => $v){
			$size_id[] = $v['id'];
		}
		$cover_category = CoverCategory::whereNull('deleted_at')->where('isActive',1)->get();
		foreach($cover_category as $m => $coca){
			$cover_sub_category = Coversubcategory::whereNull('deleted_at')->where('isActive',1)->where('cover_category_id',$coca['id'])->orderBy('id','ASC')->get();
			$coca['sub_category'] = $cover_sub_category;
			foreach($cover_sub_category as $n => $cosuca){
				$cosuca['cover_price'] = Coverprice::whereNull('deleted_at')->where('isActive',1)->where('cover_sub_category_id',$cosuca['id'])->get();
			}  
		}
		$default_currency = Currency::where('isDefault',1)->first();
		$help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		/** cart items **/
		$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
		$item_count = count($cartItems);
		/** end cart items **/
		return view('photobook.cover_pricing_detail',compact('cover_category','size','help_group_pages','resource_group_pages','corporate_group_pages','default_currency','item_count'));
	}
	
	public function htmltopdfview($project_id=null,$pdf=null){
		/* include(public_path() . '\pdfcrowd.php');;
		try
		{   
			$client = new \Pdfcrowd("expertteam", "b8f66721913b14384aa77b15e1105cd2");
			$thisUR = DB::table('user_saved_projects')->whereRaw("user_id = '". Auth::user()->id ."' AND project_id = '".$project_id."'")->get();
			$cntR = count($thisUR);
			$savedProj = DB::table('user_saved_projects')->whereRaw("user_id = '". Auth::user()->id ."' AND project_id = '".$project_id."'")->skip(2)->take($cntR-4)->get();
			$html = '';
			foreach ($savedProj as $savedProj){
				$html .= $savedProj->page_content;
			}
			
			
			$pdf = $client->convertHtml($html);
			
			header("Content-Type: application/pdf");
			header("Cache-Control: max-age=0");
			header("Accept-Ranges: none");
			header("Content-Disposition: attachment; filename=\"$project_id.pdf\"");
			echo $pdf;
		}
		catch(PdfcrowdException $why)
		{
			echo "Pdfcrowd Error: " . $why;
		} */
		ini_set('max_execution_time', 300);
		$error_level = error_reporting();
		error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); 
		
		
		$thisUR = DB::table('user_saved_projects')->whereRaw("user_id = '". Auth::user()->id ."' AND project_id = '".$project_id."'")->get();
		$cntR = count($thisUR);
		$savedProj = DB::table('user_saved_projects')->whereRaw("user_id = '". Auth::user()->id ."' AND project_id = '".$project_id."'")->skip(2)->take($cntR-4)->get();
		
        $help_group_pages = $this->help_group_pages;
		$resource_group_pages = $this->resource_group_pages;
		$corporate_group_pages = $this->corporate_group_pages;
		
		$cartItems = DB::table('carts')->whereRaw("user_id='". Auth::user()->id ."' AND status = '0'")->get();
		$item_count = count($cartItems);
		$albums = DB::table("albums")->where("user_id",Auth::user()->id)->get();
		
		if($pdf=='pdf'){
			$pdf = PDF::loadView('photobook.htmltopdfview',compact('savedProj','help_group_pages','resource_group_pages','corporate_group_pages','item_count','project_id','albums'));
			$pdf->setPaper('a4', 'portrait');
			return $pdf->stream('htmltopdfview.pdf')->header('Content-Type','application/pdf'); 
		}	
		return view('photobook.htmltopdfview',compact('savedProj','help_group_pages','resource_group_pages','corporate_group_pages','item_count','project_id','albums')); 
	}
	
}