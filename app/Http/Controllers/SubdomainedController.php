<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB,Auth;
use Redirect;
use Validator;
use Session;

class SubdomainedController extends Controller {
	public function __construct(){
		$this->middleware('auth');
	}
	public function index(){
		$sid = $_GET['sid'];
		$sharesite_id = base64_decode($sid);
		if(isset($_GET['page']) && !empty($_GET['page'])){
			if($_GET['page']=='calendar'){
				$event_type = array(
					'General' => 'General',
					'Game' => 'Game',
					'Practice' => 'Practice',
					'Party' => 'Party',
					'Meeting' => 'Meeting',
					'Birthday' => 'Birthday',
					'Vocation' => 'Vocation',
					'Aniversary' => 'Aniversary',
					'Trip' => 'Trip',
					'Volunteer' => 'Volunteer',
					'Performance' => 'Performance',
					'Holiday' => 'Holiday'
				);
				$event_data = DB::table('sharesite_events')->where('sharesite_id',$sharesite_id)->get();
				$events = array();
				foreach($event_data as $k => $v){
					$events[$k]['title'] = $v->event_title;
					$events[$k]['start'] = $v->event_start_date .' '.$v->event_start_time;
					$events[$k]['end'] = $v->event_end_date .' '.$v->event_end_time;
				}
				$events = json_encode($events);
				return view('subdomain.calendar',compact('sharesite_id','event_type','events'));
			}else{
				$sharesite_photos = DB::table('sharesite_photos')
					->where('sharesite_id',$sharesite_id)
					->get();
				$sharesite_videos = DB::table('sharesite_videos')
					->where('sharesite_id',$sharesite_id)
					->get();
				return view('subdomain.pictures',compact('sharesite_id','sharesite_photos','sharesite_videos'));
			}
		}else{
			$image1 = DB::table('sharesite_images')
				->where('sharesite_id',$sharesite_id)
				->where('image_name1','!=','')
				//->where('user_id',Auth::user()->id)
				->orderBy('id','DESC')
				->limit(1)
				->first();
			$image2 = DB::table('sharesite_images')
				->where('sharesite_id',$sharesite_id)
				->where('image_name2','!=','')
				//->where('user_id',Auth::user()->id)
				->orderBy('id','DESC')
				->limit(1)
				->first();
			$image3 = DB::table('sharesite_images')
				->where('sharesite_id',$sharesite_id)
				->where('image_name3','!=','')
				//->where('user_id',Auth::user()->id)
				->orderBy('id','DESC')
				->limit(1)
				->first();
			$sharesite = DB::table('sharesites')->where('id',$sharesite_id)->first();
			
			return view('subdomain.index',compact('sharesite_id','image1','image2','image3','sharesite'));
		}
    }
	public function change_picture(Request $request){
		/* $rules = array(
			'change_picture' => 'required',
			'change_picture.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
		);
		$validator = Validator::make($request->all(), $rules);
		if($validator->fails()) {
			return Redirect::back()
				->withErrors($validator)
				->withInput();
		}else{ */
			$user_id = Auth::user()->id; 
			$image1 = $request->file('change_picture1');
			if(isset($image1) && !empty($image1)){
				$image = $image1;
			}
			$image2 = $request->file('change_picture2');
			if(isset($image2) && !empty($image2)){
				$image = $image2;
			}
			$image3 = $request->file('change_picture3');
			if(isset($image3) && !empty($image3)){
				$image = $image3;
			}
			
			$filename = "pc_".time().'.'.$image->getClientOriginalExtension();
			if(isset($image1) && !empty($image1)){
				$filename1 = $filename;
			}else{
				$filename1 = '';
			}
			if(isset($image2) && !empty($image2)){
				$filename2 = $filename;
			}else{
				$filename2 = '';
			}
			if(isset($image3) && !empty($image3)){
				$filename3 = $filename;
			}else{
				$filename3 = '';
			}
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$destinationPath = public_path('users_upload/sharesite').'/'.$request->get('sharesite_id');
			if(!file_exists($destinationPath)){
				mkdir($destinationPath, 0777);
			}
			$image->move($destinationPath, $filename);
			DB::table('sharesite_images')->insert(array(
				'sharesite_id' => $request->get('sharesite_id'),
				'user_id' => Auth::user()->id,
				'image_name1' => $filename1,
				'image_name2' => $filename2,
				'image_name3' => $filename3,
				'image_path' => 'users_upload/sharesite/'.$request->get('sharesite_id'),
				'extention' => $ext
			));
		//}
		return back()->with('success_msg','Image Uploaded successful');
	} 
	
	public function add_event(Request $request){
		$post_data = $request->all();
		$insArr = array(
			'user_id' => Auth::user()->id,
			'sharesite_id' => $post_data['sharesite_id'],
			'event_type' => $post_data['event_type'],
			'event_title' => $post_data['event_title'],
			'event_start_date' => $post_data['event_start_date'],
			'event_start_time' => $post_data['event_start_time'],
			'event_end_date' => $post_data['event_end_date'],
			'event_end_time' => $post_data['event_end_time'],
			'location_name' => $post_data['location_name'],
			'street_address' => $post_data['street_address'],
			'notes' => $post_data['notes']
		);
		DB::table('sharesite_events')->insert($insArr);
		return redirect('/?sid='.base64_encode($post_data['sharesite_id']).'&page=calendar')->with(['success_msg'=>'Event Added Successfully!!']);
	}
	
	public function upload_pictures(Request $request){
		$user_id = Auth::user()->id; 
		$images = $request->file('pictures');
		foreach($images as $k => $image){
			$filename = "pc_".$k.time().'.'.$image->getClientOriginalExtension();
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$destinationPath = public_path('users_upload/sharesite').'/'.$request->get('sharesite_id');
			if(!file_exists($destinationPath)){
				mkdir($destinationPath, 0777);
			}
			$image->move($destinationPath, $filename);
			DB::table('sharesite_photos')->insert(array(
				'sharesite_id' => $request->get('sharesite_id'),
				'user_id' => Auth::user()->id,
				'image_name' => $filename,
				'image_path' => 'users_upload/sharesite/'.$request->get('sharesite_id'),
				'extention' => $ext
			));
		}
		return back()->with('success_msg','Image Uploaded Successfully');
	}
	
	public function upload_videos(Request $request){
		$sharesite_id = $request->get('sharesite_id');
		$user_id = Auth::user()->id; 
		$video = $request->get('video');
		DB::table('sharesite_videos')->insert(array(
			'sharesite_id' => $sharesite_id,
			'user_id' => $user_id,
			'video' => $video
		));
		return back()->with('success_msg','Video Saved Successfully');
	}
}    
