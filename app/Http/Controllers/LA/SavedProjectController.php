<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Validator;
use Datatables;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;
use PDF;

use App\Models\Project;

class SavedProjectController extends Controller
{
	/* public $show_action = true;
	public $view_col = 'project_name';
	public $listing_cols = ['id', 'project_name', 'user', 'created_at', 'isActive']; */
	
	public function __construct() {
		// Field Access of Listing Columns
	}
	
	/**
	 * Display a listing of the StaticPages.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$order = DB::table('orders')->where('status','=','Success')->get();
		foreach($order as $k => $val){
			if(is_numeric($val->project_id)){
				$soiusp = DB::table('user_saved_projects')
					->select('projects.project_name','projects.price','user_saved_projects.project_id as project_id','user_saved_projects.created_at','users.name as user_name')
					->join('projects','user_saved_projects.project_id','=','projects.id')
					->join('users','user_saved_projects.user_id','=','users.id')
					->where('user_saved_projects.project_id','=',$val->project_id)->where('user_saved_projects.deleted_at','=','0000-00-00 00:00:00')
					->distinct()->get(['project_id']);
				$val->user_saved_projects = $soiusp;
			}else{
				$e = explode(',',$val->project_id);
				$doiusp = DB::table('user_saved_projects')
					->select('projects.project_name','projects.price','user_saved_projects.project_id as project_id','user_saved_projects.created_at','users.name as user_name')
					->join('projects','user_saved_projects.project_id','=','projects.id')
					->join('users','user_saved_projects.user_id','=','users.id')
					->whereIn('user_saved_projects.project_id',$e)->where('user_saved_projects.deleted_at','=','0000-00-00 00:00:00')
					->distinct()->get(['project_id']);
				$val->user_saved_projects = $doiusp;
			}
		}
		return view('la.savedproject.index',compact('order')); 
	}

	/**
	 * Show the form for creating a new staticpage.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created staticpage in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		
	}

	/**
	 * Display the specified staticpage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($project_id=null,$order_id=null){
		$project = Project::with('Size')->where('id',$project_id)->first();
		$calendar_size = $project['Size']['Size'];
		$calendar_category_id = $project['calendar_category_id'];
		
		if($project->flag == 'Photobook'){
			$identifierClass = str_replace(' ','',$project['flag']).'_'.$calendar_size;
		}else{
			$identifierClass = str_replace(' ','',$project['flag']).'_'.$calendar_size;
		}
		//$identifierClass = str_replace(' ','',$project['flag']);
		if($project['flag']=='Photobook'){
			$thisUR = DB::table('user_saved_projects')->whereRaw("project_id = '".$project_id."'")->get();
			$cntR = count($thisUR);
			$savedProj = DB::table('user_saved_projects')->whereRaw("project_id = '".$project_id."'")->skip(2)->take($cntR-4)->get();
		}else{
			$savedProj = DB::table('user_saved_projects')->whereRaw("project_id = '".$project_id."'")->get();
		}
		/* $thisUR = DB::table('user_saved_projects')->whereRaw("project_id = '".$project_id."'")->get();
		$cntR = count($thisUR);
		$savedProj = DB::table('user_saved_projects')->whereRaw("project_id = '".$project_id."'")->skip(2)->take($cntR-4)->get(); */
		
