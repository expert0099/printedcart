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

use App\Models\ShareSiteCategory;

class ShareSiteCategoriesController extends Controller
{
	public $show_action = true;
	public $view_col = 'title';
	public $listing_cols = ['id', 'title', 'photo', 'description', 'features'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('ShareSiteCategories', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('ShareSiteCategories', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the ShareSiteCategories.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('ShareSiteCategories');
		
		if(Module::hasAccess($module->id)) {
			return View('la.sharesitecategories.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new sharesitecategory.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created sharesitecategory in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("ShareSiteCategories", "create")) {
		
			$rules = Module::validateRules("ShareSiteCategories", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("ShareSiteCategories", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.sharesitecategories.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified sharesitecategory.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("ShareSiteCategories", "view")) {
			
			$sharesitecategory = ShareSiteCategory::find($id);
			if(isset($sharesitecategory->id)) {
				$module = Module::get('ShareSiteCategories');
				$module->row = $sharesitecategory;
				
				return view('la.sharesitecategories.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('sharesitecategory', $sharesitecategory);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("sharesitecategory"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified sharesitecategory.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("ShareSiteCategories", "edit")) {			
			$sharesitecategory = ShareSiteCategory::find($id);
			if(isset($sharesitecategory->id)) {	
				$module = Module::get('ShareSiteCategories');
				
				$module->row = $sharesitecategory;
				
				return view('la.sharesitecategories.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('sharesitecategory', $sharesitecategory);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("sharesitecategory"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified sharesitecategory in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("ShareSiteCategories", "edit")) {
			
			$rules = Module::validateRules("ShareSiteCategories", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("ShareSiteCategories", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.sharesitecategories.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified sharesitecategory from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("ShareSiteCategories", "delete")) {
			ShareSiteCategory::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.sharesitecategories.index');
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
		$values = DB::table('sharesitecategories')->select($this->listing_cols)->whereNull('deleted_at');
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

		$fields_popup = ModuleFields::getModuleFields('ShareSiteCategories');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/sharesitecategories/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("ShareSiteCategories", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/sharesitecategories/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("ShareSiteCategories", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.sharesitecategories.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
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
