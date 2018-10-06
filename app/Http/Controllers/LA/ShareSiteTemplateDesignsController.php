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

use App\Models\ShareSiteTemplateDesign;

class ShareSiteTemplateDesignsController extends Controller
{
	public $show_action = true;
	public $view_col = 'template_name';
	public $listing_cols = ['id', 'template_name', 'template_photo', 'isActive'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('ShareSiteTemplateDesigns', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('ShareSiteTemplateDesigns', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the ShareSiteTemplateDesigns.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('ShareSiteTemplateDesigns');
		
		if(Module::hasAccess($module->id)) {
			return View('la.sharesitetemplatedesigns.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new sharesitetemplatedesign.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created sharesitetemplatedesign in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("ShareSiteTemplateDesigns", "create")) {
		
			$rules = Module::validateRules("ShareSiteTemplateDesigns", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("ShareSiteTemplateDesigns", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.sharesitetemplatedesigns.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified sharesitetemplatedesign.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("ShareSiteTemplateDesigns", "view")) {
			
			$sharesitetemplatedesign = ShareSiteTemplateDesign::find($id);
			if(isset($sharesitetemplatedesign->id)) {
				$module = Module::get('ShareSiteTemplateDesigns');
				$module->row = $sharesitetemplatedesign;
				
				return view('la.sharesitetemplatedesigns.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('sharesitetemplatedesign', $sharesitetemplatedesign);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("sharesitetemplatedesign"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified sharesitetemplatedesign.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("ShareSiteTemplateDesigns", "edit")) {			
			$sharesitetemplatedesign = ShareSiteTemplateDesign::find($id);
			if(isset($sharesitetemplatedesign->id)) {	
				$module = Module::get('ShareSiteTemplateDesigns');
				
				$module->row = $sharesitetemplatedesign;
				
				return view('la.sharesitetemplatedesigns.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('sharesitetemplatedesign', $sharesitetemplatedesign);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("sharesitetemplatedesign"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified sharesitetemplatedesign in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("ShareSiteTemplateDesigns", "edit")) {
			
			$rules = Module::validateRules("ShareSiteTemplateDesigns", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("ShareSiteTemplateDesigns", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.sharesitetemplatedesigns.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified sharesitetemplatedesign from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("ShareSiteTemplateDesigns", "delete")) {
			ShareSiteTemplateDesign::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.sharesitetemplatedesigns.index');
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
		$values = DB::table('sharesitetemplatedesigns')->select($this->listing_cols)->whereNull('deleted_at');
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

		$fields_popup = ModuleFields::getModuleFields('ShareSiteTemplateDesigns');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/sharesitetemplatedesigns/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("ShareSiteTemplateDesigns", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/sharesitetemplatedesigns/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("ShareSiteTemplateDesigns", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.sharesitetemplatedesigns.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
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
