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

use App\Models\PhotoBook;

class PhotoBooksController extends Controller
{
	public $show_action = true;
	public $view_col = 'photo_book';
	public $listing_cols = ['id', 'photo_book', 'photo_book_style_id', 'thumb_left', 'thumb_right', 'storytelling', 'standard', 'content', 'isActive'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('PhotoBooks', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('PhotoBooks', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the PhotoBooks.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		
		
		$module = Module::get('PhotoBooks');
		if(Module::hasAccess($module->id)) {
			return View('la.photobooks.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new photobook.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created photobook in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("PhotoBooks", "create")) {
		
			$rules = Module::validateRules("PhotoBooks", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("PhotoBooks", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.photobooks.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified photobook.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("PhotoBooks", "view")) {
			
			$photobook = PhotoBook::find($id);
			if(isset($photobook->id)) {
				$module = Module::get('PhotoBooks');
				$module->row = $photobook;
				
				return view('la.photobooks.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('photobook', $photobook);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("photobook"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified photobook.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("PhotoBooks", "edit")) {			
			$photobook = PhotoBook::find($id);
			if(isset($photobook->id)) {	
				$module = Module::get('PhotoBooks');
				
				$module->row = $photobook;
				
				return view('la.photobooks.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('photobook', $photobook);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("photobook"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified photobook in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("PhotoBooks", "edit")) {
			
			$rules = Module::validateRules("PhotoBooks", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("PhotoBooks", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.photobooks.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified photobook from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("PhotoBooks", "delete")) {
			PhotoBook::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.photobooks.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax()
	{
		$values = DB::table('photobooks')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();
		
		foreach($data->data as $k => $v){
			$img = $img2='';
			if($v[3]!=0){
				$upload = DB::table('uploads')->select('path','hash','name')->where('id',$v[3])->first();
				//$upDataArr = explode('-',$upload->path);
				//$img = $img."<img src='". env('APP_URL') ."files/". $upload->hash ."/". end($upDataArr) ."?s=50'>";
				$img = $img."<img src='". env('APP_URL') ."storage/uploads/". $upload->name ."' style='width:50px;'>";
				$data->data[$k][3] = $img;
			}else{
				$data->data[$k][3] = '';
			}
			if($v[4]!=0){
				$upload2 = DB::table('uploads')->select('path','hash','name')->where('id',$v[4])->first();
				//$upDataArr2 = explode('-',$upload2->path);
				//$img2 = $img2."<img src='". env('APP_URL') ."files/". $upload2->hash ."/". end($upDataArr2) ."?s=50'>";
				$img2 = $img2."<img src='". env('APP_URL') ."storage/uploads/". $upload2->name ."' style='width:50px;'>";
				$data->data[$k][4] = $img2;
			}else{
				$data->data[$k][4] = '';
			}
		}

		$fields_popup = ModuleFields::getModuleFields('PhotoBooks');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/photobooks/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("PhotoBooks", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/photobooks/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("PhotoBooks", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.photobooks.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}
}
