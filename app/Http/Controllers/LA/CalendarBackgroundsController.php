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

use App\Models\CalendarBackground;

class CalendarBackgroundsController extends Controller
{
	public $show_action = true;
	public $view_col = 'background_image';
	public $listing_cols = ['id', 'calendar_category_id', 'calendar_style_id', 'background_image', 'isActive'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('CalendarBackgrounds', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('CalendarBackgrounds', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the CalendarBackgrounds.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('CalendarBackgrounds');
		
		if(Module::hasAccess($module->id)) {
			return View('la.calendarbackgrounds.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new calendarbackground.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created calendarbackground in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("CalendarBackgrounds", "create")) {
		
			$rules = Module::validateRules("CalendarBackgrounds", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("CalendarBackgrounds", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.calendarbackgrounds.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified calendarbackground.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("CalendarBackgrounds", "view")) {
			
			$calendarbackground = CalendarBackground::find($id);
			if(isset($calendarbackground->id)) {
				$module = Module::get('CalendarBackgrounds');
				$module->row = $calendarbackground;
				
				return view('la.calendarbackgrounds.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('calendarbackground', $calendarbackground);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("calendarbackground"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified calendarbackground.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("CalendarBackgrounds", "edit")) {			
			$calendarbackground = CalendarBackground::find($id);
			if(isset($calendarbackground->id)) {	
				$module = Module::get('CalendarBackgrounds');
				
				$module->row = $calendarbackground;
				
				return view('la.calendarbackgrounds.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('calendarbackground', $calendarbackground);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("calendarbackground"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified calendarbackground in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("CalendarBackgrounds", "edit")) {
			
			$rules = Module::validateRules("CalendarBackgrounds", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("CalendarBackgrounds", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.calendarbackgrounds.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified calendarbackground from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("CalendarBackgrounds", "delete")) {
			CalendarBackground::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.calendarbackgrounds.index');
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
		$values = DB::table('calendarbackgrounds')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();
		
		foreach($data->data as $k => $v){
			$img = '';
			foreach(json_decode($v[3]) as $j => $vv){
				$upload = DB::table('uploads')->select('path','hash','name')->where('id',$vv)->first();
				$img = $img."<img src='". env('APP_URL') ."storage/uploads/". $upload->name ."' style='width:50px;'>";
			}
			$data->data[$k][3] = $img;
		}

		$fields_popup = ModuleFields::getModuleFields('CalendarBackgrounds');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/calendarbackgrounds/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("CalendarBackgrounds", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/calendarbackgrounds/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("CalendarBackgrounds", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.calendarbackgrounds.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
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
