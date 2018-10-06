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

use App\Models\CalendarLayout;

class CalendarLayoutsController extends Controller
{
	public $show_action = true;
	public $view_col = 'calendar_category_id';
	public $listing_cols = ['id', 'calendar_category_id', 'layout_name', 'layout_image', 'page_content', 'differiciate', 'isActive'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('CalendarLayouts', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('CalendarLayouts', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the CalendarLayouts.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('CalendarLayouts');
		
		if(Module::hasAccess($module->id)) {
			return View('la.calendarlayouts.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new calendarlayout.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created calendarlayout in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("CalendarLayouts", "create")) {
		
			$rules = Module::validateRules("CalendarLayouts", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("CalendarLayouts", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.calendarlayouts.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified calendarlayout.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("CalendarLayouts", "view")) {
			
			$calendarlayout = CalendarLayout::find($id);
			if(isset($calendarlayout->id)) {
				$module = Module::get('CalendarLayouts');
				$module->row = $calendarlayout;
				
				return view('la.calendarlayouts.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('calendarlayout', $calendarlayout);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("calendarlayout"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified calendarlayout.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("CalendarLayouts", "edit")) {			
			$calendarlayout = CalendarLayout::find($id);
			if(isset($calendarlayout->id)) {	
				$module = Module::get('CalendarLayouts');
				
				$module->row = $calendarlayout;
				
				return view('la.calendarlayouts.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('calendarlayout', $calendarlayout);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("calendarlayout"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified calendarlayout in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("CalendarLayouts", "edit")) {
			
			$rules = Module::validateRules("CalendarLayouts", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("CalendarLayouts", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.calendarlayouts.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified calendarlayout from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("CalendarLayouts", "delete")) {
			CalendarLayout::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.calendarlayouts.index');
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
		$values = DB::table('calendarlayouts')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();
		
		foreach($data->data as $k => $v){
			$img = '';
			if($v[3]!=0){
				$upload = DB::table('uploads')->select('path','hash','name')->where('id',$v[3])->first();
				$img = $img."<img src='". env('APP_URL') ."storage/uploads/". $upload->name ."' style='width:50px;'>";
				$data->data[$k][3] = $img;
			}else{
				$data->data[$k][3] = '';
			}
		}

		$fields_popup = ModuleFields::getModuleFields('CalendarLayouts');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/calendarlayouts/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("CalendarLayouts", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/calendarlayouts/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("CalendarLayouts", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.calendarlayouts.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
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
