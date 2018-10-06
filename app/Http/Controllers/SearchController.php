<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class SearchController extends Controller{
	
	public function typeahead(Request $request){
        //$query = $request->get('term','');        
        $query = $request->get('query');        
        $projects = DB::table('projects')->where('project_name','LIKE','%'.$query.'%')->get();   
		return response()->json($projects);
	}
	
	public function search_submit(Request $request){
		$search_text = $request->get('search_text');
		//$projects = DB::table('projects')->where('project_name','LIKE','%'.$search_text.'%')->first();
		$projects = DB::table('projects')->whereRaw("project_name LIKE '%".$search_text."%'")->first();
		if(!empty($projects) && isset($projects)){
			if($projects->flag == 'Photobook'){
				return redirect('/photobooks');
			}elseif($projects->flag == 'Calendar'){
				return redirect('/calendars');
			}else{
				return redirect('/posters');
			}
		}else{
			return redirect()->back();
		}
	}
}
