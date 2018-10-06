<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Staticpage;use App\Feedback;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
	
	public function help_group_pages(){
		$help_group_pages = Staticpage::where('page_group','=','Help')->where('isActive',1)->get();
		return $help_group_pages;
	}
	public function resource_group_pages(){
		$resource_group_pages = Staticpage::where('page_group','=','Resources')->where('isActive',1)->get();
		return $resource_group_pages;
	}
	public function corporate_group_pages(){
		$corporate_group_pages = Staticpage::where('page_group','=','Corporate')->where('isActive',1)->get();
		return $corporate_group_pages;
	}	
	public function user_feedback(){		
		$user_feedback = Feedback::orderBy('id','DESC')->limit(5)->get();		
		return $user_feedback;	
	}
}