		return view('la.savedproject.show', compact('savedProj','','project_id','calendar_size','calendar_category_id','order_id','identifierClass','project'));
	}
	
	public function order_detail($project_id=null,$order_id=null){
		$order = DB::table('orders')->where('id',$order_id)->first();
		$user = DB::table('users')->where('id',$order->user_id)->first();
		$userinfo = DB::table('user_address_infos')->whereRaw("user_id = '". $order->user_id ."' AND id = '". $order->address_id ."'")->first();
		return view('la.savedproject.order_detail', compact('order','user','userinfo'));
	}

	/**
	 * Show the form for editing the specified staticpage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		
	}

	/**
	 * Update the specified staticpage in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		
	}

	/**
	 * Remove the specified staticpage from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id=null)
	{
		$upArr = array('deleted_at'=>date('Y-m-d H:i:s'));
		DB::table('user_saved_projects')->where('project_id',$id)->update($upArr);
		DB::table('projects')->where('id',$id)->update($upArr);
		return redirect(config('laraadmin.adminRoute')."/saved_project");
	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax(Request $request){
		$post_data = $request->all(); 
		/* echo '<pre>';
		print_r($post_data);exit; */
		$page_id = $post_data['page_id'];
		$filename = $page_id.'.jpeg';
		$project_id = $post_data['project_id'];
		$order_id = $post_data['order_id'];
		
		$pd = DB::table('projects')->where('id',$project_id)->first();
		$user_id = $pd->user_id;
		//$ext = pathinfo($filename, PATHINFO_EXTENSION);exit;
		//$destinationPath = public_path('/uploads/user_images');
		$destinationPath = public_path('canvas_upload').'/'.$user_id;
		
		$exist = DB::table('ordered_pdf_images')->whereRaw("user_id='".$user_id."' AND project_id='".$project_id."' AND page_id='".$page_id."'")->get();
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
		//$error_level = error_reporting();
		//error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
		
		
		ini_set('display_errors',1); // enable php error display for easy trouble shooting
		error_reporting(E_ALL); // set error display to all
		
		$order_pdf = DB::table('ordered_pdf_images')->whereRaw("project_id = '".$project_id."' AND order_id = '".$order_id."'")->orderBy('page_id','ASC')->get();
		
		//$pd = DB::table('projects')->where('id',$project_id)->first();
		$pd = Project::with('Size')->where('id',$project_id)->first();
		$user_id = $pd->user_id;
		$size = $pd->Size['Size'];
		$ex = explode('x',$size);
		if($ex[0]>$ex[1]){
			$ratio = $ex[1]/$ex[0]*100;
			$page_width = 100;
			$page_height = round($ratio);
		}else{
			$ratio = $ex[0]/$ex[1]*100;
			$page_width = round($ratio);
			$page_height = 100;
		}
		/* $pw = ($page_width/100)*$page_default_width;
		$ph = ($page_height/100)*$page_default_height; */
		/* page content */
		
		if($pd->flag=='Photobook'){
			$thisUR = DB::table('user_saved_projects')->whereRaw("project_id = '".$project_id."'")->get();
			$cntR = count($thisUR);
			$savedProj = DB::table('user_saved_projects')->whereRaw("project_id = '".$project_id."'")->skip(2)->take($cntR-4)->get();
			$identifierClass = str_replace(' ','',$pd->flag).'_'.$size;
		}else{
			$savedProj = DB::table('user_saved_projects')->whereRaw("project_id = '".$project_id."'")->get();
			$identifierClass = str_replace(' ','',$pd->flag).'_'.$size;
		} 
		/* end page content */
		$html = view('la.savedproject.download_pdf', compact('order_pdf','user_id','savedProj','pd','identifierClass'));
		//$html = view('la.savedproject.pdf');
		
		/* $html = "";
		foreach($savedProj as $k => $val){
			$html .= $val->page_content;
		}  
		echo $html;exit; */   
		//['utf-8', array(290,236)] //width & height
		
		if($pd->flag=='Photobook'){
			if($size == '11x14'){
				$page_default_width = 589;
				$page_default_height = 390.8;
				$html = str_replace('width: 79%;','width: 100%;',$html);
			}elseif($size == '12x12'){
				$page_default_width = 639.8;
				$page_default_height = 340;
			}elseif($size == '10x10'){
				$page_default_width = 538;
				$page_default_height = 288.7;
			}elseif($size == '11x8'){
				$page_default_width = 589;
				$page_default_height = 238.3;
			}elseif($size == '8x11'){
				$page_default_width = 436.3;
				$page_default_height = 314.5;
				$html = str_replace('width: 73%;','width: 100%;',$html);
			}elseif($size == '8x8'){
				$page_default_width = 436.3;
				$page_default_height = 238.4;
			}else{
				$page_default_width = 385.7;
				$page_default_height = 263.8;
				$html = str_replace('width: 78%;','width: 100%;',$html);
			}
		}elseif($pd->flag=='Calendar'){
			if($size == '12x12'){
				$page_default_width = 335;
				$page_default_height = 335;
				//$html = str_replace('Text Here','',$html);
				$html = str_replace('style="display: block;"','style="display: none;"',$html);
				$html = str_replace('style="height: 40vh;"','style="height: 40%;"',$html);
			}elseif($size == '8x11'){
				$page_default_width = 233;
				$page_default_height = 310.5;
				$html = str_replace('display: block;','display: none',$html);
				$html = str_replace('width: 73%;','width: 100%;',$html);
				$html = str_replace('style="height: 40vh;"','style="height: 40%;"',$html);
			}else{
				$page_default_width = 309.4;
				$page_default_height = 157;
				$html = str_replace('display: block;','display: none',$html);
			}
		}else{
			if($size == '20x30'){
				$page_default_width = 538;
				$page_default_height = 794.8;
				$html = str_replace('width: 67%;','width: 100%;',$html);
				$html = str_replace('width:25%;float:left;','width:24.89%;float:left;',$html);
				$html = str_replace('style="height: 40vh;"','style="height: 40%;"',$html);
			}elseif($size == '8x8'){
				$page_default_width = 233;
				$page_default_height = 234.3;
				$html = str_replace('width:25%;float:left;','width:24.67%;float:left;',$html);
				$html = str_replace('style="height: 40vh;"','style="height: 40%;"',$html);
			}elseif($size == '8x10'){
				$page_default_width = 233;
				$page_default_height = 285;
				$html = str_replace('width: 80%;','width: 100%;',$html);
				$html = str_replace('width:25%;float:left;','width:24.68%;float:left;',$html);
				$html = str_replace('style="height: 40vh;"','style="height: 40%;"',$html);
			}elseif($size == '11x14'){
				$page_default_width = 309.2;
				$page_default_height = 386.3;
				$html = str_replace('width: 79%;','width: 100%;',$html);
				$html = str_replace('width:25%;float:left;','width:24.78%;float:left;',$html);
				$html = str_replace('style="height: 40vh;"','style="height: 40%;"',$html);
			}elseif($size == '12x12'){
				$page_default_width = 334.7;
				$page_default_height = 334.7;
				$html = str_replace('width:25%;float:left;','width:24.82%;float:left;',$html);
				$html = str_replace('style="height: 40vh;"','style="height: 40%;"',$html);
			}elseif($size == '16x20'){
				$page_default_width = 436.3;
				$page_default_height = 538.3;
				$html = str_replace('width: 80%;','width: 100%;',$html);
				$html = str_replace('width:25%;float:left;','width:24.86%;float:left;',$html);
				$html = str_replace('style="height: 40vh;"','style="height: 40%;"',$html);
			}
		}
		
		$mpdf = new \Mpdf\Mpdf(['format' => [$page_default_width, $page_default_height]]);
		//$mpdf->useDefaultCSS2 = true;
		//$mpdf->use_kwt = true;
		//$mpdf->useSubstitutions = true;
		//$mpdf->ignore_invalid_utf8 = true;
		//$mpdf->SetDisplayMode('fullpage');
		
		//$mpdf->SetDisplayMode('default');
		
		//$mpdf->SetDisplayMode('fullpage','two');
		/* $stylesheet = file_get_contents('public/css/photobook_custom_editor.css');
		$mpdf->WriteHTML($stylesheet,1);
		$stylesheet2 = file_get_contents('public/css/display_pdf.css');
		$mpdf->WriteHTML($stylesheet2,1); */
		
		/* if($pd->flag == 'Photobook'){
			$mpdf->AddPageByArray([
                //'orientation' => 'L',
               // 'sheet-size'=>'A4',
				//'format' => [230, 160]
            ]);
		}else{
			$mpdf->AddPageByArray([
                //'orientation' => 'P',
                //'sheet-size'=>'A4',
				//'format' => [460, 330]
            ]);
		} */
		
		
		$mpdf->WriteHTML($html);
		//$mpdf->WriteHTML($html);
		
		$mpdf->Output();
		//unset($mpdf);
		exit;

		/* $pdf = \App::make('dompdf.wrapper');		
		$pdf = PDF::loadView('la.savedproject.download_pdf' ,compact('order_pdf','user_id','savedProj'));
		//$pdf->setPaper('a4', 'portrait');
		if($pd->flag == 'Photobook'){
			$pdf->setPaper(array(0,0,450,250), 'portrait');
		}else{
			$pdf->setPaper(array(0,0,450,400), 'portrait');
		}
		return $pdf->stream('pdf_'.$project_id.'_'.$order_id.'.pdf')->header('Content-Type','application/pdf');  */
	}
}
