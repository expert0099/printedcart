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

use App\Models\PhotoBookLayout;

class PhotoBookLayoutsController extends Controller
{
	public $show_action = true;
	public $view_col = 'photo_book_id';
	public $listing_cols = ['id', 'photo_book_id', 'layout_image', 'content_page', 'isActive'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('PhotoBookLayouts', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('PhotoBookLayouts', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the PhotoBookLayouts.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('PhotoBookLayouts');
		
		if(Module::hasAccess($module->id)) {
			return View('la.photobooklayouts.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new photobooklayout.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created photobooklayout in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("PhotoBookLayouts", "create")) {
		
			$rules = Module::validateRules("PhotoBookLayouts", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("PhotoBookLayouts", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.photobooklayouts.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified photobooklayout.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("PhotoBookLayouts", "view")) {
			
			$photobooklayout = PhotoBookLayout::find($id);
			if(isset($photobooklayout->id)) {
				$module = Module::get('PhotoBookLayouts');
				$module->row = $photobooklayout;
				
				return view('la.photobooklayouts.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('photobooklayout', $photobooklayout);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("photobooklayout"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified photobooklayout.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("PhotoBookLayouts", "edit")) {			
			$photobooklayout = PhotoBookLayout::find($id);
			if(isset($photobooklayout->id)) {	
				$module = Module::get('PhotoBookLayouts');
				
				$module->row = $photobooklayout;
				
				return view('la.photobooklayouts.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('photobooklayout', $photobooklayout);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("photobooklayout"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified photobooklayout in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("PhotoBookLayouts", "edit")) {
			
			$rules = Module::validateRules("PhotoBookLayouts", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("PhotoBookLayouts", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.photobooklayouts.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified photobooklayout from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("PhotoBookLayouts", "delete")) {
			PhotoBookLayout::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.photobooklayouts.index');
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
		$values = DB::table('photobooklayouts')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();
		
		foreach($data->data as $k => $v){
			$img = '';
			if($v[2]!=0){
				$upload = DB::table('uploads')->select('path','hash','name')->where('id',$v[2])->first();
				$img = $img."<img src='". env('APP_URL') ."storage/uploads/". $upload->name ."' style='width:50px;'>";
				$data->data[$k][2] = $img;
			}else{
				$data->data[$k][2] = '';
			}
		}

		$fields_popup = ModuleFields::getModuleFields('PhotoBookLayouts');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/photobooklayouts/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("PhotoBookLayouts", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/photobooklayouts/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("PhotoBookLayouts", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.photobooklayouts.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
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
